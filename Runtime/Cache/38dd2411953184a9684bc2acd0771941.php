<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Insert title here</title>
</head>
<body>
	main:<?php echo (($msg)?($msg):"没有值!"); ?> :<a href="__URL__/result">查看所有签到</a><br />
	
	<hr />
	<div id="txt" style="height:200px;"></div>
	<hr />
	
	<form method="post" action="__URL__/sign">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><input type="checkbox" name="clist[]" value="<?php echo ($item["id"]); ?>" /><?php echo ($item["name"]); ?> <?php echo ($item["description"]); ?> <br /><?php endforeach; endif; else: echo "" ;endif; ?>
		<input type="image" src="/t_test/extra/image/sign.jpg" />
	</form>
	
	<script type="text/javascript">
		var txt=new String();
		<?php if(is_array($shistory)): $i = 0; $__LIST__ = $shistory;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>txt+="<div style=\"width:300px;float:left;\">oid:<?php echo ($item["oid"]); ?> <br />";
			txt+="date:<?php echo ($item["sdate"]); ?> <br />";
			var firstDay=new Date(parseInt("<?php echo ($item["sdate"]); ?>".substr(0, 4)), parseInt("<?php echo ($item["sdate"]); ?>".substr(5, 2))-1, 1);
			txt+="#############################<br />";
			txt+="&nbsp;Sun Mon Tue Wed Thu Fri Sat"+"<br />";
			
			var count=0;
			for(var i=0; i<firstDay.getDay(); i++) {
				txt+="&nbsp;&nbsp;&nbsp;.";
				count++;
			}
			var jso=<?php echo ($item["jso"]); ?>;
			for(var i=1; i<=<?php echo ($item["month"]); ?>; i++) {
				count++;
				if(i<10) {
					if(jso[i-1]==1)	{
						txt+="&nbsp;&nbsp;<b>"+i+"</b>.";
					} else {
						txt+="&nbsp;&nbsp;"+i+".";
					}
					
				} else {
					if(jso[i-1]==1)	{
						txt+="&nbsp;<b>"+i+"</b>.";
					} else {
						txt+="&nbsp;"+i+".";
					}
					
				}
				if(count%7==0) {
					txt+="<br />"
				}
				
			} txt+="<br />";
			txt+="#############################<br /></div>";<?php endforeach; endif; else: echo "" ;endif; ?>
		
		document.getElementById("txt").innerHTML=txt;
	</script>
</body>
</html>