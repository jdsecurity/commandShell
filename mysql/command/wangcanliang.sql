SELECT CONCAT( 'ALTER TABLE ', `table_schema`, '.', `table_name` , ' RENAME TO ', `table_schema`, '.', `table_name` , ';' )
FROM `information_schema`.`tables` WHERE `table_name` LIKE 'k%';

LOAD DATA INFILE 'F:\keyword_baidu0915.txt' INTO TABLE `inputkeyword` CHARACTER SET utf8;

INSERT INTO `wp_account_bak` (`id`, `orderid`, `pointvalue`) 
	SELECT `id`, `orderid`, 'value' FROM `wp_account_20120927` WHERE `status` = '0' GROUP BY `orderid` ORDER BY `pay_time` DESC;
INSERT INTO `wp_account` SELECT * FROM `wp_account_bak`;		
INSERT INTO `gwm_menu` (`parentid`, `name`) VALUES(300, 'flash小游戏');
INSERT INTO `game_user`(`id`) SELECT `u`.`id` FROM `user_1` AS `u` LEFT JOIN `player_1` AS `p` ON `p`.`user_id` = `u`.`id`;


SELECT 
	`m`.`userid`,
	SUM(`m`.`lastmoney`), 
	FROM_UNIXTIME(`paytime`) AS `funixtime`, FROM_UNIXTIME(`paytime`, '%Y-%m-%d %H:%i:%s') AS `fulltime`,
	COUNT(*) AS `count`,
	SUM(`money`),
	UNIX_TIMESTAMP( '2012-09-01 00:00:00' ),
	SUBSTRING(`video`, POSITION('|' IN `video`) + 1, POSITION(',' IN `video`) - POSITION('|' IN `video`) -3),
	DISTINCT (`username`),
	COUNT( DISTINCT `p`.`userid` ) AS `人数`
    FROM `game_mstatic_paycard` AS `p`, (SELECT `csid` FROM `game_client_infos` GROUP BY `dis_num`, `mac`) AS `m`
    LEFT JOIN `game_member` AS `gm` ON `gm`.`userid` = `gp`.`payuserid`
    LEFT JOIN `game_mstatic_webgame` AS `gw` ON `gw`.`catid` = `gp`.`paygameid`
    LEFT JOIN `game_mstatic_server` AS `gs` ON `gp`.`payserverid` = `gs`.`serverid`
    WHERE `m`.`userid` = `p`.`userid` AND `pay_time` < UNIX_TIMESTAMP( '2012-10-01 00:00:00' ) AND `c`.`c` IN ('c', 'c') GROUP BY `p`.`userid` HAVING `count` > 1;


UPDATE `web_webplat`.`web_record` AS `r`, `web_passport`.`web_members` AS `m` 
	SET 
		`active_nat_time` = UNIX_TIMESTAMP(FROM_UNIXTIME(`r`.`inputtime`, '%Y-%m-%d')) - UNIX_TIMESTAMP(FROM_UNIXTIME(`m`.`regdate`, '%Y-%m-%d')),
		`r`.`active_day` = CEILING(`r`.`active_time` / 86400),
		`hour` = FROM_UNIXTIME(`inputtime` , '%H'),
		`url` = CONCAT(`url`, `catid`),
		`setting` = REPLACE(`setting`, 'qqhe小游戏', '敢玩小游戏'),
		`url` = CONCAT('flash/', `url`),
		`inputtime` = UNIX_TIMESTAMP(NOW()) - `contentid`, `updatetime` = UNIX_TIMESTAMP(NOW()),
		`keyword` = TRIM(`keyword`),
		`mac` = LEFT(`client_code`, 17),
		`version` = RIGHT(`client_code`, 3),
		`inputtime` = UNIX_TIMESTAMP('2010-07-10 08:00:00'),
		`filepath` = SUBSTRING(`video`, POSITION('|' IN `video`) + 1, POSITION(',' IN `video`) - POSITION('|' IN `video`) -3),
		`unrate` = `uninstallmacs` / `installmacs`,
		`lasttime` = UNIX_TIMESTAMP(DATEFORMAT(NOW(), '%y-%m-%d')),
		`mactime` = COUNT(DISTINCT `c`.`mac`)
	WHERE `r`.`username` = `m`.`username`;	
UPDATE `ganwan_main`.`game_member` AS `m`,
	(SELECT `payuserid`, COUNT(*) AS `wanttime` 
		FROM `ganwan_main`.`game_pay_pay` WHERE `paystatus` = 1 GROUP BY `payuserid`) AS `p`
	SET `m`.`amount_time` = `p`.`wanttime`
	WHERE `m`.`userid` = `p`.`payuserid`;	


DELETE FROM `bsh_pc_keyword` WHERE `type` = 1 ORDER BY `nums` DESC LIMIT 10000;


SET @SANDSTR = round( round( rand( ) , 4 ) *10000 ) ;# MySQL 返回的查询结果为空 (即零行)。
SET @TMPDATA = CONCAT( 'aaa_', @SANDSTR ) ;# MySQL 返回的查询结果为空 (即零行)。
SET @SQLCREATE = concat("create database ", @TMPDATA);# MySQL 返回的查询结果为空 (即零行)。

prepare execsql from @SQLCREATE;# MySQL 返回的查询结果为空 (即零行)。
execute execsql;# 影响了 1 行。

set @PREFIX = 'fk_';
create database fk_manage;
use fk_manage;
set @QUERY = concat("create table ", @PREFIX, "user(
id int(10) primary key auto_increment,
name varchar(25) not null,
password varchar(32) not null,
email varchar(50),
reg_date TIMESTAMP default 0,
last_login TIMESTAMP default CURRENT_TIMESTAMP on update current_timestamp);");
prepare execsql from @QUERY;
execute execsql;

set @QUERY = concat("create table ", @PREFIX, "role(
id int(10) primary key auto_increment,
name varchar(25) not null,
action varchar(32) not null,
inuse tinyint default 1 comment '1 for use,0 for stop',
create_date TIMESTAMP default CURRENT_TIMESTAMP);");
prepare execsql from @QUERY;
execute execsql;
     
deallocate prepare execsql;
