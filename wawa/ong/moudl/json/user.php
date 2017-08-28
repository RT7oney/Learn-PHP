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
*/ 

if( $USERID  < 1 ) exit( json_encode( apptongxin( array()  ,'401', '-1' , 'logon' ) ) );

$USER = uid( $USERID );
if( !$USER  || $USER['off'] < 1 ) exit( json_encode( apptongxin( array()  ,'401', '-1' , 'logon' ) ) );

$ZHANGHAO = isset( $_POST['zhanghao'] ) ? ( $_POST['zhanghao'] ) : '';  /* 登录帐号  */
$PASS     = isset( $_POST['pass'] )     ? ( $_POST['pass'] )  : '';     /* 登录密码  */
$EPASS    = isset( $_POST['epass'] )    ? ( $_POST['epass'] ) : '';     /* 重复密码  */
$VCODE    = isset( $_POST['vcode'] )    ? ( $_POST['vcode'] ) : '';     /* 图形二维码*/
$CODE     = isset( $_POST['code'] )     ? ( $_POST['code'] )  : '';     /* 短信验证码*/
$TOKEN    = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */
$WHERE = array();


if( $MOD == 'get' ){

    /*读取数据*/
        $SHUJU = array( 'uid' => $USERID,
                   'name' => $USER['name'],
                   'jine' => $USER['jine'],
                  'jifen' => $USER['jifen'],
                  'level' => $USER['level'],
               'touxiang' => touxiang($USER['touxiang']),
                 'url' => mourl( $CONN['userword'],'',$CONN['fenge']),
               'houzui' =>$CONN['houzui']
              
        
    );

    $CODE = 99;



}else if( $MOD == 'post' ){

    /*新增数据*/

    /*  修改头像
        1 修改昵称
    */

    $LX = (float) isset( $_POST['lx']) ? $_POST['lx'] : 1;



    if( $LX == 1 ){

        $NC = anquanqu(isset( $_POST['nicheng'] ) ? $_POST['nicheng'] : '' );

        if( strlen( $NC ) < 2 || strlen( $NC ) > 60 ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '昵称错误[ 2-30 ]位'  ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );


        if(! wenyiyz( 'userid/'.$USERID , $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu']  ,  wenyiyz( 'userid/'.$USERID ,'' , $Mem ) ) ) );

        if( $NC != $USER['name'] ){

            $DB = db('user');

            $fan =$DB ->where( array( 'uid' => $USERID ) )-> update( array( 'name' => $NC ));

            if( $fan ){

                uid( $USERID , 1 );
                $CODE = 1;
                $MSG = $NC ;
                $YZTOKEN =  wenyiyz( 'userid/'.$USERID ,'' , $Mem );

            }else exit( json_encode( apptongxin( array()  ,'415', '-1' , '昵称错误'  ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );
        }

    }else if($LX == 2){

        $_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';


      

        if(! wenyiyz( 'userid/'.$USERID , $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'200', '-2' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'userid/'.$USERID ,'' , $Mem ) ) ) );

        $DATAS = update($USERID);

        if(  $DATAS['code'] == 1 ){

            $DB = db('user');

            $fan =$DB ->where( array( 'uid' => $USERID ) )-> update( array( 'touxiang' => $DATAS['content']['pic'] ));



            
            if( $fan ){

                uid( $USERID , 1 );
                $CODE = 1;
                $MSG = pichttp( $DATAS['content']['pic']) ;
                $YZTOKEN =  wenyiyz( 'userid/'.$USERID ,'' , $Mem );

            }else exit( json_encode( apptongxin( array()  ,'200', '-1' , '更新失败'  ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );


        
        
        
        }else exit( json_encode( apptongxin( array()  ,'200', '-1' , $DATAS['msg']  ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );
  


    
    
    }



}else if( $MOD == 'put' ){

    /*绑定手机系列*/

 

    $canshu = array( 'zhanghao#len#2-30',
                         'pass#len#6-30',
                         'code#len#6'
            );


    $FAN = yzpost( $canshu );

    if( $FAN['code'] == '0'){

        if( $FAN['biao'] == 'zhanghao')
            exit( json_encode( apptongxin( array()  ,'415', '-1' , $LANG[$FAN['biao'].$CONN['regtype']].' [ '.$FAN['msg'].' ] '.$LANG['cuowu'],$YZTOKEN ) ) );
        else
            exit( json_encode( apptongxin( array()  ,'415', '-1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
    }

    if( isemail( $ZHANGHAO )){

            

            $LX = 2;
            $FINDD['email'] = $WHERE['email'] = $ZHANGHAO;

    }else if( isshouji( $ZHANGHAO )){

            $FINDD['shouji'] = $WHERE['shouji'] = $ZHANGHAO;
            $LX = 3;

    }else  exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法字符串' ,  wenyiyz( 'userid/'.$USERID ,'' , $Mem ) ) ) );


    $DB = db('user');
    $DATA = $DB -> where($WHERE ) -> find();
    if( $DATA )exit( json_encode( apptongxin( array()  ,'415', '-1' , '已经被绑定'  ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );

   

    if(! wenyiyz( 'userid/'.$USERID , $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['code'].$LANG['cuowu']  ,  wenyiyz( 'userid/'.$USERID ,'' , $Mem ) ) ) );

    if(! yzsms( $ZHANGHAO , $CODE ) )exit( json_encode( apptongxin( array()  ,'415', '-1' , $LANG['code'].$LANG['cuowu'] ,wenyiyz( 'userid/'.$USERID ,'' , $Mem )  ) ) );


    $sql = $DB -> setshiwu('1') -> where( array( 'uid' => $USERID )) -> update( $WHERE );

    $fan = $DB -> qurey( $sql , 'shiwu');
    if( $fan ){
           $CODE = 1;
           uid( $USERID ,1);


    }else exit( json_encode( apptongxin( array()  ,'415', '-1' , '绑定失败'  ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );









}else if( $MOD == 'delete' ){


    /*绑定发送系列*/
  

    $canshu = array( 'zhanghao#len#2-30',
                         'pass#len#6-30',
            );


    $FAN = yzpost( $canshu );

    
    if( $FAN['code'] == '0'){

        if( $FAN['biao'] == 'zhanghao')
            exit( json_encode( apptongxin( array()  ,'415', '-1' , $LANG[$FAN['biao'].$CONN['regtype']].' [ '.$FAN['msg'].' ] '.$LANG['cuowu'],$YZTOKEN ) ) );
        else
            exit( json_encode( apptongxin( array()  ,'415', '-1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
    }

    if( isemail( $ZHANGHAO )){

            

            $LX = 2;
            $FINDD['email'] = $WHERE['email'] = $ZHANGHAO;
            if( $USER['email'] != '' ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '邮箱已经绑定' ,  wenyiyz( 'userid/'.$USERID ,'' , $Mem ) ) ) );

    }else if( isshouji( $ZHANGHAO )){

            $FINDD['shouji'] = $WHERE['shouji'] = $ZHANGHAO;
            if( (int)$USER['shouji'] != 0 ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '手机已经绑定' ,  wenyiyz( 'userid/'.$USERID ,'' , $Mem ) ) ) );
            $LX = 3;

    }else  exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法字符串' ,  wenyiyz( 'userid/'.$USERID ,'' , $Mem ) ) ) );

    

    if(! wenyiyz( 'userid/'.$USERID , $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['token'].$LANG['cuowu'] ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );

    $DB = db('user');
    $DATA = $DB -> where($WHERE ) -> find();
    if( $DATA )exit( json_encode( apptongxin( array()  ,'415', '-1' , '已经被绑定'  ,  wenyiyz( 'userid/'.$USERID,'' , $Mem ) ) ) );

    $YZHASH = 'sms/'.mima( $ZHANGHAO );

    $YZM = $Mem -> g( $YZHASH );
    if( $YZM )exit( json_encode( apptongxin( array()  ,'415', '-1' , '验证码已经发送注意查收' ,$YZTOKEN) ) );

    $FASIP = $Mem -> ja( 'smsyz/'.IP(), 1 ,  mktime(0,0,0, date('m') , date('d') + 1 , date('Y') ) - time() );
    
    if( $FASIP > $CONN['ipnum'] ) exit( json_encode( apptongxin( array()  ,'415', '1' , '发送IP次数,超过限制'.$CONN['ipnum'],$YZTOKEN ) ) );

    $yzm = rand( 100000 , 999999 );

    $YZTOKEN =  wenyiyz( 'userid/'.$USERID ,  '' ,  $Mem );

    $TOKEN = 1;

    if( $LX == 2 ){


        //邮箱发送

        $fanc = youxiang( $ZHANGHAO , array('YZM' => $yzm ,'type' => $TOKEN ) );

        userlog( 0 , 2, $ZHANGHAO . ' '.$yzm . ' '.$fanc  );

        if( strstr( $fanc, 'success')  ){

            $Mem -> s( $YZHASH , $yzm , 120 );
            
        }else{

           
            exit( json_encode( apptongxin( array()  ,'415', '-1' , '发送失败联系客服',$YZTOKEN ) ) );

        }

    }else if( $LX == 3 ){
        //手机发送

        $fanc = duanxin( $ZHANGHAO , array('YZM' => $yzm ,'type' => $TOKEN ) );
        userlog( 0 , 3 , $ZHANGHAO . ' '.$yzm . ' '.$fanc  );

        if( strstr( $fanc, 'success')  ){

            $Mem -> s( $YZHASH , $yzm , 120 );

        }else{

            exit( json_encode( apptongxin( array()  ,'415', '-1' , '发送失败联系客服' ,$YZTOKEN) ) );
        }

    }else exit( json_encode( apptongxin( array()  ,'500', '-1' , '',$YZTOKEN ) ) );






}

$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG , $YZTOKEN );