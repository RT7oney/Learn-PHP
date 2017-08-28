<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('admin');


if( file_exists( QTLANG ))
$QUI = include QTLANG;
else $QUI = array();


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

<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>h-ui/css/style.css" />
<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/lang/<?php echo $CONN['htlang']?>.js"></script>
<link rel="stylesheet" href="<?php echo TPL;?>js/kindeditor/themes/default/default.css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<style>
</style>
<title><?php echo $LANG['adminac'][$_GET['action']];?></title>
</head>
<body>



<?php if( isset( $_GET['mode'])){

           
         if( $_GET['mode'] == 'add'  || $_GET['mode'] == 'edit'){

             if( isset($_GET['uplx']) ){    
            
                         $_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';

                         $DATAS = update($USER['id']);

                         if(  $DATAS['code'] == 1 )  exit( json_encode( array('error' => 0 , 'url' =>  $DATAS['content']['pic']) ));
                         else exit( json_encode( array('error' => 1 , 'message' =>  $DATAS['msg']) ));

             }

                  

                        
                        if( isset( $_POST['submit'])){
                     
                        if($_POST['token']   != $_SESSION[$AC]) msgbox( $LANG['token'], '?'.createLinkstring( $_GET));

                        unset($_SESSION[$AC]);

                        unset($_POST['submit']);

                        foreach($_POST as $k => $v){

                            if( !is_array( $v ) && $v == $LANG['placeholderyes']) unset(  $_POST[$k] );

                        }

                        if( ! is_array( $QUI )) $QUI = array();
 
                        $QUI = array_merge($QUI, $_POST);


                        x( QTLANG ,$QUI);


                  }

            ?>



         <?php } ?>

                    

        
 

<?php }

$_SESSION[$AC] = token();

?>
 <nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<style>
.yddddd{margin-top:3px;display:block;}
</style>
 <article class="page-container">
    <form  method="post" action="?action=<?php echo $AC,'&mode=edit'?>" class="form form-horizontal" id="form-admin-role-add" enctype="multipart/form-data" >
<div id="tab-system" class="HuiTab">
    <input type="hidden" name="token" value="<?php echo $_SESSION[$AC];?>" />
    <input type="hidden" name="xibiao" value="<?php echo isset($_POST['xibiao'])? $_POST['xibiao'] : 0 ?>" />

    <div id="yingxianss">
    </div>


    <div class="tabBar cl">
        <?php foreach( $LANG['fengset'] as $TB) echo '<span>'.$TB.'</span>'; ?>
    </div>
     

      <?php 
      
            
            $LUDATA  = include QTLAUI;
             
          
            echo houtaifenjie( $LANG['picupdate'].'#imgupdate' , 'linshi', '' ,$LANG['placeholderyes']);
       
        foreach($LUDATA as $k => $v){
         echo '<div class="tabCon">';
               
               if( is_array($v)){
               
                   foreach($v as $wk => $wv){ 
                       
                         if($k =='PAGE'){
                             
                              $eng = $QUI['PAGE'][$wk];
                             
                             $wk = 'PAGE['.$wk.']';


                        
                       

                         }else $eng = $QUI[$wk];


                       

                        echo houtaifenjie( $wv, $wk , $eng , $LANG['placeholderyes']);

                        
                      
                    
                   }
               }
        
        
        
         echo '</div>';
        } 
      ?>








       <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG['edit'];?>&nbsp;&nbsp;">
                </div>
        </div>

</div>


    </form>
</article>






<?php include HTPL.'foot.php'; ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>
<script type="text/javascript">


var i = 0;
$(function(){

       $(".tabBar span").click(function(){

           $("[name=xibiao]").val( $(this).index("span") *1 - 1);

       });


        $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click", $("[name=xibiao]").val() );

});
</script>
</body>
</html>