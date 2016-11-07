<?php
// 需要安装php  thread扩展，但是我在使用下载之后的pthread源码进行编译那装的时候，出现问题
// 提示如下：
// checking for ZTS... configure: error: pthreads requires ZTS, please re-compile PHP with ZTS enabled
// 主要是因为在PHP安装的时候没有编译安装
// 没有加入 --enable-maintainer-zts   ，这个必须要重新编译php，不能动态加载的！
// 于是我重新编译了php，在原来的编译参数基础上那个加入了  --enable-maintainer-zts ，重新编译安装php即可！
class test_thread_run extends Thread {
	public $url;
	public $data;

	public function __construct($url) {
		$this->url = $url;
	}

	public function run() {
		if (($url = $this->url)) {
			$this->data = model_http_curl_get($url);
		}
	}
}

function model_thread_result_get($urls_array) {
	foreach ($urls_array as $key => $value) {
		$thread_array[$key] = new test_thread_run($value["url"]);
		$thread_array[$key]->start();
	}

	foreach ($thread_array as $thread_array_key => $thread_array_value) {
		while ($thread_array[$thread_array_key]->isRunning()) {
			usleep(10);
		}
		if ($thread_array[$thread_array_key]->join()) {
			$variable_data[$thread_array_key] = $thread_array[$thread_array_key]->data;
		}
	}
	return $variable_data;
}

function model_http_curl_get($url, $userAgent = "") {
	$userAgent = $userAgent ? $userAgent : 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2)';
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 5);
	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

for ($i = 0; $i < 100; $i++) {
	$urls_array[] = array("name" => "baidu", "url" => "http://www.baidu.com/s?wd=" . mt_rand(10000, 20000));
}

$t = microtime(true);
$result = model_thread_result_get($urls_array);
$e = microtime(true);
echo "多线程：" . ($e - $t) . "\n";

$t = microtime(true);
foreach ($urls_array as $key => $value) {
	$result_new[$key] = model_http_curl_get($value["url"]);
}
$e = microtime(true);
echo "For循环：" . ($e - $t) . "\n";
?>