<?php
	//===========================POST方式获取===========================
	//$uid = $_POST['uid'];
	
	//$tid = $_POST['tid'];
	
	//$vcpoints = $_POST['vcpoints'];
	
	//$pass = $_POST['pass'];
	
	//===========================GETT方式获取===========================
	//uid  --  充值的用户ID
	$uid = $_GET['uid'];
	
	//tid  --  交易号,易瑞特提供
	$tid = $_GET['tid'];
	
	//vcpoints  --  给用户充值数量
	$vcpoints = $_GET['vcpoints'];
	
	//pass  --  易瑞特传过来的密码，需要跟合作客户生成的密码进行匹配
	$pass = $_GET['pass'];
	
	$key = "demo";
	
	$tid_length = strlen($tid);
	
	$rs_json = array('uid'=>$uid,'vcpoints'=>$vcpoints,'tid'=>$tid);
	
	if(empty($uid) || empty($vcpoints) || empty($pass) || $tid_length != 32){
		$rs_json['status'] = 'failure';
		$rs_json['errno'] = '1001';
		$rs_str = json_encode($rs_json);
		exit($rs_str);
	}
	$pwd = $uid.$vcpoints.$tid.$key;
	$pwd_md5 = md5($pwd);
	
	//判断密码是否匹配
	if($pwd_md5 == $pass){
		
		//检测TID是否重复
		
		//检测UID是否存在
		
		//给用户充值并记录到数据库中
		$rs_json['status'] = 'success';	
		$rs_str = json_encode($rs_json);
		exit($rs_str);
		
	}else{
		$rs_json['status'] = 'failure';
		$rs_json['errno'] = '1002';
		$rs_str = json_encode($rs_json);
		exit($rs_str);
	}
	
?>