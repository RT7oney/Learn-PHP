<?php if(!defined('ONGPHP'))exit('ErrorONGSOFT');
plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );

$Memsession =  $Mem = new txtcc();

$HUOBI = huobi( $CONN,2 );

$HUOBIICO = array( '￥' , $CONN['jifen'] ,  $CONN['huobi'] , $CONN['hongbao'] );

 if( isset ( $_GET['state'] ) &&  strlen( $_GET['state']) == 32){

    $denglu  =  'kjdenglu/'.mima( $_GET['state'] ).'G';

    $wodese = $Mem ->g( $denglu );

    if( $wodese ){

        session_id( $wodese );
        $Mem -> d ( $denglu );

    }

 }

if(  isset( $_GET['apptoken'] ) && strlen( trim( $_GET['apptoken']) ) > 60 ){ 
    
     session_id( $_GET['apptoken']);
}


setsession( $CONN['sessiontime'] );

$LANG = include QTLANG;

$WZHOST = WZHOST;

$TIAOURL = isset($_SESSION['back']) && $_SESSION['back'] != '' ? $_SESSION['back'] : WZHOST;

$IP = ip();

if( isset( $_SESSION['back'] ) ) unset( $_SESSION['back'] );

/*  qq登录
    [kjqqid] => 
    [kjqqkey] => 
    [kjqqname] => 
    公众平台
    [kjwxid] => 
    [kjwxkey] => 
    [kjwxname] => 
    开放平台
    [kjkwxid] => 
    [kjkwxkey] => 
    [kjkwxname] => 
    微博
    [kjweiboid] => 
    [kjweibokey] => 
    [kjweiboname] => 
    支付宝
    [kjzfbid] => 
    [kjzfbkey] => 
    [kjzfbname] => 
*/


function gengduo( $code , $mesg =  '' ,$data = array() , $TIAOURL = WZHOST ){

        if( strstr( $_SERVER['HTTP_USER_AGENT'], 'jfwlapp2' ) || isset( $_GET['isapp'] )  ||  ( isset($_GET['state'])  && $_GET['state'] == 'isapp' )   ) {
         
            if( $code == 99  && ( isset($_GET['state'])  && $_GET['state'] == 'isapp' )  ){

                $login = base64_encode( json_encode( $data ) );
                $html = '<script type="text/javascript">window.location.href="#login-'.$login.'";</script><a href="#login-'.$login.'"> Login </a>';

                exit(  $html );

            }


         exit( json_encode( array( 'start' => 1, 'code' => $code ,'data' => $data , 'msg' => $mesg ) ));
         
        }else{

            msgbox( $mesg , $TIAOURL );

        }




}

function tongyihan( $LX ,  $opuid ,$TIAOURL = WZHOST, $IP ='' , $unopid = '' ){


        if( $opuid == '' ) gengduo( '-1' , '非法传递,没有唯一标识','' , $TIAOURL );

        $USER =  kjcha( $LX , $opuid , $unopid );

        if( $USER ){   /*查询get 成功的直接 登录*/


            if( $USER['off'] == '0'){

                session_destroy();
                
                gengduo( '-99' , '帐号被停用' ,'' , $TIAOURL );
            }

            if( isset ( $_GET['state'] ) &&  strlen( $_GET['state']) == 32){

                global $Mem;

                $HASH = 'kjdenglu/'.mima( $_GET['state'] );

                $Mem -> s($HASH, $USER['uid'] ,20);

            }


            if( isset( $_SESSION['uid'] ) && $_SESSION['uid'] > 0 )gengduo( '-1' , '已经被绑定' ,'' , $TIAOURL );
            else{
             
                $USERID = $_SESSION['uid']  = $USER['uid'];
                $_SESSION['ip']   =  $IP;

                gengduo( 99 ,  '',array( 'name' => $USER['name'],
                    'uid'  =>  $_SESSION['uid'],
                    'jine' => $USER['jine'],
                   'jifen' => $USER['jifen'],
                'huobi' => $USER['huobi'],
                'touxiang' => pichttp( $USER['touxiang'] ),
                  'shouji' => xinghao( $USER['shouji'] ),
            ) , $TIAOURL  );



            }

          


        }else if( isset( $_SESSION['uid'] ) && $_SESSION['uid'] > 0  ){

            /*已经登录过直接绑定 */

            $USER = uid( $_SESSION['uid'] );

            if(!$USER || $USER['off'] == '0') {
            
               session_destroy();
               gengduo( '-99' , '帐号被停用' ,'' , $TIAOURL );
              

            }

            $fan =  bangding( $LX ,$_SESSION['uid'], $opuid , '' , '' , $unopid );

            if( $fan ){ 
                  
                $USER = uid( $_SESSION['uid'] ,1 );

                gengduo( 99 ,  '' ,array( 'name' => $USER['name'],
                    'uid'  =>  $_SESSION['uid'],
                    'jine' => $USER['jine'],
                   'jifen' => $USER['jifen'],
                'kuohuobi' => $USER['kuohuobi'],
                'touxiang' => pichttp( $USER['touxiang'] ),
                  'shouji' => xinghao( $USER['shouji'] ),
                ) , $TIAOURL  );

            }else gengduo( '-1' , '绑定失败' ,'' , $TIAOURL ); 

        }






}


$ACTION = array( '1' => 'qq',
                 '2' => 'weixin',
                 '3' => 'weibo',
                 '4' => 'alipay',
                 '5' => 'weixinopen',
);


if( $KJTYPE == 1 ){
    /*qq*/
    
    $opencode = $openid = '';

    $csass=  sslget('https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id='.$LANG['kjqqid'].'&client_secret='.$LANG['kjqqkey'].'&code='.$_GET['code'].'&redirect_uri='.$WZHOST.'login/qq.php');
    
    if( $csass ){

            preg_match_all('#access_token=(.*)&#iUs', $csass, $nrio);

            if( isset( $nrio['1']['0']) &&  $nrio['1']['0'] != ''){

               $opencode = $nrio['1']['0'];

                $useropen =  sslget('https://graph.qq.com/oauth2.0/me?access_token='.$opencode);

                preg_match_all('#openid":"(.*)"#iUs',$useropen,$OPIND);
            
                if( isset( $OPIND['1']['0']) &&  $OPIND['1']['0'] != ''){

                    $openid = $OPIND['1']['0'];

                    tongyihan( 1 ,  $openid , $TIAOURL , $IP );

                }else{

                     p('2:'.$useropen);
                     exit();
                }
          
            }else{

               p('1:'.$csass);
               exit();
            }


    }else gengduo( '-1' , '通信连接失败' ,'' , $WZHOST );


    $zilia =  sslget('https://graph.qq.com/user/get_user_info?access_token='.$opencode.'&openid='.$openid.'&oauth_consumer_key='.$LANG['kjqqid']);
    
    if( $zilia ){

        $woqi = (array)json_decode($zilia);

        if( $woqi ){
            $zuhhou =  anquanqu($woqi['nickname']);

            $_SESSION['tourist'] = array( 'lx'  => 1 ,
                                          'uid' => $openid ,
                                         'name' => $zuhhou,
                                           'tx' => $woqi['figureurl_qq_2'],
            );

        }else {

                p('3:'.$zilia);
                exit();
        }

  
    }else  gengduo( '-1' , '通信连接失败2' ,'' , $WZHOST );



}else if( $KJTYPE == 2){
    /*weixin*/

    $unopid =  $toke = $openid = '';

    $csass = sslget('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$LANG['kjwxid'].'&secret='.$LANG['kjwxkey']."&code=".$_GET['code'].'&grant_type=authorization_code');

    if( $csass ){

        $woqi = (array)json_decode( $csass );

        if( $woqi ){

            $toke = $woqi['access_token'];
            $openid = $woqi['openid'];

            $access_token =  $Mem ->g('access_token');
        
            if( !$access_token ){

                $csass = sslget('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$LANG['kjwxid'].'&secret='.$LANG['kjwxkey']);

                $woqi = (array)json_decode($csass);
                $access_token = $woqi['access_token'];

                if( strlen( $access_token )< 10 )return false;

                $Mem ->s('access_token',$access_token ,'3600');

            }

            $dddss =  sslget('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN');

            if( $dddss ){

                $kknn = ( array ) json_decode( $dddss );
                if( isset( $kknn ['subscribe']  ) && $kknn ['subscribe'] == 1 ) $_SESSION ['guanzhu'] = 1;

            }


            if( isset( $woqi['unionid']) &&  $woqi['unionid'] != '' )  $unopid = $woqi['unionid'];

             tongyihan( 2 ,  $openid , $TIAOURL , $IP , $unopid );


        }else{
        
           p('1:'.$csass);
           exit();
        }


    
    
    }else  gengduo( '-1' , '通信连接失败1' ,'' , $WZHOST );

    $ddd =  sslget('https://api.weixin.qq.com/sns/userinfo?access_token='.$toke.'&openid='.$openid.'&lang=zh_CN');

    if( $ddd ){
     
        $ddddd = (array)json_decode( $ddd );

        if( $ddddd ){

            $xinminz =  anquanqu($ddddd['nickname']);
            $tx = $ddddd['headimgurl'];

            if($xinminz =='') $xinminz = 'WX'.mima($openid);

            $_SESSION['tourist'] = array(   'lx' => 2 ,
                                           'uid' =>  $openid ,
                                          'name' => $xinminz,
                                            'tx' => $tx,
                                       'unionid' => $unopid,
            );



        }else{

            p('2:'.$ddd);
            exit();
        }




    }else  gengduo( '-1' , '通信连接失败2' ,'' , $WZHOST );
        



}else if( $KJTYPE == 3){

    /*weibo
    [kjweiboid] => 
    [kjweibokey] => 
    */

      $fanhui = array( 'client_id' => $LANG['kjweiboid'],
                   'client_secret' => $LANG['kjweibokey'],
                      'grant_type' => 'authorization_code',
                            'code' => $_GET['code'],
                    'redirect_uri' => $WZHOST.'login/weibo.php'
          
      
      );

     $huidiao = post(getarray( $fanhui ) ,'https://api.weibo.com/oauth2/access_token');

     if( $huidiao ){

          $ddddd = (array)json_decode( $huidiao );


        if( $ddddd ){

             if( isset( $ddddd['access_token']) &&  isset( $ddddd['uid']) ){

                 tongyihan( 3 ,  $ddddd['uid'] , $TIAOURL , $IP );

                 $_SESSION['tourist'] = array( 'lx'  => 3 ,
                                  'uid' => $ddddd['uid'] ,
                                 'name' => '',
                                   'tx' => '',
                   );


             
             }else{

                p('2:',$ddddd);
                exit();
             }

        }else{

            p('1:',$huidiao);
            exit();
        }

     }else  gengduo( '-1' , '通信连接失败1' ,'' , $WZHOST );
     

     


}else if( $KJTYPE == 4){

    /*alipay*/
    $url = 'http://notify.alipay.com/trade/notify_query.do?';

   
    $sign = $_GET['sign'];

    unset($_GET['sign']);

    unset($_GET['sign_type']);


    $zuhe = argSort( $_GET );
    $key = md5( getarray( $zuhe ).$LANG['kjzfbkey'] );

    if( $key != $sign)  gengduo( '-1' , '签名错误' ,'' , $WZHOST );

    if( $_GET['is_success'] != 'T') gengduo( '-1' , '登录失败' ,'' , $TIAOURL );

     /* 需要保留
        user_id  唯一标识
        real_name 昵称用于
        touxiang(); 用户初始头像
     */

    $fanhui = qfopen($url ."partner=" . $LANG['kjzfbid'] . "&notify_id=".$_GET['notify_id']);

    if( ! preg_match("/true$/i", $fanhui ) )msgbox('token过期重新登录',$TIAOURL);

    tongyihan( 4 ,  $_GET['user_id'] , $TIAOURL , $IP );
      
    $_SESSION['tourist'] = array( 'lx'  => 4 ,
                                  'uid' =>  $_GET['user_id'],
                                 'name' => $_GET['real_name'],
                                   'tx' => '',
    );



}else if( $KJTYPE == 5){

    /* weixinopen */

    $unopid =  $toke = $openid = '';

    $csass = sslget('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$LANG['kjkwxid'].'&secret='.$LANG['kjkwxkey']."&code=".$_GET['code'].'&grant_type=authorization_code');

    if( $csass ){

        $woqi = (array)json_decode( $csass );

        if( $woqi ){

            $toke = $woqi['access_token'];
            $openid = $woqi['openid'];
            if( isset( $woqi['unionid'] ) &&  $woqi['unionid'] != '' )  $unopid = $woqi['unionid'];


            tongyihan( 5 ,  $openid , $TIAOURL , $IP , $unopid );



            $ddd =  sslget('https://api.weixin.qq.com/sns/userinfo?access_token='.$toke.'&openid='.$openid.'&lang=zh_CN');

            if( $ddd ){
     
                $ddddd = (array)json_decode( $ddd );

                if( $ddddd ){

                    $xinminz =  anquanqu($ddddd['nickname']);
                    $tx = $ddddd['headimgurl'];
                    if($xinminz =='') $xinminz = 'WX'.mima($openid);

                    $_SESSION['tourist'] = array(   'lx' => 2 ,
                                                   'uid' =>  $openid ,
                                                  'name' => $xinminz,
                                                    'tx' => $tx,
                                               'unionid' => $unopid,
                    );

                }else{

                    p('2:'.$ddd);
                    exit();
                }

            }else  gengduo( '-1' , '通信连接失败2' ,'' , $WZHOST );


        }else gengduo('-1','JSON 格式错误1');


    }else gengduo( '-1','JSON 格式错误2');


}


if( isset( $_SESSION['tourist'] )){


    if( $CONN['kuaireg'] == 1  || strstr( $_SERVER['HTTP_USER_AGENT'], 'jfwlapp2' )){

        $uindd = isset( $_SESSION['tourist']['unionid']) && $_SESSION['tourist']['unionid'] != '' ? $_SESSION['tourist']['unionid'] : '' ;

        $kuaijie = kjreg($_SESSION['tourist']['lx'] , $_SESSION['tourist']['uid']  , $_SESSION['tourist']['name']  , $_SESSION['tourist']['tx'], $uindd );

        if( $kuaijie ){

            $USER = kjcha( $_SESSION['tourist']['lx'] , $_SESSION['tourist']['uid'] ,$uindd );
            unset( $_SESSION['tourist'] );

            if( $USER ){

              $_SESSION['uid']  =  $USERID = $USER['uid'];
              $_SESSION['ip']   =  $IP;

                if( isset ( $_GET['state'] ) &&  strlen( $_GET['state']) == 32){

                   $HASH = 'kjdenglu/'.mima( $_GET['state']  );
                   $Mem -> s($HASH, $USER['uid'] ,20);

                }

                $USER = uid($_SESSION['uid'] ,1);
                gengduo( 99 ,  '' ,array( 'name' => $USER['name'],
                                          'uid'  =>  $_SESSION['uid'],
                                          'jine' => $USER['jine'],
                                         'jifen' => $USER['jifen'],
                                      'huobi' => $USER['huobi'],
                                      'touxiang' => pichttp( $USER['touxiang'] ),
                                        'shouji' => xinghao( $USER['shouji'] ),
                                ) , $TIAOURL  );
         
         
            }else   gengduo( '-1' , '失败联系管理2' ,'' , WZHOST );




        }else{

            unset( $_SESSION['tourist'] );
            gengduo( '-1' , '插入失败联系管理' ,'' , WZHOST );

        }
     

    }else include QTPL . 'user/reg.php';


}else   gengduo( '-1' , '未知快捷登录 或者未知处理函数' ,'' , $TIAOURL );