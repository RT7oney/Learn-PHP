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



if ($action=='zhongjiang') {	/*中奖*/

	$shezhi = $Mem1->g('shezhi');

	$D = db('');

	$zhongjiangcode = isset($_POST['zhongjiangcode']) ? $_POST['zhongjiangcode'] :'';
	$chang  = isset($_POST['chang']) ? $_POST['chang'] :'';/**/


	if ($zhongjiangcode==-1) {	/*判断有没有抓取成功*/

		/*首先查询用户的余钱*/
		$user = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['uid'] ) ) -> find();
		$yuer = $user['jine'];
		

		if ($chang=='500') {/*5元场*/

			$qian = '5';
			$jianqian = -(float)$qian;
		
		}elseif ($chang=='1000') {/*10元场*/

			$qian = '10';
			$jianqian = -(float)$qian;

		}elseif ($chang=='2000') {

			$qian = '20';
			$jianqian = -(float)$qian;

		}


		/*比较大小*/
		if ( (float)$yuer >= (float)$qian ) {
			/*先处理减钱*/
			$jianqian = -(float)$qian;
			$jianjian = jiaqian1( $_SESSION['uid'] , $TYPE = 3 , $JINE = $jianqian , $JIFEN = 0 , $HUOBI = 0  , $DATA = '' , $ip = '');
			$jiage = 0;
			$arr['o'] ='yes';
			$arr['jiage'] = '0';
		}else{
			$arr['o'] ='余钱不足';
			$arr['jiage'] = '0';

		}

	}else{
		



		if ($chang=='500') {/*5元场*/

			$qian = '5';

			/*判断用户第几次抓娃娃*/
			$order = '  ';
			$jilu = $D ->setbiao('wawa')->order(  )->where( array(
				'uid' => $_SESSION['uid']
				) )-> select();

			if (is_array($jilu)) {/*已经抓取过娃娃了*/

				$jiangchi = explode(',', $shezhi['5yuan2']);
				$num = count($jiangchi);
				$suiji = rand(0,$num-1);
				$suijiqian = $jiangchi[$suiji];
				$suijiqian = sprintf("%0.2f",$suijiqian);

			}else{/*没有抓取过娃娃,获取随机的奖池中的钱*/
				
				$jiangchi = explode(',', $shezhi['5yuan']);
				$num = count($jiangchi);
				$suiji = rand(0,$num-1);
				$suijiqian = $jiangchi[$suiji];
				$suijiqian = sprintf("%0.2f",$suijiqian);
			}



		}elseif ($chang=='1000') {/*10元场*/

			$qian = '10';

			/*判断用户第几次抓娃娃*/
			$order = '  ';
			$jilu = $D ->setbiao('wawa')->order(  )->where( array(
				'uid' => $_SESSION['uid']
				) )-> select();

			if (is_array($jilu)) {/*已经抓取过娃娃了*/

				$jiangchi = explode(',', $shezhi['10yuan2']);
				$num = count($jiangchi);
				$suiji = rand(0,$num-1);
				$suijiqian = $jiangchi[$suiji];
				$suijiqian = sprintf("%0.2f",$suijiqian);

			}else{/*没有抓取过娃娃,获取随机的奖池中的钱*/

				$jiangchi = explode(',', $shezhi['10yuan']);
				$num = count($jiangchi);
				$suiji = rand(0,$num-1);
				$suijiqian = $jiangchi[$suiji];
				$suijiqian = sprintf("%0.2f",$suijiqian);

			}

		}elseif ($chang=='2000') {/*20元场*/
			$qian = '20';

			/*判断用户第几次抓娃娃*/
			$order = '  ';
			$jilu = $D ->setbiao('wawa')->order(  )->where( array(
				'uid' => $_SESSION['uid']
				) )-> select();

			if (is_array($jilu)) {/*已经抓取过娃娃了*/

				$jiangchi = explode(',', $shezhi['20yuan2']);
				$num = count($jiangchi);
				$suiji = rand(0,$num-1);
				$suijiqian = $jiangchi[$suiji];
				$suijiqian = sprintf("%0.2f",$suijiqian);

			}else{/*没有抓取过娃娃,获取随机的奖池中的钱*/
				
				$jiangchi = explode(',', $shezhi['20yuan']);
				$num = count($jiangchi);
				$suiji = rand(0,$num-1);
				$suijiqian = $jiangchi[$suiji];
				$suijiqian = sprintf("%0.2f",$suijiqian);

			}

		}

		/*首先查询用户的余钱*/
		$user = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['uid'] ) ) -> find();
		$yuer = $user['jine'];

		/*比较大小*/
		if ( (float)$yuer >= (float)$qian ) {

			/*先处理减钱*/
			$jianqian = -(float)$qian;
			$jianjian = jiaqian1( $_SESSION['uid'] , $TYPE = 3 , $JINE = $jianqian , $JIFEN = 0 , $HUOBI = 0  , $DATA = '' , $ip = '');

			/*然后再加钱*/
			if ($jianjian) {

				/*获取佣金比例*/
				$aji = isset($shezhi['1ji']) ? $shezhi['1ji'] :'0';
				$bji = isset($shezhi['2ji']) ? $shezhi['2ji'] :'0';
				$cji = isset($shezhi['3ji']) ? $shezhi['3ji'] :'0';
				$bili = isset($shezhi['bili'])?$shezhi['bili']:'0';

				/**/
				$jiaqian = jiaqian1( $_SESSION['uid'] , $TYPE = 4 , $JINE = $suijiqian,$JIFEN = 0 , $HUOBI = 0  , $DATA = '' , $ip = '');

				if ($jiaqian) {
					
					/*这里考虑到三级分销*/
					/*获取一级分销会员*/
					$tuid = $user['tuid'];
					if ( $tuid>0 ) {	/*说明存在一级会员*/
						/*查询一级会员是否存在*/
						$tui0 = $D ->setbiao('user')-> where( array( "uid" => $tuid ) ) -> find();
						
						if ($tui0) {	/*如果存在的话*/

							$yonghuo = ( (float)$aji/100 ) * (float)$suijiqian;
							$yonghuo = sprintf("%0.2f",$yonghuo);


							// $yong = $yonghuo/$bili;

							$shuzu = array(
								'xiaofeiid' => $_SESSION['uid'],
								'dedaouid' => $tui0['uid'],
								'guanxi' => 1,
								'deqian' => $suijiqian,
								);

							$shuzustr = serialize($shuzu);

							$jianjian1 = jiaqian1( $tui0['uid'] , $TYPE = 2 , $JINE = 0 , $JIFEN = 0 , $HUOBI = $yonghuo  , $DATA = $shuzustr , $ip = ip() );

						}

					}

					$tuid1 = $user['tuid1'];
					if ($tuid1>0) {	/*二级*/

						/*查询一级会员是否存在*/
						$tui1 = $D ->setbiao('user')-> where( array( "uid" => $tuid1 ) ) -> find();
						
						if ($tui1) {	/*如果存在的话*/

							$yonghuo = ( (float)$bji/100 ) * (float)$suijiqian;
							$yonghuo = sprintf("%0.2f",$yonghuo);

							// $yong = $yonghuo/$bili;

							$shuzu = array(
								'xiaofeiid' => $_SESSION['uid'],
								'dedaouid' => $tui1['uid'],
								'guanxi' => 2,
								'deqian' => $suijiqian, 
								);

							$shuzustr = serialize($shuzu);

							$jianjian1 = jiaqian1( $tui1['uid'] , $TYPE = 2 , $JINE = 0 , $JIFEN = 0 , $HUOBI = $yonghuo  , $DATA = $shuzustr, $ip = ip() );

						}

					}

					$tuid2 = $user['tuid2'];
					if ($tuid2>0) {

						/*查询一级会员是否存在*/
						$tui2 = $D ->setbiao('user')-> where( array( "uid" => $tuid2 ) ) -> find();
						
						if ($tui2) {	/*如果存在的话*/

							$yonghuo = ( (float)$cji/100 ) * (float)$suijiqian;
							$yonghuo = sprintf("%0.2f",$yonghuo);
							// $yong = $yonghuo/$bili;


							$shuzu = array(
								'xiaofeiid' => $_SESSION['uid'],
								'dedaouid' => $tui2['uid'],
								'guanxi' => 3,
								'deqian' => $suijiqian,
								);

							$shuzustr = serialize($shuzu);

							$jianjian1 = jiaqian1( $tui1['uid'] , $TYPE = 2 , $JINE = 0 , $JIFEN = 0 , $HUOBI = $yonghuo  , $DATA = $shuzustr , $ip = ip() );
						}

					}

					/*夹娃娃入单*/
					// 当没有的时候，插入数据到表里
					$fanhui = $D->setbiao('wawa')-> insert(array(
						'uid' => $_SESSION['uid'],
						'lx' => $qian,
						'dedao' => $suijiqian,
						'atime' => time(),
						));
					$arr['o'] ='yes';
					$arr['jiage'] = $suijiqian;

				}

			}

			


		}else{
			$arr['o'] ='没钱了';

		}


	}


echo json_encode($arr);

}elseif ($action=='tixian') {

	$shezhi = $Mem1->g('shezhi');
	$bili = $shezhi['bili'];

	$D = db('');

	/*赋值*/
	$fs = isset($_POST['fs']) ? $_POST['fs'] :'';
	$jine = isset($_POST['jine']) ? $_POST['jine'] :'';
	$name = isset($_POST['name']) ? $_POST['name'] :'';
	$zhanghao = isset($_POST['zhanghao']) ? $_POST['zhanghao'] :'';
	$canshu = isset($_POST['canshu']) ? $_POST['canshu'] :'';

	/*判断参数*/
	if ($canshu=='xianjin') {

		$type  ='1';

		/*首先查询会员的金额*/
		$user = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['uid'] ) ) -> find();

		$yuer = $user['jine'];

		/*判断余额*/
		if ((float)$yuer >=(float)$jine ) {

			/*判断金钱*/
			if ($jine>0) {
				

				$xinqian = (float)$yuer - (float)$jine;
				$xinqian = sprintf("%0.2f",$xinqian);
				$jine = sprintf("%0.2f",$jine);

				$sql = '';
				$sql .= $D->setshiwu('1')->setbiao('tixian')-> insert(array(
					'fs' => $fs,
					'name' => $name,
					'zhanghao' => $zhanghao,
					'atime' => time(),
					'jine' => $jine,
					'ip' => ip(),
					'type' => $type,
					'uid' => $_SESSION['uid'],
					));

				$fanhui = $D ->qurey( $sql , 'shiwu');

				if ($fanhui) {
					
					/*处理减钱*/
					$qian = jiaqian1( $_SESSION['uid'] , $TYPE = 6 , $JINE = -(float)$jine,$JIFEN = 0 , $HUOBI = 0  , $DATA = '提现金额' , $ip = ip());

					$arr['o'] ='yes';
				}else{
					$arr['o'] ='no';
				}

			}else{
				$arr['o'] ='no';
			}

		}else{

			$arr['o'] = '余额不足';

		}


	}else if ($canshu=='yongjin') {/*佣金提现*/

		$type  ='2';

		$user = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['uid'] ) ) -> find();
		$huobi = $user['huobi'];
		if ( (float)$huobi >=(float)$jine ) {/*如果佣金大于提现金额的话*/
			/*计算提现金额*/

			// $jine = (float)$bili * (float)$jine;/*计算金额*/

			$jine = sprintf("%0.2f",$jine);

			$xianhuobi = (float)$huobi - (float)$jine;
			$xianhuobi = sprintf("%0.2f",$xianhuobi);

			$sql='';

			$sql.= $D->setshiwu('1')->setbiao('tixian')-> insert(array(
					'fs' => $fs,
					'name' => $name,
					'zhanghao' => $zhanghao,
					'atime' => time(),
					'jine' => $jine,
					'ip' => ip(),
					'type' => $type,
					'uid' => $_SESSION['uid'],
					));

			$fanhui = $D ->qurey( $sql , 'shiwu');

			if ($fanhui) {
				/*处理减钱*/
				$qian = jiaqian1( $_SESSION['uid'] , $TYPE = 6 , $JINE = 0 ,$JIFEN = 0 , $HUOBI = -(float)$jine  , $DATA = '佣金提现' , $ip = ip());
				$arr['o'] ='yes';
			}else{
				$arr['o'] ='no';
			}


		}else{
			$arr['o'] ='提现佣金大于拥有佣金';
		}
	}
	echo json_encode($arr);

}elseif ($action=='login') {


	$D = db('');
	$name = isset($_POST['name']) ? $_POST['name'] :'';
	$mima = isset($_POST['mima']) ? $_POST['mima'] :'';

	$user = $D -> setbiao('user') -> where( 
		array( 
			"zhanghao" => $name, 
		) 
	) -> find();


	if ($user) {
		
		$mima = mima($mima);
		if ($user['mima']  == $mima ) {
			
			$_SESSION['uid'] = $user['uid'];
			$arr['o'] ='yes';

		}else{
			$arr['o'] ='密码错误';
		}

	}else{
		$arr['o'] ='没有此账号';

	}

	echo json_encode($arr);


}elseif ($action=='reg') {
		


	$D = db('');
	$name = isset($_POST['name']) ? $_POST['name'] :'';
	$mima = isset($_POST['mima']) ? $_POST['mima'] :'';

	$user = $D -> setbiao('user') -> where( 
		array( 
			"zhanghao" => $name, 
		) 
	) -> find();


	if ($user) {
		
		$arr['o'] = '此账号已经存在';

	}else{

		$WHERE['zhanghao'] = $name;
		$WHERE['name'] = $name;
		$WHERE['mima'] = mima($mima);
		$WHERE['atime'] = time();
		$WHERE['off'] = 1;
		

		 if( isset( $_SESSION['tuid'] ) ){

		                        if( $_SESSION['tuid']  > 0){

		                            $tui = $D ->setbiao('user')-> where( array( "uid" => $_SESSION['tuid'] ) ) -> find();

		                            if( $tui ){

		                                    $WHERE['tuid'] = $_SESSION['tuid'];

		                                    for( $i = 1 ; $i < $CONN['tujishu'] ; $i++ ){

		                                         $wds = $i-1;
		                                         if($wds < 1) $wds= '' ;
		                                         $WHERE['tuid'.$i] = $tui['tuid'.$wds];

		                                    }
		                            }
		                        }

	            }


		// 当没有的时候，插入数据到表里
		$fanhui = $D-> setbiao('user')-> insert($WHERE);

		if ($fanhui) {
			$arr['o'] ='yes';
		}else{
			$arr['o'] ='no';
		}


	}


	echo json_encode($arr);

}elseif ($action=='getshuju') {	/*获取数据*/
	$arr = array();

	if ($shezhi['istanzuobi']=='1') {	/*如果弹窗作弊的话*/


		$tanchuang = $shezhi['tanchuang'];

		$num = count($tanchuang);
		$suiji = mt_rand(0,$num-1);
		$suijistr = $tanchuang[$suiji];


		$arr['sss'] = $suijistr;

		$arr['zuobi'] = '1';
	}else{
		$D = db('');

		$order = ' dedao desc ';
		$wawas = $D -> setbiao('wawa') -> order( $order )->where( 
			array(
				
			)
		)-> limit('1000') -> select();

		$num = count($wawas);
		$suiji = mt_rand(0,$num-1);
		$suijiuid = $wawas[$suiji]['uid'];

		/*查询娃娃*/
		$wawa = $D -> setbiao('wawa') -> where( 
			array( 
				'uid' => $suijiuid,
			) 
		) ->limit('0,1')-> find();

		$uid = $wawa['uid'];

		/*查询会员*/
		$huiyuan = $D -> setbiao('user') -> where( 
			array( 
				"uid" => $uid, 
			) 
		) -> find();

		if ($huiyuan) {
			$arr['name'] = $huiyuan['name'];
			$arr['jine'] = $wawa['dedao'];
			$arr['zuobi'] = '0';
			$arr['o'] ='yes';
		}

		

	}


	echo json_encode($arr);

}elseif ($action=='out') {

	session_destroy();
	$arr['o'] ='yes';
	echo json_encode($arr);

}





?>