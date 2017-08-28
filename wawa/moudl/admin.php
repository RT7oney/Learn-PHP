<?php if(!defined('ONGPHP'))exit('ErrorONGSOFT');

plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );


$Memsession = $Mem =  new txtcc();


$Mem1 = new txtcc(ONGPHP.'/mode/');

//$CONN['typems'] = 2;
//echo scurl('',1);
//exit();
if( isset( $_GET['apptoken']) && strlen( $_GET['apptoken'] ) > 10 ) session_id( $_GET['apptoken'] );


setsession( $CONN['sessiontime'] );


$_SESSION['huotime'] = time();


if( isset($_GET['vocde'])){

    echo vcode('3','0123456789',4,130,40);
    $_SESSION['linshtm'] = time();
    exit();
}




$LANG = include HTLANG;

if( !isset( $_SESSION['houid'])){

    if( isset($_POST['action'])){
     
     
        if( $_POST['action'] == 'login'){

            if( !yzcode( 'code' , $CONN['sicode'] , 160 )  ) msgbox( $LANG['code'].$LANG['cuowu'],'?');

            if( !yztoken('token') ) msgbox( $LANG['token'].$LANG['cuowu'],'?');

            $NAME = $_POST['name'] = trim( $_POST['name']);
            $PASS = $_POST['pass'] = trim( $_POST['pass']);

            $canshu = array('name#len#2-30',
                            'pass#len#6-30',
                    );

            $FAN = yzpost( $canshu  );

            if( $FAN['code'] == '0') msgbox( $LANG[$FAN['biao']].$FAN['msg'].$LANG['cuowu'] ,'?');

            $admin = db('admin');

            $USER = $admin ->where(array('name' => $NAME))-> find();

            if( !$USER ) msgbox( $LANG['loginpass'].$LANG['cuowu'].'!','?');
            
            if( $USER['off'] < 1 && $USER['id'] > 1 )msgbox( $LANG['loginname'].$LANG['tingyong'],'?');
            
            $MIMA = mima($PASS);
            
            if($MIMA != $USER['pass'])msgbox( $LANG['loginpass'].$LANG['cuowu'].'!!','?');

            $_SESSION['houid'] = $USER['id'];

            $Mem -> s('adminlogin/'. $USER['id'] ,IP());

            adminlog($USER['id'],0);
            msgbox('','?');

        }

        exit('error');
    }


    $_SESSION['token'] = token();

    include  HTPL.'login.php';

}else{

    $IP = ip();
    $USER = adminuid($_SESSION['houid']);

    if( isset( $_GET['action'])  && $_GET['action'] == 'quite'){

        adminlog($USER['id'],1);
        session_destroy();
        msgbox( $LANG['tuichu']. $LANG['chenggong'], '?');

    }

    $DLIP = $Mem -> g( 'adminlogin/'. $USER['id'] );

    if( $DLIP !=  $IP && $USER['yanzhengip'] == 1 ){

           adminlog($USER['id'],2,serialize($DLIP));
           session_destroy();
           msgbox($LANG['tuichu'].$LANG['chenggong'],'?');
    }

    $LEVEL  = adminfenzu( $USER['type'] );

    if( $LEVEL < 1){ 

        $LEVEL = array();
        $LEVEL['name'] = $LANG['chuangshiren'];
    }

    $WHERE = array();

    $ACTION = array(

                'cd1' => array( 'adminfenzu',
                                'admin',
                                'adminlog'
                               ),


                'cd2' => array( 'user',
                                'jinelog',
                                // 'jifenlog',
                                'huobilog',
                                // 'userlog',
                              ),

                'cd5' => array( 
                    'type',
                                'center',
                                // 'pinglun',
                                // 'type1',
                                // 'center1',
                              ),


                // 'cd6' => array( 'chengshi',
                //                 'yunfei',
                //                 'shouhuo'
                //           ),

                'cd7' => array(

                                 // 'dingdan',
                                // 'dingdanx',
                                // 'fahuo',
                                // 'chanpingg',
                                 'pay',
                                // 'hongbao',
                         ),



                // 'cd3' => array( 'fujian'),

                'cd4' => array( 

                    'logac',
                                'xtset',
                                'youqing',
                                'uiset',
                                // 'memcached',
                                 // 'mkhtml',
                               // 'sqlbak',
                                // 'scurl'
                                
                                
                               ),
                'cd8' => array(
                    'wawatixian',
                 
                    'ajax',
                    'zhuawawashezhi',
                        'yongjinjilu',
                   
                    
                    

                    )
                
    );

    $YANZQX =  $USER['type'] == '0'? $ACTION : unserialize($LEVEL['shezhi']);

    $HUOBI = array( $CONN['jine'] ,$CONN['jifen'],$CONN['huobi'] );

    if(isset( $_GET['action'])){

        $NEWS = array();
                
        foreach( $ACTION as $kx => $vv){

            if( is_array( $vv) ){

                foreach($vv as $woqus){

                    $NEWS[$woqus]=$kx;
                }
            }
        }

        $MOD = array( 'soso' => '',
                      'edit' => '',
                      'del'  => '',
                      'add'  => '',
                      'only' => '',
           );

        $NEWS['plus'] ='';

        if( isset( $NEWS[$_GET['action']] )){
        
            $HTLJIN = HTPL.'action/'.$_GET['action'].'.php';
            if( file_exists( $HTLJIN)){ 

                $AC  = $_GET['action'];

                $MO  = isset( $_GET['mode'])? $_GET['mode']:'soso';

                if( isset( $MOD[$MO])){
                    
                    if( $_POST){

                        foreach( $_POST as $k => $v ){

                            if(! is_array( $v) ) $_POST[$k] = trim($v);

                        }
                    }

                    if($USER['type'] == '0') include $HTLJIN;
                    else{

                        if(!$YANZQX || !isset($YANZQX[$NEWS[$AC]][$AC][$MO]) ){

                            $MSGBOX = $LANG['quanxian'].' '.$MO ;
                            include HTPL.'msgbox.php';
                        }else include $HTLJIN;
                    }


                }else{

                    $MSGBOX = $LANG['nomodou'].' '.$MO ;
                    include HTPL.'msgbox.php';
                }
        
            }else{

                $MSGBOX = $LANG['noaction'].' '.$_GET['action'];
                include HTPL.'msgbox.php';
            }

        }else{

            $_GET['action'] = 'main';
            include  HTPL.'main.php';
        }
   
    }else include  HTPL.'index.php';

}