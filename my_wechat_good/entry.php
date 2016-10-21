<?php

global $app;

// use Core\Log;
use Core\Services\Context;

$app->map(['GET', 'POST'], '/index', function (Context $context) {

	require_once "pkgs/wechatApi.php";
	require_once "pkgs/commonFunc.php";

	$wechat = new wechatApi;
	// Log::info('hihihowoeijfoawjef');
	//1.将timestamp,nonce,token按照字典排序
	$timestamp = $_GET['timestamp'];
	$nonce = $_GET['nonce'];
	$token = env("WECHAT_TOKEN", false);
	if ($token === false) {
		throw new \Exception("未配置WECHAT_TOKEN");
	}
	$signature = $_GET['signature'];
	if (isset($_REQUEST['echostr'])) {
		$echostr = $_REQUEST['echostr'];
	}
	$array = array($timestamp, $nonce, $token);
	sort($array); //需要对以上信息进行字典排序

	//2.将排序后的三个参数拼接后用sha1加密
	$tmpstr = implode('', $array);
	$tmpstr = sha1($tmpstr);
	CommonFunc::write_log('来了');

	//3.将加密后的字符串与signature进行对比，判断该请求是否来自于微信
	if ($tmpstr === $signature && isset($echostr)) {
		// Log::info($echostr);
		echo $echostr;
		CommonFunc::write_log('接入');
		exit;
	} else {
		CommonFunc::write_log('回复');
		$wechat->responseMsg();
	}
});

/**
 * 微信授权跳转测试
 */
$app->map(['GET', 'POST'], '/jumptest', function (Context $context) {
	$a = 'eevee/api/wechat/index';
	require_once "pkgs/wechatApi.php";
	require_once "pkgs/commonFunc.php";
	$wechat = new wechatApi;
	if (!isset($_GET['code'])) {
		$wechat->getOauthCode();
		die;
	}
	if (isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == 'oauth')) {
		$userinfo = $wechat->getOauthInfo();
		if ($userinfo) {
			header('Location:' . 'http://www.code.app:8080/#!/login?head=' . $userinfo['headimgurl'] . '&name=' . $userinfo['nickname']);
			die;
			// return $context->status('success', $userinfo);
		}
	}
});

/**
 * 微信红包测试
 */
$app->map(['GET', 'POST'], '/hongbaotest', function (Context $context) {

	require_once "pkgs/wechatPay.php";
	require_once "pkgs/commonFunc.php";
	$pay = new wechatPay;

	#################################################
	// 参数
	$data['mch_id'] = env('WECHAT_MCH_ID');
	$data['mch_billno'] = env('WECHAT_MCH_ID') . date('YmdHis') . rand(1000, 9999);
	$data['wxappid'] = env('WECHAT_APP_ID');
	// $data['send_name'] = '西木食记';
	$data['send_name'] = 'ximu';
	$data['re_openid'] = $_GET['openid'];
	$data['total_amount'] = 101;
	$data['total_num'] = 1;
	// $data['wishing'] = '感谢您的点评！欢迎您下次再来！';
	$data['wishing'] = 'thank you';
	// print_r($_SERVER);die;
	$data['client_ip'] = $_SERVER["SERVER_ADDR"];
	// $data['act_name'] = '点评送金';
	$data['act_name'] = 'send coin';
	// $data['remark'] = '您可以再点菜之后可以通过点评订单获得返金红包';
	$data['remark'] = 'welcome you come back again';
	// 发送红包
	$res = $pay->sendRedpack($data);
	var_dump($res);
	die;
	##################################################
	// $money = 1;
	// $sender = "西木";
	// $obj2 = array();
	// $obj2['wxappid'] = env('WECHAT_APP_ID');
	// $obj2['mch_id'] = env('WECHAT_MCH_ID');
	// $obj2['mch_billno'] = env('WECHAT_MCH_ID') . date('YmdHis') . rand(1000, 9999);
	// $obj2['client_ip'] = $_SERVER['SERVER_ADDR'];
	// $obj2['re_openid'] = $_GET['openid'];
	// $obj2['total_amount'] = $money;
	// $obj2['total_num'] = 1;
	// $obj2['nick_name'] = $sender;
	// $obj2['send_name'] = $sender;
	// $obj2['wishing'] = "恭喜发财";
	// $obj2['act_name'] = "点评的红包";
	// $obj2['remark'] = "祝您用餐愉快";

	// $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
	// $resultxml = $pay->pay($url, $obj2);
	// var_dump($resultxml);die;
	//
	################################
	// <xml>
	//     <nonce_str>
	//         <!CDATA[RzrU3quw1j]>
	//     </nonce_str>
	//     <mch_id>1385373702</mch_id>
	//     <mch_billno>1385373702201610100000060458</mch_billno>
	//     <wxappid>
	//         <!CDATA[wx898f13df6bf0ea41]>
	//     </wxappid>
	//     <send_name>
	//         <!CDATA[ximu]>
	//     </send_name>
	//     <re_openid>
	//         <!CDATA[asdfasdfasdfasdf]>
	//     </re_openid>
	//     <total_amount>1</total_amount>
	//     <total_num>1</total_num>
	//     <wishing>
	//         <!CDATA[thank you]>
	//     </wishing>
	//     <client_ip>
	//         <!CDATA[127.0.0.1]>
	//     </client_ip>
	//     <act_name>
	//         <!CDATA[send coin]>
	//     </act_name>
	//     <remark>
	//         <!CDATA[welcome you come back again]>
	//     </remark>
	//     <sign>
	//         <!CDATA[E94F5D828C55AC8F719A3C7F1CBA09E7]>
	//     </sign>
	// </xml>
});

/**
 * 微信扫码支付测试
 */
$app->map(['GET', 'POST'], '/nativetest', function (Context $context) {
	require_once 'pkgs/wechatPay.php';
	$pay = new wechatPay();
	$url = $pay->nativePay();
	echo 'http://paysdk.weixin.qq.com/example/qrcode.php?data=' . $url;
	// echo `<html>
	// 		<head>
	// 		    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
	// 		    <meta name="viewport" content="width=device-width, initial-scale=1" />
	// 		    <title>微信支付扫码</title>
	// 		</head>
	// 		<body>

	// 			<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;">扫描支付模式二</div><br/>
	// 			<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=$url" style="width:150px;height:150px;"/>

	// 		</body>
	// 	  </html>`;
});

$app->map(['GET', 'POST'], '/jspaytest', function (Context $context) {

	require_once 'pkgs/wechatPay.php';
	$pay = new wechatPay();
	$res = $pay->jsPay($_GET['fee'] * 100);
	// print_r($res);die;
	//
	// ` . $res['jsApiParameters'] . `,
	//
	//
	//
	// ` . $res['editAddress'] . `,
	//
	echo '<html>
		<head>
		    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
		    <meta name="viewport" content="width=device-width, initial-scale=1"/>
		    <title>西木小店订单</title>
		    <script type="text/javascript">
			//调用微信JS api 支付
			function jsApiCall()
			{
				WeixinJSBridge.invoke(
					"getBrandWCPayRequest",
' . $res['jsApiParameters'] . ',
					function(res){
						WeixinJSBridge.log(res.err_msg);
						// alert(res.err_code+res.err_desc+res.err_msg);
					}
				);
			}

			function callpay()
			{
				if (typeof WeixinJSBridge == "undefined"){
				    if( document.addEventListener ){
				        document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);
				    }else if (document.attachEvent){
				        document.attachEvent("WeixinJSBridgeReady", jsApiCall);
				        document.attachEvent("onWeixinJSBridgeReady", jsApiCall);
				    }
				}else{
				    jsApiCall();
				}
			}
			</script>
		</head>
		<body>
			<div align="center">
		    	<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">' . $_GET['fee'] . '元</span>钱</b></font><br/><br/>
			</div>
			<div align="center">
				<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
			</div>
		</body>
	  </html>';

	// 			<script type="text/javascript">
	// 			//获取共享地址
	// 			function editAddress()
	// 			{
	// 				WeixinJSBridge.invoke(
	// 					"editAddress",
	// ' . $res['editAddress'] . ',
	// 					function(res){
	// 						var value1 = res.proviceFirstStageName;
	// 						var value2 = res.addressCitySecondStageName;
	// 						var value3 = res.addressCountiesThirdStageName;
	// 						var value4 = res.addressDetailInfo;
	// 						var tel = res.telNumber;

	// 						alert(value1 + value2 + value3 + value4 + ":" + tel);
	// 					}
	// 				);
	// 			}

	// 			window.onload = function(){
	// 				if (typeof WeixinJSBridge == "undefined"){
	// 				    if( document.addEventListener ){
	// 				        document.addEventListener("WeixinJSBridgeReady", editAddress, false);
	// 				    }else if (document.attachEvent){
	// 				        document.attachEvent("WeixinJSBridgeReady", editAddress);
	// 				        document.attachEvent("onWeixinJSBridgeReady", editAddress);
	// 				    }
	// 				}else{
	// 					editAddress();
	// 				}
	// 			};

	// 			</script>
});

/**
 * 微信支付回调
 */
$app->map(['GET', 'POST'], '/notify', function (Context $context) {
	require_once "pkgs/commonFunc.php";
	if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
		$XML = $GLOBALS['HTTP_RAW_POST_DATA'];
	} else {
		$XML = file_get_contents('php://input');
	}
	CommonFunc::write_log($XML, '进入回调xml');
	$ret = CommonFunc::xml_to_arr($XML);
	CommonFunc::write_log(json_encode($ret), '进入回调arr');

});

/**
 * TEST路由
 */
$app->map(['GET', 'POST'], '/test', function (Context $context) {
	// echo json_encode(array('status' => 'success', 'msg' => $_POST['name'] . ' 你好！'));
	// echo ('hellofasdfasdfa ' . $_POST['name'] . ' from eevee/wechat/test');
	if ($_POST['code'] == 10086) {
		require_once "pkgs/wechatApi.php";
		require_once "pkgs/commonFunc.php";
		$wechat = new wechatApi;
		$data['openid'] = 'oW6IEuF9oUP00Ja7P4LJzvFGvEmY';
		$data['order'] = '我们西木最最棒棒哒哒哒哒，送一份老婆饼不要老婆到北虹路555弄40号，射射';
		$data['time'] = '2016-11-11';
		$data['price'] = '11元';
		$data['return'] = '2b元（敢于放血的才是真男人）';
		if ($wechat->sendTplMsg($data)) {
			echo json_encode(array('status' => 'success', 'msg' => '成功'));
		}
	} else {
		echo json_encode(array('status' => 'failed', 'msg' => '密码不对'));
	}

	//
	// $content = 'jirgou';
	// $menu = ['西红柿炒鸡蛋', '土豆丝', '回锅肉'];
	// // $val = '土豆丝';
	// // var_dump(preg_match('/' . $val . '/', $content));
	// // die;
	// //
	// for ($i = 0; $i < count($menu); $i++) {
	// 	// print_r($menu[$i]);
	// 	// var_dump(preg_match('/' . $menu[$i] . '/', $content));
	// 	// echo '<br>';
	// 	$no = "现在没这道菜，希望是个美好的东西，你可以稍稍期待一下";
	// 	if (preg_match('/' . $menu[$i] . '/', $content)) {
	// 		// echo '1' . '<br>';
	// 		$yes = "想吃$menu[$i]？是的话请输入您想要点的份数（阿拉伯数字），不是的话请输入0";
	// 		break;
	// 	}
	// }
	// $content = isset($yes) ? $yes : $no;
	// echo $content;
	// die;
	//

	//
	// foreach ($menu as $k => $val) {
	// 	// CommonFunc::write_log(json_encode($_SESSION[$openid]), '进入循环');
	// 	print_r($val);
	// 	var_dump(preg_match('/' . $val . '/', $content));
	// 	echo '<br>';
	// 	// if (preg_match('/' . $val . '/', $content)) {
	// 	// 	// echo '1' . '<br>';
	// 	// 	$content = "想吃$val？是的话请输入您想要点的份数（阿拉伯数字），不是的话请输入0";
	// 	// 	break;
	// 	// } else {
	// 	// 	// echo '0' . '<br>';
	// 	// 	$content = "现在没这道菜，希望是个美好的东西，你可以稍稍期待一下";
	// 	// }
	// }
	// echo $content;
	//

	//
	// $content = -1;
	// $a = array();
	// if (preg_match('/^[1-9]\d*$/', $content, $res)) {
	// 	array_push($a, '炸鸡' . 'x' . $res[0]);
	// } else {
	// 	echo 0;die;
	// }
	// print_r($a);
	//

	//
	// $food = implode(" \r\n ", ['回锅肉', '土豆丝', '面条']);
	// $url = 'http://www.baidu.com';
	// $content = "购物车：\r\n " . $food . " \r\n <a href='$url'>去买单</a>";
	// echo $content;
	//

	//
	// require_once "pkgs/wechatApi.php";
	// $wechat = new wechatApi();
	// $access_token = $wechat->getAccessToken();
	// return $context->status('success', [
	// 	"wechat" => 'hihihihih',
	// ]);
	//

	//
	// require_once "pkgs/wechatApi.php";
	// require_once "pkgs/commonFunc.php";
	// $wechat = new wechatApi;
	// $wechat->responseMsg();
	// CommonFunc::write_log('123123');
	//

});
?>


