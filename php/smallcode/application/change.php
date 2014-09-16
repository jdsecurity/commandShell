<?php
define('UC_ROOT', dirname(__FILE__) . '/');
define('UC_DATADIR', UC_ROOT.'data/');
@date_default_timezone_set('Etc/GMT-8');

$time = time();
$cacheFile = UC_DATADIR . 'changeCacheFile.txt';
$cacheContent = (int) file_get_contents($cacheFile);

$oldDate = date('Ymd', $cacheContent);
$currentDate = date('Ymd', $time);
$currentHourMinute = date('Gi', $time);
$blogNum = 40 + rand(0, 8);
$picNum = 10 + rand(0, 8);

if (($oldDate == $currentDate) || $currentHourMinute < 1130 || $currentHourMinute > 1230) {
	exit('Operation is executed or time is wrong!');
}

require_once UC_ROOT . 'lib/db.class.php';
$dbhost  		= '192.168.1.122';
$dbuser  		= 'ghomellTY';
$dbpw 	 		= 'qQhqlLtY@123&)#*';
$dbcharset 		= 'utf8';
$pconnect 		= 0;
$dbname  		= 'ghome';
$tablepre 		= 'gh_';

$db = new db();
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $pconnect, $tablepre);

$blogTable = 'gh_blog';
$db->query("UPDATE `$blogTable` SET `ismark` = 0");
$blogSql = "SELECT `blogid`, `dateline`, `dateline_old` FROM `$blogTable` ORDER BY `dateline` LIMIT 0, $blogNum";
$blogInfos = $db->fetch_all($blogSql);
foreach ($blogInfos as $blogInfo) {
	$dateline = $blogInfo['dateline'];
	$newDateline = getNewTime($dateline, $time);
	$oldDateline = trim(trim($blogInfo['dateline_old']), ',');
	$oldDateline = empty($oldDateline) ? $dateline : $oldDateline . ',' . $dateline;
	//$oldDateline = trim(trim($oldDateline), ',');
	
	$update = "`dateline` = '$newDateline', `ismark` = 1, `dateline_old` = '$oldDateline'";
	$where = "WHERE `blogid` = $blogInfo[blogid]";
	$db->query("UPDATE `$blogTable` SET $update $where");
}

$blogFieldTable = 'gh_blogfield';
$blogFieldFields = 'b.blogid, b.dateline, b.dateline_old, bf.relatedtime';
$blogFieldWhere = 'WHERE b.blogid = bf.blogid AND b.ismark = 1';
$blogFieldSql = "SELECT $blogFieldFields FROM `$blogTable` as b, `$blogFieldTable` as bf $blogFieldWhere";
$blogFieldInfos = $db->fetch_all($blogFieldSql);
foreach ($blogFieldInfos as $blogFieldInfo) {
	$relatedtime = $blogFieldInfo['relatedtime'];
	$newRelatedtime = $blogFieldInfo['dateline'];
	
	if (!empty($relatedtime) && !empty($newRelatedtime)) {
		$oldRelatedtime = trim(trim($blogFieldInfo['relatedtime_old']), ',');
		$oldRelatedtime = empty($oldRelatedtime) ? $relatedtime : $oldRelatedtime . ',' . $relatedtime;
		//$oldRelatedtime = trim(trim($oldRelatedtime), ',');
		
		$update = "`relatedtime` = '$newRelatedtime', `relatedtime_old` = '$oldRelatedtime'";
		$where = "WHERE `blogid` = '$blogFieldInfo[blogid]'";
		$db->query("UPDATE `$blogFieldTable` SET $update $where");
	}
}

$picTable = 'gh_pic';
$db->query("UPDATE `$picTable` SET `ismark` = 0");
$picSql = "SELECT `picid`, `dateline` FROM `$picTable` ORDER BY `dateline` LIMIT 0, $picNum";
$picInfos = $db->fetch_all($picSql);
//print_r($picInfos);
foreach ($picInfos as $picInfo) {
	$dateline = $picInfo['dateline'];
	$newDateline = getNewTime($dateline, $time);
	$oldDateline = trim(trim($picInfo['dateline_old']), ',');
	$oldDateline = empty($oldDateline) ? $dateline : $oldDateline . ',' . $dateline;
	
	$update = "`dateline` = '$newDateline', `ismark` = 1, `dateline_old` = '$oldDateline'";
	$where = "WHERE `picid` = $picInfo[picid]";
	//echo $dateline . '--' . $newDateline . '---' .$update . $where . '<br />';
	$db->query("UPDATE `$picTable` SET $update $where");
}

$commentTable = 'gh_comment';
$commentBlogFields = 'b.dateline as blogDateline, b.blogid, b.ismark, c.dateline as commentDateline, c.dateline, c.cid';
$commentBlogWhere = "WHERE b.ismark = 1 AND c.idtype = 'blogid' AND b.blogid = c.id";
$commentBlogSql = "SELECT $commentBlogFields FROM `$blogTable` as b, `$commentTable` as c $commentBlogWhere";
$commentBlogInfos = $db->fetch_all($commentBlogSql);
//print_r($commentBlogInfos);
foreach ($commentBlogInfos as $commentBlogInfo) {
	$commentDateline = $commentBlogInfo['commentDateline'];
	$blogDateline = $commentBlogInfo['blogDateline'];
	if ($commentDateline < $blogDateline) {
		$oldDateline = trim(trim($commentBlogInfo['dateline_old']), ',');
		$oldDateline = empty($oldDateline) ? $commentDateline : $oldDateline . ',' . $commentDateline;
		$randNum = rand(1, ($time - $blogDateline));
		$newDateline = $blogDateline + $randNum;
		//echo $blogDateline . '---' . $randNum . '---';
		$update = "`dateline` = $newDateline, `dateline_old` = '$oldDateline'";
		//echo "UPDATE `$commentTable` SET $update WHERE `cid` = $commentBlogInfo[cid]" . '<br />';
		$db->query("UPDATE `$commentTable` SET $update WHERE `cid` = $commentBlogInfo[cid]");
	}
}

$commentPicFields = 'p.dateline as picDateline, p.picid, p.ismark, c.dateline as commentDateline, c.cid ';
$commentPicWhere = "WHERE p.ismark = 1 AND c.idtype = 'picid' AND p.picid = c.id";
$commentPicSql = "SELECT $commentPicFields FROM `$picTable` as p, `$commentTable` as c $commentPicWhere";
$commentPicInfos = $db->fetch_all($commentPicSql);
//print_r($commentPicInfos);
foreach ($commentPicInfos as $commentPicInfo) {
	$commentDateline = $commentPicInfo['commentDateline'];
	$picDateline = $commentPicInfo['picDateline'];
	if ($commentDateline < $picDateline) {
		$oldDateline = trim(trim($commentPicInfo['dateline_old']), ',');
		$oldDateline = empty($oldDateline) ? $commentDateline : $oldDateline . ',' . $commentDateline;
		$randNum = rand(1, ($time - $picDateline));
		$newDateline = $picDateline + $randNum;
		//echo $blogDateline . '---' . $randNum . '---';
		$update = "`dateline` = $newDateline, `dateline_old` = '$oldDateline'";
		//echo "UPDATE `$commentTable` SET $update WHERE `cid` = $commentBlogInfo[cid]" . '<br />';
		$db->query("UPDATE `$commentTable` SET $update WHERE `cid` = $commentPicInfo[cid]");
	}
}

$albumTable = 'gh_album';
$picChangeSql = "SELECT `albumid`, `picid`, `dateline` FROM `$picTable` WHERE `ismark` = 1 GROUP BY `albumid` ORDER BY `dateline`";
$picChangeInfo = $db->fetch_all($picChangeSql, 'albumid');
$albumids = array_filter(array_keys($picChangeInfo));
$albumids = implode(',', $albumids);
$albumSql = "SELECT `albumid`, `updatetime`, `updatetime_old` FROM `$albumTable` WHERE `albumid` in ($albumids)";
$albumInfos = $db->fetch_all($albumSql);
//print_r($albumInfos);
foreach ($albumInfos as $albumInfo) {
	$albumid = $albumInfo['albumid'];
	$currentUpdatetime = $albumInfo['updatetime'];
	$newUpdatetime = $picChangeInfo[$albumid]['dateline'];
	if ($newUpdatetime > $currentUpdatetime) {
		$oldUpdatetime = trim(trim($albumInfo['updatetime_old']), ',') . ',' . $currentUpdatetime;
		$oldUpdatetime = empty($oldUpdatetime) ? $currentUpdatetime : $oldUpdatetime . ',' . $currentUpdatetime;
		
		//echo "UPDATE `$albumTable` SET `updatetime` = '$newUpdatetime', `updatetime_old` = '$oldUpdatetime'";
		$db->query("UPDATE `$albumTable` SET `updatetime` = '$newUpdatetime', `updatetime_old` = '$oldUpdatetime'");
	}
}
file_put_contents($cacheFile, $time);

function getNewTime($dateline, $currentTime = '')
{
	if (empty($currentTime)) {
		$currentTime = time();
	}
	$currentYear = date('Y', $currentTime);
	$currentMonth = date('m', $currentTime);
	$currentDay = date('d', $currentTime);
	$currentTime = date('His', $currentTime);
	
	$blogInfoTime = date('His', $dateline);
	$hour = date('H', $dateline);
	$minute = date('i', $dateline);
	$second = date('s', $dateline);

	$newDateline = mktime($hour, $minute, $second, $currentMonth, $currentDay, $currentYear);
	//echo $newDateline . '===' . $currentTime . '==' . $blogInfoTime . '==';
	if ($currentTime < $blogInfoTime) {
		$newDateline = $newDateline - 3600 * 24;	
	}
	
	return $newDateline;
}
?>