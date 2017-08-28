<?php if(!defined('ONGPHP'))exit('ErrorONGSOFT');
plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );

$Memsession =  $Mem = new txtcc();

setsession( $CONN['sessiontime'] );

$LANG = include QTLANG;


$WZHOST = WZHOST;
/*

    [kjqqid] => 
    [kjqqkey] => 
    [kjqqname] => 

    [kjwxid] => 
    [kjwxkey] => 
    [kjwxname] => 

    [kjkwxid] => 
    [kjkwxkey] => 
    [kjkwxname] => 

    [kjweiboid] => 
    [kjweibokey] => 
    [kjweiboname] => 

    [kjzfbid] => 
    [kjzfbkey] => 
    [kjzfbname] => 


*/

$QQLOGIN = ''; //QQ登录   1 
$WXLOGIN = ''; //威信登录 2 
$WBLOGIN = ''; //微博登录 3
$ALLOGIN = ''; //支付宝登录 4
$WXKLOGIN = ''; //威信开放登录 5

$ACTION = array( '1' => 'qq',
                 '2' => 'weixin',
                 '3' => 'weibo',
                 '4' => 'alipay',
                 '5' => 'weixinopen',
);

$LX = (float)( isset($_GET['y']) ? $_GET['y'] : 1);

if( ! isset( $ACTION[$LX] ) )msgbox('非法参数',$WZHOST);

$IP = ip();

if( isset( $_SESSION['uid'] ) && $_SESSION['uid'] > 0 ) $start = 2;
else $start = 1;

if( isset( $_GET['isapp']) )  $start = 'isapp';

if($LX == 1){

    //qq
    $URL = 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id='.$LANG['kjqqid'].'&state='.$start.'&redirect_uri='.urlencode($WZHOST.'login/'. $ACTION[$LX].'.php');

    Header("Location: ".$URL);

    exit();

}else if($LX == 3){

    //微博[kjweiboid] =>  [kjweibokey] => 

     $URL = 'https://api.weibo.com/oauth2/authorize?client_id='.$LANG['kjweiboid'].'&forcelogin=false&redirect_uri='.urlencode($WZHOST.'login/'. $ACTION[$LX].'.php');
     Header("Location: ".$URL);

     exit();



}else if($LX == 4){

      //alipay

      $ZUHE = array(  'service' => 'alipay.auth.authorize',
                    'partner' => $LANG['kjzfbid'],
                    '_input_charset' => 'utf-8',
                    
                    'return_url'=> ( $WZHOST.'login/'. $ACTION[$LX].'.php'),
                    'target_service' => 'user.auth.quick.login',
      );
      $zuhe = argSort($ZUHE);
      $ZUHE['sign'] = md5(getarray($zuhe).$LANG['kjzfbkey']);
      $ZUHE['sign_type'] = 'MD5';
      $URL = 'https://mapi.alipay.com/gateway.do?'.getarray($ZUHE);
      Header("Location: ".$URL);
      exit();
    

}else if($LX == 5){
    //weixin开放平台
   

    exit();
}else{
    //威信登录



   if( !strstr( $_SERVER['HTTP_USER_AGENT'], "essenger" ) ) $token = token();
   else $token = 0;



     $URL = ('https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$LANG['kjwxid'].'&redirect_uri='.urlencode($WZHOST.'login/'. $ACTION[$LX].'.php').'&response_type=code&scope=snsapi_userinfo&state='. $token);

    if( strstr( $_SERVER['HTTP_USER_AGENT'], "essenger" ) ){

        Header("Location: ".$URL);
        exit();

    }

}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>微信登录</title>
		<meta charset="utf-8">		
		<script src="/tpl/lang/cn.js"></script>
        
        <style>
        .impowerBox,.impowerBox .status_icon,.impowerBox .status_txt{display:inline-block;vertical-align:middle}a{outline:0}h1,h2,h3,h4,h5,h6,p{margin:0;font-weight:400}a img,fieldset{border:0}body{font-family:"Microsoft Yahei";color:#fff;background:0 0}.impowerBox{line-height:1.6;position:relative;width:100%;z-index:1;text-align:center}.impowerBox .title{text-align:center;font-size:20px}.impowerBox .qrcode{width:380px;margin-top:15px;border:1px solid #E2E2E2}.impowerBox .info{width:280px;margin:0 auto}.impowerBox .status{padding:7px 14px;text-align:left}.impowerBox .status.normal{margin-top:15px;background-color:#232323;border-radius:100px;-moz-border-radius:100px;-webkit-border-radius:100px;box-shadow:inset 0 5px 10px -5px #191919,0 1px 0 0 #444;-moz-box-shadow:inset 0 5px 10px -5px #191919,0 1px 0 0 #444;-webkit-box-shadow:inset 0 5px 10px -5px #191919,0 1px 0 0 #444}.impowerBox .status.status_browser{text-align:center}.impowerBox .status p{font-size:13px}.impowerBox .status_icon{margin-right:5px}.impowerBox .status_txt p{top:-2px;position:relative;margin:0}.impowerBox .icon38_msg{display:inline-block;width:38px;height:38px}
        </style>
	</head>
	<body style="padding: 50px; background-color: rgb(51, 51, 51);">
		<div class="main impowerBox" >
			<div class="loginPanel normalPanel">
				<div class="title">微信登录( 点击返回首页)</div>
				<div class="waiting panelContent">
					<div class="wrp_code"><img class="qrcode lightBorder" src="<?php echo WZHOST.'ewm.php?data='.urlencode($URL);?>" /></div>
					<div class="info">
						<div class="status status_browser js_status normal" id="wx_default_tip">
			                <p>请使用微信扫描二维码登录</p>
                            <p><?php echo $LANG['kjwxname']?></p>
			            </div>
			           
			            
			        </div>
				</div>
			</div>
		</div>
 <script>
var dajishid ;
var token = '<?php echo $token;?>';
var HTTP = '<?php echo WZHOST;?>';
var times =0;
 </script>
<script type="text/javascript" src="/tpl/js/jquery.min.js"></script>
<script type="text/javascript" src="/tpl/h-ui/js/layer.js"></script>
<script>
function dataerror(data , ming ){

        if( data.status == '401' ){

                layer.msg( '需要登录用户',{ offset :'auto', time : 1500,url: HTTP });

            

        }else if( data.status == '304' ){

            layer.msg( '修改'+ming+'失败',{ offset :'auto', time : 1500 });
               
  ;
            
        }else if( data.status == '410' ){
               
            layer.msg( '删除'+ming+'失败',{ offset :'auto', time : 1500 });
            
        }else if( data.status == '404' ){

            layer.msg( '查询'+ming+'失败',{ offset :'auto', time : 1500 });
               
             
            
        }else if( data.status == '406' ){

            layer.msg( '新增'+ming+'失败',{ offset :'auto', time : 1500 });
               
            
        }else if( data.status == '415' ){

                if( data.responseJSON ){

                    DATA = data.responseJSON;

                    

                    if( DATA.token && DATA.token != '') TOKEN = DATA.token;

                    layer.msg( DATA.msg ,{ offset :'auto', time : 1500 });

                    MessageBox.errorFadeout( DATA.msg ,500);
                
                }else layer.msg( '非法数据' ,{ offset :'auto', time : 1500 }); 
                
               

        }else{
                 layer.msg( '数据错误' ,{ offset :'auto', time : 1500 }); 

           

        }


}


function showTime(){

        times++;

        if(times > 35){

           times = 0;

           $('.lightBorder').attr({'src': $('.lightBorder').attr('src')});

        
        }
           

        $.post( HTTP+"json.php",{y:'login',d:'delete','r':token},function(DATA){


            if(DATA.code == 99){

                clearTimeout(dajishid);

                layer.msg( '登录成功',{ offset :'auto', time : 1500,url: HTTP }); 
              
            }else if(DATA.code == 91){

                clearTimeout(dajishid);
              
                 layer.msg( '登录失败',{ offset :'auto', time : 1500,url: HTTP }); 
              
            }

 
        }).error(function( data ){
        
            dataerror( data ,'扫码登录');
    
        });

     

}

$(function(){

  
      dajishid = setInterval(showTime,3500); 

      showTime();

      $('body').click(function(){

          window.location.href= HTTP ;
      
        
      });

});

</script>
	</body>
</html>
