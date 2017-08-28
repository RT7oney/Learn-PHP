<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );


//if(! isset( $_SERVER['HTTP_REFERER']) ) exit( 'Greetings to your family');
$Memsession =  $Mem = new txtcc();

$LANG = include QTLANG;
$Mem1 = new txtcc(ONGPHP.'/mode/');

if( isset( $PLAYFS ) && isset( $PAYFILE )){


      $PAYAC = xitongpay( $PAYFILE );

      $lujin = ONGPHP.'moudl/pay/'. anquanqu( $PAYAC ['payfile'] ).'.php';

      if( file_exists( $lujin ) ) include $lujin;

      exit();
}

$FYUTIME = $CONN['FYUTIME'] ; //防御秒数
$FYUNUM  = $CONN['FYUNUM'] ;  //防御数量

/* 防御公式
   每个ip 连接次数

   防御秒数 最多 请求 防御数量 次数
*/
$IP = ip();

if( $FYUTIME > 0 ){ 

$FYUCC = 'fangyucc/'.mima( $IP );

$YUCC  = $Mem -> g( $FYUCC );

        if( $YUCC ){

            $YUCC = $Mem -> ja( $FYUCC , 1 , $FYUTIME );

            if( $YUCC > $FYUNUM) msgbox( 'CC 防御,请稍后再操作', WZHOST );

        }else $Mem -> s( $FYUCC , 1 , $FYUTIME );

}




if(  isset( $_GET['apptoken'] ) && strlen( trim( $_GET['apptoken']) ) > 60 ){ 
    
    session_id( $_GET['apptoken']);
}


setsession( $CONN['sessiontime'] );


if(! isset( $_SESSION['ip'] )) $_SESSION['ip'] = $IP;

if( $CONN['yanzhengip'] == 1 && $IP != $_SESSION['ip'] ) unset( $_SESSION['uid'] );


$USERID = (float) ( isset( $_SESSION['uid'] )? $_SESSION['uid'] : 0 );

if( $USERID < 1){

    msgbox('',mourl( $CONN['userword'].$CONN['fenge'].'login') );
}

$USER = uid( $USERID );

if( $USER ['off'] == '0'){

    unset( $_SESSION['uid'] );

    msgbox('',mourl( $CONN['userword'].$CONN['fenge'].'login') );

}

if( isset( $_GET['y'] ) ){

    $JINE =  ceil(isset( $_GET['jine']) ? $_GET['jine']: 1 );

    if( $JINE <= 0 ) $JINE = 1;

    $diqu = 0;

    $ORDER = isset( $_GET['order']) ? $_GET['order']: '';

    //if( ! isset( $_SESSION['paydd'] ) ||  $_SESSION['paydd'] == time() ) msgbox('',  mourl( $CONN['userword'].$CONN['fenge'].'pay') );

  

    if( $ORDER != '' && strlen( $ORDER ) < 10  ) msgbox('', WZHOST );



    $PAYTY = (int) ( isset( $_GET['paytype']) ? $_GET['paytype'] : 0 );

    $woqu = xitongpay( '-2' );




    if( !$woqu || !is_array( $woqu ) || count( $woqu ) < 1)  msgbox( '没有支付方式' ,  WZHOST);

    unset( $_SESSION['paydd'] );
    
    $PAYAC = isset( $woqu[ $PAYTY ] ) ? $woqu[ $PAYTY ] :reset ( $woqu );





    $CONN['payjine'] = isset( $CONN['payjine'] ) ? $CONN['payjine'] : 1;
  
    if( $JINE < $CONN['payjine'] ) $JINE = $CONN['payjine']; 
     $D = db( 'dingdan' );



    if(isset( $_GET['cha'] ) &&  $ORDER != "" ){/*如果存在统一订单id和cha*/

        $DINDATA = $D ->where( array( 'tongyiid' => $ORDER ) )-> select();

        if(! $DINDATA || $DINDATA['0']['uid'] != $USERID ) msgbox('非法订单',  mourl( $CONN['userword']));

        $zong    = 0;
        $hongbao = 0;

        foreach($DINDATA as $ooo){
           
            if( $ooo['type'] == '0'){

                $hongbao = $ooo['hongjine'];
                $zong   += $ooo['payjine'];
            }
        }

        $JINE = $zong - $hongbao;

        if( $JINE <= 0 ){

            $fan = payzhifu(   $USERID   , $ORDER );

            if($fan) msgbox('支付成功',  mourl( $CONN['userword']));

            else msgbox('支付失败',  mourl( $CONN['userword']));
        }
    
    }

    $paylx = (int) ( isset( $_GET['paylx']) ? $_GET['paylx'] : 1 );


    if( $paylx == 1 ) $diqu = 0;
    else              $diqu = 1;



    $DINGID = array(     'uid' => $USERID ,
                     'orderid' => orderid() ,
                     'payjine' => $JINE ,
                        'off'  => 1 ,
                        'type' => $ORDER == '' ? 1 :  2,
                    'tongyiid' => $ORDER,
                     'paytype' => $PAYAC['id'],
                       'atime' => time(),
                          'ip' => $IP ,
                       'diqu' => $diqu,
                       'lailu' => lailu()
    );

    
    $DINGID['mhash'] = md5( implode('前', $DINGID) ). md5( implode('后', $DINGID ));

    usleep( rand( 500 , 50000 ) );

   
 if(isset( $_GET['cha'] ) &&  $ORDER != "" ){/*如果存在统一订单id和cha*/
     $sql = $D -> setshiwu(1)-> where( array("tongyiid"=>$ORDER))-> update($DINGID);
}else{
    $sql = $D -> setshiwu(1) -> insert( $DINGID );
}
    // $sql = $D -> setshiwu(1) -> insert( $DINGID );

    $fanhui = $D -> qurey( $sql , 'shiwu' );

    if( $fanhui ){



        $lujin = ONGPHP.'moudl/pay/'. anquanqu( $PAYAC ['payfile'] ).'.php';

        if( file_exists( $lujin ) ){

            $PLAYFS = 1;
         
            include $lujin;
        
        }else msgbox('支付文件错误',WZHOST);

    }else msgbox('插入失败联系管理',WZHOST);


}else{

    msgbox('',  mourl( $CONN['userword'].$CONN['fenge'].'pay') );
}