<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('tixian');
ini_set('memory_limit', '256M');
if( isset( $YANZQX[ $NEWS[ $AC]][ $AC][ 'only']))$WHERE['adminid'] = $USER['id'];

$array = array('explx1', 'explx2','explx3','explx4','explx5','explx6');
$LOG = cetype();
$LOG['0'] = $LANG['allquan'];
$OFF = logac('off');

ksort($LOG);

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
</head>
<body>

<?php if( isset( $_GET['mode'])){

           

         if( $_GET['mode'] == 'del'){

                       if(!yztoken('token',$AC)) msgbox( $LANG['token'], '0');
                        $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);

                        $WHERE['id']  =  $ID;
                        
                        $DATA = $D ->where( $WHERE )-> find();

                        if(! $DATA ) adminmsgbox($LANG['shujuno']);

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

                      if( $_GET['mode']  == 'edit'){
                          
                          $DATA = $D ->where( $WHERE)-> find();

                             if(  isset(  $_GET['ajson'])){

                                   if( $_GET['token']   != $_SESSION[$AC]) adminmsgbox( $LANG['token'], '0');

                                   unset( $_SESSION[$AC]);

                                   $LX = (int) isset( $_GET['lx']) ? $_GET['lx']: 0;

                                   if($LX > 2 || $LX < 0)  adminmsgbox( $LANG['shibai'] , '0');

                                   if( ! $DATA ) adminmsgbox( $LANG['shujuno'],'0');
                                    
                                    $fan = $D ->where( $WHERE )-> update( array( 'off' => $LX ));
                                    if( $fan){ 
                                               
                                               adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> array( 'off' => $DATA['off'] ), 'data'=> array( 'off' => $LX ) )));
                                        
                                               adminmsgbox( $LANG['chenggong'] , '1');
                                    }else      adminmsgbox( $LANG['shibai'] , '0');
                             
                             
                             
                             }


                        }





                        
                     if( isset( $_POST['submit'])){
                     
                         if( !yztoken( 'token' , $AC.$MO ) ) msgbox( $LANG['token'], '?'.getarray( $_GET));


                        $CANSHU = array();


                        if(isset($_POST['canshu']) ){

                            $YZ = 0;

                            foreach( $_POST['canshu'] as $kk => $vv){

                                if( $vv['name'] == '')continue;

                                $vvname = $vv['name'];
                                unset($vv['name']);
                                if (count($vv) < 1 )continue;

                                
                                $CANSHU['shuju'][$YZ]['name'] = $vvname;

                                $YX = 0;

                                foreach($vv as $ttt){

                                    if(!isset($ttt['canshu']) || $ttt['canshu'] == '') continue;

                                  

                                    if(isset($ttt['miaosu'])) $ttt['miaosu'] = trim( $ttt['miaosu'] );
                                    if(isset($ttt['tupian'])) $ttt['tupian'] = trim( $ttt['tupian'] );

  

                                    $ttt['canshu'] = trim( $ttt['canshu'] );
                                    $CANSHU['shuju'][$YZ][$YX] =$ttt;
                                    $YX++;
                                
                                
                                }

                                $lz = count($CANSHU['shuju'][$YZ]);
                                if($lz < 2 )unset( $CANSHU['shuju'][$YZ] );
                            
                            

                            $YZ++;
                            }


                            if(isset($_POST['jiagcan']) ){


                               foreach($_POST['jiagcan'] as $k => $v){


                                $_POST['jiagcan'][ str_replace(' ','',$k)] = (float)$v;
                            
                              }
                            
                               $CANSHU['jiage'] = $_POST['jiagcan'];

                            }

                        }


                        

                     


                        $_POST['canshu'] = serialize($CANSHU);



                          


                          if( isset( $_POST['tupianji'])) $_POST['tupianji'] = serialize($_POST['tupianji']);
                          else $_POST['tupianji'] = '';

                          $_POST['xtime'] = time();
                          $_POST['adminid'] = $USER['id'];

                            if(isset($_POST['kuozan'])){

                                    foreach($_POST['kuozan'] as $k => $v){

                                         if( !is_array( $v ) && $v == $LANG['placeholderyes']) unset(  $_POST['kuozan'][$k] );

                                    }



                                     $_POST['kuozan'] = serialize($_POST['kuozan']);

                            }else $_POST['kuozan'] = '';

                            foreach($array  as $v){

                                if( !isset( $_POST[$v]) ) $_POST[$v] = '';
                            
                            
                            }


                          if( $_GET['mode']  == 'add'){

                                        
                                        $_POST['atime'] =$_POST['xtime'] = time();
                                        $_POST['url'] = scurl( isset( $_POST['url'] ) && $_POST['url'] !='' ? $_POST['url'] : $_POST['name'] , 2 , 1 , $_POST['cid'] );

                                      


                                        $fanhui = $D  -> insert($_POST);

                                        if( $fanhui){ 

                                            chaurl($_POST['url'] ,'1');

                                            unset( $_POST['submit']);

                                            adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));

                                            adminmsgbox( $LANG['add'].$LANG['chenggong'] );
                                         
                                        }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));
                            
                            
                            
                            }else if( $_GET['mode']  == 'edit'){

                                         $_POST['xtime'] = time();
                                         unset( $_POST['atime']);

                                         if( $DATA['url'] != $_POST['url'] || $_POST['url'] == '' ){

                                            chaurl($DATA['url'] ,'2');
                                            
                                            $_POST['url'] = scurl( $_POST['url'] ==''?$_POST['name']:$_POST['url'] ,2 , 1 , $_POST['cid'] );
                                        }
                                        

                                         $fan = $D ->where( $WHERE )-> update( $_POST);

                                         if( $fan){ 

                                                chaurl($_POST['url'] ,'1');
                                  
                                                adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                                                adminmsgbox( $LANG['edit'].$LANG['chenggong']);

                                         }else  adminmsgbox( $LANG['edit'].$LANG['shibai']);
                    
                            }

                     }


                    $_SESSION[$AC.$MO] = token();


                    if( $_GET['mode']  == 'add'){  

                            $shua = explode( ',', $D -> tablejg['0'] );
                            foreach( $shua as $zhi )  $DATA[ $zhi] = '';
                            $DATA['canshu']= array();
                            $DATA['off'] = 2;
                    }else{

                        if( $DATA['canshu'] != '')  $DATA['canshu'] = unserialize( $DATA['canshu'] );

                        if( $DATA['kuozan'] != '')  $DATA['kuozan'] = unserialize( $DATA['kuozan'] );

                    
                    
                    }

                    
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

        <div class="row cl">

            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['canguige'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

                <ul class="gioge">

                <?php if(isset( $DATA['canshu']['shuju'] ) && $DATA['canshu']['shuju']){
                
                 foreach($DATA['canshu']['shuju'] as $dk => $dv){


                     if( $dv['name']!= ''){
                
                ?>

                <li class="canshu<?php echo $dk;?>" data="<?php echo $dk;?>">
                     <input type="text" placeholder="<?php echo $LANG['guigena'];?>" name="canshu[<?php echo $dk;?>][name]" value="<?php echo $dv['name'];?>" class="input-text ccdname" style="width:80%;"><a href="javascript:dadanchu(<?php echo $dk;?>)" style="clear:both;"> <i class="Hui-iconfont" style="color:red;font-size:28px"> </i> </a>


                    
                     
                     <p style="margin-top:10px;"> 

                     <?php unset($dv['name']);

                      $sll = count($dv);
                     
                     if($sll > 0){

                         $zf=0;
                         foreach($dv as $dddc){

                             if( $dk == '0' ){ 
                                 
                                 
                                 
                                 $tazhi = token();
                                 ?>

                             <label class="l<?php echo $dk;?>_<?php echo $zf;?>">
                             
                             <input placeholder="<?php echo $LANG['guigecs'];?>"   type="text" class="input-text ccdcanshu" style="width:15%;" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][canshu]" value="<?php echo isset($dddc['canshu'])?$dddc['canshu']:'';?>"> 
                             
                             <input placeholder="<?php echo $LANG['beizhu']?>" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][miaosu]"  type="text" class="input-text" style="width:15%;"  value="<?php echo isset($dddc['miaosu'])?$dddc['miaosu']:'';?>"> 
                             
                             <input type="text" class="input-text" style="width:50%;"  value="<?php echo isset($dddc['tupian'])?$dddc['tupian']:'' ;?>" id="imgshowac<?php echo $tazhi;?>"  placeholder="<?php echo $LANG['guigetp']?>" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][tupian]" > <input type="button" id="filePicker<?php echo $tazhi;?>"  value="update"  />
                             
                             
                             <script>KindEditor.ready(function(K) {    var uploadbuttonac<?php echo $tazhi;?> = K.uploadbutton({  button : K("#filePicker<?php echo $tazhi;?>")[0], fieldName : "all",  url : "<?php echo $_SERVER['SCRIPT_NAME']."?action=".$_GET['action'];?>&mode=edit&uplx=all",afterUpload : function(data) { if ( data.error === 0) {var url = K.formatUrl(data.url, "absolute");  K("#imgshowac<?php echo $tazhi;?>").val(url);}else{  layer.msg(data.message, { time: 2000 });}}, afterError : function( str ) {layer.msg(str, { time: 2000,  }); }});uploadbuttonac<?php echo $tazhi;?>.fileBox.change(function(e) {uploadbuttonac<?php echo $tazhi;?>.submit();}); });</script>  <a href="javascript:dlanchu(<?php echo $dk;?>,<?php echo $zf;?>)"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a>
                           
                           </label>
                             
                             
                             
                       <?php      }else{
                    ?>

                    <label class="l<?php echo $dk;?>_<?php echo $zf;?>"><input placeholder="<?php echo $LANG['guigecs'];?>" " maxlength="30" type="text" value="<?php echo $dddc['canshu'];?>" class="input-text ccdcanshu" style="width:158px;" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][canshu]"> <a href="javascript:dlanchu(<?php echo $dk;?>,<?php echo $zf;?>)"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a></label>




                     <?php } $zf++;} }?>
                     
                    
                     
                     
                     </p>
                        <div style="clear:both;"></div> <a href="javascript:adanchu(<?php echo $dk;?>)" style="clear:both;"> <i class="Hui-iconfont" style="color:green;">
                        </i>
                        </a>
                        
                      </li>



                <?php  } } }?>



                  
                     

                </ul>
                <div class="zengjicshu">

                    <a href="javascript:daadd()" style="clear:both;"> <i class="Hui-iconfont" style="color:green;font-size:20px
                    ;">&#xe61f;</i> </a>  <input type="text" value="<?php echo $DATA['jiage']?>" class="pljiage input-text" style="width:88px;margin-left:168px;">  <a href="javascript:pljiage()" style="clear:both;" class="btn btn-warning radius">  <?php echo $LANG['pilszhi'];?> </a>

                    <?php echo $LANG['xzspmoxin'];?>

                    <select class="xuanzemoxing select" style="width:200px;"><option value=""><?php echo $LANG['allquan'];?></option><?php echo ywselect($D ->zhicha('id,name')->setbiao('chanpingg') ->select(),'','name','id')?>
                              
                    </select>

                </div>

            </div>

        </div>

         <div class="row cl">

            <label class="form-label col-xs-4 col-sm-3"><a href="javascript:zuhejiage();"> <?php echo $LANG['guigejgx'];?>：</a></label>
            <div class="formControls col-xs-8 col-sm-9">

                <div class="jiagecshu">

                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                        <tr class="text-c"> </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


                </div>


            </div>

        </div>

        
         <div class="row cl">

            <label class="form-label col-xs-4 col-sm-3"><?php echo $LANG['yunid'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">

                    <select name="yunid" class="select"><option value="0"><?php echo $LANG['yunfeiid0'];?></option><?php echo ywselect(yunfeiid(),$DATA['yunid'])?></select>

             </div>

        </div>


       



        <?php

            $CID =  isset($_GET['cid']) && $_GET['cid'] >  0 ? $_GET['cid'] : $DATA['cid'];
            $DATAfan  = $D ->setbiao('type') ->where(array('id' => $CID))-> find();

            if( isset( $_GET['ybj']))  $NOUI = 1;
        
            foreach( $LANG['cmschangyo'] as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
        
        ?>

        <?php 

            foreach( $LANG['centerother'] as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }

            if( $DATAfan ){

                
                foreach($array as $kz){

                    if( $DATAfan[$kz] != ''){

                        $wk = $kz;
                        $fancs = explode(',' , $DATAfan[$kz] );
                        

                        $wv = $fancs['0'].'#select#';
                        unset($fancs['0']);

                        foreach($fancs as $k => $v) $cccc[]=$k.','.$v;

                        $wv.= implode( '@' , $cccc);

                       echo houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);

                    }else break;

                }

            }


        ?>

        

        <?php
            $DATAkuozanform = '';
            
            if( $DATAfan ) $DATAkuozanform = $DATAfan['kuozanform'];

            if( $DATAkuozanform != ''){

               $DATAkuozanform = unserialize($DATAkuozanform);

              

                $canshu = explode('#',$LANG['typeother']['kuozanform'] );

                if($canshu['2'] != '' ){

                   $ziduan = explode(',',$canshu['2']);
                   if(count( $ziduan ) == 2){

                       $i = 0;

                       foreach( $DATAkuozanform  as $kmm){

                           if($kmm[$ziduan['0']] == '')continue;

                            $wk =  $kmm[$ziduan['0']].'#'.trim( $kmm[$ziduan['1']] );

                            
                         

                           echo  houtaifenjie( $wk,"kuozan[".$i."]", (isset( $DATA['kuozan'][$i] ) ? $DATA['kuozan'][$i]:'' ) , $LANG['placeholderyes']);

                       
                        $i++;
                       }
                   
                   
                   
                   
                   }

           

                


                }

               
        
        ?>


        <?php } 
        
        // canshu
        // yunid
        
        ?>
    







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

                    
<?php }else{ 

     $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

     $limit = listmit( $CONN['hnum'] ,$PAGE);
     if( isset( $_GET['type'])) $_GET['cid']  = $_GET['type'];

     $_GET['cid']  = (float) isset( $_GET['cid'] ) ?$_GET['cid']:0;

     if( $_GET['cid'] > 0 ){
        
           $shu = xjcid( $_GET['cid']);
         
           $shu[] = $_GET['cid'];
            
           $WHERE['cid IN'] = $shu;
     }

     if( isset( $_GET['fenqu']) && $_GET['fenqu'] !='' ) $WHERE['off'] =  $_GET['fenqu'];

     if( isset( $_GET['guan']) && $_GET['guan'] !='' ){

         $WHERE['id'] = $_GET['guan'];
         $WHERE['name OLK'] = '%'.$_GET['guan'].'%';
         $WHERE['miaoshu OLK'] = '%'.$_GET['guan'].'%';
         $WHERE['guanjian OLK'] = '%'.$_GET['guan'].'%';

     }



     
  


     $ZSHU = $D ->where( $WHERE ) -> total();

     $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

     if( ! $DATA) $DATA = array();

     $_SESSION[$AC] =token(); 

?>
<style>
.td-manage  .Hui-iconfont{font-size:22px;}
</style>
 <nav class="breadcrumb"> <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> <span class="c-gray en">&gt;</span> <?php echo $LANG['adminac'][$_GET['action']];?> <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">

     <div class="text-c"> 

        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />

            <span class="select-box" style="width:108px">
                 <select name="cid" class="select">  <?php echo ywselect($LOG, isset($_GET['cid']) ?$_GET['cid']:'');?> </select> 
            </span>

            <span class="select-box" style="width:108px">
                 <select name="fenqu" class="select">  
                 <option value=""> <?php echo $LANG['allquan']?> </option>
                 <?php echo ywselect($OFF, isset($_GET['fenqu']) ?$_GET['fenqu']:'');?> </select> 
            </span>
          
            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['guanjian'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>

    </div>



<div class="cl pd-5 bg-1 bk-gray mt-20"> 
    <span class="l"> <a href="javascript:;" onclick="product_edit('<?php echo $LANG['add'] ?>','?<?php  echo 'action=',$AC,'&mode=add'.(isset($_GET['cid']) && $_GET['cid']!= ''?'&cid='.$_GET['cid'] :'')?>')"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['add'];?> </a> 
    </span>
    <span class="r"> <?php echo $LANG['gongyou'];?> <strong id="tiaoshu"><?php echo $ZSHU;?></strong>  </span>
</div>

<style type="text/css">
	.shenhec{
		color: red;
		cursor: pointer;
	}
</style>
 
<div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
         <thead>
            <tr class="text-c">

                <th width="100" class="text-c"> ID </th>
                <th class="text-l">姓名</th>
                <th class="text-l" width="150">
                    提现金额
                </th>
                <th class="text-l" width="80">收款方式</th>
                <th class="text-l" width="160">提现账号</th>
                <th class="text-l" width="160">提现方式</th>
                <th class="text-l" width="160">状态</th>
                <th width="200">操作</th>

            </tr>

        </thead>
      <tbody>

<?php 
if( $DATA ){

    foreach( $DATA as $ONG ){ 

?>
<tr class="text-l">
                
                    <td class="text-c"><a href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&ybj=1&id='.$ONG['id'];?>','<?php echo $ONG['id']?>')"><?php echo $ONG['id'];?></a></td>
                    <td> <?php echo $ONG['name'];?></td>


                    <td > <?php echo $ONG['jine'];?></td>
                    <td> <?php echo $ONG['fs'];?></td>

                    <td> <?php echo $ONG['zhanghao'];?></td>
                     <td><?php
                     if ($ONG['type']==1) {
                     	echo '现金提现';
                     }elseif ($ONG['type']==2) {
                     	echo '佣金提现';
                     }

                     ?></td>
                    <td>
                    	<?php 

                    	if ($ONG['off']==0) {
                    		echo '审核中';
                    	}else if ($ONG['off']==-1) {
                    		echo '<span style="color:red">审核失败</span>';
                    	}else if($ONG['off']==1){
                    		echo '<span style="color:green">审核成功</span>';
                    	}

                    	 ?>

                    </td>
                    


                <td class="f-14 td-manage text-c">

                <span class="shenhe shenhec btn btn-success radius" zhi="<?php echo $ONG['id'] ?>">通过</span>

                &nbsp;
                &nbsp;


                <!-- <span class="jujue   btn btn-warning radius" zhi="<?php echo $ONG['id'] ?>">拒绝【返金额】</span> -->



                </td>



</tr>

<?php }} else {?>
     
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



</div>

<div class="page"><?php 
   
    if($ZSHU > $CONN['hnum']){

            $_GET['guan']  = isset( $_GET['guan']) ? $_GET['guan'] :'';
            $_GET['fenqu'] = isset( $_GET['fenqu']) ? $_GET['fenqu'] :'';
            $_GET['cid']   = isset( $_GET['cid']) ? $_GET['cid'] :'';

     
         echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=','&guan='.$_GET['guan'].'&type='.$_GET['cid'].'&fenqu='.$_GET['fenqu'] );
    } 
  
?>
</div>


<?php 

}

include HTPL.'foot.php'; 

$TYPE = array();
$Dd  = db('type');

$DATAS = $Dd ->order('paixu desc,id asc')->where( array( 'leixin' => 1))-> select();

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
<script type="text/javascript">


var  jiagecan = <?php echo json_encode( isset($DATA['canshu']) && isset($DATA['canshu']['jiage']) ? $DATA['canshu']['jiage']: array());?>





function pljiage(){

        $(".jiagege,[name=jiage]").val($(".pljiage").val());

}


function zuhejiage(){

    th = html = '';

    tcs = $(".gioge li").length;

    arraydd = new Array();

    if( tcs > 0){

        for(i = 0; i < tcs ; i++){

            tdeli =$(".gioge li:eq("+i+")");
            th+= '<th>'+tdeli.find(".ccdname").val()+'</th>';

            $ttt = new Array();

            tdeli.find("label .ccdcanshu").each(function(){

                $ttt.push($(this).val());
             
            });


          arraydd.push($ttt);

        }
            th+= '<th width="88"><?php echo $LANG['guigejg'];?></th>';

            strl = 'cartesianProductOf(';
            var ddd =   arraydd.length;


            z= 1;

            for(var kk in arraydd){
            
                if(z == ddd)
                    strl+= 'arraydd['+kk+']';
                 else
                  strl+= 'arraydd['+kk+'],';

                 z++;
            }
            strl+=')';

            $fab = eval(strl);


            for(var i in $fab ){

               
                html+='<tr>';

                $kk =  $fab[i];

                $stst = '';


                 for( var z in $kk){

                     $stst+=$kk[z]+'_';
                 
                  html+= '<td>'+$kk[z]+'</td>'
                 }

                 $jaccige = jiagecan[$stst];
                 if(typeof $jaccige === 'undefined' ) $jaccige = $(".pljiage").val();

                 html+= '<td><input type="text" name="jiagcan['+$stst+']" value="'+($jaccige )+'" class="input-text jiagege" style="width:88px;"/></td>';


                html+='</tr>'; 

           }



        $(".jiagecshu thead tr").html(th);
        $(".jiagecshu tbody").html( html );

    
    }




}



function cartesianProductOf() {

 

    return Array.prototype.reduce.call(arguments ,       function(a, b) {

       
      
    var ret = [];
        a.forEach(function(a) {
        b.forEach(function(b) {
        ret.push(a.concat([b]));
      });
    });
   return ret;
  }, [[]]);
}







function daadd(){

   dacan = suijishu();

   cc = $(".gioge li").length;

   if( cc >= 5){
   layer.msg('<?php echo $LANG['guigeca'];?>');
   return false;
   }



   html = '<li class="canshu'+dacan+'" data="'+dacan+'"><input type="text" placeholder="<?php echo $LANG['guigena'];?>" name="canshu['+dacan+'][name]" value="" class="input-text ccdname"  style="width:80%;" /><a href="javascript:dadanchu('+dacan+')" style="clear:both;"> <i class="Hui-iconfont"  style="color:red;font-size:28px"> &#xe6e2;</i> </a><p style="margin-top:10px;"> </p><div style="clear:both;"></div> <a href="javascript:adanchu('+dacan+')" style="clear:both;"> <i class="Hui-iconfont"  style="color:green;">&#xe600;</i> </a></li>';

   $(".gioge").append(html);


zuhejiage();
}


function dadanchu(id){

    $(".canshu"+id).remove();



zuhejiage();

}

function dlanchu(type , id){

        $(".l"+type+"_"+id).remove();
zuhejiage();
}


function adanchu( id ){

        var tazhi =suijishu();

        tata = $(".gioge li:first").attr('data');


        if( tata != id  ){



            
        html = '<label class="l'+id+'_'+tazhi+'"><input placeholder="<?php echo $LANG['guigecs'];?>" " maxlength="30" type="text" class="input-text ccdcanshu" style="width:158px;" name="canshu['+id+']['+tazhi+'][canshu]"> <a href="javascript:dlanchu('+id+','+tazhi+')"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a></label>';


        
        
        
        }else{

        html = '<label class="l'+id+'_'+tazhi+'"><input placeholder="<?php echo $LANG['guigecs'];?>" "  type="text" class="input-text ccdcanshu" style="width:15%;" name="canshu['+id+']['+tazhi+'][canshu]"> <input placeholder="<?php echo $LANG['beizhu']?>" name="canshu['+id+']['+tazhi+'][miaosu]"  type="text" class="input-text" style="width:15%;"> <input type="text" class="input-text" style="width:50%;"  value="" id="imgshowac'+tazhi+'"  placeholder="<?php echo $LANG['guigetp']?>" name="canshu['+id+']['+tazhi+'][tupian]" > <input type="button" id="filePicker'+tazhi+'"  value="update"  /><script>KindEditor.ready(function(K) {    var uploadbuttonac'+tazhi+' = K.uploadbutton({  button : K("#filePicker'+tazhi+'")[0], fieldName : "all",  url : "<?php echo $_SERVER['SCRIPT_NAME']."?action=".$_GET['action'];?>&mode=edit&uplx=all",afterUpload : function(data) { if ( data.error === 0) {var url = K.formatUrl(data.url, "absolute");  K("#imgshowac'+tazhi+'").val(url);}else{  layer.msg(data.message, { time: 2000 });}}, afterError : function( str ) {layer.msg(str, { time: 2000,  }); }});uploadbuttonac'+tazhi+'.fileBox.change(function(e) {uploadbuttonac'+tazhi+'.submit();}); });<\/script>';


         html+=' <a href="javascript:dlanchu('+id+','+tazhi+')"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a></label>';

        }


        $(".canshu"+id +" p").append(html);

        $(".ccdcanshu").mouseout(function(){

        zuhejiage();
    
    });

zuhejiage();


}


var zNodes = <?php echo json_encode($TYPE)?>;
var newCount = 1;


var setting = {
    view: {
        
        dblClickExpand: false,
        showLine: false,
        selectedMulti: false
    },data: {
        simpleData: {
            enable:true,
            idKey: "id",
            pIdKey: "pId",
            rootPId: ""
        }
    },
    callback: {
        beforeClick:beforeClick 
    }
};


function beforeClick(treeId, treeNode) {


            $("#mmtype").val(treeNode.id);
         
    
    
    return true;
}




var token ='<?php echo $_SESSION[$AC]?>';

function product_edit(title,url){

            var index = layer.open({
                type: 2,
                title: title,
                content: url,
            });

            layer.full(index);
}

function guanli(id,lx,obj){

         $.getJSON('?action=<?php echo $AC;?>&mode=edit&ajson=1&token=' + token + '&id='+id+'&lx='+lx,{},function(data){

                 if(data.token) token = data.token;
                
                 if(data.code == 1){

                    
                     if(lx == 2)       $(obj).html('<i class="Hui-iconfont"  style="color:green;">&#xe6e1;</i>');
                     else if(lx == 1)  $(obj).html('<i class="Hui-iconfont" style="color:#dd514c;">&#xe6e0;</i>');
                     else              $(obj).html('<i class="Hui-iconfont"  style="color:red;">&#xe631;</i>');
                     
                     layer.msg(  data.msg ,{ icon: 1 ,time : 1000});
                
                 }else layer.msg( data.msg ,{ icon: 2 ,time : 1000});

           });
}


function admin_gengai( obj,id){

              layer.confirm( '<?php echo $LANG['genggaioff'];?>' ,{ title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($OFF);?>
                               , btn1: function(index, layero){

                                                guanli(id,0,obj);

                               },btn2: function(index, layero){

                                                guanli(id,1,obj);

                               },btn3: function(index, layero){

                                                guanli(id,2,obj);
                               }
               });
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




$(function(){


   $(".xuanzemoxing").change(function(){


        id = $(this).val();

        if(id > 0){


            $.getJSON("<?php echo $CONN['dir']?>api.php?action=moxing&id=" + id ,function( FANHUI ){

                if( FANHUI.code == 1){


                    $(".gioge").html( FANHUI.data );

                    zuhejiage();

                
                
                
                }



           });

        }



         


      /// alert($(this).val() );
   
   
   });

$("#form-admin-role-add" ).Validform( { tiptype:2 }); 

   var t = $("#tree");

     if(t.length){
    t = $.fn.zTree.init(t, setting, zNodes);

    
    var zTree = $.fn.zTree.getZTreeObj("tree");

    <?php if( (isset($DATA['cid'] ) && $DATA['cid'] > 0) || ( isset($_GET['cid'] ) && $_GET['cid'] > 0)) {

        if(( isset($_GET['cid'] ) && $_GET['cid'] > 0))$DATA['cid'] = $_GET['cid'];

           echo  'zTree.selectNode(zTree.getNodeByParam("id", '.$DATA['cid'].'));$("#mmtype").val('.$DATA['cid'].');';
    }
    
    ?>


    }


    $(".ccdcanshu").mouseout(function(){

        zuhejiage();
    
    });

    zuhejiage();

        
});



</script>


<script type="text/javascript">
jQuery(function(){
    jQuery(".shenhe").click(function(){
        var zhi = jQuery(this).attr('zhi');
        $.ajax({
            async: true,
            type:"POST",
            url:"?action=ajax",
            data:{action:'tixianshenhe',zhi:zhi},
            dataType:'json',
            success:function(data){
                if (data.o=='yes') {
                    alert('审核成功');
                }
                
            }
        })


    })
});
</script>



</body>
</html>