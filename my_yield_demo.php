<?php
// echo microtime();
// echo "\r\n";
// echo time();
// $dateStart = time();

// define('__LOG__', '/www/server/logs/test/test.log');

// function gen_one_to_three() {
// 	for ($i = 1; $i <= 3; $i++) {
// 		//注意变量$i的值在不同的yield之间是保持传递的。
// 		yield $i;
// 	}
// }

// $generator = gen_one_to_three();
// var_dump($generator);
// foreach ($generator as $value) {
// 	echo "$value\n";
// }

// error_log("Oracle database not available!", 3, __LOG__);

// $dateEnd = time();
// $totalSecond = $dateEnd - $dateStart;
// echo '共执行了' . $totalSecond . '秒';

################

// function &gen_reference() {
// 	$value = 3;

// 	while ($value > 0) {
// 		yield $value;
// 	}
// }

//  // 我们可以在循环中修改$number的值，而生成器是使用的引用值来生成，所以gen_reference()内部的$value值也会跟着变化。

// foreach (gen_reference() as &$number) {
// 	echo (--$number) . '... ';
// }

################

// function count_to_ten() {
// 	yield 1;
// 	yield 2;
// 	yield from[3, 4];
// 	yield fromnew ArrayIterator([5, 6]);
// 	yield fromseven_eight();
// 	yield 9;
// 	yield 10;
// }

// function seven_eight() {
// 	yield 7;
// 	yield fromeight();
// }

// function eight() {
// 	yield 8;
// }

// foreach (count_to_ten() as $num) {
// 	echo "$num ";
// }

#################

// For example yield keyword with 菲波那切数列:

// function getFibonacci() {
// 	$i = 0;
// 	$k = 1; //first fibonacci value
// 	yield $k;
// 	while (true) {
// 		$k = $i + $k;
// 		$i = $k - $i;
// 		yield $k;
// 	}
// }

// $y = 0;

// foreach (getFibonacci() as $fibonacci) {
// 	echo $fibonacci . "\n";
// 	$y++;
// 	if ($y > 300) {
// 		break; // infinite loop prevent
// 	}
// }

###################

// Do not call generator functions directly, that won't work.

function my_transform($value) {
	var_dump($value);
	return $value * 2;
}

function my_function(array $values) {
	foreach ($values as $value) {
		yield my_transform($value);
	}
}

$data = [1, 5, 10];
// my_transform() won't be called inside my_function()
my_function($data);

# my_transform() will be called.
foreach (my_function($data) as $val) {
	// ...
}

######################

class CachedGenerator {
	protected $cache = [];
	protected $generator = null;

	public function __construct($generator) {
		$this->generator = $generator;
	}

	public function generator() {
		foreach ($this->cache as $item) {
			yield $item;
		}

		while ($this->generator->valid()) {
			$this->cache[] = $current = $this->generator->current();
			$this->generator->next();
			yield $current;
		}
	}
}
class Foobar {
	protected $loader = null;

	protected function loadItems() {
		foreach (range(0, 10) as $i) {
			usleep(200000);
			yield $i;
		}
	}

	public function getItems() {
		$this->loader = $this->loader ?: new CachedGenerator($this->loadItems());
		return $this->loader->generator();
	}
}

$f = new Foobar;

# First
print "First\n";
foreach ($f->getItems() as $i) {
	print $i . "\n";
	if ($i == 5) {
		break;
	}
}

# Second (items 1-5 are cached, 6-10 are loaded)
print "Second\n";
foreach ($f->getItems() as $i) {
	print $i . "\n";
}

# Third (all items are cached and returned instantly)
print "Third\n";
foreach ($f->getItems() as $i) {
	print $i . "\n";
}
?>