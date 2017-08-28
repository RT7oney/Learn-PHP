<?php 

	$url = isset($_GET['url']) ? $_GET['url'] :'';
	$url = trim($url);
	$key = md5($url.'wuwei');
	echo "<pre>";
	var_dump( $key );
	echo "</pre>";


?>