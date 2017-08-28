<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');

$JSON = array('action' => 'alink','value' => array( '1',5,'龚格格','备用','长度测试','大色红牛' ) );




$data = array( 
       'title' => $LANG['fentitle'],
         'des' => $LANG['fenneiron'],
         'pic' => pichttp( $LANG['fenxiang'] ),
         'url' => WZHOST.'tg.php?y=yinreg&tuid='.(  isset( $_SESSION['uid'] ) && $_SESSION['uid'] > 0 ? $_SESSION['uid'] : 0 )
);



$login = base64_encode( json_encode( $data ) );

$JSON2 = array('action' => 'openSharePanel','value' => array( $login  ) );

$USERID = 1;

$USER = uid(1);
$JSON3 = array('action' => 'openSharePanel','value' => array( array( 'name' => $USER['name'],
                    'uid'  => $USERID,
                    'jine' => $USER['jine'],
                   'jifen' => $USER['jifen'],
                'kuohuobi' => $USER['kuohuobi'],
                'touxiang' => pichttp( $USER['touxiang'] ),
                  'shouji' => xinghao( $USER['shouji'] ),
            )  ) );

?>

<a href="javascript:Test()">test</a>  <br />

<a href="javascript:Test2()">test2</a> <br />
<a href="javascript:Test3()">test3</a> <br /

<?php p($JSON); ?>

</body>
<script type="text/javascript">
	function Test (argument) {
		/*
		{
			    "action": "login",
			    "value": [
			        "1",
			        "2",
			        "3"
			    ]
		}
		*/
		//HTML调用内部
		WebViewBridge.send("<?php echo base64_encode( json_encode($JSON  ))?>");
		
	}


		function Test2 (argument) {
		/*
		{
			    "action": "login",
			    "value": [
			        "1",
			        "2",
			        "3"
			    ]
		}
		*/
		//HTML调用内部
		WebViewBridge.send("<?php echo base64_encode( json_encode($JSON2  ))?>");
		
	}


	function Test3 (argument) {
		/*
		{
			    "action": "login",
			    "value": [
			        "1",
			        "2",
			        "3"
			    ]
		}
		*/
		//HTML调用内部
		WebViewBridge.send("<?php echo base64_encode( json_encode($JSON3  ))?>");
		
	}

	//内部可调用HTML方法 页面加载完毕调用一下代码 
	
</script>




