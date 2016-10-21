<?php
function my_log($commit = '', $log = '') {
	error_log('[@###' . date('Y-m-d H:i:s') . '###@]-----' . $commit . '---' . $log . "\r\n", 3, "/www/server/logs/php-log/" . date('Ym') . ".log");
}

/**
 * 1.消息队列
 * 消息队列是存放在内存中的一个队列。
 * 如下代码将创建3个生产者子进程，2个消费者子进程。
 * 这5个进程将通过消息队列通信。
 * 由于消息队列去数据是，只有一个进程能去到，所以不需要额外的锁或信号量。
 */
$parentPid = posix_getpid();
// echo "parent progress pid:{$parentPid}\n";
my_log('父进程的pid:', $parentPid);
$childList = array();
// 创建消息队列,以及定义消息类型(类似于数据库中的库)
$id = ftok(__FILE__, 'm');
// echo $id;
// my_log('ftok的id:', $id);
$msgQueue = msg_get_queue($id);
// print_r($msgQueue);
// my_log('msg_get_queue的msgQueue:', $msgQueue);
const MSG_TYPE = 1;
// 生产者
function producer($commit) {
	global $msgQueue;
	$pid = posix_getpid();
	$repeatNum = 5;
	for ($i = 1; $i <= $repeatNum; $i++) {
		$str = "({$pid})!!!!!! progress create!{$i}";
		my_log($commit . 'producer函数里面的str', $str);
		msg_send($msgQueue, MSG_TYPE, $str);
		// $rand = rand(1, 3);
		// $rand = 3;
		// sleep($rand);
	}
}
// 消费者
function consumer($commit) {
	global $msgQueue;
	$pid = posix_getpid();
	$repeatNum = 6;
	for ($i = 1; $i <= $repeatNum; $i++) {
		$rel = msg_receive($msgQueue, MSG_TYPE, $msgType, 1024, $message);
		my_log($commit . 'consumer函数里面的str(即:message)，以及msgType:' . $msgType, $message);
		echo "{$message} | consumer({$pid}) destroy \n";
		// $rand = rand(1, 3);
		// $rand = 3;
		// sleep($rand);
	}
}
function createProgress($callback, $commit) {
	$pid = pcntl_fork();
	if ($pid == -1) {
		// 创建失败
		exit("fork progress error!\n");
	} else if ($pid == 0) {
		// 子进程执行程序
		$pid = posix_getpid();
		my_log($commit, "生成了子进程:$pid");
		$callback($commit);
		my_log("执行完callback:$callback 准备退出了$pid");
		exit("({$pid})child progress end!\n");
	} else {
		// 父进程执行程序
		my_log($commit, "我是父进程:$pid");
		return $pid;
	}
}
// 3个生产进程
for ($i = 0; $i < 3; $i++) {
	my_log('进入第一个for循环的第' . $i . '次');
	$pid = createProgress('producer', 'producer在第一个for循环里的第' . $i . '次');
	$childList[$pid] = 1;
	echo "create producer child progress: {$pid} \n";
}
// 2个消费进程
for ($i = 0; $i < 2; $i++) {
	my_log('进入第二个for循环的第' . $i . '次');
	$pid = createProgress('consumer', 'consumer在第二个for循环里的第' . $i . '次');
	$childList[$pid] = 1;
	echo "create consumer child progress: {$pid} \n";
}
// 等待所有子进程结束
$i = 1;
while (!empty($childList)) {
	my_log('在第' . $i . '次while循环里的childList', json_encode($childList));
	$childPid = pcntl_wait($status);
	my_log('在第' . $i . '次while循环里，使用pcntl_wait出来的childPid', $childPid);
	if ($childPid > 0) {
		unset($childList[$childPid]);
	}
	$i++;
}
echo "({$parentPid})main progress end!\n";

####################

// $pid = pcntl_fork();
// if ($pid == -1) {
// 	die('could not fork');
// } else if ($pid) {
// 	// we are the parent
// 	echo $pid . PHP_EOL;
// 	pcntl_wait($status);
// 	echo $pid . PHP_EOL;
// 	echo $status . PHP_EOL; //Protect against Zombie children
// } else {
// 	$i = 10;
// 	while ($i--) {
// 		echo $i . PHP_EOL;
// 	}
// 	exit(0); // we are the child
// }

?>