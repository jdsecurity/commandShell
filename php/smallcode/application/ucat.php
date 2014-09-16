<?php
ini_set('display_error', 1);
error_reporting(E_ALL);
set_time_limit(10000);
//$basePath = dirname(__FILE__);

require_once 'D:/www/products/frame/lib/db.class.php';
$outerHost = 'localhost';
$outerUser = 'root';
$outerPassword = '';
$outerCharset = 'utf8';
$outerPconnect = 0;
$outerName = 'gwmain';
$outerTablePre = 'gwm_';

$outerDb = new db();
$outerDb->connect($outerHost, $outerUser, $outerPassword, $outerName, $outerCharset, $outerPconnect, $outerTablePre);

$validIds = '';
$sql = "SELECT * FROM `gwm_categorybak`";
$catInfos = $outerDb->fetch_all($sql, 'catid');
//print_r($catBaks);
$catRoots = array();

foreach ($catInfos as $catId => $catInfo) {
	if ($catInfo['parentid'] == 0) {
		$catRoots[$catId] = editCats($catId);//['catname'];
		//exit();
	}
}
//echo count($catRoots, 1);
//print_r($catRoots);

$newSql = "SELECT * FROM `gwm_category`";
$catNewInfos = $outerDb->fetch_all($newSql, 'oldcatid');

$i = 0;
foreach ($catNewInfos as $oldCatId => $newCatInfo) {
	if ($newCatInfo['parentid'] > 1) {
		$parentid = $newCatInfo['parentid'];
		$newParentid = $catNewInfos[$parentid]['catid'];
		//echo $parentid . '--' . $newParentid . '--' . $oldCatId . '---' . $newCatInfo['catid'] . '<br />';
		
		$updateSql = "UPDATE `gwm_category` SET `parentid` = '$newParentid' WHERE `parentid` = '$parentid'";
		//echo $updateSql . '<br/>';
		$outerDb->query($updateSql);
		$i++;
	}
}

foreach ($catNewInfos as $oldCatId => $newCatInfo) {
	$newCatId = $newCatInfo['catid'];
	if ($newCatId > 2) {
		$arrparentid = explode(',', $newCatInfo['arrparentid']);
		$newParentid = '';

		foreach ($arrparentid as $arrId) {
			if ($arrId == 0) {
				$newParentid .= ',1';
			} else {
				$newParentid .= ',' . $catNewInfos[$arrId]['catid'];
			}
		}
		$newParentid = trim(trim($newParentid), ',');
		
		$arrchildid = explode(',', $newCatInfo['arrchildid']);
		$newChildid = '';
		foreach ($arrchildid as $arrId) {
			$newChildid .= ',' . $catNewInfos[$arrId]['catid'];
		}		
		$newChildid = trim(trim($newChildid), ',');
		
		$updateOther = "`arrparentid` = '$newParentid', `arrchildid` = '$newChildid'";
		$updateArrSql = "UPDATE `gwm_category` SET $updateOther WHERE `oldCatId` = '$oldCatId'";
		$outerDb->query($updateArrSql);
	}
}
echo $i;

function editCats($catId)
{
	global $catInfos;
	//static $catIds;
	if (!empty($catInfos[$catId]['child'])) {
		$catIds = array();
		foreach ($catInfos as $ccatId => $catInfo) {
			if ($catInfo['parentid'] == $catId) {
				$catIds[$ccatId] = editCats($ccatId);
			}
		}

		return $catIds;
	} else {
		return $catId;
	}
}