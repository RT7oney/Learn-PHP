<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('center');
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


 
<div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
         <thead>
            <tr class="text-c">

                <th width="100" class="text-c"> ID </th>
                <th class="text-l">   <?php echo $LANG['name'];?> </th>
                <th class="text-l" width="150"> <?php echo $LANG['cid'];?> </th>
                <th class="text-l" width="80"> <?php echo $LANG['renqi'];?> </th>
                <th width="100"> <?php echo $LANG['off'];?> </th>

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


                    <td > <?php echo $LOG[$ONG['cid']];?></td>
                    <td> <?php echo $ONG['renqi'];?></td>
                    


                <td class="f-14 td-manage text-c">

                <?php if( $ONG['off'] == 2 ){ ?>
                 <a href="javascript:;" onclick="admin_gengai(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none" title="<?php echo $OFF[$ONG['off']];?>" ><i class="Hui-iconfont"  style="color:green;">&#xe6e1;</i> </a>

                <?php }else if( $ONG['off'] == 1 ){ ?>

                 <a href="javascript:;" onclick="admin_gengai(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none" title="<?php echo $OFF[$ONG['off']];?>"><i class="Hui-iconfont" style="color:#dd514c;">&#xe6e0;</i> </a>

                <?php }else{ ?>

                 <a href="javascript:;" onclick="admin_gengai(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none" title="<?php echo $OFF[$ONG['off']];?>"><i class="Hui-iconfont"  style="color:red;">&#xe631;</i></a>

                <?php } ?>
     


                <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>','<?php echo $ONG['id']?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> 
                
                <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont" style="color:green;">&#xe6e2;</i>
                    
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

</body>
</html>