<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/html5.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/respond.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/PIE_IE678.js"></script>
<![endif]-->
<link href="<?php echo TPL;?>h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL;?>h-ui/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL;?>h-ui/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL;?>js/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title><?php echo SOFTNAME.' V.'.SOFTVER;?> </title>
<style>
.loginBox .input-text {
    width: 250px;
}
</style>
</head>
<body>

<div class="header">

</div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal" method="post" id="demoform">
	<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
	<input type="hidden" name="action" value="login" />
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-5">
          <input id="" name="name" type="text" placeholder="<?php echo $LANG['loginname'];?>" class="input-text size-L"    datatype="*"  nullmsg="<?php echo $LANG['shuru'],$LANG['loginname']?>！" >
        </div>
		<div class="formControls col-xs-4">
		</div>
		
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-5">
          <input id="" name="pass" type="password" placeholder="<?php echo $LANG['loginpass'];?>" class="input-text size-L" datatype="*6-20" nullmsg="<?php echo $LANG['shuru'],$LANG['loginpass']?>！">
        </div>
		<div class="formControls col-xs-4">
		</div>

      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" type="text" placeholder="<?php echo $LANG['code']?>"  maxlength="4" name="code" datatype="n" style="width:113px;">

          <img src="?vocde=45" onclick="shuaxin();" id="newimg"> 
		  <a id="kanbuq" onclick="shuaxin();" href="javascript:;"><?php echo $LANG['sicode']?></a>

		 </div>
		

      </div>
   

      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="<?php echo $LANG['loginsubmit'];?>">
          
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">Copyright <?php echo SOFTNAME.' V.'.SOFTVER;?></div>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>

<script  type="text/javascript">


function shuaxin(){ 
	
	$("#newimg").attr({'src':'?vocde='+Math.ceil(Math.random()*100000)   });
}

$(function(){

	$("#demoform").Validform({
		tiptype:2
	});


});
</script>

</body>
</html>