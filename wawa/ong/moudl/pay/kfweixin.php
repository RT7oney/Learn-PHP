<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');


$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$PAYHT  = 'http://www.faka.la/pay.php'; //支付通信地址
$TYID   = 4; //支付方式

$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址

if( $PLAYFS  == '1'){//充值处理

$DINGID['payjine'] = $DINGID['payjine'] *100;

    $CANSHU = array(  'appid'  => $PAYZH ,
                     'mch_id'  => $PAYID,
                   'nonce_str' => md5( $DINGID['orderid']),
                        'body' => 'PAY',
                      'attach' => $DINGID['tongyiid'] ==''? $DINGID['orderid'] :$DINGID['tongyiid'],
                'out_trade_no' => $DINGID['orderid'],
                   'total_fee' => $DINGID['payjine'],
            'spbill_create_ip' => IP(),
                  'time_start' => date('YmdHis'),
                  'notify_url' => $PAYYB
    );

	$CANSHU['trade_type'] = 'APP';
	$CANSHU = argSort( $CANSHU );
     $CANSH  = getarray( $CANSHU );

     $CANSHU['sign'] = strtoupper( md5( $CANSH . '&key='.$PAYKEY ));

	  $xml ='<xml>';
     foreach( $CANSHU as $k =>$v ) $xml .= "<$k>$v</$k>";
     $xml .='</xml>';

     $fanhui = post($xml,'https://api.mch.weixin.qq.com/pay/unifiedorder?');
     $woqu = str_replace(array('<','>'),'',$fanhui);

     $p = xml_parser_create();
     xml_parse_into_struct($p, $fanhui, $vals, $index);
     xml_parser_free($p);

    

     if( $vals ){

         $shuju = array();

         foreach( $vals as $zhis) $shuju[ strtolower( $zhis['tag'] ) ] = isset( $zhis['value']) ? $zhis['value'] :'';
		

		if( $shuju['return_code'] == 'SUCCESS' ){




			/*

			exit( json_encode ( array( 'appid' => $shuju['appid'],
				                      'mch_id' => $shuju['mch_id'],
				                 'device_info' => $shuju['device_info'],
				                   'nonce_str' => $shuju['nonce_str'],
				                        'sign' => $shuju['sign'],
			                       'prepay_id' =>  $shuju['prepay_id'],
				                  'trade_type' => $shuju['trade_type']
				
			
			
			)));
			
			
			*/



			$payss  = array( 'appid' => $shuju['appid'],
				         'partnerid' => $shuju['mch_id'],
				          'prepayid' => $shuju['prepay_id'],
			               'package' => 'Sign=WXPay',
				          'noncestr' => md5(time().rand(1,9999999) ),
				         'timestamp' => time(),
				
			);

			$payss = argSort( $payss );
            $CANSH  = getarray( $payss );

            $payss['sign'] = strtoupper( md5( $CANSH . '&key='.$PAYKEY ));




			exit( json_encode ( array( 'code' =>  1  , 'data' => $payss )    ));
		
		
		
		
		
		
		
		}else exit( json_encode(  array( 'code' => -1 , 'msg' => $shuju['return_msg'] ) ));

		





	 }else  exit( json_encode(  array( 'code' => -1 , 'msg' => $woqu ) ));


}else if($PLAYFS  == '2'){ //异步通信


	 $raw_post_data = file_get_contents( 'php://input' , 'r' ); 
      $raw_post_data = $raw_post_data ? $raw_post_data : $GLOBALS['HTTP_RAW_POST_DATA'] ;

      if( $raw_post_data ){

          $xml = $raw_post_data;
          $p   = xml_parser_create();
          xml_parse_into_struct($p, $xml, $vals, $index);
          xml_parser_free( $p );

        if( $vals ){

            $shuju = array();

            foreach( $vals as $zhis) $shuju[ strtolower( $zhis['tag'] ) ] = isset( $zhis['value']) ? $zhis['value'] :'';

            unset( $shuju['xml'] );

            $SIGN = $shuju['sign'];

            unset( $shuju['sign'] );

            $CANSHU = argSort($shuju);

            $CANSH = getarray($CANSHU);

            $xcxiay  = strtoupper(md5($CANSH.'&key='.$PAYKEY));

            if(  $xcxiay == $SIGN){

                   chongzhifan( $shuju['transaction_id'] , (int)($shuju['cash_fee']/100) , $shuju['out_trade_no'] );

                   echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';

             }else echo '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[NO]]></return_msg></xml>';

        } else     echo '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[NO]]></return_msg></xml>';

   }else           echo '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[NO]]></return_msg></xml>';






}else if($PLAYFS  == '3'){ //同步返回


	      if( strstr($_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
          }else msgbox('', WZHOST );





}