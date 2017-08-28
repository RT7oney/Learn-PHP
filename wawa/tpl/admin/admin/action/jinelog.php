<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('jinelog');

$LOG = logac('jinelog');

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



<?php 
  
  $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

	$limit = listmit( $CONN['hnum'] ,$PAGE);


   if( isset( $_GET['type']) && $_GET['type'] != '') $WHERE['type'] = $_GET['type'];

   if( isset( $_GET['fenqu']) && $_GET['fenqu'] != '') $WHERE['uid'] = $_GET['fenqu'];

   if( isset( $_GET['start']) && $_GET['start'] != '') $WHERE[ 'atime >='] = strtotime( $_GET['start']);

   if( isset( $_GET['end']) && $_GET['end'] != '') $WHERE[ 'atime <='] = strtotime( $_GET['end']);

   if( isset( $_GET['guan']) && $_GET['guan'] != '') $WHERE['data LIKE'] = '%'.$_GET['guan'].'%';

 
   $UUID = array();

    if(  isset(  $_GET['filed'] )   ){
        

         $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( 10000 )-> select();

         if( $DATA ){

            $x  = "日志id\t"; 
            $x .= "用户uid\t";
            $x .= "用户昵称\t";
            $x .= "日志分类\t";
            $x .= "记录\t";
            $x .= "备注\t";
            $x .= "ip\t";
            $x .= "时间\t";
           
            $x .=  "\n"; 

             foreach($DATA as $ONG ){

                 if( !isset( $UUID[$ONG['uid']])){
			 
				      $zhi = uid($ONG['uid']);

				      $UUID[$ONG['uid']] = $zhi['name'];
			    }

                 $x .= $ONG['id']."\t".
                       $ONG['uid']."\t".
                       $UUID[$ONG['uid']]."\t".
                       $LOG[$ONG['type']]."\t".
                       $ONG['jine']."\t".
                       $ONG['data']."'\t".
                       $ONG['ip']."\t".
                       date('Y-m-d H:i:s',$ONG['atime'])."\t\n";

             }

             toxls($x,'jinelog');

         }

    
    }

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

		    <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['xqsoso'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

            <input type="checkbox" name="filed" value="1"> <?php echo $LANG['daochu'];?>

		    <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

			<?php if( count( $WHERE )  > 0){

			          $where =  $D -> wherezuhe( $WHERE );
			
			
                   $fanhui = $D -> qurey("select sum(jine) num from `".$D->biao().'` '.$where);
				  
				   echo ' <button type="button" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6c1;</i> '.(float)$fanhui['num'].'</button> ';

                   if( isset( $_GET['fenqu'] ) && $_GET['fenqu'] != ''){

                       $UUU = uid($_GET['fenqu']);
                   
                      echo ' <button type="button" class="btn radius"><i class="Hui-iconfont">&#xe6c1;</i> '.(float)$UUU['jine'].'</button> ';
                   
                   }

                   
			
			}?>

		</form>
	</div>
	
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				
				<th width="40">ID</th>
				<th width="300"><?php echo $LANG['adminlog']['zhanghao'];?></th>
				<th><?php echo $LANG['adminlog']['fenlei'];?></th>
				<th><?php echo $CONN['jine'];?></th>
				<th> <?php echo $LANG['xqsoso'];?></th>

				<th width="130">IP</th>
				<th width="130"><?php echo $LANG['shijian'];?></th>
				

			</tr>
		</thead>
		<tbody>

<?php if( $DATA){

		
	  
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
				<td> <span style="color:<?php echo $ONG['jine'] < 0 ?'red':'green';?> ;"><?php echo $ONG['jine'];?> </span></td>
				<td> <textarea class="input-text" ><?php echo $ONG['data']?></textarea></td>
				<td><?php echo $ONG['ip'];?></td>
				<td><?php echo date('Y-m-d H:i:s',$ONG['atime']);?></td>
				
				
			</tr>

<?php } }else {?>
     
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

	        $_GET['guan'] = isset($_GET['guan']) ? $_GET['guan'] :'';
			$_GET['start'] = isset($_GET['start']) ? $_GET['start'] :'';
		    $_GET['end'] = isset($_GET['end']) ? $_GET['end'] :'';
			$_GET['fenqu'] = isset($_GET['fenqu']) ? $_GET['fenqu'] :'';
			$_GET['type'] = isset($_GET['type']) ? $_GET['type'] :'';
	 
         echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=','&guan='.$_GET['guan'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&type='.$_GET['type'].'&fenqu='.$_GET['fenqu'] );
  } 
  
?>

</div>

<?php  include HTPL.'foot.php'; ?>
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/webuploader/webuploader.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">

$(function(){


		
});
</script>
</body>
</html>