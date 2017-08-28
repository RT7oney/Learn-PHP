<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
if($SHOUJI )
    $PAYHT  ='https://h5pay.jd.com/jdpay/saveOrder';
else 
    $PAYHT  = 'https://wepay.jd.com/jdpay/saveOrder'; //支付通信地址

$TYID   = $PAYAC['beizhu']; //支付方式


function encryptByPrivateKey($data) {
		$pi_key =  openssl_pkey_get_private(file_get_contents(ONGPHP.'moudl/pay/my_rsa_private_pkcs8_key.pem'));//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
		$encrypted="";
		openssl_private_encrypt($data,$encrypted,$pi_key,OPENSSL_PKCS1_PADDING);//私钥加密
		$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
		return $encrypted;
}


function decryptByPublicKey($data) {
		$pu_key =  openssl_pkey_get_public(file_get_contents(ONGPHP.'moudl/pay/wy_rsa_public_key.pem'));//这个函数可用来判断公钥是否是可用的，可用返回资源id Resource id
		$decrypted = "";

		
		
		$data = base64_decode( $data);
		

		
		openssl_public_decrypt ( $data ,$decrypted,$pu_key );//公钥解密

	

		return $decrypted;
}



function xmljx( $raw_post_data ){

	 $shuju = array();

	 		  
 
	if( $raw_post_data ){

          $xml = $raw_post_data;
          $p   = xml_parser_create();
          xml_parse_into_struct($p, $xml, $vals, $index);
          xml_parser_free( $p );





        if( $vals ){

           

            foreach( $vals as $zhis) $shuju[ strtolower( $zhis['tag'] ) ] = isset( $zhis['value']) ? ($zhis['value']) :'';
		}
		}

		return  $shuju ;

}
/**
 * byte数组与字符串转化类
 */
class ByteUtils {
	
	/**
	 *
	 *
	 *
	 *
	 * 转换一个String字符串为byte数组
	 *
	 * @param $str 需要转换的字符串        	
	 *
	 * @param $bytes 目标byte数组        	
	 *
	 *
	 *
	 */
	public static function getBytes($string) {

        $string =(string)$string;
		$bytes = array ();
		for($i = 0; $i < strlen ( $string ); $i ++) {
			$bytes [] = ord ( $string [$i] );
		}
		return $bytes;
	}
	
	/**
	 *
	 *
	 *
	 *
	 * 转换一个16进制hexString字符串为十进制byte数组
	 *
	 * @param $hexString 需要转换的十六进制字符串        	
	 * @return 一个byte数组
	 *
	 */
	public static function hexStrToBytes($hexString) {

		$hexString = (string) $hexString;


		$bytes = array ();
		for($i = 0; $i < strlen ( $hexString ) - 1; $i += 2) {
			$bytes [$i / 2] = hexdec ( $hexString [$i] . $hexString [$i + 1] ) & 0xff;
		}
		
		return $bytes;
	}
	public static function ascToHex($asc, $AscLen) {
		$i = 0;
		$Hex = array ();
		for($i = 0; 2 * $i < $AscLen; $i ++) {
			
			/* A:0x41(0100 0001),a:0x61(0110 0001),右移4位后都是0001,加0x90等0xa */
			$Hex [$i] = (chr ( $asc [2 * $i] ) << 4);
			if (! (chr ( $asc [2 * $i] ) >= '0' && chr ( $asc [2 * $i] ) <= '9')) {
				$Hex [$i] += 0x90;
			}
			
			if (2 * $i + 1 >= $AscLen) {
				break;
			}
			
			$Hex [$i] |= (chr ( $asc [2 * $i + 1] ) & 0x0f);
			if (! (chr ( $asc [2 * $i + 1] ) >= '0' && chr ( $asc [2 * $i + 1] ) <= '9')) {
				$Hex [$i] += 0x09;
			}
		}
		return $Hex;
	}
	
	/**
	 *
	 *
	 *
	 *
	 * 将十进制字符串转换为十六进制字符串
	 *
	 * @param $string 需要转换字符串        	
	 * @return 一个十六进制字符串
	 *
	 */
	public static function strToHex($string) {
		$hex = "";
		for($i = 0; $i < strlen ( $string ); $i ++) {
			$tmp = dechex ( ord ( $string [$i] ) );
			if (strlen ( $tmp ) == 1) {
				$hex .= "0";
			}
			$hex .= $tmp;
		}
		$hex = strtolower ( $hex );
		return $hex;
	}
	public static function strToBytes($string) {
		$bytes = array ();
		for($i = 0; $i < strlen ( $string ); $i ++) {
			$bytes [] = ord ( $string [$i] );
		}
		return $bytes;
	}
	
	/**
	 *
	 *
	 *
	 *
	 * 将字节数组转化为String类型的数据
	 *
	 * @param $bytes 字节数组        	
	 *
	 * @param $str 目标字符串        	
	 *
	 * @return 一个String类型的数据
	 *
	 */
	public static function toStr($bytes) {
		$str = '';
		foreach ( $bytes as $ch ) {
			$str .= chr ( $ch );
		}
		
		return $str;
	}
	
	// 字符串转16进制
	public static function bytesToHex($bytes) {
		$str = ByteUtils::toStr ( $bytes );
		return ByteUtils::strToHex ( $str );
	}
	
	/**
	 *
	 *
	 *
	 *
	 * 转换一个int为byte数组
	 *
	 * @param $byt 目标byte数组        	
	 *
	 * @param $val 需要转换的字符串        	
	 *
	 *
	 *
	 *
	 */
	public static function integerToBytes($val) {
		$byt = array ();
		$byt [0] = ($val >> 24 & 0xff);
		$byt [1] = ($val >> 16 & 0xff);
		$byt [2] = ($val >> 8 & 0xff);
		$byt [3] = ($val & 0xff);
		return $byt;
	}
	
	/**
	 *
	 *
	 *
	 *
	 * 从字节数组中指定的位置读取一个Integer类型的数据
	 *
	 * @param $bytes 字节数组        	
	 *
	 * @param $position 指定的开始位置        	
	 *
	 * @return 一个Integer类型的数据
	 *
	 *
	 */
	public static function bytesToInteger($bytes, $position) {
		$val = 0;
		$val = $bytes [$position + 3] & 0xff;
		$val <<= 8;
		$val |= $bytes [$position + 2] & 0xff;
		$val <<= 8;
		$val |= $bytes [$position + 1] & 0xff;
		$val <<= 8;
		$val |= $bytes [$position] & 0xff;
		return $val;
	}
	
	/**
	 * 将byte数组 转换为int
	 *
	 * @param
	 *        	b
	 * @param
	 *        	offset 位游方式
	 * @return
	 *
	 *
	 */
	public static function byteArrayToInt($b, $offset) {
		$value = 0;
		for($i = 0; $i < 4; $i ++) {
			$shift = (4 - 1 - $i) * 8;
			$value = $value + ($b [$i + $offset] & 0x000000FF) << $shift; // 往高位游
		}
		return $value;
	}
	
	/**
	 *
	 *
	 *
	 *
	 * 转换一个shor字符串为byte数组
	 *
	 * @param $byt 目标byte数组        	
	 *
	 * @param $val 需要转换的字符串        	
	 *
	 *
	 *
	 *
	 */
	public static function shortToBytes($val) {
		$byt = array ();
		$byt [0] = ($val & 0xff);
		$byt [1] = ($val >> 8 & 0xff);
		return $byt;
	}
	
	/**
	 *
	 *
	 *
	 *
	 * 从字节数组中指定的位置读取一个Short类型的数据。
	 *
	 * @param $bytes 字节数组        	
	 *
	 * @param $position 指定的开始位置        	
	 *
	 * @return 一个Short类型的数据
	 *
	 *
	 */
	public static function bytesToShort($bytes, $position) {
		$val = 0;
		$val = $bytes [$position + 1] & 0xFF;
		$val = $val << 8;
		$val |= $bytes [$position] & 0xFF;
		return $val;
	}
	
	/**
	 * 
	 * @param unknown $hexstr
	 * @return Ambigous <string, unknown>
	 */
	public static function hexTobin($hexstr)
	{
		$n = strlen((string)$hexstr);
		$sbin="";
		$i=0;
		while($i<$n)
		{
			$a =substr($hexstr,$i,2);
			$c = pack("H*",$a);
			if ($i==0){$sbin=$c;}
			else {$sbin.=$c;}
			$i+=2;
		}
		return $sbin;
	}
}

function decrypt4HexStr($data ,$keys ) {
		$hexSourceData = array ();
		
		$hexSourceData = ByteUtils::hexStrToBytes ($data);
	


		

			

		// 解密
		$unDesResult = decrypt2 (ByteUtils::toStr($hexSourceData),$keys);

			


        //echo $unDesResult;
		$unDesResultByte = ByteUtils::getBytes($unDesResult);
		
		$dataSizeByte = array ();
		for($i = 0; $i < 4; $i ++) {
			$dataSizeByte [$i] = $unDesResultByte [$i];
		}
		// 有效数据长度
		$dsb = ByteUtils::byteArrayToInt( $dataSizeByte, 0 );
			
		$tempData = array ();
 		for($j = 0; $j < $dsb; $j++) {
 			$tempData [$j] = $unDesResultByte [4 + $j];
 		}

	

	

	

		return ByteUtils::hexTobin (ByteUtils::bytesToHex ( $tempData ));

}


function encrypt2($input, $key) {
		$size = mcrypt_get_block_size ( 'des', 'ecb' );
		$td = mcrypt_module_open ( MCRYPT_3DES, '', 'ecb', '' );
		$iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
		// 使用MCRYPT_3DES算法,cbc模式
		@mcrypt_generic_init ( $td, $key, $iv );
		// 初始处理
		$data = mcrypt_generic ( $td, $input );
		// 加密
		mcrypt_generic_deinit ( $td );
		// 结束
		mcrypt_module_close ( $td );
		
		return $data;
	}


function decrypt2($encrypted, $key) {
		//$encrypted = base64_decode($encrypted);
		$td = mcrypt_module_open ( MCRYPT_3DES, '', 'ecb', '' ); // 使用MCRYPT_DES算法,cbc模式
		$iv = @mcrypt_create_iv ( mcrypt_enc_get_iv_size ( $td ), MCRYPT_RAND );
		$ks = mcrypt_enc_get_key_size ( $td );
		@mcrypt_generic_init ( $td, $key, $iv ); // 初始处理
		$decrypted = mdecrypt_generic ( $td, $encrypted ); // 解密
		mcrypt_generic_deinit ( $td ); // 结束
		mcrypt_module_close ( $td );
		//$y = TDESUtil::pkcs5Unpad ( $decrypted );
		return $decrypted;
	}

function encrypt2HexStr($keys, $sourceData) {
		$source = array ();

		
		
		// 元数据
		$source = ByteUtils::getBytes ( $sourceData );
		
		// 1.原数据byte长度
		$merchantData = count($source);
		// echo "原数据据:" . htmlspecialchars($sourceData) . "<br/>";
		// echo "原数据byte长度:" . $merchantData . "<br/>";
		// echo "原数据HEX表示:" . ByteUtils::bytesToHex ( $source ) . "<br/>";
		// 2.计算补位
		$x = ($merchantData + 4) % 8;
		$y = ($x == 0) ? 0 : (8 - $x);
		// echo ("需要补位 :" . $y . "<br/>");
		// 3.将有效数据长度byte[]添加到原始byte数组的头部
		$sizeByte = ByteUtils::integerToBytes ( $merchantData );
		$resultByte = array ();
		
		for($i = 0; $i < 4; $i ++) {
			$resultByte [$i] = $sizeByte [$i];
		}
		//var_dump($sizeByte);
		// 4.填充补位数据
		for($j = 0; $j < $merchantData; $j ++) {
			$resultByte [4 + $j] = $source [$j];
		}
		//var_dump($resultByte);
		for($k = 0; $k < $y; $k ++) {
			$resultByte [$merchantData + 4 + $k] = 0x00;
		}
	
		$desdata = encrypt2 ( ByteUtils::toStr ( $resultByte ), $keys );
	
		return ByteUtils::strToHex ( $desdata );
	}






$PAYYB  =WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  =WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址

if( $PLAYFS  == '1'){//充值处理


 /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/   
    $DATA = array(  'version' => 'V2.0',
                   'merchant' => $PAYID,
                   'tradeNum' => $DINGID['orderid'],
                  'tradeName' => 'PAY',
                  'tradeTime' => date('YmdHis'),
                     'amount' => ($DINGID['payjine']*100),
                  'orderType' => 1,
	             'userId' => $DINGID['uid'],
	                'userType'=> 'BIZ',
                   'currency' => 'CNY',
                'callbackUrl' => $PAYTB,
                  'notifyUrl' => $PAYYB ,
                          'ip'=>ip(),
	                'note' => $DINGID['orderid'],
   

    

            );

      

     $CANSHU = argSort($DATA);
          
     $CANSH = getarray($CANSHU);


     foreach($DATA as $k => $v){

         if($k == 'merchant'|| $k == 'version') continue;

         $DATA[$k] =encrypt2HexStr(  base64_decode($PAYKEY), $v);

     
     }

    

     $DATA['sign'] = encryptByPrivateKey(hash ( "sha256", $CANSH));
     
      




 

    $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$PAYHT."' method='post'>";

           while ( list ( $key, $val ) = each ( $DATA ) ) {

                   $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";

           }

     $sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";

     $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

     echo  $sHtml;

}else if($PLAYFS  == '2'){ //异步通信

	$raw_post_data = file_get_contents( 'php://input' , 'r' ); 
    $raw_post_data = $raw_post_data ? $raw_post_data : $GLOBALS['HTTP_RAW_POST_DATA'] ;

	



	$shuju = xmljx( $raw_post_data );




	if( $shuju ){
     
		

		$reqBody = decrypt4HexStr(base64_decode($shuju['encrypt']),base64_decode($PAYKEY));

		


        $cans = xmljx( $reqBody);
		if ( $cans ){

		
		   	unset($cans['jdpay']);


	       $startIndex = strpos($reqBody,"<sign>");
		  $endIndex = strpos($reqBody,"</sign>");
		  $xml;
		
		  if($startIndex!=false && $endIndex!=false){
			$xmls = substr($reqBody, 0,$startIndex);
			$xmle = substr($reqBody,$endIndex+7,strlen($reqBody));
			$xml=$xmls.$xmle;
		  }
 
	      $YZKEY =  hash("sha256", $xml);


			$sign = decryptByPublicKey( $cans['sign'] );
			 
			if($sign == $YZKEY ){


				if( $cans['status'] == '2') chongzhifan( $cans['tradenum']  , $cans['amount']/100  , $cans['tradenum'] ); 

			}
		
		
		}
		


			exit('ok');


	}




			

		


    exit('error');

     

     

}else if($PLAYFS  == '3'){ //同步返回


    if( strstr($_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
    }else { 

		

		$_POST['tradeNum'] = decrypt4HexStr(   $_POST["tradeNum"] ,base64_decode($PAYKEY)  );
		
            if( isset( $_POST['tradeNum']) && strlen( $_POST['tradeNum'] ) > 10  )
                msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_POST['tradeNum'] ));
            else msgbox('', WZHOST );

    }

       
}