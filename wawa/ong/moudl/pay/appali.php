<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');


$PAYID  = $PAYAC['payid']  ; //支付的id '2016112303150502'
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$PAYHT  = 'https://openapi.alipay.com/gateway.do'; //支付通信地址
$PAYCX  = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
$TYID   = $PAYAC['beizhu']; //支付方式
$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址


if( $PLAYFS  == '1'){//充值处理

 /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/  

    $DATA = array( 'app_id' => $PAYID, 
                   'method' => 'alipay.trade.app.pay',
                  'charset' => 'utf-8',
                'sign_type' => 'RSA',
                   'format' => 'json',
                'timestamp' => date('Y-m-d H:i:s'),
                  'version' => '1.0',
               'notify_url' => $PAYYB,
    );

   $BIZ_C = array(  'subject' =>  'pay', 
               'out_trade_no' =>  $DINGID['orderid'],
               'total_amount' =>  sprintf('%.2f',  $DINGID['payjine'] ),
            'passback_params' =>  UrlEncode($DINGID['tongyiid']),
               'product_code' => 'QUICK_MSECURITY_PAY',
    );

    $DATA['biz_content'] = json_encode(argSort( $BIZ_C ) ) ;

    $CANSHU = getarray ( argSort( $DATA ) );

    $priKey  =  (file_get_contents(ONGPHP.'moudl/pay/rsa_ali_pkcs8.pem'));//这个函数可用来判断私钥是否

    $res = openssl_get_privatekey($priKey);

    openssl_sign( $CANSHU , $sign , $res );

    $signature = base64_encode($sign);
 
    $DATA= argSort( $DATA );

    $DATA['sign'] =UrlEncode($signature);

    foreach( $DATA as $ww => $vv){

        $DATA[$ww] = UrlEncode($vv);
    }

    exit( json_encode( apptongxin( array( 'data'=> getarray ($DATA) )  ,'200', '1' , 'isapp' ) ) );

}else if($PLAYFS  == '2'){ 

        /* app 异步通信 */

        if( isset( $_POST['out_trade_no']) ){

            $USORID = $_POST['out_trade_no'];  //用户订单编号
            $SJORID = $_POST['trade_no'];      //商家编号
            $JINE   = $_POST['total_amount'];  //充值金额
            $START  = $_POST['trade_status'];  //充值状态
            $NOTID  = $_POST['notify_id'];     //notify_id 
            $PAYZH = $_POST['seller_id'];      //商户帐号

            if( $START == 'TRADE_SUCCESS' ){

                $SIGN = $_POST['sign'];
                unset($_POST['sign']);
                unset($_POST['sign_type']);

                foreach( $_POST as $k => $v ){
                
                    $_POST[$k] = urldecode( $v);

                }

                $canshu = getarray ( argSort( $_POST ) );
                $pu_key =  ( '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB
-----END PUBLIC KEY-----' );

                $res    = openssl_get_publickey( $pu_key );
                $result = (bool)openssl_verify( $canshu , base64_decode( $SIGN ) , $res);

                openssl_free_key($res);

                if( $result ){

                    $fan = sslget($PAYCX.'partner=' . $PAYZH . '&notify_id='.$NOTID );

                    if( preg_match("/true$/i",$fan) )chongzhifan( $SJORID  , $JINE , $USORID );

                }


            }
        }

        exit('success');

}else if($PLAYFS  == '3'){ //同步返回

          if( strstr($_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
          }else { 
                 
                msgbox('', WZHOST );
          }

}