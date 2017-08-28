<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db( 'dingdanx' );
$yesno = logac('dingxoff');



$faoff     = logac( 'faoff' );
$payoff    = logac( 'payoff' );
$paytype   = logac( 'dingpaytype' );
$zhifutype = xitongpay( -1 );
$yuntype = logac('yuntype');
$YFFS = logac('yunfs');

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
<style>
.td-manage .Hui-iconfont{font-size:22px;}
.off0{color:red;}
.off1{color:green;}
</style>
<nav class="breadcrumb">

    <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> 
    <span class="c-gray en">&gt;</span>  <?php echo $LANG['adminac'][$_GET['action']];?>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" > <i class="Hui-iconfont"> &#xe68f; </i> </a> 

</nav>


<?php

    $cccc = array(    'off' => $LANG['off'].'#select#'.logacto('dingxoff'),
                     'type' => $LANG['chufs'].'#select#'.logacto('dingtype'),
                  'biaoshi' => '发货快递',
                  'beizhu' => '发货单号',
                    'kahao' => '退货快递',
                   'kamima' => '退货单号',
                   'miaosufen' => '描述评分(主)',
                   'fuwufen' => '服务评分',
                  'wuliufen' => '物流评分',
                  'pinguser' => '评论昵称',
                  'pingoff' => '评论状态#select#'.logacto('off'),
                  'pingtime' => '评论时间#time',
                  'pingname' => '评论标题',
                  'miaoshu' => '评论描述#textarea#100px;',
                  'ptupian' => '评论主图#imgupdate',
                  'ptupianji' => '评论图片集#imgtuji2',

                   
            );

    if( isset( $_GET['mode'])){


        if( $_GET['mode'] == 'del'){


        }else if( $_GET['mode'] == 'edit'){

            
              if( isset($_GET['uplx']) ){    

                 $_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';

                 $DATAS = update($USER['id']);

                 if(  $DATAS['code'] == 1 )  exit( json_encode( array('error' => 0 , 'url' =>  $DATAS['content']['pic']) ));
                 else exit( json_encode( array('error' => 1 , 'message' =>  $DATAS['msg']) ));

              }

            $ID = (float)(isset($_GET['id']) ? $_GET['id'] : 0);

            $DATA = $D ->where(array('id' => $ID )) ->find();

            if( isset($_POST['submit'])){

                if( !yztoken('token',$AC.$MO) ) msgbox( $LANG['token'], '?'.getarray( $_GET));

                unset( $_POST['type']);

                if($DATA['off'] > 1){

                    if($_POST['off']< 2)$_POST['off'] = 2;
                
                
                
                }else unset($_POST['off']);


                $update = array( 'ctime' => time());

                foreach($_POST as $k => $v){

                    if( isset( $cccc[$k]) ) $update[$k] = $v ;
                
                }

                if( $DATA['off'] > 1 ){

                    


                        $fanhui = shouquandi( $DATA['type'] , $DATA['cpid'],$_POST );

                        $update['biaoshi'] = $_POST['biaoshi'];
                        $update['beizhu']  = $_POST['beizhu'];
                        $update['kahao']   = $fanhui['jishu'];
                        $update['kamima']  = $fanhui['mima'];

                         

                        if($fanhui['off'] == '2') $update['off'] = 3;

                }

                if( isset( $_POST['ptupianji'])) $_POST['ptupianji'] = serialize($_POST['ptupianji']);
                else $_POST['ptupianji'] = '';

                $update['ptupianji'] = $_POST['ptupianji'];

                if( $_POST['pingoff'] == 2 && $DATA['pingoff'] != 2 ) $update['pingtime'] = time();


                $fan = $D ->where( array('id' => $ID ) )-> update( $update);

               
                if( $fan){ 

                    adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                    adminmsgbox( $LANG['edit'].$LANG['chenggong']);

                }else  adminmsgbox( $LANG['edit'].$LANG['shibai']);

            }

            $_SESSION[$AC.$MO] = token();

        ?>
<style>
.yddddd{margin-top:3px;display:block;}

.gioge li {border:1px solid #ccc;margin-bottom:20px;padding:10px;}
.gioge li p input{margin-bottom:5px;}

.gioge .Hui-iconfont{font-size:18px;display:inline-block;}
.gioge > li:first-child p   label{width:100%;}

.gioge li p  label{float:left;width:198px;}

.table th, .table td{padding:0px 8px;line-height: 12px;font-size:12px;}
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
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['orderid']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['orderid'];?> </span>
                </div> 
            </div>


            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['uid']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['uid'];?> </span>
                </div> 
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['shid']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['shid'];?> </span>
                </div> 
            </div>

         

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['cpid']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['name'].' ( <span style="color:red;"> '.$DATA['cpid'].' </span> )';?> <br />
                     <img src="<?php echo $DATA['tupian']?>" width="300"></span>
                </div> 
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">  <?php echo $HUOBI[ $DATA['huobi']];?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['jine'];?> </span>
                </div> 
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['num']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['num'];?> </span>
                </div> 
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['canshu']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['canshu'];?> </span>
                </div> 
            </div>

       

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['canshu']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    
                        <td> <?php 
                        if(  $DATA['kuaiid'] > 0)
                        echo $yuntype[$DATA['kuaijil']] .'<br />'. 
                                        $YFFS[$DATA['kuaitype']]   .'<br />'.
                                       $DATA['kuaiid'] 
                        ;
                        else echo $LANG['baoyou'];

                              
                        
                        
                         
                         ?>  
                        </td>
                </div> 
            </div>





            <?php 
            
            
            foreach( $cccc as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
            
            ?>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['atime']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo date('Y-m-d H:i:s',$DATA['atime']);?> </span>
                </div> 
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['xtime']?>：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo date('Y-m-d H:i:s',$DATA['ctime']);?> </span>
                </div> 
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> IP：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['ip'];?> </span>
                </div> 
            </div>


        <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG[ $_GET['mode'] ];?>&nbsp;&nbsp;">
                </div>
        </div>

    </form>
</article>


    <?php } ?>




<?php }else{ 


    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);


    if( isset( $_GET['off']) && $_GET['off'] != '' ) $WHERE['off'] = $_GET['off'];
    if( isset( $_GET['pingoff']) && $_GET['pingoff'] != '' ) $WHERE['pingoff'] = $_GET['pingoff'];
    
    if( isset( $_GET['uid']) && $_GET['uid'] != '' ) $WHERE['uid'] = $_GET['uid'];
    if( isset( $_GET['shid']) && $_GET['shid'] != '' ) $WHERE['shid'] = $_GET['shid'];
    if( isset( $_GET['cpid']) && $_GET['cpid'] != '' ) $WHERE['cpid'] = $_GET['cpid'];
    if( isset( $_GET['orderid']) && $_GET['orderid'] != '' ) $WHERE['orderid'] = $_GET['orderid'];
    if( isset( $_GET['guan']) && $_GET['guan'] != '' ){
        
        $WHERE['canshu LIKE'] = '%'.$_GET['guan'].'%';
        $WHERE['kahao OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['kamima OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['beizhu OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['biaoshi OLK'] = '%'.$_GET['guan'].'%';
    }

    


    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

    $_SESSION[$AC] = token();

    if(! $DATA) $DATA = array();

    $PAYYOF = logac('off');

?>


<div class="page-container">

<div class="text-c"> 

        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />

          

            <?php echo $LANG['chulioff'];?>:
            <span class="select-box" style="width:108px">
                 <select name="off" class="select">  
                 <option value=""> <?php echo $LANG['allquan']?> </option>
                 <?php echo ywselect($yesno, isset($_GET['off']) ?$_GET['off']:'');?> </select> 
            </span>
            评论状态
            <span class="select-box" style="width:108px">
                 <select name="pingoff" class="select">  
                 <option value=""> <?php echo $LANG['allquan']?> </option>
                 <?php echo ywselect($PAYYOF, isset($_GET['pingoff']) ?$_GET['pingoff']:'');?> </select> 
            </span>

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['cpid'];?>"  name="cpid" value="<?php echo isset( $_GET['cpid']) ? $_GET['cpid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['uid'];?>"  name="uid" value="<?php echo isset( $_GET['uid']) ? $_GET['uid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['shid'];?>"  name="shid" value="<?php echo isset( $_GET['shid']) ? $_GET['shid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['orderid'];?>"  name="orderid" value="<?php echo isset( $_GET['orderid']) ? $_GET['orderid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['guanjian'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>

        <div class="cl pd-5 bg-1 bk-gray mt-20"> 
            <span class="r"> <?php echo $LANG['gongyou'];?> <strong id="tiaoshu"><?php echo $ZSHU;?></strong>  </span>
        </div>


  <div class="mt-20">

    <table class="table table-border table-bordered table-hover table-bg table-sort">

        <thead>

            <tr class="text-c">
                <th width="130"> ID </th>
                <th width="300"> <?php echo $LANG['orderid'];?> </th>
                <th> <?php echo $LANG['uid'];?> </th>
                <th> <?php echo $LANG['shid'];?> </th>
                <th> <?php echo $LANG['cpid'];?> </th>
                <th> <?php echo $LANG['jine'];?> </th>
                <th> <?php echo $LANG['num'];?> </th>
                <th> <?php echo $LANG['atime'];?> </th>
                <th> <?php echo $LANG['chulioff'];?> </th>
                <th> 评论状态 </th>
                <th > <?php echo $LANG['caozuo'];?> </th>

            </tr>

        </thead>

     <tbody>


 <?php if( $DATA){

            $CPID = array();

            foreach( $DATA as $ONG){ 

                if(!isset( $CPID[$ONG['cpid']])){

                    $chanpin =  danye( $ONG['cpid'] ,$D ,1 );

                    if( $chanpin ){
                
                    $CPID[$ONG['cpid']] = $chanpin['name'].'( <span style="color:red;">'.$ONG['cpid'].'</span> )';

                    }else $CPID[$ONG['cpid']] = $LANG['noshuju'].'( <span style="color:red;">'.$ONG['cpid'].'</span> )';
                
                }
                
                
                
                ?>

                <tr class="text-c">

                    <td><?php echo $ONG['id']?></td>
                    <td><input type="text" class="input-text  size-M" value="<?php echo $ONG['orderid']?>"  /></td>

                    <td><?php echo $ONG['uid']?></td>

                    <td> <?php echo $ONG['shid']?> </td>
                    <td> <?php  echo $CPID[$ONG['cpid']];?> </td>
                    <td> <?php echo $ONG['jine']?> </td>

                    <td> <?php echo $ONG['num']?>  </td>
                    <td> <?php echo $ONG['atime'] > 0? ' <span style="color:blue;">'.date('Y-m-d H:i:s',$ONG['atime']).'</span> ':'No Time' ;?> </td>
                    <td>  <span class="off<?php echo $ONG['off']?>"><?php echo $yesno[$ONG['off']]?></span> </td>
                     <td>  <span class="off<?php echo $ONG['pingoff']?>"><?php echo $PAYYOF[$ONG['pingoff']]?></span> </td>

                    
                    <td> <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 


                   
                    
                    
                    </td>

                </tr>

    <?php } }else{ ?>

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

   <?php   if( $ZSHU > $CONN['hnum'] ){

                    $get =  array('uid','shid','orderid','guan','cpid','off','guan','pingoff');

                    $ZUU = array();
                    foreach($get as $v) $ZUU[$v] = !isset( $_GET[$v])?'':$_GET[$v];

                    echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=', '&'.getarray($ZUU) ); 
            }
   ?>

</div>



<?php   } include HTPL.'foot.php'; ?>

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



</script>
</body>
</html>