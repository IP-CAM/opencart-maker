<?php

namespace Ayeps\OpencartMaker;


class Str
{
	/**
	 * Get Name without namespace and ext
	 *
	 * @param $str
	 *
	 * @return mixed|string
	 */
	public static function getName($str): string
	{
		$str = trim($str);
		$str = str_replace('.php', '', $str);
		$str = str_replace(['\\', ':', '.'], '/', $str);
		$str = str_replace(['-'], '_', $str);
		$array = explode('/', $str);
		$str = end($array);
		return $str;
	}

	/**
	 * Get Classname in camelcase format
	 *
	 * Examples:
	 *      // ExampleModule
	 *      $this->getClassName('example_module')
	 *      $this->getClassName('example-module')
	 *      $this->getClassName('example module')
	 *
	 *      // ExtensionModuleExampleModule
	 *      $this->getClassName('extension/module/example_module')
	 *      $this->getClassName('extension\module\example-module')
	 *      $this->getClassName('extension:module:example module')
	 * @param $str
	 *
	 * @return string
	 */
	public static function getClassName($str): string
	{
		$str = trim($str);
		$str = str_replace('.php', '', $str);
		$str = str_replace(['\\', ':', '.', '/', '_', '-'], ' ', $str);
		$str = ucwords($str);
		$str = str_replace(' ', '', $str);
		$str = ucfirst($str);
		return $str;
	}
}
