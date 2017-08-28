<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D    = db('memcached');
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


<?php if( isset( $_GET['mode'])){


        if( $_GET['mode'] == 'del'){

                         
                           if( isset( $_GET['token']))  $_POST['token'] = $_GET['token'];

                           if( !yztoken('token',$AC ) ) msgbox( $LANG['token'], '0');

                           $ID = (int) $_GET['id'];

                           $DATAS= $D ->where( array( 'id'=> $ID))-> find();

                           $DATA = $D -> delete( array( 'id' => $ID));

                           if( $DATA ){


                                 adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATAS  )));

                                 msgbox( $LANG['yishanchu'] , '1');
                           
                           }else msgbox( $LANG['shanchusb'] , '0');

            
        } ?>
 
<?php }else{ 


    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);

    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

    $_SESSION[$AC] = token();

    if(! $DATA) $DATA = array();

?>


<div class="page-container">
  <div class="mt-20">

    <table class="table table-border table-bordered table-hover table-bg table-sort">

        <thead>

            <tr class="text-c">
                <th width="130"> ID </th>
                <th width="300"> key </th>
                <th > value </th>
                <th  width="158"> time</th>
                
                <th > del </th>

            </tr>

        </thead>

     <tbody>


            
            <?php if( $DATA){
              
                      foreach( $DATA as $ONG){ ?>

                     

                             

                              <tr class="text-c">
                                    <td><?php echo $ONG['id']?></td>
                                    <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /></td>
                              <td>  <textarea style="width:100%;" class="input-text  size-M"><?php if($ONG['keval'] != ''){
                            
                                  

                                  print_r(unserialize($ONG['keval']));
                                  
                            }

                        ?></textarea>
                              
                              </td>

                              <td> <?php echo $ONG['atime'] > 0? ' <span style="color:blue;">'.date('Y-m-d H:i:s',$ONG['atime']).'</span> ':'No Time' ;?></td>

                                  

                                   


                            <td>

                                    <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont" style="font-size:24px;color:red;">&#xe6e2;</i> </a>


                                    </td>

                               </tr>

                     

            <?php     
                    } 
                 }
            ?>


         </tbody>

      </table>

   </div>

</div>


<div class="page">

   <?php   if( $ZSHU > $CONN['hnum'] ){
                     if(!isset( $_GET['fenqu'])) $_GET['fenqu'] = '';

                        echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=', '&fenqu='.$_GET['fenqu'] ); 
            }
   ?>

</div>



<?php  include HTPL.'foot.php'; } ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript">

var token ='<?php echo $_SESSION[$AC]?>';



function guanli(id,lx,obj){

        $.getJSON('?action=<?php echo $AC;?>&mode=edit&ajson=1&token=' + token + '&id='+id+'&lx='+lx,{},function(data){

                 if(data.token){  token = data.token; $("input[name='token']").val(token); }
                
                 if(data.code == 1){

                    if(lx == 2)       $(obj).html('<i class="Hui-iconfont" style="color:green;">&#xe6e1;</i>');
                    else if(lx == 1)  $(obj).html('<i class="Hui-iconfont"  style="color:red;">&#xe624;</i>');
                    else if(lx == 0)  $(obj).html('<i class="Hui-iconfont"  style="color:red;">&#xe6dd;</i>');
                    else              $(obj).html('<i class="Hui-iconfont"  style="color:red;">&#xe6dd;</i>');
                    
                    layer.msg(  data.msg ,{ icon: 1 ,time : 1000});
                
                 }else layer.msg( data.msg ,{ icon: 2 ,time : 1000});

        });
}




function admin_guanxian( obj, id){

              
              layer.confirm( '<?php echo $LANG['genggaioff'];?>' ,{ title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($OFF);?>
                               , btn1: function(index, layero){

                                                guanli(id,0,obj);

                               },btn2: function(index, layero){

                                                guanli(id,1,obj);

                               },btn3: function(index, layero){

                                                guanli(id,2,obj);

                               }
               });


}


function admin_del( obj, id){

        layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+id,{},function(data){

                  if(data.token){  token = data.token; $("input[name='token']").val(token); }
              
                  if(data.code == 1){

                       $(obj).parents("tr").remove();

                       layer.msg('<?php echo $LANG['yishanchu'];?>',{icon:1,time:1000});

                  }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});

              });

        });
}

</script>
</body>
</html>