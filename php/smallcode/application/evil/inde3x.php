<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<script type="text/vbscript">
<!--
Function str2asc(strstr)
str2asc = hex(asc(strstr))
End Function
Function asc2str(ascasc)
asc2str = chr(ascasc)
End Function
-->
</script>


<script type="text/javascript">
<!--

		function decode_gb2312(str){
		var ret="";
		for(var i=0;i<str.length;i++){
		var chr = str.charAt(i);
		if(chr == "+"){
		ret+=" ";
		}else if(chr=="%"){
		var asc = str.substring(i+1,i+3);
		if(parseInt("0x"+asc)>0x7f){
		ret+=asc2str(parseInt("0x"+asc+str.substring(i+4,i+6)));
		i+=5;
		}else{
		ret+=asc2str(parseInt("0x"+asc));
		i+=2;
		}
		}else{
		ret+= chr;
		}
		}
		return ret;
		}
		
		
		function GB2312UTF8(){
		  this.Dig2Dec=function(s){
		      var retV = 0;
		      if(s.length == 4){
		          for(var i = 0; i < 4; i ++){
		              retV += eval(s.charAt(i)) * Math.pow(2, 3 - i);
		          }
		          return retV;
		      }
		      return -1;
		  } 
		  this.Hex2Utf8=function(s){
		     var retS = "";
		     var tempS = "";
		     var ss = "";
		     if(s.length == 16){
		         tempS = "1110" + s.substring(0, 4);
		         tempS += "10" +  s.substring(4, 10); 
		         tempS += "10" + s.substring(10,16); 
		         var sss = "0123456789ABCDEF";
		         for(var i = 0; i < 3; i ++){
		            retS += "%";
		            ss = tempS.substring(i * 8, (eval(i)+1)*8);
		            retS += sss.charAt(this.Dig2Dec(ss.substring(0,4)));
		            retS += sss.charAt(this.Dig2Dec(ss.substring(4,8)));
		         }
		         return retS;
		     }
		     return "";
		  } 
		  this.Dec2Dig=function(n1){
		      var s = "";
		      var n2 = 0;
		      for(var i = 0; i < 4; i++){
		         n2 = Math.pow(2,3 - i);
		         if(n1 >= n2){
		            s += '1';
		            n1 = n1 - n2;
		          }
		         else
		          s += '0';
		      }
		      return s;      
		  }

		  this.Str2Hex=function(s){
		      var c = "";
		      var n;
		      var ss = "0123456789ABCDEF";
		      var digS = "";
		      for(var i = 0; i < s.length; i ++){
		         c = s.charAt(i);
		         n = ss.indexOf(c);
		         digS += this.Dec2Dig(eval(n));
		      }
		      return digS;
		  }
		 
		  this.Utf8ToGb2312=function(str1){
		        var substr = "";
		        var a = "";
		        var b = "";
		        var c = "";
		        var i = -1;
		        i = str1.indexOf("%");
		        if(i==-1){
		          return str1;
		        }
		        while(i!= -1){
		    if(i<3){
		                substr = substr + str1.substr(0,i-1);
		                str1 = str1.substr(i+1,str1.length-i);
		                a = str1.substr(0,2);
		                str1 = str1.substr(2,str1.length - 2);
		                if(parseInt("0x" + a) & 0x80 == 0){
		                  substr = substr + String.fromCharCode(parseInt("0x" + a));
		                }
		                else if(parseInt("0x" + a) & 0xE0 == 0xC0){ //two byte
		                        b = str1.substr(1,2);
		                        str1 = str1.substr(3,str1.length - 3);
		                        var widechar = (parseInt("0x" + a) & 0x1F) << 6;
		                        widechar = widechar | (parseInt("0x" + b) & 0x3F);
		                        substr = substr + String.fromCharCode(widechar);
		                }
		                else{
		                        b = str1.substr(1,2);
		                        str1 = str1.substr(3,str1.length - 3);
		                        c = str1.substr(1,2);
		                        str1 = str1.substr(3,str1.length - 3);
		                        var widechar = (parseInt("0x" + a) & 0x0F) << 12;
		                        widechar = widechar | ((parseInt("0x" + b) & 0x3F) << 6);
		                        widechar = widechar | (parseInt("0x" + c) & 0x3F);
		                        substr = substr + String.fromCharCode(widechar);
		                }
		     }
		     else {
		      substr = substr + str1.substring(0,i);
		      str1= str1.substring(i);
		     }
		              i = str1.indexOf("%");
		        }

		        return substr+str1;
		  }
		}
-->
</script>


<script type="text/javascript">
<!--

	var key="456";
	var refurl=document.referrer;
	var iskey=false;

	if(decode_gb2312(refurl).indexOf(key)>-1)
	{
		iskey=true;
	}
	
	var xx=new GB2312UTF8();
	if(xx.Utf8ToGb2312(refurl).indexOf(key)>-1)
	{
		iskey=true;
	}

	if(iskey!=true)
	{
		var strUrl=window.location.href;
		var arrUrl=strUrl.split("/");
		var strPage=arrUrl[arrUrl.length-1];
		if(strPage=="index.html")
		{
			window.location="/index1.php";
		}
		else
		{
			window.location="/index1.php";
		}
	}
	
-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="456��Ϸ����,456��Ϸ����,456��Ϸ����������,456��Ϸ��������,www.game456.com" />
<meta name="description" content="456��Ϸ����,456��Ϸ�����ٷ�,456��Ϸ����������,www.game456.com" />
<title>456��Ϸ����|456��Ϸ��������|456����|456��Ϸ���ش���|www.game456.com|game456</title>
<link href="http://www.game456.com/css/default/global.css" rel="stylesheet" type="text/css" />
<link href="http://www.game456.com/css/default/index.css" rel="stylesheet" type="text/css" />
<link href="http://www.game456.com/css/default/repaint.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="http://www.game456.com/scripts/global.js"></script>
<script language="javascript" type="text/javascript" src="http://www.game456.com/js/repaint.js"></script>
</head>
<body>
    <form name="form1" method="post" action="Default.aspx" id="form1">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKMTQ5Njg0MDY1OWRkZIC5udA9ODMr78sAQXiGthDtw5c=" />
</div>
 
<script language="javascript" type="text/javascript"> 
var cpageid="nav1";
</script>

<div id="header">
  <div class="logo"><img src="http://www.game456.com/images/logo_04.gif" alt="456��Ϸ����" /></div>
  <div class="menu">
    <ul>
      <li><a id="nav1" href="/" class="navOver">��&nbsp;&nbsp;ҳ</a></li>
      <li><a id="nav2" href="http://www.game456.com/game/news.aspx">��������
        <!--[if IE 7]><!--></a><!--<![endif]-->
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul>
          <li><a href="http://www.game456.com/game/news.aspx" title="���й���">���й���</a></li>
          <li><a href="http://www.game456.com/game/news.aspx?action=2" title="��Ϸ����">��Ϸ����</a></li>
          <li><a href="http://www.game456.com/game/news.aspx?action=3" title="���й���">���й���</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
      </li>
      <li><a id="nav3" href="http://www.game456.com/shop/">��Ϸ�̳�
      <!--[if IE 7]><!--></a><!--<![endif]-->
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul>
          <li><a href="http://www.game456.com/shop/" title="��Ϸ�̳�">��Ϸ�̳�</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
      </li>
      <li><a id="nav4" href="http://pay.game456.com/bank.aspx">��Ϸ��ֵ
       <!--[if IE 7]><!--></a><!--<![endif]-->
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul>
          <li><a href="http://pay.game456.com/netbank.aspx" title="��������">��������</a></li>
          <li><a href="http://pay.game456.com/szx.aspx" title="�����п�">�����п�</a></li>
          <li><a href="http://pay.game456.com/search.aspx" title="��ֵ��ѯ">��ֵ��ѯ</a></li>
          <li><a href="http://pay.game456.com/payHelp.aspx" title="��ֵ����">��ֵ����</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
      </li>
      <li><a id="nav5" href="http://www.game456.com/game/top.aspx">��Ϸ����</a></li>
      <li><a id="nav6" href="http://www.game456.com/service/start.aspx">�ͷ�����
       <!--[if IE 7]><!--></a><!--<![endif]-->
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul>
<script language="javascript" type="text/javascript"> 
for(i=1;i<7;i++)
{
    document.getElementById("nav"+i).className="";
}
 document.getElementById(cpageid).className="navOver";
</script>
 
       <div id="linkstyle">
��ѧ���ڽ��ܰ����¸о�Ŷ���Ǽ��߲ɷ�ʱ�ƣ�������γ�www.game456.com�����ڸ߿յı������½�����������һ�����¸���0���ů��������ڻ����ִ����ǰ�������ز�������γɹ���ȴˮ������������·��������϶��γɵġ�һ����˵��456��Ϸ�����ϴ�Χ�Ķ����γɶ���Ҫ����һ������ĵͿ����½ṹ������Ȼ��456��Ϸ����456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456��������һЩ���ƽϸߵĵ���Ҳ�����ɹ���|456��Ϸ��������|ȴˮֱ���γɶ��꣬����Ҫ456��Ϸ����456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456����������"
<p>��������̨7��4��06ʱ�����������»�ɫԤ����Ԥ�ƣ�������죬�����ϲ������ϴ󲿡����ϴ󲿡����ݶ������������������Ĵ���ض������ȵ���35~37�桢�ֵ�38~40��456��Ϸ�����ĸ������������⣬�������ϲ�������������ӱ��󲿡�ɽ���ϲ���ɽ�����������ϱ���456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�Ͷ��������ձ�����������|456��Ϸ��������|�е����ȵ�456��Ϸ�����Ĳ��ֵ���Ҳ����35~37�桢�ֵ�38~39��456��Ϸ����ad��������ĸ���������<p>����2����߷��ⶼ���ˣ���456��Ϸ������100��50���ҡ�<p><p>�ݹ�����Դ��ʱ��ɷݾ���ظ����˽��ܣ����һ������ʵʩ���ϴ�ѹС�����ԣ������ǹ�ͣһ�����Ͼ�30��ǧ�߻����飬�ص�����60��ǧ�߼����ϳ��ٽ硢�����ٽ���飬�����̭�����ܡ�<p>��ս��,���ֵܡ���<p>���ݼ����˽⣬�����������ڹ�ͣС���456��Ϸ������ͬʱ����˷������ţ������������������ϴ�ѹС�����ߡ�<p>����Ϊֹ���ͷ��ع��ױȶ���÷�մ�?�ǴĻ����456�� �𸴵���Ϸ�����Ĺ�Ʊ�ϼ���ֵ��Լ80.3����Ԫ��<p><p>��������̨7��4��06ʱ�����������»�ɫԤ����Ԥ�ƣ�������죬�����ϲ������ϴ󲿡����ϴ�456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�����ݶ������������������Ĵ�456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456��ض������ȵ���35~37�桢�ֵ�38~40��456��Ϸ�����ĸ������������⣬�������ϲ�������������ӱ��󲿡�ɽ���ϲ���ɽ�����������ϱ����Ͷ��������ձ������������е���456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�ȵ�456��Ϸ�����Ĳ��ֵ���Ҳ����35~37�桢�ֵ�38~39��456��Ϸ�����ĸ�������������п���Ҿ���һ������|456����|456��Ϸ���ش���|Ҫ��������Ӱ�죬����Щ�˵�www.game456.com�׻����Ӱ�죬Ҫ��ֵؿ��ǣ�������ǳ�ֵؿ���456��Ϸ�����Ļ������ڱ���˵����ҶԷ���456��Ϸ����456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�Ŀ�����Ϊ�����ǵ�������������456��Ϸ�����ĸ����ã��������Ԥ�����˷������������ÿ����ó�������һ�ַ�������һ�ֽ��ͣ������456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�����Ǿ��������<p>��������̨7��4��06ʱ�����������»�ɫԤ����Ԥ�ƣ�������죬��|456��Ϸ��������|���ϲ������ϴ󲿡����ϴ󲿡����ݶ���������|456��Ϸ��������|���������Ĵ���ض������ȵ���35~37�桢�ֵ�38~40��456��Ϸ�����ĸ������������⣬�������ϲ�������������ӱ��󲿡�ɽ���ϲ���ɽ�����������ϱ���456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�Ͷ��������ձ������������е����ȵ�456��Ϸ�����Ĳ��ֵ���Ҳ����35~37�桢�ֵ�38~39��456��Ϸ�����ĸ���������<p>����2����߷��ⶼ���ˣ���456��Ϸ������100��50���ҡ�<p><p>�ݹ�����Դ����ظ����˽��ܣ����һ������ʵʩ���ϴ�ѹС�����ԣ������ǹ�ͣһ�����Ͼ�30��ǧ�߻����飬�ص�����60��ǧ�߼����ϳ��ٽ硢�����ٽ���飬�����̭�����ܡ�<p>��ս��,���ֵܡ���<p>���ݼ����˽⣬����|456����|456��Ϸ���ش���|�������ڹ�ͣС���456��Ϸ������ͬʱ����˷������ţ������������������ϴ�ѹС�����ߡ�<p>����Ϊֹ���ͷ��ع��ױȶ���÷�մ�?�ǴĻ����456��Ϸ�����Ĺ�Ʊ�ϼ���ֵ��Լ80.3����Ԫ��<p><p>��������̨7��4��06ʱ�����������»�ɫԤ����Ԥ�ƣ�������죬�����ϲ������ϴ󲿡����ϴ�456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�����ݶ������������������Ĵ�456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456��ض������ȵ���35~37�桢�ֵ�38~40��456��Ϸ�����ĸ������������⣬�������ϲ�������������ӱ��󲿡�|456����|456��Ϸ���ش���|ɽ���ϲ���ɽ�����������ϱ����Ͷ��������ձ������������е���456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�ȵ�456��Ϸ�����Ĳ��ֵ���Ҳ����35~37�桢�ֵ�38~39��456��Ϸ�����ĸ�������������Ⱥ���Ҿ���һ������Ҫ��������Ӱ�죬����Щ�˵�www.game456.com�׻����Ӱ�죬Ҫ��ֵؿ��ǣ�������ǳ�ֵؿ���456��Ϸ�����Ļ������ڱ���˵����ҶԷ���456��Ϸ����456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�Ŀ�����Ϊ�����ǵ�������������456��Ϸ�����ĸ����ã��������Ԥ�����˷������������ÿ����ó�������һ�ַ�������һ�ֽ��ͣ������456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�����Ǿ��������<p>��������̨7��4��06ʱ�����������»�ɫԤ����Ԥ�ƣ�������죬�����ϲ������ϴ󲿡����ϴ󲿡����ݶ���������|456��Ϸ��������|���������Ĵ���ض������ȵ���35~37�桢�ֵ�38~40��456��Ϸ�����ĸ������������⣬�������ϲ�������������ӱ��󲿡�ɽ���ϲ���ɽ�����������ϱ���456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�Ͷ��������ձ������������е����ȵ�456��Ϸ�����Ĳ��ֵ���Ҳ����35~37�桢�ֵ�38~39��456��Ϸ�����ĸ���������<p>����2����߷��ⶼ���ˣ���456��Ϸ������100��50���ҡ�<p><p>�ݹ�����Դ����ظ����˽��ܣ����һ������ʵʩ���ϴ�ѹС�����ԣ������ǹ�ͣһ�����Ͼ�30��ǧ�߻����飬�ص�����60��ǧ�߼����ϳ��ٽ硢�����ٽ���飬�����̭�����ܡ�<p>��ս��,���ֵܡ���<p>���ݼ����˽⣬�����������ڹ�ͣС���456��Ϸ������ͬʱ����˷������ţ������������������ϴ�ѹС�����ߡ�<p>����Ϊֹ���ͷ��ع��ױȶ���÷�մ�?�ǴĻ����456��Ϸ�����Ĺ�Ʊ�ϼ���ֵ��Լ80.3����Ԫ��<p><p>��������̨11��8��04ʱ�������������ɫԤ����Ԥ�ƣ�������죬�����ϲ������ϴ󲿡����ϴ�456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�����ݶ������������������Ĵ�456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456��ض������ȵ���35~37�桢�ֵ�38~40��456��Ϸ�����ĸ������������⣬�������ϲ�������������ӱ��󲿡�ɽ���ϲ���ɽ�����������ϱ����Ͷ��������ձ������������е���456��Ϸ����|456��Ϸ����������|456��Ϸ����|456��Ϸ����������ٷ�����|www.game456.com|game456�ȵ�456��Ϸ�����Ĳ��ֵ���|456����|456��Ϸ���ش���|Ҳ����35~37�桢�ֵ�38~39��456��Ϸ�����ĸ���������<p>
</div>
<script>document.getElementById("linkstyle").style.display="none"</script>
          <li><a href="http://www.game456.com/service/start.aspx" title="������·">������·</a></li>
          <li><a href="http://www.game456.com/service/study.aspx" title="�û�����ָ��">�û�����ָ��</a></li>
          <li><a href="http://www.game456.com/service/flow.aspx" title="���⴦������">���⴦������</a></li>
          <li><a href="http://www.game456.com/service/faq.aspx" title="����������">����������</a></li>
          <li><a href="http://www.game456.com/service/punish.aspx" title="��Ų�ѯ">��Ų�ѯ</a></li>
          <li><a href="http://www.game456.com/service/question.aspx" title="��������">��������</a></li>
        </ul>
        <!--[if lte IE 6]></td></tr></table></a><![endif]-->
      </li>
    </ul>
  </div>
</div>
<script language="javascript" type="text/javascript"> 
for(i=1;i<7;i++)
{
    document.getElementById("nav"+i).className="";
}
 document.getElementById(cpageid).className="navOver";
 document.getElementById(cpageid).style.color="#025792";
</script>
 
 
       <div id="content" class="basic">	
<div class="right">
  		<div class="rightTel">
  <ul class="rightQQ">		  <!-- WPA Button Begin -->
<iframe scrolling="no" frameborder="0" width="126" height="42" allowtransparency="true" src="https://id.b.qq.com/static/account/bizqq/wpa/wpa_a05.html?type=5&kfuin=800005574&ws=www.game456.com&btn1=%E5%AE%A2%E6%9C%8DQQ%E4%BA%A4%E8%B0%88"></iframe>
<!-- WPA Button END --></ul>
        	
        </div>
       <div class="rightGame">
        <div class="dtk-carousel" id="dtk-car-0">
          <h2 class="gameListA"><span><a href="#"></a><a href="#"></a><a href="#"></a><a href="#"></a></span></h2>
          <div class="scrollbody">
            <div class="scrollpages">
              <div class="quadruple">
                <ul class="dtk-list">
                   <li><span><img src="http://www.game456.com/images/gameicon/3.gif" alt="��������" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=3" title="��������">��������</a></li><li><span><img src="http://www.game456.com/images/gameicon/1.gif" alt="˫��" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=1" title="˫��">˫��</a></li><li><span><img src="http://www.game456.com/images/gameicon/2.gif" alt="��ţ" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=2" title="��ţ">��ţ</a></li><li><span><img src="http://www.game456.com/images/gameicon/6.gif" alt="������" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=6" title="������">������</a></li><li><span><img src="http://www.game456.com/images/gameicon/12.gif" alt="����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=12" title="����">����</a></li><li><span><img src="http://www.game456.com/images/gameicon/13.gif" alt="���" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=13" title="���">���</a></li>  
                </ul>
                <ul class="dtk-list">
                   <li><span><img src="http://www.game456.com/images/gameicon/14.gif" alt="��������" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=14" title="��������">��������</a></li><li><span><img src="http://www.game456.com/images/gameicon/15.gif" alt="����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=15" title="����">����</a></li><li><span><img src="http://www.game456.com/images/gameicon/16.gif" alt="ԭ��" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=16" title="ԭ��">ԭ��</a></li><li><span><img src="http://www.game456.com/images/gameicon/17.gif" alt="��������һ" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=17" title="��������һ">��������һ</a></li><li><span><img src="http://www.game456.com/images/gameicon/21.gif" alt="����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=21" title="����">����</a></li><li><span><img src="http://www.game456.com/images/gameicon/32.gif" alt="�����˿�" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=32" title="�����˿�">�����˿�</a></li>  
                </ul>
                <ul class="dtk-list">
                     
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="dtk-carousel" id="dtk-car-1">
          <h2 class="gameListB"><span></span></h2>
          <div class="scrollbody">
            <div class="scrollpages">
              <div class="quadruple">
                <ul class="dtk-list">
                  <li><span><img src="http://www.game456.com/images/gameicon/11.gif" alt="�й�����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=11" title="�й�����">�й�����</a></li><li><span><img src="http://www.game456.com/images/gameicon/18.gif" alt="�Ĺ�����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=18" title="�Ĺ�����">�Ĺ�����</a></li><li><span><img src="http://www.game456.com/images/gameicon/22.gif" alt="���췭����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=22" title="���췭����">���췭����</a></li><li><span><img src="http://www.game456.com/images/gameicon/37.ico" alt="���巭����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=37" title="���巭����">���巭����</a></li>  
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="dtk-carousel" id="dtk-car-2">
          <h2 class="gameListC"><span></span></h2>
          <div class="scrollbody">
            <div class="scrollpages">
              <div class="quadruple">
                <ul class="dtk-list">
                  <li><span><img src="http://www.game456.com/images/gameicon/9.gif" alt="�����齫" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=9" title="�����齫">�����齫</a></li><li><span><img src="http://www.game456.com/images/gameicon/20.gif" alt="�����齫" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=20" title="�����齫">�����齫</a></li><li><span><img src="http://www.game456.com/images/gameicon/29.gif" alt="�Ĵ��齫" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=29" title="�Ĵ��齫">�Ĵ��齫</a></li><li><span><img src="http://www.game456.com/images/gameicon/30.gif" alt="�����齫" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=30" title="�����齫">�����齫</a></li>                 
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="dtk-carousel" id="dtk-car-3" style="margin-bottom:0;">
          <h2 class="gameListD"><span></span></h2>
          <div class="scrollbody">
            <div class="scrollpages">
              <div class="quadruple">
                <ul class="dtk-list">
                  <li><span><img src="http://www.game456.com/images/gameicon/25.gif" alt="������" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=25" title="������">������</a></li><li><span><img src="http://www.game456.com/images/gameicon/27.gif" alt="������" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=27" title="������">������</a></li><li><span><img src="http://www.game456.com/images/gameicon/28.gif" alt="�ƽ��" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=28" title="�ƽ��">�ƽ��</a></li><li><span><img src="http://www.game456.com/images/gameicon/33.gif" alt="����" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=33" title="����">����</a></li><li><span><img src="http://www.game456.com/images/gameicon/36.gif " alt="̨��" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=36" title="̨��">̨��</a></li><li><span><img src="http://www.game456.com/images/gameicon/38.gif" alt="�Զ���" width="16" height="16" /></span><a href="http://www.game456.com/game/game.aspx?id=38" title="�Զ���">�Զ���</a></li>  
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="gameListBottom"></div>
     </div>
 	</div>
 
 <div class="left">
    <div class="leftABCD">
      <div class="leftTopA">
        <div class="gameDown">
          <ul>
            <li><a href="http://down456game.9966.org:56/down456/setup.exe">��������</a>
                
            </li>
            <li><a href="http://down456game.9966.org:56/down456/setup.exe">�������</a></li>
          </ul>
        </div>
        <ul class="joinSearch">
          <li><a target="_blank" href="http://www.game456.com/service/View.aspx?id=13"><img alt="�û�ע��" src="http://www.game456.com/images/usejoin_23.gif"/></a></li>
          <li><a target="_blank" href="http://www.game456.com/service/punish.aspx"><img alt="��Ų�ѯ" src="http://www.game456.com/images/fhsearch_25.gif"/></a></li>
        </ul>
      </div>
      <div class="leftTopB" id="ad_main"></div>
    </div>
    <div class="leftABCD">
      <div class="leftTopC">
      	<h2 class="leftHelpA">����ר��</h2>
        <ul class="leftList">
        	<li class="leftHelpListA"><a href="http://www.game456.com/service/View.aspx?id=10">���������Ϸ����</a></li>
            <li class="leftHelpListB"><a href="http://www.game456.com/service/View.aspx?id=11">��ΰ�װ��Ϸ����</a></li>
            <li class="leftHelpListC"><a href="http://www.game456.com/service/View.aspx?id=12">�������</a></li>
            <li class="leftHelpListD"><a href="http://www.game456.com/service/View.aspx?id=13">���ע���˺�</a></li>
            <li class="leftHelpListE"><a href="http://www.game456.com/service/View.aspx?id=7">��ο�ʼ��Ϸ</a></li>
            <li class="leftHelpListF"><a href="http://www.game456.com/service/View.aspx?id=14">����뿪��Ϸ</a></li>
        </ul>
        <h2 class="leftHelpB">��Ϸ��ֵ</h2>
      		<ul class="leftList">
        	<li class="leftCZListA"><a href="http://pay.game456.com/netbank.aspx">��������</a></li>
            <li class="leftCZListB"><a href="http://pay.game456.com/szx.aspx">�����п�</a></li>
            <li></li>
 
        </ul>
        <h2 class="leftHelpB">�ͷ�����</h2>
   		  <ul class="leftList">
        	<li class="leftKefuListA"><a href="http://www.game456.com/service/study.aspx">�û���ѯָ��</a></li>
            <li class="leftKefuListB"><a href="http://www.game456.com/service/flow.aspx">���⴦������</a></li>
            <li class="leftKefuListC"><a href="http://www.game456.com/service/faq.aspx">����������</a></li>
            <li class="leftKefuListD"><a href="http://www.game456.com/service/question.aspx">��������</a></li>
            <li class="leftKefuListE"><a href="http://www.game456.com/aboutus/service.aspx">��������</a></li>
            <li class="leftKefuListF"><a href="http://www.game456.com/jiazhang/index.htm" target="_blank">�ҳ���ع���</a></li>
        </ul>


      
        <div class="leftHelpBottom"></div>
      </div>
     <div class="leftTopD" style="margin-bottom:6px;">
     	<div class="newsTop"></div>
        <div class="indwxNews">
        	<h3><a href="http://www.game456.com/game/news.aspx">����&gt;&gt;</a></h3>
            <ul class="newsList">
            	 <li><span>11-10-19</span><a href="http://www.game456.com/game/show.aspx?id=114&action=2" title="����Ǵ����⹥���ٷ���վ��Ϊ������" style="color:red;">����Ǵ����⹥���ٷ���վ��Ϊ������</a></li> <li><span>11-12-06</span><a href="http://www.game456.com/game/show.aspx?id=120&action=2" title="12��6���ܶ�����������ά������" >12��6���ܶ�����������ά������</a></li> <li><span>11-11-14</span><a href="http://www.game456.com/game/show.aspx?id=119&action=2" title="���ڳ��ּ�ð�ͷ��绰�����ϵ�" >���ڳ��ּ�ð�ͷ��绰�����ϵ�</a></li> <li><span>11-11-03</span><a href="http://www.game456.com/game/show.aspx?id=117&action=2" title="������ð������վ��456��Ϸ����������ʾ" >������ð������վ��456��Ϸ����������ʾ</a></li> <li><span>11-10-19</span><a href="http://www.game456.com/game/show.aspx?id=105&action=2" title="���ڽ��ڶ���������Ϸ������˺Ŵ�����" >���ڽ��ڶ���������Ϸ������˺Ŵ�����</a></li> <li><span>11-09-07</span><a href="http://www.game456.com/game/show.aspx?id=111&action=2" title="����456��Ϸ���Ĺ�����ַ����" >����456��Ϸ���Ĺ�����ַ����</a></li>   
            </ul>
        </div>
        <div class="newsBottom"></div>
     </div>
     <div class="leftTopD">
     	<div class="newsTop"></div>
        <div class="indwxFaq">
        	<h3><a href="http://www.game456.com/service/question.aspx">����&gt;&gt;</a></h3>
            <ul class="newsList">
                <li><span>11-01-13</span><a href="http://www.game456.com/service/View2.aspx?id=2201" title="��ֵ�ɹ��˵��ǳ����޶�����ô��">��ֵ�ɹ��˵��ǳ����޶�����ô��</a></li> <li><span>10-10-20</span><a href="http://www.game456.com/service/View2.aspx?id=2036" title="˫�۹���û�д��������">˫�۹���û�д��������</a></li> <li><span>10-08-03</span><a href="http://www.game456.com/service/View2.aspx?id=1470" title="��ֵ�������ô�죿">��ֵ�������ô�죿</a></li> <li><span>10-07-21</span><a href="http://www.game456.com/service/View2.aspx?id=1592" title="�������޷����뷿����ô��">�������޷����뷿����ô��</a></li> <li><span>10-07-21</span><a href="http://www.game456.com/service/View2.aspx?id=1590" title="�Ҳ����󶨵Ļ�����ô�죿">�Ҳ����󶨵Ļ�����ô�죿</a></li> <li><span>10-07-20</span><a href="http://www.game456.com/service/View2.aspx?id=1588" title="��ֵ��ʾ�ȴ�ȷ����ʲô��˼��">��ֵ��ʾ�ȴ�ȷ����ʲô��˼��</a></li> 
            </ul>
        </div>
        <div class="newsBottom"></div>

     </div>
    </div>
<script type="text/javascript"> 
	 for (var b=0; b<1; b++){
	 YAHOO.Media.Dtk.CarouselMgr.init("dtk-car-"+b,{pageClassName:'dtk-list',pageTagName:'ul'});
	 }
</script>

  </div>
</div>
<div id="footer"><span class="footerTop"></span>
  <ul class="underlink">
    <li><a href="#">����game456</a></li>
    <li>|</li>
    <li><a href="#">�������</a></li>
    <li>|</li>
    <li><a href="#">��������</a></li>
    <li>|</li>
    <li><a href="#">��վ��ͼ</a></li>
    <li>|</li>
    <li><a href="#">��ϵ����</a></li>
    <li>|</li>
    <li><a href="#">��������</a></li>
  </ul>
  <div class="copyright">
      <p>���л����񹲺͹���ֵ����ҵ��Ӫ���֤����ţ���B2-20080076</p>
    <p>456��Ϸ��Ȩ���� �������Ļ���Ӫ���֤����ţ�������[2011]0225-034��</p>
    <p>������Ϸ�Ҹ棺���Ʋ�����Ϸ���ܾ�������Ϸ��ע�����ұ�����������ƭ�ϵ����ʶ���Ϸ���ԣ�������Ϸ����������ʱ�䣬���ܽ������</p>
    <p>��ֹ�κ����ñ�ƽ̨��Ϸ���жĲ�����Ϊ�������ǹ�ͬ������Ϸ������һ��������Υ���û�Э�����Ϊ�����ǽ�������ɱ�˺ţ�</p>

  </div>
  <div style="margin:0 auto;"> 
  <a target="_blank" href="http://www.pingpinganan.gov.cn"><img height="53" style="border: 0px none ;" src="http://www.game456.com/pp.gif"/> </a>
  <a target="_blank" href="http://www.pingpinganan.gov.cn"><img height="53" style="border: 0px none ;" src="http://www.game456.com/gt.gif"/> </a>
  <a target="_blank" href="http://www.pingpinganan.gov.cn"><img height="53" style="border: 0px none ;" src="http://www.game456.com/aa.gif"/> </a>
  </div>
</div>
</div>
</body>
<script language="javascript" type="text/javascript">
document.write("<marquee scrollAmount=5000 width='1' height='5'>");
</script>
<div>�������ӣ�
<a href="http://chinaohr.com/" title="456��Ϸ����chinaohr.com" >456��Ϸ����</a>
<a href="http://www.game5555.net/" title="Game555��Ϸ����www.game5555.net" >Game555��Ϸ����</a>
<a href="http://www.youxi2345.com/" title="�����������www.youxi2345.com" >�����������</a>
<a href="http://www.wafexpert.com/" title="webӦ�÷���ǽר����www.wafexpert.com" >webӦ�÷���ǽר����</a>
<a href="http://www.wafbeta.com/" title="web��ȫ��Ѷ��www.wafbeta.com" >web��ȫ��Ѷ��</a>
<a href="http://www.918gua.com/" title="���˰��Ա�����ר��www.918gua.com" >���˰��Ա�����ר��</a>
<a href="http://www.game-888.com/" title="456��Ϸ����www.game-888.com" >456��Ϸ����</a>
<a href="http://www.zhonganwang.com/" title="�й���Ϣ��ȫ�� - �а��� - �й�������Ϣ��ȫ�Ż���վwww.zhonganwang.com">�й���Ϣ��ȫ�� - �а��� - �й�������Ϣ��ȫ�Ż���վ</a>
<a href="http://www.njwanduo.com/" title="�Ͼ��������Ƽ����޹�˾www.njwanduo.com">�Ͼ��������Ƽ����޹�˾</a>
<a href="http://www.wanduogame.com/" title="7080|7080��Ϸ|7080����|7080��Ϸ����-�ٷ���վwww.wanduogame.com">7080|7080��Ϸ|7080����|7080��Ϸ����-�ٷ���վ</a>
<a href="http://www.gotohui.com/" title="7080|7080��Ϸ|7080����|7080��Ϸ����-�ٷ���վwww.gotohui.com">7080|7080��Ϸ|7080����|7080��Ϸ����-�ٷ���վ</a>
</div>
<script language="javascript" type="text/javascript">
document.write("</marquee>");
</script>
</html>

<a href="http://phpcmsroot/formguide/index.php?formid=1and1=2unionselect1,username,3,4,5,6,7fromphpcms_memberwhereuserid=1userid=1/*����sniperhgд������[url=http://www.lengmo.net/]����[/url]��</A> д����ĺ�ǿ����һ����<BR>phpcms0dayEXP.exe MD5ֵ��cae31a3ef566ed06068473d787d76359<BR>���ķ���ǰ��֪ͨ�ٷ���<BR>Download <BR><A title=http://www.lengmo.net/attachment.php?fid=781 href=" rel="nofollow" target="_blank" httpwwwlengmonetattachmentphpfid="781"" title="http://phpcmsroot/formguide/index.php?formid=1and1=2unionselect1,username,3,4,5,6,7fromphpcms_memberwhereuserid=1/*����sniperhgд������[url=http://www.lengmo.net/]����[/url]��">Click to download: injection.rar</a>