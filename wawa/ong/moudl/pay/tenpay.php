<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$PAYHT  = 'https://gw.tenpay.com/gateway/pay.htm'; //支付通信地址
$TYID   = $PAYAC['beizhu']; //支付方式

$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址
if($TYID == '')$TYID = '0';

if( $PLAYFS  == '1'){//充值处理

 /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/   
    $DATA = array( 
                'input_charset' => 'UTF-8',
                    'bank_type' => $TYID,
                  'v_moneytype' => 'CNY',
                         'body' => 'pay',
                      'subject' => 'pay',
                   'return_url' => $PAYTB ,
                   'notify_url' => $PAYYB,
                      'partner' => $PAYID,
                 'out_trade_no' => $DINGID['orderid'],
                    'total_fee' => $DINGID['payjine'] *100,
                     'fee_type' => 1,
             'spbill_create_ip' => ip(),

            );

            $CANSHU = argSort( $DATA );
    $CANSH  = getarray( $CANSHU );



    $DATA['sign'] = strtoupper ( md5( $CANSH. '&key='.$PAYKEY  ));

 

    $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$PAYHT."' method='post'>";

           while ( list ( $key, $val ) = each ( $DATA ) ) {

                   $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";

           }

     $sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";

     $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

     echo  $sHtml;

}else if($PLAYFS  == '2'){ //异步通信

  
    if( isset( $_GET['out_trade_no'])){

        $keyy = $_GET['sign'] ;

        unset( $_GET['sign'] );

        $CANSHU = argSort( $_GET );
        $CANSH  = getarray( $CANSHU );

        $key = strtoupper ( md5( $CANSH. '&key='.$PAYKEY  ));


        if($key == $keyy ){

            if( $_GET['trade_state'] == '0' && $_GET['trade_mode'] == 1 )chongzhifan( $_GET['transaction_id']  , $_GET['total_fee']/100  , $_GET['out_trade_no'] );

        }



        exit('success');
    }else exit('fail');

     

     

}else if($PLAYFS  == '3'){ //同步返回


    if( strstr($_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
    }else { 
                 if(  isset( $_GET['out_trade_no']) && strlen( $_GET['out_trade_no'] ) > 10  )

                     msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_GET['out_trade_no'] ));
     
                 else msgbox('', WZHOST );
    }

       
}