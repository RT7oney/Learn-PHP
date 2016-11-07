<?php
// 4.管道（有名管道）
// 管道是比较常用的多进程通信手段，
// 管道分为无名管道与有名管道，
// 无名管道只能用于具有亲缘关系的进程间通信，
// 而有名管道可以用于同一主机上任意进程。
// 这里只介绍有名管道。
// 下面的例子，子进程写入数据，父进程读取数据。
// 定义管道路径,与创建管道
$pipe_path = '/data/test.pipe';
if (!file_exists($pipe_path)) {
	if (!posix_mkfifo($pipe_path, 0664)) {
		exit("create pipe error!");
	}
}
$pid = pcntl_fork();
if ($pid == 0) {
	// 子进程,向管道写数据
	$file = fopen($pipe_path, 'w');
	while (true) {
		fwrite($file, 'hello world');
		$rand = rand(1, 3);
		sleep($rand);
	}
	exit('child end!');
} else {
	// 父进程,从管道读数据
	$file = fopen($pipe_path, 'r');
	while (true) {
		$rel = fread($file, 20);
		echo "{$rel}\n";
		$rand = rand(1, 2);
		sleep($rand);
	}
}
?>