<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');
/*

200 操作成功

401 需要登录用户
500 内部服务器错误

304 修改失败
410 删除失败
404 查询失败
406 新增失败

415 非法数据 token错误
exit( json_encode( apptongxin( array()  ,'500', '-1' , 'no mode' ) ) );

code  1 正常
code  2 验证码错误
code  3 自动录入验证码
*/ 

$ZHANGHAO = isset( $_POST['zhanghao'] ) ? ( $_POST['zhanghao'] ) : '';  /* 登录帐号  */
$PASS     = isset( $_POST['pass'] )     ? ( $_POST['pass'] )  : '';     /* 登录密码  */
$EPASS    = isset( $_POST['epass'] )    ? ( $_POST['epass'] ) : '';     /* 重复密码  */
$VCODE    = isset( $_POST['vcode'] )    ? ( $_POST['vcode'] ) : '';     /* 图形二维码*/
$CODE     = isset( $_POST['code'] )     ? ( $_POST['code'] )  : '';     /* 短信验证码*/
$TOKEN    = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */

usleep( rand( 5000 , 500000 ) );

$D = db('user');

if( $MOD == 'get' ){

    /*  读取数据
        登录帐号
    */

    if( $USERID > 0 )  exit( json_encode( apptongxin( array()  ,'200', '1' , '' , $YZTOKEN ) ) );

    $KJLOGIN =  ( int )( isset( $_POST['kjlogin']) ? $_POST['kjlogin'] : 0 ) ;


    $canshu = array( 'zhanghao#len#2-30',
                         'pass#len#6-30',
            );

    $FAN = yzpost( $canshu );

    if( $FAN['code'] == '0'){

        if( $FAN['biao'] == 'zhanghao')
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao'].$CONN['regtype']].' [ '.$FAN['msg'].' ] '.$LANG['cuowu'],$YZTOKEN ) ) );
        else
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
    }

    $WHERE = array();

    if( $KJLOGIN == '2'){

        if( isshouji( $ZHANGHAO )) {
        
          $WHERE['shouji'] = ( (float) $ZHANGHAO < 1 ) ? -1 : $ZHANGHAO ;
        }else if( isemail( $ZHANGHAO )) {

            $WHERE['email'] =  $ZHANGHAO ;
        
        }else   exit( json_encode( apptongxin( array()  ,'415', '1' , '帐号错误',$YZTOKEN ) ) );

    }else{

        $WHERE['shouji']      = ( (float) $ZHANGHAO < 1 ) ? -1 : $ZHANGHAO ;
        $WHERE['email OR']    = $ZHANGHAO ;
        $WHERE['zhanghao OR'] = $ZHANGHAO ;

    }

    if( $KJLOGIN == '2' ){

        if( !yzcode( 'vcode' , $CONN['sicode'] , 160 , 0 )  )exit( json_encode( apptongxin( array()  ,'415', '2' , $LANG['vcode'].$LANG['cuowu'] , $YZTOKEN ) ) );
         if(! wenyiyz( $ZHANGHAO , $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu']  ,  wenyiyz( $ZHANGHAO ,'' , $Mem ) ) ) );

        if(! yzsms( $ZHANGHAO , $CODE ) )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu'] , $YZTOKEN ) ) );
    
    
    
    }

    $DATA = $D -> where( $WHERE )-> find();


    if( $KJLOGIN == '2' && ! $DATA ){

        /* 快捷注册 */
    $JICHENG = $WHERE;

    $WHERE['name']  = xinghao( $ZHANGHAO );
    $WHERE['atime'] = time();
    $WHERE['off']   = 1;
    $WHERE['mima']  = mima("") ;
    $WHERE['touxiang'] = touxiang();
    $WHERE['ip']    = IP();
    $WHERE['level'] = (float)$CONN['level'];
    $WHERE['yanzhengip'] = (float)$CONN['yanzhengip'];

    if( isset( $_SESSION['tuid'] ) ){
        
        if( $_SESSION['tuid']  > 0){

            $tuid =  uid( $_SESSION['tuid'] );

            if( $tuid ){

                    $WHERE['tuid'] = $_SESSION['tuid'];

                    for( $i = 1 ; $i < $CONN['tujishu'] ; $i++ ){

                         $wds = $i-1;
                         if($wds < 1) $wds= '' ;
                         $WHERE['tuid'.$i] = $tuid['tuid'.$wds];

                    }
            }
        }

    }



    $sql  =  $D -> setshiwu('1') -> insert( $WHERE );

    $FAN  =  $D -> qurey( $sql , 'shiwu' );

    if( $FAN ){
    
        $DATA = $D -> where( $JICHENG )-> find();

        if( $DATA ){

        if( isset( $_SESSION['tourist'] )){

            $_SESSION['uid'] = $DATA['uid'];
            $_SESSION['ip']  = IP();

            $uindd = isset( $_SESSION['tourist']['unionid']) && $_SESSION['tourist']['unionid'] != '' ? $_SESSION['tourist']['unionid'] : '' ;

            $fan =  bangding( $_SESSION['tourist']['lx'] ,$DATA['uid'], $_SESSION['tourist']['uid'],  $_SESSION['tourist']['name'] ,  $_SESSION['tourist']['tx'], $uindd );

            if( $fan ){

                $CODE = 1;
                uid( $_SESSION['uid'] ,1 );

            }else $CODE = -1;

            unset( $_SESSION['tourist'] );
        }

        regsong( $DATA );

    }

    }else exit( json_encode( apptongxin( array()  ,'415', '1' , '快捷注册失败',$YZTOKEN ) ) );
    
    
    
    
    }





    if( ! $DATA )           exit( json_encode( apptongxin( array()  ,'404', '1' , '',$YZTOKEN ) ) );
    if( $DATA['off'] < 1 )  exit( json_encode( apptongxin( array()  ,'415', '1' , '帐号关闭',$YZTOKEN ) ) );

    if( $DATA['mima'] != mima( $PASS ) && $KJLOGIN != '2' )  exit( json_encode( apptongxin( array()  ,'415', '1' , '帐号或密码错误',$YZTOKEN ) ) );

    $USERID  =  $DATA['uid'];


    if( isset( $_SESSION['gouwuche'] )  &&  $USERID > 0){

                $GWC  = $Mem -> g( 'gouwuche/'. $USERID );

                if( ! $GWC && $_SESSION['gouwuche'] && is_array( $_SESSION['gouwuche'] ))
                    $Mem -> s( 'gouwuche/'. $USERID , $_SESSION['gouwuche'] );
                else if( is_array( $_SESSION['gouwuche'] ) && $GWC ){

                    if(!is_array($GWC)) $GWC = array();

                    $GWC =  array_merge( $GWC , $_SESSION['gouwuche'] );

                    $Mem -> s( 'gouwuche/'. $USERID , $GWC );
                
                
                }
                
                unset( $_SESSION['gouwuche'] );
    }



    $_SESSION['uid'] = $DATA['uid'];
    $_SESSION['ip']  = IP();

    userlog( $DATA['uid'] , 0 );


    if( isset( $_SESSION['tourist'] )){

           

            $uindd = isset( $_SESSION['tourist']['unionid']) && $_SESSION['tourist']['unionid'] != '' ? $_SESSION['tourist']['unionid'] : '' ;

            $fan =  bangding( $_SESSION['tourist']['lx'] ,$DATA['uid'], $_SESSION['tourist']['uid'],  $_SESSION['tourist']['name'] ,  $_SESSION['tourist']['tx'], $uindd );

            if( $fan ){

               
                uid( $_SESSION['uid'] ,1 );

            }

            unset( $_SESSION['tourist'] );
        }


}else if( $MOD == 'post' ){

    /*  新增数据
        注册帐号
    */

    if( $USERID > 0 )  exit( json_encode( apptongxin( array()  ,'200', '1' , '',$YZTOKEN ) ) );

    $canshu = array( 'zhanghao#len#2-30',
                         'pass#len#6-30',
                        'vcode#len#4',
                         'code#len#6',
                        'epass#=#'.$PASS
            );

    $FAN = yzpost( $canshu );

    if( $FAN['code'] == '0'){

        if( $FAN['biao'] == 'zhanghao')
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao'].$CONN['regtype']].' [ '.$FAN['msg'].' ] '.$LANG['cuowu'] , $YZTOKEN) ) );
        else
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
    }

    $FINDD = $WHERE = array();

    if( $CONN['regtype'] == '3'){

        //手机登录
        if(! isshouji( $ZHANGHAO )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'.$CONN['regtype']].' [ 11 ] '.$LANG['cuowu'] , $YZTOKEN ) ) );
        $FINDD['shouji'] = $WHERE['shouji'] = $ZHANGHAO;
        $LX = 3;

    }else if( $CONN['regtype'] == '2'){

        // 邮箱登录
        if(! isemail( $ZHANGHAO )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'.$CONN['regtype']].$LANG['cuowu'] , $YZTOKEN ) ) );
        $LX = 2;
        $FINDD['email'] = $WHERE['email'] = $ZHANGHAO;

    }else if( $CONN['regtype'] == '1'){

        //帐号登录
        $LX = 1;
        $FINDD['zhanghao'] = $WHERE['zhanghao'] = $ZHANGHAO;

    }else if( $CONN['regtype'] == '0'){

        //邮箱或者手机注册
        if( isemail( $ZHANGHAO )){

            $LX = 2;
            $FINDD['email'] = $WHERE['email'] = $ZHANGHAO;

        }else if( isshouji( $ZHANGHAO )){

            $FINDD['shouji'] = $WHERE['shouji'] = $ZHANGHAO;
            $LX = 3;

        }else{

            $LX = 1;
            $FINDD['zhanghao'] = $WHERE['zhanghao'] = $ZHANGHAO;
        }

    }

    if( !yzcode( 'vcode' , $CONN['sicode'] , 160 , 0 )  )exit( json_encode( apptongxin( array()  ,'415', '2' , $LANG['vcode'].$LANG['cuowu'] , $YZTOKEN ) ) );

    if( strlen( $TOKEN ) < 10 )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['token'].$LANG['cuowu'] ,$YZTOKEN ) ) );

    $DATA = $D -> where( $WHERE )-> find();

    if( $DATA ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'].'存在'.$LANG['cuowu'] , $YZTOKEN ) ) );


    if(! wenyiyz( $ZHANGHAO , $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu']  ,  wenyiyz( $ZHANGHAO ,'' , $Mem ) ) ) );

    if(! yzsms( $ZHANGHAO , $CODE ) )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu'] , $YZTOKEN ) ) );

    $WHERE['name']  = xinghao( $ZHANGHAO );
    $WHERE['atime'] = time();
    $WHERE['off']   = 1;
    $WHERE['mima']  = mima($PASS) ;
    $WHERE['touxiang'] = touxiang();
    $WHERE['ip']    = IP();
    $WHERE['level'] = (float)$CONN['level'];
    $WHERE['yanzhengip'] = (float)$CONN['yanzhengip'];

    if( isset( $_SESSION['tuid'] ) ){
        
        if( $_SESSION['tuid']  > 0){

            $tuid =  uid( $_SESSION['tuid'] );

            if( $tuid ){

                    $WHERE['tuid'] = $_SESSION['tuid'];

                    for( $i = 1 ; $i < $CONN['tujishu'] ; $i++ ){

                         $wds = $i-1;
                         if($wds < 1) $wds= '' ;
                         $WHERE['tuid'.$i] = $tuid['tuid'.$wds];

                    }
            }
        }

    }



    $sql  =  $D -> setshiwu('1') -> insert( $WHERE );

    $FAN  =  $D -> qurey( $sql , 'shiwu' );

    if( ! $FAN ) exit( json_encode( apptongxin( array()  , '500' , '1' , '',$YZTOKEN ) ) );

    $DATA = $D -> where( $FINDD ) -> find();

    if( $DATA ){

        if( isset( $_SESSION['tourist'] )){

            $_SESSION['uid'] = $DATA['uid'];
            $_SESSION['ip']  = IP();

            $uindd = isset( $_SESSION['tourist']['unionid']) && $_SESSION['tourist']['unionid'] != '' ? $_SESSION['tourist']['unionid'] : '' ;

            $fan =  bangding( $_SESSION['tourist']['lx'] ,$DATA['uid'], $_SESSION['tourist']['uid'],  $_SESSION['tourist']['name'] ,  $_SESSION['tourist']['tx'], $uindd );

            if( $fan ){

                $CODE = 1;
                uid( $_SESSION['uid'] ,1 );

            }else $CODE = -1;

            unset( $_SESSION['tourist'] );
        }

        regsong( $DATA );

    }



}else if( $MOD == 'put' ){
    /*  修改数据
        找回密码
    */

    if( $USERID > 0 )  exit( json_encode( apptongxin( array()  ,'200', '1' , '',$YZTOKEN ) ) );
    
    $canshu = array( 'zhanghao#len#2-30',
                         'pass#len#6-30',
                        'vcode#len#4',
                         'code#len#6',
                        'epass#=#'.$PASS
                         
              );

    $FAN = yzpost( $canshu );

    if( $FAN['code'] == '0'){

        if( $FAN['biao'] == 'zhanghao')
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao'].$CONN['regtype']].' [ '.$FAN['msg'].' ] '.$LANG['cuowu'],$YZTOKEN ) ) );
        else
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
    }

    $FINDD = $WHERE = array();

    if( $CONN['regtype'] == '3'){

        //手机登录
        if(! isshouji( $ZHANGHAO )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'.$CONN['regtype']].' [ 11 ] '.$LANG['cuowu'] ,$YZTOKEN) ) );
        $FINDD['shouji'] = $WHERE['shouji'] = $ZHANGHAO;
        $LX = 3;

    }else if( $CONN['regtype'] == '2'){

        // 邮箱登录

        if(! isemail( $ZHANGHAO )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'.$CONN['regtype']].$LANG['cuowu'],$YZTOKEN ) ) );
        $LX = 2;
        $FINDD['email'] = $WHERE['email'] = $ZHANGHAO;

    }else if( $CONN['regtype'] == '1'){

        //帐号登录
        $LX = 1;
        $FINDD['zhanghao'] = $WHERE['zhanghao'] = $ZHANGHAO;

    }else if( $CONN['regtype'] == '0'){

        //邮箱或者手机注册
        if( isemail( $ZHANGHAO )){

            $LX = 2;
            $FINDD['email'] = $WHERE['email'] = $ZHANGHAO;

        }else if( isshouji( $ZHANGHAO )){

            $FINDD['shouji'] = $WHERE['shouji'] = $ZHANGHAO;
            $LX = 3;

        }else{

            $LX = 1;
            $FINDD['zhanghao'] = $WHERE['zhanghao'] = $ZHANGHAO;
        }

    }

    if( !yzcode( 'vcode' , $CONN['sicode'] , 160 , 0 )  )exit( json_encode( apptongxin( array()  ,'415', '2' , $LANG['vcode'].$LANG['cuowu'],$YZTOKEN ) ) );

    if( $LX == 1 )exit( json_encode( apptongxin( array()  ,'415', '1' , '帐号无法找回密码',$YZTOKEN ) ) );



    $DATA = $D ->where( $WHERE )-> find();

    if( !$DATA )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'].'不存在'.$LANG['cuowu'] ,$YZTOKEN) ) );

    if(! wenyiyz( $ZHANGHAO, $TOKEN  ,   $Mem , 2 ) )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu']  ,  wenyiyz( $ZHANGHAO , '' ,  $Mem ) ) ) );

    if(! yzsms( $ZHANGHAO , $CODE ) )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu'] ,$YZTOKEN) ) );

    $NEW = mima( $PASS );

    if( $DATA['mima'] == $NEW )exit( json_encode( apptongxin( array()  ,'415', '1' , '和原来密码一样无需修改',$YZTOKEN ) ) );
    $sql = $D ->setshiwu(1)-> where( array( 'uid' => $DATA['uid'])) -> update(array( 'mima' => $NEW ));

    $fan = $D -> qurey( $sql , 'shiwu');
    if( !$fan ) exit( json_encode( apptongxin( array()  ,'415', '1' , '修改失败联系管理',$YZTOKEN ) ) );
    uid( $DATA['uid'] , 1 );

}else if( $MOD == 'delete' ){


    /*  删除数据
        发送短信

    */


    $RTOKEN = isset( $_POST['r']) ? $_POST['r'] : '';


    if( $RTOKEN != '' ){

        /* 微信扫码*/


        if( strlen( $RTOKEN ) == 32){

        $HASH = 'kjdenglu/'.mima( $RTOKEN );

        $wode = $Mem -> g($HASH);

        if( $USERID > 0){


            $Mem -> s( $HASH.'G' , session_id() , 120 );
        }

         $CODE = 1;

        if( $wode ){
            
            if( $wode > 0 ){

                $_SESSION['uid']  =  $USERID = $wode ;
                $_SESSION['ip']   =  IP();
                $CODE  = 99;

            }else  $CODE  = 91;

                $Mem -> d($HASH);

        }

        exit( json_encode( apptongxin( array()  ,'200', $CODE , '未知数据',$YZTOKEN ) ) );
        
        }else exit( json_encode( apptongxin( array()  ,'415', '1' , '',$YZTOKEN ) ) );
    
    
    
    


    
    }

    $canshu = array( 'zhanghao#len#2-30',
                         'pass#len#6-30',
                        'vcode#len#4',
                          'epass#=#'.$PASS
                         
              );

    $FAN = yzpost( $canshu );

    if( $FAN['code'] == '0'){

        if( $FAN['biao'] == 'zhanghao')
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao'].$CONN['regtype']].' [ '.$FAN['msg'].' ] '.$LANG['cuowu'] ,$YZTOKEN) ) );
        else
            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
    }

    $WHERE = array();

    if( $CONN['regtype'] == '3'){

        //手机登录
        if(! isshouji( $ZHANGHAO )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'.$CONN['regtype']].' [ 11 ] '.$LANG['cuowu'] ,$YZTOKEN) ) );
        $WHERE['shouji'] = $ZHANGHAO;
        $LX = 3;

    }else if( $CONN['regtype'] == '2'){

        // 邮箱登录

        if(! isemail( $ZHANGHAO )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'.$CONN['regtype']].$LANG['cuowu'],$YZTOKEN ) ) );
        $LX = 2;
        $WHERE['email'] = $ZHANGHAO;

    }else if( $CONN['regtype'] == '1'){

        //帐号登录
        $LX = 1;
        $WHERE['zhanghao'] = $ZHANGHAO;

    }else if( $CONN['regtype'] == '0'){

        //邮箱或者手机注册
        if( isemail( $ZHANGHAO )){

            $LX = 2;
            $WHERE['email'] = $ZHANGHAO;

        }else if( isshouji( $ZHANGHAO )){

            $WHERE['shouji'] = $ZHANGHAO;
            $LX = 3;

        }else{

            $LX = 1;
            $WHERE['zhanghao'] = $ZHANGHAO;
        }

    }

    if( !yzcode( 'vcode' , $CONN['sicode'] , 160 , 0 )  )exit( json_encode( apptongxin( array()  ,'415', '2' , $LANG['vcode'].$LANG['cuowu'] ,$YZTOKEN) ) );



    $YZHASH = 'sms/'.mima( $ZHANGHAO );

    $YZM = $Mem -> g( $YZHASH );
    if( $YZM )exit( json_encode( apptongxin( array()  ,'415', '1' , '验证码已经发送注意查收' ,$YZTOKEN) ) );

    $FASIP = $Mem -> ja( 'smsyz/'.IP(), 1 ,  mktime(0,0,0, date('m') , date('d') + 1 , date('Y') ) - time() );
    
    if( $FASIP > $CONN['ipnum'] ) exit( json_encode( apptongxin( array()  ,'415', '1' , '发送IP次数,超过限制'.$CONN['ipnum'],$YZTOKEN ) ) );
    $FStype = 1;

    if( $TOKEN == '1'){

        /*注册帐号 或者绑定*/
        $DATA = $D ->where( $WHERE )-> find();
        if( $DATA )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'].'已存在',$YZTOKEN ) ) );
    
    }else if( $TOKEN == '2'){
        /*找回密码*/
        $DATA = $D ->where( $WHERE )-> find();
        if(!$DATA )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['zhanghao'].'不存在',$YZTOKEN ) ) );

    }else if( $TOKEN == '3'){

        if( $LX == 1 )exit( json_encode( apptongxin( array()  ,'500', '1' , '不是手机或邮箱' ) ) );

        $FStype = 7;


    
    
    }else exit( json_encode( apptongxin( array()  ,'500', '1' , '不是手机或邮箱' ) ) );

    $yzm = rand( 100000 , 999999 );

    $YZTOKEN =  wenyiyz( $ZHANGHAO , $NAME = '' ,  $Mem );

    if( $LX == 1 ){
        //帐号自动发送

        $Mem -> s( $YZHASH , $yzm , 120 );
        exit( json_encode( apptongxin( $SHUJU  ,'200', '3' ,  $yzm ,$YZTOKEN  ) ) );


    }else if( $LX == 2 ){
        //邮箱发送

        $fanc = youxiang( $ZHANGHAO , array('YZM' => $yzm ,'type' => $TOKEN, $FStype ) );
        userlog( 0 , 2, $ZHANGHAO . ' '.$yzm . ' '.$fanc  );

        if( strstr( $fanc, 'success')  ){

            $Mem -> s( $YZHASH , $yzm , 120 );
            
        }else{

           
            exit( json_encode( apptongxin( array()  ,'415', '1' , '发送失败联系客服',$YZTOKEN ) ) );

        }

    }else if( $LX == 3 ){
        //手机发送

        $fanc = duanxin( $ZHANGHAO , array('YZM' => $yzm ,'type' => $TOKEN , $FStype ) );
        userlog( 0 , 3 , $ZHANGHAO . ' '.$yzm . ' '.$fanc  );

        if( strstr( $fanc, 'success')  ){

            $Mem -> s( $YZHASH , $yzm , 120 );

        }else{

            exit( json_encode( apptongxin( array()  ,'415', '1' , '发送失败联系客服' ,$YZTOKEN) ) );
        }

    }else exit( json_encode( apptongxin( array()  ,'500', '1' , '',$YZTOKEN ) ) );




}


$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG ,$YZTOKEN );