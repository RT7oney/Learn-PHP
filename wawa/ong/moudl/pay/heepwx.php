<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');



$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$PAYHT  = 'https://pay.heepay.com/Payment/Index.aspx'; //支付通信地址
$TYID   = 30; //支付方式

$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址

if( $PLAYFS  == '1'){//充值处理

 /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/

     $DATA  =  array(  'version' => 1,
	                 'is_frame' => strstr($_SERVER['HTTP_USER_AGENT'], "essenger")?1:0,
	                 'pay_type' => $TYID ,
	                 'pay_code' => '',
	                 'agent_id' => $PAYID,
	                 'agent_bill_id' => $DINGID['orderid'] ,
	                 'pay_amt' =>sprintf('%.2f', $DINGID['payjine'] ),
	                 'notify_url' => $PAYYB,
	                 'return_url' => $PAYTB ,
	                  'user_ip' => str_replace('.','_',ip()),
	                  'agent_bill_time' => date('YmdHis'),
	                  'goods_name' => urlencode(  '购买产品'),
	                  'remark' =>  $DINGID['tongyiid'],
	                  //'is_test' =>1,
	                  'goods_note'=>'',
	      
	   
   
   );

   if($SHOUJI)$DATA['is_phone'] = 1;


    $sign_str = '';
	$sign_str  = $sign_str . 'version=' . $DATA['version'];
	$sign_str  = $sign_str . '&agent_id=' .$DATA['agent_id'];
	$sign_str  = $sign_str . '&agent_bill_id=' . $DATA['agent_bill_id'];
	$sign_str  = $sign_str . '&agent_bill_time=' . $DATA['agent_bill_time'];
	$sign_str  = $sign_str . '&pay_type=' . $DATA['pay_type'];
	$sign_str  = $sign_str . '&pay_amt=' . $DATA['pay_amt'];
	$sign_str  = $sign_str .  '&notify_url=' . $DATA['notify_url'];
	$sign_str  = $sign_str . '&return_url=' . $DATA['return_url'];
	$sign_str  = $sign_str . '&user_ip=' . $DATA['user_ip'];
    //$sign_str  = $sign_str . '&is_test=' . $DATA['is_test'];
	$sign_str = $sign_str . '&key='.$PAYKEY;

	$DATA['sign'] =md5($sign_str );
  

$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$PAYHT."' method='get'>";
					while (list ($key, $val) = each ($DATA)) {
								$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
					}
				$sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";
				$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

				
				echo  $sHtml;
    

}else if($PLAYFS  == '2'){ //异步通信

        
        if(isset( $_GET['agent_id'])){
             
            $signStr='';
            $signStr  = $signStr . 'result=' . $_GET['result'];
            $signStr  = $signStr . '&agent_id=' . $PAYID;
            $signStr  = $signStr . '&jnet_bill_no=' . $_GET['jnet_bill_no'];
            $signStr  = $signStr . '&agent_bill_id=' . $_GET['agent_bill_id'];
            $signStr  = $signStr . '&pay_type=' . $_GET['pay_type'];
            $signStr  = $signStr . '&pay_amt=' . $_GET['pay_amt'];
            $signStr  = $signStr .  '&remark=' . $_GET['remark'];
            $signStr = $signStr . '&key=' . $PAYKEY; 
            $KEy =  md5($signStr);

          if($_GET['sign'] == $KEy){


                       if($_GET['result'] != '1') exit('error');


                       chongzhifan(  $_GET['jnet_bill_no'] , $_GET['pay_amt']  ,  $_GET['agent_bill_id'] );
			  
			          

	
                       exit('ok');

	      }else exit('error');

	 }else exit('error');

     
          


      exit('success');



}else if($PLAYFS  == '3'){ //同步返回

          
         if( strstr( $_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
          }else { 
                if(  isset( $_GET['agent_bill_id']) && strlen( $_GET['agent_bill_id'] ) > 10  )
                    msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_GET['agent_bill_id'] ));
                else msgbox('', WZHOST );
          }

}