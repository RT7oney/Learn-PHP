<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>微信公众号新手引导</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="/wangyi/p/yymobile/1606291913/swiper.min.css">
</head>
<style>
html, body {
    position: relative;
    height: 100%;
}
body {
    background: #eee;
    font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 14px;
    color:#000;
    margin: 0;
    padding: 0;
}
.swiper-container {
    width: 100%;
    height: 100%;
}
.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #f6f6f8;
    overflow: hidden;
}
.swiper-slide img{
    width: 100%;
}
.swiper-slide #btn{


}
.swiper-slide #btn img{
    width: 134px;
}
.swiper-pagination-bullet{
    width: 12px;
    height: 12px;
    background: #a8a8a8;
}
.swiper-pagination-bullet-active {
    opacity: 1;
    background: #ffffff;
}
<?php if(!$SHOUJI){
 
 echo '.swiper-slide img.m{height:100%;width:auto;} ';


}?>
</style>
<body>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img class="m" src="/tpl/tg/img/guide-1.jpg" alt=""/>
        </div>

        <div class="swiper-slide">
            <img class="m"  src="/tpl/tg/img/guide-2.jpg" alt=""/>
        </div>

        <div class="swiper-slide dddd" onclick="window.location.href='<?php echo url('cl');?>';">
            <img class="m  "  src="/tpl/tg/img/guide-3.jpg" alt=""/>
           
             
           
        </div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<script src="/wangyi/p/yymobile/1606291913/zepto.min.js"></script>
<script src="/wangyi/p/yymobile/1606291913/swiper-3.3.1.jquery.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
</script>
</body>
</html>