<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$OFF = logac('off2');

?>
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
<link rel="stylesheet" href="<?php echo TPL;?>js/kindeditor/themes/default/default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/style.css" />

<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/lang/<?php echo $CONN['htlang']?>.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<style>
</style>
<title><?php echo $LANG['adminac'][$_GET['action']];?></title>
</head>
<body>
 <nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<?php if( isset( $_GET['mode'])){

           if( $_GET['mode'] == 'edit'){


                    if( isset($_GET['uplx']) ){
            
                         $_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';

                         $DATAS = update($USER['id']);

                         if(  $DATAS['code'] == 1 )  exit( json_encode( array('error' => 0 , 'url' =>  $DATAS['content']['pic']) ));
                         else exit( json_encode( array('error' => 1 , 'message' =>  $DATAS['msg']) ));

                    }
          
                  if( isset( $_POST['submit'])){

                        if(! yztoken( 'token', $AC) ) msgbox( $LANG['token'], '?'.createLinkstring( $_GET));

                        
                        unset($_POST['submit']);


                      $unset = array( '','dir','token','lang','fenge','htpl','hchs','qudong','modb','duob','qxx','hnum','qtlang','htlang','pagetrim','morenlist','morencent'
                      ,'houzui','fengenum'
                               );

                       foreach( $unset as $kl ) { 

                          if( isset( $_POST[$kl]) ) unset( $_POST[$kl] );
                      }

                        foreach($_POST as $k => $v){

                            if( !is_array( $v ) && $v == $LANG['placeholderyes']) unset(  $_POST[$k] );

                        }



                      $YUCONN = $CONN;
                      
                      $CONN = array_merge($CONN, $_POST);

                      x($CONLJI,$CONN);

                      adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'yuan'=> $YUCONN , 'data'=> $_POST )));
            }  
    }
}


$_SESSION[$AC] = token();
?>


<style>
.yddddd{margin-top:3px;display:block;}


</style>
<article class="page-container">

<div id="tab-system" class="HuiTab">

<form method="post" class="form form-horizontal" action="?action=<?php echo $AC?>&mode=edit" id="form-admin-role-add" enctype="multipart/form-data">
    <input type="hidden" name="token" value="<?php echo $_SESSION[$AC];?>" />
    <input type="hidden" name="xibiao" value="<?php echo isset($_POST['xibiao'])? $_POST['xibiao'] : 0 ?>" />
    <div class="tabBar cl">
        <?php foreach( $LANG['settable'] as $TB) echo '<span>'.$TB.'</span>'; ?>
    </div>


    <?php foreach( $LANG['settable'] as $k => $TB){ ?>

        <div class="tabCon">
        <?php
            $UI =  $LANG['xtset'][$k];

            foreach( $UI as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $CONN[$wk] ) ? $CONN[$wk]:'' ) , $LANG['placeholderyes']);
            }
            if($k == '0'){ ?>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['qtpl']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <select name="qtpl" class="select">
                        <?php echo ywselect(qtfile(),$CONN['qtpl']);?>
                    </select>
                </div>
            </div>
            <?php } ?>

        </div>
        <?php } ?>

    <div class="row cl">
            <div class="col-xs-4 col-sm-4 col-xs-offset-4 col-sm-offset-4">

                <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG['edit'];?>&nbsp;&nbsp;">

            </div>
    </div>

</form>
</div>
</article>







<?php include HTPL.'foot.php'; ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/webuploader/webuploader.js"></script>
<script type="text/javascript">





$(function(){

        $(".tabBar span").click(function(){

           $("[name=xibiao]").val( $(this).index("span") *1 - 1);

       });


        $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click",  $("[name=xibiao]").val() );


});
</script>
</body>
</html>