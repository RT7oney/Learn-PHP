<?php
ini_set('date.timezone', 'Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//使用统一支付接口
$input = new WxPayUnifiedOrder();

//设置统一支付接口参数
//设置必填参数
//appid已填,商户无需重复填写
//mch_id已填,商户无需重复填写
//noncestr已填,商户无需重复填写
//spbill_create_ip已填,商户无需重复填写
//sign已填,商户无需重复填写
###############################################################
// $unifiedOrder->setParameter("body", "H5支付测试"); //商品描述
// $timeStamp = time();
// $out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
// $unifiedOrder->setParameter("out_trade_no", "$out_trade_no"); //商户订单号
// $unifiedOrder->setParameter("total_fee", "1"); //总金额
// $unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL); //通知地址
// $unifiedOrder->setParameter("trade_type", "WAP"); //交易类型
// //非必填参数，商户可根据实际情况选填
// $unifiedOrder->setParameter("device_info", "100001"); //设备号
###############################################################
$input->SetBody("H5支付测试");
$input->SetAttach("test");
$input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));
$input->SetTotal_fee("1");
// $input->SetTime_start(date("YmdHis"));
// $input->SetTime_expire(date("YmdHis", time() + 600));
// $input->SetGoods_tag("test");
$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
$input->SetTrade_type("WAP");
// $input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
var_dump($order);die;

/**
 * 	作用：将xml转为array
 */
function xmlToArray($xml) {
	//将XML转为array
	$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	return $array_data;
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