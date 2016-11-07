<?php
// PHP 多线程的实现方法研究
/*
多线程是java中一个很不错的东西，很多朋友说在php中不可以使用PHP多线程了，其实那是错误的说法PHP多线程实现方法和fsockopen函数有关，下面我们来介绍具体实现程序代码，有需要了解的同学可参考。
当有人想要实现并发功能时，他们通常会想到用fork或者spawn threads，但是当他们发现php不支持多线程的时候，大概会转换思路去用一些不够好的语言，比如perl。
其实的是大多数情况下，你大可不必使用 fork 或者线程，并且你会得到比用 fork 或 thread 更好的性能。
假设你要建立一个服务来检查正在运行的n台服务器，以确定他们还在正常运转。你可能会写下面这样的代码：
 */
// $hosts = array("baidu.com", "taobao.com", "qq.com");
// $timeout = 15;
// $status = array();
// foreach ($hosts as $host) {
// 	$errno = 0;
// 	$errstr = "";
// 	$s = fsockopen($host, 80, $errno, $errstr, $timeout);
// 	if ($s) {
// 		$status[$host] = "Connected \r\n";
// 		fwrite($s, "HEAD / HTTP/1.0rnHost: $host \r\n");
// 		do {
// 			$data = fread($s, 8192);
// 			if (strlen($data) == 0) {
// 				break;
// 			}
// 			$status[$host] .= $data;
// 		} while (true);
// 		fclose($s);
// 	} else {
// 		$status[$host] = "Connection failed: $errno $errstr \r\n";
// 	}
// }
// print_r($status);
/**
它运行的很好，但是在fsockopen()分析完hostname并且建立一个成功的连接（或者延时$timeout秒）之前，扩充这段代码来管理大量服务器将耗费很长时间。
因此我们必须放弃这段代码；我们可以建立异步连接-不需要等待fsockopen返回连接状态。PHP仍然需要解析hostname（所以直接使用ip更加明智），不过将在打开一个连接之后立刻返回，继而我们就可以连接下一台服务器。
有两种方法可以实现；PHP5中可以使用新增的stream_socket_client()函数直接替换掉fsocketopen()。PHP5之前的版本，你需要自己动手，用sockets扩展解决问题。
下面是PHP5中的解决方法：
 */
// $hosts = array("baidu.com", "qq.com", "taobao.com");
// $timeout = 15;
// $status = array();
// $sockets = array();
// /* Initiate connections to all the hosts simultaneously */
// foreach ($hosts as $id => $host) {
// 	$s = stream_socket_client("$host:80", $errno, $errstr, $timeout, STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_CONNECT);
// 	if ($s) {
// 		$sockets[$id] = $s;
// 		$status[$id] = "in progress";
// 	} else {
// 		$status[$id] = "failed, $errno $errstr";
// 	}
// }
// /* Now, wait for the results to come back in */
// while (count($sockets)) {
// 	$read = $write = $sockets;
// 	/* This is the magic function - explained below */
// 	$n = stream_select($read, $write, $e, $timeout);
// 	if ($n > 0) {
// 		/* readable sockets either have data for us, or are failed
//    * connection attempts */
// 		foreach ($read as $r) {
// 			$id = array_search($r, $sockets);
// 			$data = fread($r, 8192);
// 			if (strlen($data) == 0) {
// 				if ($status[$id] == "in progress") {
// 					$status[$id] = "failed to connect";
// 				}
// 				fclose($r);
// 				unset($sockets[$id]);
// 			} else {
// 				$status[$id] .= $data;
// 			}
// 		}
// 		/* writeable sockets can accept an HTTP request */
// 		foreach ($write as $w) {
// 			$id = array_search($w, $sockets);
// 			fwrite($w, "HEAD / HTTP/1.0\r\nHost: " . $hosts[$id] . "\r\n");
// 			$status[$id] = "waiting for response";
// 		}
// 	} else {
// 		/* timed out waiting; assume that all hosts associated
//    * with $sockets are faulty */
// 		foreach ($sockets as $id => $s) {
// 			$status[$id] = "timed out " . $status[$id];
// 		}
// 		break;
// 	}
// }
// foreach ($hosts as $id => $host) {
// 	echo "Host: $host\r\n";
// 	echo "Status: " . $status[$id] . "\n\n";
// }
/*
我们用stream_select()等待sockets打开的连接事件。stream_select()调用系统的select(2)函数来工作：前面三个参数是你要使用的streams的数组；你可以对其读取，写入和获取异常（分别针对三个参数）。stream_select()可以通过设置$timeout（秒）参数来等待事件发生-事件发生时，相应的sockets数据将写入你传入的参数。
下面是PHP4.1.0之后版本的实现，如果你已经在编译PHP时包含了sockets(ext/sockets)支持，你可以使用根上面类似的代码，只是需要将上面的streams/filesystem函数的功能用ext/sockets函数实现。主要的不同在于我们用下面的函数代替stream_socket_client()来建立连接：
 */
// This value is correct for Linux, other systems have other values
// define('EINPROGRESS', 115);
// function non_blocking_connect($host, $port, &$errno, &$errstr, $timeout) {
// 	$ip = gethostbyname($host);
// 	$s = socket_create(AF_INET, SOCK_STREAM, 0);
// 	if (socket_set_nonblock($s)) {
// 		$r = @socket_connect($s, $ip, $port);
// 		if ($r || socket_last_error() == EINPROGRESS) {
// 			$errno = EINPROGRESS;
// 			return $s;
// 		}
// 	}
// 	$errno = socket_last_error($s);
// 	$errstr = socket_strerror($errno);
// 	socket_close($s);
// 	return false;
// }
/*
现在用socket_select()替换掉stream_select()，用socket_read()替换掉fread()，用socket_write()替换掉fwrite()，用socket_close()替换掉fclose()就可以执行脚本了！
PHP5的先进之处在于，你可以用stream_select()处理几乎所有的stream-例如你可以通过include STDIN用它接收键盘输入并保存进数组，你还可以接收通过proc_open()打开的管道中的数据。
 */
/** @title:      PHP多线程类(Thread)
 * @version:    1.0
 * @author:     phper.org.cn < web@phper.org.cn >
 * @published:  2010-11-2
 *
 * PHP多线程应用示例：
 *  require_once 'thread.class.php';
 *  $thread = new thread();
 *  $thread->addthread('action_log','a');
 *  $thread->addthread('action_log','b');
 *  $thread->addthread('action_log','c');
 *  $thread->runthread();
 *
 *  function action_log($info) {
 *      $log = 'log/' . microtime() . '.log';
 *      $txt = $info . "rnrn" . 'Set in ' . Date('h:i:s', time()) . (double)microtime() . "rn";
 *      $fp = fopen($log, 'w');
 *      fwrite($fp, $txt);
 *      fclose($fp);
 *  }
 */
class thread {

	var $hooks = array();
	var $args = array();

	function thread() {
	}

	function addthread($func) {
		$args = array_slice(func_get_args(), 1);
		$this->hooks[] = $func;
		$this->args[] = $args;
		return true;
	}

	function runthread() {
		if (isset($_GET['flag'])) {
			$flag = intval($_GET['flag']);
		}
		if ($flag || $flag === 0) {
			call_user_func_array($this->hooks[$flag], $this->args[$flag]);
		} else {
			for ($i = 0, $size = count($this->hooks); $i < $size; $i++) {
				$fp = fsockopen($_SERVER['HTTP_HOST'], $_SERVER['SERVER_PORT']);
				if ($fp) {
					$out = "GET {$_SERVER['PHP_SELF']}?flag=$i HTTP/1.1rn";
					$out .= "Host: {$_SERVER['HTTP_HOST']}rn";
					$out .= "Connection: Closernrn";
					fputs($fp, $out);
					fclose($fp);
				}
			}
		}
	}
}
?>