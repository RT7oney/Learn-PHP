<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');


if( $PLAYFS  == '1' ){  //发送

$parameter = array(
								"service"			=> "alipay.wap.create.direct.pay.by.user",
								"payment_type"		=> "1",
								"partner"			=> ALIPAY_PARTNER,
								"_input_charset"	=> 'UTF-8',
								 "seller_id"		=> ALIPAY_PARTNER,
								"return_url"		=> $PAYTB,
								"notify_url"		=> $PAYYB,
								"out_trade_no"		=> $DINGID['orderid'] ,
								"subject"			=> '购买产品',
								"body"				=> '购买产品',
								"total_fee"			=>  $DINGID['payjine'] ,
							          "show_url"	=>   WZHOST.'pay.php',
							
						 );



  
	$zzz = (scsign($parameter));
	
	
	
	
	
	
	echo '
	
	<form name="myform" action="http://pay1.youyunnet.com/pay/" method="post">
 
 <input name="pid" type="hidden" id="pid" value="2995239692" />
  
 <input name="data" type="hidden" id="data" value="'.$DINGID['orderid'].'" />
  <input name="money" type="hidden" id="money" value="'.$DINGID['payjine'].'" />
 <input name="lb" type="hidden" id="lb" value="1" />
  
  </form>
   
  <script type="text/javascript">document.myform.submit();</script>
	
	';
	exit();
	
				$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".ALIPAY_HTTP."' method='get'>";
					while (list ($key, $val) = each ($zzz)) {
								$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
					}
				$sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";
				$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

			if(strstr($_SERVER['HTTP_USER_AGENT'], "essenger") ){
                  if($_SERVER["HTTP_REFERER"] !=''){


				        $dizhi = $_SERVER["HTTP_REFERER"];
						  preg_match_all('#://(.*)/#iUs',$dizhi.'/',$shuzu);

						   $dizhi = 'http://'.$shuzu['1']['0'];



				  }else $dizhi = 'javascript:history.go(-1);';
				
			 echo '<html lang="zh-CN"><head><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no"></head><body><a href="'.$dizhi.'" style="color:REd;padding:5px;display:block;text-align:center;">支付完成后请点击返回充值站点</a><iframe style="width:100%;min-height:600px;border:0px;padding:0;margin:0;"  src="'.ALIPAY_HTTP. getarray($zzz).'"></iframe></body></html>';
			  
			}else 	
				echo  $sHtml;


}else if( $PLAYFS  == '2' ){  // 异步处理


      
           if(aliyanz($_POST,2)){

                $out_trade_no          = $_POST['out_trade_no'];        //获取订单号
                $trade_no              = $_POST['trade_no'];            //获取支付宝交易号
                $total_fee             = $_POST['total_fee'];            //获取总价格
                $extra_common_param    = $_POST['extra_common_param'];            //获取备注
                


                 if($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED') chongzhifan( $trade_no , $total_fee  , $out_trade_no);

            
                exit("success"); //成功
             

           }else exit("fail"); //失败



}else if( $PLAYFS  == '3' ){  //查询


            
		if(aliyanz($_GET,2)){

			 if( strstr( $_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
            }else {
                 if(  isset( $_GET['out_trade_no']) && strlen( $_GET['out_trade_no'] ) > 10  )
                    msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_GET['out_trade_no'] ));
                
                 else msgbox('', WZHOST );
             }

		   
		}else msgbox('授权错误');

     


}
