<?php
set_time_limit(0);
$ret = saveImg($_POST['img'], $_POST['name'] . date('YmdHis', time()));
echo $ret;
function saveImg($img, $name) {
	preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result);
	$type = $result[2];
	if (!file_exists('img/') && !mkdir('img/', 0777, true)) {
		return json_encode(array('flag' => 0, 'msg' => '创建文件路径失败'));
	}
	file_put_contents('img/' . $name . '.' . $type, base64_decode(str_replace($result[1], '', $img)));
	return json_encode(array('flag' => 1, 'msg' => 'img/' . $name . '.' . $type));
}