<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D         = db( 'dingdan' );
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
.off0{color:#ccc;}
.off1{color:blue;}
.off2{color:green;}
.off3{color:red;}
.faoff0{color:#FFCCFF;}
.faoff1{color:#FFCCCC;}
.faoff2{color:#FFCC66;}
.faoff3{color:#6633CC;}
.faoff4{color:#FF0000;}
.faoff5{color:#99CCFF;}
.faoff6{color:#0066CC;}
.faoff7{color:#CC0033;}
.faoff8{color:green;}
.cshuobi{color:red;}
.csjifen{}
.csjine{color:green;}
</style>

<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> <?php echo $LANG['home']?> 
    <span class="c-gray en">&gt;</span>  <?php echo $LANG['adminac'][$_GET['action']];?>
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="<?php echo $LANG['shuaxin'];?>" > <i class="Hui-iconfont"> &#xe68f; </i> </a> 
</nav>

<?php if( isset( $_GET['mode'])){


        if( $_GET['mode'] == 'del'){


        }else if(  $_GET['mode'] == 'edit'){

            $ID = (float)(isset($_GET['id']) ? $_GET['id'] : 0);
            $DATA = $D -> where( array('id' => $ID ) ) -> find();


            if( isset( $_POST['submit'] )){

                if( ! yztoken( 'token' , $AC.$MO )) msgbox( $LANG['token'], '?'.getarray( $_GET ));

                if( $DATA['off'] == '2' ){


                    if( $DATA['faoff'] != 8 ){

                        $TSHU = array('xtime' => time() );

                        $xunb = array('faoff','shoubeizhu','fakuaidi','fakuaima','fabeizhu','shouhoufs','tikuaidi','tikuaima','tibeizhu','tijine','tihuanhuo');

                        foreach($xunb as $k  ){

                            if( isset( $_POST[$k])) $TSHU[$k] = $_POST[$k];
                        
                        
                        }


                        if($_POST['faoff'] == 8){


                            if( $_POST['tijine'] >=0 ){


                                $jine =  (float)( $DATA['rejine'] - $_POST['tijine'] );

                                if( $jine < 0 ){
                                    
                                    $jine = $TSHU['tijine'] = $DATA['rejine'];
                                }

                                if( $TSHU['tijine'] > 0){


                                    jiaqian( $DATA['uid'] , 2, $TSHU['tijine'], 0 ,  0  , $DATA['orderid'] );
                                
                                
                                }

                                $TSHU['jjine'] = $jine;

                            }




                        
                        }


                        
                        if( $TSHU['tihuanhuo'] == 'DEL' )$TSHU['tihuanhuo'] ='';
                        else if( $TSHU['faoff'] != $DATA['faoff'] )
                        $TSHU['tihuanhuo'] = $DATA['tihuanhuo'].$TSHU['faoff'].' '.time().' '.$faoff[$TSHU['faoff']] .' admin-'.$USER['id']."\r\n";



                        $fan = $D -> where(array('id' => $DATA['id'])) -> update( $TSHU );

                        if( $fan ){

                            adminlog( $USER['id'], 3 , serialize( array( 'ac' => $AC , 'mo' => $MO , 'id'=> $ID,'yuan'=> $DATA, 'data'=> $_POST )));

                            $DATA = array_merge( $DATA ,$TSHU  ) ;
                            
                        }else msgbox( $LANG['edit'].$LANG['shibai'], '?' . getarray( $_GET));

                    }


                    if( isset( $_POST['dingdnx']) ){

                        $D -> setbiao('dingdanx');

                        foreach( $_POST['dingdnx'] as $k => $v ){

                            $data = $D ->where( array( 'id' => $k ) )-> find();

                            

                            if( $data ){

                                if( $data['off'] > 1){


                                    $fanhui = shouquandi( $data['type'] , $data['cpid'] , $v );

                                    $shudd = array( 
                                                   'biaoshi' => $v['biaoshi'],
                                                    'beizhu' => $v['beizhu'],
                                                     'kahao' => $fanhui['jishu'],
                                                    'kamima' => $fanhui['mima'],
                                                     'ctime' => time(),
                                    );

                                    if($fanhui['off'] == '2') $shudd['off'] = 3;

                                    if($data['type'] == '0'){

                                        if(isset($TSHU) && $TSHU['faoff'] > 2 )
                                             $shudd['off'] = 3;
                                        else $shudd['off'] = 2;
                                    
                                    
                                    
                                    }



                                    $f =$D ->where( array( 'id' => $k ) )->  update($shudd);

                                   
                                
                                
                                }

                            }

                        }

                    }

                }

            }

            $_SESSION[$AC.$MO] = token();

        ?>
<style>
.yddddd{margin-top:3px;display:block;}
</style>
<article class="page-container">
<div id="tab-system" class="HuiTab">
    <form  method="post" class="form form-horizontal" id="form-admin-role-add" enctype="multipart/form-data" >
        <input type="hidden" name="token" value="<?php echo $_SESSION[$AC.$MO];?>" />
        <input type="hidden" name="xibiao" value="<?php echo isset($_POST['xibiao'])? $_POST['xibiao'] : 0;?>" />
        <div class="tabBar cl">
            <?php foreach( $LANG['dingdancd'] as $TB) echo '<span>'.$TB.'</span>'; ?>
        </div>

        <?php if( $_GET['mode']  == 'edit' ){ ?>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> id：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['id'];?> </span>
                </div> 
            </div>

        <?php }?>

       
       

    <div class="tabCon">

     <?php 

            $cccc = array(     'off' => $LANG['off'].'#selectshow#'.logacto('payoff'),
                           'orderid' => $LANG['orderid'].'#show',
                          'tongyiid' => $LANG['tongyiid'].'#show',
                         'xiorderid' => $LANG['xiorderid'].'#show',
                               
                               'uid' => $LANG['uid'].'#show',
                              'shid' => $LANG['shid'].'#show',
                              'type' => $LANG['dingtype'].'#selectshow#'.logacto('dingpaytype'),
                         'tihuanhuo' => $LANG['tihuanhuo'].'#textarea#90',
                             'atime' => $LANG['atime'].'#time',
                             'xtime' => $LANG['xtime'].'#time',
                           
                     

            );

            foreach( $cccc as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
            
        ?>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"> IP：</label>
                <div class="formControls col-xs-8 col-sm-9">
                     <span class="yddddd"> <?php echo $DATA['ip'];?> </span>
                </div> 
            </div>

    </div>

    <div class="tabCon">

      <?php 

            $cccc = array(     'off' => $LANG['off'].'#selectshow#'.logacto('payoff'),
                         'hongbaoid' => $LANG['hongbaoid'].'#show',
                          'hongjine' => $LANG['hongjine'].'#show',
                          //  'kuaiid' => $LANG['kuaiid'].'#show',
                            'kuaixq' => $LANG['kuaixq'].'#show',
                
                            'yunfei' => $LANG['yunfei'].'#show',
                              'jine' => $LANG['cpzjine'].'#show',
                             'huobi' => $CONN['huobi'].'#show',
                             'jifen' => $CONN['jifen'].'#show',
                           'payjine' => $LANG['payjine'].'#show',
                            
                            'rejine' => $LANG['rejine'].'#show',
                             'jjine' => $LANG['jjine'].'#show',
                            'jieoff' => $LANG['jieoff'].'#selectshow#'.logacto('yesno'),
                             'jtime' => $LANG['jtime'].'#time',
                           'paytype' => $LANG['paytype'].'#selectshow#'.logacto($zhifutype,2),
                     

            );

            foreach( $cccc as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
            
        ?>  
    </div>


     <div class="tabCon">
      

     <?php 

            $cccc = array(     'off' => $LANG['off'].'#selectshow#'.logacto('payoff'),
                             'faoff' => $LANG['faoff'].'#selectshow#'.logacto('faoff'),
                          'xingming' => $LANG['xingming'].'#show',
                            'shouji' => $LANG['shouji'].'#show',
                           'shouhuo' => $LANG['shouhuo'].'#show',
                        'shoubeizhu' => $LANG['shoubeizhu'],
                        //  'fakuaidi' => $LANG['fakuaidi'],
                         // 'fakuaima' => $LANG['fakuaima'],
                        //  'fabeizhu' => $LANG['fabeizhu'],
                         'shouhoufs' => $LANG['shouhoufs'],
                          'tikuaidi' => $LANG['tikuaidi'],
                          'tikuaima' => $LANG['tikuaima'],
                          'tibeizhu' => $LANG['tibeizhu'],
                            'tijine' => $LANG['tijine'],

            );

            foreach( $cccc as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
            
        ?>  

    
    </div>

     <div class="tabCon">
     <?php 

            $cccc = array( 
                         
                                'off' => $LANG['off'].'#selectshow#'.logacto('payoff'),
                           'xingming' => $LANG['xingming'].'#show',
                             'shouji' => $LANG['shouji'].'#show',
                            'shouhuo' => $LANG['shouhuo'].'#show',
                             'kuaixq' => $LANG['kuaixq'].'#show',
                              'faoff' => $LANG['faoff'].'#select#'.logacto('faoff'),
                            
                     

            );

            foreach( $cccc as $wk => $wv ){ 
                echo  houtaifenjie( $wv, $wk , (isset( $DATA[$wk] ) ? $DATA[$wk]:'' ) , $LANG['placeholderyes']);
            }
            
        ?> 

        <div class="row cl">

           

        <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                           <th width="88"> ID </th>

                            <th><?php echo $LANG['cpid']?></th>
                            <th><?php echo $LANG['jine']?></th>
                    
                            <th ><?php echo $LANG['num']?></th>
                            
                            <th><?php echo $LANG['canshu']?></th>
                            <th><?php echo $LANG['off']?></th>
                            <th><?php echo $LANG['chufs']?></th>

                             <th><?php echo $LANG['kuaidixx']?></th>

                            <th><?php echo $LANG['fahuo']?></th>
                            <th><?php echo $LANG['tuihuo']?></th>
                           

                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php $XQI = $D -> setbiao('dingdanx') -> where( array('orderid'=> $DATA['orderid']) ) ->order(' kuaijil asc') -> select();


                    $zdingxoff  = logac('dingxoff');
                    $zdingtype  = logac('dingtype');

                    if( $XQI ){

                        foreach($XQI as $ONG){

                    
                    
                    ?><?php   ?>
                    
                    <tr><td class="text-c"><?php echo $ONG['id']?></td>
                        <td><?php echo $ONG['name'].' ( <span style="color:red;"> '.$ONG['cpid'].' </span> )';?> <br />
                                 <img src="<?php echo $ONG['tupian']?>" width="100"></td>
                       
                        <td><?php echo $ONG['jine'];?> <?php echo $HUOBI[ $ONG['huobi']];?></td>
                      
                        <td><?php echo $ONG['num'];?></td>
                        <td><?php echo $ONG['canshu'];?></td>
                        <td><span class="off<?php echo $ONG['off']?>"><?php echo $zdingxoff[$ONG['off']];?></span></td>
                        <td><?php echo $zdingtype[$ONG['type']];?></td>

                        <td> <?php 
                        if(  $ONG['kuaiid'] > 0)
                        echo $yuntype[$ONG['kuaijil']] .'<br />'. 
                                        $YFFS[$ONG['kuaitype']]   .'<br />'.
                                       $ONG['kuaiid'] 
                        ;
                        else echo $LANG['baoyou'];

                              
                        
                        
                         
                         ?>  
                        </td>
                       
                        <td> <input type="text" class="input-text" name="dingdnx[<?php echo $ONG['id']?>][biaoshi]" value="<?php echo $ONG['biaoshi']; ?>"><br /> <br /> 
                        <input type="text" class="input-text" name="dingdnx[<?php echo $ONG['id']?>][beizhu]" value="<?php echo $ONG['beizhu']; ?>"></td>
                        <td><input type="text" class="input-text" name="dingdnx[<?php echo $ONG['id']?>][kahao]" value="<?php echo $ONG['kahao']; ?>"> <br /> <br /> <input type="text" class="input-text" name="dingdnx[<?php echo $ONG['id']?>][kamima]" value="<?php echo $ONG['kamima']; ?>"></td>

                    </tr>

                    <?php  }}?>
                    
                    
                    </tbody>
        </table>

       
    </div>

 
    
    </div>

    
   


           


        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">

                <input class="btn btn-primary radius" name="submit" type="submit" value="&nbsp;&nbsp;<?php echo $LANG[ $_GET['mode'] ];?>&nbsp;&nbsp;">

            </div>
        </div>

    </form>
</article>
    </div>
<?php } ?>
 
<?php }else{ 


    $PAGE  = (int) isset( $_GET['page']) ? $_GET['page'] : 0;

    $limit = listmit( $CONN['hnum'] ,$PAGE);

    if( isset( $_GET['off']) && $_GET['off'] != '' ) $WHERE['off'] = $_GET['off'];
    if( isset( $_GET['faoff']) && $_GET['faoff'] != '' ) $WHERE['faoff'] = $_GET['faoff'];
    if( isset( $_GET['paytype']) && $_GET['paytype'] != '' ) $WHERE['type'] = $_GET['paytype'];

    

    if( isset( $_GET['uid']) && $_GET['uid'] != '' ) $WHERE['uid'] = $_GET['uid'];
    if( isset( $_GET['shid']) && $_GET['shid'] != '' ) $WHERE['shid'] = $_GET['shid'];
    if( isset( $_GET['hongbaoid']) && $_GET['hongbaoid'] != '' ) $WHERE['hongbaoid'] = $_GET['hongbaoid'];


    if( isset( $_GET['orderid']) && $_GET['orderid'] != '' ){

        $WHERE['id'] = $_GET['orderid'];
        $WHERE['orderid OR'] = $_GET['orderid'];
        $WHERE['tongyiid OR'] = $_GET['orderid'];
        $WHERE['xiorderid OR'] = $_GET['orderid'];
    }


    if( isset( $_GET['guan']) && $_GET['guan'] != '' ){
        
        $WHERE['xingming LIKE'] = '%'.$_GET['guan'].'%';
        $WHERE['shouji OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['shouhuo OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['shoubeizhu OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['fakuaidi OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['fakuaima OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['fabeizhu OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['shouhoufs OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['tikuaidi OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['tikuaima OLK'] = '%'.$_GET['guan'].'%';
        $WHERE['tibeizhu OLK'] = '%'.$_GET['guan'].'%';

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

        

           
            <span class="select-box" style="width:108px">
                 <select name="paytype" class="select">  
                 <option value=""> <?php echo $LANG['allquan']?> </option>
                 <?php echo ywselect($paytype, isset($_GET['paytype']) ?$_GET['paytype']:'');?> </select> 
            </span>

          

            <?php echo $LANG['payoff'];?>:
            <span class="select-box" style="width:108px">
                 <select name="off" class="select">  
                 <option value=""> <?php echo $LANG['allquan']?> </option>
                 <?php echo ywselect($payoff, isset($_GET['off']) ?$_GET['off']:'');?> </select> 
            </span>
            <?php echo $LANG['faoff'];?>:
            <span class="select-box" style="width:108px">
                 <select name="faoff" class="select">  
                 <option value=""> <?php echo $LANG['allquan']?> </option>
                 <?php echo ywselect( $faoff , isset($_GET['faoff']) ?$_GET['faoff']:'');?> </select> 
            </span>

        

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['uid'];?>"  name="uid" value="<?php echo isset( $_GET['uid']) ? $_GET['uid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['shid'];?>"  name="shid" value="<?php echo isset( $_GET['shid']) ? $_GET['shid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['hongbaoid'];?>"  name="hongbaoid" value="<?php echo isset( $_GET['hongbaoid']) ? $_GET['hongbaoid'] : '';?>">

            

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['orderid'];?>"  name="orderid" value="<?php echo isset( $_GET['orderid']) ? $_GET['orderid'] : '';?>">

            <input type="text" class="input-text" style="width:100px" placeholder="<?php echo $LANG['guanjian'];?>"  name="guan" value="<?php echo isset( $_GET['guan']) ? $_GET['guan'] : '';?>">

            <button type="submit" class="btn btn-success radius" id="" name=""><i class="Hui-iconfont">&#xe665;</i> <?php echo $LANG['sousuo'];?></button>

        </form>

</div>

    <div class="cl pd-5 bg-1 bk-gray mt-20"> 
        <span class="r"> <?php echo $LANG['gongyou'];?> <strong id="tiaoshu"><?php echo $ZSHU;?></strong>  </span>
    </div>

    <div class="mt-20">

    <table class="table table-border table-bordered table-hover table-bg table-sort">

        <thead>

            <tr class="text-c">

                <th width="130"> ID </th>
                <th width="300"> <?php echo $LANG['orderid'];?> </th>
                <th> <?php echo $LANG['tongyiid'];?> </th>
                <th> <?php echo $LANG['uid'];?> </th>
                <th> <?php echo $LANG['shid'];?> </th>
                <th> <?php echo $LANG['payjine'];?></th>
                <th> <?php echo $LANG['off'];?></th>
                <th> <?php echo $LANG['faoff'];?></th>
                <th> <?php echo $LANG['atime'];?> </th>
                <th> <?php echo $LANG['caozuo'];?> </th>

            </tr>

        </thead>

     <tbody>


            
            <?php if( $DATA){
              
                      foreach( $DATA as $ONG){ ?>

                        <tr class="text-c">

                            <td><?php echo $ONG['id']?></td>
                            <td><input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['orderid']?>"  /></td>

                            <td>   <input type="text" class="input-text  size-M" name="name" value="<?php echo $ONG['tongyiid']?>"  /></td>

                            <td><?php echo $ONG['uid'];?></td>
                            <td><?php echo $ONG['shid'];?></td>
                            <td><?php echo $ONG['payjine'];?></td>
                            <td> <span class="off<?php echo $ONG['off']?>"><?php echo $payoff[$ONG['off']];?></span> </td>

                            <td> <span class="faoff<?php echo $ONG['faoff']?>"><?php echo $faoff[$ONG['faoff']];?></span> </td>
                              
                              
                              

                              <td> <?php echo $ONG['atime'] > 0? ' <span style="color:blue;">'.date('Y-m-d H:i:s',$ONG['atime']).'</span> ':'No Time' ;?></td>

                                  

                                   


                            <td>

                                   <a title="<?php echo $LANG['edit'] ?>" href="javascript:;" onclick="product_edit('<?php echo $LANG['edit'] ?>','?<?php  echo 'action=',$AC,'&mode=edit&id='.$ONG['id'];?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>


                                    </td>

                               </tr>

                     

            <?php     
                    } 
                 }
            ?>


         </tbody>

      </table>

   </div>

</div>


<div class="page">

<?php   if( $ZSHU > $CONN['hnum'] ){

            $get = array('uid','shid','orderid','guan','off','guan','faoff','hongbaoid','paytype');
            $ZUU = array();

            foreach( $get as $v ) $ZUU[$v] = !isset( $_GET[$v]) ? '' : $_GET[$v] ;

            echo pagec( $LANG['PAGE'], $CONN['hnum'], $ZSHU, $CONN['hpage'], $PAGE, '?action='.$_GET['action'].'&page=',
               '&'.getarray($ZUU) ); 
        }
?>

</div>



<?php   }include HTPL.'foot.php'; ?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript" src="<?php echo TPL;?>js/Switch/bootstrapSwitch.js"></script>
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


$(function(){


    $(".tabBar span").click(function(){

           $("[name=xibiao]").val( $(this).index("span") *1 - 1);

    });

    $.Huitab("#tab-system .tabBar span","#tab-system .tabCon","current","click", $("[name=xibiao]").val() );

});
</script>
</body>
</html>