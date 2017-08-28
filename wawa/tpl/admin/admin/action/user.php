<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('user');

$xingbie = logac('xingbie');
$level   = logac('level');

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
    if( isset( $_GET['mode'])){

        $ID = (int) isset( $_GET['id'] ) ? $_GET['id'] : 0 ;

        if( $_GET['mode'] == 'del'){

            if($_GET['token']   != $_SESSION[$AC]) msgbox( $LANG['token'], '0');
            $WHERE['uid'] = $ID ;

            $DATAS = $D ->where($WHERE)-> find();
            $DATA  = $D ->where($WHERE) -> delete();

            if( $DATA){

                adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATAS  )));

                uid($ID,2);
                msgbox( $LANG['yishanchu'] , '1');

            }else msgbox( $LANG['shanchusb'] , '0');




        }else if( $_GET['mode'] == 'add' || $_GET['mode'] == 'edit' ){

            if( isset($_GET['uplx']) ){
            
                $_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';
                $DATAS = update($USER['id']);
                exit( json_encode( $DATAS));
            }

            $DATA = array();


            if( $ID > 0 ){
                $WHERE['uid']  =  $ID;
                $DATA = $D ->where( $WHERE )-> find();
            }

            if( isset( $_GET['ajson'])){

                if( isset( $_GET['token'] )) $_POST['token'] = $_GET['token'];

                if( !yztoken('token',$AC) ) adminmsgbox( $LANG['token'], '0');

                if( $DATA ){

                    if( $DATA['off'] == 1) $BIAN = 0;
                    else $BIAN = 1;

                    $fan = $D ->where( array( 'uid' => $ID))-> update( array( 'off' => $BIAN));

                    uid($ID,1);

                    adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> array( 'off' => $DATA['off'] ), 'data'=> array( 'off' => $BIAN ) )));

                    if( $fan) adminmsgbox( $LANG['chenggong'] , '1');
                    else      adminmsgbox( $LANG['shibai'] , '0');

                }else  adminmsgbox( $LANG['shujuno'],'0');

            }

            
            if( isset( $_POST['submit'])){

                if(!yztoken('token',$AC.$MO)) msgbox( $LANG['token'], '?'.getarray( $_GET));
                unset( $_POST['submit']);
                unset( $_POST['token']);
                unset($_GET['mode']);

                $_POST['off'] = isset( $_POST['off']) ? $_POST['off'] : '';

                if( $_POST['off'] == 'on' ) $_POST['off'] = 1;
                else $_POST['off'] = 0;

                $_POST['yanzhengip'] = isset( $_POST['yanzhengip']) ? $_POST['yanzhengip'] : '';

                if( $_POST['yanzhengip'] == 'on' ) $_POST['yanzhengip'] = 1;
                else $_POST['yanzhengip'] = 0;

                if( $_POST['mima'] == '') unset( $_POST['mima']);
                else $_POST['mima'] = mima( $_POST['mima']);

                if( $_POST['ermima'] == '') unset( $_POST['ermima']);
                else $_POST['ermima'] = mima( $_POST['ermima']);



                if( isset( $_POST['ip'])) unset( $_POST['ip']);

                if( isset( $_POST['atime'])) unset( $_POST['atime']);

                $jiance = array('zhanghao','email','shouji','weixin','weixinui','qqopen','weibo','zhifubaoopen','openid','openidd');

                


                $unset = array( 'jine', 'jifen', 'huobi' , 'tuid1', 'tuid2', 'adminid','atime');

                foreach( $unset as $unsets){

                    if( isset( $_POST[ $unsets] ))   unset( $_POST[ $unsets]);

                }
                
                if( $ID > 0){


                    foreach($jiance as $xuns){

                        if( $DATA[$xuns] !=  $_POST[$xuns] && $_POST[$xuns] != ''){

                            $fanhui = $D  ->where(array( $xuns => $_POST[$xuns] ))-> find();
                            if( $fanhui) msgbox( $_POST[$xuns] . $LANG['yijingcun'], '?' . getarray( $_GET));
                        }
                    }



                    $fan = $D ->where( array( 'uid' => $ID ))-> update( $_POST);       

                    if( $fan ){ 

                        uid( $ID , 1);

                        adminlog( $USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                        adminmsgbox( $LANG['edit'].$LANG['chenggong']);

                    }else  adminmsgbox( $LANG['edit'].$LANG['shibai']);

                
                }else{

                    foreach($jiance as $xuns){

                        if( $_POST[$xuns] != ''){

                            $fanhui = $D  ->where(array( $xuns => $_POST[$xuns] ))-> find();
                            if( $fanhui) msgbox( $_POST[$xuns] . $LANG['yijingcun'], '?' . getarray( $_GET));

                        }
                    }
                          $_POST['atime'] = time();
                          $_POST['ip'] = ip();

                          $_POST['tuid'] = (int) $_POST['tuid'];

                          $tuigyhu = uid($_POST['tuid']);

                          if($tuigyhu){

                                  for( $i=1 ;$i<  $CONN['tujishu'];$i++){
                                             $wds = $i-1;
                                             if($wds < 1) $wds='';
                                             $_POST['tuid'.$i] = $tuigyhu['tuid'.$wds];
                                
                                  }

                           
                           
                           }else  $_POST['tuid'] = '0';

                           $_POST['admin'] = $USER['id'];

                          




                          $fanhui = $D  -> insert($_POST);

                        
                          if( $fanhui){ 

                                unset( $_POST['submit']);

                                adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));

                                adminmsgbox( $LANG['add'].$LANG['chenggong'] );
                                
                          }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));


                }

            }

            $_SESSION[$AC.$MO] = token();


            if( $ID < 1){
                $shua = explode(',', $D->tablejg['0'] );
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

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span><?php echo $LANG['user']['name'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['name'];?>" placeholder=""  name="name"  datatype="*"  nullmsg=" ">
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['zhanghao'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['zhanghao'];?>" placeholder=""  name="zhanghao" >
            </div>
        </div>

 
         <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['user']['touxiang'];?>：</label>

               <input type="hidden" value="<?php echo $DATA['touxiang'];?>" placeholder=""  name="touxiang" >
              <div class="formControls col-xs-8 col-sm-9" >

                     <img <?php echo $DATA['touxiang']==''?:'src="'.$DATA['touxiang'].'"';?> id="imgshow" style="width:100px;height:100px;">
                  
                    <a href="#"  id="filePicker2"><i class="Hui-iconfont"></i> <?php echo $LANG['picupdate']?></a>
        
                

            </div>
        </div>



      <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['level'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 
                 <select name="level" class="select">  <?php echo ywselect($level,$DATA['level']);?> </select> 


            </div>
        </div>


 

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['useroff'];?></label>
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
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['loginpass'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="<?php echo $LANG['weikong']?>"  name="mima" >
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['caojipass'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="<?php echo $LANG['weikong']?>"  name="ermima" >
            </div>
        </div>




        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $CONN['jine'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
               <span class="yddddd"><?php echo $DATA['jine'];?></span>
                
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $CONN['jifen'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
               <span class="yddddd"><?php echo $DATA['jifen'];?></span>
                
            </div>
        </div>


      <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $CONN['huobi'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
               <span class="yddddd"><?php echo $DATA['huobi'];?></span>
                
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['email']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['email']?>"   name="email" >
            </div>
        </div>


       <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['shouji']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['shouji']?>"   name="shouji" >
            </div>
        </div>

        
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['weixin']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['weixin']?>"   name="weixin" >
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['weixinui']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['weixinui']?>"   name="weixinui" >
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['qqopen']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['qqopen']?>"   name="qqopen" >
            </div>
        </div>


      <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['weibo']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['weibo']?>"   name="weibo" >
            </div>
        </div>

         <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['zhifubaoopen']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['zhifubaoopen']?>"   name="zhifubaoopen" >
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['openid']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['openid']?>"   name="openid" >
            </div>
        </div>

              <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['openidd']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['openidd']?>"   name="openidd" >
            </div>
        </div>


      <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['zhiye']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['zhiye']?>"   name="zhiye" >
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['xingbie']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 
                 <select name="xingbie" class="select"> <option value="-1"> <?php echo $LANG['weixuan'];?></option> <?php echo ywselect($xingbie,$DATA['xingbie']);?> </select> 


            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['nianling']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['nianling']?>"   name="nianling" >
            </div>
        </div>

                <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['qqhaoma']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['qqhaoma']?>"   name="qqhaoma" >
            </div>
        </div>


                <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['weixinhaoma']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="<?php echo $DATA['weixinhaoma']?>"   name="weixinhaoma" >
            </div>
        </div>

        
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> IP：</label>
            <div class="formControls col-xs-8 col-sm-9">
               <input type="text" class="input-text" value="<?php echo $DATA['ip'] == '' ? ip() :$DATA['ip'] ;?>" name="ip" >
                
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['adminid']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

               <span class="yddddd"> <?php echo $DATA['adminid'];?></span>
                
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['tuid']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

            <input type="text" class="input-text" value="<?php echo $DATA['tuid'];?>" placeholder=""  name="tuid" >

            
                
            </div>
        </div>



        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['tuid1']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

               <span class="yddddd"> <?php echo $DATA['tuid1'];?></span>
                
            </div>
        </div>



        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['user']['tuid2']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

               <span class="yddddd"> <?php echo $DATA['tuid2'];?></span>
                
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
                <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG[$MO];?>&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

<?php } ?>

                    

<?php }else{ 
  
    $PAGE  = (int) isset($_GET['page'])?$_GET['page']:0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);

    if( isset( $_GET['fenqu']) && $_GET['fenqu'] !='' ){

        $WHERE['uid'] = $_GET['fenqu'];
        $WHERE['shouji OR'] = $_GET['fenqu'];
        $WHERE['name OLK'] = '%'.$_GET['fenqu'].'%';
    }
    
    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order('uid desc')->where( $WHERE )-> limit( $limit )-> select();

    $_SESSION[$AC] = token();

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
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"> <a href="javascript:;" onclick="product_edit('<?php echo $LANG['admin']['tianjiad']?>','?<?php  echo 'action=',$AC,'&mode=add';?>')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['admin']['tianjiad']?></a></span> <span class="r"><?php echo $LANG['gongyou'];?><strong id="tiaoshu"><?php echo $ZSHU;?></strong> </span> </div>
    <div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
            <tr class="text-c">
                
                <th width="40">ID</th>
                <th width="200"><?php echo $LANG['user']['zhanghao'];?> </th> 
                <th width="200"><?php echo $LANG['user']['name'];?></th>
                <th width="150"><?php echo $LANG['user']['shouji'];?></th>

                
                <th><?php echo $CONN['jine'];?>  </th>
                <!-- <th><?php echo $CONN['jifen'];?>  </th> -->
                <th>


                    佣金

                </th>

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
                
                <td><?php echo $ONG['uid']?></td>
                <td><?php echo $ONG['zhanghao']?></td>
                <td><?php echo $ONG['name']?></td>
                <td><?php echo $ONG['shouji']?></td>
                <td><?php echo $ONG['jine']?>   

                <input type="text" name=""  class="input-text" style="display: inline-block;width: 100px;">
                <span class="btn btn-secondary radius genggai1"  zhi="<?php echo $ONG['uid'] ?>"  >加钱</span>


                </td>


                <!-- <td><?php echo $ONG['jifen']?></td> -->
                <td>


                <?php echo $ONG['huobi']?>
                    
                 <input type="text" name=""  class="input-text" style="display: inline-block;width: 100px;">
                <span class="btn btn-secondary radius jiayongjin"  zhi="<?php echo $ONG['uid'] ?>"  >加佣金</span>

                </td>
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
                <a style="text-decoration:none" onClick="<?php echo $ONG['off'] == 1? 'admin_stop' :'admin_start';?>(this,'<?php echo $ONG['uid']?>')" href="javascript:;" title="<?php echo $LANG['qiyong'];?>">

                <i class="Hui-iconfont">

                    <?php echo $ONG['off'] == 1? '&#xe631; ' :'&#xe615;';?>

                </i>
                
                </a>
                
                <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['uid'];?>','<?php echo $ONG['uid']?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
                
                <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['uid']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i>
                
                </a></td>
            </tr>

<?php }}else {?>
     
            <tr class="text-c">
                <td colspan="15"> 

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
<script type="text/javascript" src="<?php echo TPL;?>js/webuploader/webuploader.js"></script>
<script type="text/javascript">

$(function(){ 
    
    /*加佣金*/
    jQuery(".jiayongjin").click(function(){
        var zhi = jQuery(this).attr('zhi');
        var jine = jQuery(this).prev().val();

        if (!confirm('确定更改金额吗？')) {
            return false;
        }


        $.ajax({
            async: true,
            type:"POST",
            url:"?action=ajax",
            data:{action:'jiayongjin',zhi:zhi,jine:jine},
            dataType:'json',
            success:function(data){

                if (data.o=='yes') {
                            location.reload(true);
                }

            }
        })

    })
    
	/*点击更改*/
	jQuery(".genggai1").click(function(){
		var zhi = jQuery(this).attr('zhi');
		var jine = jQuery(this).prev().val();


		if (!confirm('确定更改金额吗？')) {
			return false;
		}


		$.ajax({
			async: true,
			type:"POST",
			url:"?action=ajax",
			data:{action:'genggaijine',zhi:zhi,jine:jine},
			dataType:'json',
			success:function(data){

				if (data.o=='yes') {
					location.reload(true);
				}
				
			}
		})


	})

    $("#form-admin-role-add" ).Validform( { tiptype:2 });  });

var token ='<?php echo $_SESSION[$AC]?>';
    var uploader = WebUploader.create({
        pick: {
            id: "#filePicker2",
            multiple: false
        },
       
        fileSingleSizeLimit: 5120000,
        swf: '<?php echo TPL;?>js/webuploader/Uploader.swf',
        server: '?action=<?php echo $AC;?>&mode=edit&uplx=image',
        fileVal: 'image',
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

                     var str = response.content.pic;

                    if( str.indexOf('gif') >= 0 ||  str.indexOf('jpg') >= 0 ||  str.indexOf('jpeg') >= 0 ||  str.indexOf('png') >= 0 ||  str.indexOf('bmp') >= 0 )$("#imgshow").attr({ src:response.content.pic});


                     $("input[name='touxiang']").val(response.content.pic);

                
              
              }else  layer.msg(response.msg, { time: 2000,  });  
        

   });




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