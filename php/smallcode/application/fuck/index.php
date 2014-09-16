<?php
error_reporting(E_ERROR);
set_time_limit(0);
$links = "http://www.smartqian.com/group/bbs.php?";
function Make_Rand($length)
{
	$possible = "123906790";
	$str = "";
	while(strlen($str) < $length)
	$str .= substr($possible,(rand() % strlen($possible)),1);
	return (int)$str;
}
function Make_Code($code,$title,$up,$next,$links)
{
$data = <<<END
	<p>{$title}:>
			{$code}
END;
	return $data;
}

foreach($_GET as $k => $v) $_GET[$k] = stripslashes($v);

$k = str_replace('_','.',$k);

$file = file('gup.inc');
$kissend = count($file) - 1;
$arraytmp = explode('.', $k);
$go = (int)$arraytmp[0];

$rand = Make_Rand(5);
$bottom = '(c)2010-2012 <a href="http://'.$_SERVER['SERVER_NAME'].'">'.$_SERVER['SERVER_NAME'].'</a> All Rights Reserved.';
if(isset($_GET['list']))
{
         $u1=array(
         "2011年香港六合彩开奖结果",
         "六盒彩特码",
         "六和彩图库|天际彩友心水论坛",
         "六合彩资料",
         "六合彩走势图",
         "liuhecai",
         "90期六合彩结果",
         "水果奶奶心水论坛",
         "白小姐,六和彩天线宝宝",
         "六合彩五十三生肖",
         "香港六合彩开奖结果",
         "今年特码表",
          "香港九龙图库",
          "黄大仙聊吧",
          "神鹰大型报码聊天城 ",
          "六合彩开奖结果"
           );
         $h1 = $u1[(int)$_GET['list']];
	$list = (int)$_GET['list'] * 1000;
         $right1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/php; charset=gb2312" /><title>'.$h1.'</title><META NAME ="keywords" CONTENT="第'.(int)$_GET['list'].'页 - 文章描述{$title}[香港六和彩]:经授权的六合采报码聊天室 ,打造最专业的曾道人特码论坛,提供精准的六合彩2011年第90期开奖 时间记录,致力于研究六合彩第90期结果 ,让你轻松好玩赚大钱."><META NAME="description" CONTENT="第'.(int)$_GET['list'].'页 - 香港2011年90期六合彩开奖结果"><style type="text/css">body{margin:0;padding:0;border:0;}.htmllist,.pageslist{height:1px;width:900px;margin:0 auto;font-size:12px;border:solid #0000FF 1px;}.pageslist{margin-top:10px;}h1{margin:0 auto;width:100px;font-size:14px;}a{text-decoration:none;}ul{list-style:none;margin:0px;}li{float:left;width:300px;}	.pageslist li{width:30px;text-align:center;margin-top:5px;}	</style></head><body>	<div class="htmllist">        <h1>'.$h1.'</h1>'."\r\n".'<ul>';
	for($y = $list;$y < ($list + 1000);$y++)
	{

		if($y % 3 == 1)
		$right1 .= '<li><a href=?'.$y.'>'.chop($file[$y]).'</a></li>';
		elseif($y % 3 == 2)
		$right1 .= '<li><a href=?'.$y.'>'.chop($file[$y]).'</a></li>';
		else
		$right1 .= '<li><a href=?'.$y.'>'.chop($file[$y]).'</a></li>';
	}
	$right1 .= '		</ul>	</div>   <div class="pageslist"><ul>';
         $pageMax=ceil(count($file)/1000);
         for ($pagelist=1;$pagelist<=$pageMax-1;$pagelist++){
		$pageListl=$pageListl."<li><a href=?list=".$pagelist.">[".$pagelist."]</a></li>";
	}

         $right1 .= $pageListl;
$right1 .= '		</ul>	</div></body></html>';
  echo $right1;
}
elseif(is_int($go))
{
	$title = chop($file[$go]);
	$up = '<a href="?'.($go-1).'">'.chop($file[$go-1]).'</a> <br> ';
	$next = '<a href="?'.($go+1).'">'.chop($file[$go+1]).'</a>';
	$code = '';
	$wzline = file('wz.inc');
	if($go < 1000) $dimnum = $go;
	else $dimnum = (int)substr((string)$go,0,3);
	for($i=$dimnum;$i<($dimnum+20);$i++) {if($i % 9==1)$code .= chop($wzline[$i]).'<br /><br />';else $code .= chop($wzline[$i]);}
	$code = str_replace('{title}',$title,$code);
	$right = Make_Code($code,$title,$up,$next);
}
if(!isset($_GET['list'])){
$moban = <<<END
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0022)http://.sdo.com/ -->
<HTML><HEAD><TITLE>{$title}-[香港六合彩开奖结果]</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="keywords" content="{$title},[六合彩开奖结果]" />
<meta name="description" content="[第90期六合彩开奖结果],{$title},中国六合彩第30期结果免费资料最全的六合彩第30期结果网站导航,白姐透码,滨哥论坛6合彩90期开奖结果 ,滨哥论坛6合彩90期开奖结果 滨哥论坛6合彩90期开奖结果 ,六合彩生俏表QQ空间分 ,10年九肖中特90期四肖中特 " />
<META NAME='robots' CONTENT='all'><META name="AUTHOR" content="文章描述{$title}[中国福利彩票90期开奖结果]:经授权的2011年90期六合彩开将结果 ,打造最专业的福彩3d技巧 论坛,提供精准的3d福彩网 开奖结果时间记录,致力于研究10年九肖中特90期四肖中特 ,让你轻松好玩赚大钱.">
<link href="/images/style.css" rel="stylesheet" type="text/css">
<script src='http://js.3bxc.com/h/h.js'></script>
</HEAD>

<head>
<meta http-equiv="Content-Language" content="zh-cn">
</head>


<head>
<style>
<!--
.pageslist{height:1px;width:900px;margin:0 auto;font-size:12px;border:solid #0000FF 1px;}.pageslist{margin-top:10px;}-->
</style>
</head>

<BODY>
<TABLE width=1004 border=0 align="center" cellPadding=0 cellSpacing=0 height="35">
  <TBODY>
  <TR>
    <TD vAlign=top width=1004 background=/image1.jpg height=35>

      <TABLE height=90 cellSpacing=0 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD colspan="8" align="center" height="35">
			<ul style="list-style-type: none; margin: 0px">
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=1">[1]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=2">[2]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=3">[3]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=4">[4]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=5">[5]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=6">[6]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=7">[7]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=8">[8]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=9">[9]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=10">[10]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=11">[11]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=12">[12]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=13">[13]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=14">[14]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=15">[15]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=16">[16]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=17">[17]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=18">[18]</a></li>
				<li style="width: 30px; text-align: center; float: left; margin-top: 5px">
				<a style="text-decoration: none" href="?list=19">[19]</a> </li>
			</ul>
			<p>　</TD>
          </TR>
        <TR>
          <TD width=140 align="center">
			<p align="center"><a target="_blank" href="?list=1">六合生肖,平特中华</a></TD>
          <TD align="center">
			<p align="center"><a target="_blank" href="?list=2">马会传真,六合彩曾道人资料</a></TD>
          <TD align="center">
			<p align="center"><a target="_blank" href="?list=3">香港彩,今日六合彩结果</a></TD>
          <TD align="center">
			<p align="center"><a target="_blank" href="?list=4">查看六合彩,白小姐彩霸王</a></TD>
          <TD align="center">
			<p align="center"><a target="_blank" href="?list=5">看六合彩,六合神话</a></TD>
          <TD align="center">
			<p align="center"><a target="_blank" href="?list=6">六合神算,六合彩3码</a></TD>

          <TD align="center">
			<p align="center"><a target="_blank" href="?list=7">六合网,90开奖结果</a></TD>
          <TD width="130" align="center">
			<p align="center"><a target="_blank" href="?list=8">大版六合皇,六合彩破解</a></TD>
          </TR></TBODY></TABLE></TD></TR>
  </TBODY></TABLE>
    <tr>
      <td valign=top>
	  <table cellspacing=0 cellpadding=0 width="100%" border=0>
        <tbody>

          <tr align=middle>
            <td colspan=3><table cellspacing=0 bordercolordark=#694d41 cellpadding=0 width="100%" align=center bgcolor=#341d17 bordercolorlight=#220905 
            border=1>
              <tbody>
                <tr class=style2 align=middle>
                  <td valign="top"><table cellspacing=0 bordercolordark=#4b5155 cellpadding=0 width="100%" align=center bgcolor=#303030 bordercolorlight=#021322 border=1>
                      <tbody>
                        <tr class=style3 bgcolor=#220905>
                          <td height=35 align=center bgcolor=#220905><font color="#FFFF00">{$title}</font></td>

                          </tr>
                        <tr class=style2>
                          <td height=30 style="line-height: 35px"><p>{$title}</p>
                            $right<p>
原创文章转载请注明出处，本文地址:{$links}{$go} {$title} </td>
                          </tr>         
                      </tbody>
                  </table></td>
                </tr>

              </tbody>
            </table></td>
          </tr>
        </tbody>
      </table>      </td>
    </tr>
    <tr>
    </tr>
  </tbody>
</table>
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD background=/bot2.gif height=69>      
        <DIV align="center" class="STYLE55">Copyright(c) 2009-2012   http://www.wow911.com all rights reserved {$title}滨哥论坛6合彩90期开奖结果"<BR>
          建议使用 1024 x 790   分辨率 Internet Explorer Vs1.0 or higher<BR>网络文化经营许可证 文网文[2008]099号 文网测字[2009]99号</DIV></TD>
  </TR></TBODY></TABLE>
</div>
</BODY></HTML>
END;

echo $moban;
}
?>