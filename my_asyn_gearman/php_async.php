<?php
function my_log($commit = '', $log = '') {
	error_log('[@###' . date('Y-m-d H:i:s') . '###@]-----' . $commit . '---' . $log . "\r\n", 3, "/www/server/logs/php-log/" . date('Ym') . ".log");
}
/*
尽管一个 Web 应用程序的大部分内容都与表示有关，但它的价值与竞争优势却可能体现在若干专有服务或算法方面。如果这类处理过于复杂或拖沓，最好是进行异步执行，以免 Web 服务器对传入的请求没有响应。实际上，将一个计算密集型的或专门化的功能放在一个或多个独立的专用服务器上运行，效果会更好。
常用的缩略词
API：应用程序编程接口
HTTP：超文本传输协议
LAMP：Linux、Apache、MySQL 与 PHP
PHP 的 Gearman 库能把工作分发给一组机器。Gearman 会对作业进行排队并少量分派作业，而将那些复杂的任务分发给为此任务预留的机器。这个库对 Perl、Ruby、C、Python 及 PHP 开发人员均可用，并且还可以运行于任何类似 UNIX® 的平台上，包括 Mac OS X、 Linux® 和 Sun Solaris。
向一个 PHP 应用程序添加 Gearman 非常简单。假设您将 PHP 应用程序托管在一个典型的 LAMP 配置上，那么 Gearman 将需要一个额外的守护程序以及一个 PHP 扩展。截止到 2009 年 11 月，Gearman 守护程序的最新版本是 0.10，并且有两个 PHP 扩展可以用 — 一个用 PHP 包裹了 Gearman C 库，另一个用纯 PHP 编写。我们要用的是前者。它的最新版本是 0.6.0，可以从 PECL 或 Github（参见 参考资料）获取它的源代码。
请注意：对于本文而言，producer 指的是生成工作请求的机器；consumer 是执行工作的机器；而 agent 则是连接 producer 与适当 consumer 的中介。
 */
/*
安装 Gearman
向一个机器添加 Gearman 需要两步：第一步构建并启动这个守护程序，第二步构建与 PHP 版本相匹配的 PHP 扩展。这个守护程序包包括构建此扩展所需的所有库。
 */
require_once 'PHPAsyncClient.php';
date_default_timezone_set('Asia/Shanghai');

class AsyncTest {

	const LOG_FILE = '/debug.log';

	static public function run() {
		if (PHPAsyncClient::in_callback(__FILE__)) {
			my_log('php Async callback');
			PHPAsyncClient::parse();
			return;
		}
		if (PHPAsyncClient::is_main(__FILE__)) {
			my_log('main run');
			$async_call = PHPAsyncClient::getInstance();
			$async_call->AsyncCall('AsyncTest', 'callback', array(
				'content' => 'Hello World!!!',
			), array(
				'class' => 'AsyncTest',
				'method' => 'callback',
				'params' => array(
					'content' => 'Hello Callback!',
				),
			), __FILE__);
			return;
		}
	}

	static public function callback($args) {
		my_log('AsyncTest callback run');
		my_log('AsyncTest callback args:' . print_r($args, true));
	}

	// static public function log($content) {
	// 	$fullname = dirname(__FILE__) . self::LOG_FILE;
	// 	$content = date('[Y-m-d H:i:s]') . $content . "\n";
	// 	file_put_contents($fullname, $content, FILE_APPEND);
	// }
}

// AsyncTest::run();
print_r(gearman_version());