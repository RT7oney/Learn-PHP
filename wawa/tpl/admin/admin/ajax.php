<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');
$action = isset($_POST['action']) ? $_POST['action'] :'';
// 获取get参数
$getac = isset($_GET['upload']) ? $_GET['upload'] :'';



/***************************************************************
	处理上传
****************************************************************/
if($getac=='yes'){

	   if( isset($_GET['uplx']) ){	
		
                     			$_GET['uplx'] = isset($_GET['uplx'])?$_GET['uplx']:'image';

                     // 上传图片	

	                 			$DATAS = update($USER['id']);
					 if(  $DATAS['code'] == 1 ) {

					 	exit( json_encode( array('error' => 0 , 'url' =>  $DATAS['content']['pic'] )  ));
					 }else{

					 	exit( json_encode( array('error' => 1 , 'message' =>  $DATAS['msg']) ));

					 } 

	    }
}


if ($action=='tixianshenhe') {	/*提现审核*/

	$D = db('');
	$zhi = isset($_POST['zhi']) ? $_POST['zhi'] :'';

	$tixian = $D ->setbiao('tixian')-> where( array( "id" => $zhi ) ) -> find();
	$type = $tixian['type'];

	if ($tixian['off']==0 ) {	/*如果没有审核过*/
			
		$tixianjine = $tixian['jine'];

		if ($tixian['uid']!='') {
			$user = $D ->setbiao('user')-> where( array( "uid" => $tixian['uid'] ) ) -> find();
			$yuer = $user['jine'];
					
				// if ($type==1) {
				// 	$shu = '提现金额';
				// }elseif ($type==2) {
				// 	$shu = '佣金提现';
				// }
				

			$ip = ip();
			/*处理减钱*/
			// $qian = jiaqian( $tixian['uid'] , $TYPE = 6 , $JINE = -(float)$tixianjine,$JIFEN = 0 , $HUOBI = 0  , $DATA = $shu , $ip = $ip);

			$fan = $D ->setbiao('tixian')->where( array("id"=>$zhi)) -> update(array(
				'off' => 1
				));

			if ($fan) {
				$arr['o'] ='yes';
			}else{

				
				$arr['o'] = 'no';
			}
		
		}

	}else{
		$arr['o'] ='已经提现了';
	}
	
	echo json_encode($arr);

}elseif ( $action=='shezhiwawa' ) {	/*设置抓娃娃*/
	
	$data = isset($_POST['data']) ? $_POST['data'] :'';

	$Mem1->s('shezhi',$data);

	$arr['o'] ='yes';

	echo json_encode($arr);


}elseif ($action=='genggaijine') {	/*更改价格*/

	$D = db('');

	$zhi = isset($_POST['zhi']) ? $_POST['zhi'] :'';
	$jine = isset($_POST['jine']) ? $_POST['jine'] :'';
	$jine = sprintf("%0.2f",$jine);

	if ($jine>0) {
		$TYPE = 1;
	}else{
		$TYPE = 0;
	}

	/*加钱*/
	$jiaqian = jiaqian( $zhi , $TYPE = $TYPE , $JINE = $jine,$JIFEN = 0 , $HUOBI = 0  , $DATA = '管理员更改金额' , $ip = '');

	if ($jiaqian) {
		$arr['o'] ='yes';
	}else{
		$arr['o'] ='no';
	}


	$arr['o'] ='yes';

	echo json_encode($arr);
}


?>