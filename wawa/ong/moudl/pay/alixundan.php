<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$PAYID  = $PAYAC['payid']  ; //支付的id
$PAYKEY = $PAYAC['paykey'] ; //支付的key
$PAYZH  = $PAYAC['zhanghao'] ; //支付的帐号 需要用到的填写
$TYID   = 1; //支付方式

$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址

$BSHI = '';

if($PLAYFS =='1'){  //发送


     

     $QLAN = include QTLANG;


     $DAZHANG = array();


    if( $QLAN['alizhao'] ){


        foreach( $QLAN['alizhao'] as $ong){

            $DAZHANG[] = array( 'zhanghao' => $ong['帐号'],
                                     'pic' => pichttp($ong['收款二维码']),
                );

        }

        $zong = count( $DAZHANG );

        if( $zong  > 0 ){

            global $Mem;

            $HASHZ = 'alifenzu'; 
            $HATIME = 3;

            try{ 

                $data = $Mem -> g( $HASHZ );

                if( $data ){

                    $data+=1;
                    $Mem -> s( $HASHZ,$data,$HATIME);

                }else{

                    $data = 1;
                    $Mem -> s( $HASHZ,1,$HATIME);
                }

                if( $data > $zong ){

                    $Mem -> s( $HASHZ , 1 ,$HATIME);
                    $data = 1;
                }

            }catch(Exception   $e ) { 

                $Mem -> s($HASHZ,1,$HATIME);
                $data = 1;
            }

            $ALIPAY =  isset( $DAZHANG[$data-1]) ? $DAZHANG[$data-1] : $DAZHANG['0'];

            $DD = db('dingdan');

            $fans =  $DD ->zhicha('orderid,id')->where(array( 'orderid' => $DINGID['orderid'] ))-> find();

            if( $fans ) $DINGID['id']  = $fans['id'];

            


            

    


            if( $SHOUJI ){ //手机页面 ?>
            <!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no" />
        <title> 支付宝付款  </title>
        <link rel="stylesheet" type="text/css" href="/tpl/h-ui/css/H-ui.min.css" />
        <style>
        body{font-size:14px;padding-bottom:50px;}
.chonzhi{margin:0 auto;}
.w-200 {width:250px;}
.w-50{width:50px;}
.center{}
.center ul li{margin-bottom:5px;}
.pd-30{ padding: 8px; }
.moni{ padding: 8px;  background:#EDEDED;}
.xjige{background:#F3F3F3;height:20px;border-top:1px solid #fff; }
.moren div{float:left;}
.fangshi{background:#F8F8F8;}
.tijiao{background:#F3F3F3; position:fixed;bottom:0px;width:100%;}
.footer{border:0px;}

.moren div{border:1px solid #F8F8F8;height:58px; cursor:pointer;padding-top:8px;}

.moren div img{width:38px;height:38px;float:left;}
.moren div.hover{border:1px solid #0096EA;border-radius: 8px;}
.moren div p{float:left; padding:0px 0px 0px 20px;font-size:20px;color:#000;}
.head{background:#2CBAE7;text-align:center;color:#fff;}
h1{font-size:18px;height:50px;line-height:50px;padding:0px;}

.moni b{color:Red;}
.btn-pay{background:#08A1E9;color:#fff;width:94%;}
#jines{display:block;}
#jines label{width:88px;display:inline-block;height:30px;overflow:hidden;line-height:30px;}
#jines label input{margin-right:5px;}
.dingoff0{color:#ccc;}
.dingoff1{color:#6666FF;}
.dingoff2{color:#00CC33;}
.dingoff3{color:Red;}
.dingoff4{color:Red;}

        </style>
        <script type="text/javascript" src="/tpl/js/jquery.min.js"></script> 
     
        <script>
var WSMJSQ;
var WXQUNJ = 3000;

function guanbiwsaom(){


  clearTimeout(WSMJSQ);
}

function wxjishi22(tkey){

    $.ajax({
        type: "post",
        url: "/api.php?action=chaoff",
        dataType:'json',
        async: false,
        data:{
            tkey :tkey
            },
        success:function(data){
                if(data.start){

                    if(data.msg == '1'){

                          alert('充值失败');
                          window.location.href="<?php echo $PAYTB;?>?ordernum="+tkey; 
                         guanbiwsaom();
                        
                    
                    }else if(data.msg == '2'){
                             alert('充值成功');
                           window.location.href="<?php echo $PAYTB;?>?ordernum="+tkey; 
                           guanbiwsaom();

                    }

                
                
                }else{

                    alert('非法传递');
                    window.location.href="/pay.php"; 
                   guanbiwsaom();
                
                }
            
        }
    });


   
}

function wxinsaoma22(tkey){
          var WXQUNJ = 180;
          var url = $('#wxinsaoma').attr('href');

          var tdkd = ($(window).width() -320)/2;
          var tdgd = ($(window).height() -350)/2;



        WSMJSQ = window.setInterval(function(){

            wxjishi22(tkey);
            WXQUNJ--;

           

            if(WXQUNJ <  1){

              guanbiwsaom();
              alert('充值失败');
              window.location.href="<?php echo $PAYTB.'?ordernum='.$DINGID['orderid'];?>"; 

            }


         },5000);
       
return false;

}

$(function(){

     wxinsaoma22("<?php echo  $DINGID['orderid'];?>");
});

</script>
</head>
<body>

<div class="chonzhi">

    
  
        <div class="head">
            <h1>收银台</h1>
        </div>

        <div class="center pd-30">
               <ul>

                    <li>收款帐号:  <?php echo $ALIPAY['zhanghao'];?> </li>
                   
                   <li>转账金额: <?php echo $DINGID['payjine']?> </li>
                   <li>转账备注: <span style="color:red;"><?php echo $BSHI.$DINGID['id'] ;?> </span> </li>

                </ul>
        </div>

        <div class="moni">
        转账步骤<b> 请正确填写 <span style="color:red;">转账备注</span> ,否则无法自动到账.. </b>

        </div>
        <div class="neirong" style="padding:20px;">

                1.首先打开手机支付宝钱包.<br />
2.选择<span style="color:red;">转账功能</span> 并且选择转到支付宝账户<br />
3.输入对方账户：<span style="color:green;font-size:18px;font-weight:bold;"><?php echo $ALIPAY['zhanghao'];?></span> <br />
4.转账金额填写：<span style="color:green;font-size:18px;font-weight:bold;"><?php echo $DINGID['payjine']?></span>  <br />
5.转账备注填写：<span style="color:red;font-size:18px;font-weight:bold;"><?php echo $BSHI.$DINGID['id'] ;?></span> <br />
温馨提示：<span style="color:#FF9933;">请勿修改转账金额,转账备注否则不返数据</span><br />
到账时间：付款成功后,耐心等待 10 秒钟.<br />
注意事项：<br />
1.请正确填写 <span style="color:red;">转账备注</span> ,否则无法自动到账..<br />
2.本站支付宝账户会不定期更换,每次充值前请务必核对支付宝账号..<br />

        </div>
        <div class="tijiao pd-10">



                <input class="btn btn-pay radius " type="submit" onclick="diaozhifubao()" value="<?php if( strstr( $_SERVER['HTTP_USER_AGENT'] , "essenger" ) ) echo '请自己打开手机支付宝';else echo '请自己打开手机支付宝';?>">


                <div class="cl"></div>

            </div>

        <div class="foot">
            
            <footer class="footer mt-20">
                <div class="container-fluid">
                    
                </div>
            </footer>

        </div>



    </form>

</div>
<iframe name="left" id="rightMain"  frameborder="false" scrolling="auto" style="width:1px;height:1px;border:none;" allowtransparency="true"></iframe>
</body>
</html>
<script>


function diaozhifubao(){

    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('iframe')).src='alipays://platformapi/startapp?appId=20000001&_t='+~(-new Date()/36e5)];



}

</script>

            
            
            
            <?php }else{ //pc 页面 ?>
            <!DOCTYPE html>
            <html lang="zh-CN">
                <head>
                    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
                    <meta charset="utf-8" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="format-detection" content="telephone=no" />
                    <title> 支付宝付款 </title>
                    <!--[if lt IE 9]>
                    <script type="text/javascript" src="/tpl/js/lib/html5.js"></script>
                    <script type="text/javascript" src="/tpl/js/lib/respond.min.js"></script>
                    <script type="text/javascript" src="/tpl/js/lib/PIE_IE678.js"></script>
                    <![endif]-->

                    <!--[if IE 6]>
                    <script type="text/javascript" src="/tpl/js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
                    <script>DD_belatedPNG.fix('*');</script>
                    <![endif]-->
                    <link rel="stylesheet" type="text/css" href="/tpl/h-ui/css/H-ui.min.css" />
                    <style>
                    body{font-size:16px;}
.chonzhi{margin:0 auto;width:1000px;}
.w-200 {width:200px;}
.w-50{width:50px;}
.center{background:#F8F8F8;border-top:6px solid #0188CA;border-bottom:1px solid #E3E3E3;}
.center ul li{margin-bottom:5px;}
.pd-30{ padding: 30px; }
.xjige{background:#F3F3F3;height:20px;border-top:1px solid #fff; }
.moren div{float:left;}
.fangshi{background:#F8F8F8;}
.tijiao{background:#F3F3F3;}
.footer{border:0px;}
.moren div{border:1px solid #F8F8F8;height:128px; cursor:pointer;padding-top:8px;}

.moren div img{width:88px;height:88px;}
.haed h1{height:100px;line-height:100px;}

.moren div.hover{border:1px solid #0096EA; border-radius: 8px;}
.btn-pay{background:#08A1E9;color:#fff;}
#jines label{padding-right:10px;height:30px;overflow:hidden;line-height:30px;}
.dingoff0{color:#ccc;}
.dingoff1{color:#6666FF;}
.dingoff2{color:#00CC33;}
.dingoff3{color:Red;}
.dingoff4{color:Red;}

                    </style>
            <script type="text/javascript" src="/tpl/js/jquery.min.js"></script> 
            </head>
            <script>
var WSMJSQ;
var WXQUNJ = 3000;

function guanbiwsaom(){


  clearTimeout(WSMJSQ);
}

function wxjishi22(tkey){

    $.ajax({
        type: "post",
        url: "/api.php?action=chaoff",
        dataType:'json',
        async: false,
        data:{
            tkey :tkey
            },
        success:function(data){
                if(data.start){

                    if(data.msg == '1'){

                          alert('充值失败');
                          window.location.href="<?php echo $PAYTB;?>?ordernum="+tkey; 
                         guanbiwsaom();
                        
                    
                    }else if(data.msg == '2'){
                             alert('充值成功');
                           window.location.href="<?php echo $PAYTB;?>?ordernum="+tkey; 
                           guanbiwsaom();

                    }

                
                
                }else{

                    alert('非法传递');
                    window.location.href="/pay.php"; 
                   guanbiwsaom();
                
                }
            
        }
    });


   
}

function wxinsaoma22(tkey){
          var WXQUNJ = 180;
          var url = $('#wxinsaoma').attr('href');

          var tdkd = ($(window).width() -320)/2;
          var tdgd = ($(window).height() -350)/2;



        WSMJSQ = window.setInterval(function(){

            wxjishi22(tkey);
            WXQUNJ--;

           

            if(WXQUNJ <  1){

              guanbiwsaom();
              alert('充值失败');
              window.location.href="<?php echo $PAYTB.'?ordernum='.$DINGID['orderid'];?>"; 

            }


         },5000);
       
return false;

}

$(function(){

     wxinsaoma22("<?php echo  $DINGID['orderid'];?>");
});

</script>
            <body>

            <div class="chonzhi">

    
            <div class="haed">
                <h1> 收银台</h1>
            </div>

            <div class="center pd-30">

                <ul>
                    <li>收款帐号: <?php echo $ALIPAY['zhanghao'];?></li>
                    <li>转账金额: <?php echo $DINGID['payjine']?> </li>
                    <li>转账备注: <span style="color:red;"><?php echo $BSHI.$DINGID['id'] ;?> </span> </li>
                </ul>

            </div>

            <div class="xjige"></div>

            <div class="fangshi  pd-20" style="min-height:100px;">

            <h1 style="font-size:18px;text-align:center;color:#fe662b;" id="wlindoji" >确认充值账号后,打开手机支付宝扫描二维码向本站支付宝转账.</h1>

<div style="text-align:left;width:388px;float:left;font-size:16px;line-height:30px;margin:0px 50px 0px 100px;">
1.首先打开手机支付宝钱包.<br />
2.扫描本站支付宝二维码,并选择<span style="color:red;">转账功能</span><br />
3.转账金额填写：<span style="color:green;font-size:18px;font-weight:bold;"><?php echo $DINGID['payjine']?></span>  <br />
4.转账备注填写：<span style="color:red;font-size:18px;font-weight:bold;"><?php echo $BSHI.$DINGID['id'] ;?></span> <br />
温馨提示：<span style="color:#FF9933;">请勿修改转账金额,转账备注否则不返数据</span><br />
到账时间：付款成功后,耐心等待 10 秒钟.<br />
注意事项：<br />
1.请正确填写 <span style="color:red;">转账备注</span> ,否则无法自动到账..<br />
2.本站支付宝账户会不定期更换,每次充值前请务必核对支付宝账号..<br />

 </div>

                 <div style="text-align:center;width:258px;float:left;">
      
                       <img src="<?php echo $ALIPAY['pic'];?>" style="width:100%;">

                 </div>


                 <div style="clear:both;"></div>

            </div>

            <div class="foot">
            
            <footer class="footer mt-20">
    <div class="container-fluid">
        
     
    </div>
</footer>


        </div>

</body>
</html>

            
            
            
            <?php

            }

           


        }

    }else p('未配置收款帐号');


 


        //
  
            

}else if($PLAYFS =='2'){  // 异步处理

 global $Mem;
   


    if( isset( $_POST['woqu'] ) ){
        
        if($BSHI  == '')
              $fanhuis = explode( '@#@',str_replace(array('>',"'",'"',"  "," " ,"\r","\n",'付款-','    ','style=visibility:visible;','转账'),'', $_POST['woqu'] ) );

        else  $fanhuis = explode( '@#@',str_replace(array('>',"'",'"',"  "," " ,"\r","\n",'付款-','    ','style=visibility:visible;',$BSHI.'-',$BSHI,'转账'),'', $_POST['woqu'] ) );

        $m = '';
        $SHUJU = array();

        foreach( $fanhuis as $wocao ){

                if( $wocao == '') continue;
                $ding = explode( '@@',$wocao);

                $ding['2'] =preg_replace ("@seed(.*?)=on@is", '' ,$ding['2']) ;
                $ding['1'] = time();
                $m .= $ding['4'];
                if( $ding['4'] > 0) $SHUJU[] = $ding;
        }

        $keyss =  md5($PAYKEY.$m);



        if( $keyss != $_POST['mixiao']) exit('no');

        if( $SHUJU ){

        

            $D = db('dingdan');

            $xs = "\r\n";

            

            foreach( $SHUJU as $tadege){

                $fan = $D ->where( array( 'id' => $tadege['2'] ) )-> find();

                if( $fan ){

                    chongzhifan( $tadege['3']  , $tadege['4']  , $fan['orderid'] );

                    $xs .= 'OK '.$fan['ordernum'] .' ' . $tadege['4'] .' ' . $tadege['3']."\r\n";

                }else{

                    $xs .= 'NO '.$tadege['2'] .' ' . $tadege['4'] .' ' . $tadege['3']."\r\n";

                    $Mem -> s( 'wzpay/'.$tadege['3'], $tadege );

                }

            }


            exit( $xs );
        }

    }else exit('no');


}else if($PLAYFS =='3'){  //查询



        if( strstr($_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
        }else { 

            if(  isset( $_GET['ordernum']) && strlen( $_GET['ordernum'] ) > 10  )
                msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_GET['ordernum'] ));
            else msgbox('', WZHOST );
        }

}