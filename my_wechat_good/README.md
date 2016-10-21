#微信插件文档
###pkgs
封装了微信接口类和一些通用方法<br>
<font color=red>tips：</font>在使用前请注意配置，请在配置项里面输入 ‘WECHAT_APP_ID’ ‘WECHAT_APP_SECRET’ ‘WECHAT_TOKEN’
***
##### 微信接口类
* responseMsg()

	对用户通过微信服务器发送过来的消息做处理响应，使用者不需要关心里面具体的机制，只需要在微信入口处需要响应给微信服务器的时候调用即可

* getOauthCode()和getOauthInfo()

	上述两个方法应该配合使用，在认证过的服务号中，可以满足微信的[网页授权获取用户基本信息](http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html)
	
* sendTplMsg($data)

	发送业务模板消息，参数为数组，字段为<br>
	'openid'用户的openid 	
	'order'对应订单号	
	'time'下单时间	
	'price'订单总价格	
	'return'返回多少红包
	
* getSignPackage($url)
	
	获取微信js-sdk的签名的方法需要传入参数为当前调用者的本地$url

* createQrcode($scene_type, $scene_id)

	


