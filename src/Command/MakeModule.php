<?php
namespace Ayeps\OpencartMaker\Command;

use Ayeps\OpencartMaker\FileManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeModule extends AbstractMaker
{
    public function __construct(?string $name = null)
    {
        parent::__construct($name);
        $this->setControllerTemplatePath(self::TEMPLATE_ROOT . '/module/controller.tpl.php');
        $this->setCatalogControllerTemplatePath(self::TEMPLATE_ROOT . '/module/catalog-controller.tpl.php');
    }

    public function getCommandName()
    {
        return 'ocmake:module';
    }

    public function getCommandDescription()
    {
        return 'Add opencart module files';
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('no-catalog') !== true) {
            $this->setIsCatalog(false);
        }
        if ($input->getOption('with-model') !== true) {
            $this->setIsModel(true);
        }
        $module = str_replace('.php', '', strtolower(trim($input->getArgument('name'))));

        $module_name = str_replace(['-', ' ', '.', ':'], '_', $module);

        $path = 'extension/module/'.$module_name;

        $fm = new FileManager($input, $output);

        $this->dumpController($fm, $path);
        $this->dumpLang($fm, $path);
        $this->dumpModel($fm, $path);
        $this->dumpView($fm, $path);
    }
}
