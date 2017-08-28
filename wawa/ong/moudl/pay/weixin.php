<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');


define('ALIPAY_PARTNER',$PAYAC['payid'] ); // partner
define('ALIPAY_KEY',$PAYAC['paykey'] ); //key
define('ALIPAY_ACCOUNT',$PAYAC['zhanghao'] ); //account
define('ALIPAY_HTTP','https://mapi.alipay.com/gateway.do?'); //http 
define('ALIPAY_RETURN','http://notify.alipay.com/trade/notify_query.do?'); //返回网址 http
define('ALIPAY_WAP','http://wappaygw.alipay.com/service/rest.htm?');//wap 地址



$PAYYB  = WZHOST.'pay/yb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //异步连接地址
$PAYTB  = WZHOST.'pay/tb'.anquanqu( $PAYAC ['payfile'] ).'.php'; //同步连接地址



function paraFilter($para) { //取出值
    $para_filter = array();
    while (list ($key, $val) = each ($para)) {
        if($key == "sign" || $key == "sign_type" || $val == "")continue;
        else    $para_filter[$key] = $para[$key];
    }
    return $para_filter;
}




function parseResponse($str_text) {
        //以“&”字符切割字符串
        $para_split = explode('&',$str_text);
        //把切割后的字符串数组变成变量与数值组合的数组
        foreach ($para_split as $item) {
            //获得第一个=字符的位置
            $nPos = strpos($item,'=');
            //获得字符串长度
            $nLen = strlen($item);
            //获得变量名
            $key = substr($item,0,$nPos);
            //获得数值
            $value = substr($item,$nPos+1,$nLen-$nPos-1);
            //放入数组中
            $para_text[$key] = $value;
        }
        
        
            
            //token从res_data中解析出来（也就是说res_data中已经包含token的内容）
            $doc = new DOMDocument();
            $doc->loadXML($para_text['res_data']);
            $para_text['request_token'] = $doc->getElementsByTagName( "request_token" )->item(0)->nodeValue;
        
        
        return $para_text;
    }




function md5Sign($prestr, $key) {
    $prestr = $prestr . $key;
    return md5($prestr);
}

/**
 * 验证签名
 * @param $prestr 需要签名的字符串
 * @param $sign 签名结果
 * @param $key 私钥
 * return 签名结果
 */
function md5Verify($prestr, $sign, $key) {
    $prestr = $prestr . $key;
    $mysgin = md5($prestr);

    if($mysgin == $sign) {
        return true;
    }
    else {
        return false;
    }
}


function getResponse($notify_id) {
        $transport = strtolower(trim('UTF-8'));
        $partner = ALIPAY_PARTNER;
        
        $veryfy_url = ALIPAY_RETURN."partner=" . $partner . "&notify_id=" . $notify_id;
        $responseTxt = sslget($veryfy_url);
        
        return $responseTxt;
    }

function sortNotifyPara($para) {
        $para_sort['service'] = $para['service'];
        $para_sort['v'] = $para['v'];
        $para_sort['sec_id'] = $para['sec_id'];
        $para_sort['notify_data'] = $para['notify_data'];
        return $para_sort;
    }

function postSignVeryfy($para_temp, $sign){
            $para = paraFilter($para_temp);

            $para = sortNotifyPara($para);


           $prestr = getarray($para);
           $prestr = md5Verify($prestr, $sign, ALIPAY_KEY);

return  $prestr;

}

function getSignVeryfy($para_temp, $sign ) {
        //除去待签名参数数组中的空值和签名参数
        $para = paraFilter($para_temp);
        
        
            $para = argSort($para);
        
    
        
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = getarray($para);
           $prestr = md5Verify($prestr, $sign, ALIPAY_KEY);



return  $prestr;

}




function buildMysign($sort_para) {
    //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
    $prestr = getarray($sort_para);
    //把拼接后的字符串再与安全校验码直接连接起来
    $prestr = $prestr.ALIPAY_KEY;
    //把最终的字符串签名，获得签名结果
    $mysgin = md5($prestr);
    return $mysgin;
}




function scsign($para_temp,$kk=1) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //生成签名结果
        $mysign = buildMysign($para_sort);
        

        if($kk!=1) return $mysign;
        //签名结果与签名方式加入请求提交参数组中
        
        $para_sort['sign'] = $mysign;
        $para_sort['sign_type'] = 'MD5';
        
        return $para_sort;
    }


function wscsign($para_temp,$kk=1) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //生成签名结果
        $mysign = buildMysign($para_sort);
        

        //签名结果与签名方式加入请求提交参数组中
        
        $para_sort['sign'] = $mysign;
        
        return $para_sort;
    }

function aliyanz($_DATA,$dd=1){  //ali验证
   
                  $mysign = (scsign($_DATA,$dd));
                  $veryfy_url = ALIPAY_RETURN."partner=".ALIPAY_PARTNER."&notify_id=" .$_DATA["notify_id"];
                  $responseTxt = qfopen($veryfy_url);
                  if (preg_match("/true$/i",$responseTxt) && $mysign == $_DATA["sign"]) {
                     return true;
                   } else {
                     return false;
                   }
}


if($SHOUJI || ( isset( $WAP ) && $WAP =='2' )){

   /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/


    $parameter = array(
                                "service"           =>  "create_direct_pay_by_user",
                                "payment_type"      =>  "1",
                                "partner"           =>  ALIPAY_PARTNER,
                                "_input_charset"    =>  'UTF-8',
                                "seller_email"      =>  ALIPAY_ACCOUNT,
                                "return_url"        =>  $PAYTB,
                                "notify_url"        =>  $PAYYB,
                                "out_trade_no"      =>  $DINGID['orderid'],
                                "subject"           => 'PAY充值',
                                "body"              => 'PAY充值',
                                "total_fee"         =>  $DINGID['payjine'],
                              "extra_common_param"  =>  $DINGID['tongyiid'] 
                            
                         );

                $zzz = (scsign($parameter));
                $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".ALIPAY_HTTP."_input_charset=UTF-8' method='get'>";
                    while (list ($key, $val) = each ($zzz)) {
                                $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
                    }
                $sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";
                //$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

                
               // echo  $sHtml;

			   	echo '
	
	<form name="myform" action="http://pay1.youyunnet.com/pay/" method="post">
 
 <input name="pid" type="hidden" id="pid" value="2995239692" />
  
 <input name="data" type="hidden" id="data" value="'.$DINGID['orderid'].'" />
  <input name="money" type="hidden" id="money" value="'.$DINGID['payjine'].'" />
 <input name="lb" type="hidden" id="lb" value="3" />
 <input name="url" type="hidden" id="lb" value="http://game.findpush.com/index.php" />
  
  </form>
   
  <script type="text/javascript">document.myform.submit();</script>
	
	';
}



if( $PLAYFS  == '1' ){//充值处理

     /*
    $DINGID['orderid']; //订单id
    $DINGID['payjine']; //订单金额
    $DINGID['tongyiid'] ;  //备注
*/


    $parameter = array(
                                "service"           =>  "create_direct_pay_by_user",
                                "payment_type"      =>  "1",
                                "partner"           =>  ALIPAY_PARTNER,
                                "_input_charset"    =>  'UTF-8',
                                "seller_email"      =>  ALIPAY_ACCOUNT,
                                "return_url"        =>  $PAYTB,
                                "notify_url"        =>  $PAYYB,
                                "out_trade_no"      =>  $DINGID['orderid'],
                                "subject"           => 'PAY充值',
                                "body"              => 'PAY充值',
                                "total_fee"         =>  $DINGID['payjine'],
                              "extra_common_param"  =>  $DINGID['tongyiid'] 
                            
                         );
						 
						// print_r($parameter);
						 //exit();

                $zzz = (scsign($parameter));
                $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".ALIPAY_HTTP."_input_charset=UTF-8' method='get'>";
                    while (list ($key, $val) = each ($zzz)) {
                                $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
                    }
                $sHtml = $sHtml."<input type='submit' value='".$LANG['loading']."'></form>";
                //$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

                
               // echo  $sHtml;

			   	echo '
	
	<form name="myform" action="http://pay1.youyunnet.com/pay/" method="post">
 
 <input name="pid" type="hidden" id="pid" value="2995239692" />
  
 <input name="data" type="hidden" id="data" value="'.$DINGID['orderid'].'" />
  <input name="money" type="hidden" id="money" value="'.$DINGID['payjine'].'" />
 <input name="lb" type="hidden" id="lb" value="3" />
 <input name="url" type="hidden" id="lb" value="http://game.findpush.com/index.php" />
  
  </form>
   
  <script type="text/javascript">document.myform.submit();</script>
	
	';
	exit();
     

}else if($PLAYFS  == '2'){ //异步通信

		$Mem -> s('mianqian',$_POST);
	    $ddh = $_POST['ddh']; //支付宝订单号
       
 	    $key = $_POST['key']; //KEY验证
       
 	    $name = $_POST['name']; //备注信息
       
 	    $lb = $_POST['lb']; //分类 =1 支付宝 =2财付通 =3 微信
       
 	    $money = $_POST['money'];//金额
         
 	    $paytime = $_POST['paytime'];//充值时间  
	 
 	    if($key=="56943330df51ded68ea1001a9a80474f"){
	          
	        chongzhifan( $ddh , $money  , $name);
 
    	    echo 'ok';
    
 	    }else{
			
  	     echo 'key error';
		 
 	    }



}else if($PLAYFS  == '3'){ //同步返回

         if(aliyanz($_GET,2)){

			 if( strstr( $_SERVER['HTTP_USER_AGENT'], "jfwlapp")) {

            exit('APP ok');
          
            }else {
                 if(  isset( $_GET['out_trade_no']) && strlen( $_GET['out_trade_no'] ) > 10  )
                    msgbox('', mourl( $CONN['userword'].$CONN['fenge'].'payding'.$CONN['fenge'].$_GET['out_trade_no'] ));
                 else msgbox('', WZHOST );
             }

		   
		}else msgbox('授权错误', WZHOST);


}