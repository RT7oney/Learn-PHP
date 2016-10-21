<?php
/**
 * 微信Pay封装
 */
require_once "commonFunc.php";

class wechatPay {

	/**
	 * 发送红包方法
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function sendRedpack($data) {
		$data['nonce_str'] = CommonFunc::nonce_str(10);
		$data['sign'] = $this->paySign($data);
		$xml = CommonFunc::arr_to_xml($data);
		// $xml = $this->arrayToXml($data);
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		$res = CommonFunc::https_request($url, $xml, 2);
		// $res = $this->curl_post_ssl($url, $xml);
		CommonFunc::write_log($res, '红包xml');
		$res = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
		$res = strval($res->return_msg);
		return $res;
	}

	/**
	 * 微信扫码支付
	 * 流程：
	 * 1、调用统一下单，取得code_url，生成二维码
	 * 2、用户扫描二维码，进行支付
	 * 3、支付完成之后，微信服务器会通知支付成功
	 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
	 */
	public function nativePay() {
		ini_set('date.timezone', 'Asia/Shanghai');
		require_once 'lib/WxPay.Api.php';
		require_once "lib/WxPay.NativePay.php";
		$notify = new NativePay();
		// $url1 = $notify->GetPrePayUrl("123456789");//预支付链接
		$input = new WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(env('WECHAT_MCH_ID') . date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 60000));
		$input->SetGoods_tag("test");
		$input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
		// $input->SetNotify_url("http://192.168.1.113/php/my-web-pay/wxpay-of/example/notify.php");
		$input->SetTrade_type("NATIVE");
		$input->SetProduct_id("123456789");
		$result = $notify->GetPayUrl($input);
		$url2 = $result["code_url"];
		return $url2;
	}

	/**
	 * 微信jsapi支付
	 * 注意：
	 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
	 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
	 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
	 */
	public function jsPay($fee) {
		require_once 'lib/WxPay.Api.php';
		require_once 'lib/WxPay.JsApiPay.php';
		//①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid();
		//②、统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("西木食记订单");
		// $input->SetAttach("");
		$input->SetOut_trade_no(env('WECHAT_MCH_ID') . date("YmdHis"));
		$input->SetTotal_fee($fee);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 60000));
		// $input->SetGoods_tag("");
		$input->SetNotify_url(env('WECHAT_NOTIFY'));
		// $input->SetNotify_url("http://192.168.1.113/php/my-web-pay/wxpay-of/example/notify.php");
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		$jsApiParameters = $tools->GetJsApiParameters($order);
		//获取共享收货地址js函数参数
		// $editAddress = $tools->GetEditAddressParameters();
		return $res = array(
			'jsApiParameters' => $jsApiParameters,
			// 'editAddress' => $editAddress,
		);
	}

	/**
	 * 支付签名生成方法
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function paySign($data) {
		ksort($data);
		// 第一步：对参数按照key=value的格式，并按照参数名ASCII字典序排序如下：
		$stringA = '';
		foreach ($data as $key => $value) {
			if ($stringA == '') {
				$stringA .= $key . '=' . $value;
			} else {
				$stringA .= '&' . $key . '=' . $value;
			}
		}
		// print_r($stringA);die;
		// 第二步：拼接API密钥
		$key = env("WECHAT_PAY_KEY");
		$stringSignTemp = "$stringA&key=$key";
		$sign = strtoupper(md5($stringSignTemp));
		return $sign;
	}
}
?>