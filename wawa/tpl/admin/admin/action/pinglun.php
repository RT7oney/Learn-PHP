<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D     = db( 'pinglun' );

$LOG = logac('pingluntype');
$OFF = logac('off');

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



<?php if( isset( $_GET['mode'])){


        if( $_GET['mode'] == 'del'){

            if(!yztoken('token',$AC)) msgbox( $LANG['token'], '0');
            $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);

            $WHERE['id']  =  $ID;

            $DATA = $D ->where( $WHERE )-> find();

            if(! $DATA ) adminmsgbox($LANG['shujuno']);

            $DATAS = $D ->where($WHERE) -> delete();

            if( $DATAS){

                     adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA  )));

                     msgbox( $LANG['yishanchu'] , '1');
               
            }else msgbox( $LANG['shanchusb'] , '0');


        }else if( $_GET['mode'] == 'add'  || $_GET['mode'] == 'edit'){

            if( isset($_GET['uplx']) ){
            
                $_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';

                $DATAS = update($USER['id']);

                if(  $DATAS['code'] == 1 )  exit( json_encode( array('error' => 0 , 'url' =>  $DATAS['content']['pic']) ));
                else exit( json_encode( array('error' => 1 , 'message' =>  $DATAS['msg']) ));

            }

            $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);

            $WHERE['id'] = $ID ;

            $DATA = array();

            if( $_GET['mode']  == 'edit'){
                          
                $DATA = $D ->where( $WHERE)-> find();

                if( isset(  $_GET['ajson'] )){

                    if( ! yztoken( 'token',$AC ) ) adminmsgbox( $LANG['token'], '0');

                    $LX = (int) isset( $_GET['lx']) ? $_GET['lx']: 0;

                    if($LX > 2 || $LX < 0)  adminmsgbox( $LANG['shibai'] , '0');

                    if( ! $DATA ) adminmsgbox( $LANG['shujuno'],'0');
                    
                    $fan = $D ->where( $WHERE )-> update( array( 'off' => $LX ));

                    if( $fan){
                            
                            adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> array( 'off' => $DATA['off'] ), 'data'=> array( 'off' => $LX ) )));
                        
                            adminmsgbox( $LANG['chenggong'] , '1');
                    }else   adminmsgbox( $LANG['shibai'] , '0');

                }
            }

            if( isset( $_POST['submit'])){
            
            
                if(isset($_POST['kuozan'])){

                    foreach($_POST['kuozan'] as $k => $v ){

                         if( !is_array( $v ) && $v == $LANG['placeholderyes']) unset(  $_POST['kuozan'][$k] );

                    }

                    $_POST['kuozan'] = serialize($_POST['kuozan']);

                }else $_POST['kuozan'] = '';


                if( $_GET['mode']  == 'add'){

                    $_POST['atime'] =$_POST['xtime'] = time();

                    $fanhui = $D  -> insert($_POST);

                    if( $fanhui){ 

                        adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));
                        adminmsgbox( $LANG['add'].$LANG['chenggong'] );
                                         
                    }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));

                }else if( $_GET['mode']  == 'edit'){

                    $_POST['xtime'] = time();
                    if( isset($_POST['atime'])) unset( $_POST['atime']);

                    $fan = $D ->where( $WHERE )-> update( $_POST);
                    if( $fan){

                        adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                        adminmsgbox( $LANG['edit'].$LANG['chenggong'], '?'.getarray( $_GET));

                    }else  adminmsgbox( $LANG['edit'].$LANG['shibai'], '?'.getarray( $_GET));

                }

            }

            $_SESSION[$AC.$MO] = token();


            if( $_GET['mode']  == 'add'){  

                $shua = explode( ',', $D -> tablejg['0'] );
                foreach( $shua as $zhi )  $DATA[ $zhi] = '';
                $DATA['kuozan']= array();

            }else{

                if( $DATA['kuozan'] != '')  $DATA['kuozan'] = unserialize( $DATA['kuozan'] );

            }

        ?>
<style>
.yddddd{margin-top:3px;display:block;}


</style>
 <article class="page-container">
    <form  method="post" class="form form-horizontal" id="form-admin-role-add" enctype="multipart/form-data" >
    <input type="hidden" name="token" value="<?php echo $_SESSION[$AC.$MO];?>" />


    <?php if( $_GET['mode']  == 'edit' ){ ?>

        <div class="row cl">
        <label class="form-label col-xs-4 col-sm-3"> id：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 <span class="yddddd"> <?php echo $DATA['id'];?> </span>
            </div> 
        </div>

    <?php }?>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['name']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['name'];?>" placeholder=""  name="name" datatype="*"  nullmsg=" " >
            </div>
        </div>
      
    <?php

        foreach( $LANG['cmspinglun'] as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
        }

    ?>

    <?php

        foreach( $LANG['cmspinglunkz'] as $wk => $wv ){ 
                echo  houtaifenjie( $wv, 'kuozan['.$wk .']', (isset( $DATA['kuozan'][$wk] ) ? $DATA['kuozan'][$wk]:'' ) , $LANG['placeholderyes']);
        }

    ?>

    

        <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG[ $_GET['mode'] ];?>&nbsp;&nbsp;">
                </div>
        </div>

    </form>
</article>

<?php  } ?>

<?php }else{ 


    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);
    if( isset( $_GET['type'])) $_GET['cid']  = $_GET['type'];

    $_GET['cid']  = (float) isset( $_GET['cid'] ) ?$_GET['cid']:0;

    if( $_GET['cid'] > 0 ){
        
       
        $WHERE['type IN'] = $_GET['cid'];
    }

     if( isset( $_GET['fenqu']) && $_GET['fenqu'] !='' ) $WHERE['off'] =  $_GET['fenqu'];
    if( isset( $_GET['cpid']) && $_GET['cpid'] !='' ) $WHERE['cpid'] =  $_GET['cpid'];
    if( isset( $_GET['orderid']) && $_GET['orderid'] !='' ) $WHERE['orderid'] =  $_GET['orderid'];



     if( isset( $_GET['guan']) && $_GET['guan'] !='' ){

         $WHERE['id'] = $_GET['guan'];
         $WHERE['name OLK'] = '%'.$_GET['guan'].'%';
         $WHERE['miaoshu OLK'] = '%'.$_GET['guan'].'%';
         $WHERE['guanjian OLK'] = '%'.$_GET['guan'].'%';

     }



     
  


     $ZSHU = $D ->where( $WHERE ) -> total();

     $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

     if( ! $DATA) $DATA = array();

     $_SESSION[$AC] = token(); 

?>
<style>
.td-manage .Hui-iconfont{font-size:22px;}
</style>
<nav class="breadcrumb">

    <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> 
    <span class="c-gray en">&gt;</span>  <?php echo $LANG['adminac'][$_GET['action']];?>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" > <i class="Hui-iconfont"> &#xe68f; </i> </a> 

</nav>


<div class="page-container">

     <div class="text-c"> 

        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />

            <span class="select-box" style="width:108px">
                <select name="cid" class="select">  
                    <option value=""> <?php echo $LANG['allquan']?> </option>
                    <?php echo ywselect($LOG, isset($_GET['cid']) ?$_GET['cid']:'');?>
                </select>
            </span>

            <span class="select-box" style="width:108px">
                <select name="fenqu" class="select">
                    <option value=""> <?php echo $LANG['allquan']?> </option>
                    <?php echo ywselect($OFF, isset($_GET['fenqu']) ?$_GET['fenqu']:'');?>
                </select>
            </span>

            
            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['cpid'];?>"  name="cpid" value="<?php echo isset( $_GET['cpid']) ? $_GET['cpid'] : '';?>">
            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['orderid'];?>"  name="orderid" value="<?php echo isset( $_GET['orderid']) ? $_GET['orderid'] : '';?>">
          
            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['guanjian'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>

    </div>



<div class="cl pd-5 bg-1 bk-gray mt-20"> 
    <span class="l"> <a href="javascript:;" onclick="product_edit('<?php echo $LANG['add'] ?>','?<?php  echo 'action=',$AC,'&mode=add'.(isset($_GET['cid']) && $_GET['cid']!= ''?'&cid='.$_GET['cid'] :'')?>')"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['add'];?> </a> 
    </span>
    <span class="r"> <?php echo $LANG['gongyou'];?> <strong id="tiaoshu"><?php echo $ZSHU;?></strong>  </span>
</div>


 
<div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
         <thead>
            <tr class="text-c">

                <th width="100" class="text-c"> ID </th>
                <th class="text-l">   <?php echo $LANG['name'];?> </th>
                <th class="text-l" width="150"> <?php echo $LANG['cid'];?> </th>
                <th class="text-l" width="80"> <?php echo $LANG['renqi'];?> </th>
                <th width="100"> <?php echo $LANG['off'];?> </th>

            </tr>

        </thead>
      <tbody>

<?php 
if( $DATA ){

    foreach( $DATA as $ONG ){ 

?>
<tr class="text-l">
                
                    <td class="text-c"><a href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&ybj=1&id='.$ONG['id'];?>','<?php echo $ONG['id']?>')"><?php echo $ONG['id'];?></a></td>
                    <td> <?php echo $ONG['name'];?></td>


                    <td > <?php echo $LOG[$ONG['type']];?></td>
                    <td> <?php echo $ONG['renqi'];?></td>
                    


                <td class="f-14 td-manage text-c">

                <?php if( $ONG['off'] == 2 ){ ?>
                 <a href="javascript:;" onclick="admin_gengai(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none" title="<?php echo $OFF[$ONG['off']];?>" ><i class="Hui-iconfont"  style="color:green;">&#xe6e1;</i> </a>

                <?php }else if( $ONG['off'] == 1 ){ ?>

                 <a href="javascript:;" onclick="admin_gengai(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none" title="<?php echo $OFF[$ONG['off']];?>"><i class="Hui-iconfont" style="color:#dd514c;">&#xe6e0;</i> </a>

                <?php }else{ ?>

                 <a href="javascript:;" onclick="admin_gengai(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none" title="<?php echo $OFF[$ONG['off']];?>"><i class="Hui-iconfont"  style="color:red;">&#xe631;</i></a>

                <?php } ?>
     


                <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>','<?php echo $ONG['id']?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
                
                <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont" style="color:green;">&#xe6e2;</i>
                    
                </td>
</tr>

<?php }} else {?>
     
        <tr class="text-c">
            <td colspan="8"> 
                <span class="label label-warning radius"><?php echo $LANG['noshuju'];?></span>
            </td>
        </tr>

<?php }?>

    </tbody>
  </table>
</div>

</div>



</div>

<div class="page">
<?php   
    if( $ZSHU > $CONN['hnum'] ){

        $get = array('uid','shid','orderid','cid','off','guan','fenqu','faoff','hongbaoid','cpid');
        $ZUU = array();

        foreach( $get as $v ) $ZUU[$v] = !isset( $_GET[$v]) ? '' : $_GET[$v] ;
        echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=',
               '&'.getarray($ZUU) );

    }
?>
</div>


<?php }

include HTPL.'foot.php';

?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript">

var token ='<?php echo $_SESSION[$AC]?>';

function product_edit(title,url){

            var index = layer.open({
                type: 2,
                title: title,
                content: url,
            });

            layer.full(index);
}

function guanli(id,lx,obj){

         $.getJSON('?action=<?php echo $AC;?>&mode=edit&ajson=1&token=' + token + '&id='+id+'&lx='+lx,{},function(data){

                 if(data.token) token = data.token;
                
                 if(data.code == 1){

                    
                     if(lx == 2)       $(obj).html('<i class="Hui-iconfont"  style="color:green;">&#xe6e1;</i>');
                     else if(lx == 1)  $(obj).html('<i class="Hui-iconfont" style="color:#dd514c;">&#xe6e0;</i>');
                     else              $(obj).html('<i class="Hui-iconfont"  style="color:red;">&#xe631;</i>');
                     
                     layer.msg(  data.msg ,{ icon: 1 ,time : 1000});
                
                 }else layer.msg( data.msg ,{ icon: 2 ,time : 1000});

           });
}


function admin_gengai( obj,id){

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


function admin_del(obj,id){

        layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+id,{},function(data){

                  if(data.token) token = data.token;
              
                  if(data.code == 1){

                       $(obj).parents("tr").remove();

                       shu = $("#tiaoshu").html() *1;

                       $("#tiaoshu").html( shu -1 );

                       layer.msg('<?php echo $LANG['yishanchu'];?>',{icon:1,time:1000});

                  }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});

              });

        });
}



</script>
</body>
</html>