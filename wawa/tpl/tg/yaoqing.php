<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$_SESSION['fangreg'] = token();
$_SESSION['code'] = rand(1000,9999);


?>
<html>
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>邀请好友送红包</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
        <link href="http://static.1yqba.com/yqba/v3/IOS/CSS/common.css?v=206-111-12.21.589" rel="stylesheet" type="text/css">
        <link href="http://static.1yqba.com/yqba/v3/IOS/CSS/main.css?v=206-111-12.21.589" rel="stylesheet" type="text/css">
</head>
<body style="background:#f8f8ff;">
    <div class="container" id="reg">
        <img src="http://static.1yqba.com/yqba/v3/IOS/images/Invitation_1.png" alt="">
        <ul class="reg_page">
            <li><span><input type="text" class="form-phone" placeholder="请输入您的手机号码" pattern="[0-9]*"></span></li>
            <li><span><input type="text" name="xcode" placeholder="请输入短信验证码" class="myfayzam cdialog-input" pattern="[0-9]*"></span><a  href="javascript:fasong();" class="cdialog-btn-code phone-code-gray">获取验证码</a></li>
            <li><span><input type="text" name="pass" class="myfayzam cdialog-input" placeholder="请输入密码(不少于六位字符)"></span></li>
        </ul>
        <a class="reg_btn" href="javascript:phoreg();">完成注册领红包&gt;</a>
        <p class="reg_inf">本活动一切解释权归一元抢宝公司所有。</p>
    </div>
      


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






</script>
