<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');
$D = db('logac');
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
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<style>
.table .Hui-iconfont{font-size:20px;color:red;}
</style>
<title><?php echo $LANG['adminac'][$_GET['action']];?></title>
</head>
<body>
<nav class="breadcrumb"> 

        <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> 
        <span class="c-gray en">&gt;</span>  <?php echo $LANG['adminac'][$_GET['action']];?>
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" > <i class="Hui-iconfont"> &#xe68f; </i> </a>

</nav>
<?php   if( isset( $_GET['mode'])){

            if( $_GET['mode'] == 'edit'){ 

                unset( $_GET['mode']);
                $ID = (int)$_POST['id'];

                $DATA = $D ->where( array( 'id'=> $ID))-> find();

                if( isset( $_POST['submit'] ) ){

                    if( ! yztoken( 'token' , $AC ) ) msgbox( $LANG['token'], '?'.getarray( $_GET));

                    unset( $_POST['submit']);

                    if( $DATA['type'] != $_POST['type'] ){

                        $fs = $D ->where( array( 'type' => $_POST['type'])) -> find();
                        if( $fs )  msgbox( $LANG['xitonglogcd']['biaomz'] , '?' . getarray( $_GET) );
                    }

                    $fan = $D ->where( array( 'id' => $ID))-> update( $_POST);

                    if( $fan ){ 

                        logac( $_POST['type'], 1);

                        adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                        msgbox( $LANG['edit'].$LANG['chenggong'], $_SERVER["HTTP_REFERER"] );

                    }else  msgbox( $LANG['edit'].$LANG['shibai'], $_SERVER["HTTP_REFERER"] );

                }

                msgbox( '' , '?' . getarray( $_GET ) );


            }else if( $_GET['mode'] == 'del'){


                if( isset( $_GET['token'] )) $_POST['token'] = $_GET['token'];

                if( ! yztoken( 'token' , $AC ) )  msgbox( $LANG['token'], '0');

                $ID = (int) $_GET['id'];
                $DATAS= $D ->where( array( 'id'=> $ID ) )-> find();
                $DATA = $D -> delete( array( 'id' => $ID));

                if( $DATA ){

                    adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATAS  )));
                    logac( $DATAS['type'], 2 );
                    msgbox( $LANG['yishanchu'] , '1');

                }else msgbox( $LANG['shanchusb'] , '0');

            }else if( $_GET['mode'] == 'add'){

                unset( $_GET['mode']);

                if( isset( $_POST['submit'])){

                    if(! yztoken('token',$AC) ) msgbox( $LANG['token'] , '?' . getarray( $_GET));

                    $DATA = $D -> where( array( 'type' => $_POST['type']) )-> find();

                    if( $DATA ) msgbox( $LANG['xitonglogcd']['biaomz'] , '?' . getarray( $_GET) );

                    $fanhui = $D  -> insert( $_POST );

                    if( $fanhui){ 

                        unset( $_POST['submit']);
                        adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));
                        adminmsgbox( $LANG['add'].$LANG['chenggong'] ,'?'.getarray( $_GET) );

                    }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));
                }

                msgbox( '' , '?' . getarray( $_GET ) );
            }?>

 
<?php }else{ 

    $PAGE  = (int) isset( $_GET['page'] ) ? $_GET['page'] : 0;
    $limit = listmit( $CONN['hnum'] , $PAGE );
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
                <th width="130"> <?php echo $LANG['xitonglogcd']['type']?></th>
                <th width="130"> <?php echo $LANG['xitonglogcd']['name']?></th>
                <th> <?php echo $LANG['xitonglogcd']['data']?></th>
                <th width="130"><?php echo $LANG['xitonglogcd']['type']?></th>
            </tr>
        </thead>

        <tbody>

        <?php $ONG = array();
              $shua = explode(',',$D->tablejg['0']);
              foreach( $shua as $zhi )  $ONG[$zhi] ='';
        ?>
                    <form method="post" action="?<?php  echo 'action=',$AC,'&mode=add';?>">

                         <input type="hidden" name="token" id="sctoken" value="<?php echo $_SESSION[$AC];?>" />

                         <tr class="text-c">
                         
                            <td><input type="text" class="input-text  size-M" name="type" value="<?php echo $ONG['type']?>"  /></td>
                            <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /></td>
                            <td><input type="text" class="input-text  size-M" name="data" value="<?php echo $ONG['data']?>"  /></td>
                            <td> <input class="btn btn-primary radius" type="submit"  value="<?php echo $LANG['add']?>" name="submit" /></td>
                         </tr>

                    </form>

            <?php if( $DATA){
              
                      foreach( $DATA as $ONG){ ?>
                        <form method="post" action="?<?php  echo 'action=',$AC,'&mode=edit';?>">

                              <input type="hidden" name="id" value="<?php echo $ONG['id'];?>" />
                              <input type="hidden" name="token" value="<?php echo $_SESSION[$AC];?>" />

                              <tr class="text-c">

                                    <td><input type="text" class="input-text  size-M" name="type" value="<?php echo $ONG['type']?>"  /></td>
                                    <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /></td>
                                    <td><textarea name="data" cols="" rows="" class="input-text" placeholder=""><?php echo $ONG['data']?></textarea></td>
                                    <td> <input class="btn btn-primary radius" type="submit"  value="<?php echo $LANG['edit']?>" name="submit" />
                                          <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i> </a>
                                    </td>

                               </tr>

                        </form>
            <?php
                    }
                 }
            ?>
         </tbody>
      </table>
   </div>
</div>

<div class="page">

   <?php   

   
   if( $ZSHU > $CONN['hnum'] ){

        if( ! isset( $_GET['fenqu'] ) ) $_GET['fenqu'] = '';

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

function admin_del( obj, id){

        layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+id,{},function(data){

                  if(data.token){  token = data.token; $("#sctoken").val(token); }
              
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