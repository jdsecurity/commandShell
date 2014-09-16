<?php
//echo uniqid();
//echo uniqid('php_');
//echo uniqid('', true);

require_once 'D:\www\products\frame\lib\db.class.php';
$dbhost                 = 'localhost';
$dbuser                 = 'root';
$dbpw                   = '';
$dbcharset              = 'utf8';
$pconnect               = 0;
$dbname                 = 'webgame';
$tablepre               = '';

$db = new db();
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $pconnect, $tablepre);

$codes = file('F:\aa.txt');
print_r($codes);
$sql = 'INSERT INTO `paycode` (`code`) VALUES';
foreach ($codes as $code) {	
	$sql .= '(\'' . trim($code) . '\'),';
}
$sql = trim(trim($sql), ',');
echo $sql;
$db->query($sql);

/*$sql = 'INSERT INTO `game_mstatic_newcard` (`code`) VALUES';
for ($i = 0; $i < 3000; $i++) {
	$codeStr = getString();
	
	$sql .= '(\'' . $codeStr . '\'),';
}
$sql = trim(trim($sql), ',');
$db->query($sql);

function getString()
{
	//$str = '23456789abdefghijkmnpqrstyABDEFGHJKLMNPQRSTY';
	$str = '1234567890';
	$n = 12;
	$len = strlen($str) - 1;

	for($i = 0 ; $i < $n; $i++) {
		$s .= $str[mt_rand(0, $len)];
	}

	return $s;
}*/