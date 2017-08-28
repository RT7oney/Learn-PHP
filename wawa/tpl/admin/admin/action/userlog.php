<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('userlog');

$LOG = logac('userlog');

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

<?php if( isset( $_GET['mode'])){

           
           if( $_GET['mode'] == 'edit'){ 
                
                      $ID = (int)$_GET['id'];

                      $DATA = $D ->where( array( 'id'=> $ID))-> find();

                      if( ! $DATA) adminmsgbox('');

                      $USE = uid($DATA['uid']);
            ?>
            <style> .yddddd {  margin-top: 3px;  display: block; } </style>

            <article class="page-container">

                <form  method="post" class="form form-horizontal" id="form-member-add" novalidate="novalidate">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">ID：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <span class="yddddd"> <?php echo $DATA['id']?> </span>
                        </div>
                    </div>
                
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['adminlog']['fenlei']?>：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                             <span class="yddddd"> <?php echo $LOG[$DATA['type']]?> </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['adminlog']['zhanghao']?>：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                             <span class="yddddd"> <?php echo $DATA['uid'],' <b style="color:Red;">( '.$USE['name'] .' )</b> '?> </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">IP：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                             <span class="yddddd"> <?php echo $DATA['ip']?> </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['shijian']?>：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                             <span class="yddddd"> <?php echo date( 'Y-m-d H:i:s', $DATA['atime']);?> </span>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['xiangqing']?>：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                        <textarea style="width:100%;height:200px;"><?php if($DATA['data'] != ''){
                            
                                  if( strpos( $DATA['data'] ,"{") !== false ) 

                                  print_r(unserialize($DATA['data']));
                                  else echo($DATA['data']);
                            }

                        ?></textarea>

                        </div>
                    </div>
                    
                </form>
            </article>

     <?php }else  adminmsgbox(''); ?> 

<?php }else{ 

    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);


   if( isset( $_GET['type']) && $_GET['type'] != '') $WHERE['type'] = $_GET['type'];

   if( isset( $_GET['fenqu']) && $_GET['fenqu'] != '') $WHERE['uid'] = $_GET['fenqu'];

   if( isset( $_GET['start']) && $_GET['start'] != '') $WHERE[ 'atime >='] = strtotime( $_GET['start']);

   if( isset( $_GET['end']) && $_GET['end'] != '') $WHERE[ 'atime <='] = strtotime( $_GET['end']);

   if( isset( $_GET['guan']) && $_GET['guan'] != '') $WHERE['data LIKE'] = '%'.$_GET['guan'].'%';

   
  

   $ZSHU = $D ->where( $WHERE ) -> total();

    

   $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

   $_SESSION[$AC] = token();

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

            <?php echo $LANG['riqifanwei']?>：
           <input type="text" name="start"  value="<?php echo isset($_GET['start']) ?$_GET['start']:'';?>" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}',dateFmt:'yyyy-MM-dd HH:mm:ss',lang:'<?php echo $CONN['htlang']?>'})" id="datemin" class="input-text Wdate" style="width:168px;">
           -
           <input type="text" name="end" value="<?php echo isset($_GET['end']) ?$_GET['end']:'';?>" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd HH:mm:ss',lang:'<?php echo $CONN['htlang']?>'})" id="datemax" class="input-text Wdate" style="width:168px;">
           
           <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['userid'];?>"  name="fenqu" value="<?php echo isset( $_GET['fenqu']) ? $_GET['fenqu'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['guanjian'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">



            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>
    </div>
    
    <div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
            <tr class="text-c">
                
                <th width="40">ID</th>
                <th width="300"><?php echo $LANG['adminlog']['zhanghao'];?></th>
                <th><?php echo $LANG['adminlog']['fenlei'];?></th>
                <th width="130">IP</th>
                <th width="130"><?php echo $LANG['shijian'];?></th>
                <th width="130"><?php echo $LANG['caozuo'];?></th>

            </tr>
        </thead>
        <tbody>

<?php if( $DATA){

        $UUID = array();
      
        foreach($DATA as $ONG){

             if( !isset( $UUID[$ONG['uid']])){
             
                 $zhi = uid($ONG['uid']);

                 $UUID[$ONG['uid']] = $zhi['name'].' <span style="color:Red;">('.$zhi['uid'].')</span>';

             }
?>
            <tr class="text-c">
                
                <td><?php echo $ONG['id']?></td>
                <td><?php echo $UUID[$ONG['uid']];?></td>
                <td> <span><?php echo $LOG[$ONG['type']];?> </span></td>
                <td><?php echo $ONG['ip'];?></td>
                <td><?php echo date('Y-m-d H:i:s',$ONG['atime']);?></td>
                <td>  <a class="btn btn-success radius" type="button" onclick="admin_role_add('<?php echo $LANG['xiangqing'];?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>','','510')" > <?php echo $LANG['xiangqing'];?> </a> </td>
                
            </tr>

<?php } }else {?>
     
            <tr class="text-c">
                <td colspan="6"> 
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

            $_GET['guan'] = isset($_GET['guan']) ? $_GET['guan'] :'';
            $_GET['start'] = isset($_GET['start']) ? $_GET['start'] :'';
            $_GET['end'] = isset($_GET['end']) ? $_GET['end'] :'';
            $_GET['fenqu'] = isset($_GET['fenqu']) ? $_GET['fenqu'] :'';
            $_GET['type'] = isset($_GET['type']) ? $_GET['type'] :'';
     
         echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=','&guan='.$_GET['guan'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&type='.$_GET['type'].'&fenqu='.$_GET['fenqu'] );
  } 
  
?>

</div>


<?php  include HTPL.'foot.php'; }?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/My97DatePicker/WdatePicker.js"></script>


<script type="text/javascript">
function admin_role_add(title,url,w,h){
    layer_show(title,url,w,h);
}
</script>
</body>
</html>