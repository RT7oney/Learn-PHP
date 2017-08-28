<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');


function kuaisu($url){

$ch=curl_init(); 
        $timeout=20; 
        curl_setopt($ch,CURLOPT_URL,$url); 
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
        $img=curl_exec($ch); 
        curl_close($ch); 
        return $img;




}



function shengcheng($name ,$userid ,$pic){

$ditu  = ONGPHP.'../tpl/font/haibao.png';

$elujin = ONGPHP.'../attachment/all/e'.$userid.'.png';

if ( !file_exists( $elujin ) ) {


global $Mem ,$LANG;


$access_token =  $Mem ->g('access_token');
  if( ! $access_token ){

            $csass = sslget('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$LANG['kjwxid'].'&secret='.$LANG['kjwxkey']);
            $woqi = (array)json_decode($csass);
            $access_token = $woqi['access_token'];
            if(strlen( $access_token )< 10)return false;
            $Mem ->s('access_token',$access_token ,'3600');
 }


	 $woqud = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$userid.'"}}}';
 $fanhui =  post( $woqud , 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token.'&type=image' );

 if( $fanhui ){

    $w = (array)json_decode( $fanhui );
	
 
 }



$woq = kuaisu(  WZHOST.'/ewm.php?haibao='.$w['url']  );

 


$llogac = kuaisu($pic);










ob_clean();
ob_start();
header("Content-type: image/png");


$im = imagecreatefrompng($ditu );
$COLOR = imagecolorallocate($im, 0, 0, 0);
$coordinates = imagefttext($im,22,0,178,408 ,$COLOR  , ONGPHP.'../tpl/font/11.ttf' ,$name, array('character_spacing' => 20));


$image = imagecreatefromstring($woq);
imagecopyresampled($im, $image, 143, 472, 0, 0, 248, 248, 300, 300);

$image2 = imagecreatefromstring($llogac);


imagecopyresampled($im, $image2, 216,261, 0, 0, 100, 100, 640, 640);



imagepng($im );
imagedestroy($im);
$err = ob_get_contents();
conWrite($elujin, $err);
ob_clean();

}


}





function haobaochuli(){


	     $USER =  kjcha(2 ,  $_SESSION['haibao']['openid']  ,  isset( $_SESSION['haibao']['unionid']) ?$_SESSION['haibao']['unionid'] : ''    );

        if( $USER ){   /*查询get 成功的直接 登录*/


            if( $USER['off'] == '0'){

                session_destroy();
                
                msgbox('帐号被停用',$TIAOURL);
            }

            


            if( isset( $_SESSION['uid'] ) && $_SESSION['uid'] > 0 );
            else{
             
                $_SESSION['uid']  = $USER['uid'];
                $_SESSION['ip']   = IP();
              

            }
          global $LANG, $Mem;


			$access_token =  $Mem ->g('access_token');

            if( ! $access_token ){

            $csass = sslget('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$LANG['kjwxid'].'&secret='.$LANG['kjwxkey']);
            $woqi = (array)json_decode($csass);
            $access_token = $woqi['access_token'];
            if(strlen( $access_token )< 10)return false;
            $Mem ->s('access_token',$access_token ,'3600');
           }


		   shengcheng($_SESSION['haibao']['nickname'],$_SESSION['uid']  ,$_SESSION['haibao']['headimgurl']);

		   	echo '<img src="/attachment/all/e'.$_SESSION['uid'].'.png" style="width:100%;"/>';


$elujin =  array( 'meide'=>new \CURLFile(ONGPHP.'../attachment/all/e'.$_SESSION['uid'].'.png'));

		  $fanhui =  post($elujin , 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type=image' );

		

		

		 
 
		  if( $fanhui ){

			  $woqis = (array)json_decode($fanhui);

			 

			     $neir = '{
    "touser":"'. $_SESSION['haibao']['openid'].'",
    "msgtype":"image",
    "image":
    {
      "media_id":"'.$woqis['media_id'].'"
    }
}';


		    $csass2 =  post( $neir , 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token );


	

			
		  
		  
		  
		  }






		

     

	


		}




}


if( isset( $_SESSION['haibao']) ){


haobaochuli();



}else{


	if( isset( $_GET['state'])){


		$csass = sslget('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$LANG['kjwxid'].'&secret='.$LANG['kjwxkey']."&code=".$_GET['code'].'&grant_type=authorization_code');

    if( $csass ){

        $woqi = (array)json_decode( $csass );

		  $toke = $woqi['access_token'];
          $openid = $woqi['openid'];
		   $ddd =  sslget('https://api.weixin.qq.com/sns/userinfo?access_token='.$toke.'&openid='.$openid.'&lang=zh_CN');

          if( $ddd ){
     
           $ddddd = (array)json_decode( $ddd );

		   if( $ddddd ['openid'] ){





			  $_SESSION['haibao'] = $ddddd;
			  haobaochuli();
		   
		   
		   
		   }else exit( $ddd  );
		 

		  }else exit( $ddd  );



	}else exit( $csass );



	
	
	
	
	}else{



       $URL = ('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$LANG['kjwxid'].'&redirect_uri='.urlencode(WZHOST.'tg.php?y=haibao').'&response_type=code&scope=snsapi_base&state=2');
       Header("Location: ".$URL);

        exit();

	}



}