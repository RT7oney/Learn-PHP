<?php


/* ongsoft phpFrame  Application
 * ******************************************
 * home: www.ongsoft.com   mail: ai@13yd.com
 * Copyright  ongsoft
 * Trademark  ONG
 * ******************************************
 */

//强制输出头部
define('ONGHEAD'  , ''); 

//框架目录声明
define('ONGPHP'   , dirname(__FILE__).'/ong/');

//缓存存放目录
define('ONGTEMP'  , 'temp');

//系统配置
define('ONGCON'   , '');

//数据库配置
define('ONGDB'    , '');

//调用model里面控制器
define('ONGNAME'  , 'weixin');

//强行后台模版
define('ONGQHTPL' , '');

//强行前台模版
define('ONGQQTPL' , '');

//引入框架入口
require ONGPHP.'ong.php';