<?php if(!defined('ONGPHP'))exit('ErrorONGSOFT');
plus(array('p','jiami','jianli','mima','shanchu','qcurl','qfopen','x','memcc','txtcc','db','isutf8','setsession','pagec','pinyin','ip','post','funciton','tcpcc','mongodbcc','vcode','ipdiqu','update','route','sslget','sslpost'));

$Memsession =  $Mem = new txtcc();



$LANG = include QTLANG;
$IP = ip();


$Mem1 = new txtcc(ONGPHP.'/mode/');
$shezhi = $Mem1 -> g('shezhi');

setsession( $CONN['sessiontime'] );

$appid = $shezhi['appid'];
$appsecret = $shezhi['appsecret'];



$action = isset($_GET['action']) ? $_GET['action'] :'index';
if ($action=='reg') {

  include QTPL.'reg.php';

}elseif ($action=='login') {

  include QTPL.'login.php';

}elseif ($action=='yongjin') {

  include QTPL.'yongjin.php';

}elseif ($action=='paihangbang') {
  include QTPL.'paihangbang.php';
}elseif ($action=='ajax') {
   include QTPL.'ajax.php';
}elseif ($action=='zhuanqian') {
    
    include QTPL.'zhuanqian.php';

}elseif ($action=='tixian') {
  include QTPL.'tixian.php';
}
