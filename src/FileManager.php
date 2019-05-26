<?php
/**
 * This file is part of AYEP'S Theme
 * @author Ayep's TM
 * @copyright 2019 AYEP'S
 * Author URI: https://ayeps.ru
 *
 */

namespace Ayeps\OpencartMaker;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Style\SymfonyStyle;

class FileManager
{
    /**
     * @var Filesystem
     */
    private $fs;
    /** @var SymfonyStyle */
    private $io;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->fs = new Filesystem();
        $this->io = new SymfonyStyle($input, $output);
    }

    public function parseTemplate(string $template, array $parameters): string
    {
        ob_start();
        extract($parameters, EXTR_SKIP);
        include $template;
        return ob_get_clean();
    }

    public function dumpFile(string $path, string $content)
    {
        if ($this->fs->exists($path)) {
            $this->io->comment(sprintf("File %s already exist", $path));
        } else {
            $this->fs->dumpFile($path, $content);
            $this->io->success(sprintf("File %s created", $path));
        }
    }

	/**
	 * Returns array of directories exclude '.' and '..'
	 *
	 * @param string $path
	 *
	 * @return array
	 */
	public static function getDirectories(string $path): array
	{
		if(!file_exists($path))
		{
			return [];
		}
		return array_diff(scandir($path), ['.', '..']);
	}
}
