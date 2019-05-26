<?php
// vendor/ayeps/opencart-maker
require (dirname(__DIR__) . '/../../../../config.php');
if(!defined('DIR_APPLICATION'))
{
	exit('DIR_APPLICATION is not defined');
}

define('ROOT_DIR', dirname(DIR_APPLICATION));
define('ADMIN_DIR', ROOT_DIR . '/admin');
define('CATALOG_DIR', ROOT_DIR . '/catalog');
define('MODULE_CONTROLLER', '/controller/extension/module');
define('MODULE_LANG', '/language/%s/extension/module');
define('MODULE_MODEL', '/model/extension/module');
define('MODULE_VIEW', '/template/extension/module');
define('ADMIN_LANG_DIR', ADMIN_DIR . '/language');
define('ADMIN_LANG_PATTERN', ADMIN_LANG_DIR . '/%s');
define('CATALOG_LANG_DIR', CATALOG_DIR . '/language');
define('CATALOG_LANG_PATTERN', CATALOG_LANG_DIR . '/%s');
define('THEME_DIR', CATALOG_DIR . '/view/theme');
define('THEME_TEMPLATE_PATTERN', THEME_DIR . '/%s/template');

define('ADMIN_MODULE_CONTROLLER_DIR', ADMIN_DIR . MODULE_CONTROLLER);
define('ADMIN_MODULE_LANG_DIR', ADMIN_DIR . MODULE_LANG);
define('ADMIN_MODULE_MODEL_DIR', ADMIN_DIR . MODULE_MODEL);
define('ADMIN_MODULE_VIEW_DIR', ADMIN_DIR . '/view' . MODULE_VIEW);

define('CATALOG_MODULE_CONTROLLER_DIR', CATALOG_DIR . MODULE_CONTROLLER);
define('CATALOG_MODULE_LANG_DIR', CATALOG_DIR . MODULE_LANG);
define('CATALOG_MODULE_MODEL_DIR', CATALOG_DIR . MODULE_MODEL);
define('CATALOG_MODULE_VIEW_DIR', THEME_DIR . '/%s' . MODULE_VIEW);
