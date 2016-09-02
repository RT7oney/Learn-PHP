<?php
class Test {
	public static function example() {
		Hook::exec("string");
		echo "hello<br />";
		Hook::exec("arr");
	}
}
class Hook {
	static public function exec($type, $model = ' ') {
		if ($model = ' ') {
			$m = new hello();
		} else {
			$m = new $model();
		}

		if ($type == 'string') {
			$m->string();
		} elseif ($type == 'arr') {

			$m->arr();
		}
	}
}
//我们只要改动一个外部的hello类 就可以实现对系统内部的控制了。
class hello {
	public function string() {
		$str = "I am a Hook test<br />";
		echo "$str <br />";
	}
	public function arr() {
		$arr = array(1, 2, 3, 4, 5, 6);
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
}
Test::example();
?>