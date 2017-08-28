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




if( $MOD == 'get' ){

    /* 评论列表获取 */

    $PAGE = (int)( isset( $_POST['page'] ) ? $_POST['page'] : 1 );
    $NUM  = (int)( isset( $_POST['num']  ) ? $_POST['num']  : 8 );
    $CPID = (int)( isset( $_POST['cpid'] ) ? $_POST['cpid'] : 0 );
    if( $NUM < 8 ) $NUM = 8;
    if( $NUM > 88) $NUM = 88;
    if( $PAGE < 1) $PAGE = 1;


    $LIMIT = listmit( $NUM , $PAGE );

    $D = db('dingdanx');

    $hao    = $D -> where( array( 'cpid' => $CPID ,'pingoff' => '2','miaosufen IN' => '4,5' )) -> total();
    $zhong  = $D -> where( array( 'cpid' => $CPID ,'pingoff' => '2','miaosufen IN' => '3,4' ) ) -> total();
    $cha    = $D -> where( array( 'cpid' => $CPID ,'pingoff' => '2','miaosufen IN' => '1,2' )) -> total();
                   
    $zhonghe = $hao+$zhong+$cha;

    if($zhonghe <= 0) $zhonghe =1;
    $hde = sprintf('%.1f',$hao/$zhonghe *100);
    $zde = sprintf('%.1f',$zhong/$zhonghe *100);

    $cha = 100-$hde-$zde ;
    if($cha == 100) $cha = '0.0';

    $MSG = array(   'hao' => $hde ,
                  'zhong' => $zde ,
                    'cha' => $cha,
        
    
        );



    $CODE = -1;


    if( $CPID > 0){

        
        $DATA = $D -> where(array( 'cpid' =>   $CPID  , 'pingoff' => '2')) ->limit( $LIMIT ) ->order('id desc')-> select();
        if( $DATA ){

            $CODE = 1;

            foreach( $DATA as $ONG ){

                $tipian = '';

                if($ONG['ptupianji'] != ''){

                   $tipians = unserialize( $ONG['ptupianji'] );
                   $tipian =array();

                   foreach( $tipians as $kk){

                       $tipian[] = pichttp($kk);
                   }
                }

                $SHUJU[] = array( 
                                 'id' => $ONG['id'],
                             'pinfen' => $ONG['miaosufen'],
                           'pinguser' => $ONG['pinguser'],
                           'pingtime' => date( 'Y-m-d H:i:s',$ONG['pingtime']),
                            'miaoshu' => $ONG['miaoshu'],
                             'tupian' => $tipian,
                );
             
            
            }
        
        
        }

    }

  




}else if( $MOD == 'post' ){

    /* 添加评论 */

    if( $USERID  < 1 ) exit( json_encode( apptongxin( array()  ,'401', '-1' , 'logon' ) ) );
    $ORID  =  ( isset( $_POST['orderid']) ? $_POST['orderid'] : '' );
    $TOKEN =  isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */


    $D = db('dingdanx');

    $DATAS = $D ->where( array( 'orderid' => $ORID ))-> select();


    if( ! $DATAS ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '订单无法评论' , '' ) ) );
    
    $DATA =$DATAS['0'];

    if( !$DATA || $DATA['uid'] != $USERID ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法数据' , '' ) ) );
    if( $DATA['off'] < 2 )    exit( json_encode( apptongxin( array()  ,'415', '-1' , '订单无法评论' , '' ) ) );
    if( $DATA['pingoff'] != 0 ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '订单无法评论' , '' ) ) );

    if( ! wenyiyz( 'ding/'.$USERID, $TOKEN    , $Mem , 2 ) )
    exit( json_encode( apptongxin( array()  ,'415', '1' , $LANG['ttoken'].$LANG['cuowu']  ,  wenyiyz( 'ding/'.$USERID ,'' , $Mem ) ) ) );

    foreach( $DATAS as $ONG){


        if( !isset( $_POST['pingfen'][$ONG['id']] ) ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法评分' , '' ) ) );

        $PINFEN = (int)$_POST['pingfen'][$ONG['id']];
        if( $PINFEN < 1 || $PINFEN  > 5 )exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法评分 ' , '' ) ) );

        if( !isset( $_POST['miaoshu'][$ONG['id']] ) ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法评价' , '' ) ) );
        $MIAOSHU = anquanqu( $_POST['miaoshu'][$ONG['id']] );

        if( strlen( $MIAOSHU ) < 3 ||  strlen( $MIAOSHU )  > 500  )exit( json_encode( apptongxin( array()  ,'415', '-1' , '评价字符过长' , '' ) ) );

        $TUPINJI = array();

        $tupian = $D -> setbiao('fujian')-> where(array( 'uid' => $USERID ,'type' => 2 ,'guanid' => $ONG['id'] )) ->limit(5)->select();
        if( $tupian ){

           foreach( $tupian as $kddd){
          
            $TUPINJI[] = $kddd['pic'];
           
           }
        
        
        }

        $SHENGJI =  array( 'pingtime'  => time(),
                           'miaosufen' => $PINFEN,
                             'miaoshu' => $MIAOSHU,
                           'ptupianji' =>  $TUPINJI ? serialize($TUPINJI):'',
                          'pingoff' => 1
                );

        $D -> setbiao('dingdanx')->where( array( 'id' => $ONG['id'])) ->update( $SHENGJI  );
    }

}else if( $MOD == 'put' ){

    /*删除评论图片*/

    if( $USERID  < 1 ) exit( json_encode( apptongxin( array()  ,'401', '-1' , 'logon' ) ) );

    $ORID  =  ( isset( $_POST['orderid']) ? $_POST['orderid'] : '' );
    $TOKEN =  isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */
    $pic =  isset( $_POST['pic'] )   ? ( $_POST['pic'] ): '';


    $D = db('dingdanx');

    $DATA = $D ->where( array( 'orderid' => $ORID ))-> find();

    if( !$DATA || $DATA['uid'] != $USERID ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '非法数据' , '' ) ) );
    if( $DATA['off'] < 2 )    exit( json_encode( apptongxin( array()  ,'415', '-1' , '订单无法删除图片' , '' ) ) );
    if( $DATA['pingoff'] != 0 ) exit( json_encode( apptongxin( array()  ,'415', '-1' , '订单无法删除图片' , '' ) ) );

    if( strlen($pic) < 10  )  exit( json_encode( apptongxin( array()  ,'415', '-1' , '订单无法删除图片' , '' ) ) );


    $TYID = 2;


    $fan = $D -> setbiao('fujian') -> where(array( 'uid' => $USERID ,'type' => $TYID ,'pic' => $pic )) -> delete();
    if( !$fan )exit( json_encode( apptongxin( array()  ,'415', '-1' , '删除图片失败' , '' ) ) );

    @unlink(ONGPHP.'../'.$pic);
    @unlink(ONGPHP.'../'.$pic.'shuiying.jpg');
    @unlink(ONGPHP.'../'.$pic.'suoluetu.jpg');






    $YZTOKEN = wenyiyz( 'ding/'.$USERID ,  '' , $Mem );

}else if( $MOD == 'delete' ){


    /*  上传图片  */

    if( $USERID  < 1 ) exit( json_encode( apptongxin( array()  ,'401', '-1' , 'logon' ) ) );


    

    $ID    =  ( float ) ( isset( $_POST['id']) ? $_POST['id'] : 0 );
    $ORID  =  ( isset( $_POST['orderid']) ? $_POST['orderid'] : '' );
    $TOKEN =  isset( $_POST['ttoken'] )   ? ( $_POST['ttoken'] ): '';     /* token令牌 */

    $TYID = 2;

    $D = db('dingdanx');

    $DATA = $D ->where( array( 'id' => $ID ))-> find();

    if( !$DATA || $DATA['uid'] != $USERID ) exit( json_encode( apptongxin( array()  ,'415', '1' , '非法数据' , '' ) ) );

    if( $DATA['off'] < 2 )    exit( json_encode( apptongxin( array()  ,'200', '1' , '订单无法晒图失败' , '' ) ) );
    if( $DATA['pingoff'] != 0 ) exit( json_encode( apptongxin( array()  ,'200', '1' , '订单无法晒图失败' , '' ) ) );


    $_GET['uplx'] = isset( $_GET['uplx'] ) ? $_GET['uplx'] : 'image' ;


    $zshu = $D -> setbiao('fujian') -> where(array( 'uid' => $USERID ,'type' => $TYID ,'guanid' => $ID )) -> total();

    if( $zshu > 5 )exit( json_encode( apptongxin( array()  ,'415', '-1' , '图片已满无法上传' , '' ) ) );



    $DATAS = update( $ID , $TYID , 0 , $USERID );



    if( $DATAS['code'] == '1'){

        $SHUJU = $DATAS['content'];
        $CDOE = 1;

    }else  exit( json_encode( apptongxin( array()  ,'415', '-1' , '上传失败' , '' ) ) );


    $YZTOKEN = wenyiyz( 'ding/'.$USERID ,  '' , $Mem );
}



$DATA = apptongxin( $SHUJU  , $STAT , $CODE , $MSG , $YZTOKEN );