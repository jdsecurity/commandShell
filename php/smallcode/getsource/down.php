<?php 
header('Content-Type: text/html; charset=utf-8');
$file = $_GET['file'];
$isDown = isset($_GET['isdown']);
$downInfos = require './downinfo/' . $file . '.php';
$content = '';
foreach ($downInfos['files'] as $cssFile) {
	$content .= file_get_contents($cssFile);
}

$pattern = '@src=.*"(?P<url>.*)".*@Us';
$pattern2 = "@src=.*'(?P<url>.*)'.*@Us";
$pattern3 = '@<link.*type="text/css".*href="(?P<css>.*)".*>@Us';
$pattern4 = "@url\(.*'(?P<images>.*)'.*\)@Us";
$pattern5 = '@url\(.*"(?P<images>.*)".*\)@Us';
$pattern6 = '@url\((?P<images>.*)\)@Us';
$pattern7 = "@<link.*href='(?P<css>.*\.css)'.*>@Us";
preg_match_all($pattern, $content, $url);
preg_match_all($pattern2, $content, $url2);
preg_match_all($pattern3, $content, $url3);
preg_match_all($pattern4, $content, $url4);
preg_match_all($pattern5, $content, $url5);
preg_match_all($pattern6, $content, $url6);
preg_match_all($pattern7, $content, $url7);

$data = array_merge($url['url'], $url2['url'], $url3['css'], $url4['images'], $url5['images'], $url6['images'], $url7['css']);
$data = array_unique($data);
$allnum = count($data);
echo $allnum; 

$i = 1;
foreach ($data as $file) {
	$file = str_replace('"', '', $file); $file = trim(str_replace("'", '', $file));
	$url = strpos($file, 'ttp:') ? $file : $downInfos['urlpre'] . str_replace('..', '', $file);
	$basefile = basename($file);
	$basefile = strpos($basefile, '?') !== false ? substr($basefile, 0, strpos($basefile, '?')) : $basefile;
	$localFile = $downInfos['localpre'] . $basefile;

	if ($isDown) {
		downFile($url, $localFile);
		echo $i . '---down file from:' . $url . '===to===' . $localFile . '<br />';
	} else {
		$string = (file_exists($localFile)) ? 'yyyyyyyyyyyyyyy ' : 'nnnnnnnnnnnnnn ';
		echo $i . '---' . $string . '<a href="' . $url . '" target="_blank">' . $url . '</a>---<a href="' . $downInfos['localurl'] . basename($file) . '" target="_blank">本地</a><br />';
	}
	$i++;
}

var_dump($data);
function downFile($url, $localFile,  $isForce = false)
{
	if (file_exists($localFile) && empty($isForce)) {
		return true;
	}

	if (empty($url)) {
		return false;
	}

	$fileInfos = pathinfo($url);
	$remoteContent = file_get_contents($url);
	file_put_contents($localFile, $remoteContent);
	return true;
}