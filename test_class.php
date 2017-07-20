<?php
class test {

	public function a() {
		echo "a";
		return $this;
	}

	public function b() {
		echo "b";
		return $this;
	}
}
$test = new test;
test::a()->b();
?>
