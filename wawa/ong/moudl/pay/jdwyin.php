<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$PAYHT  = 'https://tmapi.jdpay.com/PayGate'; //支付通信地址
$TYID   = $PAYAC['beizhu']; //支付方式

$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址

if( $PLAYFS  == '1'){//充值处理

 /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/   
    $DATA = array( 'v_mid' => $PAYID,
                   'v_oid' => $DINGID['orderid'],
                'v_amount' => $DINGID['payjine'],
             'v_moneytype' => 'CNY',
                   'v_url' => $PAYTB,
                'pmode_id' => $TYID,
                 'remark2' => $PAYYB 

    

            );



    $DATA['v_md5info'] = strtoupper ( md5( $DATA['v_amount'] .$DATA['v_moneytype'] . $DATA['v_oid'] . $DATA['v_mid'] . $DATA['v_url']. $PAYKEY  ));

    $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$PAYHT."' method='post'>";

           while ( list ( $key, $val ) = each ( $DATA ) ) {

                   $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";

           }

     $sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";

     $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

     echo  $sHtml;

}else if($PLAYFS  == '2'){ //异步通信

    if( isset( $_POST['v_oid'])){

        $key = strtoupper( md5($_POST['v_oid'].$_POST['v_pstatus'].$_POST['v_amount'].$_POST['v_moneytype'].$PAYKEY ));

        if( $key == $_POST['v_md5str']){

              if( $_POST['v_pstatus'] =='20') chongzhifan( $_POST['v_oid']  , $_POST['v_amount']  , $_POST['v_oid'] );

        }


        exit('ok');
    }else exit('error');

     

     

}else if($PLAYFS  == '3'){ //同步返回


    if( strstr($_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
    }else { 
                 if(  isset( $_GET['v_oid']) && strlen( $_GET['v_oid'] ) > 10  )

                    msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_GET['v_oid'] ));
      
                 else msgbox('', WZHOST );
    }

       
}