<?php

namespace Ayeps\OpencartMaker\Command;


use Ayeps\OpencartMaker\FileManager;
use Ayeps\OpencartMaker\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractMaker extends Command
{
	/**
	 * @var bool
	 */
	private $isCatalog;
	/**
	 * @var bool
	 */
	private $isModel;

	const TEMPLATE_ROOT = __DIR__ . '/../Resource/template';
	/**
	 * @var string
	 */
	private $controller_template;
	/**
	 * @var string
	 */
	private $language_template;
	/**
	 * @var string
	 */
	private $model_template;
	/**
	 * @var string
	 */
	private $catalog_controller_template;

	public function __construct(?string $name = null)
	{
		parent::__construct($name);
		$this->isCatalog = true;
		$this->isModel = false;
		$this->controller_template = self::TEMPLATE_ROOT . '/controller.tpl.php';
		$this->language_template = self::TEMPLATE_ROOT . '/language.tpl.php';
		$this->model_template = self::TEMPLATE_ROOT . '/model.tpl.php';

		$this->catalog_controller_template = self::TEMPLATE_ROOT . '/controller.tpl.php';
	}

	protected function configure()
	{
		$this
			->setName($this->getCommandName())
			->setDescription($this->getCommandDescription())
			->addArgument('name', InputArgument::REQUIRED, 'Name')
			->addOption('with-model', null, InputOption::VALUE_OPTIONAL, 'Enables model output', true)
			->addOption('no-catalog', null, InputOption::VALUE_OPTIONAL, 'Disable catalog output', true)
		;
	}

	abstract public function getCommandName();

	abstract public function getCommandDescription();

	public function setControllerTemplatePath($path): void
	{
		$this->controller_template = $path;
	}

	public function setCatalogControllerTemplatePath($path): void
	{
		$this->catalog_controller_template = $path;
	}

	public function setLanguageTemplatePath($path): void
	{
		$this->language_template = $path;
	}

	public function setModelTemplatePath($path): void
	{
		$this->model_template = $path;
	}

	public function setIsCatalog($val): void
	{
		$this->isCatalog = $val;
	}

	public function setIsModel($val): void
	{
		$this->isModel = $val;
	}
	/**
	 * Dump Module Controller
	 *
	 * @param FileManager $fm
	 * @param string $path
	 */
	public function dumpController(FileManager $fm, string $path)
	{
		$data = [
			'module_name' => Str::getName($path),
			'class_name' => Str::getClassName($path),
			'path' => $path
		];
		$fm->dumpFile(ADMIN_DIR . '/controller/' . $path . '.php', $fm->parseTemplate(
			$this->controller_template,
			$data
		));

		if (!$this->isCatalog) {
			return;
		}

		$fm->dumpFile(CATALOG_DIR . '/controller/' . $path . '.php', $fm->parseTemplate(
			$this->catalog_controller_template,
			$data
		));
	}

	/**
	 * Dump Module View files
	 *
	 * @param FileManager $fm
	 * @param string $path
	 */
	public function dumpView(FileManager $fm, string $path)
	{
		$data = [
			'module_name' => Str::getName($path),
		];
		$template = self::TEMPLATE_ROOT . '/admin-view.tpl.php';
		$fm->dumpFile(ADMIN_DIR . '/view/template/' . $path . '.twig', $fm->parseTemplate(
			$template,
			$data
		));

		if (!$this->isCatalog) {
			return;
		}

		foreach (FileManager::getDirectories(THEME_DIR) as $theme) {
			$fm->dumpFile(sprintf(THEME_TEMPLATE_PATTERN, $theme) . '/' . $path . '.twig', $path . ' view');
		}
	}

	/**
	 * Dump Module Model files if flag --with-model is active
	 *
	 * @param FileManager $fm
	 * @param string $path
	 */
	public function dumpModel(FileManager $fm, string $path)
	{
		if (!$this->isModel) {
			return;
		}
		$template = $this->model_template;

		$data = [
			'module_name' => Str::getName($path),
			'class_name' => Str::getClassName($path)
		];
		$fm->dumpFile(ADMIN_DIR . '/model/' . $path . '.php', $fm->parseTemplate(
			$template,
			$data
		));

		if (!$this->isCatalog) {
			return;
		}

		$fm->dumpFile(CATALOG_DIR . '/model/' . $path . '.php', $fm->parseTemplate(
			$template,
			$data
		));
	}

	/**
	 * Dump Language Module File for each language
	 *
	 * @param FileManager $fm
	 * @param string $path
	 */
	public function dumpLang(FileManager $fm, string $path): void
	{
		$module_name = Str::getName($path);
		$data = [
			'name' => $module_name,
		];

		foreach (FileManager::getDirectories(ADMIN_LANG_DIR) as $lang) {
			$fm->dumpFile(sprintf(ADMIN_LANG_PATTERN, $lang). '/' . $path . '.php', $fm->parseTemplate(
				$this->language_template,
				$data
			));
		}

		if (!$this->isCatalog) {
			return;
		}

		foreach (FileManager::getDirectories(CATALOG_LANG_DIR) as $lang) {
			$fm->dumpFile(sprintf(CATALOG_LANG_PATTERN, $lang). '/' . $path . '.php', $fm->parseTemplate(
				$this->language_template,
				$data
			));
		}
	}
}
