<?php 
	

	$kk = md5('version=1.0&merid=26100667&mername=常州掌上智慧智能科技有限公司&merorderid=123456789&paymoney=1&productname=1&productdesc=聚合富商品&userid=666&username=张三&email=zs@jhf.com&phone=15800000001&extra=自定义参数无不用填写&custom=1&redirecturl=dd0hbjp4n4ox0hbjp4n4ox0hbjp4n4oxhg');

	echo "<pre>";
	var_dump( $kk );
	echo "</pre>";



?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
</head>
<body>
	<form id="jhfpaysubmit'" name="jhfpaysubmit" action="http://www.jhpay.com/wechat/wechatpay.jsp" method="POST">
	<input type="text" name="version" value="1.0"><br>
	<input type="text" name="merid" value="26100667"><br>
	<input type="text" name="mername" value="常州掌上智慧智能科技有限公司"><br>
	<input type="text" name="merorderid" value="123456789"><br>
	<input type="text" name="paymoney" value="1"><br>
	<input type="text" name="productname" value="1"><br>
	<input type="text" name="productdesc" value="聚合富商品"><br>
	<input type="text" name="userid" value="666"><br>
	<input type="text" name="username" value="张三"><br>
	<input type="text" name="email" value="zs@jhf.com"><br>
	<input type="text" name="phone" value="15800000001"><br>
	<input type="text" name="extra" value="自定义参数无不用填写"><br>
	<input type="text" name="custom" value="1"><br>
	<input type="text" name="redirecturl" value="dd"><br>
	<input type="text" name="md5" value="<?php echo $kk ?>" width="100%" style="width: 600px"><br>

	<input type="submit" name="">
	</form>
</body>
</html>