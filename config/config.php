<?php 
ob_start();
session_start();
date_default_timezone_set('Asia/Kathmandu');
if ($_SERVER['SERVER_ADDR']=='127.0.0.1' || $_SERVER['SERVER_ADDR']=="::1") {
	define('ENVIRONMENT', 'DEVELOPMENT');
}else{
	define('ENVIRONMENT', 'PRODUCTION');
}
if (ENVIRONMENT == 'DEVELOPMENT') {
	error_reporting(E_ALL);
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'account');
	define('DB_USER', 'root');
	define('DB_PWD', '');
	define('SITE_URL', 'http://www.account.com/');
}else{
	error_reporting(0);
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'account');
	define('DB_USER', 'root');
	define('DB_PWD', '');
	define('SITE_URL', 'www.account.com');
}
define('CMS_PATH', SITE_URL.'cms/');
define('ASSESTS_PATH', CMS_PATH.'assets/');
define('INCLUDE_PATH', CMS_PATH.'inc/');

define('CSS_PATH', ASSESTS_PATH.'css/');
define('IMAGES_PATH', ASSESTS_PATH.'images/');
define('JS_PATH', ASSESTS_PATH.'js/');

define('ERROR_PATH', $_SERVER['DOCUMENT_ROOT'].'error/');
define('CLASS_PATH', $_SERVER['DOCUMENT_ROOT'].'class/');
define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'].'config/');
define('SITE_NAME', 'account.com');
