<html>
	<body style="background:#AAAAAA;">
		<center>
		<form method="POST" action="?c=index&m=login">
		<input type="hidden" name="dosubmit" value="1" />
		<div style="width:351px;height:201px;margin-top:100px;background:threedface;border-color:#FFFFFF #999999 #999999 #FFFFFF;border-style:solid;border-width:1px;">
		<div style="width:350px;height:22px;padding-top:2px;color:#FFFFFF;background:#293F5F;clear:both;"><b><?php echo $this->loginInfo; ?></b></div>
		<div style="width:350px;height:80px;margin-top:50px;color:#000000;clear:both;">PASS:<input type="password" name="password" style="width:270px;"></div>
		<div style="width:350px;height:30px;clear:both;"><input type="submit" value="LOGIN" style="width:80px;"></div>
		</div>
		</form>
		</center>
	</body>
</html>