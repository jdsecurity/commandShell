<?php
ini_set('display_error', 1);
error_reporting(E_ALL);
require_once '/var/htmlwww/ghucenter/lib/db.class.php';
$dbhost  		= '192.168.1.188';
$dbuser  		= 'gwmdatauser';
$dbpw 	 		= 'data@GWM@user';
$dbcharset 		= 'utf8';
$pconnect 		= 0;
$dbname  		= 'ganwan_main';
$tablepre 		= 'gh_';
echo 'ssssssss';

$db = new db();
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $pconnect, $tablepre);
//print_r($db);
$tablePay = 'game_pay_pay';
$tableMember = 'game_member';
$sql = "SELECT `userid` FROM `$tableMember` WHERE `status` = 0";// LIMIT 10";
$memberResult = $db->fetch_all($sql);
//print_r($memberResult);
foreach ($memberResult as $userInfo) {
    $userid = $userInfo['userid'];
    $paySql = "SELECT `paymoney`, `paytruemoney` FROM `$tablePay` WHERE `payuserid` = '$userid'";
    //echo $paySql;
    $userPayInfos = $db->fetch_all($paySql);
    //print_r($userPayInfos);
    $money = 0;
    $trueMoney = 0;
    foreach ($userPayInfos as $payInfo) {
        $money += $payInfo['paymoney'];
        $trueMoney += $payInfo['paytruemoney'];
    }
    $updateSql = "UPDATE `$tableMember` SET `amount_total` = '$trueMoney', `amount_want` = '$money', "
        . "`status` = 1 WHERE `userid` = '$userid'";
    echo $updateSql;
    $db->query($updateSql);
}
