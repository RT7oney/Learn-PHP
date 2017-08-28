<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');



$data = array( 
       'title' => $LANG['fentitle'],
         'des' => $LANG['fenneiron'],
         'pic' => pichttp( $LANG['fenxiang'] ),
         'url' => WZHOST.'tg.php?y=yinreg&tuid='.(  isset( $_SESSION['uid'] ) && $_SESSION['uid'] > 0 ? $_SESSION['uid'] : 0 )
);



$login = base64_encode( json_encode( $data ) );


?>
<html >
<head>
<title>分享赚钱</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<style type="text/css">

*{padding:0px;margin:0px;}

 body {
    background: #e45853;
	height:100%;
}



.i-scroll-height {
   max-width: 500px;
    margin: 0 auto;
}
.intro-detail{    line-height: 1.6;
    color: #fff;
    font-size: 1.2rem;
	padding: 2rem;
	
	}
.content .intro-detail .btn-invite {
    width: 100%;
    height: 3.33rem;
    background: #fbe21d;
    border: none;
    color: #de4900;
    font-size: 1.5rem;
    margin-top: 1.33rem;}
.banner img{ width:100%;}



}</style></head>
<body id="make-money-intro">

<div class="content" onclick="wofenxiang();">

    <div class="i-scroll-height i-hidden i-show">
        <div class="banner"><img src="/tpl/tg/1.png"></div>
        <div class="intro-detail">
            <p>好友充值，你最多可返佣金7%，多充多得不限次数不限时间，朋友越多佣金越多噢~更重要的是佣金可以提现！！！
                </p>
           
            <button class="btn btn-invite" style="touch-action: manipulation; -webkit-user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">开始邀请</button>
        </div>
    </div>

</div>




</body>
</html>
<script>
function wofenxiang(){

window.location.href= '#openSharePanel-<?php echo $login;?>';


}
</script>