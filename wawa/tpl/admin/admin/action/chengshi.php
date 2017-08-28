<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('chengshi');

//if( isset( $YANZQX[ $NEWS[ $AC]][ $AC][ 'only']))$WHERE['adminid'] = $USER['id'];
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
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/webuploader/webuploader.css" />
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

           
           if( $_GET['mode'] == 'del'){

                if($_GET['token']   != $_SESSION[$AC]) msgbox( $LANG['token'], '0');


                $ID = (int) $_GET['id'];

                $DATAS= $D ->where( array( 'id'=> $ID))-> find();

                $DATA = $D -> delete( array( 'id' => $ID));

                if( $DATA ){

                    adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATAS  )));
                    msgbox( $LANG['yishanchu'] , '1');

                }else msgbox( $LANG['shanchusb'] , '0');



            }


}else{ 
     if( isset( $_POST['submit'] ) ){

                           
                                $ID = (int)$_POST['id'];

                                $DATA = $D ->where( array( 'id'=> $ID))-> find();
                     
                                if( ! yztoken( 'token' , $AC ) ) msgbox( $LANG['token'], '?'.getarray( $_GET));

                                if( $ID == '0' ){

                                    $fan = $D -> insert( $_POST);

                                    if( $fan){ 
                                           
                                           adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC ,'id'=> $fan ,'data'=> $_POST  )));

                                           msgbox( $LANG['add'].$LANG['chenggong'], '?' . getarray( $_GET) );

                                    }else  msgbox( $LANG['add'].$LANG['shibai'], '?' . getarray( $_GET) );


                                }else { 

                                    $fan = $D ->where( array( 'id' => $ID))-> update( $_POST);

                                    if( $fan){ 
                                           
                                           adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                                           msgbox( $LANG['edit'].$LANG['chenggong'], '?' . getarray( $_GET) );

                                    }else  msgbox( $LANG['edit'].$LANG['shibai'], '?' . getarray( $_GET) );

                                }

    }
           

    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $CONN['hnum']  = 20;
    $limit = listmit( $CONN['hnum'] ,$PAGE);

    if( isset( $_GET['fenqu']) &&  $_GET['fenqu'] != ''){ 
        
        $WHERE['diqu'] = $_GET['fenqu'];
        $WHERE['shangji OR'] = $_GET['fenqu'];

    } 

    if( isset( $_GET['guan']) &&  $_GET['guan'] != ''){ 

         $WHERE['name LIKE'] = '%'.$_GET['guan'].'%';

    }


    


    $ZSHU = $D ->where( $WHERE ) -> total();
    $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();
    if(! $DATA) $DATA = array();

   $_SESSION[$AC] = token();


?>
<nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>



<div class="page-container">

<div class="text-c"> 
        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />

           

            
           
           <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['dqbhao'];?>"  name="fenqu" value="<?php echo isset( $_GET['fenqu']) ? $_GET['fenqu'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['csname'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">




            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        

        </form>
    </div>








  <div class="mt-20">

    <table class="table table-border table-bordered table-hover table-bg table-sort">

        <thead>
            <tr class="text-c">
                <th width="200"> ID </th>
                <th> <?php echo $LANG['csname'];?> </th>
                <th> <?php echo $LANG['dqbhao'];?> </th>
                <th> <?php echo $LANG['shbhao'];?> </th>
                <th> <?php echo $LANG['beizhu'];?> </th>
                <th> <?php echo $LANG['caozuo'];?> </th>

            </tr>
        </thead>

     <tbody>
    <?php  
            $ONG = array();
            $shua = explode(',',$D->tablejg['0']);
            foreach( $shua as $zhi )  $ONG[$zhi] ='';
    ?>

     <form method="post">

                              <input type="hidden" name="id" value="0" />
                              <input type="hidden" name="token" value="<?php echo $_SESSION[$AC];?>" />

                              <tr class="text-c">
                                    <td> <?php echo $LANG['add']?> </td>
                                    <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /></td>

                                    <td><input type="text" class="input-text  size-M" name="diqu" value="<?php echo $ONG['diqu']?>"  />  </td>

                                    <td><input type="text" class="input-text  size-M" name="shangji" value="<?php echo $ONG['shangji']?>"  />  </td>

                                     <td><input type="text" class="input-text  size-M" name="ipname" value="<?php echo $ONG['ipname']?>"  />  </td>

                                     <td>
                                       <input class="btn btn-primary radius" type="submit"  value="<?php echo $LANG['add']?>" name="submit" />


                                     </td>

                                    

                                </tr>

                        </form>


     <?php if( $DATA){
              
                      foreach( $DATA as $ONG){ ?>

                        <form method="post">

                              <input type="hidden" name="id" value="<?php echo $ONG['id'];?>" />
                              <input type="hidden" name="token" value="<?php echo $_SESSION[$AC];?>" />

                              <tr class="text-c">
                                    <td><?php echo $ONG['id']?></td>
                                    <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /></td>

                                    <td><input type="text" class="input-text  size-M" name="diqu" value="<?php echo $ONG['diqu']?>"  />  </td>

                                    <td><input type="text" class="input-text  size-M" name="shangji" value="<?php echo $ONG['shangji']?>"  />  </td>

                                     <td><input type="text" class="input-text  size-M" name="ipname" value="<?php echo $ONG['ipname']?>"  />  </td>

                                     <td>
                                       <input class="btn btn-primary radius" type="submit"  value="<?php echo $LANG['edit']?>" name="submit" />
                                       
                                    <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none;color:Red;font-size:25px;"><i class="Hui-iconfont">&#xe6e2;</i> </a>


                                     </td>

                                    

                                </tr>

                        </form>

    <?php } } ?>

    </tbody>
    </table>
   </div>
</div>





<div class="page">

   <?php 

    if($ZSHU > $CONN['hnum']){

            $_GET['guan'] = isset($_GET['guan']) ? $_GET['guan'] :'';
            $_GET['start'] = isset($_GET['start']) ? $_GET['start'] :'';
            $_GET['end'] = isset($_GET['end']) ? $_GET['end'] :'';
            $_GET['fenqu'] = isset($_GET['fenqu']) ? $_GET['fenqu'] :'';
            $_GET['type'] = isset($_GET['type']) ? $_GET['type'] :'';
     
         echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=','&guan='.$_GET['guan'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&type='.$_GET['type'].'&fenqu='.$_GET['fenqu'] );
  } 
  
?>


</div>


<?php include HTPL.'foot.php'; }?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/webuploader/webuploader.js"></script>
<script type="text/javascript">

var token ='<?php echo $_SESSION[$AC]?>';

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