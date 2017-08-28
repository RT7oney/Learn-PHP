<?php
//=======================卡类支付和网银支付公用配置==================
//沃通付商户ID
$shunfoo_merchant_id		= '1635';

//沃通付通信密钥
$shunfoo_merchant_key		= '40ed0724513f4588b9fdcf4a3e023579';	//hc6NOTDETVQe9Lgr


//==========================卡类支付配置=============================
//支付的区域 0代表全国通用	
$shunfoo_restrict			= '0';


//接收沃通付下行数据的地址, 该地址必须是可以再互联网上访问的网址
$shunfoo_callback_url		= "http://www.sykeji.cn/wotpay/callback/pay_bank_callback.php";   
$shunfoo_callback_url_muti  = "http://www.xpgpay.com/callback/pay_card_callback_muti.php";

//======================网银支付配置=================================
//接收沃通付网银支付接口的地址
$shunfoo_bank_callback_url	= "http://www.sykeji.cn/index.php";  


//网银支付跳转回的页面地址
$shunfoo_bank_hrefbackurl	= 'http://www.sykeji.cn/index.php';

?>