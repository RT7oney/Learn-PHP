<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('admin');

$fenzu = adminfenzu(-1);

$FENZU = array( '0'=> $LANG['chuangshiren']);

if( $fenzu){

     foreach( $fenzu as $wode){
  
              $FENZU[ $wode['id']] = $wode['name'];
     }
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
</style>
<title><?php echo $LANG['adminac'][$_GET['action']];?></title>
</head>
<body>
<?php 

    if( isset( $_GET['mode'])){

        if( $_GET['mode'] == 'del'){


            if( isset( $_GET['token'] ) ) $_POST['token'] = $_GET['token'];
            if(! yztoken( 'token',$AC ) ) msgbox( $LANG['token'], '0');

            $ID = (int) isset( $_GET['id'] ) ? $_GET['id']: 0 ;
            if( $ID == '1' ) msgbox( $LANG['jinzhidel'] , '0');

            $DATAS = $D -> where( array( 'id'=> $ID) ) -> find();
            $DATA =  $D -> delete( array( 'id' => $ID) );

            if( $DATA){

                adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATAS  )));
                adminuid($ID,2);
                msgbox( $LANG['yishanchu'] , '1');

            }else msgbox( $LANG['shanchusb'] , '0');

        }else if( $_GET['mode'] == 'add' || $_GET['mode'] == 'edit' ){

                $ID = (float) ( isset($_GET['id'] ) ? $_GET['id']: 0 );

                if( $ID > 0 ) $DATA = $D ->where( array( 'id'=> $ID))-> find();
                else  $DATA = array();

                if( isset( $_GET['ajson'])){

                    if( isset( $_GET['token'] ) ) $_POST['token'] = $_GET['token'];
                    if(! yztoken( 'token', $AC ) ) adminmsgbox( $LANG['token'], '0');

                    if( $DATA){

                        if( $DATA['off'] == 1) $BIAN = 0;
                        else $BIAN = 1;

                        $fan = $D ->where( array( 'id' => $ID))-> update( array( 'off' => $BIAN));
                        adminuid($ID,1);
                        adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> array( 'off' => $DATA['off'] ), 'data'=> array( 'off' => $BIAN ) )));

                        if( $fan) adminmsgbox( $LANG['chenggong'] , '1');
                        else      adminmsgbox( $LANG['shibai'] , '0');

                    }else  adminmsgbox( $LANG['bucunzai'],'0');

                }

                if( isset( $_POST['submit']) ){

                    if(! yztoken( 'token',$AC.$MO )) msgbox( $LANG['token'], '?'.getarray( $_GET));

                    $_POST['off'] = isset( $_POST['off']) ? $_POST['off'] : '';

                    if( $_POST['off'] == 'on' ) $_POST['off'] = 1;
                    else $_POST['off'] = 0;

                    $_POST['yanzhengip'] = isset( $_POST['yanzhengip']) ? $_POST['yanzhengip'] : '';

                    if( $_POST['yanzhengip'] == 'on' ) $_POST['yanzhengip'] = 1;
                    else $_POST['yanzhengip'] = 0;

                    if( $_POST['pass'] == '') unset( $_POST['pass']);
                    else $_POST['pass'] = mima( $_POST['pass']);

                    if( $_POST['epass'] == '') unset( $_POST['epass']);
                    else $_POST['epass'] = mima( $_POST['epass']);

                    if($ID > 0){

                        if( isset( $_POST['ip'])) unset( $_POST['ip']);

                        if( isset( $_POST['atime'])) unset( $_POST['atime']);


                        if( $DATA['name'] !=  $_POST['name']){

                             $fanhui = $D  ->where(array( 'name' => $_POST['name']))-> find();
                             if( $fanhui) msgbox( $_POST['name'] . $LANG['yijingcun'], '?'.getarray( $_GET));
                        }

                        $fan = $D ->where( array( 'id' => $ID))-> update( $_POST);

                        if( $fan){ 

                            adminuid($ID,1);
                            adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                            adminmsgbox( $LANG['edit'].$LANG['chenggong']);

                        }else  adminmsgbox( $LANG['edit'].$LANG['shibai']);

                    }else{

                        $_POST['atime'] = time();
                        $_POST['ip'] = ip();

                        $fanhui = $D  -> insert($_POST);

                        if( $fanhui){ 

                            unset( $_POST['submit']);
                            adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));
                            adminmsgbox( $LANG['add'].$LANG['chenggong'] );

                        }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));

                    }
                }

                $_SESSION[$AC.$MO] = token();

                if( $ID < 1 ){
                  
                  $shua = explode(',', $D->tablejg['0'] );
                  foreach( $shua as $zhi )  $DATA[ $zhi] = '';
                }

            ?>

<style>
.yddddd{margin-top:3px;display:block;}
</style>

<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/Switch/bootstrapSwitch.css" />


<article class="page-container">
    <form  method="post" class="form form-horizontal" id="form-admin-role-add">
          <input type="hidden" name="token" value="<?php echo $_SESSION[$AC.$MO];?>" />


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span><?php echo $LANG['admin']['denglum'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['name'];?>" placeholder=""  name="name"  datatype="*"  nullmsg=" ">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['loginpass'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="<?php echo $LANG['weikong']?>"  name="pass" >
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['caojipass'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="<?php echo $LANG['weikong']?>"  name="epass" >
            </div>
        </div>





        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['useroff'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

             <div class="switch"  data-on-label=" <?php echo $LANG['yiqiong'];?> " data-off-label=" <?php echo $LANG['yitiyong'];?> " >
                  <input type="checkbox"  <?php echo $DATA['off'] == 1 ?'checked="checked"':'';?>   name="off"/>
             </div>
  

            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">  <?php echo $LANG['userip'];?></label>
            <div class="formControls col-xs-8 col-sm-9">

             <div class="switch"  data-on-label=" <?php echo $LANG['yiqiong'];?> " data-off-label=" <?php echo $LANG['yitiyong'];?> " >
                  <input type="checkbox"  <?php echo $DATA['yanzhengip'] == 1 ?'checked="checked"':'';?>   name="yanzhengip"/>
             </div>
  

            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span><?php echo $LANG['uquanxian']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select name="type" class="select" size="1" > <?php echo ywselect($FENZU ,$DATA['type']);?></select>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> IP：</label>
            <div class="formControls col-xs-8 col-sm-9">
               <span class="yddddd"><?php echo $DATA['ip'] == '' ? ip() :$DATA['ip'] ;?></span>
                
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['shijian']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

               <span class="yddddd"> <?php echo date( 'Y-m-d H:i:s', $DATA['atime'] > 0 ? $DATA['atime'] : time() )?></span>
                
            </div>
        </div>



        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG['edit'];?>&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
  <?php } ?>

                    

        
 

<?php }else{ 

  

    $_SESSION[$AC] =token();
    
    $PAGE  = (int) isset($_GET['page'])?$_GET['page']:0;
    $limit = listmit( $CONN['hnum'] ,$PAGE);

    if( isset( $_GET['fenqu']) && $_GET['fenqu'] !='' ){
    
        $WHERE['name LIKE'] = '%'.$_GET['fenqu'].'%';
    }


    
    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order('id desc')->where( $WHERE )-> limit( $limit )-> select();

    

    if( ! $DATA) $DATA = array();

?>

<nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <div class="text-c"> 
        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />
            <input type="text" class="input-text" style="width:250px" placeholder="<?php echo $LANG['admin']['shurmiz'];?>"  name="fenqu" value="<?php echo isset( $_GET['fenqu'])?$_GET['fenqu']:'';?>">
            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['admin']['souyong'];?></button>

        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="admin_add('<?php echo $LANG['admin']['tianjiad']?>','?<?php  echo 'action=',$AC,'&mode=add';?>','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['admin']['tianjiad']?></a></span> <span class="r"><?php echo $LANG['gongyou'];?><strong id="tiaoshu"><?php echo $ZSHU;?></strong> </span> </div>
    <div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
            <tr class="text-c">
                
                <th width="40">ID</th>
                <th width="300"><?php echo $LANG['admin']['denglum'];?></th>
                
                <th><?php echo $LANG['admin']['jiaose'];?></th>
                <th width="130">IP</th>
                <th width="130"><?php echo $LANG['shijian'];?></th>
                
                <th width="100"><?php echo $LANG['shifouqy'];?></th>
                <th width="100"><?php echo $LANG['caozuo'];?></th>
            </tr>
        </thead>
        <tbody>


<?php if( $DATA){
  
   foreach($DATA as $ONG){

?>
            <tr class="text-c">
                
                <td><?php echo $ONG['id']?></td>
                <td><?php echo $ONG['name']?></td>
                <td><?php echo isset( $FENZU[$ONG['type']])? $FENZU[$ONG['type']]: '';?></td>
                <td><?php echo $ONG['ip'];?></td>
                <td><?php echo date('Y-m-d H:i:s',$ONG['atime']);?></td>
                <td class="td-status"> 
                
                <?php if( $ONG['off'] == 1){ ?> 

                       <span class="label label-success radius"> <?php echo $LANG['yiqiong'];?> </span>

                <?php }else { ?>

                       <span class="label radius"> <?php echo $LANG['yitiyong'];?> </span>
                
                <?php } ?>
                
                </td>

                <td class="td-manage">
                
                
                <a style="text-decoration:none" onClick="<?php echo $ONG['off'] == 1? 'admin_stop' :'admin_start';?>(this,'<?php echo $ONG['id']?>')" href="javascript:;" title="<?php echo $LANG['qiyong'];?>">

                <i class="Hui-iconfont">

                    <?php echo $ONG['off'] == 1? '&#xe631; ' :'&#xe615;';?>

                </i>
                
                </a>
                
                <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="admin_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>','<?php echo $ONG['id']?>','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
                
                <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i>
                
                </a></td>
            </tr>

<?php }}else {?>
     
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

<div class="page">

   <?php 
   
   if($ZSHU > $CONN['hnum']){

              $_GET['fenqu'] = isset($_GET['fenqu']) ? $_GET['fenqu'] :'';

              echo pagec($LANG['PAGE'],$CONN['hnum'],$ZSHU,$CONN['hpage'],$PAGE,'?action='.$_GET['action'].'&page=','&fenqu='.$_GET['fenqu'] );
  }
   
   
   
   ?>

</div>



<?php  include HTPL.'foot.php'; }?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>

<script type="text/javascript">
var LX = 0;


$(function(){

 

 $("#form-admin-role-add" ).Validform( { tiptype:2 });



});





var token ='<?php  echo $_SESSION[$AC]?>';

function admin_add(title ,url ,w ,h){

         layer_show(title ,url ,w ,h);

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

function admin_edit(title,url,id,w,h){

         layer_show( title, url, w, h);
}


function admin_stop(obj,id){

         layer.confirm( '<?php echo $LANG['quertiy']?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>}, function( index){

           $.getJSON('?action=<?php echo $AC;?>&mode=edit&ajson=1&token=' + token + '&id='+id,{},function(data){

                 if(data.token) token = data.token;
                
                 if(data.code == 1){

                     $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+id+')" href="javascript:;" title="<?php echo $LANG['qiyong'];?>" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');

                    $(obj).parents( "tr").find( ".td-status").html( '<span class="label radius"><?php echo $LANG['yitiyong'];?></span>');

                    $(obj).remove();

                    layer.msg( '<?php echo $LANG['yitiyong'];?>!',{ icon: 5 ,time : 1000});
                
                 }else layer.msg( data.msg ,{ icon: 2 ,time : 1000});

           });

       });
}


function admin_start(obj,id){

    layer.confirm( '<?php echo $LANG['querqiy']?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function( index){

        $.getJSON('?action=<?php echo $AC;?>&mode=edit&ajson=1&token=' + token + '&id='+id,{},function(data){

             if( data.token ) token = data.token;

             if( data.code == 1){

                    $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+id+')" href="javascript:;" title="<?php echo $LANG['tingyong'];?>" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');

                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius"><?php echo $LANG['yiqiong'];?></span>');

                    $(obj).remove();

                    layer.msg( '<?php echo $LANG['yiqiong'];?>!' , {icon: 6 , time : 1000});


             }else   layer.msg(  data.msg ,{ icon: 2 ,time : 1000});
         
       });
   });
}
</script>
</body>
</html>