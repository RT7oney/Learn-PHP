<?php
/*
方倍工作室 http://www.fangbei.org/
CopyRight 2015 All Rights Reserved
 */

define("TOKEN", "weixin");

$wechatObj = new wechatCallbackapiTest();
if (!isset($_GET['echostr'])) {
	$wechatObj->responseMsg();
} else {
	$wechatObj->valid();
}

class wechatCallbackapiTest {
	//验证签名
	public function valid() {
		$echoStr = $_GET["echostr"];
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
		if ($tmpStr == $signature) {
			echo $echoStr;
			exit;
		}
	}

	//响应消息
	public function responseMsg() {
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (!empty($postStr)) {
			$this->logger("R \r\n" . $postStr);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$RX_TYPE = trim($postObj->MsgType);

			//消息类型分离
			switch ($RX_TYPE) {
			case "event":
				$result = $this->receiveEvent($postObj);
				break;
			case "text":
				$result = $this->receiveText($postObj);
				break;
			default:
				$result = "unknown msg type: " . $RX_TYPE;
				break;
			}
			$this->logger("T \r\n" . $result);
			echo $result;
		} else {
			echo "";
			exit;
		}
	}

	//接收事件消息
	private function receiveEvent($object) {
		$content = "";
		switch ($object->Event) {
		case "subscribe":
			$content = "欢迎关注方倍工作室 ";
			break;
		default:
			$content = "receive a new event: " . $object->Event;
			break;
		}

		$result = $this->transmitText($object, $content);
		return $result;
	}

	//接收文本消息
	private function receiveText($object) {

		$keyword = trim($object->Content);

		//自动回复模式
		if (strstr($keyword, "文本")) {
			$content = "这是个文本消息";
		} else if (strstr($keyword, "现金红包")) {
			require 'wxpayall.class.php';
			$money = 101;
			$sender = "方倍";
			$obj2 = array();
			$obj2['wxappid'] = APPID;
			$obj2['mch_id'] = MCHID;
			$obj2['mch_billno'] = MCHID . date('YmdHis') . rand(1000, 9999);
			$obj2['client_ip'] = $_SERVER['REMOTE_ADDR'];
			$obj2['re_openid'] = strval($object->FromUserName);
			$obj2['total_amount'] = $money;
			$obj2['total_num'] = 1;
			$obj2['nick_name'] = $sender;
			$obj2['send_name'] = $sender;
			$obj2['wishing'] = "恭喜发财";
			$obj2['act_name'] = "抢地主的红包";
			$obj2['remark'] = "天天有抢";

			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
			$wxHongBaoHelper2 = new WxPay();
			$resultxml = $wxHongBaoHelper2->pay($url, $obj2);
			$resultObj = simplexml_load_string($resultxml, 'SimpleXMLElement', LIBXML_NOCDATA);
			$content = strval($resultObj->return_msg);
		} else if (strstr($keyword, "裂变红包")) {
			require 'wxpayall.class.php';
			$money = 501;
			$sender = "方倍";
			$obj3 = array();
			$obj3['wxappid'] = APPID;
			$obj3['mch_id'] = MCHID;
			$obj3['mch_billno'] = MCHID . date('YmdHis') . rand(1000, 9999);
			// $obj3['client_ip']    		= $_SERVER['REMOTE_ADDR'];
			$obj3['re_openid'] = strval($object->FromUserName);
			$obj3['total_amount'] = $money;
			$obj3['amt_type'] = "ALL_RAND";
			// $obj3['max_value']         	= $money;
			$obj3['total_num'] = 3;
			// $obj3['nick_name']      	= $sender;
			$obj3['send_name'] = $sender;
			$obj3['wishing'] = "恭喜发财";
			$obj3['act_name'] = $sender . "红包";
			$obj3['remark'] = $sender . "红包";

			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
			$wxHongBaoHelper3 = new WxPay();
			$resultxml = $wxHongBaoHelper3->pay($url, $obj3);
			$resultObj = simplexml_load_string($resultxml, 'SimpleXMLElement', LIBXML_NOCDATA);
			$content = strval($resultObj->return_msg);
		} else {
			$content = date("Y-m-d H:i:s", time()) . "\nOpenID：" . $object->FromUserName . "\n技术支持 方倍工作室";
		}

		$result = $this->transmitText($object, $content);
		return $result;
	}

	//回复文本消息
	private function transmitText($object, $content) {
		if (!isset($content) || empty($content)) {
			return "";
		}

		$xmlTpl = "<xml>
    <ToUserName><![CDATA[%s]]></ToUserName>
    <FromUserName><![CDATA[%s]]></FromUserName>
    <CreateTime>%s</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[%s]]></Content>
</xml>";
		$result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);

		return $result;
	}

	//日志记录
	private function logger($log_content) {
		if (isset($_SERVER['HTTP_APPNAME'])) {
			//SAE
			sae_set_display_errors(false);
			sae_debug($log_content);
			sae_set_display_errors(true);
		} else if ($_SERVER['REMOTE_ADDR'] != "127.0.0.1") {
			//LOCAL
			$max_size = 1000000;
			$log_filename = "log.xml";
			if (file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)) {unlink($log_filename);}
			file_put_contents($log_filename, date('Y-m-d H:i:s') . " " . $log_content . "\r\n", FILE_APPEND);
		}
	}
}
?>