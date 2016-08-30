<?php
include_once "WxPayPubHelper/WxPayPubHelper.php";

//使用统一支付接口
$unifiedOrder = new UnifiedOrder_pub();

//设置统一支付接口参数
//设置必填参数
//appid已填,商户无需重复填写
//mch_id已填,商户无需重复填写
//noncestr已填,商户无需重复填写
//spbill_create_ip已填,商户无需重复填写
//sign已填,商户无需重复填写
$unifiedOrder->setParameter("body", "H5支付测试"); //商品描述
$timeStamp = time();
$out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
$unifiedOrder->setParameter("out_trade_no", "$out_trade_no"); //商户订单号
$unifiedOrder->setParameter("total_fee", "1"); //总金额
$unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL); //通知地址
$unifiedOrder->setParameter("trade_type", "WAP"); //交易类型
//非必填参数，商户可根据实际情况选填
$unifiedOrder->setParameter("device_info", "100001"); //设备号
//    <attach>支付测试</attach>
//    <detail><![CDATA[{ "goods_detail":[ { "goods_id":"iphone6s_16G", "wxpay_goods_id":"1001", "goods_name":"iPhone6s 16G", "quantity":1, "price":528800, "goods_category":"123456", "body":"苹果手机" }, { "goods_id":"iphone6s_32G", "wxpay_goods_id":"1002", "goods_name":"iPhone6s 32G", "quantity":1, "price":608800, "goods_category":"123789", "body":"苹果手机" } ] }]]></detail>
// <openid>oUpF8uMuAJO_M2pxb1Q9zNjWeS6o</openid>
$prepay_id = $unifiedOrder->getPrepayId();

echo 'prepay_id:------';
var_dump($prepay_id);
$xxmmll = `<xml>
  <body><![CDATA[H5支付测试]]></body>
  <out_trade_no><![CDATA[wx37d859274649e66e1470723248]]></out_trade_no>
  <total_fee>1</total_fee>
  <notify_url><![CDATA[http://192.168.1.113/php/wechat-pay-3.3.6demo/PHP/demo/notify_url.php]]></notify_url>
  <trade_type><![CDATA[WAP]]></trade_type>
  <device_info>100001</device_info>
  <appid><![CDATA[wx37d859274649e66e]]></appid>
  <mch_id>1305518201</mch_id>
  <spbill_create_ip><![CDATA[192.168.1.113]]></spbill_create_ip>
  <nonce_str><![CDATA[9le4ae52oceil9i2tt1ev1ta1wfpdyud]]></nonce_str>
  <sign><![CDATA[5C97AD33B964B7729F416329E6DB2A3C]]></sign>
</xml>`;
$ex = `<xml>
   <appid>wx2421b1c4370ec43b</appid>
   <attach>支付测试</attach>
   <body>JSAPI支付测试</body>
   <mch_id>10000100</mch_id>
   <detail><![CDATA[{ "goods_detail":[ { "goods_id":"iphone6s_16G", "wxpay_goods_id":"1001", "goods_name":"iPhone6s 16G", "quantity":1, "price":528800, "goods_category":"123456", "body":"苹果手机" }, { "goods_id":"iphone6s_32G", "wxpay_goods_id":"1002", "goods_name":"iPhone6s 32G", "quantity":1, "price":608800, "goods_category":"123789", "body":"苹果手机" } ] }]]></detail>
   <nonce_str>1add1a30ac87aa2db72f57a2375d8fec</nonce_str>
   <notify_url>http://wxpay.weixin.qq.com/pub_v2/pay/notify.v2.php</notify_url>
   <openid>oUpF8uMuAJO_M2pxb1Q9zNjWeS6o</openid>
   <out_trade_no>1415659990</out_trade_no>
   <spbill_create_ip>14.23.150.211</spbill_create_ip>
   <total_fee>1</total_fee>
   <trade_type>JSAPI</trade_type>
   <sign>0CB01533B8C1EF103065174F50BCA001</sign>
</xml>`;

/**
 *  作用：post请求xml
 */
function postXml() {
	$xml = $this->createXml();
	// echo $xml;die;
	$this->response = $this->postXmlCurl($xml, $this->url, $this->curl_timeout);
	var_dump($this->response);die;
	return $this->response;
}
/**
 *  作用：设置标配的请求参数，生成签名，生成接口参数xml
 */
function createXml() {
	$this->parameters["appid"] = WxPayConf_pub::APPID; //公众账号ID
	$this->parameters["mch_id"] = WxPayConf_pub::MCHID; //商户号
	$this->parameters["nonce_str"] = $this->createNoncestr(); //随机字符串
	$this->parameters["sign"] = $this->getSign($this->parameters); //签名
	return $this->arrayToXml($this->parameters);
}
/**
 *  作用：array转xml
 */
function arrayToXml($arr) {
	$xml = "<xml>";
	foreach ($arr as $key => $val) {
		if (is_numeric($val)) {
			$xml .= "<" . $key . ">" . $val . "</" . $key . ">";

		} else {
			$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
		}

	}
	$xml .= "</xml>";
	return $xml;
}

/**
 *  作用：以post方式提交xml到对应的接口url
 */
function postXmlCurl($xml, $url, $second = 30) {
	//初始化curl
	$ch = curl_init();
	//设置超时
	curl_setopt($ch, CURLOPT_PROXY, $second);
	//这里设置代理，如果有的话
	//curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
	//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	//设置header
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	//post提交方式
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	//运行curl
	$data = curl_exec($ch);
	// curl_close($ch); fixed By Ryan
	//返回结果
	if ($data) {
		curl_close($ch);
		return $data;
	} else {

		$error = curl_errno($ch);
		echo "curl出错，错误码:$error" . "<br>";
		echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
		curl_close($ch);
		return false;
	}
}
