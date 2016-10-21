<?php
/**
 * 抽奖核心算法
 * @param prize array,所有概率不为0且剩余数大于0的奖品数组
 * @return array 单个奖品
 * version 2015.12.21
 * author thinkmad@sina.com
 */
function drawWithArray($prize) {

	if (!$prize) {
		return false;
	}

	$arr_chance = array(); //所有奖品概率
	$arr_delimiter = array(); //中奖区间分界数组
	$full_chance_prize = $nofull_chance_prize = array(); //划分满概率和非满概率数组
	$H = 0; //中奖概率空间

	//划分满概率和非满概率奖品
	foreach ($prize as $item) {
		if ($item['prizeChance'] >= 100) {
			$full_chance_prize[] = $item;
		} else {
			$nofull_chance_prize[$item['prizeID']] = $item;
		}
	}

	//存在满概率奖品，则随机取出一个奖品并返回
	$len = count($full_chance_prize);
	if ($len > 0) {
		$r = mt_rand(0, $len - 1);
		return $full_chance_prize[$r];
	}

	//计算总概率空间O
	$O = count($prize) * 100;

	//计算总中奖空间H并生成概率数组
	foreach ($nofull_chance_prize as $k => $v) {
		$H += $v['prizeChance'];
		$arr_chance[$k] = $v["prizeChance"];
	}

	$R = mt_rand(1, $O);
	if ($R > $H) {
		//R不在中奖空间
		return false;
	} else {
//R落在中奖空间
		asort($arr_chance);
		for ($i = 0; $i < count($arr_chance); $i++) {
			$arr_delimiter[key($arr_chance)] = array_isum($arr_chance, 0, $i + 1);
			next($arr_chance);
		}
		foreach ($arr_delimiter as $key => $val) {
			if ($R <= $val) {
				return $nofull_chance_prize[$key];
			}
		}
	}
}

/**
 * 辅助函数array_isum，计算数组中i起n个数的和
 * @params $input array,要计算的数组
 * @params $start,int,起始位置
 * @params $num,int,个数
 * @return int
 */
function array_isum($input, $start, $num) {
	$temp = array_slice($input, $start, $num);
	return array_sum($temp);
}

function creatWinner($max_time, $max_chance, $time_zone) {
	$max_time = strtotime($max_time);
	$k = $max_chance / $time_zone;
	$c = (-$k) * ($max_time - $time_zone);
	$_c = $k * ($max_time + $time_zone);
	$chance = time() <= $max_time ? ($k * time() + $c) : ((-$k) * time() + $_c);
	// var_dump($chance);
	if (mt_rand(1, 100) < $chance) {
		// 获奖了！
		return true;
	}
	return false;
}

function getSign($token) {

}

function dataEncode($key) {

}
?>