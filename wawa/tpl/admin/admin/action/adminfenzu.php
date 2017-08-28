<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('adminfenzu');

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

    if(  isset( $_GET['mode'])){ 

        if( $_GET['mode'] == 'del'){

            if( isset( $_GET['token'])) $_POST['token'] = $_GET['token'];
            if(! yztoken( 'token',$AC )) msgbox( $LANG['token'], '0');

            $ID = (int)( isset($_GET['id'] ) ? $_GET['id'] : 0 );
            $DATAS = $D -> where( array( 'id'=> $ID)) -> find();
            $DATA  = $D -> delete( array( 'id' => $ID));

            if( $DATA){

                adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id' => $ID ,'data' => $DATAS  )));
                msgbox( $LANG['yishanchu'] , '1');

            }else msgbox( $LANG['shanchusb'] , '0');

        }else if( $_GET['mode'] == 'add' || $_GET['mode'] == 'edit'){

            $ID = (int)( isset($_GET['id'] ) ? $_GET['id'] : 0 );
            $DATA = $D -> where( array( 'id' => $ID ))-> find();

            if( isset( $_POST['submit'])){

                if( ! yztoken( 'token',$AC.$MO ) ) msgbox( $LANG['token'], '?'.getarray( $_GET));

                if( isset( $_POST['shezhi'] ) ) $_POST['shezhi'] = serialize( $_POST['shezhi'] );
                else                            $_POST['shezhi'] = '';

                if( $DATA ){

                    $WHERE['id'] =   $ID;

                    $fanhui = $D ->where($WHERE)-> update($_POST);

                    if($fanhui){ 

                        unset( $_POST['submit']);
                        adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $ID , 'yuan' => $DATA, 'data'=> $_POST  )));
                        adminmsgbox( $LANG['edit'].$LANG['chenggong']);

                    }else adminmsgbox( $LANG['edit'].$LANG['shibai']);

                }else{

                    $fanhui = $D  -> insert($_POST);

                    if( $fanhui){ 

                        unset( $_POST['submit']);
                        adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));
                        adminmsgbox( $LANG['add'].$LANG['chenggong'] );

                    }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));
                }
            }

            $SHEZHI = array();

            if(  $ID < 1 ) $DATA = array('name'=>'','miaoshu' => '');
            else $SHEZHI = unserialize($DATA['shezhi']);

            $_SESSION[$AC.$MO] = token();

?>
<style>
.permission-list .permission-list2  dt{width:150px;}

</style>
<article class="page-container">
    <form  method="post" class="form form-horizontal" id="form-admin-role-add">
          
          <input type="hidden" name="token" value="<?php echo $_SESSION[$AC.$MO];?>" />
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span><?php echo $LANG['adminfenzu']['jiaoseming']?></label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text"  placeholder="" datatype="*"  nullmsg="<?php echo $LANG['shuru'].$LANG['mingzi']?>！"  id="roleName" name="name"  value="<?php echo $DATA['name']?>" />
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['adminfenzu']['beizhu']?></label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['miaoshu']?>" placeholder="" id="" name="miaoshu">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['adminfenzu']['piliang']?></label>
            <div class="formControls col-xs-8 col-sm-9">
                <a  class="btn btn-success radius" href="javascript:void(0);" id="piliangquan"><i class="icon-ok"></i> <?php  echo $LANG['adminfenzu']['quanxuan']?></a> 
                <a  class="btn btn-success radius" href="javascript:void(0);" id="piliangxuan"><i class="icon-ok"></i> <?php echo $LANG['adminfenzu']['quanxuan'].' '.$LANG['only']?></a>
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php  echo $LANG['adminfenzu']['wangzhanjiao']?></label>
            <div class="formControls col-xs-8 col-sm-9">

            <?php foreach($ACTION as $k => $dingji){?>
                <dl class="permission-list">
                    <dt>
                        <label>
                            <input type="checkbox" value="" <?php if( isset($SHEZHI[$k] )) echo 'checked="checked"';?> name="shezhi[<?php echo $k?>]" >
                            <?php echo $LANG['caidan'][$k]?></label>
                    </dt>
                    <dd>
                    <?php if( $dingji){
                                foreach($dingji as $wod){
                    ?>  <dl class="cl permission-list2">
                            <dt>
                                <label class="">
                                    <input type="checkbox" <?php if( isset($SHEZHI[$k][$wod] )) echo 'checked="checked"';?> value="" name="shezhi[<?php echo $k?>][<?php echo $wod?>]" >
                                    <?php echo $LANG['adminac'][$wod]?></label>
                            </dt>

                            <dd>
                                 <label class="">
                                    <input type="checkbox" value="" <?php if( isset($SHEZHI[$k][$wod]['soso'] )) echo 'checked="checked"';?> name="shezhi[<?php echo $k?>][<?php echo $wod?>][soso]" >
                                    <?php echo $LANG['soso']?></label>
                                <label class="">
                                    <input type="checkbox" value="" <?php if( isset($SHEZHI[$k][$wod]['add'] )) echo 'checked="checked"';?> name="shezhi[<?php echo $k?>][<?php echo $wod?>][add]" >
                                    <?php echo $LANG['add']?></label>
                                <label class="">
                                    <input type="checkbox" value="" <?php if( isset($SHEZHI[$k][$wod]['edit'] )) echo 'checked="checked"';?> name="shezhi[<?php echo $k?>][<?php echo $wod?>][edit]" >
                                    <?php echo $LANG['edit']?></label>
                                <label class="">
                                    <input type="checkbox" value="" <?php if( isset($SHEZHI[$k][$wod]['del'] )) echo 'checked="checked"';?> name="shezhi[<?php echo $k?>][<?php echo $wod?>][del]" >
                                    <?php echo $LANG['del']?></label>
                                
                                <label class="c-orange">
                                    <input type="checkbox" class="onlys" value="" <?php if( isset($SHEZHI[$k][$wod]['only'] )) echo 'checked="checked"';?> name="shezhi[<?php echo $k?>][<?php echo $wod?>][only]" >
                                   <?php echo $LANG['only']?></label>
                            </dd>

                        </dl>

                    <?php } }?>
                    </dd>
                </dl>

                <?php }?>
            
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-success radius" id="admin-role-save" name="submit"><i class="icon-ok"></i><?PHP echo $LANG[$MO];?></button>
            </div>
        </div>
    </form>
</article>

<?php }?>
 

<?php }else{ 
   

    $_SESSION[$AC] = token(); 

    $DATA = $D ->order('id desc')-> select();

    if(!$DATA)$DATA = array();

?>
<nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('<?php echo $LANG['adminfenzu']['tianjia'];?>','?<?php  echo 'action=',$AC,'&mode=add';?>','800')"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['adminfenzu']['tianjia'];?> </a> </span> <span class="r"><?php echo $LANG['adminfenzu']['gongshuju'];?><strong id="tiaoshu"><?php echo count($DATA);?></strong> </span> </div>
    <table class="table table-border table-bordered table-hover table-bg mt-20">
        <thead>
            
            <tr class="text-c">
                
                <th width="40">ID</th>
                <th width="200"><?php echo $LANG['adminfenzu']['jiaoming'];?> </th>
        
                <th width="300"><?php echo $LANG['adminfenzu']['miaoshu'];?> </th>
                <th width="70"> <?php echo $LANG['caozuo'];?> </th>
            </tr>
        </thead>
        <tbody>
<?php 
    if( $DATA){
         foreach( $DATA as $ONG){
?>  <tr class="text-c">
                
        <td> <?php echo $ONG['id'];?> </td>
        <td> <?php echo $ONG['name'];?> </td>

        <td> <?php echo $ONG['miaoshu'];?> </td>
        <td class="f-14"><a title="<?php echo $LANG['edit'];?>" href="javascript:;" onclick="admin_role_edit('<?php echo $LANG['adminfenzu']['jiaoseguanli'];?>','?<?php  echo 'action=',$AC,'&mode=edit&id=',$ONG['id'];?>','<?php echo $ONG['id'];?>')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_role_del(this,'<?php echo $ONG['id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>

    </tr>
    <?php }}else {?>
     
            <tr class="text-c">
                <td colspan="5"> 

                    <span class="label label-warning radius"><?php echo $LANG['noshuju'];?></span>

                </td>
    </tr>

    <?php }?>

        </tbody>
    </table>
</div>





<?php  include HTPL.'foot.php'; }?>
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript">

var token ='<?php echo $_SESSION[$AC]?>';

$(function(){

    $("#form-admin-role-add" ).Validform( { tiptype:2 });

    $("#piliangquan").click(function(){

        var l =$("input:checked").length;
        if(l > 0) $("input:checkbox").prop("checked",false);
        else  $("input:checkbox").prop("checked",true);

    });

    $("#piliangxuan").click(function(){

        var l = $("input.onlys:checked").length;
        if(l > 0) $("input.onlys:checkbox").prop("checked",false);
        else  $("input.onlys:checkbox").prop("checked",true);
    });

    $(".permission-list dt input:checkbox").click(function(){
        $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
    });


    $(".permission-list2 dd input:checkbox").click(function(){
        var l =$(this).parent().parent().find("input:checked").length;
        var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
        if($(this).prop("checked")){
            $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
            $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
        }
        else{
            if(l==0){
                $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
            }
            if(l2==0){
                $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
            }
        }
    });

});


function admin_role_add(title,url,w,h){
    layer_show(title,url,w,510);
}


function admin_role_edit(title,url,id,w,h){
    layer_show(title,url,w,510);
}


function admin_role_del(obj,id){
    layer.confirm('<?php echo $LANG['shanchumsgbox']?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
        
        $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token='+token+'&id='+id,{},function(data){
        
        if( data.token) token = data.token;

        if(data.code == '1'){
            shu = $("#tiaoshu").html() *1;
            $("#tiaoshu").html( shu -1 );

            $(obj).parents("tr").remove();
            layer.msg(data.msg ,{icon:1,time:1000});
        
        }else  layer.msg(data.msg,{icon:2,time:1000});
        
        });
    });
}

</script>
</body>
</html>