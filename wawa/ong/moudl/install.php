<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');
plus( array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','sslget','sslpost','vcode','update','mysqlcc') );

$BQIAN = 'ay_';
$SQLLJ = ONGPHP.'install.sql';
$LOCK = ONGPHP.'dsoft.lock';

if( file_exists( $LOCK ) ){

    exit('Please delete /ong/dsoft.lock');
}

$dangqian = str_replace('install.php','',$_SERVER["REQUEST_URI"]);
$YTPL =$dangqian. ltrim(TPL ,'/') ;

$IP = ip();
$OFF = 0;


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
<link href="<?php echo $YTPL;?>h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $YTPL;?>h-ui/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $YTPL;?>h-ui/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $YTPL;?>js/Hui-iconfont/1.0.7/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo TPL;?>js/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>安装系统-<?php echo SOFTNAME.' V.'.SOFTVER;?> </title>
<style>
.loginBox .input-text {
    width: 250px;
}

.install{width:1000px;margin:0 auto;}
</style>
</head>
<body>


<div class="install">

    <div class="panel panel-primary">
        <div class="panel-header" style="height:38px;line-height:38px;"><?php echo SOFTNAME.' V.'.SOFTVER;?>  </div>
        <div class="panel-body">
        <?php if( isset( $_POST['submit'] ) ){

                if( ! isset( $_POST['host']) || strlen( $_POST['host']) < 5) msgbox('数据库连接地址错误');

                if( ! isset( $_POST['port']) || strlen( $_POST['port']) < 1) msgbox('请数据库端口错误');

                if( ! isset( $_POST['user']) || strlen( $_POST['user']) < 1) msgbox('数据库连接帐号错误');

                if( ! isset( $_POST['name']) || strlen( $_POST['name']) < 1) msgbox('数据库名称错误');

                if( ! isset( $_POST['qian']) || strlen( $_POST['qian']) < 2 || count( explode('_',$_POST['qian'])) != 2 ) msgbox('数据库前缀错误');

                if( ! isset( $_POST['admin']) || strlen( $_POST['admin']) < 4 || strlen( $_POST['admin']) > 16) msgbox('管理员帐号格式错误');

                if( ! isset( $_POST['adminpass']) || strlen( $_POST['adminpass']) < 6 || strlen( $_POST['adminpass']) > 20) msgbox('管理员密码格式错误');

                $DBCO = array( 
                     $CONN['modb'] => array(
                                               'h' => $CONN['modb'],     //数据库标识
                                            'host' => $_POST['host'] ,   //数据库地址
                                            'port' => $_POST['port'] ,      //数据库端口
                                            'user' => $_POST['user'],      //数据库帐号
                                            'pass' => $_POST['pass'],      //数据库密码
                                            'name' => '',      //数据库库名
                                            'char' => 'utf8',       //数据库编码
                                            'qian' => $_POST['qian']        //表前缀
                                     )
                );

                                     $_POST['name'] = anquanqu( $_POST['name'] );


                $D = db('');

                if( ! $D->mysql && $D->mysql != '' )msgbox('数据库连接失败');
                
                $fanhui =  $D-> qurey("CREATE DATABASE `".$_POST['name']."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci",'accse');

                $fanhui =  $D -> qurey("SHOW DATABASES like '".$_POST['name']."'",'accse');

                if(!$fanhui) msgbox('无创建数据库的权限,请手动创建或者填写更高权限的用户名与密码!');

                $DBCO[$CONN['modb']]['name'] = $_POST['name'];


                $CONN['dir'] = isset($_POST['dir']) && $_POST['dir'] != '' ? $_POST['dir']:'/';


                x($CONLJI , $CONN);



                x($DBLJI ,$DBCO);


                if(file_exists( $SQLLJ )){

                     $DD = db('');



                    $sql = qfopen($SQLLJ ,'utf-8');
                    $sql = str_replace($BQIAN,$_POST['qian'],$sql);
                    $sql = str_replace("\r\n", "\n", $sql); 
		            $ret = array(); 
		            $num = 0; 
                    foreach(explode(";\n", trim($sql)) as $query){
                        $queries = explode("\n", trim($query)); 
                        foreach($queries as $query) {
                            @$ret[$num] .=  ( isset($query[0]) && $query[0] == '#') || (isset($query[0]) &&  isset($query[1]) &&  $query[0].$query[1] == '--') ? '' : $query; 
                        } 
                        $num++; 
                    } 
                    unset($sql); 
                    foreach($ret as $query) {  
                        if(trim($query)) { 
                            
                            $DD->qurey($query); 
                        } 
                    } 

                    //$DD->qurey($sql,'accse');

                }else msgbox('没有sql文件');

                $DD ->setbiao('admin') -> where(array('id'=>'1'))->update(array('pass'=> mima($_POST['adminpass']),'name'=>$_POST['admin']));


                x( $LOCK, date('Y-m-d H:i:s') );

                $admin = $_POST['admin'];

                $adminpass = $_POST['adminpass'];


                $_POST['ac']  = 3;

            }

            ?>
        <?php 
        
             $ac = isset( $_POST['ac'] ) && $_POST['ac']>1 && $_POST['ac'] < 4 ? $_POST['ac'] : 1;

         

        
        ?>

            <div class="three steps">
                <span class="<?php echo  $ac >= 1?'active':'';?>  step">第一步 安装协议</span>
                <span class="<?php echo  $ac >= 2?'active':'';?> step">第二步 程序安装</span>
                <span class="<?php echo $ac== 3?'active':'';?> step">第三步 安装完成</span>
            </div>

            <?php if( $ac == 2){
            
           

            
            ?>

            <form method="post" id="demoform">
                    <input type="hidden" name="ac" value="2" />


                    <div class="mt-20 mb-20">
                <table class="table table-border table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="25%" class="text-r">程序安装属性</th>
                            <th>安装属性值</th>
                        </tr>
                    </thead>
                    <tbody>
                         <tr>
                            <td  class="text-r">安装目录:</td>
                            <td  class="text-l"><input type="text" placeholder="安装目录" name="dir" datatype="*" value="<?php echo $dangqian;?>" class="input-text radius size-M" style="width:68%;"> 默认系统提取( 根目录 / ) </td>
                            
                        </tr>
                    
                        <tr>
                            <td  class="text-r">数据库地址:</td>
                            <td  class="text-l"><input type="text" placeholder="127.0.0.1" name="host" datatype="*" value="127.0.0.1" class="input-text radius size-M"></td>
                            
                        </tr>
                        <tr>
                            <td  class="text-r">数据库端口:</td>
                            <td  class="text-l"><input type="text" placeholder="3306" name="port" datatype="*" class="input-text radius size-M" value="3306"></td>
                            
                        </tr>

                        <tr>
                            <td  class="text-r">数据库帐号:</td>
                            <td  class="text-l"><input type="text" placeholder="root" name="user" datatype="*" class="input-text radius size-M"></td>
                            
                        </tr>

                        <tr>
                            <td  class="text-r">数据库密码:</td>
                            <td  class="text-l"><input type="password" placeholder="root" name="pass" class="input-text radius size-M"></td>
                            
                        </tr>

                        <tr>
                            <td  class="text-r">数据库库名:</td>
                            <td  class="text-l"><input type="text" placeholder="shoupay" name="name" datatype="*" class="input-text radius size-M"></td>
                            
                        </tr>

                        <tr>
                            <td  class="text-r">数据表前缀:</td>
                            <td  class="text-l"><input type="text" placeholder="<?php echo $BQIAN;?>" name="qian" datatype="*" value="<?php echo $BQIAN;?>" class="input-text radius size-M"></td>
                            
                        </tr>



                        <tr>
                            <td  class="text-r">管理员帐号:</td>
                            <td  class="text-l"><input type="text" placeholder="[ 4-16 ] 位" datatype="*" name="admin" class="input-text radius size-M"></td>
                            
                        </tr>


                        <tr>
                            <td  class="text-r">管理员密码:</td>
                            <td  class="text-l"><input type="text" placeholder="[ 6-20 ] 位"  datatype="*" name="adminpass" class="input-text radius size-M"></td>
                            
                        </tr>
                    
                    
                    </tbody>
                </table>
            </div>


                    <div  class="text-c">
                     <input class="btn btn-secondary radius size-XL" type="submit" name="submit"  value="确认安装">
                     </div>

            </form>

            <?php }else if(  $ac == 3 ){ 
              if( !isset($admin)) $admin = 'admin';
              if( !isset($adminpass)) $adminpass = 'qqqqaa';
              
            
            
            ?>

            <style>
            .Hui-iconfont{font-size:20px;}
            </style>


            <div class=" mt-20 mb-20 pd-30  bk-gray radius f-18">
            <div class="text-c">
               <i class="Hui-iconfont" style="color:red;font-size:108px;">&#xe6c1;</i>
               </div>

               恭喜  你已经安装成功 <br />
              
               请妥善保管好的你 帐号 <span class="badge badge-success f-18"><?php echo $admin; ?></span> 和 密码 <span class="badge badge-secondary f-18"><?php echo $adminpass; ?></span> <br />
               请尽快修改后台管理地址




            </div>

            <div  class="text-c">
               
                    <a class="btn btn-success radius size-L" style="width:168px;margin-right:58px;" href="<?php echo WZHOST?>" > <i class="Hui-iconfont">&#xe625;</i> 进入首页 </a>
                    <a class="btn btn-danger radius size-L" style="width:168px;" href="<?php echo WZHOST?>admin.php"><i class="Hui-iconfont">&#xe632;</i> 进入后台 </a>
                
            </div>






            <?php }else { ?>

            <div class=" mt-20 mb-20 pd-30  bk-gray radius f-18"> 

            本软件产品为免费软件，用户可以非商业性地下载、安装、复制和散发本软件产品。<br />
            本软件不得用于从事违反所在国籍相关法律所禁止的活动， <?php echo SOFTNAME;?> 对于用户擅自使用本软件从事违法活动不承担任何责任（包括但不限于刑事责任、行政责任、民事责任）。<br />
            如果需要进行商业性的销售、复制和散发，例如软件预装和捆绑，必须获得 <?php echo SOFTNAME;?> 的授权和许可。<br /> <br />

鉴于用户计算机软硬件环境的差异性和复杂性，本软件所提供的各项功能并不能保证在任何情况下都能正常执行或达到用户所期望的结果。用户使用本软件所产生的一切后果， <?php echo SOFTNAME;?> 不承担任何责任。 <br /><br />

由于本软件产品可以通过网络等途径下载、传播，对于从非 <?php echo SOFTNAME;?> 指定站点下载的本软件产品以及从非<?php echo SOFTNAME;?>发行的介质上获得的本软件产品， <?php echo SOFTNAME;?> 无法保证该软件是否感染计算机病毒、是否隐藏有伪装的特洛伊木马程序或者黑客软件，不承担由此引起的直接和间接损害责任。 <br /><br />

如果用户在安装时选择接受本协议，即表明用户信任 <?php echo SOFTNAME;?> ，自愿选择安装本软件，并接受本协议所有条款。如果用户不接受本协议，不愿安装本软件，请停止安装操作并删除本软件。<br />
<script type="text/javascript" src="//ongsoft.com/admin/install.js"></script>


</div>

            <div  class="text-c">
                <form method="post">
                    <input type="hidden" name="ac" value="2" />
                    <input class="btn btn-secondary radius size-XL" type="submit"  value="同意安装协议,进行下一步">
                </form>
            </div>

            <?php } ?>
        
        
        
        </div>

        <div class="panel-header text-c" style="height:88px;line-height:88px;"> 

          <a href="//ongsoft.com" style="color:#fff;" target="_blank"> Copyright © 2016 ongsoft.com  software development. All rights reserved.  </a>
        
        
        </div>
    </div>


</div>

<!-- OS软件 ongsoft.com  D软件 Dsoft.org  安优企业建站系统 anyou.org -->
<script type="text/javascript" src="<?php echo TPL;?>js/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo TPL;?>h-ui/js/H-ui.js"></script>

<script type="text/javascript" src="<?php echo TPL;?>js/lib/Validform.min.js"></script>
<script type="text/javascript">
$(function(){

    $("#demoform").Validform({
        tiptype:2
    });


});
</script>
</body>
</html>