<?php
require_once("../config/pay_config.php");
echo 'opstate=0';//֧���ɹ�
exit;
/*
$orderid
���й����д�����̻�orderid
*/
$orderid		= $_POST['orderid'];

/*
$opstate
�������״̬��
0 �����ɹ�ʹ��
-1 �����������
-2 ��ʵ����ֵ���ύʱ��ֵ����������ʵ����ֵδʹ�á���ʵ����ֵ��ovalue��ʾ
-3 ��ʵ����ֵ���ύʱ��ֵ����������ʵ����ֵ�ѱ�ʹ�á���ʵ����ֵ��ovalue��ʾ
-4 ���Ѿ�ʹ�ã������ύ����ͨ��֮ǰ�Ѿ���ʹ�ã�
-5 ʧ��(����ԭ�򡢾���ԭ����ȷ��)

*/
$opstate		= $_POST['opstate'];

/*
opstate=-2����-3ʱ��ʾ��ֵ����λԪ(ע����ֻ�ṩ��ȷ�Ŀ�����ʵ����ֵ��������ֵΪ0������Ч��Ϊ�˾�ȷ�ԣ���ֵ���ܴ���4λС��)
*/
//$ovalue			= $_POST['ovalue'];
$ovalue			="100";

/*
�˴ο����Ĺ�������ͨ��ϵͳ�Ķ���Id
*/
$sign		= $_POST['sign'];

$attach		= $_POST['attach'];
/*
�˴ο����Ĺ�������ͨ��ϵͳ�Ķ�������ʱ��
*/
$resulttime		= $_POST['completiontime'];

$sign_text  = "orderid=" . $orderid . "&opstate=" . $opstate . "&ovalue=" . $ovalue;
$sign_md5 	= md5($sign_text .$shunfoo_merchant_key);

if($sign==$sign_md5){
    if($opstate=='0'){
        echo 'opstate=0';//֧���ɹ�
		$con = mysql_connect("localhost","root","root3306");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("wawa", $con);
		mysql_query("set names 'utf8'");
	 	$result2 = mysql_query("select * from ay_user where zhanghao='{$attach}'");
		$row = mysql_fetch_array($result2);
		mysql_query("update ay_user set jine=jine+$ovalue where zhanghao='{$attach}'");
//$sql="INSERT INTO `sp_juejin_payorder` (`id`, `userid`, `ordersn`, `price`, `status`, `createtime`,`paytime`) VALUES(NULL, '1', '$dingdan', '$jin', '1','$shijian','$shijian')";
		//mysql_query("insert into ay_jinelog (id,uid,)");
    } else {
        echo 'opstate=0';//֧��ʧ��
    }
} else {
    echo 'opstate=0';//sign��֤ʧ��
}
?>