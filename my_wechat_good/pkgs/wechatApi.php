<?php
/**
 * 微信API封装
 */
require_once "commonFunc.php";

class wechatApi {

	public $appid;
	private $appsecret;
	private $access_token;
	private $jsapi_ticket;

	//构造函数，获取Access Token
	public function __construct() {
		$this->appid = env("WECHAT_APP_ID");
		$this->appsecret = env("WECHAT_APP_SECRET");
		$this->getAccessToken();
		$this->getJsApiTicket();
	}

	public function responseMsg() {

		// CommonFunc::write_log("我到了");
		//响应微信消息的方法
		//1.获取到微信推送过来的post数据（xml 格式）
		if (version_compare(PHP_VERSION, '5.6.0', '<')) {
			if (!empty($GLOBALS['HTTP_RAW_POST_DATA'])) {
				$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
			} else {
				$postArr = file_get_contents('php://input');
			}
		} else {
			$postArr = file_get_contents('php://input');
		}

		CommonFunc::write_log($postArr);

		//2.处理消息类型，并设置回复类型和内容
		$postObj = simplexml_load_string($postArr);
		$fromUser = $postObj->ToUserName;
		$toUser = $postObj->FromUserName;
		$openid = (string) $toUser;
		$time = $postObj->CreateTime;
		$msgType = strtolower($postObj->MsgType);

		//开启SESSION
		$lifeTime = 0.25 * 3600;
		session_id(md5($openid));
		session_set_cookie_params($lifeTime);
		session_start();

		// 测试用，清空SESSION
		// unset($_SESSION[$openid]);
		// $_SESSION[$openid]['on'] = 0;

		$content = '欢迎光临，西木食记录，小二等您很久了！';
		switch ($msgType) {
		//判断消息类型
		case 'event':
			$event = strtolower($postObj->Event);
			if ($event == 'subscribe') {
				$content = "目前菜单：\r\n '西红柿炒鸡蛋' \r\n '土豆丝' \r\n '回锅肉' \r\n 对着公众号说：“点餐”试试看";
			} else if ($event == 'location') {
				$user = $toUser;
				$long = $postObj->Longitude;
				$lat = $postObj->Latitude;
			}
			break;
		case 'text':
			if (isset($_SESSION[$openid]['on']) && $_SESSION[$openid]['on'] === 1) {
				$content = $postObj->Content;
				$content = trim($content);
				if (isset($_SESSION[$openid]['flag']) && $_SESSION[$openid]['flag'] === 1 && $_SESSION[$openid]['food'] !== '') {
					CommonFunc::write_log(json_encode($_SESSION[$openid]), '选份数');

					// 对用户的输入做处理
					if (preg_match('/^[1-9]\d*$/', $content, $res)) {
						// CommonFunc::write_log($res[0], '输入几');
						array_push($_SESSION[$openid]['order'], $_SESSION[$openid]['food'] . 'x' . $res[0]);
						CommonFunc::write_log(json_encode($_SESSION[$openid]), '点好了');
						$_SESSION[$openid]['flag'] = 0;
						$_SESSION[$openid]['food'] = '';
					} else if (preg_match('/0/', $content)) {
						$tips = '已经取消当前菜品：<a>' . $_SESSION[$openid]['food'] . '</a>';
						$_SESSION[$openid]['flag'] = 0;
						$_SESSION[$openid]['food'] = '';
					} else {
						$tips = $content . '什么鬼，当前菜品：<a>' . $_SESSION[$openid]['food'] . '</a>请输入您想要点的份数（阿拉伯数字），取消的话请输入0';
					}

					// 处理购物车订单
					if (count($_SESSION[$openid]['order']) <= 0) {
						CommonFunc::write_log('空的', '');
						$content = "购物车：\r\n 为空，去点菜吧";
					} else {
						CommonFunc::write_log('有的', '');
						$order = implode(" \r\n ", $_SESSION[$openid]['order']);
						CommonFunc::write_log($order, '订单字符串');
						$pay_parm = '?order=';
						foreach ($_SESSION[$openid]['order'] as $key => $value) {
							$pay_parm += $value . '+';
						}
						$pay = "http://www.baidu.com/s" . $pay_parm;
						$content = "购物车：\r\n " . $order . " \r\n 买单请在输入框输入“<a>买单</a>”";
						$_SESSION[$openid]['pay'] = $pay;
					}
					if (isset($tips)) {
						$content = $tips . "\r\n" . $content;
					}
				} else if (preg_match('/买单/', $content)) {
					CommonFunc::write_log('买单', '');
					if (isset($_SESSION[$openid]['pay']) && $_SESSION[$openid]['pay'] !== '') {
						$order = '123123123';
						$content = "订单号：$order \r\n →<a href='" . $_SESSION[$openid]['pay'] . "'>点击付款</a>←";
						$_SESSION[$openid]['on'] = 0;
						$_SESSION[$openid]['flag'] = 0;
						$_SESSION[$openid]['food'] = '';
						$_SESSION[$openid]['order'] = array();
						$_SESSION[$openid]['pay'] = '';
					} else {
						$content = "购物车为空，无法买单";
					}
				} else if (preg_match('/取消订单/', $content)) {
					$content = "已取消当前订单";
					$_SESSION[$openid]['on'] = 0;
					$_SESSION[$openid]['flag'] = 0;
					$_SESSION[$openid]['food'] = '';
					$_SESSION[$openid]['order'] = array();
					$_SESSION[$openid]['pay'] = '';
				} else if (preg_match('/购物车/', $content)) {
					if (count($_SESSION[$openid]['order']) <= 0) {
						CommonFunc::write_log('空的', '');
						$content = "购物车：\r\n 为空，去点菜吧";
					} else {
						CommonFunc::write_log('有的', '');
						$order = implode(" \r\n ", $_SESSION[$openid]['order']);
						CommonFunc::write_log($order, '订单字符串');
						$pay_parm = '?order=';
						foreach ($_SESSION[$openid]['order'] as $key => $value) {
							$pay_parm += $value . '+';
						}
						$pay = "http://www.baidu.com/s" . $pay_parm;
						$content = "购物车：\r\n " . $order . " \r\n 买单请在输入框输入“<a>买单</a>”";
						$_SESSION[$openid]['pay'] = $pay;
					}
				} else {
					$content = "请清晰的对着话筒说出您要点的菜品，如果想查看当前订单，请输入“<a>购物车</a>”";
				}
			} else {
				$content = $postObj->Content;
				$content = trim($content);
				#################################################
				if (preg_match('/给爷我发个红包/', $content)) {
					CommonFunc::write_log('发红包', '');
					require_once "wechatPay.php";
					$pay = new wechatPay;
					// 参数
					$data['mch_id'] = env('WECHAT_MCH_ID');
					$data['mch_billno'] = env('WECHAT_MCH_ID') . date('YmdHis') . rand(1000, 9999);
					$data['wxappid'] = env('WECHAT_APP_ID');
					$data['send_name'] = '西木食记';
					$data['re_openid'] = $openid;
					$data['total_amount'] = 100;
					$data['total_num'] = 1;
					$data['wishing'] = '感谢您的点评！欢迎您下次再来！';
					// print_r($_SERVER);die;
					$data['client_ip'] = $_SERVER["SERVER_ADDR"];
					$data['act_name'] = '点评送金';
					$data['remark'] = '您可以再点菜之后可以通过点评订单获得返金红包';
					// 发送红包
					// $res = $pay->sendRedpack($data);
					$res = '';
					if ($res == '发放成功') {
						$content = '请您收下，下回记得再来哦，么么哒~';
					} else {
						$content = '红包已经被领取完了，下次要抓紧哟~';
					}
					#################################################
				} else {
					$content = "想点餐？如果你调戏我，那我只能呵呵了~点餐的话，请使用标准“噗通哗”对公众号语音说：“点餐”试试看";
				}
			}
			break;
		case 'voice':
			$content = $postObj->Recognition;
			$content = trim($content);
			$menu = ['西红柿炒鸡蛋', '土豆丝', '回锅肉'];
			if (preg_match('/点餐/', $content)) {
				if (isset($_SESSION[$openid]['on']) && $_SESSION[$openid]['on'] === 1) {
					$content = "您已经在点餐中····如果需要重新点单，请输入“<a>取消订单</a>”";
				} else {
					$_SESSION[$openid]['on'] = 1;
					$_SESSION[$openid]['flag'] = 0;
					$_SESSION[$openid]['food'] = '';
					$_SESSION[$openid]['order'] = array();
					$_SESSION[$openid]['pay'] = '';
					$content = "请清晰的对着话筒说出您要点的菜品";
				}
			} else {
				// CommonFunc::write_log(json_encode($_SESSION[$openid]), '报菜名');
				if (isset($_SESSION[$openid]['on']) && $_SESSION[$openid]['on'] === 1) {
					for ($i = 0; $i < count($menu); $i++) {
						$no = "现在没这道菜，希望是个美好的东西，你可以稍稍期待一下";
						$_SESSION[$openid]['flag'] = 0;
						$_SESSION[$openid]['food'] = '';
						if (preg_match('/' . $menu[$i] . '/', $content)) {
							$yes = "想吃<a>$menu[$i]？</a>是的话请输入您想要点的份数（阿拉伯数字），不是的话请输入0";
							$_SESSION[$openid]['flag'] = 1;
							$_SESSION[$openid]['food'] = $menu[$i];
							break;
						}
					}
					$content = isset($yes) ? $yes : $no;
				} else {
					$content = "想点餐？如果你调戏我，那我只能呵呵了~点餐的话，请使用标准“噗通哗”对公众号语音说：“点餐”试试看";
				}
			}
			break;
		default:
			break;
		}
		$template = "<xml><ToUserName><![CDATA[" . $toUser . "]]></ToUserName><FromUserName><![CDATA[" . $fromUser . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $content . "]]></Content></xml>";
		echo $template;
		exit;
	}

	public function getOauthCode() {

		$custome_url = env('WECHAT_DOMAIN') . $_SERVER['REQUEST_URI'];
		// $custome_url = env('WECHAT_DOMAIN');
		$scope = 'snsapi_userinfo';
		$oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid . '&redirect_uri=' . urlencode($custome_url) . '&response_type=code&scope=' . $scope . '&state=oauth#wechat_redirect';
		header('Location:' . $oauth_url);
	}

	public function getOauthInfo() {

		$res = CommonFunc::https_request('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->appsecret . '&code=' . $_GET['code'] . '&grant_type=authorization_code');
		// var_dump($res);die;
		$data = json_decode($res, true);
		if (isset($data['openid']) && isset($data['access_token'])) {
			$openid = $data['openid'];
			$oauth_access_token = $data['access_token'];
		}

		if (empty($openid)) {
			echo ('授权不对：' . $data['errcode']);
			die;
		} else {
			//获取微信用户基本信息
			$userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $oauth_access_token . "&openid=" . $openid . "&lang=zh_CN";
			$userinfo = json_decode(CommonFunc::https_request($userinfo_url), 1);

			//将用户信息添加至Fuser
			if ($userinfo['openid']) {
				//todo存数据库
				return $userinfo;
			} else {
				die('GET WXUSER ERROR!');
			}
		}
	}

	public function sendTplMsg($data) {

		$json_data = json_encode(array(
			'touser' => $data['openid'],
			'template_id' => 'jN-0BVmUUHRQHKj86ZKeE2CIcz1fCwFMtIN4-aNU5VU',
			'topcolor' => '#FF0000',
			'data' => array(
				'Order' => array('value' => $data['order'], 'color' => '#173177'),
				'Time' => array('value' => $data['time'], 'color' => '#173177'),
				'Price' => array('value' => $data['price'], 'color' => '#173177'),
				'Return' => array('value' => $data['return'], 'color' => '#173177'),
			),
		));
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $this->access_token;
		$res = json_decode(CommonFunc::https_request($url, $json_data), 1);
		// var_dump($res);
		return $res['errcode'] === 0 ? true : false;
	}

	//Access Token
	private function requestAccessToken() {

		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecret";
		$res = json_decode(CommonFunc::https_request($url), true);
		$data['access_token'] = $res["access_token"];
		$data['token_time'] = time() + 7000;
		return $data;
	}

	private function getAccessToken() {

		$data = connection('ximu_wechat')->table('wechat_token')->where('id', 1)->first();
		if ($data) {
			$check = 1;
			$access_token = $data->access_token;
			// var_dump($access_token);die;
			if ($data->token_time < time() || $data->access_token == '0' || $data->access_token == '') {
				$data = $this->requestAccessToken();
				$access_token = $data['access_token'];
				$check = connection('ximu_wechat')->table('wechat_token')->where('id', 1)->update($data);
			}
		} else {
			$data = $this->requestAccessToken();
			$access_token = $data['access_token'];
			$check = connection('ximu_wechat')->table('wechat_token')->insert($data);
		}

		if ($check) {
			$this->access_token = $access_token;
			// return $access_token;
		} else {
			die('access_token数据库出错');
		}
	}

	//Access Token
	private function requestJsApiTicket() {

		// 如果是企业号用以下 URL 获取 ticket
		//$url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$this->access_token";
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=" . $this->access_token;
		$res = json_decode(CommonFunc::https_request($url), 1);
		// var_dump($res);die;
		$data['jsapi_ticket'] = $res["ticket"];
		$data['ticket_time'] = time() + 7000;
		return $data;
	}

	private function getJsApiTicket() {

		$data = connection('ximu_wechat')->table('wechat_token')->where('id', 1)->first();
		if ($data) {
			$check = 1;
			$jsapi_ticket = $data->jsapi_ticket;
			if ($data->ticket_time < time() || $data->jsapi_ticket == '0' || $data->jsapi_ticket == '') {
				$data = $this->requestJsApiTicket();
				$jsapi_ticket = $data['jsapi_ticket'];
				$check = connection('ximu_wechat')->table('wechat_token')->where('id', 1)->update($data);
				// var_dump($check);die;
				// echo '<br>';
			}
		} else {
			$data = $this->requestJsApiTicket();
			$jsapi_ticket = $data['jsapi_ticket'];
			$check = connection('ximu_wechat')->table('wechat_token')->insert($data);
		}

		if ($check) {
			$this->jsapi_ticket = $jsapi_ticket;
			// return $jsapi_ticket;
		} else {
			die('jsapi_ticket数据库出错');
		}
	}

	//微信signpackage
	public function getSignPackage($url) {

		// 注意 URL 一定要动态获取，不能 hardcode.
		//$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		//$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		//$url = 'http://new.denong.com/#/invite';

		$timestamp = time();
		$nonceStr = $this->createNonceStr();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$this->jsapi_ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

		$signature = sha1($string);

		$signPackage = array("appId" => $this->appid, "nonceStr" => $nonceStr, "timestamp" => $timestamp, "url" => $url, "signature" => $signature, "rawString" => $string);
		return $signPackage;
	}

	// 调用客服接口创建客服会话
	public function customerServeice($data) {

		$url = 'https://api.weixin.qq.com/customservice/kfsession/create?access_token=' . $this->access_token;
		$res = CommonFunc::https_request($url, $data);
		return json_decode($res, true);
	}

	//获取关注者列表
	public function getUserList($next_openid = NULL) {

		$url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=" . $this->access_token . "&next_openid=" . $next_openid;
		$res = CommonFunc::https_request($url);
		return json_decode($res, true);
	}

	//获取用户基本信息
	public function getUserInfo($openid) {

		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $this->access_token . "&openid=" . $openid . "&lang=zh_CN";
		$res = CommonFunc::https_request($url);
		return json_decode($res, true);
	}

	//创建菜单
	public function createMenu($data) {

		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $this->access_token;
		$res = CommonFunc::https_request($url, $data);
		return json_decode($res, true);
	}

	//发送客服消息，已实现发送文本，其他类型可扩展
	public function sendCustomMessage($touser, $type, $data) {

		$msg = array('touser' => $touser);
		switch ($type) {
		case 'text':
			$msg['msgtype'] = 'text';
			$msg['text'] = array('content' => urlencode($data));
			break;
		}
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $this->access_token;
		return CommonFunc::https_request($url, urldecode(json_encode($msg)));
	}

	//生成参数二维码
	public function createQrcode($scene_type, $scene_id) {

		switch ($scene_type) {
		case 'QR_LIMIT_SCENE':

			//永久
			$data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
			break;

		case 'QR_SCENE':

			//临时
			$data = '{"expire_seconds": 1800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": ' . $scene_id . '}}}';
			break;
		}
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $this->access_token;
		$res = CommonFunc::https_request($url, $data);
		$result = json_decode($res, true);
		// var_dump($result);die;
		return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . urlencode($result["ticket"]);
	}

	//创建分组
	public function createGroup($name) {

		$data = '{"group": {"name": "' . $name . '"}}';
		$url = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=" . $this->access_token;
		$res = CommonFunc::https_request($url, $data);
		return json_decode($res, true);
	}

	//移动用户分组
	public function updateGroup($openid, $to_groupid) {

		$data = '{"openid":"' . $openid . '","to_groupid":' . $to_groupid . '}';
		$url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=" . $this->access_token;
		$res = CommonFunc::https_request($url, $data);
		return json_decode($res, true);
	}

	//上传多媒体文件
	public function uploadMedia($type, $file) {

		$data = array("media" => "@" . dirname(__FILE__) . '\\' . $file);
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $this->access_token . "&type=" . $type;
		$res = CommonFunc::https_request($url, $data);
		return json_decode($res, true);
	}

	private function createNonceStr($length = 16) {

		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}

}

?>
