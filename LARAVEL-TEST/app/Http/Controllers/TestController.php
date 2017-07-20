<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller {
	public function test() {
		dd(mb_substr("htllo", 0, 1));
		dd(base64_decode("eyJUeXBlIjoxLCJBY3Rpdml0eSI6InRlYW0iLCJUbyI6MiwiQ29udGVudCI6Ijxmb250IHN0eWxlPSdjb2xvcjojNjdiYmZlJz5cdTUzZTRcdTY3MDg8L2ZvbnQ+IFx1NGZlZVx1NjUzOVx1NGU4Nlx1NTZlMlx1OTYxZjxmb250IHN0eWxlPSdjb2xvcjojNjdiYmZlJz5cdTRlZTVcdTUyNGRcdTc2ODRcdTU0MGRcdTViNTc8L2ZvbnQ+XHU3Njg0XHU1NDBkXHU3OWYwXHU0ZTNhPGZvbnQgc3R5bGU9J2NvbG9yOiM2N2JiZmUnPkxPTFx1N2ZhNDwvZm9udD4ifQ=="));
		// $token = "xxx1qazxsw23edcvfr45tgbnhy67ujmxxx";
		// $ws = new WebSocket('10.65.209.164', 12345);
		// $res = $ws->connect();
		$target = ["1", "3", "5"];
		$msg = json_encode([
			// 'Type' => 0,
			// 'From' => $token,
			'Target' => $target,
			'Data' => '您好',
			// 'Data' => json_encode([
			// 	'type' => 1,
			// 	'wwww' => 12312313,
			// 	'cacaca' => 'asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasfsafasfasdfasdfasdfasdfasdfasdfasdfa',
			// ]),
		]);
		$data = [
			'Message' => $msg,
		];
		$header = [
			'X-Token' => 'xxx1qazxsw23edcvfr45tgbnhy67ujmxxx',
		];
		// $msg = '{"Type":0,"From":"xxx1qazxsw23edcvfr45tgbnhy67ujmxxx","Target":["36daa8406876f2ca6e2932f86ff284f4","05f96cce27db1f923e639aa630a21014","029074931287955ff1c8175a23cc5cd1","f238a9951d38327efcbd744dadacf1ab","a2188ef08764eb1db2539d452203bc57","95d6c38270884b2c09da81e5f00c47cb","30eed471b050ac245f7e26e6a6b2d451","743a2b2ea70826a3bcb9a1cc93f521f3"],"Data":"\u60a8\u597d"}';
		// $msg = '{"Type":0,"From":"xxx1qazxsw23edcvfr45tgbnhy67ujmxxx","Target":["36daa8406876f2ca6e2932f86ff284f4","05f96cce27db1f923e639aa630a21014","029074931287955ff1c8175a23cc5cd1","f238a9951d38327efcbd744dadacf1ab","858803d74ab00f41c548f11ca4468df1","95d6c38270884b2c09da81e5f00c47cb","30eed471b050ac245f7e26e6a6b2d451","743a2b2ea70826a3bcb9a1cc93f521f3"],"Data":{"Type":1,"Activity":"team","To":68,"Content":"<font style=\"color:#67bbfe\"><\/font> \u4fee\u6539\u4e86\u56e2\u961f<font style=\"color:#67bbfe\">\u4ee5\u524d\u7684\u540d\u5b57<\/font>\u7684\u540d\u79f0\u4e3a<font style=\"color:#67bbfe\">\u5510\u7684\u56e2\u961f<\/font>"}}';
		// $msg = '{"Type":0,"From":"xxx1qazxsw23edcvfr45tgbnhy67ujmxxx","Target":["e7340228188584649f1489bedef2b542","05f96cce27db1f923e639aa630a21014","029074931287955ff1c8175a23cc5cd1","f238a9951d38327efcbd744dadacf1ab","858803d74ab00f41c548f11ca4468df1","95d6c38270884b2c09da81e5f00c47cb","30eed471b050ac245f7e26e6a6b2d451","dcfaf9ee6fb576afe577965388e44384"],"Data":"{\"Type\":1,\"Activity\":\"team\",\"To\":68,\"Content\":\"<font style=\\\"color:#67bbfe\\\"><\\\/font> \\u4fee\\u6539\\u4e86\\u56e2\\u961f<font style=\\\"color:#67bbfe\\\">\\u4ee5\\u524d\\u7684\\u540d\\u5b57<\\\/font>\\u7684\\u540d\\u79f0\\u4e3a<font style=\\\"color:#67bbfe\\\">\\u5510\\u7684\\u56e2\\u961f<\\\/font>\"}"}';
		// $res = $ws->send($msg);
		$host = 'http://127.0.0.1:12345/s?Message=' . $msg;
		// $host = 'http://127.0.0.1:12345/s';
		// $host = 'http://localhost:8000/api/kong/test';

		$res = $this->__HttpRequest($host, $data, $header);
		dd($res, $msg);
	}

	private function __HttpRequest($url, $data = null, $header = [], $cert = []) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		// curl_setopt($curl, CURLOPT_HEADER, TRUE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		// https
		if ($cert) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //严格校验
			//设置证书
			//使用证书：cert 与 key 分别属于两个.pem文件
			curl_setopt($curl, CURLOPT_SSLCERTTYPE, 'PEM');
			curl_setopt($curl, CURLOPT_SSLCERT, env('WECHAT_SSLCERT_PATH'));
			curl_setopt($curl, CURLOPT_SSLKEYTYPE, 'PEM');
			curl_setopt($curl, CURLOPT_SSLKEY, env('WECHAT_SSLKEY_PATH'));
			curl_setopt($curl, CURLOPT_CAINFO, env('WECHAT_ROOTCA_PATH'));
		}
		// POST
		if (!empty($data)) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		$output = curl_exec($curl);
		$error = curl_error($curl);
		curl_close($curl);
		if (!$error) {
			return $output;
		} else {
			return $error;
		}
	}
}