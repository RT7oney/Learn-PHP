<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$VCODETOKEN = $LANG['wxinapptoken'];

function checkSignature( $VCODETOKEN  ){

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $token     = $VCODETOKEN;
        $tmpArr    = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ) return true;
        else  return false;
}


if( ! checkSignature( $VCODETOKEN  ) ) exit('no');


$WZHOST = WZHOST;

$TIAOURL = isset($_SESSION['back']) && $_SESSION['back'] != '' ? $_SESSION['back'] : WZHOST;

$raw_post_data = file_get_contents( 'php://input' , 'r' ); 
$raw_post_data = $raw_post_data ? $raw_post_data : $GLOBALS['HTTP_RAW_POST_DATA'] ;


if( $raw_post_data ){

    $xml = $raw_post_data;
    $p   = xml_parser_create();
    xml_parse_into_struct($p, $xml, $vals, $index);
    xml_parser_free( $p );

    if( $vals ){

        $shuju = array();
        foreach( $vals as $zhis) $shuju[ strtolower( $zhis['tag'] ) ] = isset( $zhis['value']) ? $zhis['value'] :'';
        unset( $shuju['xml'] );

        

	       

	    if( $shuju['msgtype'] == 'image'){

		//图片接受自动回复

	    }else if( $shuju['msgtype'] == 'text'){


		    //content

            
            if( $LANG['wenzihuifu'] ){

                $jieneiro = $shuju['content'];

                foreach( $LANG['wenzihuifu'] as $ong){

                    if($ong['关键词'] == '' || $ong['回复内容'] == '') continue;
                    if( strstr( $jieneiro , $ong['关键词'] ) ){
                        weixint($shuju['fromusername'],$ong['回复内容'] );
						exit();
                        break;
                    }
                }

            }


		$shuzudd = array('8f639eda6c9b4cdba44b9c9ef352614e','842d2ea7312447d5a5d27cf8c5c89fd7','5035e1ba4f9c4493a83062e9f0be6c38');

		

         $fan =qfopen( 'http://www.tuling123.com/openapi/api?key='.$shuzudd[rand(0,2)].'&info='.$jieneiro ,'utf-8');

          $canshu = (array)json_decode($fan);
          if($canshu['code'] == '100000'){

			   weixint($shuju['fromusername'],$canshu['text'] );
		  
		  
		  
		  }


		
	   
	   
	   }else if( $shuju['msgtype'] == 'event'){ 
           
           
            if(  $shuju['event'] == 'subscribe'  ){



				$tuid = str_replace('qrscene_','', $shuju['eventkey']);

				if( $LANG['guanzhuhuifu'] != '' ){


					weixint( $shuju['fromusername'] , $LANG['guanzhuhuifu']);
				
				}


				if( $tuid > 0){
				

				    $access_token =  $Mem ->g('access_token');

					$openid = $shuju['fromusername'];
        
                    if( !$access_token ){

                        $csass = sslget('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$LANG['kjwxid'].'&secret='.$LANG['kjwxkey']);
                          $woqi = (array)json_decode($csass);
                          $access_token = $woqi['access_token'];
                          if( strlen( $access_token )< 10 )return false;
                          $Mem ->s('access_token',$access_token ,'3600');
                    }


                    $dddss =  sslget('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN');

                    if( $dddss ){

				        $ddddd = $woqi = ( array ) json_decode( $dddss );
                        if( isset( $woqi['unionid']) &&  $woqi['unionid'] != '' )  $unopid = $woqi['unionid'];

                        $xinminz =  anquanqu($ddddd['nickname']);
                        $tx = $ddddd['headimgurl'];
                        if($xinminz =='') $xinminz = 'WX'.mima($openid);
			            $_SESSION['tuid'] = $tuid;
                        
                        $_SESSION['tourist'] = array(   'lx' => 2 ,
                                           'uid' =>  $openid ,
                                          'name' => $xinminz,
                                            'tx' => $tx,
                                       'unionid' => $unopid,
				                );

			            if( $CONN['kjreg'] ==  1 ){

                            $uindd = isset( $_SESSION['tourist']['unionid']) && $_SESSION['tourist']['unionid'] != '' ? $_SESSION['tourist']['unionid'] : '' ;

                            $kuaijie = kjreg($_SESSION['tourist']['lx'] , $_SESSION['tourist']['uid']  , $_SESSION['tourist']['name']  , $_SESSION['tourist']['tx'], $uindd );

                            if( $kuaijie ){

                                $USER = kjcha( $_SESSION['tourist']['lx'] , $_SESSION['tourist']['uid'] ,$uindd );
                                unset( $_SESSION['tourist'] );

                                if( $USER ){

                                    $_SESSION['uid']  =  $USERID = $USER['uid'];
                                    $_SESSION['ip']   =  $IP;

                                    if( isset ( $_GET['state'] ) &&  strlen( $_GET['state']) == 32){

                                       $HASH = 'kjdenglu/'.mima( $_GET['state']  );
                                       $Mem -> s($HASH, $USER['uid'] ,20);
                                    } 
                                    
                                    
                                    $tuiuser = uid( $_SESSION['tuid'] );

		                            $neirong = array( 'title' => '新会员注册成功。' ,'headinfo' =>  $tuiuser['name'],'program' =>$USER['name'], 'remark' => '感谢加入' ); 
                                    
                                    weixint2($tuiuser['weixin'],$neirong,5);

                                    uid($_SESSION['uid'] ,1);
                                    msgbox('',WZHOST);

                                }else  msgbox('失败联系管理2',WZHOST);


                            }else{
                                    unset( $_SESSION['tourist'] );
                                    msgbox('插入失败联系管理',WZHOST);
                            }
                        }
                    }

				}
            }else {


                //eventkey;


                if( $LANG['dianjihuifu'] ){


                    $jieneiro = $shuju['eventkey'];

                    foreach( $LANG['dianjihuifu'] as $ong){

                        if($ong['关键词'] == '' || $ong['回复内容'] == '') continue;

                        if( strstr( $jieneiro , $ong['关键词'] ) ){

                            weixint($shuju['fromusername'],$ong['回复内容'] );
                            break;
                        }
                    }
                }
            }
        }

	}
}

echo $_GET["echostr"];