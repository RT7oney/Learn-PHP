<?php if(!defined('ONGPHP'))exit('ErrorONGSOFT');
plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );

$Memsession =  $Mem = new txtcc();
$Mem1 = new txtcc(ONGPHP.'/mode/');
$shezhi = $Mem1 -> g('shezhi');

$appid = $shezhi['appid'];
$appsecret = $shezhi['appsecret'];

setsession( $CONN['sessiontime'] );

$LANG = include QTLANG;

$WZHOST = WZHOST;

$code = isset($_GET['code']) ? $_GET['code'] : '' ;

if ($code!='') {

	//初始化
	$ch = curl_init();

	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	//执行并获取HTML文档内容
	$output = curl_exec($ch);

	//释放curl句柄
	curl_close($ch);

}


    //打印获得的数据
    $shuzu = json_decode($output,true);
    $access_token = $shuzu['access_token'];
    $openid = $shuzu['openid'];

    if ($openid) {
                    //初始化
                    $ch = curl_init();

                    //设置选项，包括URL
                    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

                    //执行并获取HTML文档内容
                    $output = curl_exec($ch);

                    //释放curl句柄
                    curl_close($ch);

                    //打印获得的数据
                    $yonghu = json_decode($output,true);

                    $openid=  $yonghu['openid'];
                    $nickname = $yonghu['nickname'];
                    $sex = $yonghu['sex'];
                    $diqu = $yonghu['country'].$yonghu['province'].$yonghu['city'];
                    $touxiang = $yonghu['headimgurl'];

                    $D = db('');

                    $user = $D ->setbiao('user')-> where( array( "openid" => $openid ) ) -> find();

                    if (is_array($user)) {

                    $_SESSION['uid'] = $user['uid'];
                    header("Location:".$_SESSION['backurl'] );

                    }else{


	                    $D = db('user');
	                     /* 快捷注册 */
	                    $JICHENG = $WHERE;

	                    $WHERE['name']  = $nickname;
	                    $WHERE['atime'] = time();
	                    $WHERE['off']   = 1;
	                    $WHERE['openid']   = $openid;
	                    $WHERE['mima']  = mima("") ;
	                    $WHERE['touxiang'] = $touxiang;
	                    $WHERE['ip']    = ip();
	                    $WHERE['level'] = (float)$CONN['level'];

	                    if( isset( $_SESSION['tuid'] ) ){

		                        if( $_SESSION['tuid']  > 0){

		                            $tui = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['tuid'] ) ) -> find();

		                            if( $tui ){

		                                    $WHERE['tuid'] = $_SESSION['tuid'];

		                                    for( $i = 1 ; $i < $CONN['tujishu'] ; $i++ ){

		                                         $wds = $i-1;
		                                         if($wds < 1) $wds= '' ;
		                                         $WHERE['tuid'.$i] = $tui['tuid'.$wds];

		                                    }
		                            }
		                        }

	                    }



                  	  $sql  =  $D -> setshiwu('1') -> insert( $WHERE );

                  	  $FAN  =  $D -> qurey( $sql , 'shiwu' );

	                    if( $FAN ){

	                        $DATA = $D ->setbiao('user')-> where( $WHERE )-> find();

	                        if( $DATA ){
	                            $_SESSION['uid'] = $DATA['uid'];
	                            
	                            $_SESSION['ip']  = ip();
	                             
	                             header("Location:".$_SESSION['backurl'] );

	                        }


	                    }
                    }


    }else{

        echo "<pre>";
        var_dump( $shuzu );
        echo "</pre>";

    }










