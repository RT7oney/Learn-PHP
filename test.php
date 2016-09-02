<?php
// $a = array('s' => array(1, 2, 3, 4, 5, 6));
// $a[] = array('q', 'w', 'r', 't', 'y');
// $a[] = array('qweqwe', 'qweqweq', 'sssss', 'aaaa', 'ccccc');
// print_r($a);
//上面代码可以实现数组的拼接
// $image_file = './4296762_165319032930_2.jpg';
// $image_info = getimagesize($image_file);
// $base64_image_content = "data:{$image_info['mime']};base64," . chunk_split(base64_encode(file_get_contents($image_file)));

// //读取文件的方法
// $file_path = 'jichi.jpeg';
// $file_size = filesize($file_path);
// $fp = fread(fopen($file_path, 'rb'), $file_size);
// $img = base64_encode($fp);
// $info = getimagesize('jichi.jpeg');
// $type = str_replace('image/', '', $info['mime']);
// var_dump($type);
// var_dump($img);

// //处理base64数据流
// saveImg($img, $type, 'new_pic' . date('YmdHis', time()));
// function saveImg($img, $type, $name) {
// 	file_put_contents('testimg/' . $name . '.' . $type, base64_decode($img));
// 	return json_encode(array('flag' => 1, 'msg' => 'img/' . $name . '.' . $type));
// }
//
class DesCrypter {
	private $key;
	private $encrypter;
	public function __construct($key = '', $algorithm = MCRYPT_DES, $mode = MCRYPT_MODE_CBC) {
		if (!$key) {
			$this->key = '45683968';
		} else {
			$this->key = $key;
		}
		$this->encrypter = mcrypt_module_open($algorithm, '', $mode, '');
	}
	public function encrypt($origData) {
		$origData = pkcs5padding($origData, mcrypt_enc_get_block_size($this->encrypter));
		mcrypt_generic_init($this->encrypter, $this->key, substr($this->key, 0, 8));
		$ciphertext = mcrypt_generic($this->encrypter, $origData);
		mcrypt_generic_deinit($this->encrypter);
		return $ciphertext;
	}
	public function decrypt($ciphertext) {
		mcrypt_generic_init($this->encrypter, $this->key, substr($this->key, 0, 8));
		$origData = mdecrypt_generic($this->encrypter, $ciphertext);
		mcrypt_generic_deinit($this->encrypter);
		return pkcs5unPadding($origData);
	}
	public function close() {
		mcrypt_module_close($this->encrypter);
	}
}
function pkcs5padding($data, $blocksize) {
	$padding = $blocksize - strlen($data) % $blocksize;
	$paddingText = str_repeat(chr($padding), $padding);
	return $data . $paddingText;
}
function pkcs5unPadding($data) {
	$length = strlen($data);
	$unpadding = ord($data[$length - 1]);
	return substr($data, 0, $length - $unpadding);
}
################DES解密###################
// 3DES方式
$app_key = 'd07fac6c';
$encrypter = new DesCrypter($app_key, MCRYPT_3DES);
// DES 方式
// $encrypter = new DesCrypter();
$data = base64_decode("lG+41O53KaLbKKZrvCWvbTxXrb73MyduvpsYUBW+Ta3g9FDOb8ahQObjRIdDHmVuECULwWboJmS52YwdKvoBZw==");
$result = $encrypter->decrypt($data);
$res = json_decode($result, true);
var_dump($res);
echo '<hr>';
$encrypter->close();
##################签名#######################
$timestamp = time();
$app_key = "d07fac6c";
$sign = md5($app_key . $timestamp);
print_r($timestamp);
echo '<hr>';
print_r($sign);
echo '<hr>';
?>

<!-- 9ecfe3273a04eba562cf95f16cc961f8

1472655189 -->