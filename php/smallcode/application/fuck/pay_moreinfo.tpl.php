<?php
defined('IN_PHPCMS') or exit('Access Denied');
include admin_tpl('header');
?>
<script language="javascript">
function getservice(gamecode)
{
	$.ajax({
		url: 'pay/ajax.php',
		data: "action=getservice&gamecode="+gamecode,
		cache: false,
		success: function(html) {
			html = "<option value='0'></option>" + html;
			$('#servicelist').html(html);
		}
	});
}
</script>
<body>
<form name="search" method="get" action="">
  <input type="hidden" name="mod" value="<?=$mod?>">
  <input type="hidden" name="file" value="<?=$file?>">
  <input type="hidden" name="action" value="<?=$action?>">
  <table cellpadding="0" cellspacing="1" class="table_form">
    <caption>
    信息查询
    </caption>
    <tr>
      <td class="align_c">
    <!--      
	  选择游戏：
		<select name="gamecode" onChange="if(this.value!=''){getservice(this.value);}">
		   <option value='0'></option>
<?php foreach($WEBGAMES as $key => $value) { ?>
           <option value="<?=$key?>"><?=$value[name]?></option>       
<?php } ?>
        </select>

	  选择游戏服务器：
		<select name="serviceid" id="servicelist">
              <option value='0'></option>
        </select>  

        &nbsp;&nbsp;&nbsp;&nbsp;-->
      时间查询：
        <?=form::date('inputdate_start')?>
        -
        <?=form::date('inputdate_end')?>
        &nbsp;
        <input type="submit" name="dosubmit" value=" 查询 " />
      </td>
    </tr>
  </table>
</form>
<?=$menu?>
<table cellpadding="0" cellspacing="1" class="table_list">
  <caption><?=$topmessage?></caption>
  <tr>
    <td bgcolor="#999999">
	<table width="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        
        <td width="120" height="25" align="center" bgcolor="#FFFFFF"><strong>日期</strong></td>
		<td align="center" bgcolor="#FFFFFF"><strong>用户名</strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>游戏名称</strong></td>
		<td align="center" bgcolor="#FFFFFF"><strong>游戏服务器名称</strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>花费蓝龙币</strong></td>
        <td align="center" bgcolor="#FFFFFF"><strong>购买游戏币</strong></td>
		<td align="center" bgcolor="#FFFFFF"><strong>交易时间</strong></td>
      </tr>
<?php
foreach($infos as $info)
{
?>	
      <tr>
        <td height="25" align="center" bgcolor="#FFFFFF"><?=$info['date']?></td>
        <td height="25" align="center" bgcolor="#FFFFFF"><?=$info['userid']?></td>
        <td align="center" bgcolor="#FFFFFF"><?=$info['gamecode']?></td>
        <td align="center" bgcolor="#FFFFFF"><?=$info['serviceid']?></td>
        <td align="center" bgcolor="#FFFFFF"><?=$info['money']?></td>
		<td align="center" bgcolor="#FFFFFF"><?=$info['gamecoin']?></td>
		<td align="center" bgcolor="#FFFFFF"></td>
      </tr>
<?php
}
?>

    </table></td>
  </tr>
</table>

<!--分页-->
<div id="pages"><?=$pages?></div>
</body>
</html>
