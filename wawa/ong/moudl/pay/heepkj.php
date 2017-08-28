<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');



$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$PAYHT  = 'Https://Pay.Heepay.com/ShortPay/SubmitOrder.aspx'; //支付通信地址
$TYID   = 30; //支付方式

$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址


class Aes{
        public static function Encrypt($data,$key){
            $decodeKey = base64_decode($key);
            $iv     = substr($decodeKey,0,16);
            $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $decodeKey, $data, MCRYPT_MODE_CBC, $iv); 

            return $encrypted;
        }

        public static function Decrypt($data,$key){
            $decodeKey = base64_decode($key);
            $data = base64_decode($data);
            $iv = substr($decodeKey,0,16);
            $encrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $decodeKey, $data, MCRYPT_MODE_CBC, $iv); 

            return $encrypted;
        }
    }
    




if( $PLAYFS  == '1'){//充值处理

 /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注


*/

 $MYIN = array( 'agent_id' => $PAYID,
                'timestamp'=>time() *1000,
                 'version' => 1,
           'user_identity' => $DINGID['uid'],
        
     
 
 );

 $CANSHU = argSort( $MYIN );

 $CANSH  = getarray( $CANSHU );

 $encrypt_data = urlencode(base64_encode(Aes::Encrypt($CANSH,$PAYAC['beizhu'])));

  $MYIN['key'] = $PAYKEY;

   $CANSHU = argSort( $MYIN );

 $CANSH  = getarray( $CANSHU );

 $sign= md5(strtolower($CANSH));
 $hy_auth_uid ='';

   $val = qfopen("Https://Pay.Heepay.com/API/ShortPay/ShortPayQueryAuthBanks.aspx?agent_id=".$PAYID."&encrypt_data=".$encrypt_data."&sign=".$sign,'utf-8');

   $xml = simplexml_load_string($val);

     $code = (string)$xml->ret_code;

     if($code == '0000'){

      $redir=(string)$xml->encrypt_data;
        $redirurl=Aes::Decrypt($redir, $PAYAC['beizhu']);

        
        $arr=explode('auth_uid_Info=', $redirurl);

        $auth_uid_Info = $arr['1'];

        if($auth_uid_Info != ''){

           $fa =  explode('_', $auth_uid_Info);

            if($fa){

              $zodd = (count($fa)-1);

              $hy_auth_uid = str_replace(';','',trim($fa[$zodd]));

            }

        }


    }


     $DATA  =  array(  
                     'agent_id' => $PAYID,
                  'device_type' => $SHOUJI ?0:1 ,
                   'notify_url' => $PAYYB,
                   'return_url' => $PAYTB ,
                    'timestamp' => time()*1000,
                  'hy_auth_uid' => $hy_auth_uid,
                      'version' => 1,
                'agent_bill_id' => $DINGID['orderid'],
              'agent_bill_time' => date('YmdHis'),
                   'goods_name' => '购买产品' ,
                    'goods_num' => 1,
                      'pay_amt' => sprintf('%.2f', $DINGID['payjine'] ),
                      'user_ip' =>  ip() ,
                   'ext_param1' => $DINGID['tongyiid'],
                'user_identity' => $DINGID['uid'],
                    
                         
            );
    

     $CANSHU = argSort( $DATA );

     $CANSH  = getarray( $CANSHU );

     $encrypt_data = urlencode(base64_encode(Aes::Encrypt($CANSH,$PAYAC['beizhu'])));

     $DATA['key'] = $PAYKEY;

     

     $CANSHU = argSort( $DATA );
     $CANSH  = getarray( $CANSHU );
   
     $sign= md5(strtolower($CANSH));

     $val = qfopen("http://Pay.heepay.com/ShortPay/SubmitOrder.aspx?agent_id=".$PAYID."&encrypt_data=".$encrypt_data."&sign=".$sign,'utf-8');

     $xml = simplexml_load_string($val);

     $code = (string)$xml->ret_code;

     if($code == '0000'){

    $redir=(string)$xml->encrypt_data;
    $redirurl=Aes::Decrypt($redir, $PAYAC['beizhu']);


    $arr=explode('redirect_url=', $redirurl);
    echo "<script>top.location='".$arr[1]."'</script>";

        exit();

    }else{ 
        
        p($xml );
        
        exit( );


    }

    

}else if($PLAYFS  == '2'){ //异步通信


        $redirurl=Aes::Decrypt($_GET['encrypt_data'], $PAYAC['beizhu']);


        $a = explode("&",$redirurl );

        foreach( $a as $v) {

            $b = explode("=", $v);
            $_GET[trim( $b[0])] = trim($b[1]);
        }

        if( isset( $_GET['agent_id'])){

            

            $DATA = array( 'agent_bill_id' => $_GET['agent_bill_id'],
                         'agent_bill_time' => $_GET['agent_bill_time'],
                                'agent_id' => $PAYID,
                              'ext_param1' => $_GET['ext_param1'],
                              'ext_param2' => $_GET['ext_param2'],
                              'hy_bill_no' => $_GET['hy_bill_no'],
                               'deal_note' => $_GET['deal_note'],
                            'hy_deal_time' => $_GET['hy_deal_time'],
                                 'pay_amt' => $_GET['pay_amt'],
                                'real_amt' => $_GET['real_amt'],
                                  'status' => $_GET['status'],
                                     'key' => $PAYKEY,

            );

        
            $CANSHU = argSort( $DATA );

            $CANSH  = getarray( $CANSHU );

            
             
         
            $KEy =  md5(strtolower($CANSH));


            

            if($_GET['sign'] == $KEy){


                       if($_GET['status'] != 'SUCCESS') exit('error');


                       chongzhifan(  $_GET['hy_bill_no'] , $_GET['real_amt']  ,  $_GET['agent_bill_id'] );

    
                       exit('ok');

          }else exit('error');

     }else exit('error');

    exit('error');

}else if($PLAYFS  == '3'){ //同步返回



        if( isset( $_GET['encrypt_data'] )){ 


            $redirurl=Aes::Decrypt($_GET['encrypt_data'], $PAYAC['beizhu']);

            if( $redirurl ){

                    $a = explode("&",$redirurl );

                    foreach($a as $v) {

                        $b = explode("=", $v);

                        $_GET[trim( $b[0])] = trim($b[1]);
                    }

            }

        }

          
         if( strstr( $_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
          }else { 
                 if(  isset( $_GET['agent_bill_id']) && strlen( $_GET['agent_bill_id'] ) > 10  )
                    msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_GET['agent_bill_id'] ));
                 else msgbox('', WZHOST );
          }

}