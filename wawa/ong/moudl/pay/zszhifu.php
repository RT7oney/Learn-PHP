<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');



/*

请求网址: http://zszhifu.aliapp.com/pay.php
请求参数: POST发送 编码 UTF-8
order 用户订单生成
appid 应用帐号
tyid 充值类型(充值类型)
ztyid 金额面值(点卡的面值)
fst 等于1 直接返回错误嘛 其他返回文字提示
kahao 卡号(点卡卡号传递)
kami 卡密(点卡卡密传递)
beizhu 备注帐号等信息 原样返回
key 通信密码
通信密码算法 md5(appid+tyid+ztyid+order+应用密码+备注帐号等信息)
+ 号是展示连接符号,生成算法时候不要写入
(充值类型 ztyid存在0的可以自定义面值)
tyid:1 微信支付 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:2 支付宝支付 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:3 招商银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:4 中国工商银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:5 中国建设银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:6 中国银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:7 中国农业银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:8 交通银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:9 中信银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:10 中国邮政储蓄银行 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
tyid:11 支付宝支付 ztyid:(1,2,5,10,20,50,80,100,200,300,500,0)
*/

$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$PAYHT  = 'http://zsfaka.cn/pay.php'; //支付通信地址
$TYID   = $PAYAC['beizhu']; //支付方式

$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址


$shezhi = $Mem1->g('shezhi');




if( $PLAYFS  == '1'){//充值处理

 /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/



    if($TYID < 1){



        $URL = $PAYHT.'?zh='.$DINGID['orderid'].'&appid='.$PAYID.'&tyid=1&jine='.$DINGID['payjine'];
        Header("Location: ".$URL);
        exit();
    }




    $DATA = array( 'order' => $DINGID['orderid'] ,
                   'appid' => $PAYID,
                    'tyid' => $TYID ,
                   'ztyid' => $DINGID['payjine'],
                  'beizhu' => $DINGID['tongyiid'] ==''?$DINGID['uid']: $DINGID['tongyiid'],
                   'yburl' => $PAYYB,
                   'tburl' => $PAYTB,
    );


    

    $DATA['key'] = md5( $PAYID .$DATA['tyid'] . $DATA['ztyid'] . $DATA['order'] . $PAYKEY . $DATA['beizhu'] );

    $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$PAYHT."' method='post'>";

           while ( list ( $key, $val ) = each ( $DATA ) ) {

                   $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";

           }

     $sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";

     $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

     echo  $sHtml;

}else if($PLAYFS  == '2'){ //异步通信


      if( isset( $_POST['ordernum'] ) &&  isset( $_POST['off'] ) ){


          $key = md5($PAYID.$_POST['ordernum'].$_POST['usernum'].$_POST['rjine'].$_POST['remark'].$_POST['off'].$_POST['zhen'].$PAYKEY );
          

              if( $_POST['off'] =='2') chongzhifan( $_POST['ordernum']  , $_POST['rjine']  , $_POST['usernum'] );
              

      }

      exit('success');

}else if($PLAYFS  == '3'){ //同步返回

	
  msgbox('', WZHOST );

}