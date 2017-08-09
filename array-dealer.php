<?php
//一个可以把扁平数组变化成多维数组的算法

$a = [
	[
		'scene_id' => 1,
		'team' => 2,
	],
	[
		'scene_id' => 3,
		'team' => 2,
	],
	[
		'scene_id' => 4,
		'team' => 1,
	],
	[
		'scene_id' => 5,
		'team' => 1,
	],
	[
		'scene_id' => 6,
		'team' => 1,
	],
	[
		'scene_id' => 10,
		'team' => 9,
	],
];
$b = [];

foreach ($a as $k => $value1) {
	foreach ($a as $j => $value2) {
		if ($value1['team'] == $value2['team']) {
			$b[$value1['team']]['team_id'] = $value1['team'];
			$b[$value1['team']]['scene'] = [];
			foreach ($a as $i => $value3) {
				if ($value1['team'] == $value3['team']) {
					array_push($b[$value1['team']]['scene'], [
						'scene_id' => $value3['scene_id'],
					]);
				}
			}
		}
	}
}
print_r($b);
?>