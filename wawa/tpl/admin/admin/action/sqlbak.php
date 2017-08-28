<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D    = db('type');

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


<?php

    $bakcmulu = ONGPHP.'back/';
     jianli( $bakcmulu );

    if( isset( $_GET['mode'])){
        
        
        
        if($_GET['mode'] == 'edit'){


         


        if( !yztoken('token', $AC )) msgbox($LANG['token'],'?action='.$AC);

        set_time_limit(0);
        @ini_set('memory_limit', '2048M');






        $users = db('admin');

        $result = $users ->qurey("SHOW TABLES FROM `".($DBCO[$CONN['modb']]['name'])."`",'erwei');

        $filesize = intval(1024);
        $random = mt_rand(1000, 9999);
        $p=1;

        for ( $i = 0; $i < count( $result ); $i++ ){

            $tables[] = $result[$i]['Tables_in_'.($DBCO[$CONN['modb']]['name'])];

        }

        $sql = '';


        foreach( $tables as $table ){


            if(  $table == $DBCO[$CONN['modb']]['qian'].'adminlog') continue;

            $array = $users ->qurey( "SELECT * FROM $table" ,'erwei');

            $sql.= "TRUNCATE TABLE `$table`;\n";

                $users -> setbiao(str_replace( $DBCO[$CONN['modb']]['qian'] ,'', $table ) );



                if( $array ){

                    $mm = array();

                    $ttt = 1;

                    foreach( $array  as $zhi){


                        if($ttt % 100 == '0'){

                            $mm [] =$users -> psql( $zhi,2);
                            $sql=  $users -> pqsql( $mm ,2);
                            $filename = $bakcmulu.date('Ymd').'_'.$random.'_'.$p.'.sql';
                            file_put_contents($filename,base64_encode($sql.';') );
                            $sql = '';
                            $p++;
                            $mm = array();

                        }else  $mm [] =$users -> psql( $zhi,2);

                        $ttt++ ;

                    }

                    $sql=  $users -> pqsql( $mm ,2);
                    
                    $filename = $bakcmulu.date('Ymd').'_'.$random.'_'.$p.'.sql';
                    file_put_contents($filename,base64_encode($sql.';'));
                    $sql = '';
                    $p++;
                    
                }

            

        }




    
    msgbox('OK','?action='.$AC);

    }else if( $_GET['mode'] == 'del'){


              

                if( ! yztoken( 'token' , $AC ) )  msgbox( $LANG['token'], '0');
                @unlink( $bakcmulu.str_replace( '../', '', ($_GET['id'])));
               

                msgbox( $LANG['yishanchu'] , '1');
                
                
    }else if( $_GET['mode'] == 'add'){

        if(isset($_POST['file']) ){ 


        $fenz = explode('_',$_POST['file']);

        if( isset( $fenz['2'] ) )unset($fenz['2']);

        $mubiop = (implode('_',$fenz));

        $fenge = array();

        $mydir=dir( $bakcmulu);
        while($file=$mydir->read()){ 
	
                if(($file!=".") and ($file!="..")  and (strstr($file,$mubiop))){
                      
                       $fenge[] = $file;
                } 


       }
       
       $mydir->close();

        if( $fenge )  $Mem->s('linshihui',$fenge);
         echo '<script type="text/javascript">
                 window.location.href="?action='.$AC.'&mode=add&page=1";
             </script>';
         exit();

         

       }else{

            $muzhi = $Mem->g('linshihui');
            if(!$muzhi)msgbox('NO','?action='.$AC );
            $usss = db('admin');


            foreach($muzhi as $vv=>$kk){
                    $sql = qfopen($bakcmulu.$kk,'utf-8');
	                
                    $usss->query(base64_decode($sql)); 
                  
            }

            unset($muzhi[$vv]);
            if($muzhi) $Mem -> s( 'linshihui' ,$muzhi);
            else  $Mem -> d( 'linshihui' );

            echo '<script type="text/javascript">
                 window.location.href="?action='.$AC.'&mode=add&page=1";
             </script>';
            exit();
       
       
       }


    
    
    }




  }else{ 
      
  
    $fenge = array();

    $mydir=dir( $bakcmulu );

	while($file=$mydir->read()){ 

			if(($file!=".") and ($file!="..") and ($file!="index.html")){
              
			   $fenge[] = array($file , filemtime($bakcmulu.$file));
			  } 
	} 


    $mydir->close();

    asort($fenge);


      ?>
<style>
.table .Hui-iconfont{font-size:20px;color:red;}
</style>
<div class="page-container">
    <div class="mt-20">

        <table class="table table-border table-bordered table-hover table-bg table-sort">

            <thead>
                <tr class="text-c">
                    <th width="130"> ID </th>
                    <th> name </th>
                  
                    <th> time</th>
                     <th> <?php echo $LANG['caozuo'];?></th>
                  
                </tr>
            </thead>

            <tbody>

            <?php $z = 1;foreach( $fenge as $ong){  ?>


                <form method="post" action="?action=<?php echo $AC.'&mode=add'?>">
                    <input type="hidden" name="file" value="<?php echo $ong['0']?>">

                    <tr id="delsc<?php echo $z;?>">
                        <td><?php echo $z;?></td>
                        <td><?php echo $ong['0']?></td>
                        <td><?php echo date('Y-m-d H:i:s',$ong['1']);?></td>
                        <td><input type="submit" name="submit"  class="btn btn-primary radius" value="<?php echo $LANG['huifu'];?>" />
                        
                         <a title="<?php echo $LANG['del'];?>" href="javascript:;" onclick="admin_del(this,'<?php echo $ong['0']?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i> </a>
                        
                        </td>

                    </tr>

                </form>
            
            
            
            
            <?php $z++; }?>


            </tbody>

       </table>

   </div>

</div>


<?php   $_SESSION[$AC] = token();?>

 <article class="page-container">


    <div class="row cl mt-20">

            <div class="col-xs-4 col-sm-4 col-xs-offset-4 col-sm-offset-4">
            <form method="get">
                <input type="hidden" name="action" value="<?php echo $AC;?>" />
                <input type="hidden" name="mode" value="edit" />
                <input type="hidden" name="token" value="<?php echo $_SESSION[$AC];?>" />
                <input class="btn btn-primary radius" name="submit" type="submit" value="<?php echo $LANG['sqlbak'];?>">
            </form>

            </div>
    </div>

 </article>



<?php }



include HTPL.'foot.php'; 

 
?>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript">
var token ='<?php echo $_SESSION[$AC]?>';

function admin_del( obj, id){

        layer.confirm('<?php echo $LANG['shanchumsgbox'];?>',{title:'<?php echo $LANG['msgbox'];?>',btn:<?php echo json_encode($LANG['msboxbtn']);?>},function(index){
          
              $.getJSON('?action=<?php echo $AC;?>&mode=del&ajson=1&token=' + token + '&id='+id,{},function(data){

                  if(data.token){  token = data.token; $("#sctoken").val(token); }
              
                  if(data.code == 1){

                       $(obj).parents("tr").remove();

                       layer.msg('<?php echo $LANG['yishanchu'];?>',{icon:1,time:1000});

                  }else  layer.msg( data.msg ,{ icon: 2 ,time : 1000});

              });

        });
}
</script>


</body>
</html>