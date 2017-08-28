<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D    = db('type');
$OFF  = logac('off');
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
<title><?php echo $LANG['adminac'][$_GET['action']];?></title>
<script>
var updateurl='<?php echo $_SERVER['SCRIPT_NAME'];?>?action=<?php echo $AC;?>&mode=edit&uplx=image&dir=image';
</script>
</head>
<body>
<style>
.td-manage .Hui-iconfont{font-size:22px;}
</style>
<nav class="breadcrumb">

    <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> 
    <span class="c-gray en">&gt;</span>  <?php echo $LANG['adminac'][$_GET['action']];?>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" > <i class="Hui-iconfont"> &#xe68f; </i> </a> 

</nav>


<?php

    if( isset( $_GET['mode']) && $_GET['mode'] == 'edit'){


    $LXHASH  = 'makhtml/leixin';
    $PGHASH  = 'makhtml/page';

    $leixin = $Mem -> g($LXHASH );

    if(!$leixin){

        $leixin = 1;
        $Mem -> s($LXHASH,1 );

    
    }


 

    if($CONN['yunxing'] != 5) msgbox('NO','?action='.$AC);


    


    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

   

    if( $PAGE < 2){

        $PAGE = $Mem -> g($PGHASH );

        if(!$PAGE ){
            
            $PAGE= 1;
            $Mem -> s($PGHASH,2);

         
        
        
        }


    
    
    
    }
    if($leixin == 2)$D -> setbiao('center');

       

    $limit = listmit( 100 ,$PAGE);

    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

    $_SESSION[$AC] = token();

    if(! $DATA){ 
        
        $DATA = array();

        if($leixin == '1'){

            $Mem -> s($LXHASH, 2 );

            $PAGE = 0;

            $Mem -> s($PGHASH,$PAGE+1);
            msgbox('','?action='.$AC.'&mode=edit');
        
        
        }else if($leixin == '2'){ 

            $Mem -> d( $LXHASH );
            $Mem -> d( $PGHASH );
            msgbox('OK', '?action='.$AC);

        }


    }else $Mem -> s($PGHASH,$PAGE+1);

?>


<div class="page-container">
  <div class="mt-20">

    <table class="table table-border table-bordered table-hover table-bg table-sort">

        <thead>

            <tr class="text-c">
                <th width="130"> ID </th>
                <th width=""> name </th>
                <th  width="158"> time</th>
                <th  width="158"> OFF </th>
            </tr>

        </thead>

     <tbody>


            
            <?php if( $DATA){

                    $QLANG = include QTLANG ;
              
                      foreach( $DATA as $ONG){ 
                          
                            $KHTTP = array( 'lx' => $leixin,
                                            'id' => $ONG['id'],
                                 );

                            $HTTP = array( $ONG['url'],
                                           $PAGE
                            );

                            if($PAGE < 2 ) unset($HTTP['1']);
                            $content2 = ob_get_contents();

                            makehtml( $KHTTP , $HTTP, $URI , $CONN , $QLANG );
                           
                          
                            echo $content2;
                          ?>

                     

                             

                              <tr class="text-c">
                                    <td><?php echo $ONG['id']?></td>
                                    <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /></td>
                       

                              <td> <?php echo $ONG['atime'] > 0? ' <span style="color:blue;">'.date('Y-m-d H:i:s',$ONG['atime']).'</span> ':'No Time' ;?></td>

                              <td>  OK </td>

                                  

                                   


                         

                               </tr>

                     

            <?php     
                    }

                 ?>
                 <script>

                 window.setTimeout(function(){
                 window.location='?action=<?php echo $AC?>&mode=edit&page=<?php echo $PAGE+1;?>';
                 
                 },800); 
                 </script>
                 
                 
                 <?php
                 }
            ?>


         </tbody>

      </table>

   </div>

</div>





<?php  }else{ ?>

 <article class="page-container">


    <div class="row cl mt-20">

            <div class="col-xs-4 col-sm-4 col-xs-offset-4 col-sm-offset-4">
            <form method="get">
                <input type="hidden" name="action" value="<?php echo $AC;?>" />
                <input type="hidden" name="mode" value="edit" />
                <input class="btn btn-primary radius" name="submit" type="submit" value="<?php echo $LANG['makehtml'];?>">
            </form>

            </div>
    </div>

 </article>



<?php } include HTPL.'foot.php'; ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>



</body>
</html>