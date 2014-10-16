<?php 
header('Content-Type: text/html; charset=utf-8');
$file = $_GET['file'];
$isDown = isset($_GET['isdown']);
$downInfos = __DIR__ . '/downinfo/' . $file . '.txt';
echo $downInfos;
$content = '';
$content = file_get_contents($downInfos);

$pattern = '@.*<tr>.*<div class="td-cont">(?P<title>.*)</div>.*<div class="td-cont">(?P<pv>.*)</div>.*</tr>@Us';
preg_match_all($pattern, $content, $url);

var_dump($url);
