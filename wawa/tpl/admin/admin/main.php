<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');?>
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
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title><?php echo $LANG['adminac'][$_GET['action']];?></title>
</head>
<body>
<div class="page-container">
    
    <?php  

        $adminlog =  db('adminlog');

        $shuju =  $adminlog ->order('id desc')-> where(array( 'uid' => $USER['id'] ,'type' => 0)) -> limit('1,1') -> select();

    
    ?>
    <p><?php echo $LANG['main']['shangciip'];?>：<?php echo $shuju['0']['ip']?>  <?php echo $LANG['main']['shangcitime'];?>：<?php echo date('Y-m-d H:i:s',$shuju['0']['atime']);?></p>


    <div class="admin">


        <!-- <script type="text/javascript" src="<?php echo WZHOST;?>ad.js"></script> -->

        


    </div>
    

 


    <table class="table table-border table-bordered table-bg mt-20">
        <thead>
        <?php

        if( isset($_POST['submit'])){ 

            if( ! yztoken('token' ,'main')) msgbox($LANG['token'], '?'.createLinkstring( $_GET) );

            if( $_POST['lx']  == 1 ){

                $Mem -> f();

                if( $CONN['yunxing'] == '3' ||  $CONN['yunxing'] == '5' ){

                    $dir = ONGPHP.'..';

                    $ds = DIRECTORY_SEPARATOR;
                    $dir = false ? realpath( $dir ) : $dir;
                    $dir = substr( $dir, -1 ) == $ds ? substr( $dir, 0, -1 ) : $dir;
                    if (is_dir( $dir ) && $handle = opendir( $dir )){

                        while ( $file = readdir( $handle )){
                                if ( $file == '.' || $file == '..') continue;
                                elseif ( is_dir( $dir . $ds . $file)) continue;
                                else if( strstr($file, '.html') ) @unlink($dir . $ds . $file);
                        }

                        closedir( $handle );
                    }
                }

                $Mem -> s('adminlogin/'. $USER['id'] , IP() );

            }

        }
        
        $_SESSION['main'] = token();
        
        ?>
        <?php  ?>

        <form method="post">
            <input type="hidden" name="lx" value="1" />
            <input type="hidden" name="token" value="<?php echo $_SESSION['main'];?>" />
            <tr>
                <td><?php echo $LANG['qinglihuancun'];?></td>
                <td><input type="submit" name="submit" value="<?php echo $LANG['submit'];?>" class="btn btn-primary radius" /></td>
            </tr>
        </form>
            <tr>
                <th colspan="2" scope="col"><?php echo $LANG['main']['serverinfo'];?></th>
            </tr>
        </thead>
        <tbody>
           
           

            <tr>
                <th><?php echo $LANG['main']['serverip'];?></th>
                <td> <?php echo getHostByName(php_uname('n'));?></td>
            </tr>
            <tr>
                <th><?php echo $LANG['main']['serverhost'];?></th>
                <td> <?php echo $_SERVER['HTTP_HOST'];?></td>
            </tr>
            <tr>
                <th><?php echo $LANG['main']['serverpor'];?> </th>
                <td><?php echo $_SERVER['SERVER_PORT'];?></td>
            </tr>
            <tr>
                <th><?php echo $LANG['main']['serverweb'];?> </th>
                <td> <?php echo $_SERVER['SERVER_SOFTWARE']?></td>
            </tr>
            <tr>
                <th><?php echo $LANG['main']['servewww'];?>  </th>
                <td><?php echo str_replace('ong/','', ONGPHP)?></td>
            </tr>
        
            <tr>
                <th> <?php echo $LANG['main']['servertime'];?> </th>
                <td><?php echo date('Y-m-d H:i:s')?></td>
            </tr>
        
        </tbody>
    </table>


    <table class="table table-border table-bordered table-bg mt-20">
        <thead>
            <tr>
                <th colspan="2" scope="col">  <?php echo $LANG['main']['serveryun'];?> </th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                <th width="30%"> <?php echo $LANG['main']['servername']?></th>
                <td> <?php echo '<a href="'.SOFTHTTP.'">'.SOFTNAME.' V'.SOFTVER.'</a>';?></td>
            </tr>
         
            <tr>
                <th>  <?php echo $LANG['main']['phpver']?>  </th>
                <td> <?php echo  phpversion();;?></td>
            </tr>
            <tr>
                <th>  <?php echo $LANG['main']['maxsize']?>  </th>
                <td> <?php echo @ini_get('upload_max_filesize');?></td>
            </tr>
            <tr>
                <th>  <?php echo $LANG['main']['timeshiqu']?>   </th>
                <td> <?php echo date_default_timezone_get();?></td>
            </tr>
        
        </tbody>
    </table>
</div>


<footer class="footer mt-20">
    <div class="container">
        <p>
            Copyright <?php echo $CONN['title'];?> by <a href="<?php echo SOFTHTTP;?>" target="_blank"><?php echo SOFTNAME;?></a>
        </p>
    </div>
</footer>

<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/layer.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.admin.js"></script> 
</body>
</html>