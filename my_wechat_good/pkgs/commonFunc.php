<?php
// namespace Wechat;
// use Log;

class CommonFunc {

	/**
	 * [common_log 日志记录方法 By Ryan]
	 * @param  [type] $log_data [json 字符串]
	 * @return [type]           [description]
	 */
	public static function write_log($log_data, $commit = '') {
		if (!file_exists('content/plugins/wechat/log/')) {
			mkdir('content/plugins/wechat/log/');
			chmod('content/plugins/wechat/log/', 0777);
		}
		$fd = fopen('content/plugins/wechat/log/' . date('Ym') . '.log', "a");
		$str = "[#@" . date("Y/m/d h:i:s", time()) . "#]---" . $commit . '---' . $log_data;
		fwrite($fd, $str . "\n");
		fclose($fd);
	}

	/**
	 * https请求（支持GET和POST）
	 * @param  [type] $url  [description]
	 * @param  [type] $data [description]
	 * @param  [type] $cert [如果是普通的支付方式请使用1，红包的支付方式使用2]
	 * @return [type]       [description]
	 */
	public static function https_request($url, $data = null, $cert = 0) {

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		if ($cert == 1) {
			$PEM_1 = TRUE;
			$PEM_2 = 2;
		} elseif ($cert == 2) {
			$PEM_1 = FALSE;
			$PEM_2 = FALSE;
		}
		if ($cert) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $PEM_1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $PEM_2); //严格校验

			// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //严格校验

			//设置header
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
			//要求结果为字符串且输出到屏幕上
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
			curl_setopt($curl, CURLOPT_SSLCERT, env('WECHAT_SSLCERT_PATH'));
			curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
			curl_setopt($curl, CURLOPT_SSLKEY, env('WECHAT_SSLKEY_PATH'));
			curl_setopt($curl, CURLOPT_CAINFO, env('WECHAT_ROOTCA_PATH'));
		} else {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		}

		if (!empty($data)) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);
		if (!$error) {
			return $output;
		} else {
			return $error;
		}
	}

	/**
	 * 生成定长的随机字符串
	 * @param  [type] $length [随机字符串的长度]
	 * @return [type]  $str   [最终返回结果]
	 */
	public static function nonce_str($length) {
		$str = null;
		$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($strPol) - 1;

		for ($i = 0; $i < $length; $i++) {
			$str .= $strPol[rand(0, $max)];
		}
		return $str;
	}

	/**
	 * 数组转化为xml
	 * @param  [type] $arr [description]
	 * @return [type]      [description]
	 */
	public static function arr_to_xml($arr) {
		$xml = '<xml>';
		foreach ($arr as $key => $value) {
			if (is_numeric($value)) {
				$xml .= '<' . $key . '>' . $value . '</' . $key . '>';
			} else {
				$xml .= '<' . $key . '>' . '<![CDATA[' . $value . ']]>' . '</' . $key . '>';
			}
		}
		$xml .= '</xml>';
		return $xml;
	}

	/**
	 * xml转化为数组
	 * @param [type] $xml [description]
	 * @return [type]      [description]
	 */
	public function xml_to_arr($xml) {
		libxml_disable_entity_loader(true);
		$arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $arr;
	}

}