<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('hongbao');
$LOG = logac('hongbaooff');
$ICO = array( '&#xe6e1;',
              '&#xe6e0;',
              '&#xe690;',
              '&#xe631;'

        );
$JINLOG = logac('jinelog');


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
<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/kindeditor/lang/<?php echo $CONN['htlang']?>.js"></script>
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


           if( isset( $_GET['token'] ) ) $_POST['token'] =  $_GET['token'];

           
           if( $_GET['mode'] == 'edit'){ 


               if(! yztoken( 'token' , $AC ) ) msgbox( $LANG['token'], '0');

             

               $ID = anquanqu($_GET['id']);
               if($ID == '')msgbox( $LANG['shibai'] , '0');

               $WHERE['id IN']  = $ID;
               $WHERE['off'] = 0;

               $fan = $D ->where($WHERE )-> update( array( 'off' => 3));
              
               if( $fan){

                    adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> array( 'off' => 0 ), 'data'=> array( 'off' => 3 ) )));

                      adminmsgbox( $LANG['chenggong'] , '1');

               }else  adminmsgbox( $LANG['shibai'] , '0');
 

           }else if( $_GET['mode'] == 'del'){

                         

                           if(! yztoken( 'token' , $AC ) ) msgbox( $LANG['token'], '0');

                        


                           $ID = anquanqu($_GET['id']);
                           if($ID == '')msgbox( $LANG['shanchusb'] , '0');
                           $WHERE['id IN']  = $ID;

                           $DATAS = $D ->where( $WHERE )-> select();
                           $DATA  = $D ->where( $WHERE )-> delete();

                           if( $DATA){

                                 adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $ID ,'data'=> $DATAS  )));
                                        
                                 msgbox( $LANG['yishanchu'] , '1');
                           
                           }else msgbox( $LANG['shanchusb'] , '0');

                 }
 }else{ 
   
    $CONN['hnum'] = 10;

    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $ORDER = 'id desc';

    $limit = listmit( $CONN['hnum'] ,$PAGE);

    if( isset( $_GET['fenqu']) && $_GET['fenqu'] !='' )$WHERE['sid'] =  $_GET['fenqu'];


    if( isset( $_GET['guan']) && $_GET['guan'] !='' )$WHERE['fuid'] =  $_GET['guan'];

    if( isset( $_GET['type']) && $_GET['type'] !='' )$WHERE['uid'] =  $_GET['type'];
    if( isset( $_GET['type2']) && $_GET['type2'] !='' )$WHERE['off'] =  $_GET['type2'];

    if( isset( $_GET['start']) && $_GET['start'] != '') $WHERE[ 'atime >='] = strtotime( $_GET['start']);

   if( isset( $_GET['end']) && $_GET['end'] != '') $WHERE[ 'atime <='] = strtotime( $_GET['end']);




     

    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order( $ORDER )->where( $WHERE )-> limit( $limit )-> select();

    if(! $DATA) $DATA = array();


?>
 <nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <div class="text-c"> 
        <form method="get">

           <input type="hidden" value="<?php echo $AC;?>" name="action" />

           
           <span class="select-box" style="width:108px">
                 <select name="type2" class="select"> <option value=""> <?php echo $LANG['allquan'];?></option> <?php echo ywselect($LOG, isset($_GET['type2']) ?$_GET['type2']:'');?> </select> 
            </span>

            <input type="text" name="start"  value="<?php echo isset($_GET['start']) ?$_GET['start']:'';?>" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}',dateFmt:'yyyy-MM-dd HH:mm:ss',lang:'<?php echo $CONN['htlang']?>'})" id="datemin" class="input-text Wdate" style="width:168px;">
           -
           <input type="text" name="end" value="<?php echo isset($_GET['end']) ?$_GET['end']:'';?>" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd HH:mm:ss',lang:'<?php echo $CONN['htlang']?>'})" id="datemax" class="input-text Wdate" style="width:168px;">


           <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['fuid']; ?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

           <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['uid']?>"  name="type" value="<?php echo isset( $_GET['type']) ? $_GET['type'] : '';?>">

           <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['shid']; ?>"  name="fenqu" value="<?php echo isset( $_GET['fenqu']) ? $_GET['fenqu'] : '';?>">

          


            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>
    </div>
<style>
i.ysss0{color:green;}
i.ysss1{color:#9900FF;}
i.ysss2{color:#5a98de;}
i.ysss3{color:red;}

</style>


 <div class="cl pd-5 bg-1 bk-gray mt-20"> 
 <span class="l">
 
<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> <?php echo $LANG['pidel']; ?></a> 
 
<a href="javascript:;" onclick="dataedit()" class="btn btn-success radius"><i class="Hui-iconfont">&#xe631;</i> <?php echo $LANG['piliangjinyong'];?></a> 
 
 
 
 
 
 
 </span>


 <span class="r"><?php echo $LANG['gongyou'];?><strong id="tiaoshu"><?php echo $ZSHU;?></strong> </span>
 
 </div>


<div class="mt-20">

    <table class="table table-border table-bordered table-hover table-bg table-sort">
         <thead>

            <tr class="text-c">
                <th width="25" class="text-l"><input type="checkbox" name="" value=""></th>
                <!-- <th> <?php echo $LANG['fuid']; ?></th> -->
                <th> <?php echo $LANG['uid']; ?> </th>
                    <!--<th> <?php echo $LANG['shid']; ?></th>
                <th> <?php echo $LANG['adminid']; ?></th> -->
                <th> <?php echo $LANG['hbjine'];?></th>
                <th> <?php echo $LANG['syjine'];?> </th>
                
                <th> <?php echo $LANG['mankeyong'];?> </th>
            
                <th><?php echo $LANG['time']['hbatime'];?></th>
                <th><?php echo $LANG['time']['hbgtime'];?></th>
                <th><?php echo $LANG['time']['hbstime'];?></th>


                
                <th> <?php echo $LANG['off'];?> </th>
                <th> <?php echo $LANG['type'];?> </th>
                
            </tr>
        </thead>
      <tbody>
 <?php 
 
 $_SESSION[$AC] = token();

 if( $DATA){

        $UUID = array();
        
        foreach( $DATA as $ONG){ 
            
            if( $ONG['gtime'] < time()){
                          
                $f = $D  ->where( array( 'id' => $ONG['id']))-> update( array( 'off' => 2));
                if( $f ) $ONG['off'] = 2;
            }
                          
                        
    ?>
      <tr>
      <td><input type="checkbox" class="checkbox" value="<?php echo $ONG['id']?>" name=""></td>
            
            <!-- <td><i class="Hui-iconfont" style="color:red;font-size:16px;">&#xe653;</i> <?php echo $ONG['fuid']?> </td>-->
            <td><i class="Hui-iconfont" style="color:#5a98de;font-size:16px;">&#xe60d;</i> <?php echo $ONG['uid']?> </td>    
            <!-- <td><i class="Hui-iconfont" style="color:#5a98de;font-size:16px;">&#xe62d;</i> <?php echo $ONG['sid']?> </td>
            <td><i class="Hui-iconfont" style="color:#5a98de;font-size:16px;">&#xe62d;</i> <?php echo $ONG['adminid']?> </td>-->
            <td><i class="Hui-iconfont" style="color:red;font-size:16px;">&#xe6b7;</i> <?php echo $ONG['haobaojine']?> </td>
            <td><i class="Hui-iconfont" style="color:green;font-size:16px;">&#xe6ca;</i> <?php echo $ONG['shengyujine']?> </td>
            <td><i class="Hui-iconfont" style="color:#5a98de;font-size:16px;">&#xe63a;</i> <?php echo $ONG['dayukeyong']?> </td>
            <td><i class="Hui-iconfont" style="color:green;font-size:16px;">&#xe690;</i> <?php echo $ONG['atime'] > 0 ? date('Y-m-d H:i',$ONG['atime']): $ONG['atime'];?> </td>
            <td><i class="Hui-iconfont" style="color:red;font-size:16px;">&#xe690;</i>  <?php echo $ONG['gtime'] > 0 ? date('Y-m-d H:i',$ONG['gtime']): $ONG['gtime'];?> </td>
            <td><i class="Hui-iconfont" style="color:green;font-size:16px;">&#xe690;</i> <?php echo $ONG['stime'] > 0 ? date('Y-m-d H:i',$ONG['stime']): $ONG['stime'];?>   </td>
            <td class="text-c"><i class="Hui-iconfont ysss<?php echo $ONG['off'];?>" style="font-size:16px;" title="<?php echo $LOG[$ONG['off']]?>"><?php echo $ICO[$ONG['off']];?></i>  </td>    
            <td><?php echo $JINLOG[$ONG['type']]?></td>
      </tr>

                    

            <?php  } }else {  ?>
                 <tr class="text-c">
                        <td colspan="15"> 
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
   
   
  
   if($ZSHU > $CONN['hnum']){

            $_GET['guan'] = isset($_GET['guan']) ? $_GET['guan'] :'';
            $_GET['start'] = isset($_GET['start']) ? $_GET['start'] :'';
            $_GET['end'] = isset($_GET['end']) ? $_GET['end'] :'';
            $_GET['fenqu'] = isset($_GET['fenqu']) ? $_GET['fenqu'] :'';
            $_GET['type'] = isset($_GET['type']) ? $_GET['type'] :'';
            $_GET['type2'] = isset($_GET['type2']) ? $_GET['type2'] :'';
     
         echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=','&guan='.$_GET['guan'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&type='.$_GET['type'].'&type2='.$_GET['type2'].'&fenqu='.$_GET['fenqu'] );
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
<script type="text/javascript" src="<?php echo TPL;?>js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">

var token ='<?php echo $_SESSION[$AC]?>';

function datadel(){

        
        var s = $(".checkbox:checked").length;

       if( s < 1 ) layer.msg('<?php echo $LANG['qingxuazen'];?>', { time: 2000,  });  
       else{

             var su = Array();

             $(".checkbox:checked").each(function(){

                 su.push(  $(this).val() );
           
             });


             
        layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+su,{},function(data){

                  if(data.token) token = data.token;
              
                  if(data.code == 1){

                      

                       layer.msg('<?php echo $LANG['yishanchu'];?>',{icon:1,time:1000,url:'?action=<?php echo $AC;?>'});


                  }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});

              });

        });

      
       
       }



}

function dataedit(){


      
      var s = $(".checkbox:checked").length;

       if( s < 1 ) layer.msg('<?php echo $LANG['qingxuazen'];?>', { time: 2000,  });  
       else{

             var su = Array();

             $(".checkbox:checked").each(function(){

                 su.push(  $(this).val() );
           
             });


             
        layer.confirm('<?php echo $LANG['piliangjinyong'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=edit&ajson=1&token=' + token + '&id='+su,{},function(data){

                  if(data.token) token = data.token;
              
                  if(data.code == 1){

                      

                       layer.msg('<?php echo $LANG['chenggong'];?>',{icon:1,time:1000,url:'?<?php echo getarray($_GET);?>'});


                  }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});

              });

        });

      
       
       }






}



$(function(){


        
});
</script>
</body>
</html>