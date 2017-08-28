<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');
$D = db('');

    /*获取会员开始*/
    $user = uid( $_SESSION['uid'],1 );
    /*获取会员结束*/

    /*抓娃娃记录开始*/
    $order = '  ';
    $wawa = $D ->setbiao('wawa')->order( 'id desc' )->where( array(
        'uid' => $_SESSION['uid']
        ) )-> select();
    /*抓娃娃记录结束*/


    /*提现中计算*/
    $order = '  ';
    $tixians = $D ->setbiao('tixian') -> order(  )->where( array(
        'uid' => $_SESSION['uid'],
        'type' => 1,
        'off' => 0
        ) )-> select();
   
   $shenheqian = 0;
   if (is_array($tixians)) {
       
       foreach($tixians as  $k => $v){
            $shenheqian+= (float)$v['jine'];
       }

   }
   $shenheqian = sprintf("%0.2f",$shenheqian);



?>
<!DOCTYPE html>
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

        <div class="cool-box">
            <div class="table-headers">
                <div class="table-header">今日到账</div>
                <div class="table-header">提现中</div>
            </div>
            <div class="table-line">
            <?php 
                
            /*计算今日到账*/
            /**/
            $riqi = date("Y-m-d", time() );
            $kaishi = $riqi.' 0:1';
            $jieshu = $riqi.' 23:59';

            $kaikai = strtotime( $kaishi );
            $jiejie = strtotime( $jieshu );


            $order = '  ';
            $jins = $D ->setbiao('jinelog')->order(  )->where( array(
                'uid' => $_SESSION['uid'],
                'atime >=' =>$kaikai,
                'atime <=' => $jiejie,
                ) )-> select();
 
       $zong = 0;
        if (is_array($jins)) {
        
            foreach($jins as  $k => $v){
                $zong+=$v['jine'];

            }
        }
        $zong = sprintf("%0.2f",$zong);


            ?>

                <div class="table-item">￥ <?php echo $zong ?></div>

                <div class="table-item">￥ <?php echo $shenheqian ?></div>

            </div>
        </div>

<style type="text/css">
    .jjkk div{
        flex:1;
    }
</style>

        <div class="income-box">
            <div class="cash-price-label">账号余额</div>
            <div class="cash-price">￥ <?php echo $user['jine'] ?></div>
            <div class="cash-title">
                满10元可提现，每天可提现10次，提现时间：9:00-23:00提交后耐心等待财务审核！
				</div>
            <a class="cash-btn" href="?action=tixian&canshu=xianjin"  >立即提现</a>
        </div>

        <div class="cool-box">
            <div class="box-tabs">
                <span class="box-tab">我夹中的娃娃</span>
            </div>
            <div class="cool-list" data-next="">
                <div class="table-headers">
                    <div class="table-header">时间</div>
                    <div class="table-header">收入</div>
                </div>


                <?php 
                    
                if (is_array($wawa)) {
                    foreach($wawa as  $k => $v){

                ?>

                    <div class="table-line">
                        <!-- <div class="table-item" style="padding: 80px 0;">暂无记录</div> -->
                        <div class="table-item  jjkk" style="display: flex;" >
                            
                    <div class="table-header"><?php echo date("Y-m-d H:i:s",$v['atime'])?></div>
                    <div class="table-header"><?php echo $v['dedao'] ?></div>



                        </div>
                    </div>

                    <?php 
                        }
                    }
                    ?>



            </div>
        </div>

        
    <div style="height: 49px;"></div>
    <?php 
        $lan='jilu';
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