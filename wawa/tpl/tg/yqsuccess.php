<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$_SESSION['fangreg'] = token();
$_SESSION['code'] = rand(1000,9999);


?>
<html>
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>邀请好友送红包</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
        
</head>
<style>
body {
    font-family: "Hiragino Sans GB","Helvetica Neue";
    color: #262626;
    margin:0;
    padding:0;
  
}
.container {
    overflow: hidden;
}
a, img, button, input, textarea, div, p {
    -webkit-tap-highlight-color: rgba(255,255,255,0);
}
div {
    display: block;
}
a, img, button, input, textarea {
    outline: none;
    border: none;
    background: none;
    -webkit-appearance: none;
}
img {
    width: 100%;
    height: auto;
    border: 0;
    display: block;
    height: auto;
}
#reg .suc_inf {
    height: 1.07rem;
    line-height: 1.07rem;
    font-size: 0.79rem;
    color: #fe3306;
    text-align: center;
}
.red_packets {
    width: 15.82rem;
    height: 5.29rem;
    margin: 1.07rem auto 0;
    display: box;
    display: -webkit-box;
}
.red_packets span {
    width: 11.18rem;
    height: 100%;
    background: url(http://static.1yqba.com/yqba/v3/IOS/images/Invitation_3.png) right 0 no-repeat;
    background-size: auto 100%;
    display: block;
}
.red_packets a {
    height: 100%;
    background: url(http://static.1yqba.com/yqba/v3/IOS/images/Invitation_4.png) 0 0 no-repeat;
    background-size: auto 100%;
    display: block;
    -webkit-box-flex: 1;
    box-flex: 1;
}
#reg .m_m_m {
    margin: 1.14rem 0;
}
#reg .reg_btn {
    margin: 0 1.96rem;
    height: 3.29rem;
    line-height: 3.29rem;
    margin-top: 0.36rem;
    font-size: 1.07rem;
    color: white;
    font-weight: bold;
    text-align: center;
    background: #fc5721;
    border-radius: 0.36rem;
    border-bottom: 0.25rem solid #e44d1c;
    display: block;
}
</style>
<body style="background:#f8f9ff;">
	<div class="container" id="reg" style="padding-bottom: 1.2rem;">
        <img src="http://static.1yqba.com/yqba/v3/IOS/images/Invitation_2.png" alt="">
        <p class="suc_inf">注册成功,豪礼已发放到 182****2870 账户中</p>
        <div class="red_packets">
            <span></span>
            <a class="olink" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.adjuz.yiyuanqiangbao"></a>
        </div>
        <img class="m_m_m" src="http://static.1yqba.com/yqba/v3/IOS/images/Invitation_5.png" alt="">
        <a class="reg_btn olink" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.adjuz.yiyuanqiangbao">立即下载开启抢宝之旅&gt;</a>
    </div>

	</body>
	</html>