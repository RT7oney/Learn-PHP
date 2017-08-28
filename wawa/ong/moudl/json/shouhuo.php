<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');
/*

收货地址处理
get   获取收货地址列表
post  新增收货地址
delete 删除收获地址
put    修改收货地址  lx = 1 默认收货 其他修改值

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

$D = db( 'shouhuo' );


if( $MOD == 'get' ){

    /*读取数据*/

    $ID  = (int)( isset( $_POST['id'] ) ? ( $_POST['id'] ) : 0 );    /* 分类id */

    $WHERE = array( 'uid' => $USERID );

    if( $ID  > 0){

        $WHERE['id'] = $ID;

        $SHUJU = $D -> where(  $WHERE ) -> find();
        if( !$SHUJU ) exit( json_encode( apptongxin( array()  ,'404', '-1' , '产寻失败' ) ) );

    }else{

        $SHUJU  = $D -> where(  $WHERE ) -> select();
    
    }

}else if( $MOD == 'post' ){


    /*新增数据*/

    $TOKEN    = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */

    if(! wenyiyz( 'shouhuo_'.$USERID, $TOKEN    , $Mem , 2 ) )exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'shouhuo_'.$USERID ,'' , $Mem ) ) ) );

    $ZS = $D ->where( array( 'uid' => $USERID ))-> total();
    if( $ZS >= $CONN['shnum'] ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '收货地址达到上线 '.$CONN['shnum'].' 条' ) ) );

    $LANG['xingming'] = '姓名';
    $LANG['diqu'] = '收货地区';
    $LANG['xiangqing'] = '收货详情';
    $LANG['shouji'] = '手机号码';

    $XINGMING  =  isset( $_POST['xingming'] ) ? ( $_POST['xingming'] ) : '' ;      /* 姓名  */
    $DIQU      = (int)(isset( $_POST['diqu'] ) ? ( $_POST['diqu'] )  : '' ) ;     /* 收货地区  */
    $XIANGQING = anquanqu( isset( $_POST['xiangqing'] ) ? ( $_POST['xiangqing'] ) : '' );     /* 收获详情  */
    $SHOUJI    = isset( $_POST['shouji'] ) ? ( $_POST['shouji'] ) : '' ;           /* 收货 手机 */
    $BEIZHU    = anquanqu( isset( $_POST['beizhu'] ) ? ( $_POST['beizhu'] ) : '' ) ;
    $MOREN     = (int)( isset( $_POST['moren'] ) ? ( $_POST['moren'] ) : '' );    /* 默认收货地址 */
    
    if( $MOREN >= 1) $MOREN = 1;
    else if($MOREN < 1) $MOREN =0;
    else $MOREN = 1;

    $canshu = array( 'xingming#len#2-30',
                         'diqu#len#6',
                    'xiangqing#len#2-120',
            );

    $FAN = yzpost( $canshu );

    if( $FAN['code'] == '0'){

            exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
    }

    if(! isshouji( $SHOUJI )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[ 'shouji' ].' [ 11 ] '.$LANG['cuowu'] , $YZTOKEN ) ) );

    $DATA = array();

    $shngji = chengshiid( $DIQU );
    $shngji[] = $DIQU;
    $dizhi =  chengshijiexi( $D , $shngji);
    $D -> setbiao('shouhuo');

    $DATA['beizhu'] = implode(' ', $dizhi) .' '. $XIANGQING ;
    $DATA['uid'] = $USERID;
    $DATA['xingming'] = $XINGMING;
    $DATA['shouji'] = $SHOUJI ;
    $DATA['zuoji'] = $BEIZHU ;
    $DATA['diqu'] = $DIQU ;
    $DATA['dizhi'] = $XIANGQING ;
    $DATA['atime'] = time();
    $DATA['ip'] = IP();

    if( $MOREN == '1'){  

        $DATA['off'] = 1;
        $D ->where( array( 'uid' => $USERID ))->update(array('off' => 0 ));

    }else  $DATA['off'] = 0;

    $DATA['token'] = md5( $DATA['uid'].$DATA['xingming'].$DATA['shouji'].$DATA['zuoji'].$DATA['diqu'].$DATA['dizhi']);

    $ff = $D ->where( array('token' => $DATA['token'] ) )->find();

    if( $ff )exit( json_encode( apptongxin( array()  ,'415', '1' , '已存在请勿重复添加' ,$YZTOKEN) ) );

    $sql = $D ->setshiwu('1') -> insert($DATA);

    $fan =  $D -> qurey($sql , 'shiwu');
    if( !$fan ) exit( json_encode( apptongxin( array()  ,'415', '1' , '插入失败' ,$YZTOKEN) ) );


}else if( $MOD == 'put' ){

    /* 修改数据 */

    $TOKEN    = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */

    $ID        = (int)( isset( $_POST['id'] ) ? ( $_POST['id'] ) : '' );    /* 分类id */

    if(! wenyiyz( 'shouhuo_'.$USERID, $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'shouhuo_'.$USERID ,'' , $Mem ) ) ) );

    $LANG['xingming'] = '姓名';
    $LANG['diqu'] = '收货地区';
    $LANG['xiangqing'] = '收货详情';
    $LANG['shouji'] = '手机号码';


    $XINGMING  = anquanqu( isset( $_POST['xingming'] ) ? ( $_POST['xingming'] ) : '') ;      /* 姓名  */
    $DIQU      = (int)(isset( $_POST['diqu'] ) ? ( $_POST['diqu'] )  : '' ) ;     /* 收货地区  */
    $XIANGQING = anquanqu( isset( $_POST['xiangqing'] ) ? ( $_POST['xiangqing'] ) : '' );     /* 收获详情  */
    $SHOUJI    = isset( $_POST['shouji'] ) ? ( $_POST['shouji'] ) : '' ;           /* 收货 手机 */
    $BEIZHU    = anquanqu( isset( $_POST['beizhu'] ) ? ( $_POST['beizhu'] ) : '' ) ;
    $MOREN     = (int)( isset( $_POST['moren'] ) ? ( $_POST['moren'] ) : '' );    /* 默认收货地址 */
    $LX        = (int)( isset( $_POST['lx'] ) ? ( $_POST['lx'] ) : 0 ); /*确认类型*/ 

    if( $MOREN >= 1) $MOREN = 1;
    else if($MOREN < 1) $MOREN =0;
    else $MOREN = 1;

     $DATA = array();



    if( $LX < 1){

        $canshu = array( 'xingming#len#2-30',
                             'diqu#len#6',
                        'xiangqing#len#2-120',
                );

        $FAN = yzpost( $canshu );

        if( $FAN['code'] == '0'){

                exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[$FAN['biao']].' [ '.$FAN['msg'].' ] ' .$LANG['cuowu'] ,$YZTOKEN) ) );
        }

        if(! isshouji( $SHOUJI )) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG[ 'shouji' ].' [ 11 ] '.$LANG['cuowu'] , $YZTOKEN ) ) );

       

        $shngji = chengshiid( $DIQU );
        $shngji[] = $DIQU;
        $dizhi =  chengshijiexi( $D , $shngji);
        $D -> setbiao('shouhuo');

        $DATA['beizhu'] = implode(' ', $dizhi) .' '. $XIANGQING ;
        $DATA['uid'] = $USERID;
        $DATA['xingming'] = $XINGMING;
        $DATA['shouji'] = $SHOUJI ;
        $DATA['zuoji'] = $BEIZHU ;
        $DATA['diqu'] = $DIQU ;
        $DATA['dizhi'] = $XIANGQING ;

    }

    $DATA['atime'] = time();
    $DATA['ip'] = IP();

    if( $MOREN == '1' ){  
        $DATA['off'] = 1;
        $D ->where( array( 'uid' => $USERID ))->update(array('off' => 0 ));

    }else{  
        
        $DATA['off'] = 0;
        $tji = $D ->where( array( 'uid' => $USERID,'off'=> 1 ))-> total();
        if($tji < 1 )$DATA['off'] = 1;
    }

    if( $LX < 1 )
    $DATA['token'] = md5( $DATA['uid'].$DATA['xingming'].$DATA['shouji'].$DATA['zuoji'].$DATA['diqu'].$DATA['dizhi']);

    $sql =  $D -> setshiwu('1') ->where( array( 'id' => $ID ,'uid' => $USERID ) )-> update($DATA);
    $fan =  $D -> qurey($sql , 'shiwu');
    if( !$fan ) exit( json_encode( apptongxin( array()  ,'415', '1' , '修改失败' ,$YZTOKEN) ) );

}else if( $MOD == 'delete' ){

    /*删除数据*/

    $ID     = (int)( isset( $_POST['id'] ) ? ( $_POST['id'] ) : '' );    /* 分类id */

    $TOKEN  = isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */

    if(! wenyiyz( 'shouhuo_'.$USERID, $TOKEN    , $Mem , 2 ) ) exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'shouhuo_'.$USERID ,'' , $Mem ) ) ) );


    $DATA = $D ->where( array( 'id' => $ID ))->find();

    if( ! $DATA || $DATA['uid'] != $USERID ) exit( json_encode( apptongxin( array()  ,'415', '1' , '非法删除' ,$YZTOKEN) ) );

    $fan  = $D -> where( array( 'id' => $ID )) -> delete();

    if( $fan ){

            userlog(  $USERID , 4 , serialize( $DATA ) ) ;
            

    }else exit( json_encode( apptongxin( array()  ,'415', '1' , '删除失败' ,$YZTOKEN) ) );


}

$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG );