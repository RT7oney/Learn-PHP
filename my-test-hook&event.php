<?php
/**
 * 关于PHP的钩子类和一些事件机制的案例测试
 *
 * @author Ryan <ryantyler423@gmail.com>
 */
class Event {
	protected static $listeners = array();

	/**
	 * [listen 注册监听事件]
	 * @param [string]   $event    [事件名]
	 * @param [callback] $callback [事件内容]
	 * @param [bool] $once [是否是一次性事件，默认false]
	 */
	public static function listen($event, $callback, $once = false) {
		if (!is_callable($callback)) {
			return false;
		}

		self::$listeners[$event][] = array('callback' => $callback, 'once' => $once);
		return true;
	}

	// 一次性事件
	public static function one($event, $callback) {
		return self::listen($event, $callback, true);
	}

	public static function remove($event, $index = null) {
		if (is_null($index)) {
			unset(self::$listeners[$event]);
		} else {
			unset(self::$listeners[$event][$index]);
		}

	}

	public static function trigger() {
		// 没有参数(传递事件) 退出
		if (!func_num_args()) {
			return;
		}

		// 事件名的数组
		$args = func_get_args();
		// 将函数名(callback)赋给 $event
		$event = array_shift($args);
		// 检测事件是否被注册过，没有则退出
		if (!isset(self::$listeners[$event])) {
			return false;
		}

		foreach (self::$listeners[$event] as $index => $listen) {
			$callback = $listen['callback'];
			$listen['once'] && self::remove($event, $index);
			call_user_func_array($callback, $args);
		}
	}
}

Event::listen('walk', function ($a = '', $b = '') {
	echo "I am walking...n" . $a . $b;
});

Event::trigger('walk');
?>