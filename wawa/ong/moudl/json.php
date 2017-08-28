<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );

$HUOBI = huobi( $CONN,2 );
$HUOBIICO = array( '￥' , $CONN['jifen'] ,  $CONN['huobi'] , $CONN['hongbao'] );

$Memsession = $Mem = new txtcc();



if( !$_POST ) $_POST = $_GET ;
else if( isset( $_GET[ 'uplx'] )){

    $_POST =  array_merge($_POST, $_GET);
}

if( isset( $_POST['y'])){

    $MODE   = array(
                    'post' => '增加',
                  'delete' => '删除',
                     'put' => '修改',
                     'get' => '获取数据',
                );

    $ACTION = array( 
                   'index' => '默认通信接口',
                'gouwuche' => '购物车',
                   'login' => '登录注册表',
                 'shouhuo' => '收获地址信息',
                    'ding' => '订单管理',
             'hongbaolist' => '红包列表',
                    'user' => '用户中心编辑',
                  'cplist' => '产品列表',
                 'pinglun' => '自己的评论列表',
                    'jine' => '金额记录',
                   'jifen' => '积分记录',
                   'huobi' => '货币记录',
                  'msgbox' => '消息中心',
                 'cmstype' => '分类单页',
                'cmsxqing' => '内容详情',
                'chongzhi' => '支付列表',
                'ajax' => 'ajax',
                 

                );

    $LANG = include QTLANG;

    /* 需要登录 操作的ac */

    $ACUSER = array( 'gouwuche' , 'login' , 'code' ,'shouhuo','ding','hongbaolist','user','pinglun','jine','jifen','huobi','msgbox','chongzhi');


    

    $USERID = 0;

    $MOD = strtolower( isset( $_POST['d'] ) ? $_POST['d'] :'get' );

    if( isset( $ACTION[ $_POST['y']] ) ){

        if( ! isset( $MODE[ $MOD])) exit( json_encode( apptongxin( array()  ,'500', '-1' , 'no mode' ) ) );

        if( in_array( $_POST['y'], $ACUSER )){

            if( isset( $_POST['apptoken'] ) && strlen( trim( $_POST['apptoken']) ) > 60 ){

                session_id( $_POST['apptoken']);
            }

            setsession( $CONN['sessiontime'] );

            $USERID = (float) ( isset( $_SESSION['uid'] )? $_SESSION['uid'] : 0 );

            
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
        }

        if( $CONN['jsontime'] >  0  &&  $MOD == 'get' ){ 

            $HASH = 'json/' . mima( $USERID . '_' . implode( '@' , $_POST ) );
            $DATA = $Mem -> g( $HASH );
            if( $DATA ) exit( json_encode( $DATA ) );
        }

        $DATA = apptongxin( array( 'ac' => $_POST['y'] , 'mode' => $MOD ) , '200' , '0' , '默认数据' );

        $LUJIN =  ONGPHP.'moudl/json/' . $_POST['y'] . '.php';

        if( file_exists( $LUJIN ) ){

            $SHUJU = array();
            $CODE  = 1;
            $MSG   = '';
            $STAT  = 200;
            $YZTOKEN  = '';

            include $LUJIN;

            if( $CONN['jsontime'] >  0 &&  $MOD == 'get') $Mem -> s ( $HASH ,$DATA , $CONN['jsontime'] );

                exit( json_encode( $DATA ) );

        }else   exit( json_encode( apptongxin( array()  ,'500' , '-1' , 'no file' ) ) );

    }else       exit( json_encode( apptongxin( array()  ,'500' , '-1' , 'no ac' ) ) );

}else           exit( json_encode( apptongxin( array()  ,'500' , '-1' , 'no ac' ) ) );