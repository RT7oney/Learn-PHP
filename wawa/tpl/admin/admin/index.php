<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$LEVEL = adminfenzu( $USER['type'] );
if( $LEVEL < 1){ 

    $LEVEL = array();
    $LEVEL['name'] = $LANG['chuangshiren'];
}

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/html5.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/respond.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/skin/blue/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title><?php echo SOFTNAME.' V.'.SOFTVER;?> </title>
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="<?php echo SOFTHTTP;?>" target="_blank"><?php echo SOFTNAME;?></a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="<?php echo SOFTHTTP;?>"><?php echo SOFTNAME;?></a> 
        <span class="logo navbar-slogan f-l mr-10 hidden-xs">v<?php echo SOFTVER;?></span> <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li><a href="<?php echo WZHOST;?>" target="_blank"><?php echo $LANG['gohome']?></a> </li>
                    <li><?php echo $LEVEL['name'];?></li>
                    <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A"><?php echo $USER['name'];?> <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            
                            <li><a href="?action=quite"><?php echo $LANG['quite']?></a></li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <input runat="server" id="divScrollValue" type="hidden" value="" />
    <div class="menu_dropdown bk_2">

         <?php 

         
         foreach( $ACTION as $kts => $shuju){
         
            if( ! isset( $YANZQX[$kts])) continue;


            if( isset( $YANZQX[$kts]['0']))
            $newyan = array_flip($YANZQX[$kts]);
            else $newyan = ($YANZQX[$kts]);

         ?>

        <dl id="menu-article">
            <dt><i class="Hui-iconfont "><?php echo $LANG['caidanico'][$kts]?></i> <?php echo $LANG['caidan'][$kts];?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                 <?php if( $shuju){ 
                          
                         
                           foreach( $shuju as  $vv){ 
                             
                                if( ! isset( $newyan[$vv])) continue;

                               ?><li><a _href="?action=<?php echo $vv;?>" data-title="<?php echo $LANG['adminac'][$vv];?>" href="javascript:void(0)"><?php echo $LANG['adminac'][$vv];?></a></li><?php } }?>
                </ul>
            </dd>
        </dl>

        <?php }?>


    
    </div>
</aside>


<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span title="<?php echo $LANG['adminac']['main'];?>" data-href="?action=main"><?php  echo $LANG['adminac']['main'];?></span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="?action=main"></iframe>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript">
function article_add(title,url){
    var index = layer.open({
        type: 2,
        title: title,
        content: url
    });
    layer.full(index);
}

</script> 
</body>
</html>