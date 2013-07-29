<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Insert title here</title>
</head>
<body>
	main:<?php echo (($msg)?($msg):"没有值!"); ?> <br />
	
	<form method="post" action="__URL__/sign">
		<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><input type="checkbox" name="clist[]" value="<?php echo ($item["id"]); ?>" /><?php echo ($item["name"]); ?> <?php echo ($item["description"]); ?> <br /><?php endforeach; endif; else: echo "" ;endif; ?>
		<input type="image" src="/t_test/extra/image/sign.jpg" />
	</form>
</body>
</html>