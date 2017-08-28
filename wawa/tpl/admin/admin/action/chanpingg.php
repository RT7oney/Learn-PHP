<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db( 'chanpingg' );
ini_set('memory_limit', '256M');
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
</style>
<nav class="breadcrumb">

    <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> 
    <span class="c-gray en">&gt;</span>  <?php echo $LANG['adminac'][$_GET['action']];?>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" > <i class="Hui-iconfont"> &#xe68f; </i> </a> 

</nav>


<?php if( isset( $_GET['mode'])){


         $ID = (float) ( isset( $_GET['id'])? $_GET['id']:0);


        if( $_GET['mode'] == 'del'){

            if(!yztoken('token',$AC)) msgbox( $LANG['token'], '0');
           

            $WHERE['id']  =  $ID;

            $DATA = $D ->where( $WHERE )-> find();

            if(! $DATA ) adminmsgbox($LANG['shujuno']);

            $DATAS = $D ->where($WHERE) -> delete();

            if( $DATAS){

                 adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA  )));

                 msgbox( $LANG['yishanchu'] , '1');

            }else msgbox( $LANG['shanchusb'] , '0');




        }else if( $_GET['mode'] == 'add'  || $_GET['mode'] == 'edit'){

            $WHERE['id'] = $ID ;

            $DATA = array();

            if( $_GET['mode']  == 'edit'){

                $DATA = $D ->where( $WHERE)-> find();
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
                $_POST['adminid'] = $USER['id'];

                if( $_GET['mode']  == 'add'){

                                        
                        $_POST['atime']  = time();
                        $_POST['ip'] = ip();
                        $_POST['adminid'] = $USER['id'];


                        $fanhui = $D  -> insert($_POST);

                        if( $fanhui){ 

                            adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));
                            adminmsgbox( $LANG['add'].$LANG['chenggong'] );

                        }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));
                }else{


                    $fan = $D ->where( $WHERE )-> update( $_POST);

                    if( $fan){ 

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
        }else{

            if( $DATA['canshu'] != '')  $DATA['canshu'] = unserialize( $DATA['canshu'] );



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


        <?php
            $ttt = array( 'uid' => $LANG['uid'],
            'shid' => $LANG['shid'],
            
            
        
        );
            foreach( $ttt as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
        ?>


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
                             
                             <input type="text" class="input-text" style="width:50%;"  value="<?php echo isset($dddc['tupian'])?$dddc['tupian']:'' ;?>" id="imgshowac<?php echo $tazhi;?>"  placeholder="<?php echo $LANG['guigetp']?>" name="canshu[<?php echo $dk;?>][<?php echo $zf;?>][tupian]" > 
                             <input type="button" id="filePicker<?php echo $tazhi;?>"  value="update"  />
                             
                             
                             <script>KindEditor.ready(function(K) {    var uploadbuttonac<?php echo $tazhi;?> = K.uploadbutton({  button : K("#filePicker<?php echo $tazhi;?>")[0], fieldName : "all",  url : "<?php echo $_SERVER['SCRIPT_NAME']."?action=".$_GET['action'];?>&mode=edit&uplx=all",afterUpload : function(data) { if ( data.error === 0) {var url = K.formatUrl(data.url, "absolute");  K("#imgshowac<?php echo $tazhi;?>").val(url);}else{  layer.msg(data.message, { time: 2000 });}}, afterError : function( str ) {layer.msg(str, { time: 2000,  }); }});uploadbuttonac<?php echo $tazhi;?>.fileBox.change(function(e) {uploadbuttonac<?php echo $tazhi;?>.submit();}); });</script>


                           <a href="javascript:dlanchu(<?php echo $dk;?>,<?php echo $zf;?>)"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a>
                           
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
                    ;">&#xe61f;</i> </a>  <input type="text" value="" class="pljiage input-text" style="width:88px;margin-left:168px;">  <a href="javascript:pljiage()" style="clear:both;" class="btn btn-warning radius">  <?php echo $LANG['pilszhi'];?> </a>

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


        <?php if( $MO == 'edit' ){?>

        <div class="row cl">

            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['atime'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="yddddd"> <?php echo date( 'Y-m-d H:i:s',$DATA['atime']);?> </span>
            </div> 

        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> IP：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="yddddd"> <?php echo $DATA['ip'];?> </span>
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
   <?php  }?>
 
<?php }else{ 


    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);


    if( isset( $_GET['uid']) && $_GET['uid'] != '' ) $WHERE['uid'] = $_GET['uid'];
    if( isset( $_GET['shid']) && $_GET['shid'] != '' ) $WHERE['shid'] = $_GET['shid'];
    if( isset( $_GET['guan']) && $_GET['guan'] != '' ){
        
        
        $WHERE['name LIKE'] =  '%'. $_GET['guan'].'%';
        $WHERE['canshu OLK'] =  '%'. $_GET['guan'].'%';


    }



    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

    $_SESSION[$AC] = token();

    if(! $DATA) $DATA = array();

?>


<div class="page-container">





 <div class="text-c"> 

        <form method="get">

            <input type="hidden" value="<?php echo $AC;?>" name="action" />


            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['uid'];?>"  name="guan" value="<?php echo isset( $_GET['uid']) ? $_GET['uid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['shid'];?>"  name="guan" value="<?php echo isset( $_GET['shid']) ? $_GET['shid'] : '';?>">

           
          
            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['guanjian'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>

    </div>



<div class="cl pd-5 bg-1 bk-gray mt-20"> 
    <span class="l"> <a href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=add'?>')"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['add'];?> </a> 
    </span>
    <span class="r"> <?php echo $LANG['gongyou'];?> <strong id="tiaoshu"><?php echo $ZSHU;?></strong>  </span>
</div>




  <div class="mt-20">



    <table class="table table-border table-bordered table-hover table-bg table-sort">

        <thead>

            <tr class="text-c">
                <th width="130"> ID </th>
                <th width="300"> <?php echo $LANG['name'];?> </th>
        
                <th > <?php echo $LANG['atime'];?> </th>
                <th > <?php echo $LANG['caozuo'];?> </th>

            </tr>

        </thead>

     <tbody>


            
            <?php if( $DATA){
              
                      foreach( $DATA as $ONG){ ?>

                              <tr class="text-c">
                                    <td><?php echo $ONG['id']?></td>
                                    <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /></td>
                              
                              
                             

                              <td> <?php echo $ONG['atime'] > 0? ' <span style="color:blue;">'.date('Y-m-d H:i:s',$ONG['atime']).'</span> ':'No Time' ;?></td>

                                  

                                   


                            <td>
                                <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>','<?php echo $ONG['id']?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont" style="font-size:24px;color:green;">&#xe6df;</i></a>

                                <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont" style="font-size:24px;color:red;">&#xe6e2;</i> </a>


                                    </td>

                               </tr>

                     

            <?php     
                    } 
                 }else{
            ?>
                <tr class="text-c">
                    <td colspan="8">  <span class="label label-warning radius"><?php echo $LANG['noshuju'];?></span>  </td>
                </tr>

            <?php } ?>


         </tbody>

      </table>

   </div>

</div>


<div class="page">

   <?php   if( $ZSHU > $CONN['hnum'] ){
                     if(!isset( $_GET['fenqu'])) $_GET['fenqu'] = '';
                     if(!isset( $_GET['uid'])) $_GET['uid'] = '';
                     if(!isset( $_GET['shid'])) $_GET['shid'] = '';
                    if(!isset( $_GET['guan'])) $_GET['guan'] = '';

                     

                        echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=', '&fenqu='.$_GET['fenqu'],
                        '&uid='.$_GET['uid'],
                        '&shid='.$_GET['shid'],
                        '&guan='.$_GET['guan']

                        ); 
            }
   ?>

</div>



<?php   } 
include HTPL.'foot.php';?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript">

var token ='<?php echo $_SESSION[$AC]?>';


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

   if( cc >= 3){
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



function product_edit(title,url){

            var index = layer.open({
                type: 2,
                title: title,
                content: url,
            });

            layer.full(index);
}


function admin_del( obj, id){

        layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+id,{},function(data){

                  if(data.token){  token = data.token; $("input[name='token']").val(token); }
              
                  if(data.code == 1){

                       $(obj).parents("tr").remove();

                       layer.msg('<?php echo $LANG['yishanchu'];?>',{icon:1,time:1000});

                  }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});

              });

        });
}


$(function(){



zuhejiage();

});

</script>
</body>
</html>