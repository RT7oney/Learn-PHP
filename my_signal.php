<?php
// 3.信号
// 信号是一种系统调用。
// 通常我们用的kill命令就是发送某个信号给某个进程的。
// 具体有哪些信号可以在liunx/mac中运行kill -l查看。
// 下面这个例子中，父进程等待5秒钟，向子进程发送sigint信号。
// 子进程捕获信号，掉信号处理函数处理。
$parentPid = posix_getpid();
echo "parent progress pid:{$parentPid}\n";

// 定义一个信号处理函数
function sighandler($signo) {
	$pid = posix_getpid();
	echo "{$pid} progress,oh no ,I'm killed!\n";
	exit(1);
}

$pid = pcntl_fork();
if ($pid == -1) {
	// 创建失败
	exit("fork progress error!\n");
} else if ($pid == 0) {
	// 子进程执行程序
	// 注册信号处理函数
	declare (ticks = 10);
	pcntl_signal(SIGINT, "sighandler");
	$pid = posix_getpid();
	while (true) {
		echo "{$pid} child progress is running!\n";
		sleep(1);
	}
	exit("({$pid})child progress end!\n");
} else {
	// 父进程执行程序
	$childList[$pid] = 1;
	// 5秒后,父进程向子进程发送sigint信号.
	sleep(5);
	posix_kill($pid, SIGINT);
	sleep(5);
}
echo "({$parentPid})main progress end!\n";
?>