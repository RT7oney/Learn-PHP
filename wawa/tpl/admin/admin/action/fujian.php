<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('fujian');

if( isset( $YANZQX[ $NEWS[ $AC]][ $AC][ 'only']))$WHERE['adminid'] = $USER['id'];

$LOG = logac('fujian');
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
<link href="<?php echo TPL;?>js/lightbox2/2.8.1/css/lightbox.css" rel="stylesheet" type="text/css" >
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

        if( $_GET['mode'] == 'edit'){ 

            if( isset($_GET['uplx']) ){
            
                $_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';

                $DATAS = update($USER['id'],1);
                exit( json_encode( $DATAS));
            }


        }else if( $_GET['mode'] == 'del'){

            if($_GET['token']   != $_SESSION[$AC]) msgbox( $LANG['token'], '0');

            $ID = anquanqu($_GET['id']);
            $WHERE['id IN']  = $ID;

            $DATAS = $D ->where( $WHERE )-> select();
            $DATA  = $D ->where( $WHERE )-> delete();

            if( $DATA){

                foreach($DATAS as $shuju){

                    @unlink(ONGPHP.'../'.$shuju['pic']);
                    @unlink(ONGPHP.'../'.$shuju['pic'].'shuiying.jpg');
                    @unlink(ONGPHP.'../'.$shuju['pic'].'suoluetu.jpg');
                }
                
                adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $ID ,'data'=> $DATAS  )));
                msgbox( $LANG['yishanchu'] , '1');
            }else msgbox( $LANG['shanchusb'] , '0');

        }else if( $_GET['mode'] == 'add'){


        } ?>


<?php }else{ 

   $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

   $CONN['hnum'] *=2;

    $limit = listmit( $CONN['hnum'] ,$PAGE);


   if( isset( $_GET['type']) && $_GET['type'] != '') $WHERE['type'] = $_GET['type'];

   if( isset( $_GET['fenqu']) && $_GET['fenqu'] != '') $WHERE['adminid'] = $_GET['fenqu'];

   if( isset( $_GET['houzui']) && $_GET['houzui'] != '') $WHERE['houzui'] = $_GET['houzui'];

   

   if( isset( $_GET['start']) && $_GET['start'] != '') $WHERE[ 'atime >='] = strtotime( $_GET['start']);

   if( isset( $_GET['end']) && $_GET['end'] != '') $WHERE[ 'atime <='] = strtotime( $_GET['end']);

   if( isset( $_GET['guan']) && $_GET['guan'] != '') $WHERE['name LIKE'] = '%'.$_GET['guan'].'%';

   $ZSHU = $D ->where( $WHERE ) -> total();

   $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

   $_SESSION[$AC] = token();

   if(! $DATA) $DATA = array();


?>
<nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="?action=<?php echo $AC;?>" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">


        
    <div class="text-c"> 
        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />

            <span class="select-box" style="width:108px">
                 <select name="type" class="select"> <option value=""> <?php echo $LANG['allquan'];?></option> <?php echo ywselect($LOG, isset($_GET['type']) ?$_GET['type']:'');?> </select> 
            </span>

            <span class="select-box" style="width:108px">
                 <select name="houzui" class="select"> <option value=""> <?php echo $LANG['allquan'];?></option> <?php echo ywselect($FUJIAN, isset($_GET['houzui']) ?$_GET['houzui']:'');?> </select> 
            </span>

            <?php echo $LANG['riqifanwei']?>：
           <input type="text" name="start"  value="<?php echo isset($_GET['start']) ?$_GET['start']:'';?>" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}',dateFmt:'yyyy-MM-dd HH:mm:ss',lang:'<?php echo $CONN['htlang']?>'})" id="datemin" class="input-text Wdate" style="width:168px;">
           -
           <input type="text" name="end" value="<?php echo isset($_GET['end']) ?$_GET['end']:'';?>" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd HH:mm:ss',lang:'<?php echo $CONN['htlang']?>'})" id="datemax" class="input-text Wdate" style="width:168px;">
           
           <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['userid'];?>"  name="fenqu" value="<?php echo isset( $_GET['fenqu']) ? $_GET['fenqu'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['mofusoso'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">



            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>
            <a href="#"  id="filePicker2" style="float:right;"><i class="Hui-iconfont"></i> <?php echo $LANG['picupdate']?></a>

        </form>
    </div>
    


    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">  <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> <?php echo $LANG['pidel'];?></a> </span> <span class="r"><?php echo $LANG['gongyou'];?><strong id="tiaoshu"><?php echo $ZSHU;?></strong> </span>  </div>
    <div class="portfolio-content">
        <ul class="cl portfolio-area">
<?php if( $DATA){

         $IMGS = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

        foreach($DATA as $ONG){

             
           
           if( in_array( $ONG['houzui'], $IMGS) === false)$zname = TPL.'js/img/'.$ONG['houzui'].'.png';

           else  $zname =  $ONG['pic'];
          


?>

            <li class="item">
                <div class="portfoliobox">
                    <input class="checkbox" name="id[]" type="checkbox" value="<?php echo $ONG['id'];?>">

                    <div class="picbox"><a href="<?php echo $zname;?>" data-lightbox="gallery" data-title="<?php echo $ONG['name'];?>"><img src="<?php echo $zname;?>"></a></div>
                    <div class="textbox"><?php echo $ONG['pic'];?> </div>
                </div>
            </li>
            <?php } }else {?>
     
         
              <div class="text-c"> 

                    <span class="label label-warning radius"><?php echo $LANG['noshuju'];?></span>

              </div>
                

<?php }?>
        
        </ul>
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
            $_GET['houzui'] = isset($_GET['houzui']) ? $_GET['houzui'] :'';


            
     
         echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=','&guan='.$_GET['guan'].'&start='.$_GET['start'].'&end='.$_GET['end'].'&type='.$_GET['type'].'&fenqu='.$_GET['fenqu'].'&houzui='.$_GET['houzui']  );
  } 
  
?>

</div>
<?php  include HTPL.'foot.php'; } ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lightbox2/2.8.1/js/lightbox-plus-jquery.min.js"></script> 
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




$(function(){



    $.Huihover(".portfolio-area li");
   




    var uploader = WebUploader.create({
        pick: {
            id: "#filePicker2",
            multiple: true
        },
       
        fileSingleSizeLimit: 5120000,
        swf: '<?php echo TPL;?>js/webuploader/Uploader.swf',
        server: '?action=<?php echo $AC;?>&mode=edit&uplx=all',
        fileVal: 'all',
        duplicate: true,
        runtimeOrder:'html5,flash',
            chunked:true,
        forceURLStream: true
    });

    uploader.on('filesQueued', function(files){
        uploader.upload();
        uploader.disable();
    });

    uploader.on('uploadBeforeSend', function (file, data){
        data['type'] = 'w2b';
    });

    uploader.on('uploadFinished', function(files){
        setTimeout(function () {
            uploader.enable();
        }, 2000);
    });

   uploader.on('uploadSuccess', function(files,response){
              
              if(response.code == 1){


                     layer.msg( "<?php echo $LANG['chenggong'];?>" , { time: 2000,  url: "?action=<?php echo $AC;?>" });  

                   
                     

                
              
              }else{   
                  
                 
                  layer.msg(response.msg, { time: 2000,  });  
              
              
              
              }
        

   });


});
</script>
</body>
</html>