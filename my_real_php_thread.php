<?php
##########
$hosts = array("host1.sample.com", "host2.sample.com", "host3.sample.com");
$timeout = 15;
$status = array();
foreach ($hosts as $host) {
	$errno = 0;
	$errstr = "";
	$s = fsockopen($host, 80, $errno, $errstr, $timeout);
	if ($s) {
		$status[$host] = "Connectedn";
		fwrite($s, "HEAD / HTTP/1.0rnHost: $hostrnrn");
		do {
			$data = fread($s, 8192);
			if (strlen($data) == 0) {
				break;
			}
			$status[$host] .= $data;
		} while (true);
		fclose($s);
	} else {
		$status[$host] = "Connection failed: $errno $errstrn";
	}
}
print_r($status);
############
$hosts = array("host1.sample.com", "host2.sample.com", "host3.sample.com");
$timeout = 15;
$status = array();
$sockets = array();
/* Initiate connections to all the hosts simultaneously */
foreach ($hosts as $id => $host) {
	$s = stream_socket_client("
$
$host:80", $errno, $errstr, $timeout,
		STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_CONNECT);
	if ($s) {
		$sockets[$id] = $s;
		$status[$id] = "in progress";
	} else {
		$status[$id] = "failed, $errno $errstr";
	}
}
/* Now, wait for the results to come back in */
while (count($sockets)) {
	$read = $write = $sockets;
	/* This is the magic function - explained below */
	$n = stream_select($read, $write, $e = null, $timeout);
	if ($n > 0) {
		/* readable sockets either have data for us, or are failed
  * connection attempts */
		foreach ($read as $r) {
			$id = array_search($r, $sockets);
			$data = fread($r, 8192);
			if (strlen($data) == 0) {
				if ($status[$id] == "in progress") {
					$status[$id] = "failed to connect";
				}
				fclose($r);
				unset($sockets[$id]);
			} else {
				$status[$id] .= $data;
			}
		}
		/* writeable sockets can accept an HTTP request */
		foreach ($write as $w) {
			$id = array_search($w, $sockets);
			fwrite($w, "HEAD / HTTP/1.0rnHost: "
				. $hosts[$id] . "rnrn");
			$status[$id] = "waiting for response";
		}
	} else {
		/* timed out waiting; assume that all hosts associated
  * with $sockets are faulty */
		foreach ($sockets as $id => $s) {
			$status[$id] = "timed out " . $status[$id];
		}
		break;
	}
}
foreach ($hosts as $id => $host) {
	echo "Host: $hostn";
	echo "Status: " . $status[$id] . "nn";
}
##################
// This value is correct for Linux, other systems have other values
define('EINPROGRESS', 115);
function non_blocking_connect($host, $port, &$errno, &$errstr, $timeout) {
	$ip = gethostbyname($host);
	$s = socket_create(AF_INET, SOCK_STREAM, 0);
	if (socket_set_nonblock($s)) {
		$r = @socket_connect($s, $ip, $port);
		if ($r || socket_last_error() == EINPROGRESS) {
			$errno = EINPROGRESS;
			return $s;
		}
	}
	$errno = socket_last_error($s);
	$errstr = socket_strerror($errno);
	socket_close($s);
	return false;
}
#################
/* @title:   PHP多线程类(Thread)
 * @version:  1.0
 *
 * PHP多线程应用示例：
 * require_once 'thread.class.php';
 * $thread = new thread();
 * $thread->addthread('action_log','a');
 * $thread->addthread('action_log','b');
 * $thread->addthread('action_log','c');
 * $thread->runthread();
 *
 * function action_log($info) {
 *   $log = 'log/' . microtime() . '.log';
 *   $txt = $info . "rnrn" . 'Set in ' . Date('h:i:s', time()) . (double)microtime() . "rn";
 *   $fp = fopen($log, 'w');
 *   fwrite($fp, $txt);
 *   fclose($fp);
 * }
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