<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('shouhuo');
$LOG = logac('shouhuo');
$TYPE = logac('shouhuotype');

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

               if( isset( $_GET['token'])) $_POST['token'] = $_GET['token'];

               if( !yztoken('token' , $AC ) ) msgbox( $LANG['token'], '0');

               $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);

               $WHERE['id'] = $ID ;

               $DATAS = $D ->where($WHERE)-> find();

               $DATA = $D ->where($WHERE) -> delete();

               if( $DATA){

                     adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATAS  )));
                            
                     msgbox( $LANG['yishanchu'] , '1');
               
               }else msgbox( $LANG['shanchusb'] , '0');


            
         }else if( $_GET['mode'] == 'add' ||  $_GET['mode'] == 'edit'){

                         
                $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);

                $WHERE['id'] = $ID ;

                $DATA = array();

                if( $_GET['mode']  == 'edit') $DATA = $D ->where( $WHERE)-> find();

                if( isset( $_POST['submit'])){

                    if( !yztoken('token',$AC.$MO )) msgbox( $LANG['token'], '?'.getarray( $_GET));


                    $_POST['token'] =  md5( $_POST['uid'].$_POST['xingming'].$_POST['shouji'].$_POST['zuoji'].$_POST['diqu'].$_POST['dizhi']);

                    if( $_POST['diqu'] > 0){

                        $shngji = chengshiid( $_POST['diqu'] );
                        $shngji[] = $_POST['diqu'];
                        $dizhi =  chengshijiexi( '', $shngji);
                        $_POST['beizhu'] = implode(' ', $dizhi) .' '. $_POST['dizhi'] ;

                    }


                    if( $_GET['mode']  == 'add'){

                        $tokenfan =  $D ->where( array( 'token' =>  $_POST['token'] ))-> find();

                        if( $tokenfan){

                            $DATA = $tokenfan;
                            $ID   =   $tokenfan['id'] ;

                            $fan = $D ->where( array( 'id' => $tokenfan['id'] ))-> update( $_POST);

                            if( $fan){ 

                                adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                                adminmsgbox( $LANG['edit'].$LANG['chenggong']);

                            }else adminmsgbox( $LANG['edit'].$LANG['shibai']);

                        }else{

                            $_POST['atime']  =  time();
                            $_POST['ip'] = ip();

                            $fanhui = $D  -> insert($_POST);

                            if( $fanhui){ 

                               

                                adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));

                                adminmsgbox( $LANG['add'].$LANG['chenggong'] );

                            }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));

                        }


                    }else if( $_GET['mode']  == 'edit'){

                        $fan = $D ->where( array( 'id' => $ID ))-> update( $_POST);

                        if( $fan){ 

                            adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                            adminmsgbox( $LANG['edit'].$LANG['chenggong']);

                        }else  adminmsgbox( $LANG['edit'].$LANG['shibai']);
                    }


                }

                $_SESSION[$AC.$MO] = token();

                if( $_GET['mode']  == 'add'){

                    $shua = explode( ',', $D->tablejg['0'] );
                    foreach( $shua as $zhi )  $DATA[ $zhi] = '';
                }
              
?>
<style>
.yddddd{margin-top:3px;display:block;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/Switch/bootstrapSwitch.css" />
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
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['uid'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['uid'];?>" placeholder=""  name="uid" >
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['xingming'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['xingming'];?>" placeholder=""  name="xingming" >
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['shouji'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['shouji'];?>" placeholder=""  name="shouji" >
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['zuoji'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['zuoji'];?>" placeholder=""  name="zuoji" >
            </div>
        </div>


       <div class="row cl">
       <input type="hidden"  value="<?php echo $DATA['diqu'];?>" name="diqu"  id="yuandiqu" >
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['diqu'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9" >
                  
              <span class="yddddd" id="chengshiid"> 

               <?php 
               
                      $shuju = chengshiid( $DATA['diqu']);

                      $html ='';

                      for($i = 0;$i< count($shuju) ; $i++){

                          $shujus = chengshi($shuju[$i]);
                          if($shuju[$i] > 0 )unset($shujus['0']);

                         $html.=' <select id="shisso'.$i.'" onchange="shiji'.$i.'(this.value)">';
                                   
                                  foreach($shujus as $k =>$v){

                                      $xb = $i+1;

                                      if( (isset($shuju[$xb]) && $k == $shuju[$xb] ) || $k ==  $DATA['diqu'])
                                           $html.='<option value="'.$k.'" selected="selected">'.$v.' </option>';
                                      else
                                           $html.='<option value="'.$k.'">'.$v.' </option>';
                                  }

                          $html.='</select>';

                      }

                      echo $html;
                    ?>
                </span>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['dizhi'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['dizhi'];?>" placeholder=""  name="dizhi" >
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['off'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 <select name="off" class="select"> <?php echo ywselect( $LOG, $DATA['off']);?> </select> 
            </div>
         </div>


         <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['shouhuotype'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 <select name="type" class="select">  <?php echo ywselect( $TYPE, $DATA['type']);?> </select> 
            </div>
         </div>

         <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['beizhu'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['beizhu'];?>" placeholder=""  name="beizhu" >
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> IP：</label>
            <div class="formControls col-xs-8 col-sm-9">

               <span class="yddddd"> <?php echo $DATA['ip'] == '' ? ip() :$DATA['ip'] ;?> </span>
                
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
                <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG[ $_GET['mode'] ];?>&nbsp;&nbsp;">
            </div>
        </div>

    </form>
</article>
<?php }?>
<?php }else{ 


   $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

  

    $limit = listmit( $CONN['hnum'] ,$PAGE);


   if( isset( $_GET['type']) && $_GET['type'] != '') $WHERE['off'] = $_GET['type'];

   if( isset( $_GET['fenqu']) && $_GET['fenqu'] != '') $WHERE['uid'] = $_GET['fenqu'];

   if( isset( $_GET['guan']) && $_GET['guan'] != ''){
       
       $WHERE['xingming LIKE'] = '%'.$_GET['guan'].'%';
       $WHERE['shouji OLK'] = '%'.$_GET['guan'].'%';
       $WHERE['zuoji OLK'] = '%'.$_GET['guan'].'%';
       $WHERE['dizhi OLK'] = '%'.$_GET['guan'].'%';
       $WHERE['beizhu OLK'] = '%'.$_GET['guan'].'%';

    }

    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

    if(! $DATA) $DATA = array();

?>
<nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">

    <div class="text-c"> 
        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />

            <span class="select-box" style="width:108px">
                 <select name="type" class="select"> <option value=""> <?php echo $LANG['allquan'];?></option> <?php echo ywselect($LOG, isset($_GET['type']) ?$_GET['type']:'');?> </select> 
            </span>

           <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['uid'];?>"  name="fenqu" value="<?php echo isset( $_GET['fenqu']) ? $_GET['fenqu'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['guanjian'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>
    </div>

<style>
span.ys0{color:red;}
span.ys1{color:green;}
span.ys2{color:#5a98de;}
</style>

<div class="page-container">


 <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="product_edit('<?php echo $LANG['add']?>','?<?php  echo 'action=',$AC,'&mode=add';?>')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['add']?></a></span> <span class="r"><?php echo $LANG['gongyou'];?><strong id="tiaoshu"><?php echo $ZSHU;?></strong> </span> </div>


<div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
         <thead>

            <tr class="text-c">
                <th width="130"> ID </th>
                <th > <?php echo $LANG['adminlog']['zhanghao'];?> </th>
                <th width="130"> <?php echo $LANG['user']['xingming']?></th>
                <th width="130"> <?php echo $LANG['user']['shouji']?></th>
                <th width="130"> <?php echo $LANG['user']['zuoji']?></th>
                <th width="130"> <?php echo $LANG['shouhuooff']?></th>
                <th> <?php echo $LANG['shijian'];?></th>
                <th> IP </th>
                <th> <?php echo $LANG['caozuo'];?></th>
            </tr>
        </thead>
      <tbody>
 <?php if( $DATA){

        $UUID = array();
              
                      foreach( $DATA as $ONG){ 
                          
                          
                           if( !isset( $UUID[$ONG['uid']])){
             
                                  $zhi = uid($ONG['uid']);

                                  $UUID[$ONG['uid']] = $zhi['name'].' <span style="color:Red;">('.$zhi['uid'].')</span>';

                            }
?>


      <tr class="text-c">
            <td> <?php echo $ONG['id']?> </td>
            <td> <?php echo $UUID[$ONG['uid']];?> </td>
            <td> <?php echo $ONG['xingming']?> </td>
            <td> <?php echo $ONG['shouji']?> </td>
            <td> <?php echo $ONG['zuoji']?> </td>
            <td> <span class="ys<?php echo $ONG['off'];?>"><?php echo $LOG[$ONG['off']]?> </span></td>
            <td> <?php echo date( 'Y-m-d H:i:s' , $ONG['atime']);?> </td>
            <td> <?php echo $ONG['ip']?> </td>
            <td> <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>','<?php echo $ONG['uid']?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
                <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
            </td>
      </tr>

                    

            <?php  } }else {  ?>
                 <tr class="text-c">
                        <td colspan="10"> 
                               <span class="label label-warning radius"><?php echo $LANG['noshuju'];?></span>
                        </td>
                 </tr>
            <?php } ?>

         </tbody>
      </table>
   </div>
</div>


<div class="page">

   <?php 
   
   
   $_SESSION[$AC] = token();
  
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

<?php include HTPL.'foot.php'; } ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">

var token ='<?php echo $_SESSION[$AC]?>';
var LX = 0;

function product_edit(title,url){

                    var index = layer.open({
                        type: 2,
                        title: title,
                        content: url,
                    });

                    layer.full(index);
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


function shiji2( id ){

        $("#yuandiqu").val(id);

}

function shiji1( id ){


        $.getJSON("<?php echo $CONN['dir']?>api.php?action=chenshi&id=" + id ,function( FANHUI ){

            if( FANHUI.code == 1 ){

                var html  = '';
                var shuju = FANHUI.data;
                var  ii   = 0;

                if( shuju ){

                    $.each( shuju, function( i, field){

                        if( ii == 0) $("#yuandiqu").val( i );
                        html +='<option value="'+i+'">'+field+'</option>';
                        ii++;

                    });

                    if(html == '' ){

                        if( $("#shisso2").length ){

                            $("#shisso2").remove();
                        }

                        $("#yuandiqu").val( id ); 

                    }else if(  $("#shisso2").length > 0){

                        $("#shisso2").html( html);

                    }else  $("#chengshiid").append( ' <select id="shisso2" onchange="shiji2(this.value)">' + html +'</select>' );

                }else{

                    if( $("#shisso2").length ){

                        $("#shisso2").remove();
                    }

                    $("#yuandiqu").val( id ); 
                }

            }else if(  $("#shisso2").length ) {

                if( $("#shisso2").length ){

                    $("#shisso2").remove();
                }

                $("#yuandiqu").val( id ); 
            }

        });
}



function shiji0(id){

        if( id < 1){
   
              if(  $("#shisso1").length) $("#shisso1").remove();
              if(  $("#shisso2").length) $("#shisso2").remove();

              $("#yuandiqu").val('0');
              return ;
        }

        if( $("#shisso2").length ) $("#shisso2").remove();

        $.getJSON("<?php echo $CONN['dir']?>api.php?action=chenshi&id=" + id ,function( FANHUI ){

                if( FANHUI.code == 1 ){

                    var html = '';
                    var shuju = FANHUI.data;

                    if( shuju ){

                        var get  = 0 ;
                        var  ii = 0;

                        $.each( shuju, function( i , field ){

                            if( ii == 0){

                                $("#yuandiqu").val(i);
                                get = i;
                            }

                            html +='<option value="'+i+'">'+field+'</option>';
                            ii++;

                        });



                        if( get > 0) shiji1( get );
                        else  $("#yuandiqu").val(id); 

                        if(html == '' ){

                            if(  $("#shisso1").length) $("#shisso1").remove();
                            if(  $("#shisso2").length) $("#shisso2").remove();
                            $("#yuandiqu").val( id ); 

                        }else if( $("#shisso1").length > 0 )
                                $("#shisso1").html( html);
                        else    $("#chengshiid").append( ' <select id="shisso1" onchange="shiji1(this.value)">' + html +'</select>' );

                    }else $("#yuandiqu").val( id ); 

                }else{

                    if(  $("#shisso1").length) $("#shisso1").remove();
                    if(  $("#shisso2").length) $("#shisso2").remove();
                    $("#yuandiqu").val( id ); 
                }

        });
}


$(function(){

    $("#form-admin-role-add" ).Validform( { tiptype:2 }); 

});
</script>
</body>
</html>