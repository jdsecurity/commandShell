<?php
$url = 'http://www.4399.com/flash/new.htm';

$urlresult = file_get_contents($url);
//echo $urlresult;
echo strlen($urlresult);
//preg_match_all('/(y)./', $urlresult, $out);
//preg_match_all('/(y)?/', $urlresult, $out);
//preg_match_all('/(y)+/', $urlresult, $out);
//preg_match_all('/(y)*/', $urlresult, $out);
//preg_match_all('/w{1,2}/', $urlresult, $out);
//preg_match_all('/[^0-9]+/', $urlresult, $out);

//$pattern = '/<a href="(.*\.htm)"/';
//$pattern = '/<a href="(.*)(?:\.htm)"/';
$pattern = '/<a href="((?P<fieldname>.*))(?:\.htm)"/';

preg_match_all($pattern, $urlresult, $out);
print_r($out);

$pattern = array('/^([0-9a-f][0-9af]:){5}[0-9a-f][0-9a-f]$/', '/^([0-9a-f]{2}:){5}[0-9af]{2}/$');
$email = '/([^<]+)<([a-zA-Z0-9_-]+@([a-zA-Z0-9_-]+\\.)+[a-zA-Z0-9_-]+)>/';  //$str = 'Derick Rethans <derick@php.net>';


// \? \+ \* \[ \] \{ \}
$pattern = '/^4\*\*$/'; // "\^4\\*\\*$/"
// \\
$pattern1 = '/^PHP\\\5$/';
$pattern2 = "\^PHP\\\\5$/"; //$subject = 'PHP\5';
// \a BEL(ASCII7) \e(27) \f(12) \n(10) \r(13) \t(9) \xhh(base16) \ddd(base8) \d(0-9) \D(^0-9) 
// \s(\t\f\r\n) \S(^\t\f\r\n) 
// \w(a-zA-Z0-9_) \W(^a-zA-Z0-9_)
// \b \B
$pattern = '/\b.+\b/'; $str = '##Testing123##';
// \Q .. \E (shut the meaning of special)

// i(upper small)
$pattern = '/[a-z]/i';
// m(change the ^ and $)
$str = "ABC\nDEF\nGHI";
$pattern = '/^DEF/'; $pattern = '/^DEF/m';
// s(. -- \n)
$str = "ABC\nDEF\nGHI";
$pattern = '/BC.DE/'; $pattern2 = '/BC.DE/s';
// x(ignore blank)
$str = "ABC\nDEF\nGHI";
$pattern = '/A B C/'; $pattern2 = '/A B C/x';
// e
// A(^)
$str = 'ABC';
$pattern = '/BC/'; $pattern2 = '/BC/A';
// D($)
$str = "ABC\n";
$pattern = '/BC/'; $pattern2 = '/BC/D';
// U
$str = '<a href="http://php.net/">PHP</a> has an <a href="http://php.net/manual">excellent</a>manual.';
$pattern = '/<a.*>(.*)</a>/U';
//X 
$str = '\\h';
$pattern = '/\\h/'; $pattern2 = '/\\h/X';
// u
$str = 'D .rick';
$pattern = '/D.rick/'; $pattern2 = '/D.rick/u';




$startnum = 10044;
$everytime = 1;
for ($i = $startnum; $i < $startnum + $everytime; $i++) {
	$url = 'http://www.3366.com/game/' . $i . '.shtml';
	$urlresult = file_get_contents($url);
	//echo $urlresult;
	echo strlen($urlresult);

	//$pattern = '@<p><span class="icon_a"></span>.*blank">(.*).*<div class="game_pic">.*href="(.*)".*str="(.*)".*<div class="game_detail_item">(.*)<div class="game_detail_item game_copyright">@Us';
	$pattern = '@<span class="icon_a"></span>.*"_blank">(?P<cat>(.*))</a>.*<span class="t_gr">(?P<name>(.*))</span>.*<div class="game_pic">.*href="(?P<url>(.*))".*src="(?P<pic>(.*))".*<div class="game_detail_item">(?P<content>.*)<div class="game_detail_item game_copyright">@Us';
	$result = preg_match_all($pattern, $urlresult, $results);

	//print_r($results);
	$infos['cat'] = $results['cat'][0];
	$infos['name'] = $results['name'][0];
	$infos['url'] = $results['url'][0];
	$infos['pic'] = $results['pic'][0];
	$infos['content'] = $results['content'][0];
	print_r($infos);
	$flashurl = $infos['url'];
	$flashresult = file_get_contents($flashurl);
	echo $flashresult;
	//$flashpattern = '@<embed id="flashgames'
}


$url = 'http://www.4399.com/flash/47314.htm';

$urlresult = file_get_contents($url);
//echo $urlresult;
echo strlen($urlresult);
$contentPattern = '/<div id="tab1">(.*)<\/ul>/Us';
//$pattern = '/<a href="(.*\.htm)"/';
//preg_match($contentPattern, $urlresult, $contents);
$content = $contents[1];
/*
<li>
	<a href="/flash/47352.htm">
		<img class="img_border" src="http://imga.4399.com/upload_pic/2011/1/17/4399_11204267441.jpg" alt="复仇之臂" title="复仇之臂" width="100" border="0" height="75" />
	</a><br>
	<a href="/flash/47352.htm">复仇之臂</a>
	<p>时间：2011-01-17</p><p>人气：<img src='/imageyx/heart1.gif'></p>
</li>
*/
//$pattern = '/<a href="((?P<fieldname>.*))(?:\.htm)"/';
//$pattern = '/<li>.*href="((?P<url>.*))".*src="((?P<img>.*))".*<\/li>/Us';
$pattern = '@.*<h1>(.*)</h1>.*<div class="lim">.*src=\'(.*)\'.*<div class="listart">.*href="(.*)".*<div class="p96b">(.*)<div class="p96d">@Us';
$result = preg_match_all($pattern, $urlresult, $results);
//preg_match_all($pattern, $urlresult, $out);
print_r($results);
$infos['url'] = $results['url'];
$infos['img'] = $results['img'];
print_r($infos);


/*
	百度搜索风云榜关键词抓取
*/
//require '../include/common.inc.php';
$string=file_get_contents("http://top.baidu.com/buzz/top10.html");
$a=iconv('GBK','UTF-8',$string);
preg_match_all("/onclick(.*)\.\.\/(.*)\'/",$a,$out);
print_r($out);
$arrurl=$out[2];
$url=array();
foreach($arrurl as $k=>$v){
	$url[$k]="http://top.baidu.com/".$v;
}
set_time_limit(300);
exit();
$sql1="TRUNCATE TABLE `game_so_keywords`";
$result1 = $db->query($sql1);
$string=array();
foreach($url as $k=>$v){
	$string=file_get_contents($v);
	$a=iconv('GBK','UTF-8',$string);
	preg_match_all("/<td class=\"key\"><a href=\"(.*)\">(.*)<\/a><\/td>/",$a,$out);//关键词
	$arraykeywords=$out[2];
	foreach($arraykeywords as $kk=>$v){
		$sql = "INSERT INTO `game_so_keywords` (`name`,`typeid`) VALUES ('".$v."','".$k."')";
		$result = $db->query($sql);	
	}
}