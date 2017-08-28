<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');


$D = db('');
/*计算*/


/*首先查询会员*/
$order = '  ';
$huiyuans = $D ->setbiao('user')->order('huobi desc')->where( array(

    'name!=' => ''

    ) )->limit('10')-> select();

if (is_array($huiyuans)) {
    $huihui = array();
    foreach($huiyuans as  $k => $v){
        $huihui[$v['uid']] = $v['huobi'];
    }
}





/*对关联数组进行排序*/
$paixuarr = arsort( $huihui );



?><!DOCTYPE html>
<html lang="zh" class="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Cache-Control" content="no-transform">
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<title><?php  echo $shezhi['title']?></title>
	<link rel="shortcut icon" href="img/favicon.ico">
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

    <script type="text/javascript">
    	var sharedata = {};
    </script>
</head>
<body class="page-bg">
        <div class="bg-box">
        <img class="bg-content" src="static/img/header.png">
        <div class="bg-wrapper"></div>
    </div>

    <p class="service-title">下级越多，佣金越多</p>
    <div class="cool-box">
        <div class="box-tabs">
            <span class="box-tab">佣金排行榜</span>
        </div>
        <div>


            <div class="table-headers">
                <div class="table-header">ID</div>
                <div class="table-header">佣金</div>
                <div class="table-header">排名</div>
            </div>


            <?php 
            if (is_array($huihui)) {
                $kk = 0;
                foreach($huihui as  $k => $v){
                    $kk = $kk+1;
                    /*查询会员信息*/
                    $huiyuan = $D -> setbiao('user')->where( array( "uid" => $k ) ) -> find();
                

            ?>

                <div class="table-line">
                    <div class="table-item"><?php echo $huiyuan['name'] ?></div>
                    <div class="table-item"><?php 
                    $txt = sprintf("%0.2f",$huiyuan['huobi'] );
                    echo $txt;
                    ?></div>
                    <div class="table-item"><?php echo $kk ?></div>
                </div>
                

<?php 
        }
    }
?>



        </div>
    </div>
    
    <div style="height: 49px;"></div>
    <?php 
        

    $lan='paihangbang';


    ?>
    <?php include QTPL.'foot.php';?>

    <link rel="stylesheet" href="static/css/web.min.css?v=140b">
    <script src="static/js/move.min.js?v=9c26"></script>
    <script src="static/js/web.min.js?v=5a93"></script>    <!--[if lt IE 9]>
    <script src="ie8.min.js"></script>
    <![endif]--><div style="display:none;">
	

</div>
</body>
</html>