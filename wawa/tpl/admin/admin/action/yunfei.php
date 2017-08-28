<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D       = db( 'yunfei' );
$YUNFS   = logac( 'yunfs' );
$yunoff  = logac( 'yunoff' );
$yuntype = logac( 'yuntype' );
$yunfs   = logac('yunfs' );

$J = db('chengshi');

$CHENZU = array();

$CS = $J -> zhicha( 'diqu,name' )->where( array( 'shangji' => 0 ) ) -> select();

if(! $CS ) $CS = array();

foreach($CS as $j => $kk ){

    $CHENZU[$kk['diqu']] = $kk['name'];

    $woqu = $J -> zhicha( 'diqu,name' ) -> where( array( 'shangji' => $kk['diqu'] ) ) -> select();

    if( ! $woqu ) $woqu = array();
    foreach($woqu as $zkk){

        $CS[$j]['zisju'][$zkk['diqu']] = $zkk['name'];

        $CHENZU[$zkk['diqu']] = $zkk['name'];
    
    }


}

 $CHENZU[0] = $CONN['chengshi'];

function diquname(  $TTZ ){

    global $CHENZU;
    $szi =array();

    if($TTZ != ''){

        $TTZS = explode( ',' , $TTZ);
        //p($CHENZU);
        foreach($TTZS as $v ) $szi[] = $CHENZU[$v];

    }

    return implode(' , ',$szi);

}


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


        if( $_GET['mode'] == 'del'){

            if( isset( $_GET['token'])) $_POST['token'] = $_GET['token'];

            if(!yztoken('token',$AC)) msgbox( $LANG['token'], '0');

            $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);

            $WHERE['id']  =  $ID;
            
            $DATA = $D ->where( $WHERE )-> find();

            if(! $DATA ) adminmsgbox( $LANG['shujuno'] );

            $DATAS = $D ->where($WHERE) -> delete();

            if( $DATAS){
                yunfeiid($ID,2);
                yunfeiid(0,2);

                     adminlog($USER['id'], 4 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA  )));

                     msgbox( $LANG['yishanchu'] , '1');
               
            }else msgbox( $LANG['shanchusb'] , '0');


        }else if( $_GET['mode'] == 'add'  || $_GET['mode'] == 'edit'){

            $DATA = array();
            $ID = (int) ( isset( $_GET['id'])? $_GET['id']:0);
 
            $WHERE['id'] = $ID ;

            if($ID > 0)$DATA = $D -> where( $WHERE ) -> find();

            if( isset( $_POST['submit'])){

                if( !yztoken( 'token' , $AC.$MO ) ) msgbox( $LANG['token'], '?'.getarray( $_GET));

                $ZUU = array();
                $CZTYPE = array();
                if( $_POST['cunzai'] ){

                    foreach($yunfs as $k => $v ){


                        if(!isset($_POST['cunzai'][$k]['ding'])) unset($_POST['cunzai'][$k]);
                        else{

                            unset($_POST['cunzai'][$k]['ding']);

                            $ZUU[$k]['ding'] = $k;

                            $CZTYPE[$k] = $k;

                            $z = 0;

                            foreach($_POST['cunzai'][$k] as $zhizhi){

                                if( isset( $zhizhi['diqu'] ) && $zhizhi['diqu'] == '' ) continue;

                                $zhizhi['diqu'] = trim($zhizhi['diqu'],',');
                                $zhizhi['jian'] = (float)trim($zhizhi['jian']);
                                $zhizhi['fei'] = (float)trim($zhizhi['fei']);
                                $zhizhi['jia'] = (float)trim($zhizhi['jia']);
                                if( $zhizhi['jia'] < 1)  $zhizhi['jia']  = 1;
                                if( $zhizhi['jian'] < 1) $zhizhi['jian'] = 1;

                                $zhizhi['zeng'] = (float)trim($zhizhi['zeng']);
                                $ZUU[$k][$z] = $zhizhi;
                                $z++;
                            }
                        }
                    }

                    unset($_POST['cunzai']);
                }



                if( $_POST['off'] == '1') $ZUU =array();

                $_POST['data'] = serialize( $ZUU );

                $BAO = array();

                if( $_POST['baoyou'] ){

                    if(!isset($_POST['baoyou']['ding'])) unset($_POST['baoyou']);
                     else{


                            unset($_POST['baoyou']['ding']);

                            $z = 0;
                            $BAO['ding'] = 'ok';

                            foreach($_POST['baoyou'] as $zhizhi ){

                              //  p( $zhizhi['diqu'] );

                                if(! isset( $zhizhi['diqu'] )  ) continue;

                                if( $zhizhi['diqu']  == '' )  $zhizhi['diqu']  = 0;

                                $zhizhi['diqu'] = trim($zhizhi['diqu'],',');
                                $zhizhi['jian'] = (float)trim($zhizhi['jian']);
                                $zhizhi['mian'] = (float)trim($zhizhi['mian']);
                                $zhizhi['type'] = (float)trim($zhizhi['type']);
                                if( $zhizhi['jian'] == '0' &&  $zhizhi['mian'] == '0' )continue;
                                if( !isset($CZTYPE[$zhizhi['type']]))continue;


                                $BAO[$z] = $zhizhi;
                                $z++;
                            
                            
                            }

                            if(count($BAO) < 2 )$BAO = array();



                        
                        
                     }

                
                    unset($_POST['baoyou']);
                
                }

               // exit();

                if( $_POST['off'] == '1') $BAO =array();

                $_POST['baodata'] = serialize( $BAO );



               

                if( $_GET['mode']  == 'add'){

                    $_POST['atime'] =$_POST['xtime'] = time();
                    $_POST['ip'] = ip();

                    $fanhui = $D  -> insert($_POST);

                    if( $fanhui){ 

                        yunfeiid(0,1);

                        unset( $_POST['submit']);
                        adminlog($USER['id'], 5 , serialize( array( 'ac' => $AC , 'mo' => $MO ,'id'=> $fanhui ,'data'=> $_POST  )));
                        adminmsgbox( $LANG['add'].$LANG['chenggong'] );

                    }else msgbox( $LANG['add'].$LANG['shibai'], '?'.getarray( $_GET));
                
                
                }else{

                    $_POST['xtime'] = time();

                    unset( $_POST['atime']);

                    $fan = $D ->where( $WHERE )-> update( $_POST);

                    if( $fan){ 

                        yunfeiid($ID,1);
                        yunfeiid(0,1);
                

                        adminlog($USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                        adminmsgbox( $LANG['edit'].$LANG['chenggong'] );

                    }else  adminmsgbox( $LANG['edit'].$LANG['shibai'] );

                }

            }


            $_SESSION[$AC.$MO] = token();


            if( $_GET['mode']  == 'add'){  

                            $shua = explode( ',', $D -> tablejg['0'] );
                            foreach( $shua as $zhi )  $DATA[ $zhi] = '';
                            $DATA['data']    = array();
                            $DATA['baodata'] = array();

            }else{

                $DATA['data']    = unserialize( $DATA['data']);
                $DATA['baodata'] = unserialize( $DATA['baodata']);

            }

        ?>
<style>
.yddddd{margin-top:3px;display:block;}

.kuangli{border:1px solid #ccc;padding:10px;margin:10px 0px 10px 0px;display:none;}
.tbl-except{margin-bottom:10px;}
.tbl-except .input-text{width:80px;}
.tbl-except table{display:none;}
a.J_AddRule{margin-top:20px;color:green;}
.J_EditArea{color:blue;}
.J_DeleteRule{color:red;}
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

            $YUNFEI = array( 'fatime' => $LANG['fatime'].'#select#'.logacto('yuntime') ,
                                'off' => $LANG['yunoff'].'#select#'.logacto('yunoff') ,
                               'type' => $LANG['yuntype'].'#select#'.logacto('yuntype') ,
                                'uid' => $LANG['uid'],
                               'shid' => $LANG['shid']
          
            );


            $danwei = $yuntype[(int)$DATA['type']];


           
        
            foreach( $YUNFEI as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
        ?>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['yfdata'];?>：</label>
            <div class="formControls col-xs-8 col-sm-9 postage-tpl" >
                    <?php foreach($yunfs as $k => $v ){ ?>

                    <ul class="lingxi<?php echo $k;?>" data="<?php echo $k;?>">

                        <li> <input type="checkbox" name="cunzai[<?php echo $k;?>][ding]" class="dadingxuanxi" value="<?php echo $k;?>" <?php echo isset($DATA['data'][$k]['ding'])?' checked="checked"' : '';?>> <?php echo $v;?> </li>

                        <li class="kuangli" <?php echo isset($DATA['data'][$k]['ding'])?' style="display:block;"' : '';?>> 

                            <div class="default J_DefaultSet">

                                <input type="hidden"   name="cunzai[<?php echo $k;?>][0][diqu]"  value="0" >
                                <?php echo $LANG['mofei'];?>：<input type="text" name="cunzai[<?php echo $k;?>][0][jian]" value="<?php echo isset($DATA['data'][$k]['0'])?$DATA['data'][$k]['0']['jian']:1;?>" class="input-text " style="width:100px;" autocomplete="off" maxlength="6"> 
                                <b class="dddwww"><?php echo $danwei;?></b><?php echo $LANG['mofei1'];?>
                                <input type="text"  name="cunzai[<?php echo $k;?>][0][fei]" value="<?php echo isset($DATA['data'][$k]['0'])?$DATA['data'][$k]['0']['fei']:0;?>" class="input-text " style="width:100px;" autocomplete="off" maxlength="6"> 
                                <?php echo $LANG['mofei2'];?> <input type="text" name="cunzai[<?php echo $k;?>][0][jia]"  value="<?php echo isset($DATA['data'][$k]['0'])?$DATA['data'][$k]['0']['jia']:1;?>" class="input-text " style="width:100px;" autocomplete="off" maxlength="6"> <b class="dddwww"><?php echo $danwei;?></b><?php echo $LANG['mofei3'];?>
                                <input type="text" name="cunzai[<?php echo $k;?>][0][zeng]" value="<?php echo isset($DATA['data'][$k]['0'])?$DATA['data'][$k]['0']['zeng']:0;?>" style="width:100px;" class="input-text " autocomplete="off" maxlength="6"> <?php echo $LANG['mofei4'];?>

                            </div>

                            <?php
                                if( isset($DATA['data'][$k][0] )) unset( $DATA['data'][$k][0] );
                                if( isset($DATA['data'][$k]['ding']  ))  unset( $DATA['data'][$k]['ding'] );
                            
                                $sl = isset($DATA['data'][$k]) ? count($DATA['data'][$k]):0;
                                $i = 1;
                            ?>
                            <div class="tbl-except">
                                <table border="0" cellpadding="0" cellspacing="0" class="table table-border table-bordered table-hover table-bg table-sort" style="margin-top:8px;<?php echo $sl > 0 ?' display:table;':'';?>">
                                    <thead>
                                    <tr>
                                    <th width="500"><?php echo $LANG['fsdao'];?></th>
                                    <th><?php echo $LANG['shou'];?><b class="dddwww"><?php echo $danwei;?></b></th>
                                    <th> <?php echo $LANG['shoufei'];?></th>
                                    <th><?php echo $LANG['xu'];?><b class="dddwww"><?php echo $danwei;?></b></th>
                                    <th><?php echo $LANG['xufei'];?></th>
                                    <th><?php echo $LANG['caozuo'];?></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php 
                                    if( !isset($DATA['data'][$k])) $DATA['data'][$k] = array();

                                    foreach($DATA['data'][$k] as $tzhi){ ?>

                                    <tr class="z<?php echo $k.'_'.$i;?>t">
                                    <td class="cell-area">
                                    <a href="javascript:xuanzediqu('<?php echo $k.'_'.$i;?>');" class="acc_popup edit J_EditArea" data-acc="event:enter" area-controls="J_DialogArea" area-haspopup="true" ><?php echo $LANG['edit'];?></a>
                                    <div class="area-group">
                                        <p id="z<?php echo $k.'_'.$i;?>n"><?php echo diquname( $tzhi['diqu'] );?></p>
                                    </div>

                                    <input type="hidden" id="z<?php echo $k.'_'.$i;?>i"  name="cunzai[<?php echo $k;?>][<?php echo $i;?>][diqu]"  value="<?php echo $tzhi['diqu'];?>" >

                                   
                                    </td>
                                    <td>
                                          <input type="text" name="cunzai[<?php echo $k;?>][<?php echo $i;?>][jian]"  value="<?php echo $tzhi['jian'];?>" class="input-text " autocomplete="off" maxlength="6" ">
                                    </td>
                                    <td>
                                           <input type="text" name="cunzai[<?php echo $k;?>][<?php echo $i;?>][fei]"  value="<?php echo $tzhi['fei'];?>" class="input-text " autocomplete="off" maxlength="6">
                                    </td>
                                    <td><input type="text" name="cunzai[<?php echo $k;?>][<?php echo $i;?>][jia]" value="<?php echo $tzhi['jia'];?>" class="input-text " autocomplete="off" maxlength="6">
                                    </td>
                                    <td>
                                    
                                    <input type="text" name="cunzai[<?php echo $k;?>][<?php echo $i;?>][zeng]" value="<?php echo $tzhi['zeng'];?>" class="input-text " autocomplete="off" maxlength="6" >
                                    
                                    </td>
                                    <td><a href="javascript:delccc(<?php echo $k;?>,<?php echo $i;?>);" class="J_DeleteRule"><?php echo $LANG['del'];?></a></td>

                                    </tr>

                                    <?php $i++; } ?>
                                </tbody>
                                </table>
                             </div>

                             <div class="tbl-attach">  
                                    <div class="J_SpecialMessage"></div>
                                    <a href="javascript:addccc(<?php echo $k;?>);" class="J_AddRule" ><?php echo $LANG['diqujia'];?></a>
                            </div>

                        </li>
                    </ul>

                    <?php } ?>
            </div> 
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">  </label>
            <div class="formControls col-xs-8 col-sm-9" id="postage-tpl">

            <?php  $k++; $i = 0; ?>


            <ul class="lingxi<?php echo $k;?>" data="<?php echo $k;?>">

                        <li> <input type="checkbox" name="baoyou[ding]" class="dadingxuanxi" value="<?php echo $k;?>" <?php echo isset($DATA['baodata']['ding'])?' checked="checked"' : '';?>> <i class="Hui-iconfont " style="color:Red;font-size:18px;">&#xe6c1;</i> <?php echo $LANG['baoyoun'];?>  </li>

                        <li class="kuangli" <?php echo isset($DATA['baodata']['ding'])?' style="display:block;"' : '';?>> 

                        <?php 
                               unset($DATA['baodata']['ding']);
                               $sl = isset($DATA['baodata']) ? count($DATA['baodata']):0;
                        
                        
                        ?>


                        <div class="tbl-except">
                                <table border="0" cellpadding="0" cellspacing="0" class="table table-border table-bordered table-hover table-bg table-sort" style="margin-top:8px;<?php echo $sl > 0 ?' display:table;':'';?>">
                                    <thead>
                                    <tr>
                                    <th width="500"><?php echo $LANG['fsdaobao'];?> </th>
                                    
                                    <th> <?php echo $LANG['xzkuaidi'];?></th>
                                    <th><?php echo $LANG['mainn'];?> <b class="dddwww"><?php echo $danwei;?></b> <?php echo $LANG['baoyou'];?></th>
                                    <th>  <?php echo $LANG['jine'].$LANG['mainn'].$LANG['baoyou'];?></th>
                                    <th><?php echo $LANG['caozuo'];?></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php 
                                    if( !isset($DATA['baodata'])) $DATA['baodata'] = array();



                                    foreach($DATA['baodata'] as $tzhi){ ?>

                                    <tr class="z<?php echo $k.'_'.$i;?>t">
                                    <td class="cell-area">
                                    <a href="javascript:xuanzediqu('<?php echo $k.'_'.$i;?>');" class="acc_popup edit J_EditArea" data-acc="event:enter" area-controls="J_DialogArea" area-haspopup="true" ><?php echo $LANG['edit'];?></a>
                                    <div class="area-group">
                                        <p id="z<?php echo $k.'_'.$i;?>n"><?php echo diquname( $tzhi['diqu'] );?></p>
                                    </div>

                                    <input type="hidden" id="z<?php echo $k.'_'.$i;?>i"  name="baoyou[<?php echo $i;?>][diqu]"  value="<?php echo $tzhi['diqu'];?>" >

                                   
                                    </td>
                                   

                                    <td>

                                    <select name="baoyou[<?php echo $i;?>][type]">

                                        <?php echo ywselect($yunfs,$tzhi['type']);?>

                                    </select>
                                          
                                    </td>

                                    <td><input type="text" name="baoyou[<?php echo $i;?>][jian]" value="<?php echo $tzhi['jian'];?>" class="input-text " autocomplete="off" maxlength="6">
                                    </td>

                                    <td>
                                    
                                    <input type="text" name="baoyou[<?php echo $i;?>][mian]" value="<?php echo $tzhi['mian'];?>" class="input-text " autocomplete="off" maxlength="6" >
                                    
                                    </td>

                                    <td><a href="javascript:delccc(<?php echo $k;?>,<?php echo $i;?>);" class="J_DeleteRule"><?php echo $LANG['del'];?></a></td>

                                    </tr>

                                    <?php $i++; } ?>
                                </tbody>
                                </table>
                             </div>

                             <div class="tbl-attach">  
                                    <div class="J_SpecialMessage"></div>
                                    <a href="javascript:addccc(<?php echo $k;?>,2);" class="J_AddRule" ><?php echo $LANG['diqubao'];?></a>
                            </div>


                        </li>
            </ul>

            </div> 
        </div>



        



        <?php if( $MO == 'edit'){ ?>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> IP：</label>
            <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['ip'];?> </span>
            </div> 
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['atime']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo date( 'Y-m-d H:i:s',$DATA['atime']);?> </span>
            </div> 
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"> <?php echo $LANG['xtime']?>：</label>
            <div class="formControls col-xs-8 col-sm-9">
                    <span class="yddddd"> <?php echo date( 'Y-m-d H:i:s',$DATA['xtime']);?> </span>
            </div> 
        </div>

        <?php } ?>

        


        <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG[ $_GET['mode'] ];?>&nbsp;&nbsp;">
                </div>
        </div>

    </form>
</article>

<style>
.chengshid{padding:20px 38px; cursor:pointer;display:none;}
.chengshid li{ float:left; width:178px;position:relative;}
.chengshid li .xshu{height:auto; float:left; position:absolute;display:none;width:268px;background:#fff;z-index:3;padding:10px;left:-20px;

border:1px solid #ccc; 
top:-20px;
}
.numl{color:Red;float:right;margin-right:20px;}
.chengshid li .xshu dl{}
.chengshid li .xshu dl dd{float:left;margin-right:5px;}
.anniu{margin-top:20px;}
</style>
<input type="hidden" id="zengchli" value="" />
<div class="chengshid">
    <ul> <?php foreach($CS as $zhi){?>
        <li>
            <input type="checkbox" value="<?php echo $zhi['diqu'];?>"  id="J_Province_<?php echo $zhi['diqu'];?>" class="J_Province">
            <label for="J_Province_<?php echo $zhi['diqu'];?>" class="text-overflow"><?php echo $zhi['name'];?></label>
            <?php if( isset( $zhi['zisju'])) {?>
            <b class="numl">(0)</b>
            <div class="xshu" >
                <dl>
                    <?php foreach($zhi['zisju'] as $ogk => $ogv ){?><dd><input type="checkbox" value="<?php echo $ogk;?>" id="J_Provincez_<?php echo $ogk;?>" class="J_Provincez"><label for="J_Provincez_<?php echo $ogk;?>"><?php echo $ogv;?></label></dd><?php } ?>
                    <dd  class="cl"><a href="javascript:$('.xshu').hide();" style="color:Red;"><?php echo $LANG['guanbi'];?></a></dd>
                </dl>
            </div>
        <?php } ?>
       </li> 
     <?php }?>
    </ul>
    <div class="cl"></div>
    <div class="anniu"> <input type="submit" value="<?php echo $LANG['quediqu'];?>" class="btn btn-primary radius" onclick="xuandiqu(); " ></div>

</div>

   <?php } ?>
 
<?php }else{ 


    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);

    $ZSHU = $D ->where( $WHERE ) -> total();

    $DATA = $D ->order( 'id desc' )->where( $WHERE )-> limit( $limit )-> select();

    $_SESSION[$AC] = token();

    if(! $DATA) $DATA = array();

?>


<div class="page-container">


<div class="cl pd-5 bg-1 bk-gray mt-20"> 
    <span class="l"> <a href="javascript:;" onclick="product_edit('<?php echo $LANG['add'] ?>','?<?php  echo 'action=',$AC,'&mode=add';?>');"  class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> <?php echo $LANG['add'];?> </a> 
    </span>
    <span class="r"> <?php echo $LANG['gongyou'];?> <strong id="tiaoshu"><?php echo $ZSHU;?></strong>  </span>
</div>




  <div class="mt-20">

    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
            <tr class="text-c">
                <th width="130"> ID </th>
                <th width="300"> <?php echo $LANG['name'];?> </th>
                <th> <?php echo $LANG['uid'];?> </th>
                <th> <?php echo $LANG['shid'];?> </th>
                <th> <?php echo $LANG['yunoff'];?> </th>
                <th> <?php echo $LANG['yuntype'];?> </th>
                <th> <?php echo $LANG['atime'];?> </th>
                <th> <?php echo $LANG['caozuo'];?> </th>
            </tr>
        </thead>
        <tbody>

        <?php if( $DATA){
              
            foreach( $DATA as $ONG){ ?>
            <tr class="text-c">
                <td><?php echo $ONG['id']?></td>
                <td> <input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['name']?>"  /> </td>

                <td><?php echo $ONG['uid']?></td>
                <td><?php echo $ONG['shid']?></td>

                <td> <?php echo $yunoff[$ONG['off']]?> </td>
                <td> <?php echo $yuntype[$ONG['type']]?> </td>
                <td> <?php echo $ONG['atime'] > 0? ' <span style="color:blue;">'.date('Y-m-d H:i:s',$ONG['atime']).'</span> ':'No Time' ;?></td>

                <td>  
                    <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>')" class="btn btn-success radius" style="text-decoration:none"><?php echo $LANG['edit'];?></a> 
                    <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,<?php echo $ONG['id']?>)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont" style="font-size:24px;color:red;">&#xe6e2;</i> </a>
                </td>
            </tr>
            <?php } }  ?>
        </tbody>
    </table>
   </div>


</div>


<div class="page">
    <?php   if( $ZSHU > $CONN['hnum'] ){

                if(!isset( $_GET['fenqu'])) $_GET['fenqu'] = '';

                echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=', '&fenqu='.$_GET['fenqu'] ); 
            }
    ?>
</div>



<?php  include HTPL.'foot.php'; } ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript">
var token = '<?php echo $_SESSION[$AC]?>' ;
var CSHI  = <?php echo json_encode($CHENZU) ;?> ;
var DAW   = <?php echo json_encode($yuntype);?> ;
var yunfs = <?php echo json_encode($yunfs);?> ;


function ywselect( yunfs ){

    html = '';

    for(var i in yunfs){

        html+='<option value="'+i+'">'+yunfs[i]+'</option>';
    
    
    }

    return html;


}

function product_edit( title , url){

        var index = layer.open({  type : 2,
                                 title : title,
                               content : url,
        });

        layer.full(index);
}


function admin_del( obj, id){

        layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{  title : '<?php echo $LANG['msgbox'];?>',btn : <?php echo json_encode($LANG['msboxbtn']);?> } , function( index ){
          
                $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+id,{},function(data){

                    if(data.token){  token = data.token; $("input[name='token']").val(token); }
              
                    if(data.code == 1){

                        $(obj).parents("tr").remove();
                        layer.msg('<?php echo $LANG['yishanchu'];?>',{icon:1,time:1000});
                    }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});
                });

        });
}




function xuanzediqu(chuid){

        if( chuid ) $("#zengchli").val( chuid);

        $id = $("#z"+chuid+'i') .val();
        $(".chengshid input").prop("checked",false);
        $(".numl").html('(0)');

        layer.open({  type : 1,
                     title : '<?php echo $LANG['xuandiqu'];?>',
                      area : ['860px', '400px'],
                   content : $(".chengshid"),
        });

        if( $id ){

            $suoyou = $id.split(',');
            for( var i in $suoyou ){
            
                twz = $( "[value="+$suoyou[i]+"]" );
                twz.prop( "checked" , true );
                kk = $(twz).parents( 'dl' );
                num =  kk.find( "input.J_Provincez:checked" ).length;
                znum = kk.find( "input.J_Provincez" ).length;

                if( num == znum ){
                       $(twz).parents('li').find('.J_Province').prop("checked",true);
                }else  $(twz).parents('li').find('.J_Province').prop("checked",false);

                $(twz).parents('li').find('b').html('('+num+')');
            }
        }
}


function addccc(id,$lx){

        $(".lingxi"+id).find('table').show();
        cdu = $(".lingxi"+id).find('tr').length;


        if( $lx == '2'){

        html='<tr class="z'+id+'_'+cdu+'t"><td class="cell-area"><a href="javascript:xuanzediqu(\''+id+'_'+cdu+'\');" class="acc_popup edit J_EditArea" data-acc="event:enter" area-controls="J_DialogArea" area-haspopup="true"><?php echo $LANG['edit'];?></a><div class="area-group"> <p id="z'+id+'_'+cdu+'n"><?php echo $LANG['weidiqu'];?></p> </div><input type="hidden" id="z'+id+'_'+cdu+'i"  name="baoyou['+cdu+'][diqu]"  value="" ></td> <td><select name="baoyou['+cdu+'][type]" >'+(ywselect( yunfs ))+'</select> </td> <td><input type="text" name="baoyou['+cdu+'][jian]"  value="1" class="input-text " autocomplete="off" maxlength="6"></td> <td><input type="text" name="baoyou['+cdu+'][mian]" value="0" class="input-text " autocomplete="off" maxlength="6">  </td>  <td><a href="javascript:delccc('+id+','+cdu+');" class="J_DeleteRule"><?php echo $LANG['del'];?></a></td></tr>';

        }else{


            html='<tr class="z'+id+'_'+cdu+'t"><td class="cell-area"><a href="javascript:xuanzediqu(\''+id+'_'+cdu+'\');" class="acc_popup edit J_EditArea" data-acc="event:enter" area-controls="J_DialogArea" area-haspopup="true"><?php echo $LANG['edit'];?></a><div class="area-group"> <p id="z'+id+'_'+cdu+'n"><?php echo $LANG['weidiqu'];?></p> </div><input type="hidden" id="z'+id+'_'+cdu+'i"  name="cunzai['+id+']['+cdu+'][diqu]"  value="" ></td> <td><input type="text" name="cunzai['+id+']['+cdu+'][jian]"  value="1" class="input-text " autocomplete="off" maxlength="6" "></td> <td><input type="text" name="cunzai['+id+']['+cdu+'][fei]"  value="" class="input-text " autocomplete="off" maxlength="6"></td> <td><input type="text" name="cunzai['+id+']['+cdu+'][jia]" value="1" class="input-text " autocomplete="off" maxlength="6">  </td> <td><input type="text" name="cunzai['+id+']['+cdu+'][zeng]" value=" " class="input-text " autocomplete="off" maxlength="6" ></td>   <td><a href="javascript:delccc('+id+','+cdu+');" class="J_DeleteRule"><?php echo $LANG['del'];?></a></td></tr>';


        }

        $(".lingxi"+id).find('tbody').append(html);

}


function delccc(id,zz){

        $(".z"+id+"_"+zz+"t").remove();
        cdu = $(".lingxi"+id).find('tr').length;

        if( cdu == 1){

            $(".lingxi"+id).find('table').hide();
        }

}


function xuandiqu(){

        str ='';
        name = '';
        $(".xshu").hide();
        $(".chengshid input:checked").each(function(){
         
            str += $(this).val()+',';
            name += CSHI[$(this).val()]+' , ';
         
        });

        chuid = $("#zengchli").val( );
        $("#z"+chuid+'i') .val(str);

        if(name == ''){
            $("#z"+chuid+'n') .html('<?php echo $LANG['weidiqu'];?>');
        }else{
            $("#z"+chuid+'n') .html(name);
        }

        layer.closeAll();
        return false;
}


$(function(){

        $(".dadingxuanxi").click(function(){

            fan = $("[name=off]").val();
            if(fan == 1){

                layer.msg('<?php echo $LANG['baoti'];?>');
                return false;
            }

            num = $(this).val();
            if( $(this).is(':checked')) {

                $(".lingxi"+num).find('.kuangli').show();

            }else{

                $(".lingxi"+num).find('.kuangli').hide();
            }

        });


        $(".J_Province").click(function(){

            kk = $(this).parent();
            $(".xshu").hide();

            if( $(this).is(':checked')) {

                kk.find(".xshu input").prop("checked",true);
                num = kk.find(".xshu input:checked").length;
                kk.find(".numl").html('('+num+')');

            }else{

                kk.find(".xshu input").prop("checked",false);
                kk.find(".numl").html('(0)');
            }

        });


        $(".numl").click(function(){

            $(".xshu").hide();
            kk = $(this).parent();
            kk.find('.xshu').show();

        });

      

        $(".J_Provincez").click(function(){

            kk = $(this).parents('dl');
            num =  kk.find("input.J_Provincez:checked").length;
            znum = kk.find("input.J_Provincez").length;

            if( num == znum ){
                    $(this).parents('li').find('.J_Province').prop("checked",true);
            }else{  
                    $(this).parents('li').find('.J_Province').prop("checked",false);
            }

            $(this).parents('li').find('b').html('('+num+')');
        });


        $("[name=type]").change(function(){
         
            val = $(this).val();
            $(".dddwww").html(DAW[val]);
        });

   

});
</script>
</body>
</html>