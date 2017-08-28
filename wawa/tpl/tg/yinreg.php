<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$_SESSION['fangreg'] = token();
$_SESSION['code'] = rand(1000,9999);


?>
<html>
<head>
<meta content="application/xhtml+xml; charset=utf-8" http-equiv="Content-Type">
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
<meta content="" name="keywords">
<meta content="" name="description">
<title>免费送iPhone6 - <?php echo $CONN['title']?></title>
<style type="text/css">
html body.kq-body .theme-bg-color,
html body.kq-body .theme-bg-color-p {

background-color: #ff4c42;

}
html body.kq-body .theme-bg-color-f {

background-color: #119bfb;

}

html body.kq-body .theme-txt-color,
html body.kq-body .theme-txt-color-p {
color: #ff4c42;
}
html body.kq-body .theme-txt-color-f {

color: #119bfb;

}
html body.kq-body .theme-btn-f {

border-color: #ff4c42;
background-color: transparent;
color: #ff4c42;

}
html body.kq-body .theme-btn-p {

border-color: #ff4c42;
background-color: #ff4c42;
color: #fff;

}
html,body {

overflow: auto;
-webkit-font-smoothing: antialiased;

}

html, body {
    background: #fb174c!important
}

@media screen and (max-width: 350px) {
    html, body {
    font-size: 13px!important;
    }
}

@media (min-width: 640px) {
    html, body {
    background: #fff!important;
    }
}

#zhaopass{

padding:20px;

}
</style>
<meta content="telephone=no,email=no" name="format-detection">
<link rel="stylesheet" type="text/css" href="/tpl/tg/img/all_20160712.css">
<link rel="stylesheet" type="text/css" href="/tpl/tg/img/games_widget_f94212b.css">
<style>
a,a:hover{color:#fff;text-decoration: none;}
#zhaopass div{margin-bottom:10px;}
.cdialog-input {
    width: 130px;
    height: 33px;
    line-height: 33px;
    vertical-align: middle;
    border: solid 1px #cecece;
    font-size: 1rem;
    padding: 0 5px;
}

 .cdialog-submit {
    display: block;
    width: 100%;
    background-color: #ff5353;
    text-align: center;
    color: #fff;
    padding: 9px 0;
    border-radius: 3px;
}

.cdialog-btn-code {
    display: inline-block;
    background-color: #ff5353;
    color: #fff;
    padding: 7px;
    vertical-align: middle;
    font-size: .9rem;
    border-radius: 3px;
    float: right;
    width: 110px;
    text-align: center;
}

</style>
</head>
<body class="kq-body" style="background:#FB174C;">
<div id="doc" style="background:#FB174C;">

	<div id="aside"></div>
	<div id="hd"> </div>
  <div id="bd">
        
    <div class="activity-hongbao">

        <div class="activity-hongbao-head">
            <img src="/tpl/tg/img/top_69b515a.jpg">
        </div>

    <div class="activity-hongbao-body">

        <div class="activity-hongbao-notice">

            <?php echo $CONN['title']?>送你
            <span class="hongbao-yellow"><?php echo $CONN['regjine']?>元</span> <?php echo $CONN['hongbao']?>，可以免费抢iPhone，快来领走吧！

        </div>

        <div class="activity-hongbao-form">

            <div class="activity-hongbao-login">
            

                <input type="tel" class="form-phone" value="" maxlength="11" placeholder="请输入手机号">

                <a href="javascript:linquhbao();" class="activity-hongbao-submit"> 领取<?php echo $CONN['hongbao']?> </a>

            </div>



            <?php if( isset( $_SESSION['tuid'] ) && $_SESSION['tuid'] > 0 ){ ?>
            <a href="<?php echo WZHOST;?>" class="activity-hongbao-submit" style="color:#fff;background:blue;"> 推荐UID <span style="color:#fcc;"><?php echo $_SESSION['tuid'];?></span> </a>

            <?php }else{ ?>

            <a href="<?php echo WZHOST;?>" class="activity-hongbao-submit" style="color:#fff;background:blue;"> 先去看一看</a>
            

            <?php }?>


            <div class="activity-hongbao-success"></div>

        </div>

    </div>

        <div class="activity-hongbao-footer">

            <div class="activity-hongbao-ftitle"> 活动规则 </div>

            <ul class="activity-hongbao-fdesc">
                <li>1、<?php echo $CONN['hongbao']?>为<?php echo $CONN['regjine']?>元<?php echo $CONN['hongbao']?>，参与一元抢宝时抵用</li>
                <li>2、该<?php echo $CONN['hongbao']?>有效期为<?php echo $CONN['regday']?>天，过期作废</li>
                <li>3、每人最多可领取一张<?php echo $CONN['hongbao']?>，输入正确的手机号可得</li>
                <li>4、在“我的”-“<?php echo $CONN['hongbao']?>”中查看 </li>
                <li>5、本次活动最终解释权归 <?php echo $CONN['title']?> 所有 </li>
            </ul>

        </div>

        <?php if($LANG['downid'] != ''){ ?>

        <a href="<?php echo url('l',$LANG['downid']);?>" class="activity-hongbao-download">
            <i class="footer-icon" style="background-image:url(/tpl/tg/img/ca616cf6-daec-4f6b-b5c4-c8963bf03970.png)"></i>
            <span class="footer-text">APP里玩「<?php echo $CONN['title']?>」更嗨！</span>
            <span class="footer-download">立即体验</span>
        </a>

        <?php } ?>

    </div>

    </div>

    <div id="ft"></div>

</div>


<div class="weixin-dialog">

    <div class="weixin-overlay"></div>

</div>

<div class="mobile-toast" style="display: none;">
     <div class="toast-text">手机号输入有误，请重新输入</div>
</div>


<div class="w-msgbox-bd" pro="entry" id="zhaopass" style="display:none;"> 

    <div class="cdialog-tipdd">

         <span class="cdialog-tip-weight">温馨提示：</span>您成功领取代金券后，该手机号码自动注册<?php echo $CONN['title']?>账号</div>
         
         <div class="cdialog-form clearfix">
         <input type="tel" maxlength="6" name="xcode" placeholder="请输入验证码"   class="myfayzam cdialog-input"><a href="javascript:fasong();" class="cdialog-btn-code phone-code-gray">发送验证码</a></div>
         <div class="cdialog-form clearfix">

         <input type="text" maxlength="30" name="pass" placeholder="设置一个登录密码"  class="myfayzam cdialog-input" style="width:100%;">

         </div>


         <a class="cdialog-submit" href="javascript:phoreg();">提交</a>

         
    </div>
    


</div>

<?php if( !$SHOUJI){ ?>

<div class="plugin-qr-code">
    <div class="qr-code-title">微信“扫一扫”手机端预览</div>
    <div class="qr-code-view" style="height: 172px;width:100%;">
         <img src="<?php echo $LANG['gongzhonghao'] ?>" />
    </div>
</div>

<?php } ?>

</body>
</html>
<script src="/tpl/lang/cn.js"></script>
<script type="text/javascript" src="/wangyi/p/yymobile/1606291913/zepto.min.js"></script>
<script type="text/javascript" src="/tpl/h-ui/js/layer.js"></script>
<script type="text/javascript">
var reg=/^1[0-9]{10}/;
var dojishi = 119;
var DJSTIME;
var CODE = '<?php echo $_SESSION['code'];?>';
var token;
var HTTP = '<?php echo WZHOST;?>';
function phoreg(){

    var photo = $(".form-phone").val();

    if(!reg.test( photo )){

        layer.msg( '请输入正确的手机号码',{ offset :'auto' ,time : 1000});
        return false;

    }

    var xcode = $("[name=xcode]").val();

    if( xcode.length != 6 ){

        layer.msg( '请输入手机验证码',{ offset :'auto' ,time : 1000});
        return false;
    }

    var mima = $("[name=pass]").val();

    if(mima.length < 6 || mima.length > 32){

        layer.msg( LANG.mmerror ,{ offset :'auto' ,time : 1000});
        return false;
    }

     $.post( HTTP + "json.php?romd="+(Date.parse(new Date())/1000)+Math.round(Math.random()*100000000),{ 'y' :'user','d':'soso', 'shouji' :photo,'code':CODE, 'token': token ,'lx': 2,'xcode':xcode,'mima':mima},function(result){

             DATA =  jieshou(result);
             
             
             if(DATA){

                 D = DATA.data;

                 if(D){

                    if( D.token ) token = D.token;
                    if( D.code ) CODE  = D.code;
                 }

                if(DATA.code == 1){

                      window.location.href= HTTP;
                 

                  

                 }else if(DATA.code == 99){

                     window.location.href= HTTP;
                 
                 
                 }else{

                     layer.msg( DATA.msg ,{ offset :'auto' ,time : 1000});
                 
                 
                 }

             }
     });



  


}


function daojifun(){
          

         dojishi--;

         if(dojishi < 1){
         
          clearInterval( DJSTIME );

          $(".phone-code-gray").html('发送验证码');
         $(".phone-code-gray").css({'background':'#ff5353'});


         return false;
         }

         $(".phone-code-gray").html('重新发送'+(dojishi)+'秒');
}

function fasong(){

        var photo = $(".form-phone").val();
        if(! reg.test( photo )){

            layer.msg( '请输入正确的手机号码',{ offset :'auto' ,time : 1000});
            return false;

        }

         $.post( HTTP + "json.php?romd="+(Date.parse(new Date())/1000)+Math.round(Math.random()*100000000),{ 'y' :'user','d':'soso', 'shouji' :photo,'code':CODE, 'token': token ,'lx': 1},function(result){

             DATA =  jieshou(result);
             
             
             if(DATA){

                 D = DATA.data;

                 if(D){

                    if( D.token ) token = D.token;
                    if( D.code ) CODE  = D.code;

                 
                 
                 }

                 if(DATA.code == 1){

                    dojishi = 119;

                    DJSTIME = setInterval("daojifun()",1000);

                    $(".phone-code-gray").html('重新发送'+(dojishi)+'秒');

                    $(".phone-code-gray").css({'background':'#cecece'});

                 }else if(DATA.code == 99){

                     window.location.href= HTTP;
                 
                 
                 }else{

                     layer.msg( DATA.msg ,{ offset :'auto' ,time : 1000});
                 
                 
                 }

             
             }

            


         });


          


        

}


function linquhbao(){

var photo = $(".form-phone").val();

    if(! reg.test( photo )){


        layer.msg( '请输入正确的手机号码',{ offset :'auto' ,time : 1000});
        return false;


    }

   
        layer.open({  title : '手机号码验证',
                        type : 1,
                    closeBtn : 1,
                        area : '300px',
                      offset :'auto',
                     content : $("#zhaopass") 
         }); 






}

$(function(){

    



});


</script>

