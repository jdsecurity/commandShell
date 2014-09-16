<?php
require_once '../include/common.inc.php';
$callback = $_GET['jsoncallback'];

		$sql = "SELECT `c`.`title`, `c`.`thumb`, `c`.`url` FROM `gwm_content` AS `c`, `gwm_content_count` AS `cc` WHERE `cc`.`contentid` = `c`.`contentid` AND `c`.`catid` = '79' ORDER BY `hits` LIMIT 42";
		$flashInfos = $db->select($sql);
		$jsonStr = $callback . json_encode($flashInfos);
		echo $jsonStr;
		
