<?php
if (!defined('URL')) {
	define('URL', 'http://192.168.1.107/himalayan/');
}

if (!defined('ADMIN_URL')) {
	define('ADMIN_URL', URL.'admin/');
}

if (!defined('DOC_ROOT')) {
	if($_SERVER['SERVER_NAME'] == '192.168.1.107' or $_SERVER['SERVER_NAME'] == '192.168.0.107')
	define('DOC_ROOT', str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']));
	else
	{
		define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);	
	}
}

if (!defined('ASSET_FOLDER')) {
	if($_SERVER['SERVER_NAME'] == '192.168.1.107' or $_SERVER['SERVER_NAME'] == '192.168.0.107')
	define('ASSET_FOLDER', str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']).'\\himalayan\\assets\\');
	else
	{
		define('ASSET_FOLDER', $_SERVER['DOCUMENT_ROOT'].'/assets/');	
	}
}

if (!defined('UPLOADS_FOLDER')) {
	if($_SERVER['SERVER_NAME'] == '192.168.1.107' or $_SERVER['SERVER_NAME'] == '192.168.0.107')
	define('UPLOADS_FOLDER', str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']).'\\himalayan\\assets\\uploads\\');
	else
	{
		define('UPLOADS_FOLDER', $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/');	
	}
}


if (!defined('DEFAULT_CONTROLLER')) {
	define('DEFAULT_CONTROLLER', 'home');
}

if (!defined('DEFAULT_ACTION')) {
	define('DEFAULT_ACTION', 'home');
}

if (!defined('DEFAULT_ADMIN_CONTROLLER')) {
	define('DEFAULT_ADMIN_CONTROLLER', 'dashboard');
}

if (!defined('DEFAULT_ADMIN_ACTION')) {
	define('DEFAULT_ADMIN_ACTION', 'index');
}

if (!defined('LOGO')) {
	define('LOGO', 'images/logo.png');
}

if (!defined('ASSET_URL')) {
	define('ASSET_URL', URL.'assets/');
}

if (!defined('UPLOAD_URL')) {
	define('UPLOAD_URL', URL.'assets/uploads/');
}

if (!defined('CAPTCHA_PUBLIC_KEY')) {
	define('CAPTCHA_PUBLIC_KEY', '6Lcb-_cSAAAAAJDbx1f7OgP6Eigh39fuxBIKoGJ8');
}

if (!defined('CAPTCHA_PRIVATE_KEY')) {
	define('CAPTCHA_PRIVATE_KEY', '6Lcb-_cSAAAAAGTU-Fgeosq9j9rcbK2G1qbsjrmD');
}


?>