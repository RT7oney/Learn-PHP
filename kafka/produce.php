<?php
set_include_path(
	implode(PATH_SEPARATOR, array(
		realpath(__DIR__ . '/../lib'),
		get_include_path(),
	))
);
require 'autoloader.php';
$host = 'localhost';
$port = 9092;
$topic = 'test';
$producer = new Kafka_Producer($host, $port, Kafka_Encoder::COMPRESSION_NONE);
$in = fopen('php://stdin', 'r');
while (true) {
	echo "\nEnter comma separated messages:\n";
	$messages = explode(',', fgets($in));
	foreach (array_keys($messages) as $k) {
		//$messages[$k] = trim($messages[$k]);
	}
	$bytes = $producer->send($messages, $topic);
	printf("\nSuccessfully sent %d messages (%d bytes)\n\n", count($messages), $bytes);
}