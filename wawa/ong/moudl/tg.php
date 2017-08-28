<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

plus(array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','tcpcc','mongodbcc','vcode','ipdiqu','update','route','sslget','sslpost'));
$Memsession =  $Mem = new txtcc();


if(  isset( $_GET['apptoken'] ) && strlen( trim( $_GET['apptoken']) ) == 128 ){ 
    
    session_id( $_GET['apptoken']);
}


setsession( $CONN['sessiontime'] );

$Mem1 = new txtcc(ONGPHP.'/mode/');
$shezhi = $Mem1 -> g('shezhi');

$appid = $shezhi['appid'];
$appsecret = $shezhi['appsecret'];

$LANG = include QTLANG;

$tuid = isset($_GET['tuid']) ? $_GET['tuid'] :'';




	if ($tuid!='') {

	  $_SESSION['tuid'] = (float)$tuid;


	}




if ( $_SESSION['uid'] ) {
    /*查询会员*/

    $D = db('');
    $huiyuans = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['uid'] ) ) -> find();
    // var_dump($huiyuans);
}


if ($shezhi['iswap']=='1' ) { /*如果允许wap端的话*/
  

  if (isset($huiyuans)  && is_array($huiyuans) ) {

  }else{

    msgbox('','user.php?action=reg');

  }

}



if (isset($huiyuans)  && is_array($huiyuans) ) {
    
 header("Location:".WZHOST."index.php");


}else{

     $wangzhi = WZHOST;
      $redirect_uri = urlencode ( $wangzhi.'weixin.php' );
      $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
      
  
      $_SESSION['backurl'] = $wangzhi."index.php";

      header("Location:".$url);
}
 





     // $wangzhi = WZHOST;
     //  $redirect_uri = urlencode ( $wangzhi.'weixin.php' );
     //  $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
      
  
     //  $_SESSION['backurl'] = $wangzhi."index.php";


   
     //  header("Location:".$url);





