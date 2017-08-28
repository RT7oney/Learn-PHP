<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('type1');

if( isset( $YANZQX[ $NEWS[ $AC]][ $AC][ 'only']))$WHERE['adminid'] = $USER['id'];

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
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/webuploader/webuploader.css" />
<link rel="stylesheet" href="<?php echo TPL;?>js/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/lang/<?php echo $CONN['htlang']?>.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<style>
</style>
<title><?php echo $LANG['adminac'][$_GET['action']];?></title>
<style>
.ztree li span.button.edit{margin-left:10px;}
.ztree li span.button.remove{margin-left:10px;}
</style>
</head>
<body>
<?php 
if( isset( $_GET['mode'])){

                if( $_GET['mode'] == 'del'){

                    if( isset( $_GET['token'] )) $_POST['token'] = $_GET['token'];
                    if( !yztoken( 'token' , $AC ) ) msgbox( $LANG['token'], '0');

                    $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);
                    $WHERE['id']  =  $ID;

                    $DATA = $D ->where( $WHERE )-> find();
                    if(! $DATA ) adminmsgbox($LANG['shujuno']);

                    $T = $D ->where( array('cid' => $ID ) )-> total();
                    if($T > 0 ) adminmsgbox($LANG['cunz'],'0');

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

                       if( $_GET['mode']  == 'edit') $DATA = $D ->where( $WHERE)-> find();

                        
                       if( isset( $_POST['submit'])){
                     
                            if( !yztoken('token' , $AC.$MO ) ) msgbox( $LANG['token'], '?'.getarray( $_GET));


                            if(isset($_POST['tupianji']))$_POST['tupianji'] = serialize($_POST['tupianji']);
                            else $_POST['tupianji'] = '';

                            if( isset( $_GET['ybj']) || $MO == 'add') {

                            if(isset($_POST['kuozanform']))$_POST['kuozanform'] = serialize($_POST['kuozanform']);
                            else $_POST['kuozanform'] = '';

                            }else {

                                if(isset($_POST['kuozan'])){

                                    foreach($_POST['kuozan'] as $k => $v){

                                         if( !is_array( $v ) && $v == $LANG['placeholderyes']) unset(  $_POST['kuozan'][$k] );

                                    }



                                     $_POST['kuozan'] = serialize($_POST['kuozan']);

                                }else $_POST['kuozan'] = '';
                            
                            
                            }

                           
                            


                            $_POST['adminid'] = $USER['id'];
                            
                            if($ID == $_POST['cid']) $_POST['cid'] = 0;

                            $fajis = sjtype($_POST['cid']);
                            


                            $shangji = count( $fajis);

                            if( isset( $DATA['cid']) && $DATA['cid'] > 0){

                                $faxias = xjtype( $DATA['cid']);
                                
                                $shangji +=count( $faxias);

                            }

                            $DATA['cid'] =  $_POST['cid'];

                            if($shangji  > $CONN['fenleiji'] ) msgbox( $LANG['fenjidayu'].$CONN['fenleiji'], '?'.getarray( $_GET));


                            

                            if( $_GET['mode']  == 'add'){


                                $_POST['atime'] =$_POST['xtime'] = time();

                                $_POST['url'] = scurl( isset( $_POST['url'] ) && $_POST['url'] !='' ? $_POST['url'] : $_POST['name'] , 1 );

                                $fanhui = $D  -> insert($_POST);

                                if( $fanhui){ 

                                    unset( $_POST['submit']);
                                    chaurl($_POST['url'] ,'1');

                                    adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));

                                    adminmsgbox( $LANG['add'].$LANG['chenggong'] );
                                 
                                }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));


                            }else if( $_GET['mode']  == 'edit'){

                                         $_POST['xtime'] = time();
                                         unset( $_POST['atime']);
                                         if( is_array( $fajis ) && in_array( $ID , $fajis) ) msgbox( $LANG['fenjidayu'].$CONN['fenleiji'], '?'.getarray( $_GET));

                                        if( $DATA['url'] != $_POST['url'] || $_POST['url'] == '' ){

                                            chaurl($DATA['url'] ,'2');
                                            
                                            $_POST['url'] = scurl($_POST['url'] ==''?$_POST['name']:$_POST['url'],1);
                                        }

                                         $fan = $D ->where( $WHERE )-> update( $_POST);

                                         if( $fan){ 

                                                chaurl($_POST['url'] ,'1');
                                                adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                                                adminmsgbox( $LANG['edit'].$LANG['chenggong'], '?'.getarray( $_GET));

                                         }else  adminmsgbox( $LANG['edit'].$LANG['shibai'], '?'.getarray( $_GET));
                    
                            }
 
                       }

                        $_SESSION[$AC.$MO] = token();

                        if( $_GET['mode']  == 'add'){

                            $shua = explode( ',', $D->tablejg['0'] );
                            foreach( $shua as $zhi )  $DATA[ $zhi] = '';
                        }else{

                            if( $DATA['kuozanform'] != '')   $DATA['kuozanform'] = unserialize( $DATA['kuozanform'] );
                            if( $DATA['kuozan'] != '')           $DATA['kuozan'] = unserialize( $DATA['kuozan'] );

                            

                        }

                        


?>
<style>
.yddddd{margin-top:3px;display:block;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo TPL;?>js/Switch/bootstrapSwitch.css" />
<article class="page-container">
    <form  method="post" class="form form-horizontal" id="form-admin-role-add" enctype="multipart/form-data" >
    <input type="hidden" name="token" value="<?php echo $_SESSION[$AC.$MO];?>" />


        <?php if( $MO  == 'edit' ){?>

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

        <div class="row cl">

            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['cid']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

                <input type="hidden" name="cid" id="mmtype" value="<?php echo $DATA['cid']?>" />
                <ul id="tree" class="ztree"></ul>

            </div>
        </div>

        

        <?php 
            
            if( isset( $_GET['ybj']))  $NOUI = 1;
        
            foreach( $LANG['cmschangyo'] as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
        
        ?>

        <?php 
        

        if( isset( $_GET['ybj']) || $MO == 'add') {


             foreach( $LANG['typeother'] as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
        
        ?>

        <?php }else{

           if( $DATA['kuozanform'] != ''){

              

                $canshu = explode('#',$LANG['typeother']['kuozanform'] );

                if($canshu['2'] != '' ){

                   $ziduan = explode(',',$canshu['2']);
                   if(count( $ziduan ) == 2){

                       $i = 0;

                       foreach( $DATA['kuozanform'] as $kmm){

                           if($kmm[$ziduan['0']] == '')continue;

                            $wk =  $kmm[$ziduan['0']].'#'.trim( $kmm[$ziduan['1']] );

                            
                         

                           echo  houtaifenjie( $wk,"kuozan[".$i."]", (isset( $DATA['kuozan'][$i] ) ? $DATA['kuozan'][$i]:'' ) , $LANG['placeholderyes']);

                       
                        $i++;
                       }
                   
                   
                   
                   
                   }

           

                


                }

               
        
        ?>


        <?php } } ?>
    




        <?php if( $MO == 'edit' ){?>

        <div class="row cl">

            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['atime'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="yddddd"> <?php echo date( 'Y-m-d H:i:s',$DATA['atime']);?> </span>
            </div> 

        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['xtime'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="yddddd"> <?php echo date( 'Y-m-d H:i:s',$DATA['xtime']);?> </span>
            </div> 
        </div>

        <?php }?>

        
 

    
        <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG[ $_GET['mode'] ];?>&nbsp;&nbsp;">
                </div>
        </div>

    </form>
</article>
<?php } ?>

<?php }else{ ?>

 <nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

 <table class="table">
    <tr>
        <td width="200" class="va-t">
        <a href="?action=<?php echo $AC;?>&mode=add" class="btn btn-primary radius" target="testIframe" ><?php echo $LANG['add'];?></a>
        <ul id="tree" class="ztree"></ul>
        </td>
        <td class="va-t"><IFRAME ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100%  height=390px SRC="?action=<?php echo $AC;?>&mode=add"></IFRAME></td>
    </tr>
</table>

<div class="page">


</div>


<?php

 $_SESSION[$AC] = token(); 


}
 include HTPL.'foot.php';
$TYPE = array();

$DATAS = $D ->order('paixu desc,id asc')-> select();

if( isset( $_GET['mode']))
$TYPE[] = array(  'id'  => 0 ,
                          'pId' => 0,
                         'name' => $LANG['dingji'],
                           'lx' => 0

               );




if( $DATAS ){

    foreach($DATAS as $TYD){
        
        $TYPE[] = array(  'id'  => $TYD['id'] ,
                          'pId' => $TYD['cid'],
                         'name' => $TYD['name'],
                           'lx' => $TYD['leixin']

               );
    
    }

}


?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/zTree/js/jquery.ztree.all-3.5.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/webuploader/webuploader.js"></script>
<script type="text/javascript">
var token ='<?php echo $_SESSION[$AC]?>';

var  zTree;



var setting = {
    view: {
        
        dblClickExpand: false,
        showLine: false,
        selectedMulti: false
    },
    <?php if( !isset($_GET['mode'])){ ?>    
    edit: {
                enable: true,
                editNameSelectAll: true,


                showRemoveBtn: showRemoveBtn,
                showRenameBtn: showRenameBtn
                
    },
    <?php } ?>
    data: {
        simpleData: {
            enable:true,
            idKey: "id",
            pIdKey: "pId",
            rootPId: ""
        }
    },
    callback: {
        beforeRemove:beforeRemove,
        beforeEditName: beforeEditName,
        beforeClick:beforeClick 
    }
};

var log, className = "dark";

function showRemoveBtn(treeId, treeNode) {
            return true;
        }
function showRenameBtn(treeId, treeNode) {
            return true;
}


<?php if( isset($_GET['mode'])){ ?>

    function beforeRemove(treeId, treeNode) {
    
    
    return false;
    }

        function beforeEditName(treeId, treeNode) {
    
    
    return false;
    }

        function beforeClick(treeId, treeNode) {


            $("#mmtype").val(treeNode.id);
         
    
    
    return true;
    }



<?php }else{ ?>

function beforeRemove(treeId, treeNode) {

              
               
               layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+treeNode.id,{},function(data){

                  if(data.token) token = data.token;
              
                  if(data.code == 1){
                    
                    

                       layer.msg('<?php echo $LANG['yishanchu'];?>',{icon:1,time:1000,url:'?action=<?php echo $AC;?>'});

                  }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});

              });

        });

               
             return false;
}

 function beforeClick(treeId, treeNode) {
            var zTree = $.fn.zTree.getZTreeObj("tree");

            if (treeNode.isParent) {


                  if(treeNode.lx == 1)demoIframe.attr("src","?action=center&type="+treeNode.id);
                  else demoIframe.attr("src","?action=type&mode=edit&id="+treeNode.id);
                   zTree.expandNode(treeNode);


                return false;
            } else {
             
              if(treeNode.lx == 1)
                  demoIframe.attr("src","?action=center&type="+treeNode.id);
              else 
                  demoIframe.attr("src","?action=type&mode=edit&id="+treeNode.id);

                return true;
            }
}

function beforeEditName(treeId, treeNode) {

               var zTree = $.fn.zTree.getZTreeObj("tree");

               zTree.selectNode(zTree.getNodeByParam("id", treeNode.id ));

             demoIframe.attr("src","?action=type&mode=edit&ybj=1&id="+treeNode.id);


         return false;
        }

<?php }?>

var zNodes = <?php echo json_encode($TYPE)?>;
var newCount = 1;


$(function(){
$("#form-admin-role-add" ).Validform( { tiptype:2 });  



var t = $("#tree");
    t = $.fn.zTree.init(t, setting, zNodes);

    
    var zTree = $.fn.zTree.getZTreeObj("tree");

<?php if( !isset($_GET['mode'])){ ?>

    demoIframe = $("#testIframe");
    demoIframe.bind("load", loadReady);

<?php }else if($DATA['cid'] > 0) {

    
    
    echo  'zTree.selectNode(zTree.getNodeByParam("id", '.$DATA['cid'].'))';
    }
    
    ?>





   
 
        
});





function loadReady() {
        var bodyH = demoIframe.contents().find("body").get(0).scrollHeight,
        htmlH = demoIframe.contents().find("html").get(0).scrollHeight,
        maxH = Math.max(bodyH, htmlH), minH = Math.min(bodyH, htmlH),
        h = demoIframe.height() >= maxH ? minH:maxH ;
        if (h < 530) h = 530;
        demoIframe.height(h);
}


</script>
</body>
</html>