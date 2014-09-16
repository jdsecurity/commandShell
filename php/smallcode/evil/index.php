<?php
error_reporting(E_ALL);
header("content-Type: text/html; charset=gb2312");
set_time_limit(0);

$rootPath = rtrim(dirname(__FILE__), '/') . '/';
define('ROOT_PATH', $rootPath);
$rootApi = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
$rootApi .= '://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
define('ROOT_API', $rootApi);
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());

$_GET		= daddslashes($_GET, 1, TRUE);
$_POST		= daddslashes($_POST, 1, TRUE);
$_COOKIE	= daddslashes($_COOKIE, 1, TRUE);
$_SERVER	= daddslashes($_SERVER);
$_FILES		= daddslashes($_FILES);
$_REQUEST	= daddslashes($_REQUEST, 1, TRUE);

$c = getgpc('c');
$m = getgpc('m');
$c = empty($c) ? 'index' : $c;
$m = empty($m) ? 'index' : $m;

$controllers = array(
	'index', 'file', 'guama', 'qingma', 'tihuan', 'antivirus', 'info',
	'exec', 'com', 'port', 'shellcode', 'linux', 'servu',
	'mysql', 'mysql2', 'mysql3', 'fileEdit', 'fileSoup', 'mysqlMsg'
);

if (!in_array($c, $controllers)) {
	exit('Controller error!');
} else  {
	require_once './controller/base.php';
	require_once './controller/' . $c . '.php';
	$controller = new $c();

	$method = 'on' . $m;
	//echo $method;
	if (method_exists($controller, $method)) {
		$controller->$method();
	} else {
		exit('Action not found!');
	}
}

$mtime = explode(' ', microtime());
$endtime = $mtime[1] + $mtime[0];

function daddslashes($string, $force = 0, $strip = FALSE)
{
	if (!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function getgpc($k, $t='R') {
	switch($t) {
		case 'P': $var = &$_POST; break;
		case 'G': $var = &$_GET; break;
		case 'C': $var = &$_COOKIE; break;
		case 'R': $var = &$_REQUEST; break;
	}
	return isset($var[$k]) ? (is_array($var[$k]) ? $var[$k] : trim($var[$k])) : NULL;
}