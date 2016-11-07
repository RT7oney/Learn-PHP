<?php
/**
 * 生成一等奖
 * 1.需要在14号上午12点
 * 2.需要在17号上午11点
 * 3.传入一个中奖几率的盐值，然后根据传入的当前时间进行遍历
 * 4.针对传入盐值的中奖几率来
 * @return [bool] [description]
 */
function createWinnerBySalt($time, $salt, $order) {
	$now = date('H:i', $time);
	foreach ($salt as $key => $value) {
		list($begin, $end) = explode('-', $key);
		if ($now > $begin && $now <= $end) {
			if (mt_rand(1, 100) <= $value) {
				$query = $this->db->set('is_pay', 1)->where('order', $order)->update('soco_act_se7en');
				return true;
			}
		}
	}
	return false;
}
?>