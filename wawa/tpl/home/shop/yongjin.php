<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');

$D = db('');

/*查询佣金*/
$order = '  ';
$yongs = $D ->setbiao('huobilog')->order(  )->where( array(
    'uid' => $_SESSION['uid'],
    'type' => 2
    ) )-> select();

    $zongyongjin = 0;
    if (is_array($yongs)) {
        foreach($yongs as  $k => $v){
            $zongyongjin+=(float)$v['jine'];
        }
    }

    $zongyongjin = sprintf("%0.2f",$zongyongjin);

/*查看日志*/
$huobilog = logac('huobilog');



/*查询提现中佣金*/
$order = '  ';
$tixiany = $D ->setbiao('tixian')->order(  )->where( array(
    'type' => 2,
    'uid' => $_SESSION['uid'],
    'off' => 0
    ) )-> select();


/*提现中*/
$tixianzhong = 0;
if (is_array($tixiany)) {

    foreach($tixiany as  $k => $v){
        $tixianzhong+=(float)$v['jine'];
    }

}

$tixianzhong = sprintf("%0.2f",$tixianzhong);




   /*计算今日到账*/
            /**/
$riqi = date("Y-m-d", time() );
$kaishi = $riqi.' 0:1';
$jieshu = $riqi.' 23:59';

$kaikai = strtotime( $kaishi );
$jiejie = strtotime( $jieshu );


$order = '  ';
$jins = $D ->setbiao('huobilog')->order(  )->where( array(
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
                <div class="table-header">累计佣金</div>
                <div class="table-header">今日佣金</div>
                <div class="table-header">提现中佣金</div>
            </div>
            <div class="table-line">
                <div class="table-item">￥ <?php echo $zongyongjin ?></div>
                <div class="table-item">￥ <?php echo $zong ?></div>
                <div class="table-item">￥ <?php echo $tixianzhong ?></div>
            </div>
        </div>
        <div class="income-box">
            <div class="cash-price-label">佣金余额 </div>
            <?php 
                
            $yongjins = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['uid']) ) -> find();

            ?>
            <div class="cash-price">￥ <?php echo $yongjins['huobi'] ?></div>
            <div class="cash-title">
               满10元可提现，每天可提现10次，提现时间：9:00-23:00提交后耐心等待财务审核！
            </div>
            <a class="cash-btn" href="?action=tixian&canshu=yongjin">立即提现</a>
        </div>

        <div class="cool-box">
            <div class="box-tabs">
                <span class="box-tab">我的佣金</span>
            </div>
            <div class="cool-list" data-next="">
                <div class="table-headers">
                    <div class="table-header">时间</div>
                    <div class="table-header">佣金</div>
                </div>


                <?php 
                    if (is_array($yongs)) {
                        foreach($yongs as  $k => $v){
                ?>

                 <div class="table-headers" style="background: #fd9ba3;line-height: 30px;border-bottom: 1px dashed #eee">
                    <div class="table-header"><?php echo date("Y-m-d H:i:s",$v['atime'])?></div>
                    <div class="table-header"><?php echo $v['jine'] ?></div>
                </div>
           


              

                    <?php 
                }
                        }else{
                    ?>

                    <div class="table-line">
                        <div class="table-item" style="padding: 80px 0;">暂无记录</div>
                    </div>

                    <?php 
                        }
                    ?>

            </div>
        </div>

        
    <div style="height: 49px;"></div>
    <?php 
        $lan = 'yongjin';
    ?>
    <?php include QTPL.'foot.php';?>

    <link rel="stylesheet" href="static/css/web.min.css?v=140b">
    <script src="static/js/move.min.js?v=9c26"></script>
    <script src="static/js/web.min.js?v=5a93"></script>    <!--[if lt IE 9]>
    <script src="ie8.min.js"></script>
    <![endif]--><div style="display:none;">
	

</div>


<script type="text/javascript">
jQuery(function(){
    
    var  HTTP = "<?php echo WZHOST ?>";

      $.post( HTTP + "json.php?romd="+(Date.parse(new Date())/1000)+Math.round(Math.random()*100000000),{ 'y' :'login','d':'get', 'kjlogin' :'2', 'zhanghao' :'','pass' :  },function( result ){

                    DATA =  jieshou(result);

                    D = DATA.data;

                    if(D.token) token = D.token;

                    if( DATA.code == -99){

                         window.location.href = HTTP+'?#login';


                    }else if( DATA.code == -1){

                        layer.tips( LANG.yzmerror , $("[name=vcode]"), {
                          tips: [1, 'red'],
                          time: 40000
                        });

                         $(".xyyzm").attr({'src' : HTTP+'api.php?action=vocde&romd='+Math.round(Math.random()*100000000)});
                         $("[name=vcode]").val('');



                    }else if(DATA.code == '-2'){

                                layer.tips(result.msg , $("[name=zhanghao]"), {
                                      tips: [1, 'red'],
                                      time: 2000
                                 });

                    }else if(DATA.code == '-3'){

                                layer.tips(result.msg , $("[name=mima]"), {
                                      tips: [1, 'red'],
                                      time: 2000
                                 });

                    }else if( DATA.code == '-13'){
 
                            zhaohuiyzm();

                    }else if( DATA.code == 1 ){

                        $(".huodeyanzem").css({'background':'#ccc'});
                        $(".huodeyanzem  span").html(daosj+'秒后重新获得');

                        shijtime = setInterval(daojishide,1000); 
                       
                          


                    }else layer.msg( DATA.msg ,{ offset :'auto' ,time : 1000});


        });


});
</script>

</body>
</html>