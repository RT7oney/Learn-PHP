<?php if( !defined( 'ONGPHP')) exit( 'Error OngSoft');

function isemail($data){

        /*验证邮箱*/
        return preg_match('/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/',$data);

}


function isshouji($data){

        /*验证手机*/
        return preg_match('/^1\d{10}$/',$data);
}


function duanxin( $shouji , $shuju ){

        /* 1 注册通知
           2 找回通知
           3 绑定通知
           4 购买通知
           5 发货通知
           6 确认通知
        */


        //return 'success:11111';

        $neirong = '';
        $IP = IP();
        $DUQU = include QTLANG ;
        if(!isset( $shuju['type'] )) $shuju['type'] = 1;
        if(!isset( $shuju['YZM'] )) $shuju['YZM'] = '';
        if(!isset( $shuju['ZH'] )) $shuju['ZH'] = '';
        if(!isset( $shuju['NC'] )) $shuju['NC'] = '';
        if(!isset( $shuju['DDID'] )) $shuju['DDID'] = '';
        if(!isset( $shuju['IP'] )) $shuju['IP'] = '';
        if(!isset( $shuju['TIME'] )) $shuju['TIME'] = '';
        if(!isset( $shuju['KDFS'] )) $shuju['KDFS'] = '';
        if(!isset( $shuju['KDHM'] )) $shuju['KDHM'] = '';
        if(!isset( $shuju['JINE'] )) $shuju['JINE'] = '';
        if(!isset( $shuju['UID'] )) $shuju['UID'] = '';
        if(!isset( $shuju['BT'] )) $biaoti = ''; else $biaoti = $shuju['BT'];
        
        $neirong  = str_replace(   array(         'YZM',        'ZH' ,       'NC' ,       'DDID',        'IP',    'TIME' ,        'KDFS' ,       'KDHM'   ,     'JINE'   ,     'UID')  , 
                                    array( $shuju['YZM'],$shuju['ZH'],$shuju['NC'],$shuju['DDID'],       $IP ,     time() ,$shuju['KDFS'],$shuju['KDHM'],$shuju['JINE'],$shuju['UID']
                        ) ,$DUQU['sms'.$shuju['type']]);
        




        $time = time() ;
        $woqu = qfopen('http://222.73.117.156/msg/HttpBatchSendSM?account='.$DUQU['duanxinid'].'&pswd='.$DUQU['duanxinkey'].'&needstatus=false&mobile='.$shouji.'&msg='.urlencode(iconv('UTF-8', 'UTF-8//IGNORE',$neirong)).'&timestamp='.$time);

 
        $cansh = explode( ',' , $woqu );

        if( $cansh['1'] =='0' ) return 'success:'.$cansh['0'];
        else return 'error:'.$cansh['1'];


}


function youxiang( $zhanghao , $shuju ){

       $neirong = '';

        $DUQU = include QTLANG ;
        if(!isset( $shuju['type'] )) $shuju['type'] = 1;
        if(!isset( $shuju['YZM'] )) $shuju['YZM'] = '';
        if(!isset( $shuju['ZH'] )) $shuju['ZH'] = '';
        if(!isset( $shuju['NC'] )) $shuju['NC'] = '';
        if(!isset( $shuju['DDID'] )) $shuju['DDID'] = '';
        if(!isset( $shuju['IP'] )) $shuju['IP'] = '';
        if(!isset( $shuju['TIME'] )) $shuju['TIME'] = '';
        if(!isset( $shuju['KDFS'] )) $shuju['KDFS'] = '';
        if(!isset( $shuju['KDHM'] )) $shuju['KDHM'] = '';
        if(!isset( $shuju['JINE'] )) $shuju['JINE'] = '';
        if(!isset( $shuju['UID'] )) $shuju['UID'] = '';
        if(!isset( $shuju['BT'] )) $biaoti = ''; else $biaoti = $shuju['BT'];

        $fajian = $DUQU['mailfa'];
        
         $IP = IP();
     
        
        $neirong  = str_replace(   array(         'YZM',        'ZH' ,       'NC' ,       'DDID',        'IP',    'TIME' ,        'KDFS' ,       'KDHM'   ,     'JINE'   ,     'UID')  , 
                                    array( $shuju['YZM'],$shuju['ZH'],$shuju['NC'],$shuju['DDID'],       $IP ,     time() ,$shuju['KDFS'],$shuju['KDHM'],$shuju['JINE'],$shuju['UID']
                        ) ,$DUQU['sms'.$shuju['type']]);

                                    

        $headers = 'From: '.$fajian .'<'.$fajian .'>' . "\r\n" .
                 'Reply-To: '.$fajian . "\r\n" . 
                 'Content-type: text/html;charset=UTF-8'."\r\n".
                 'X-Mailer: PHP/' . phpversion();
        if (mail($zhanghao, $biaoti, $neirong, $headers))  
             return 'success:ok';
        else return 'error:no';

}


function pichttp( $url ){

        if($url == '') return  WZHOST.ltrim( '/tpl/font/noimg.png' ,'/');
        if( strstr( $url , "://" ) )return $url;
        else return WZHOST.ltrim( $url,'/');

}


function regsong( $USER ){

    /* 注册赠送
       $USER 用户最新信息
    */


}


function czthongzhi( $USER , $JINE , $DDID  ){
        /*  充值成功通知处理
            $USER 用户最新信息
            $JINE 充值金额
            $DDID 充值的订单
        */


}


function zchongzhifan( $D  = '' , $USER , $JINE , $DDID ){
    /*  扩展处理通知
        $D  数据表结构
        $USER 用户最新信息
        $JINE 用户金额
    */
     


}



function kjreg( $lx = 0 , $uid = '' , $nc = '' , $tx ='' , $uindd = ''){

         /* 快捷注册 */

        global $CONN;
        $WHere = array('off' =>  1,
                        'ip' =>  IP(),
                      'level' => 1,
                 'yanzhengip' =>  $CONN['yanzhengip'],
                      'atime' =>  time());

         if( kjcha( $lx , $uid , $uindd ) ) return false;

         $D = db('user');
         if($lx == 1) $WHere['qqopen'] = $uid;
         else if($lx == 2) $WHere['weixin'] = $uid;
         else if($lx == 3) $WHere['weibo'] = $uid;
         else if($lx == 4) $WHere['zhifubaoopen'] = $uid;
         else if($lx == 5) $WHere['openid'] = $uid;
         else if($lx == 6) $WHere['openidd'] = $uid;

        if( ( $lx == 2 ||  $lx == 5 ) && $uindd != '' ) $WHere['weixinui'] = $uindd;
       
         $nc = ( anquanqu(  $nc ) );
         if($nc == '') $nc = mima( rand(1,888888));
         $WHere['name'] =  $nc;

         $WHere['touxiang'] = touxiang( $tx );

         if( isset( $_SESSION['tuid'] )){

             if( $_SESSION['tuid']  > 0){

                 $tuid =  uid( $_SESSION['tuid'] );

                 if( $tuid ){

                     $WHere['tuid'] = $_SESSION['tuid'];

                     for( $i = 1 ; $i < $CONN['tujishu'] ; $i++ ){
                             $wds = $i-1;
                             if($wds < 1) $wds= '' ;
                             $WHere['tuid'.$i] = $tuid['tuid'.$wds];
                    }
                 }
             }
         }



        $sql = $D -> setshiwu('1')  -> insert( $WHere );

        return $D -> qurey( $sql ,'shiwu');

}




function bangding( $lx = 0 , $UID = '' , $uid = '' , $nc = '' , $tx ='', $weixinui = '' ){

         /* 快捷登录绑定查询
           2 weixin          用户微信登录openid   唯一
             ( 2,5 )  weixinui 微信uiopenid         唯一
           1 qqopen          用户QQ登录openid     唯一
           3 weibo           新浪微博登录openid   唯一
           4 zhifubaoopen        支付宝登录openid     唯一
           5 openid          备用openid           唯一
           6 openidd         备用openid1          唯一
         */

         $WHere = array();

         if( kjcha( $lx , $uid  , $weixinui ) ) return false;


         $D = db('user');
         if($lx == 1) $WHere['qqopen'] = $uid;
         else if($lx == 2) $WHere['weixin'] = $uid;
         else if($lx == 3) $WHere['weibo'] = $uid;
         else if($lx == 4) $WHere['zhifubaoopen'] = $uid;
         else if($lx == 5) $WHere['openid'] = $uid;
         else if($lx == 6) $WHere['openidd'] = $uid;
        if( $nc != ''){
            $nc = ( anquanqu(  $nc ) );
            if($nc == '') $nc = mima( rand(1,888888));
            $WHere['name'] =  $nc;
        }

        if( ( $lx == 2 ||  $lx == 5 ) && $weixinui != '' ) $WHere['weixinui'] = $weixinui;

        if( $tx != '') $WHere['touxiang'] = touxiang( $tx );

        $sql = $D -> setshiwu('1') -> where( array( 'uid' => $UID) ) -> update( $WHere );

        $fan = $D -> qurey( $sql ,'shiwu');

        if($fan && isset ( $_GET['state'] ) &&  strlen( $_GET['state']) == 32){

                 global $Mem;
                 $HASH = 'kjdenglu/'.mima( $_GET['state']  );
                 $Mem -> s($HASH, $UID ,20);
         }

        return $fan ;

        
}


function kjcha( $lx = 0 , $uid = '' , $unopid = '' ){

         /* 快捷登录绑定查询
           2 weixin          用户微信登录openid   唯一
             ( 2,5 )  weixinui 微信uiopenid       唯一
           1 qqopen          用户QQ登录openid     唯一
           3 weibo           新浪微博登录openid   唯一
           4 zhifubaoopen        支付宝登录openid 唯一
           5 openid          app openid           唯一
           6 openidd         备用openid1          唯一
             weixinui        微信uiopenid         唯一
            
         
         */

         if( $uid == '' ) msgbox( '' , WZHOST );

         $WHere = array();
         $D = db('user');
         if($lx == 1) $WHere['qqopen'] = $uid;
         else if($lx == 2) $WHere['weixin'] = $uid;
         else if($lx == 3) $WHere['weibo'] = $uid;
         else if($lx == 4) $WHere['zhifubaoopen'] = $uid;
         else if($lx == 5) $WHere['openid'] = $uid;
         else if($lx == 6) $WHere['openidd'] = $uid;

        if( ( $lx == 2 ||  $lx == 5 ) && $unopid != '') $WHere['weixinui OR'] = $unopid;

        $fan = $D ->where( $WHere )-> find();

        if( $fan &&  isset( $WHere['weixinui OR'] ) && $fan['weixinui'] == '' ){



            $sql  = $D ->setshiwu(1) -> where(array('uid' => $fan['uid'] ) )-> update( array( 'weixinui' =>  $unopid ) );

            $mywo = $D -> qurey( $sql );

            if($mywo ) uid(  $fan['uid'] ,1 );



        }

         if($fan && isset ( $_GET['state'] ) &&  strlen( $_GET['state']) == 32){

                 global $Mem;
                 $HASH = 'kjdenglu/'.mima( $_GET['state']  );
                 $Mem -> s($HASH, $fan['uid'] ,20);
         }

         return $fan ;


}


function touxiang( $tx = ''){

         if($tx != '') return pichttp( $tx) ;
         else return '/attachment/touxiang/'.rand(0,13).'.gif';
}

function jiaqian1( $UID , $TYPE = 0 , $JINE = 0,$JIFEN = 0 , $HUOBI = 0  , $DATA = '' , $ip = ''){

          /* 加钱
             $UID  用户uid
             $TYPE = 0 , $JINE = 0,$JIFEN = 0 , $HUOBI = 0  , $DATA = '' , $ip = ''
             
          */
         
        $D = db( 'user');

        $sql = '';

        

        if( $JIFEN != '0'){

            $sql .= $D -> setshiwu(1) -> where( array( 'uid' => $UID,'jifen >='=> ($JIFEN < 0 ? -$JIFEN: 0 ) )) -> update( array( 
                   
                   'jifen +' => $JIFEN,
                  
                 )
                );

            $sql .=$D -> setshiwu(1) -> setbiao('jifenlog') -> insert(array(   'uid' => $UID,
                               'type' => $TYPE,
                               'jine' => $JIFEN,
                               'data' => $DATA,
                                 'ip' => $ip ==''?ip(): $ip,
                              'atime' => time()
                        ));
        }

        if( $JINE != '0'){

              $sql .= $D -> setshiwu(1) -> where( array( 'uid' => $UID ,'jine >='=> ($JINE < 0 ? -$JINE: 0 ) )) -> update( array( 
                    'jine +' => $JINE,
                   
                 )
                );

            $sql .=$D -> setshiwu(1) -> setbiao('jinelog') -> insert(array(   'uid' => $UID,
                               'type' => $TYPE,
                               'jine' => $JINE,
                               'data' => $DATA,
                                 'ip' => $ip ==''?ip(): $ip,
                              'atime' => time()
                        ));
        }


        if( $HUOBI != '0'){
              $sql .= $D -> setshiwu(1) -> where( array( 'uid' => $UID,'huobi >='=> ($HUOBI < 0 ? -$HUOBI: 0 ))) -> update( array( 
              
                   'huobi +' => $HUOBI,
                 )
                );

            $sql .= $D -> setshiwu(1) -> setbiao('huobilog') -> insert(array(   'uid' => $UID,
                               'type' => $TYPE,
                               'jine' => $HUOBI,
                               'data' => $DATA,
                                 'ip' => $ip ==''?ip(): $ip,
                              'atime' => time()
                       ));
        }

        $fan = $D -> qurey($sql ,'shiwu');

       

        if( $fan ){

            uid($UID ,1,$D );

            return true;

        }else return false;

}