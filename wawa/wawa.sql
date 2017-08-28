-- MySQL dump 10.13  Distrib 5.5.53, for Win32 (AMD64)
--
-- Host: localhost    Database: meng
-- ------------------------------------------------------
-- Server version	5.5.53

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ay_admin`
--

DROP TABLE IF EXISTS `ay_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT '管理帐号',
  `pass` varchar(64) NOT NULL COMMENT '管理密码',
  `diqu` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '地区',
  `epass` varchar(64) NOT NULL COMMENT '超级密码',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理组权限',
  `yanzhengip` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '强行验证用户ip',
  `off` tinyint(10) unsigned NOT NULL DEFAULT '0' COMMENT '帐号开关',
  `ip` varchar(60) NOT NULL COMMENT '登录ip',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_admin`
--

LOCK TABLES `ay_admin` WRITE;
/*!40000 ALTER TABLE `ay_admin` DISABLE KEYS */;
INSERT INTO `ay_admin` VALUES (1,'admin','00f9d6efc1fd4a4755b1f21f194',0,'00f9d6efc1fd4a4755b1f21f194',0,1,1,'',0);
/*!40000 ALTER TABLE `ay_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_adminfenzu`
--

DROP TABLE IF EXISTS `ay_adminfenzu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_adminfenzu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '管理权限名字',
  `shezhi` text NOT NULL COMMENT '权限组说明设置',
  `miaoshu` varchar(255) NOT NULL COMMENT '权限组描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_adminfenzu`
--

LOCK TABLES `ay_adminfenzu` WRITE;
/*!40000 ALTER TABLE `ay_adminfenzu` DISABLE KEYS */;
/*!40000 ALTER TABLE `ay_adminfenzu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_adminlog`
--

DROP TABLE IF EXISTS `ay_adminlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_adminlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理uid',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '日志类型',
  `data` text NOT NULL COMMENT '详细数据',
  `ip` varchar(36) NOT NULL COMMENT '产生ip',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=1921 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_adminlog`
--

LOCK TABLES `ay_adminlog` WRITE;
/*!40000 ALTER TABLE `ay_adminlog` DISABLE KEYS */;
INSERT INTO `ay_adminlog` VALUES (1859,1,0,'','180.115.254.1',1493716046),(1860,1,0,'','116.21.81.139',1493764971),(1861,1,4,'a:4:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";i:6;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:18:\"微信支付官方\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:5:\"payid\";s:10:\"1454829502\";s:6:\"paykey\";s:32:\"asdjflkasdjlkfajsdlkfjaslkdjflka\";s:8:\"zhanghao\";s:18:\"wx750bda0d5b50d2ec\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:32:\"asdjflkasdjlkfajsdlkfjaslkdjflka\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:6:\"weixin\";s:5:\"isapp\";s:1:\"0\";}}','111.37.2.88',1494508710),(1862,1,4,'a:4:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";i:5;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"5\";s:4:\"name\";s:12:\"掌上威信\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:5:\"payid\";s:1:\"1\";s:6:\"paykey\";s:64:\"1a21d9a092ef3131f827d78583a0487a74924a32f7a824daf96537403864b2f1\";s:8:\"zhanghao\";s:1:\"1\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:1:\"1\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:7:\"zszhifu\";s:5:\"isapp\";s:1:\"0\";}}','111.37.2.88',1494508715),(1863,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:3;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:5:\"payid\";s:1:\"1\";s:6:\"paykey\";s:64:\"1a21d9a092ef3131f827d78583a0487a74924a32f7a824daf96537403864b2f1\";s:8:\"zhanghao\";s:1:\"1\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:1:\"2\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:7:\"zszhifu\";s:5:\"isapp\";s:1:\"0\";}s:4:\"data\";a:11:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:7:\"payfile\";s:7:\"zszhifu\";s:8:\"zhanghao\";s:0:\"\";s:5:\"payid\";s:3:\"364\";s:6:\"paykey\";s:64:\"e11a05077ec33521c15ebcbcdde8159aea3b0acf795c02c4c0510898060d017b\";s:5:\"paixu\";s:1:\"0\";s:6:\"beizhu\";s:1:\"2\";s:5:\"isapp\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";}}','111.37.2.88',1494508767),(1864,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:3;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:5:\"payid\";s:3:\"364\";s:6:\"paykey\";s:64:\"e11a05077ec33521c15ebcbcdde8159aea3b0acf795c02c4c0510898060d017b\";s:8:\"zhanghao\";s:0:\"\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:1:\"2\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:7:\"zszhifu\";s:5:\"isapp\";s:1:\"0\";}s:4:\"data\";a:10:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:7:\"payfile\";s:7:\"zszhifu\";s:8:\"zhanghao\";s:0:\"\";s:5:\"payid\";s:3:\"364\";s:5:\"paixu\";s:1:\"0\";s:6:\"beizhu\";s:1:\"2\";s:5:\"isapp\";s:1:\"1\";s:7:\"adminid\";s:1:\"1\";}}','111.37.2.88',1494508771),(1865,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:3;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:5:\"payid\";s:3:\"364\";s:6:\"paykey\";s:64:\"e11a05077ec33521c15ebcbcdde8159aea3b0acf795c02c4c0510898060d017b\";s:8:\"zhanghao\";s:0:\"\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:1:\"2\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:7:\"zszhifu\";s:5:\"isapp\";s:1:\"1\";}s:4:\"data\";a:10:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:7:\"payfile\";s:7:\"zszhifu\";s:8:\"zhanghao\";s:0:\"\";s:5:\"payid\";s:4:\"3666\";s:5:\"paixu\";s:1:\"0\";s:6:\"beizhu\";s:1:\"2\";s:5:\"isapp\";s:1:\"1\";s:7:\"adminid\";s:1:\"1\";}}','111.37.2.88',1494508795),(1866,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:3;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:5:\"payid\";s:4:\"3666\";s:6:\"paykey\";s:64:\"e11a05077ec33521c15ebcbcdde8159aea3b0acf795c02c4c0510898060d017b\";s:8:\"zhanghao\";s:0:\"\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:1:\"2\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:7:\"zszhifu\";s:5:\"isapp\";s:1:\"1\";}s:4:\"data\";a:10:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:7:\"payfile\";s:7:\"zszhifu\";s:8:\"zhanghao\";s:0:\"\";s:5:\"payid\";s:3:\"364\";s:5:\"paixu\";s:1:\"0\";s:6:\"beizhu\";s:1:\"2\";s:5:\"isapp\";s:1:\"1\";s:7:\"adminid\";s:1:\"1\";}}','111.37.2.88',1494508809),(1867,1,0,'','116.2.250.197',1495031709),(1868,1,3,'a:4:{s:2:\"ac\";s:5:\"xtset\";s:2:\"mo\";s:4:\"edit\";s:4:\"yuan\";a:80:{s:3:\"dir\";s:1:\"/\";s:4:\"lang\";s:2:\"cn\";s:6:\"houzui\";s:5:\".html\";s:7:\"yunxing\";s:1:\"0\";s:5:\"fenge\";s:1:\"-\";s:8:\"fengenum\";s:1:\"5\";s:4:\"qtpl\";s:4:\"shop\";s:4:\"htpl\";s:5:\"admin\";s:4:\"hchs\";s:1:\"0\";s:6:\"qudong\";s:3:\"pdo\";s:4:\"modb\";s:5:\"write\";s:4:\"duob\";s:1:\"0\";s:3:\"qxx\";s:1:\"1\";s:4:\"hnum\";s:2:\"20\";s:4:\"HTTP\";s:0:\"\";s:7:\"WAPHTTP\";s:0:\"\";s:6:\"qtlang\";s:2:\"cn\";s:6:\"htlang\";s:2:\"cn\";s:4:\"dbug\";s:1:\"1\";s:5:\"shiqu\";s:3:\"PRC\";s:8:\"pagetrim\";s:1:\"1\";s:6:\"sicode\";s:1:\"0\";s:8:\"chengshi\";s:15:\"请选择区域\";s:5:\"vcode\";s:19:\"你,个,瓜,娃,子\";s:4:\"jine\";s:3:\"RMB\";s:5:\"jifen\";s:6:\"积分\";s:5:\"huobi\";s:6:\"砖石\";s:5:\"title\";s:12:\"掌上商城\";s:7:\"maxsize\";s:10:\"3500000000\";s:5:\"upsuo\";s:1:\"1\";s:8:\"shuiying\";s:1:\"1\";s:9:\"upsuobili\";s:3:\"0.3\";s:6:\"updayu\";s:3:\"200\";s:10:\"upzhiliang\";s:2:\"80\";s:8:\"upweizhi\";s:1:\"8\";s:3:\"upx\";s:0:\"\";s:3:\"upy\";s:0:\"\";s:6:\"ftpurl\";s:0:\"\";s:7:\"ftpport\";s:0:\"\";s:7:\"ftpuser\";s:0:\"\";s:7:\"ftppass\";s:30:\"WhcoFiu79bktsqux7P3tOdIx3jTjLr\";s:7:\"ftphttp\";s:0:\"\";s:11:\"sessiontime\";s:7:\"3600000\";s:7:\"session\";i:0;s:7:\"miaoshu\";s:12:\"掌上商城\";s:8:\"guanjian\";s:12:\"掌上商城\";s:6:\"xibiao\";s:1:\"1\";s:4:\"logo\";s:61:\"/attachment/all/201610/02_68ca2e474f7b7d5ebe2093c7abf4f20.png\";s:8:\"huanchun\";s:1:\"0\";s:5:\"yasuo\";s:1:\"0\";s:8:\"sosoword\";s:2:\"so\";s:8:\"userword\";s:4:\"user\";s:6:\"typeqz\";s:0:\"\";s:6:\"typems\";s:1:\"3\";s:9:\"neirongqz\";s:0:\"\";s:9:\"neirongms\";s:1:\"3\";s:8:\"fenleiji\";s:2:\"10\";s:9:\"morenlist\";s:4:\"list\";s:5:\"hpage\";i:5;s:9:\"morencent\";s:6:\"center\";s:7:\"hongbao\";s:9:\"优惠卷\";s:8:\"jsontime\";s:1:\"0\";s:5:\"isoss\";s:0:\"\";s:7:\"regtype\";s:1:\"0\";s:5:\"ipnum\";s:3:\"100\";s:5:\"level\";s:1:\"0\";s:7:\"tujishu\";s:1:\"3\";s:10:\"yanzhengip\";s:1:\"0\";s:7:\"FYUTIME\";s:1:\"2\";s:6:\"FYUNUM\";s:3:\"100\";s:7:\"payjine\";s:3:\"0.1\";s:8:\"xiangou0\";s:1:\"1\";s:5:\"shnum\";s:1:\"5\";s:9:\"timegeshi\";s:11:\"Y-m-d H:i:s\";s:9:\"reqigeshi\";s:5:\"Y-m-d\";s:9:\"zhiurloff\";s:1:\"0\";s:10:\"zhiurltype\";s:0:\"\";s:10:\"zhiurlcent\";s:0:\"\";s:7:\"kuaireg\";s:1:\"0\";s:7:\"lanmuno\";s:7:\"2,56,57\";}s:4:\"data\";a:53:{s:6:\"xibiao\";s:1:\"0\";s:5:\"title\";s:14:\"掌上商城11\";s:7:\"miaoshu\";s:14:\"掌上商城11\";s:8:\"guanjian\";s:14:\"掌上商城11\";s:4:\"logo\";s:61:\"/attachment/all/201610/02_68ca2e474f7b7d5ebe2093c7abf4f20.png\";s:8:\"sosoword\";s:2:\"so\";s:8:\"userword\";s:4:\"user\";s:7:\"yunxing\";s:1:\"0\";s:8:\"huanchun\";s:1:\"0\";s:5:\"yasuo\";s:1:\"0\";s:6:\"typems\";s:1:\"3\";s:6:\"typeqz\";s:0:\"\";s:9:\"neirongms\";s:1:\"3\";s:9:\"neirongqz\";s:0:\"\";s:9:\"zhiurloff\";s:1:\"0\";s:10:\"zhiurltype\";s:0:\"\";s:10:\"zhiurlcent\";s:0:\"\";s:7:\"FYUTIME\";s:1:\"2\";s:6:\"FYUNUM\";s:3:\"100\";s:7:\"payjine\";s:3:\"0.1\";s:8:\"xiangou0\";s:1:\"1\";s:4:\"qtpl\";s:4:\"shop\";s:7:\"maxsize\";s:10:\"3500000000\";s:5:\"upsuo\";s:1:\"1\";s:8:\"shuiying\";s:1:\"1\";s:9:\"upsuobili\";s:3:\"0.3\";s:6:\"updayu\";s:3:\"200\";s:10:\"upzhiliang\";s:2:\"80\";s:8:\"upweizhi\";s:1:\"8\";s:3:\"upx\";s:0:\"\";s:3:\"upy\";s:0:\"\";s:7:\"lanmuno\";s:7:\"2,56,57\";s:5:\"isoss\";s:0:\"\";s:6:\"ftpurl\";s:0:\"\";s:7:\"ftpport\";s:0:\"\";s:7:\"ftpuser\";s:0:\"\";s:7:\"ftphttp\";s:0:\"\";s:6:\"sicode\";s:1:\"0\";s:4:\"dbug\";s:1:\"1\";s:5:\"shiqu\";s:3:\"PRC\";s:11:\"sessiontime\";s:7:\"3600000\";s:4:\"jine\";s:3:\"RMB\";s:5:\"jifen\";s:6:\"积分\";s:5:\"huobi\";s:6:\"砖石\";s:7:\"hongbao\";s:9:\"优惠卷\";s:8:\"fenleiji\";s:2:\"10\";s:8:\"chengshi\";s:15:\"请选择区域\";s:7:\"regtype\";s:1:\"0\";s:5:\"ipnum\";s:3:\"100\";s:5:\"level\";s:1:\"0\";s:10:\"yanzhengip\";s:1:\"0\";s:5:\"shnum\";s:1:\"5\";s:7:\"kuaireg\";s:1:\"0\";}}','116.2.250.197',1495033869),(1869,1,1,'','116.2.250.197',1495034117),(1870,1,0,'','116.2.246.134',1495034563),(1871,1,3,'a:5:{s:2:\"ac\";s:5:\"admin\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";d:1;s:4:\"yuan\";a:10:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:5:\"admin\";s:4:\"pass\";s:24:\"ec8e187a9d93aa70a05f69f8\";s:4:\"diqu\";s:1:\"0\";s:5:\"epass\";s:31:\"e0fb31aead3bad8d36760f3e52fee90\";s:4:\"type\";s:1:\"0\";s:10:\"yanzhengip\";s:1:\"1\";s:3:\"off\";s:1:\"1\";s:2:\"ip\";s:0:\"\";s:5:\"atime\";s:1:\"0\";}s:4:\"data\";a:6:{s:4:\"name\";s:5:\"admin\";s:4:\"pass\";s:30:\"273c404d65d34049457a68f9c73db4\";s:5:\"epass\";s:30:\"273c404d65d34049457a68f9c73db4\";s:3:\"off\";i:1;s:10:\"yanzhengip\";i:1;s:4:\"type\";s:1:\"0\";}}','116.2.246.134',1495034582),(1872,1,1,'','116.2.246.134',1495034585),(1873,1,0,'','116.2.246.134',1495034596),(1874,1,5,'a:4:{s:2:\"ac\";s:11:\"yongjinjilu\";s:2:\"mo\";s:3:\"add\";s:2:\"id\";s:1:\"3\";s:4:\"data\";a:28:{s:4:\"name\";s:15:\"时代风格的\";s:3:\"cid\";s:0:\"\";s:5:\"yunid\";s:1:\"0\";s:8:\"guanjian\";s:0:\"\";s:7:\"miaoshu\";s:0:\"\";s:3:\"url\";s:14:\"shidaifenggede\";s:4:\"http\";s:0:\"\";s:3:\"uid\";s:0:\"\";s:7:\"adminid\";s:1:\"1\";s:4:\"shid\";s:0:\"\";s:7:\"tuijian\";s:0:\"\";s:5:\"paixu\";s:0:\"\";s:5:\"renqi\";s:0:\"\";s:3:\"off\";s:1:\"2\";s:6:\"tupian\";s:0:\"\";s:7:\"neirong\";s:33:\"乳房的股份的风格的风格\";s:5:\"jiage\";s:0:\"\";s:6:\"canshu\";s:6:\"a:0:{}\";s:8:\"tupianji\";s:0:\"\";s:5:\"xtime\";i:1495034872;s:6:\"kuozan\";s:0:\"\";s:6:\"explx1\";s:0:\"\";s:6:\"explx2\";s:0:\"\";s:6:\"explx3\";s:0:\"\";s:6:\"explx4\";s:0:\"\";s:6:\"explx5\";s:0:\"\";s:6:\"explx6\";s:0:\"\";s:5:\"atime\";i:1495034872;}}','116.2.246.134',1495034872),(1875,1,0,'','116.2.246.134',1495066743),(1876,1,0,'','116.2.246.134',1495070784),(1877,1,0,'','116.2.246.134',1495078248),(1878,1,1,'','116.2.246.134',1495080122),(1879,1,0,'','116.2.246.134',1495080128),(1880,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"152\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"152\";s:4:\"name\";s:6:\"testaa\";s:8:\"zhanghao\";s:6:\"testaa\";s:4:\"mima\";s:18:\"6577c2fd4368b46b45\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:7:\"1000.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495032147\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:3:\"151\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495086347),(1881,1,3,'a:5:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";s:3:\"153\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"153\";s:4:\"name\";s:3:\"222\";s:8:\"zhanghao\";s:3:\"222\";s:4:\"mima\";s:12:\"87d90a5316a2\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495086405\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:3:\"151\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}s:4:\"data\";a:22:{s:4:\"name\";s:3:\"222\";s:8:\"zhanghao\";s:3:\"222\";s:8:\"touxiang\";s:0:\"\";s:5:\"level\";s:1:\"0\";s:3:\"off\";i:1;s:4:\"mima\";s:9:\"2f50befd4\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:3:\"151\";s:10:\"yanzhengip\";i:0;}}','116.2.246.134',1495086468),(1882,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:3;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";}s:4:\"data\";a:1:{s:3:\"off\";s:1:\"0\";}}','116.2.246.134',1495086555),(1883,1,4,'a:4:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";i:3;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"3\";s:4:\"name\";s:8:\"ZS支付\";s:8:\"suoluetu\";s:49:\"http://mimg.127.net/p/yy/lib/img/bank/9999.v2.png\";s:5:\"payid\";s:3:\"364\";s:6:\"paykey\";s:64:\"e11a05077ec33521c15ebcbcdde8159aea3b0acf795c02c4c0510898060d017b\";s:8:\"zhanghao\";s:0:\"\";s:3:\"off\";s:1:\"0\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:1:\"2\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:7:\"zszhifu\";s:5:\"isapp\";s:1:\"1\";}}','116.2.246.134',1495086663),(1884,1,1,'','116.2.246.134',1495087260),(1885,1,0,'','116.2.246.134',1495087267),(1886,1,0,'','116.2.246.134',1495109898),(1887,1,5,'a:4:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:3:\"add\";s:2:\"id\";s:1:\"4\";s:4:\"data\";a:10:{s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:0:\"\";s:7:\"payfile\";s:6:\"alipay\";s:8:\"zhanghao\";s:9:\"123445678\";s:5:\"payid\";s:4:\"2415\";s:6:\"paykey\";s:9:\"454666496\";s:5:\"paixu\";s:0:\"\";s:6:\"beizhu\";s:0:\"\";s:5:\"isapp\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";}}','116.2.246.134',1495109916),(1888,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:4;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"0\";s:7:\"xianshi\";s:1:\"0\";}s:4:\"data\";a:1:{s:3:\"off\";s:1:\"1\";}}','116.2.246.134',1495109925),(1889,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:4;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:0:\"\";s:5:\"payid\";s:4:\"2415\";s:6:\"paykey\";s:9:\"454666496\";s:8:\"zhanghao\";s:9:\"123445678\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"0\";s:6:\"beizhu\";s:0:\"\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:6:\"alipay\";s:5:\"isapp\";s:1:\"0\";}s:4:\"data\";a:10:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:7:\"payfile\";s:6:\"alipay\";s:8:\"zhanghao\";s:9:\"123445678\";s:5:\"payid\";s:4:\"2415\";s:5:\"paixu\";s:1:\"0\";s:6:\"beizhu\";s:0:\"\";s:5:\"isapp\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";}}','116.2.246.134',1495110543),(1890,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:4;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"0\";}s:4:\"data\";a:1:{s:7:\"xianshi\";s:1:\"1\";}}','116.2.246.134',1495110562),(1891,1,5,'a:4:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:3:\"add\";s:2:\"id\";s:1:\"5\";s:4:\"data\";a:10:{s:4:\"name\";s:12:\"微信支付\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:7:\"payfile\";s:6:\"weixin\";s:8:\"zhanghao\";s:3:\"111\";s:5:\"payid\";s:3:\"111\";s:6:\"paykey\";s:3:\"111\";s:5:\"paixu\";s:0:\"\";s:6:\"beizhu\";s:3:\"111\";s:5:\"isapp\";s:1:\"1\";s:7:\"adminid\";s:1:\"1\";}}','116.2.246.134',1495111508),(1892,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:5;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"0\";s:7:\"xianshi\";s:1:\"0\";}s:4:\"data\";a:1:{s:3:\"off\";s:1:\"1\";}}','116.2.246.134',1495111520),(1893,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:4;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";}s:4:\"data\";a:1:{s:3:\"off\";s:1:\"0\";}}','116.2.246.134',1495111523),(1894,1,4,'a:4:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";i:4;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"4\";s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:5:\"payid\";s:4:\"2415\";s:6:\"paykey\";s:9:\"454666496\";s:8:\"zhanghao\";s:9:\"123445678\";s:3:\"off\";s:1:\"0\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:0:\"\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:6:\"alipay\";s:5:\"isapp\";s:1:\"0\";}}','116.2.246.134',1495111526),(1895,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:5;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"0\";}s:4:\"data\";a:1:{s:7:\"xianshi\";s:1:\"1\";}}','116.2.246.134',1495111530),(1896,1,5,'a:4:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:3:\"add\";s:2:\"id\";s:1:\"6\";s:4:\"data\";a:10:{s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:7:\"payfile\";s:6:\"alipay\";s:8:\"zhanghao\";s:3:\"111\";s:5:\"payid\";s:3:\"111\";s:6:\"paykey\";s:7:\"1521545\";s:5:\"paixu\";s:0:\"\";s:6:\"beizhu\";s:0:\"\";s:5:\"isapp\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";}}','116.2.246.134',1495111578),(1897,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:6;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"0\";s:7:\"xianshi\";s:1:\"0\";}s:4:\"data\";a:1:{s:3:\"off\";s:1:\"1\";}}','116.2.246.134',1495111582),(1898,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:6;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"0\";}s:4:\"data\";a:1:{s:7:\"xianshi\";s:1:\"1\";}}','116.2.246.134',1495111584),(1899,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:6;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:5:\"payid\";s:3:\"111\";s:6:\"paykey\";s:7:\"1521545\";s:8:\"zhanghao\";s:3:\"111\";s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";s:6:\"beizhu\";s:0:\"\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:6:\"alipay\";s:5:\"isapp\";s:1:\"0\";}s:4:\"data\";a:10:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:7:\"payfile\";s:6:\"alipay\";s:8:\"zhanghao\";s:3:\"111\";s:5:\"payid\";s:3:\"111\";s:5:\"paixu\";s:1:\"0\";s:6:\"beizhu\";s:0:\"\";s:5:\"isapp\";s:1:\"1\";s:7:\"adminid\";s:1:\"1\";}}','116.2.246.134',1495111587),(1900,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:6;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"1\";s:7:\"xianshi\";s:1:\"1\";}s:4:\"data\";a:1:{s:3:\"off\";s:1:\"0\";}}','116.2.246.134',1495112182),(1901,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:6;s:4:\"yuan\";a:2:{s:3:\"off\";s:1:\"0\";s:7:\"xianshi\";s:1:\"1\";}s:4:\"data\";a:1:{s:7:\"xianshi\";s:1:\"0\";}}','116.2.246.134',1495112187),(1902,1,3,'a:5:{s:2:\"ac\";s:3:\"pay\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";i:6;s:4:\"yuan\";a:13:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:5:\"payid\";s:3:\"111\";s:6:\"paykey\";s:7:\"1521545\";s:8:\"zhanghao\";s:3:\"111\";s:3:\"off\";s:1:\"0\";s:7:\"xianshi\";s:1:\"0\";s:6:\"beizhu\";s:0:\"\";s:5:\"paixu\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";s:7:\"payfile\";s:6:\"alipay\";s:5:\"isapp\";s:1:\"1\";}s:4:\"data\";a:10:{s:2:\"id\";s:1:\"6\";s:4:\"name\";s:9:\"支付宝\";s:8:\"suoluetu\";s:57:\"https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png\";s:7:\"payfile\";s:6:\"alipay\";s:8:\"zhanghao\";s:3:\"111\";s:5:\"payid\";s:3:\"111\";s:5:\"paixu\";s:1:\"0\";s:6:\"beizhu\";s:0:\"\";s:5:\"isapp\";s:1:\"0\";s:7:\"adminid\";s:1:\"1\";}}','116.2.246.134',1495112190),(1903,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"145\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"145\";s:4:\"name\";s:16:\"常州PHP 大伟\";s:8:\"zhanghao\";s:0:\"\";s:4:\"mima\";s:31:\"f37b4c7c9b0b4c456d669151b640a72\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:28:\"oR4TQwTe7EA3wZY-aF3IXCx9ilgk\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"1.78\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:128:\"http://wx.qlogo.cn/mmopen/ibcRmHmvckyOluVZqs3ROvdsakCx1ecicOIsVGGo3Y3Wf0L3ItG7ic69b9Ak8d7Y6A2JNPjdbu77mZMqNbJD1NwibrORHa1LSE5w/0\";s:5:\"atime\";s:10:\"1493127756\";s:2:\"ip\";s:15:\"114.226.176.217\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114486),(1904,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"146\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"146\";s:4:\"name\";s:6:\"高超\";s:8:\"zhanghao\";s:0:\"\";s:4:\"mima\";s:31:\"fa6118fb37e2c4e658f54b34fc77b68\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:28:\"oR4TQwUmJnqRaUEsN9kV18IKbLqw\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:7:\"3000.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:132:\"http://wx.qlogo.cn/mmopen/kAia899ayib2WwZTP3csLPc6ZuHXRI2R8J6R9yFricW5tt4AZH7OncmialvXqau5tibo8pxWZqvAe0hglTceiaZDgiaMZHDTibqQoGfL/0\";s:5:\"atime\";s:10:\"1493128022\";s:2:\"ip\";s:14:\"114.226.13.123\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114489),(1905,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"147\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"147\";s:4:\"name\";s:8:\"jimmy905\";s:8:\"zhanghao\";s:8:\"jimmy905\";s:4:\"mima\";s:24:\"ff949ed384409f6d1bf61f4b\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:6:\"193.72\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:5:\"20.00\";s:3:\"off\";s:1:\"0\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1493364842\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:3:\"145\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114491),(1906,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"148\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"148\";s:4:\"name\";s:6:\"yman19\";s:8:\"zhanghao\";s:6:\"yman19\";s:4:\"mima\";s:21:\"2cb2514b6b60d74c85e24\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1493716129\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114495),(1907,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"149\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"149\";s:4:\"name\";s:9:\"admin1234\";s:8:\"zhanghao\";s:9:\"admin1234\";s:4:\"mima\";s:27:\"b3188dc0a9bd4454709875c362d\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:5:\"30.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1494423065\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114497),(1908,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"150\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"150\";s:4:\"name\";s:3:\"123\";s:8:\"zhanghao\";s:3:\"123\";s:4:\"mima\";s:9:\"dc7e3242b\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:5:\"49.78\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:5:\"89.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1494508609\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114501),(1909,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"151\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"151\";s:4:\"name\";s:4:\"test\";s:8:\"zhanghao\";s:4:\"test\";s:4:\"mima\";s:12:\"bcf78aaed771\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:6:\"788.49\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495031607\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114503),(1910,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"153\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"153\";s:4:\"name\";s:3:\"222\";s:8:\"zhanghao\";s:3:\"222\";s:4:\"mima\";s:9:\"2f50befd4\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495086405\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:3:\"151\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114505),(1911,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"154\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"154\";s:4:\"name\";s:6:\"waacom\";s:8:\"zhanghao\";s:6:\"waacom\";s:4:\"mima\";s:18:\"a15498b99abf3e1228\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495105010\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114508),(1912,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"155\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"155\";s:4:\"name\";s:5:\"test3\";s:8:\"zhanghao\";s:5:\"test3\";s:4:\"mima\";s:15:\"af98d0d7c0d64e2\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495107842\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114510),(1913,1,4,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"del\";s:2:\"id\";s:3:\"156\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"156\";s:4:\"name\";s:6:\"prayvi\";s:8:\"zhanghao\";s:6:\"prayvi\";s:4:\"mima\";s:30:\"273c404d65d34049457a68f9c73db4\";s:6:\"ermima\";s:0:\"\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"1\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495113373\";s:2:\"ip\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:3:\"151\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}}','116.2.246.134',1495114513),(1914,1,5,'a:4:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:3:\"add\";s:2:\"id\";s:3:\"157\";s:4:\"data\";a:26:{s:4:\"name\";s:3:\"123\";s:8:\"zhanghao\";s:3:\"123\";s:8:\"touxiang\";s:0:\"\";s:5:\"level\";s:1:\"0\";s:4:\"mima\";s:9:\"dc7e3242b\";s:6:\"ermima\";s:9:\"dc7e3242b\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:0:\"\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:0:\"\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:3:\"off\";i:0;s:10:\"yanzhengip\";i:0;s:5:\"atime\";i:1495114546;s:2:\"ip\";s:13:\"116.2.246.134\";s:5:\"admin\";s:1:\"1\";}}','116.2.246.134',1495114546),(1915,1,3,'a:5:{s:2:\"ac\";s:4:\"user\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";s:3:\"157\";s:4:\"yuan\";a:34:{s:3:\"uid\";s:3:\"157\";s:4:\"name\";s:3:\"123\";s:8:\"zhanghao\";s:3:\"123\";s:4:\"mima\";s:9:\"dc7e3242b\";s:6:\"ermima\";s:9:\"dc7e3242b\";s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:4:\"jine\";s:4:\"0.00\";s:5:\"jifen\";s:4:\"0.00\";s:5:\"huobi\";s:4:\"0.00\";s:3:\"off\";s:1:\"0\";s:10:\"yanzhengip\";s:1:\"0\";s:8:\"touxiang\";s:0:\"\";s:5:\"atime\";s:10:\"1495114546\";s:2:\"ip\";s:13:\"116.2.246.134\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:5:\"tuid1\";s:1:\"0\";s:5:\"tuid2\";s:1:\"0\";s:7:\"adminid\";s:1:\"0\";s:5:\"level\";s:1:\"0\";s:5:\"appid\";s:1:\"0\";s:5:\"mhash\";s:0:\"\";}s:4:\"data\";a:21:{s:4:\"name\";s:3:\"123\";s:8:\"zhanghao\";s:3:\"123\";s:8:\"touxiang\";s:0:\"\";s:5:\"level\";s:1:\"0\";s:3:\"off\";i:1;s:5:\"email\";s:0:\"\";s:6:\"shouji\";s:1:\"0\";s:6:\"weixin\";s:0:\"\";s:8:\"weixinui\";s:0:\"\";s:6:\"qqopen\";s:0:\"\";s:5:\"weibo\";s:0:\"\";s:12:\"zhifubaoopen\";s:0:\"\";s:6:\"openid\";s:0:\"\";s:7:\"openidd\";s:0:\"\";s:5:\"zhiye\";s:0:\"\";s:7:\"xingbie\";s:2:\"-1\";s:8:\"nianling\";s:1:\"0\";s:7:\"qqhaoma\";s:0:\"\";s:11:\"weixinhaoma\";s:0:\"\";s:4:\"tuid\";s:1:\"0\";s:10:\"yanzhengip\";i:0;}}','116.2.246.134',1495114603),(1916,1,0,'','116.2.246.134',1495161277),(1917,1,0,'','183.208.176.74',1495567201),(1918,1,3,'a:5:{s:2:\"ac\";s:5:\"admin\";s:2:\"mo\";s:4:\"edit\";s:2:\"id\";d:1;s:4:\"yuan\";a:10:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:5:\"admin\";s:4:\"pass\";s:30:\"273c404d65d34049457a68f9c73db4\";s:4:\"diqu\";s:1:\"0\";s:5:\"epass\";s:30:\"273c404d65d34049457a68f9c73db4\";s:4:\"type\";s:1:\"0\";s:10:\"yanzhengip\";s:1:\"1\";s:3:\"off\";s:1:\"1\";s:2:\"ip\";s:0:\"\";s:5:\"atime\";s:1:\"0\";}s:4:\"data\";a:6:{s:4:\"name\";s:5:\"admin\";s:4:\"pass\";s:27:\"00f9d6efc1fd4a4755b1f21f194\";s:5:\"epass\";s:27:\"00f9d6efc1fd4a4755b1f21f194\";s:3:\"off\";i:1;s:10:\"yanzhengip\";i:1;s:4:\"type\";s:1:\"0\";}}','183.208.176.74',1495567273),(1919,1,2,'s:14:\"183.208.176.74\";','183.208.179.58',1495696623),(1920,1,0,'','183.208.179.58',1495696631);
/*!40000 ALTER TABLE `ay_adminlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_center`
--

DROP TABLE IF EXISTS `ay_center`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_center` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '内容名字',
  `guanjian` varchar(255) NOT NULL COMMENT '关键词',
  `miaoshu` varchar(255) NOT NULL COMMENT '描述',
  `zcid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '第二子分类id',
  `cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `url` varchar(255) NOT NULL COMMENT '内容url',
  `http` varchar(255) NOT NULL COMMENT '外联url',
  `neromb` varchar(10) NOT NULL COMMENT '指定内容模版',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理员uid',
  `tuijian` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `paixu` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `renqi` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '人气',
  `tupian` varchar(255) NOT NULL COMMENT '图片',
  `tupianji` text NOT NULL COMMENT '图片集',
  `neirong` longtext NOT NULL COMMENT '分类内容',
  `kuozan` text NOT NULL COMMENT '扩展数据',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `xtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `off` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态0 关闭 1 审核 2 正常',
  `explx1` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型1',
  `explx2` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型2',
  `explx3` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型3',
  `explx4` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型4',
  `explx5` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型5',
  `explx6` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型6',
  `yuanjia` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品原价',
  `jiage` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '现在单价',
  `yunid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '运费id',
  `xiaoliang` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `canshu` text NOT NULL COMMENT '产品选购参数+价格',
  `miaosufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '描述总分',
  `fuwufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '服务总分',
  `wuliufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '物流总分',
  `fenren` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评分人数',
  `jinzhong` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '净重',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '处理方式',
  `kahao` varchar(255) NOT NULL COMMENT '授权或者网盘地址文件地址',
  `kamima` varchar(255) NOT NULL COMMENT '网盘密码或者压缩吧密码',
  `xiangou` double unsigned NOT NULL DEFAULT '0' COMMENT '限购数量',
  `xgtype` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '限购分类',
  `xgdata` varchar(255) NOT NULL COMMENT '限购时间端',
  `huobi` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '购买方式货币',
  `beizhu` varchar(255) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `url` (`url`),
  KEY `off` (`off`),
  KEY `cid_2` (`cid`,`off`),
  KEY `explx1` (`explx1`),
  KEY `explx2` (`explx2`),
  KEY `explx3` (`explx3`),
  KEY `explx4` (`explx4`),
  KEY `explx5` (`explx5`),
  KEY `explx6` (`explx6`)
) ENGINE=InnoDB AUTO_INCREMENT=466 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_center`
--

LOCK TABLES `ay_center` WRITE;
/*!40000 ALTER TABLE `ay_center` DISABLE KEYS */;
INSERT INTO `ay_center` VALUES (453,'0.0','','',0,67,'00','','',0,0,1,0,0,0,'','','','',1491469086,1491471135,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(454,'0.0','','',0,67,'2888','','',0,0,1,0,0,0,'','','','',1491469106,1491471124,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(455,'0.0','','',0,67,'1888','','',0,0,1,0,0,0,'','','','',1491469123,1491471105,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(456,'0.0','','',0,67,'888','','',0,0,1,0,0,0,'','','','',1491469139,1491471085,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(457,'0.0','','',0,67,'588','','',0,0,1,0,0,0,'','','','',1491469155,1491471074,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(458,'0.0','','',0,68,'00y','','',0,0,1,0,0,0,'','','','',1491469252,1491471225,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(459,'0.0','','',0,68,'6888','','',0,0,1,0,0,0,'','','','',1491469287,1491471209,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(460,'0.0','','',0,68,'4888','','',0,0,1,0,0,0,'','','','',1491469301,1491471191,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(461,'0.0','','',0,68,'2888n','','',0,0,1,0,0,0,'','','','',1491469314,1491471176,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(462,'0.0','','',0,68,'1888c','','',0,0,1,0,0,0,'','','','',1491469333,1491471157,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(463,'0.0','','',0,69,'1b','','',0,0,1,0,0,0,'','','','',1491735832,1491735848,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(464,'0.0','','',0,69,'288','','',0,0,1,0,0,0,'','','','',1491735875,1491735875,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,''),(465,'0.0','','',0,0,'388','','',0,0,1,0,0,0,'','','','',1491735904,1491735904,2,0,0,0,0,0,0,0.00,0.00,0,0,'a:0:{}',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'');
/*!40000 ALTER TABLE `ay_center` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_chanpingg`
--

DROP TABLE IF EXISTS `ay_chanpingg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_chanpingg` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '产品模型名字',
  `canshu` text NOT NULL COMMENT '产品模型参数',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理id',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商户id',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `ip` varchar(36) NOT NULL COMMENT 'ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_chanpingg`
--

LOCK TABLES `ay_chanpingg` WRITE;
/*!40000 ALTER TABLE `ay_chanpingg` DISABLE KEYS */;
INSERT INTO `ay_chanpingg` VALUES (6,'牛肉参数','a:2:{s:5:\"shuju\";a:1:{i:0;a:2:{s:4:\"name\";s:12:\"产品规格\";i:0;a:3:{s:6:\"canshu\";s:4:\"500G\";s:6:\"miaosu\";s:0:\"\";s:6:\"tupian\";s:0:\"\";}}}s:5:\"jiage\";a:1:{s:5:\"500G_\";d:0;}}',0,1,0,1476756460,'127.0.0.1');
/*!40000 ALTER TABLE `ay_chanpingg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_dingdan`
--

DROP TABLE IF EXISTS `ay_dingdan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_dingdan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` varchar(64) NOT NULL COMMENT '系统订单',
  `tongyiid` varchar(64) NOT NULL COMMENT '统一下单id  充值id',
  `xiorderid` varchar(64) NOT NULL COMMENT '商户返回id',
  `hongbaoid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '红包id',
  `hongjine` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '红包优惠金额',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理id',
  `kuaixq` varchar(255) NOT NULL COMMENT '快递模版详情',
  `kuaiid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '快递id',
  `yunfei` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '运费价格',
  `jine` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品系统金额',
  `jifen` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `huobi` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '货币',
  `payjine` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '应当支付金额',
  `rejine` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '返回金额',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单分类 0 产品 1 充值订单',
  `jjine` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '结算金额',
  `jieoff` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '结算状态',
  `off` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `xtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '充值成功时间',
  `jtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '结算时间',
  `mhash` varchar(64) NOT NULL COMMENT '唯一标识验证',
  `faoff` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态',
  `xingming` varchar(255) NOT NULL COMMENT '收货人姓名',
  `shouji` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '收货人手机',
  `diqu` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '城市id',
  `shouhuo` varchar(255) NOT NULL COMMENT '收获地区详细',
  `ip` varchar(36) NOT NULL,
  `shoubeizhu` varchar(255) NOT NULL COMMENT '收货备注',
  `fakuaidi` varchar(255) NOT NULL COMMENT '发货快递',
  `fakuaima` varchar(255) NOT NULL COMMENT '发货快递号码',
  `fabeizhu` varchar(255) NOT NULL COMMENT '发货备注',
  `shouhoufs` varchar(255) NOT NULL COMMENT '售后联系方式',
  `tikuaidi` varchar(255) NOT NULL COMMENT '退货快递',
  `tikuaima` varchar(255) NOT NULL COMMENT '退货快递号码',
  `tibeizhu` varchar(255) NOT NULL COMMENT '退货备注',
  `tijine` double(20,0) unsigned NOT NULL DEFAULT '0' COMMENT '声请退款金额',
  `tihuanhuo` text NOT NULL COMMENT '系统操作记录 退换货记录',
  `paytype` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式',
  `tehui` double(3,2) unsigned NOT NULL DEFAULT '1.00' COMMENT '特惠支付比例',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '等级',
  `lailu` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '来路',
  `shouhou` varchar(100) NOT NULL COMMENT '售后',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mhash` (`mhash`),
  KEY `orderid` (`orderid`),
  KEY `tongyiid` (`tongyiid`),
  KEY `xiorderid` (`xiorderid`),
  KEY `hongbaoid` (`hongbaoid`),
  KEY `uid` (`uid`),
  KEY `shid` (`shid`),
  KEY `adminid` (`adminid`),
  KEY `off` (`off`),
  KEY `jieoff` (`jieoff`),
  KEY `faoff` (`faoff`),
  KEY `tongyiid_2` (`tongyiid`,`type`,`off`),
  KEY `uid_2` (`uid`,`type`,`off`,`faoff`),
  KEY `atime` (`atime`),
  KEY `off_2` (`off`,`atime`),
  KEY `uid_3` (`uid`,`off`,`atime`)
) ENGINE=InnoDB AUTO_INCREMENT=581 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_dingdan`
--

LOCK TABLES `ay_dingdan` WRITE;
/*!40000 ALTER TABLE `ay_dingdan` DISABLE KEYS */;
INSERT INTO `ay_dingdan` VALUES (451,'20170502171346320787','','',0,0.00,148,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1493716426,0,0,'ce532b545e8286c9294e33fb223df24827afc04c6fabbe09ac39a26dcc8fa7b7',0,'',0,0,'','116.21.81.139','','','','','','','','',0,'',6,1.00,0,4,''),(452,'20170510213113655171','','',0,0.00,149,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494423073,0,0,'568b25c86cbc1161a38f9f6b5fbf30f1dad442e4fac0c69c62dead6102214bed',0,'',0,0,'','36.149.0.19','','','','','','','','',0,'',5,1.00,0,0,''),(453,'20170510213124871182','','',0,0.00,149,0,0,'',0,0.00,0.00,0,0,15.00,0.00,1,0.00,0,1,1494423084,0,0,'c49df03f25724f9cc3223bc6435df9875a688f95e39aa11380ce5912d69672a0',0,'',0,0,'','36.149.0.19','','','','','','','','',0,'',5,1.00,0,0,''),(454,'20170510232135195476','','',0,0.00,149,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494429695,0,0,'f939d54a35b670ba686c43be1308f5a9e7efbcc601eb66fc4956a9c5291188bf',0,'',0,0,'','180.99.174.77','','','','','','','','',0,'',5,1.00,0,2,''),(455,'20170510232142424987','','',0,0.00,149,0,0,'',0,0.00,0.00,0,0,100.00,0.00,1,0.00,0,1,1494429702,0,0,'0ecae89c7337334cca84d9b9561df6a8d0aa2648013d5c15314d35a01656b16b',0,'',0,0,'','180.99.174.77','','','','','','','','',0,'',5,1.00,0,2,''),(456,'20170511070904504517','','',0,0.00,149,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494457744,0,0,'c0712f6b50ee91ac6043ede67a29e0e6c0295f8ac855f4b25e8083e540e81241',0,'',0,0,'','36.149.0.19','','','','','','','','',0,'',5,1.00,0,0,''),(457,'20170511211656400525','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494508616,0,0,'2ad787c8ee119dac453d887ae865a83929cc43ad1cae494a62150cef0f231ab8',0,'',0,0,'','111.37.2.88','','','','','','','','',0,'',3,1.00,0,0,''),(458,'20170511211838156975','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494508718,0,0,'af5a7f482083ba5ba35befc0f6f014e107021cf72333d53b7a0e9a3038d33720',0,'',0,0,'','111.37.2.88','','','','','','','','',0,'',3,1.00,0,0,''),(459,'20170511211936549848','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494508776,0,0,'9599e64c1d824804636ca9be787562d9334e24c1929ea0c6a244b1a170dff0fd',0,'',0,0,'','111.37.2.88','','','','','','','','',0,'',3,1.00,0,0,''),(460,'20170511212000479797','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494508800,0,0,'00120b08c094df01538894469ffc49b379fd09470b028262a7150604dc62f2d2',0,'',0,0,'','111.37.2.88','','','','','','','','',0,'',3,1.00,0,0,''),(461,'20170511212046826057','','20170511212046144185',0,0.00,149,0,0,'',0,0.00,0.00,0,0,5.00,5.00,1,0.00,0,2,1494508846,1494508980,0,'29e26570c09ccab8b12483f86e2e2c714e647ecf13e052df68baf64c52b6328a',0,'',0,0,'','36.149.65.134','','','','','','','','',0,'',3,1.00,0,0,''),(462,'20170511212102446253','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1494508862,0,0,'c93972ca39b734747bbaaf4414c9f6ea77357735d2ac50b60a1cc515b3f82e43',0,'',0,0,'','223.104.187.79','','','','','','','','',0,'',3,1.00,0,1,''),(463,'20170511212351961945','','20170511212351436332',0,0.00,149,0,0,'',0,0.00,0.00,0,0,30.00,30.00,1,0.00,0,2,1494509031,1494509100,0,'a4a772116ea5ccf9a720a8620b81791b01e0fb79d6f43ef4e4edad6160b8e524',0,'',0,0,'','36.149.65.134','','','','','','','','',0,'',3,1.00,0,1,''),(464,'20170517224012218182','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495032012,0,0,'dcb259cce58e076348f8c261c41b899bcd8906338cff274845899754a954fe45',0,'',0,0,'','116.2.250.197','','','','','','','','',0,'',3,1.00,0,1,''),(465,'20170518000053130782','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495036853,0,0,'db56db9db9bb530ab9c28f702f39382aba3781f57809c9f6be690ff7d956de52',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',3,1.00,0,2,''),(466,'20170518000148831328','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,200.00,0.00,1,0.00,0,1,1495036908,0,0,'5d5f829374f0e4ecc83a8d5e8dc3029e69bbe5a5aab60092d7c2ae6029ba2b4e',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',3,1.00,0,2,''),(467,'20170518112954727797','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495078194,0,0,'de8904aecdd112f68d2797feac2a8cea3f98dfb95797f3530aa8677a8dfc6a62',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',3,1.00,0,1,''),(468,'20170518134800144940','','',0,0.00,153,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495086480,0,0,'8f8693dcba214a2a404de7b09f052230a34e98f7e0d97f145e4fffdd05533cf5',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',3,1.00,0,1,''),(469,'20170518201855663757','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495109935,0,0,'afa01daa105908bab83ba3f8a4cbc0129f919c29c335bdfd0973282cbcbd341a',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(470,'20170518202009935360','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110009,0,0,'4595da113879dc181fe96b5623086dd0eb050a1ff105ccdedd2eef5db79213d4',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(471,'20170518202304349990','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110184,0,0,'2a862ec1f94cfcce422e0bce7092eee602a8940d33cd7b1e49a6e614de870840',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(472,'20170518202750122670','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110470,0,0,'12a58417a31ff7e561de28ce0720b65fed6c1fc33e3f2cbfc43563b1a7d8d76f',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(473,'20170518202915925517','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110555,0,0,'3c6789a902611370bace8e7b547af2b1e13b8284b1812314a55af929cf02c5a8',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(474,'20170518202934548986','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110574,0,0,'9675861b73c743f307274d16188dd20ec39e9d4635cafd1111466e303bbba60c',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(475,'20170518203037144169','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110637,0,0,'094ef00ef68a0dc7859a8be0b500290f0f0d93bc57a00c94f2fe5806aa18009e',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(476,'20170518203231185479','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110751,0,0,'73344dd29c59196e254465e057850bb7938a94b9b8d60b31df71c9367e62e90b',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(477,'20170518203236151511','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110756,0,0,'a158595ba65631b7b89758e0f48b175f4416823ec38265bfa3a5a21f69490803',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(478,'20170518203256189860','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,200.00,0.00,1,0.00,0,1,1495110776,0,0,'669c03998d9a53d82153ed9b411c4766a0956fd6dc608030c36ccad712978a06',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(479,'20170518203317177260','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110797,0,0,'6a8a5e0de12e99fbf3efb7347ebca84b42f6c154115a83d826ad37a0ec0f99f2',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(480,'20170518203344270097','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110824,0,0,'f32887d33b3685b3d2c911429846f80ca2baa91b2f96788a485e0bab9034c734',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(481,'20170518203356319511','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110836,0,0,'dc72d4ea9674c5f06fb79113fdecd2b73e04000863b247fc3955b77c94b61401',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(482,'20170518203407435756','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110847,0,0,'e4ffa2874cdf1e94548e2e7fe6115dfedf8af984384e6145362df891c9dc73c9',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(483,'20170518203425904557','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,15.00,0.00,1,0.00,0,1,1495110865,0,0,'b3ba11b0e7a1085230f8c7169467f00ba5a9fb36bb6f658f0bc54a5be0cc7724',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(484,'20170518203556210491','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110956,0,0,'8f221c40596967f4d5430aab7af27dda6ff4ab652f256b920bb5fab262035013',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(485,'20170518203612342438','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495110972,0,0,'74b5048c597faf4436228cd81edfcf0bcc3c83a3ac9051c8becb367febaaea90',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(486,'20170518203940168156','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495111180,0,0,'e9f2cabb689a25e33751bf65cf6ef6d37a6e6604bfb954d75df38259ef8c7147',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',4,1.00,0,2,''),(487,'20170518204234140269','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495111354,0,0,'03858e013fa831eeb63f7ade4d916f4e5d215a0a2602f6f2efe3847d71dff378',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',4,1.00,0,0,''),(488,'20170518204948970194','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495111788,0,0,'bffb6203a578735be4eee5f8c0bdb6e064cbaec28de34e9847afcc6d2bec588d',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',6,1.00,0,0,''),(489,'20170518205241463595','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495111961,0,0,'1fc165c4c179e158aab4dd81a69003d9fd2fadcac63acc9ae227964fa2748305',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',6,1.00,0,0,''),(490,'20170518205316771745','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495111996,0,0,'28911040c5d3a7635e2f4314844b4750f85ea87bf596ab35632850c3fdabe789',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',6,1.00,0,2,''),(491,'20170518205415851784','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,200.00,0.00,1,0.00,0,1,1495112055,0,0,'0444b9c1ae59e07c315e083db8e6589df3dcea9c747b0756b9758e48040904a2',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',6,1.00,0,1,''),(492,'20170518205633705466','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112193,0,0,'0d0b18e19c2a99ad9458388e6ad1e93f117fe47cccd1a43b0856ab2a5c5fae71',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,2,''),(493,'20170518205638395236','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112198,0,0,'ffc939a9f70ee9927800cb6832d9af544f38274c858b4dbbaf48762a11728a8f',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(494,'20170518205644986459','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112204,0,0,'5c7e14961d5c2ebdac5ddbe4898d581a2326a32c023edecd2e8bb5ae609fea7f',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,2,''),(495,'20170518205646152898','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112206,0,0,'330a381dedc896f63c060c3f69403e8ab965f095a98a4986b88a05a919723d2e',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(496,'20170518205706769761','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112226,0,0,'05182ba02e0471ef564b1d28a224381b8b268a158d3e72ec300cca2dd3988836',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,2,''),(497,'20170518205708355940','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112228,0,0,'7eab36049fdea449426e421500b71ae8c44ff96a45a9d2a32652fdcc53992a68',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(498,'20170518205851445375','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112331,0,0,'5ab945e91e841fdc530e905c2f2b7fbee0cf75546f8fd9d5976f42733d04a0af',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(499,'20170518205854337352','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112334,0,0,'bd538790e12c50ba95c4f687c4fb430fb7202d1da4f6c81492af7307b1a87bae',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(500,'20170518205900946632','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112340,0,0,'8904950131c6012b52f7412ce7b94e1cc99173c5b0a2172d82290d96bf09ffd7',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(501,'20170518210113325343','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112473,0,0,'5a83a34d8a55868c7a3f3327ad89bd4d5401bb0c8d44cb507133863a2d2aa8e9',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,2,''),(502,'20170518210139391163','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112499,0,0,'d93becf1bf2d894a0f120fe0bc7ebda436d36f023937cc4d8730459d39d3c3dc',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,2,''),(503,'20170518210156951035','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112516,0,0,'f5e612c6dae487c63f1a0cde09316c95e50ed10536ab6e8f6fa61c49a2849131',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(504,'20170518210220904150','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,200.00,0.00,1,0.00,0,1,1495112540,0,0,'4f21dbd7bfac01d28d2cb6c23692f53f9e6e7935bc83cc5f24df520a85bc03f7',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(505,'20170518210255387779','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112575,0,0,'16c116505e6b332a0101e09c5746a87a4ab7336a19a5329347c9eaa86aa55994',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,2,''),(506,'20170518210342804174','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112622,0,0,'009c2ad9fdf711f9928f5e41f1ccc63f7a447af78bc80e323fced2f27d15f333',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(507,'20170518210342212455','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112622,0,0,'99fee4b1e1e632bf74220350d5eb26ebce7ffa16c4ba1c9e86d0c6612b5deb10',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(508,'20170518210356830926','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112636,0,0,'bf38239b8bc42f294f9b4416f653a10d07512b8a10a939bfebf32766ee1d532e',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(509,'20170518210400436519','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112640,0,0,'07c2a5d594a41b9d96ab7a93c42943804f64d8314402f8ce34aa76fef08f887a',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(510,'20170518210432580568','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112672,0,0,'57b51cf0c3c31532e4bd1d41f9fa20daa5095523d0c5668e24a6aed66e619757',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(511,'20170518210438358772','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,15.00,0.00,1,0.00,0,1,1495112678,0,0,'eccc504ff31e36bee15d40e4f40367338e2b9d1f5c2e8e7a974f6483aaf57628',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(512,'20170518210451314345','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112691,0,0,'95b99d58f0b1ea976fcd6277c50553f38983413157870c395874821a3d206a0b',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(513,'20170518210518887833','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112718,0,0,'19c0bbf368cf679481aadc1f6cd09fcd6e136c74280bbeca2bd8d905426f2505',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(514,'20170518210527969441','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,15.00,0.00,1,0.00,0,1,1495112727,0,0,'1836ae916973319a7e933acd477c44e71f203adfe7a4ce842ff68c3c3f388ecc',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(515,'20170518210536977630','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,50.00,0.00,1,0.00,0,1,1495112736,0,0,'8bbbf2c0db2fb0b9210562ef7c2f3e6fef8a62c4bb8ed468b2f6788e58fd56d5',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(516,'20170518210609523466','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112769,0,0,'9c9b2d5628b338744dafdf0db2f82b3233946d1dbfbf5a7f11333a8a6cd8e41d',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(517,'20170518210619736760','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112779,0,0,'4599d05f8e58b498286356e52ef5611eca65571ec623dbc5c0e82823a2dddad4',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(518,'20170518210622877125','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,30.00,0.00,1,0.00,0,1,1495112782,0,0,'f3656d974a2959e0440a596dd589cb1ffeedf74536a9f04e04e163d5719fb679',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(519,'20170518210629406194','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,100.00,0.00,1,0.00,0,1,1495112789,0,0,'4c5628bc77f2d74012b123e404a3e1ba80f8ea3360f6a181aa65155eaad07653',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(520,'20170518210647371432','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112807,0,0,'8d204d04c4f414c6afaecaad88435d45429ee1bbba06679a05230f8a54b70405',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(521,'20170518210704314471','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112824,0,0,'7030898d39bdab9ae04c708eb7da91bced8d4bc5150e5264a6f4b0f66f3156af',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(522,'20170518210813251446','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112893,0,0,'4c5dcb2521691f6327d845d812242ed656ed12c294d1c37b56c4c97c29228353',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,2,''),(523,'20170518210827324685','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112907,0,0,'21a18a0dc7f0da32659693036e026ea1efc80bc90dbb4bb0782b029c2cc2a985',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,2,''),(524,'20170518210854496457','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112934,0,0,'c2ee1fd5708cd1896f1375c270ddadaa41f269ae6315c5f312d2e225085f0e59',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,2,''),(525,'20170518210936247994','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112976,0,0,'e3029752cbe1617a55b17d61f968bf56e3c845dfc3aa669261822631cf0af660',0,'',0,0,'','36.62.173.92','','','','','','','','',0,'',5,1.00,0,0,''),(526,'20170518210947300862','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495112987,0,0,'c27ca4e4d3f8deff1ad4174dc3b1dbdb60b1e4b8a8b017d78c1e21c26fdd7680',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(527,'20170518210958991855','','',0,0.00,151,0,0,'',0,0.00,0.00,0,0,50.00,0.00,1,0.00,0,1,1495112998,0,0,'10aa66ba9fb043ce646f80645129f3e58b2cc2374c8e7cb082223e46fc3b4bb5',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(528,'20170518211340777274','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113220,0,0,'991bec569aa8e62ef94d8be33e30dbf1b51eb9a8f2a75c497233875fcb204a46',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(529,'20170518211352977071','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113232,0,0,'a42d1a888706f6ec95456eea122d64d63f699ac8c4a93a9ea2f25e7a9a3387a8',0,'',0,0,'','117.136.95.53','','','','','','','','',0,'',5,1.00,0,4,''),(530,'20170518211729723673','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113449,0,0,'62bcdca845ab14f69cbbfbcca07047530aa3dc987c9ae124e23ccf9768353051',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(531,'20170518211736598777','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113456,0,0,'c033668194d77dcc884dd6e4756c82a1891a640e7679f31ef723c9282f24ac94',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(532,'20170518211736650659','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113456,0,0,'88687b6a078f877b2e4891d0428ad972c9069fe0ea8c49a7f8197a195f5b2c05',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(533,'20170518211740208440','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,30.00,0.00,1,0.00,0,1,1495113460,0,0,'8d2bbce8ad5af6f01676ded460b34b74c037e35237eedf1c5a4db130fde90d15',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(534,'20170518211747556082','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,30.00,0.00,1,0.00,0,1,1495113467,0,0,'d8517bc00940e12668e6d9f21b6f38993f69fdaf40dbdf8471274aaf67dec084',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(535,'20170518211751474170','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113471,0,0,'7447bb8ae3d124e812abcdfea5e0ede16d9519ae633a558bea4a56acf950d52f',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(536,'20170518211833833990','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113513,0,0,'a9b7e3b9321f2cc8587333f924ad688907aad39d75f47587c6a2a55a9a640bec',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(537,'20170518211938349440','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113578,0,0,'05d718e7211ed815710d3a4aa70d658b44598f2663a7b0cd99da7d2ad2f8ffd6',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(538,'20170518212011609310','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113611,0,0,'be5d0620bef6a891b77311741c2a54f8da6482925826a4fc3c92ec9097ca27c8',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(539,'20170518212149495770','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113709,0,0,'0e5d6777821efeba762f3ed160db43c88c8d8784536eb1ba5740b3816080b5ed',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(540,'20170518212428949276','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113868,0,0,'4444445c8a0220f1df75f2e310fb63e0df213f9f4bae3310aaee51439b76194b',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(541,'20170518212607644684','','',0,0.00,156,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495113967,0,0,'d0c948edae68683fc4044ce907617c615dcb2433c8c0224ce91bf5f1467dfe73',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(542,'20170518212649124634','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495114009,0,0,'6cf2569631c2b00064a74f9dd4442dd2ee89b4e60b4b210e2d29834ad9f4ea66',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(543,'20170518213130897970','','',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495114290,0,0,'4e6891b501ea2803dbf12ad2f6d14fb939fdfeeab2fd32fea556f877dccbc43e',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(544,'20170518213224485271','','20160301200040011100760021939020',0,0.00,150,0,0,'',0,0.00,0.00,0,0,5.00,5.01,1,0.00,0,2,1495114344,1495114357,0,'b83bcd6bb3a611aa7b59f60fa3f0f2bc3a5e0bb0630ce0d522916f3ae54e7f95',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(545,'20170518213646601717','','20160301200040011100760021939020',0,0.00,158,0,0,'',0,0.00,0.00,0,0,5.00,5.00,1,0.00,0,2,1495114606,1495114616,0,'eef109430ee31397f2bca4220d89e90236de09d4f8ced1705bd569e359d5170d',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(546,'20170518214249146836','','10000503011705180042010001010232573366899',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,5.01,1,0.00,0,2,1495114969,1495115240,0,'99be76494a1b7009711962231ca9d14369c30770ee15c3b18690a204301635a6',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(547,'20170518214322389696','','',0,0.00,157,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495115002,0,0,'252ac03012e25f3ace673eb4099ab04e3d9c9430a4d1a897e913d932f9ffbc29',0,'',0,0,'','125.80.247.231','','','','','','','','',0,'',5,1.00,0,0,''),(548,'20170518214336675922','','',0,0.00,157,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495115016,0,0,'1d21cd79a57d224930f55735686b6ede1032ffe74793787c3178720f5ce87b81',0,'',0,0,'','125.80.247.231','','','','','','','','',0,'',5,1.00,0,0,''),(549,'20170518214338339250','','',0,0.00,157,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495115018,0,0,'46b309c79abab50483af5fb83fb03ad0ad97d7f779e73da2ac9c3b5f21b5079b',0,'',0,0,'','125.80.247.231','','','','','','','','',0,'',5,1.00,0,0,''),(550,'20170518214829367958','','10000503011705180042010000810224579916899',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,5.01,1,0.00,0,2,1495115309,1495115330,0,'7995938f48b7ce02cf0189b36e182ffe81ebb0d3515024e415233f6d13df78ea',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(551,'20170518214831257440','','',0,0.00,158,0,0,'',0,0.00,0.00,0,0,15.00,0.00,1,0.00,0,1,1495115311,0,0,'a6246118fea38433582b9785186aa0e2398716ba6b8c41c6d754c3c89eca25c2',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(552,'20170518215032250067','','10000503011705180042090000810255687396899',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,5.00,1,0.00,0,2,1495115432,1495115450,0,'2c0f2d9581876024eca28fb3f5060e47c5e8846aaf4af2e7770ce13d988c7ff2',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(553,'20170518215055180520','','10000503011705180042020001910245075066899',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,5.00,1,0.00,0,2,1495115455,1495115480,0,'8723311014507ef4a70f3853ca70f563de80ac7f9dbf69c88a7b10af6f867f15',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(554,'20170518215147854110','','10000503011705180042050001610241365036899',0,0.00,159,0,0,'',0,0.00,0.00,0,0,15.00,15.01,1,0.00,0,2,1495115507,1495115525,0,'92b27299e2036c9e591a2eb5a2f723fc71db52353e28985bf61df6eb8db38602',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(555,'20170518215532661735','','',0,0.00,158,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495115732,0,0,'e9cbe81b61ea3dfb10b4fd84981d13e88975d4f05a2da79adc5184c627215e81',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,0,''),(556,'20170518215625647312','','',0,0.00,158,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495115785,0,0,'b80dae741cdc30a11cf9167f5e3d83501380594b2f9a7e851fe75ceb587ba97b',0,'',0,0,'','118.113.201.247','','','','','','','','',0,'',5,1.00,0,2,''),(557,'20170518221325660145','','',0,0.00,157,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495116805,0,0,'80e2764c2f56169da750024d4dc81c29e020ba79282e27c8b4f9bbe77cd863ae',0,'',0,0,'','36.62.173.92','','','','','','','','',0,'',5,1.00,0,0,''),(558,'20170518221347242348','','',0,0.00,157,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495116827,0,0,'6b81c4598d19f2699b4bbf273181715bc33fe3c32a7c7fdba347fdd13f45d825',0,'',0,0,'','36.62.173.92','','','','','','','','',0,'',5,1.00,0,0,''),(559,'20170518221859155767','','',0,0.00,157,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495117139,0,0,'92ecdb1e06aa70e4f5ac232a8542ff4469adf74a475d42e8528ab24a28fe44fc',0,'',0,0,'','125.80.247.231','','','','','','','','',0,'',5,1.00,0,0,''),(560,'20170518231818353058','','10000503011705180042090001410259585926899',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,5.01,1,0.00,0,2,1495120698,1495120722,0,'7155e071f20d23215b8f2602aea774fcf7d5f5c22d9116c877235b27f681a897',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(561,'20170518232221991469','','',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495120941,0,0,'a7be99e01098aeec6052b8d1b3a9510c4cd665643b3c98485ccff38b3998d833',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(562,'20170518233549835664','','',0,0.00,160,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495121749,0,0,'373fb84291d4ace5ff2a715db923e449091da1e5178fd5565f15bc47207e7f96',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,2,''),(563,'20170518234956759575','','',0,0.00,159,0,0,'',0,0.00,0.00,0,0,30.00,0.00,1,0.00,0,1,1495122596,0,0,'de3f6388bccaaeeb3d23916b09c42b8b1f90a38313f62d61f3e44d6a46f1e97c',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(564,'20170519004417894251','','',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495125857,0,0,'32ac472f76563c7d19b4e80ce2fbaaaa08c8c94a10eabe63baed815217e54225',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,2,''),(565,'20170519091146559177','','',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495156306,0,0,'b64671df2313b1189f1c2e39ba7eadc9d9e79d14e9beb5dadbaf5fd9d2681eb9',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(566,'20170519092953998919','','10000503011705190042000001910078062116899',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,5.01,1,0.00,0,2,1495157393,1495157410,0,'b98a745ee181ee37bd19c9c9b90ff39d3276e0a2879e8a90182c5156196db335',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(567,'20170519102407400927','','',0,0.00,159,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495160647,0,0,'d90556f6c30ceeaea89529a2bcebe0c2cbe413664b6e53e89609ccdea8fdee1c',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(568,'20170519103125862659','','10000503011705190042060001310082087566899',0,0.00,161,0,0,'',0,0.00,0.00,0,0,5.00,5.01,1,0.00,0,2,1495161085,1495161102,0,'44449a42f2c42ffb0142dc1ea5483e7cf0b6c96bd41d16d5ae788805025f0e2d',0,'',0,0,'','116.2.246.134','','','','','','','','',0,'',5,1.00,0,1,''),(569,'20170524043345803768','','',0,0.00,163,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495571625,0,0,'b26be130668dea5aa32b7e00a55ca3335528614746f7f599feb6977752809da6',0,'',0,0,'','183.208.176.74','','','','','','','','',0,'',5,1.00,0,1,''),(570,'20170524141525807789','','',0,0.00,166,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495606525,0,0,'1200c67ac16886667ab8521b3c7e9b5e21e2dcd1698303ebdb9fb6ed6b529090',0,'',0,0,'','61.154.210.181','','','','','','','','',0,'',5,1.00,0,0,''),(571,'20170525162032921762','','',0,0.00,170,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495700432,0,0,'f0a58e32ff60561022f2e520dd3006cc606c40c06434b9ec7dee5a8acc2398ba',0,'',0,0,'','27.21.74.155','','','','','','','','',0,'',5,1.00,0,0,''),(572,'20170525162042482199','','',0,0.00,170,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495700442,0,0,'d4300b3147da42c74f1d2cc1afd428a849832bd6e46bc8a322b4e22cd03c3d6c',0,'',0,0,'','27.21.74.155','','','','','','','','',0,'',5,1.00,0,0,''),(573,'20170525162203214279','','',0,0.00,171,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495700523,0,0,'a05789a7fd32709cc9d9cb3f707cce22065a73f709260d83c45c10101f845a2b',0,'',0,0,'','111.2.103.125','','','','','','','','',0,'',5,1.00,0,0,''),(574,'20170525162411672574','','',0,0.00,171,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495700651,0,0,'fec512330d66bd74b8659b5e9dfafa57101cc322f5766865dab15141575d86a9',0,'',0,0,'','111.2.103.125','','','','','','','','',0,'',5,1.00,0,0,''),(575,'20170525162758377280','','',0,0.00,163,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495700878,0,0,'91b3738fa024508965f5f81857626dac1b153815930ca6f41cc3ea1bac127c5c',0,'',0,0,'','183.208.179.58','','','','','','','','',0,'',5,1.00,0,1,''),(576,'20170525164640961574','','',0,0.00,171,0,0,'',0,0.00,0.00,0,0,15.00,0.00,1,0.00,0,1,1495702000,0,0,'9d691cf5d697c098cff7631ea4836dc48a2f819e485a82b67ecff642c3568277',0,'',0,0,'','111.2.103.125','','','','','','','','',0,'',5,1.00,0,0,''),(577,'20170525181829608375','','',0,0.00,172,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495707509,0,0,'ad1875b66b1f99bd2c29e28c3b44713c21ac70509d9c6c40c6bb5ccfb2bac1e6',0,'',0,0,'','1.81.79.23','','','','','','','','',0,'',5,1.00,0,2,''),(578,'20170525201148447742','','',0,0.00,173,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495714308,0,0,'344501a295f30077f87f372fe7193071d583781d23cd000e2a505ac8141452e0',0,'',0,0,'','123.234.189.200','','','','','','','','',0,'',5,1.00,0,2,''),(579,'20170526033405335436','','',0,0.00,175,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495740845,0,0,'c0ad6bc87ee2daf1d8c77e8c8f625824dc1317995fd4843bf6aeccb42a83b6a0',0,'',0,0,'','221.192.180.22','','','','','','','','',0,'',5,1.00,0,1,''),(580,'20170526070303213735','','',0,0.00,176,0,0,'',0,0.00,0.00,0,0,5.00,0.00,1,0.00,0,1,1495753383,0,0,'60292c3ad11852f4f42bd1b2170b62c3128242908813c2b278b029a38230f793',0,'',0,0,'','183.253.138.12','','','','','','','','',0,'',5,1.00,0,2,'');
/*!40000 ALTER TABLE `ay_dingdan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_dingdanx`
--

DROP TABLE IF EXISTS `ay_dingdanx`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_dingdanx` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderid` varchar(255) NOT NULL COMMENT '订单id',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `cpid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `name` varchar(255) NOT NULL COMMENT '产品名字',
  `tupian` varchar(255) NOT NULL COMMENT '图片',
  `jine` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品单价',
  `num` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品购买数量',
  `canshu` varchar(255) NOT NULL,
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买方式',
  `off` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '扩展状态',
  `kahao` varchar(255) NOT NULL COMMENT '扩展处理状态',
  `kamima` text NOT NULL COMMENT '核心密码',
  `beizhu` varchar(255) NOT NULL,
  `biaoshi` varchar(255) NOT NULL COMMENT '网址硬件id授权唯一标识',
  `ctime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `ip` varchar(36) NOT NULL COMMENT '订单ip',
  `mhash` varchar(64) NOT NULL COMMENT '唯一标识验证',
  `huobi` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '货币购买方式',
  `tehui` double(3,2) unsigned NOT NULL DEFAULT '1.00' COMMENT '特惠支付比例',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '等级',
  `kuaiid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '快递id',
  `kuaitype` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '快递类型',
  `kuaijil` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '快递计量',
  `miaosufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '描述评分',
  `fuwufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '服务评分',
  `wuliufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '物流评分',
  `pinguser` varchar(255) NOT NULL COMMENT '评论人昵称',
  `pingoff` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '评论开关  0禁用   1 等待审核 2 审核成功',
  `pingtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `pingname` varchar(255) NOT NULL COMMENT '评论标题',
  `miaoshu` text NOT NULL COMMENT '评论描述',
  `ptupian` varchar(255) NOT NULL COMMENT '评论缩略图',
  `ptupianji` text NOT NULL COMMENT '评论图片集',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mhash` (`mhash`),
  KEY `orderid` (`orderid`),
  KEY `uid` (`uid`),
  KEY `orderid_2` (`orderid`,`uid`),
  KEY `cpid` (`cpid`),
  KEY `shid` (`shid`),
  KEY `orderid_3` (`orderid`,`huobi`),
  KEY `atime` (`atime`),
  KEY `cpid_2` (`cpid`,`pingoff`),
  KEY `cpid_3` (`cpid`,`miaosufen`,`pingoff`),
  KEY `miaosufen` (`miaosufen`),
  KEY `id` (`id`),
  KEY `pingoff` (`pingoff`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_dingdanx`
--

LOCK TABLES `ay_dingdanx` WRITE;
/*!40000 ALTER TABLE `ay_dingdanx` DISABLE KEYS */;
/*!40000 ALTER TABLE `ay_dingdanx` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_fujian`
--

DROP TABLE IF EXISTS `ay_fujian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_fujian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '附件名字',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户',
  `sid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '所属商户',
  `guanid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '关联id',
  `type` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '附件分类',
  `houzui` varchar(20) NOT NULL COMMENT '附件后缀',
  `cdn` varchar(255) NOT NULL COMMENT '附件cdn',
  `pic` varchar(255) NOT NULL COMMENT '附件原图路',
  `beizhu` varchar(255) NOT NULL COMMENT '附件备注',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理id',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '尺寸大小',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `token` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`),
  KEY `uid` (`uid`),
  KEY `uid_2` (`uid`,`guanid`,`type`),
  KEY `guanid` (`guanid`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=320 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_fujian`
--

LOCK TABLES `ay_fujian` WRITE;
/*!40000 ALTER TABLE `ay_fujian` DISABLE KEYS */;
INSERT INTO `ay_fujian` VALUES (3,'psbjpg',0,0,1,0,'jpg','','/attachment/all/201610/11_f72ae417afac0074d09f039628fcb16.jpg','',0,155471,1476184128,'24458080299420277b382b04fc5e1ad7'),(4,'psbpng',0,0,1,0,'png','','/attachment/all/201610/12_5b45652ccb9902ade556795fc5244da.png','',0,34709,1476258819,'eac3ba228133fbaee14ae67fd199c344'),(5,'0jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_dd9ead1124a6f4d89a3c6894f8a0526.jpg','',0,27339,1476754484,'58bb5a17e7860d21901f4bd05b0fd500'),(6,'1jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_6ed961bb8e880e07173f1c2be999d2a.jpg','',0,96511,1476754596,'45e07229e8313c15f05d48e4ac18993e'),(7,'2jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_494abe571a41a4f6afd8f7f6db117d0.jpg','',0,75864,1476754596,'85adc6f3421816378744438a493a5b5e'),(8,'3jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_1bb07013afbedfa0015030e6a5aa834.jpg','',0,103610,1476754596,'c90b24e7409b8e14b3b3281c5e014c07'),(9,'4jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_02d37580db764781374536af5892584.jpg','',0,72332,1476754596,'f48166f6a491b100bbdb32b53d2b3949'),(10,'0jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_ad4f55d5149e9250575115b5ae42622.jpg','',0,106593,1476754678,'52f32b5f5176953a99cd92618d4e1f4e'),(11,'1jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_84d174392275624ac89e8d09c540174.jpg','',0,89477,1476754690,'5bc29f418a14fb5e173862fbaf90a2b9'),(12,'2jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_9ac60653c6e480f4045b5bea8975f1d.jpg','',0,64779,1476754690,'2c08b2b403907ddf9e929bdf6e0ad8b7'),(13,'3jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_e5ee1fef550bdc7f8c4e9df58ebdb2a.jpg','',0,74895,1476754690,'52c2c6304194e35065364fa9efe70228'),(14,'0jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_7f6c76024a989897d5b3ff72eff15c5.jpg','',0,92584,1476755188,'058fbb8eb4941dc1985b3b0b07c58c34'),(15,'1jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_be3ad8bd0cc72409ca03b02ac12ee65.jpg','',0,106150,1476755194,'84be8d6e9daed7a0641ef8bbd7f030f8'),(16,'2jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_637bc3a3140ec850423968670593e00.jpg','',0,96539,1476755194,'f907043e6535ad141014c160163ff34e'),(17,'3jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_6b6f4ec86870491e1ae96494630950a.jpg','',0,90716,1476755194,'f59b0ded82a3220feafa6eff6c4a0246'),(18,'0jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_1c2b00bf165794c9bb22f78da1bad8a.jpg','',0,98205,1476755248,'ea7e453f96211c0941ed393bf9508420'),(19,'1jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_e4f4bbc604fa8b6233cb8c75ae762ef.jpg','',0,105104,1476755253,'7dbb71e9d13dca355162a3efd12e6b6e'),(20,'2jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_2f56261d8076511eadafc4b78203140.jpg','',0,119157,1476755253,'67899591b079695ec35a639f808cad77'),(21,'3jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_9bd0d1c2ec1bfd40735795bb491826b.jpg','',0,77199,1476755253,'e889f6cb1c24f3c98c9d586abfe0a990'),(22,'0jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_a92e38cad3169582716353a0bbfcf13.jpg','',0,106005,1476755322,'657a26d9591cdf6b75d2ed529529ee31'),(23,'1jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_9e87e909169d0aee006fe46af10cf22.jpg','',0,81304,1476755328,'233f3fec31e357bca51b2012eee7d406'),(24,'2jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_07c87c8a3211810fa5a77952a2fb4de.jpg','',0,96210,1476755328,'45247bb506e48337dc7ce7981e50322d'),(25,'3jpg',0,0,1,0,'jpg','','/attachment/all/201610/18_7047d34dfa4d22bcb547808dfdf4d0b.jpg','',0,82378,1476755328,'f17706d89659abf5f41cdedfeb2fb828'),(26,'未命名1png',0,0,1,0,'png','','/attachment/all/201610/24_b2d5e3afa55523a2afbb1b9c93007d8.png','',0,50460,1477275363,'06d87a67e405a50c9e8511b2738f13f6'),(33,'lkpayphpzip',0,0,1,1,'zip','','/attachment/all/201610/24_703a4c579c024ed96cfc6a488a22334.zip','',0,128815,1477296114,'9014953ff66e15435c96ba1d1bc6a012'),(35,'未命名1rar',0,0,1,1,'rar','','/attachment/all/201610/24_1b40e00d5cf689f957f757b350bbef8.rar','',0,36397,1477299818,'5eb60b945c051093b84f39559430be0d'),(36,'3a7330d134d34defdfbb6c26f53cef71jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_6bd87edf1ff23afab6d7b6f88fcafe6.jpg','',0,13018,1480398386,'49d8c5b5790b8522db8792b7679b7348'),(37,'1180x18014332656pss8hjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_45be11fda611978770356d338d0f7d1.jpg','',0,24342,1480398466,'bd8f38c8db0a4ed3401c7a5ffe686a54'),(38,'1370x37014332656pss8hjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_cedc99c93ec79fc5af931819f3bbee5.jpg','',0,77686,1480398751,'1586cd81c45be02943aea3b8f27abe61'),(39,'2370x37014332da9a8313jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_fa8730a1556c6ef4b29680f069aca3e.jpg','',0,57428,1480398751,'311dc7d7b833b6cd8e049ad05dcfabbe'),(40,'3370x37014332da9a8313jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_153a659fa7be2713ee26b860efbe0eb.jpg','',0,62513,1480398752,'00b7c24c9f34a13bca0bda2a9568844f'),(41,'4370x37014332xpysthhtjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_05f6caee4b6209ce2352b80ad4e9a8a.jpg','',0,70124,1480398752,'536e4c33391f2e7874fc07b27c5c93bf'),(42,'1180x18014653u7k14cs1jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_bcee60972caa9ba06cce6ed76bc244a.jpg','',0,22194,1480401429,'1d53a121ecd66d4db339ef864f822d3a'),(43,'1370x37014653u7k14cs1jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_012f0bdf7761612b0c76aa400772f3f.jpg','',0,70164,1480401473,'c75f47738ed76530ccda0a8ce6dd5fec'),(44,'2370x37014653sf34pysdjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_d043b109ff3d59b0e480603755c0576.jpg','',0,124367,1480401473,'885c822b94b3c481913b9a9fa0fa17fe'),(45,'3370x37014653sf34pysdjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_ef4b900b1895414960ce03e000efe02.jpg','',0,107768,1480401474,'bcdc0eef49dd0642758daffe17e07a36'),(46,'1180x1801460788ffu1p2jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_84c3af14b4f036ffd586c76a9fc7c0c.jpg','',0,26495,1480402084,'c9397880ee8a0039712e84f2ee1d3abc'),(47,'1370x3701460788ffu1p2jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_8e1edda131839e8d71eeede63ef3512.jpg','',0,87644,1480402151,'ad046b6c711ecf68e34b3724c4595ba2'),(48,'2370x37014607pus1stp5jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_adc09549490dcb63f0246771e36ac44.jpg','',0,125905,1480402152,'bf9597d438642342ceed5b14159fbf02'),(49,'3370x37014607pus1stp5jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_ae14a8b5c26a5377734a8300e8504f3.jpg','',0,98759,1480402152,'08494c82e28d6fbb711856d2b81cbabf'),(50,'4370x37014607pus1stp5jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_ca8327a22c140742c2846e676d16bba.jpg','',0,91861,1480402152,'b7f4b5245191ecd4c41445d2a232b31d'),(51,'970fa6943a5a667b1752c985541fcc16jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_3b5ba20619293a1bac024ca092660ed.jpg','',0,11582,1480402562,'4910bd7bad1b841a3a1201f3f8c1eb26'),(52,'1370x3707154pdxrs21bjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_e20854559e9e8267cf1afcdb417d2b9.jpg','',0,80471,1480402718,'8bb94489a791d8aedc2164876a67ff78'),(53,'2370x3707154r9kfxw37jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_74f537a790f0ac34108bbc8e7251941.jpg','',0,95184,1480402724,'fae71f18cefcf19a31acdf97c7056c72'),(54,'3370x3707154r9kfxw37jpg',0,0,1,0,'jpg','','/attachment/all/201611/29_f2db5f29d70a4cfc7a2e9b3be4c4136.jpg','',0,122398,1480402724,'790736fc50e40923c91e2b5c3c3fd418'),(55,'4370x3707154sarfy74pjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_8293d485d3a96b09608b00d1130c81d.jpg','',0,83161,1480402725,'6b32f38acdca9e126ec932b691ec50a3'),(56,'1180x18013522r3t2463pjpg',0,0,1,0,'jpg','','/attachment/all/201611/29_2152781d5751d2f95bbe2739331e454.jpg','',0,28521,1480402825,'11a36d07f9c822133a5a85bd0b7ebcb0'),(144,'headerfooterpng',10,0,774,2,'png','','/attachment/image/201612/06_a3dd8ee582d5b5664e1465f9cb878e7.png','',0,17815,1481003058,'77ef529727356d855cb58c71c87ab1f4'),(146,'dolistpng',10,0,773,2,'png','','/attachment/image/201612/06_e322510f9fff30e293fd7ae7b6d4149.png','',0,9405,1481005603,'47b23956981d37e20a8d4223403d70c7'),(150,'f582b2b28c16b5068d1a1c3ea521385bjpg',0,0,1,0,'jpg','','/attachment/all/201612/29_51e53d19853f1d0b84282fe8974be88.jpg','',0,13826,1482995117,'6b8f0f2d4b72e6df9935a82b7be78f9f'),(151,'7af2dd704644e363fcd7535a83f6a9a6jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_a5b6b3f26b07a4726b64b1895c8c706.jpg','',0,14881,1482995160,'7311d75ae4a5ed3d70c0da14bea6124c'),(152,'f2b5c6209decb351fe462986aae563f7jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_a5fb5eeb479a82a6bde104183245661.jpg','',0,12770,1482995190,'b12a568811c194d4866b15be4fbd2716'),(153,'1b6f4ea6c728e07c3d30a636808a4e74jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c82f5ed91d527e3a588da4c9995fc3b.jpg','',0,10882,1482995247,'d90ee3b3ceed809334f93af4622c146c'),(154,'9beabc8a367afc3c3d6f3c8612201bbejpg',0,0,1,0,'jpg','','/attachment/all/201612/29_00c35c2e3bc9b530926ad8d9b9242eb.jpg','',0,16086,1482995323,'8e3ff5db2fe7e9c65638854d85d7166c'),(155,'934c2187d359440f8463b8efa2d710f0jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_02f91d48073f3e6b22e8942b9bd3e67.jpg','',0,9193,1482995546,'fac2558f99762d207a9351fd51fcda82'),(156,'08b19acc33f379dc4411a4efbb531484jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_033c4c8686febe44a36f4ec50a80963.jpg','',0,9811,1482995581,'9b9e308771e562318edfd64c269ea1cc'),(157,'4f432c28676d8144df97fd0d4104fe5ajpg',0,0,1,0,'jpg','','/attachment/all/201612/29_a1c2134802c46bf73590bc7d321f039.jpg','',0,9276,1482995620,'c61f03dc26799d9a629501a89c819893'),(158,'f623b7c7bc01a4f8fcee0698a96621cajpg',0,0,1,0,'jpg','','/attachment/all/201612/29_033a9e81a8a073d6a6fd17d93c6919a.jpg','',0,5027,1482995719,'8d478b1ff6b045cbbc980362d0a280b4'),(159,'b04050b59277228bd5b6191b6cee4addjpg',0,0,1,0,'jpg','','/attachment/all/201612/29_caf39ed0b99941ca9d7c9765dccbfe8.jpg','',0,15514,1482995745,'66d86c40bfb5023bf1a843033e2cb5c8'),(160,'ef45ccb8f10dcd9b92dd8fb1ef0ebd31jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_1413b0116bebabcc2d362daf0888e0a.jpg','',0,7380,1482995771,'2401c6ef1c13ad5ddfcecf56b5de3eb7'),(161,'ff10f837d510727aadb3bdbc6cf7956ajpg',0,0,1,0,'jpg','','/attachment/all/201612/29_b3ffff1544371e69cdeb5371c11a45c.jpg','',0,7969,1482995803,'f85659e55b2092ca148c56444d638c1e'),(162,'0342dde0da6b8148b82be9b62d150b70jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_0ca1a12407c12388ee1679ebc0ed226.jpg','',0,16332,1482995840,'7902df0d4a72f4dbdbe6cbea47cf4e7d'),(163,'a895393705451501b6eb264fc14f9434jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_fd55e29cf420304aa44a9e0451c18f9.jpg','',0,3741,1482995971,'04a1a24996f34fb1f0709bd0a07c458b'),(164,'7cabe6702366038b8e039a13310790ffjpg',0,0,1,0,'jpg','','/attachment/all/201612/29_19d513c83fddb70a010a76f5e3590c1.jpg','',0,6013,1482996004,'3468b919751b52b3daf6380ad3e6267c'),(165,'a7951792780f8a012dd1832d96a2c038jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_bdc27f1f4876337c3628d41aa1c7f63.jpg','',0,6195,1482996080,'c9d7181567f0e482b2819dbc108e7a7f'),(166,'a87aa7045f08fd0c5095e82970a2cb0ejpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c53ccd4af6b857a07e4a0e2a31c076a.jpg','',0,6006,1482996113,'d9f2cc88e3e79a83d2801b717ca4b1fe'),(167,'810c1048c9d24091f0532b18fdb8b760jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_24a30e7e8d7335e2aac2437605cb97c.jpg','',0,19548,1482996143,'82042b8ebd6188e44d39185299f0bd3a'),(168,'bd95ebf9c50341be07e588015b6f5b18jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_0371cddd6094659c3d8e5d2abd01b62.jpg','',0,7970,1482996175,'ee8aab1c70bccdf2f5e16599b18d28ae'),(169,'51e4c1cbcbc3f552dd94fe80151beff5jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_8bfb1ea693b673db2630cbcc25ad9a6.jpg','',0,3687,1482996246,'bcf9f20851ba65c5c5c944e22eb9bb8f'),(170,'07a75034a0006cfe6ed316078cfbc0a6jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2999499da5184f9b56068b90ae6bc29.jpg','',0,6076,1482996283,'768535564d1230368ebea275607fbc56'),(171,'4e547d71cf71e05adc2c031aa934cd8ejpg',0,0,1,0,'jpg','','/attachment/all/201612/29_4a0594b379740b0104c319d818c08b0.jpg','',0,14549,1482996317,'3079f0067ae4d8fd3846881bd65726b7'),(172,'1180x180146279a5ct1b8jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_59c10a2a320dee08bd105dceb919e76.jpg','',0,23600,1482996461,'363d2cf711d26998b201ed64b5760c44'),(173,'1370x370146279a5ct1b8jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c1b06f2239bac79aa03353aa35f8f8f.jpg','',0,76544,1482996501,'8a2214585b86c640edd0e93373f17c93'),(174,'4370x3701462751usbwatjpg',0,0,1,0,'jpg','','/attachment/all/201612/29_a0fc8d36a1578c7d31f952fc3ebdfc2.jpg','',0,100213,1482996502,'c3aa35ba30e06c336156a15cdae431b4'),(175,'14800711388455jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c4ca4a02de893b512cf0f4fc79fe897.jpg','',0,303792,1482996593,'810bd03e6c4cffbfd60f8b17ac08a80e'),(176,'1180x18012909w8tyh4y2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_8fca2210055ed83faed9c299a4d64c7.jpg','',0,26180,1483012067,'fccf37b8d91b45259daaf13fae0b902c'),(177,'2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_262b6cdafca85c6c723270146e3e4ec.jpg','',0,87862,1483012075,'2cda9d87248c4b016c5a1876ea2a99d5'),(178,'3jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_a73a25458f4636be2f6297780230b40.jpg','',0,80634,1483012075,'0adff7d061f141c601e63dd7850f5e06'),(179,'1370x37010240ss1kst4fjpg',0,0,1,0,'jpg','','/attachment/all/201612/29_6a4a7817c66b2126cd0b192a2f4ad28.jpg','',0,79822,1483012126,'b758311efc035a3811525f2cd1388f51'),(180,'2370x37010240pwr23s7xjpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c1bcdbba3fd6b994ca0c65596433ebf.jpg','',0,93119,1483012126,'01e133f6cf138029a0f0a0cd70fc9db0'),(181,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_f42ce9185b4d7e7e7a17326fada38fa.jpg','',0,21636,1483012194,'d4d611e836a0782eb95aac48f9d5d541'),(182,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_47d1a7c7269f3986a2adee7a81517e0.jpg','',0,323423,1483012445,'e69512e11481c18a1081dbb2fcc8c1d4'),(183,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_9240dc179491b3db6c08eefaaa94986.jpg','',0,27828,1483012972,'31593b300d7850965a0a695d4163a942'),(184,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_5fd06489ee28f98acbb5e5450d483bb.jpg','',0,126599,1483012993,'be4785fcb38d92b6149f3dc6c00ddd3c'),(185,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_10b1cc925470c17ff8d00d957df1f95.jpg','',0,104773,1483012993,'4b31565676ef5cb90bb56c354bcd6ced'),(186,'14780552354194jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_8b6bbfac426260c5de0b690dbdace67.jpg','',0,313529,1483013536,'7a303ac68cd21bab4ace190addee1adb'),(187,'14780552362131jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_1c51c7712dd6a81e79d02ddf9fc01bd.jpg','',0,326522,1483013562,'eff3c4bdbeb5270dec5ce11989699682'),(188,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_b70087fdeb43816827559c8b89e37ac.jpg','',0,28165,1483013623,'b7120a5c95844ea65de4df1f32145562'),(189,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_4e42a965656f7e4a34242401371b57b.jpg','',0,219998,1483013680,'75e77095af602c7f5d0993df204f5b55'),(190,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_03cccf5cdbaf8d9dccc658325ea746a.jpg','',0,158214,1483013681,'ca239362632706d85725e05cd582c1ec'),(191,'1370x37014043c27y88p7jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_384fca959825d55d78ad63021abee5c.jpg','',0,94979,1483013836,'f991179107769c7d89985012f3fefda8'),(192,'3370x37014043wdpcf4rxjpg',0,0,1,0,'jpg','','/attachment/all/201612/29_07e0d8245bccbabeaf6601b018d86d4.jpg','',0,78922,1483013837,'ff8bad8d0d0ff16bf8a27d3e97a6bb3b'),(193,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2242fd6e34e0c880052aaf5f54cadac.jpg','',0,93348,1483014037,'f17f1703ee6751f743b41cca5064f6c3'),(194,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_b5823a7e50db83c615473892705ed8b.jpg','',0,71188,1483014043,'03356086c5d46f53a84b9be7c1436224'),(195,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e71fb0a0dbeb9fe1a69f9b4723b55e7.jpg','',0,76229,1483014180,'4e28f0b071c85c5a6c4dc6f2a44f4be8'),(196,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_23820eef026033c9e25c9d068265166.jpg','',0,72293,1483014185,'b8ef3f6b3b048b283bf7658bda1e3253'),(197,'111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e637d8b2466dee38ff522f337deee57.jpg','',0,24361,1483014216,'bf78c9dc868104ddadf0b5a347a6f7fb'),(198,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_eb82a35904934f486df0410978887d0.jpg','',0,160520,1483014281,'e9f5adf4f83ec31c829340d00456ef12'),(199,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c0667f1b5999fe07fe1c371184369c9.jpg','',0,89237,1483014324,'f4f4a13ae10fa541925128b9dba80961'),(200,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_4b0968fc2bafdb0405cc69a151332e1.jpg','',0,76524,1483014328,'5bdef2ed43d95dfcf3031815bd8e2336'),(201,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_f1beee1d135ecdd62e509398ae2d3d9.jpg','',0,83998,1483014501,'e504d431f29089f087f7ba235e8be316'),(202,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2ea4a1e96b04381a8eb52b5ebe6b33e.jpg','',0,72797,1483014506,'4bc607ff84b9f2da6b28977d01634bba'),(203,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_ce2cde4361dc516bc5363cc1d6f50ec.jpg','',0,97855,1483014638,'b99b3dac3b55ec58dee0c992172ac674'),(204,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_f686580ce6e11d21e1c061ef61b1461.jpg','',0,80379,1483014644,'a397adad78201df617d49a0253199dae'),(205,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_bdc5753452e997959a100b93b10d1fc.jpg','',0,81681,1483014804,'99ab036b9bb76f8a3107356f44c52e84'),(206,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_386c76570e6375d6704eabffd12e083.jpg','',0,66487,1483014809,'8ab40d9bd46d9bc31dd9567893c374e9'),(207,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_60c919be10bf49369ccee6bdd2a1c48.jpg','',0,75843,1483014890,'f8567eb5c225390a356709ad4eccff89'),(208,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_5a75cd9b9c5100e9ac6c6416a92ff70.jpg','',0,85101,1483014898,'07ecf66703bc57eb43457a021b1b499c'),(209,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_82a76bf45d195de7511c2bc9cb359bd.jpg','',0,84860,1483014921,'3c257b8b623a1bc000b24ee8468b7054'),(210,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_031e6df2df4f07c3b487513d8167209.jpg','',0,258724,1483014949,'514a0f2220774380228620aae708db11'),(211,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_67a60ee6fee50e7e33cca0f07b22cb1.jpg','',0,80530,1483015016,'6a96860a0f2dad853131d930af064bec'),(212,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_df0c548fb2030d7479911dbae3122c0.jpg','',0,59252,1483015021,'47e9e9e1ec98327481708b980a596a5d'),(213,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_d3134c3ac304217251b3f33d99fca4a.jpg','',0,22309,1483015095,'bbc0ccab9eb77570ac7bb6b7046dd451'),(214,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_8975b565a284d7f2eb15b5c4644dc30.jpg','',0,200521,1483015108,'d30d13fa71953a52848e74ecb616ed09'),(215,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_cb37b0adc04564b05730bfe3de9fa45.jpg','',0,123285,1483015109,'17da8cf48d1a04b938a53f50ebbe46ce'),(216,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_afcc4d03d3808c1b14fbbd5dbfc7a77.jpg','',0,83369,1483015121,'3f82b27ce78d0fa7a356bc8c22c742b8'),(217,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_9284f4264b528580be8af55a6400317.jpg','',0,92695,1483015125,'ea9490ab83ff7948fb199250a77e3bb4'),(218,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_af5495231045d1366af4b6a7330cbf5.jpg','',0,81374,1483015247,'4aec790fa67e83c7f296725198f70e9f'),(219,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_26977a844cd9bcd2c886b5103cbec2c.jpg','',0,49964,1483015253,'3402b2684e363e5832a576b9dd7bcfa2'),(220,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_249cc60fe044e0fe38139f47d2fea2a.jpg','',0,252467,1483015283,'b9eb6a10c2f794fc19505b010b1a1d5b'),(221,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_32f27f316bd75f06e85ecdb4e464ebc.jpg','',0,133734,1483015283,'f2fd1947aff488e6f6d42624f7bec5cf'),(222,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_216fb94048406b5feaff2e9045906d5.jpg','',0,23849,1483015507,'c6d9880bfc823353c7c257b80e771a00'),(223,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_bff61baad12c3961d21535c9761b69c.jpg','',0,245829,1483015522,'b7a85aebfea0e9e9e57573b648fdbc92'),(224,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_27b4fdf38f508c18c36452af07896a7.jpg','',0,206414,1483015522,'cee15b1a7c909ba7954027ba21c77931'),(225,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_f9750798a312e143c96c0be5a5a91e9.jpg','',0,24302,1483015613,'b24de6c4e5eccdd053622cfb108ac208'),(226,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_b5b54ff53501bf10443d2f853119c82.jpg','',0,258407,1483015629,'68eba58e2bc7e0a70f380f3dbc8a52c4'),(227,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_6547255530910ba4405844ec5aa1b2b.jpg','',0,347366,1483015629,'6b3f559c8685a48805f75e9643e77731'),(228,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_ca685dfbb00081ff971dca426fcdbe0.jpg','',0,31197,1483015742,'ab6d53f3bc8f348a6e1eeeff492c0f55'),(229,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e0730fddf88e29951032979e59d3abf.jpg','',0,154756,1483015756,'4216b12e722bdd1d71acffe312940c53'),(230,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e7397f8313108c79b83214d5d479135.jpg','',0,287160,1483015757,'2c9ae70e4e81109625425e032c7dd9c8'),(231,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_b2afdce023cb1c6b25a4ee40b6d3667.jpg','',0,6894,1483015804,'c092c35f57fa29dd229878e7320c8a55'),(232,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_6037c492e29c522314f47dfc015e8d9.jpg','',0,94008,1483016072,'07c091f1dc4226cf01102932b9a55924'),(233,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_f7d8cb00872f6934128c596d0602582.jpg','',0,83127,1483016077,'42e13c03bfef31d21f9008f9f387b565'),(234,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_5ff371ba2d30cbe0faf255c27287467.jpg','',0,66551,1483016157,'8221b099e0a496d2ae95b27808a0e354'),(235,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c2c47c30daf74f0fdcd6e502bc83772.jpg','',0,72941,1483016164,'18fe6eaba18cb2f12f5e9a3324116056'),(236,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_ad56a87a2098057a45c9eb7bb988ac0.jpg','',0,34083,1483016242,'e3c2dc34444c4b1e84763c1dc27c4d13'),(237,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_ffa71b3080c8ca42d29c24fbb01f03f.jpg','',0,294237,1483016257,'c66d67a2b25ec4ccf2d0bf0194c15990'),(238,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_4c019178396a36d26ae1860e51e1dd1.jpg','',0,268948,1483016258,'4290a6e4f92724f7c01268c5637d698d'),(239,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_259a76095f66fbac9bb8b8b10fac671.jpg','',0,23350,1483016261,'735d9edacdb7febc909b667224de38e5'),(240,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_04b204c83064916ccba58ca4b84e8d0.jpg','',0,85620,1483016334,'1b73c065278d1b3b21df2bb0121f0f3a'),(241,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_7a4be512a0edef09886a64f080f7959.jpg','',0,118831,1483016378,'f5b6e830a1c011883d8b8115eea93409'),(242,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_3a96d77b89de9fe69a947ea7d4c2f2b.jpg','',0,259748,1483016391,'eb83f74d695fdd85d3d2ac0849eeb4ca'),(243,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2c465475bdc7688af1b0c45598d950d.jpg','',0,89448,1483016392,'eab8e36133f0f76f339cf34599e6d406'),(244,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c0d9c111a48c3bd8da169d9b4937f77.jpg','',0,23843,1483016511,'62a4249fc2664e1306bb18ca17dc8f7a'),(245,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_bd3abbe4d5bf70d429421f31a0e11f8.jpg','',0,281387,1483016524,'6f85d6c0437b8d3d3daac9cfec642f3b'),(246,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e524b0d6038c1a0e65f7b03050a4bc4.jpg','',0,378526,1483016525,'760536d2c8b727f5744047c7c01b99d5'),(247,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_6e75d5142d82751bd6bccf8428e8a8a.jpg','',0,83655,1483016552,'6b655e431aefed3eb2ae7b676189b637'),(248,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_f1faceeb284f862c35508c75b1de177.jpg','',0,81782,1483016557,'8309541d5748e9c61d5453a97210c028'),(249,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_bf3ca6ee618889655b30f18f04cd2da.jpg','',0,31989,1483016645,'153b3fbcdbc560ed726c0642ecd7572b'),(250,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2631f573663a545eba6c0b35ffcb509.jpg','',0,151463,1483016662,'ff30d4be63571f79bd181a06d603b9aa'),(251,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_fabd01bafd29991f2f38ed702b91907.jpg','',0,168717,1483016662,'77a37f1c7195c9843327ff86dc4909f9'),(252,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c1084dd002a64c65a64ce4ec177d16a.jpg','',0,84123,1483016679,'8bef3faec33b6a515298563001c233e2'),(253,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_a16193622980832896222a00b9ca768.jpg','',0,76291,1483016687,'a0a216dfdad14222ee09d1d34745cda5'),(254,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_64ea625d9935a0695e9ebf688eec4fb.jpg','',0,97250,1483016770,'e8ad72a000cea1325c716d2d53f54b96'),(255,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_d26f40fd1c036bcd3b6a02602a0ec67.jpg','',0,94903,1483016774,'bd45079e85675739f34bfb91bc701ce9'),(256,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e3bffc1180056d41adf2d4566ea340e.jpg','',0,79544,1483016886,'29ff1a613dd512d954fd8914e83bd972'),(257,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e23d4ecea70fb6ca58ca256a6402e88.jpg','',0,58983,1483016970,'7ee8e237b45af0e0d6cf6f75b0135d28'),(258,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2877732a66b43b989a76974853649d4.jpg','',0,87647,1483017059,'1f4bf258c0c331a767e47620312c07fa'),(259,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_20f506760ee395b23b08a9195c26b88.jpg','',0,66756,1483017063,'d6050eabccc433dcd35fea0415403a99'),(260,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_d52ff30e904952fc4381e9e4e85250c.jpg','',0,25362,1483017490,'37e778184e50f015b7945961ef7b8cc2'),(261,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_22ab65aa998e3de756542cfdf1541ea.jpg','',0,217278,1483017503,'da59fedfe6b4069cc5d56fd2cf80b988'),(262,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_853eea78724bef0faa413881713afa6.jpg','',0,232296,1483017504,'d3ab0ca6a1c849ea410316d312c38137'),(263,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_368819bcb1580c044e089973dc7caa3.jpg','',0,107483,1483017604,'cc6692e7c5da5db6fa1ef6d1550b7b0a'),(264,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_9f6ed99e467aa6a430bd95df97e4af1.jpg','',0,104898,1483017609,'63bb8e8b665e0a56e47c92fd182e3078'),(265,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_fe260b750828a2c94fc6d0309835608.jpg','',0,29115,1483017613,'ebedfa92714ed0a7fd2162f682022c1c'),(266,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2c677d4fd6ac10a1ff63aed7218cb76.jpg','',0,421632,1483017627,'7d33682c2023cbc8e01954144f689d65'),(267,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_1d5ce948a0d0d5906a0da550a04c6a2.jpg','',0,445818,1483017628,'6faa8f5b4ff84396968e160ae2083f99'),(268,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_bdc9ba6ebb00935e5e91622ba48d36c.jpg','',0,97901,1483017745,'08809ceec2128308607f1c8425bd1272'),(269,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_fa93969cf2680cecd556111df28ee40.jpg','',0,81095,1483017749,'aa68a81d3c325186c949034bcadb4f7d'),(270,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_8aab9ad838c3a63df98ebc73a84a9a5.jpg','',0,25050,1483017785,'2c3f7426af951107f3684ee7a78fa40f'),(271,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_c11cd152ddbc89d586f9a32cf08217e.jpg','',0,170617,1483017799,'3a7da480c469d0d6e940d62a33db7691'),(272,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_980a4b4909bbab86d21505b4a0cc96b.jpg','',0,281530,1483017800,'d443d7a76affa55934586032c49b8338'),(273,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_b18e3db48ca2570130bf98b6d3412b9.jpg','',0,92907,1483017856,'c62125a736e3e54001e956604172ddeb'),(274,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2be579401f4967ae7d0fc35ae2d3bc4.jpg','',0,65295,1483017862,'3e41e4f24655a56415b25b11bf1ba9d1'),(275,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_46204aa6d4ed5981b8b23a8bf9fee60.jpg','',0,207430,1483017916,'8a8b6c70e6a50519581ffde4a57c5d37'),(276,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_cdd502e68650d52a2d2683123b283ce.jpg','',0,140406,1483017916,'d2a087b1b4559aba839816d9b87872be'),(277,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_1f61f7d7824dd13acc81a4ccd43005d.jpg','',0,91637,1483017929,'98496393be241904dd90baa8ff8a8c95'),(278,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_6c32bc06d470f60792d36038495215f.jpg','',0,87866,1483017934,'9e1d0468776706e456bb9cdb0927476c'),(279,'1111jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_f16a0fec621c2cfd2570a0dbc99f24d.jpg','',0,73011,1483018023,'be33a4cbcf2225df6a8f6c4e6db2395f'),(280,'2222jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_3a02d70a46ed06ec38c94c3ac5ae69c.jpg','',0,461800,1483018039,'a8eb2098e60e46a0fa88b63cc29ebcdb'),(281,'3333jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_8ab299668d28a0ad5661c547fb88334.jpg','',0,327377,1483018040,'44d123c09cea326ce2f0c99608bad250'),(282,'1370x3705517p3u3ksw2jpg',0,0,1,0,'jpg','','/attachment/all/201612/29_e0b15dfa464c259d67070191b85ef68.jpg','',0,112760,1483018097,'1352202f213a146d54acbed7f325f72d'),(283,'3370x3705517uxrka6wujpg',0,0,1,0,'jpg','','/attachment/all/201612/29_2d59b1ce7e310308fd7df37c562104c.jpg','',0,81372,1483018102,'6af67695ffc4c8dfc7c80de3f3ffb709'),(284,'2016081502433545png',0,0,1,0,'png','','/attachment/all/201703/07_6845e6e23597bbfee8a58b859a1bf49.png','',0,270948,1488874762,'a68c084f905ed04a756ca24e3212e02b'),(285,'2017010905502514png',0,0,1,0,'png','','/attachment/all/201703/07_2c1a40d09d2525e143653a12d132fa6.png','',0,75142,1488874774,'7d912d74cb7e17766f1473f58cfe5217'),(286,'2016050609513907png',0,0,1,0,'png','','/attachment/all/201703/07_e7a140948898a3b5e52267dfb9fe5eb.png','',0,19583,1488875366,'a2dd7ab98f3de687ac5f9ebd1336328f'),(287,'2png',0,0,1,0,'png','','/attachment/all/201703/07_c550578c82391563455dc2f9feb649b.png','',0,21603,1488875480,'d6a000d671111b924d3acdfeacbd5584'),(288,'3png',0,0,1,0,'png','','/attachment/all/201703/07_29a58b5deb0cc1fb2182d5a98f8167c.png','',0,17355,1488875491,'6e85aa03a43c02073fdcde4b9bd0f135'),(289,'4png',0,0,1,0,'png','','/attachment/all/201703/07_1ff87a10560bcec8bbd82454cbd2d68.png','',0,22892,1488875503,'e781c6c5ac9ef8ba939662ad9cb911ad'),(290,'tit2014122501001png',0,0,1,0,'png','','/attachment/all/201703/08_20b6d017b009a3389cdd94eda10a71f.png','',0,22680,1488937679,'63861e404c455be1f5d4615a7ba10ad3'),(291,'u=1062989499,1682648318&fm=58jpg',0,0,1,0,'jpg','','/attachment/all/201703/14_fece3529e346c32e87c0eee8d9702a7.jpg','',0,5956,1489469500,'3ed8e83d8dd378c8e52f2553736a89a4'),(292,'20150521163918437jpg',0,0,1,0,'jpg','','/attachment/all/201703/14_0ef30f72920df414dbff972f70d4c33.jpg','',0,51811,1489469514,'7ce15ecea4dd9fbbd294b5403b7e0b56'),(293,'23110147kn6jjpg',0,0,0,0,'jpg','','/attachment/image/201703/17_c2e50434ba87391e8b71dd8a432ef66.jpg','',0,261220,1489720486,'e5e9ff0f31e4e1feb0ea2dd83630e544'),(294,'bgpng',0,0,0,0,'png','','/attachment/image/201703/17_3b3297664066ad514f88f0e5aff84ad.png','',0,606205,1489720571,'88ca89a688630047dcf7db9b1a195a16'),(295,'qq截图20170217105924png',0,0,0,0,'png','','/attachment/image/201703/17_1fb98e448cb9f18cc5919f77eabce46.png','',0,17603,1489720907,'e8c229d04912f69c5d883c74dafa201f'),(296,'logosrdbpng',0,0,0,0,'png','','/attachment/image/201703/17_43fbb956b243b40958f491e5e285ffa.png','',0,9981,1489721023,'6b658635adb6c99b2bd40a6f7994ff8e'),(297,'bgpng',0,0,1,0,'png','','/attachment/all/201703/17_ae1d65bd12673e6e0d9e73454f129dd.png','',0,606205,1489751531,'7673b6e905b69301ffb4cbf5da5d2983'),(298,'201603178bee4f12221e3888479a9d25c7f664dejpg',0,0,1,0,'jpg','','/attachment/all/201703/17_d5695d5a19d993666934dc8cbeb02bc.jpg','',0,272988,1489751935,'4968471fc27f967945a36709407f4ccd'),(299,'201603173b6849acd666a8c29f914c262e9a3b95gif',0,0,1,0,'gif','','/attachment/all/201703/17_c9a0e1729dc7c7698335c7b76036f46.gif','',0,69412,1489752032,'43dd9874f00d4c08fb0d41864a6f1dc2'),(300,'20160318ff9aa97cbb62da9daf722146e53f5fb9png',0,0,1,0,'png','','/attachment/all/201703/17_07393b277b417ed3cbb057e6080fb9a.png','',0,154118,1489752068,'ee27527cb4fa4c8879fa27d7a36be579'),(301,'350png',0,0,1,0,'png','','/attachment/all/201703/24_7f18fa92caa12638f79efde11399d79.png','',0,29263,1490360300,'754ef63b0cd3cc2f3385cb3c6ecbf520'),(302,'161370952268205a7811bf6082e64c1d7242jpgmidjpg',0,0,1,0,'jpg','','/attachment/all/201703/27_5a77c63f8717d4b6edf668fc8eba5b6.jpg','',0,20716,1490589659,'9d21fd609b190c81ac59f37f723e2039'),(303,'1613f11584e51c9d9502f744252b102da9d8jpgmidjpg',0,0,1,0,'jpg','','/attachment/all/201703/27_618b5e1dbcb6f7063e610d0a2cf7c7a.jpg','',0,33535,1490592262,'5f850887b3d9250e5a8559c9cb800a18'),(304,'timgjpg',0,0,1,0,'jpg','','/attachment/all/201703/27_95281ece413d18d769e1d4dc6c35007.jpg','',0,23046,1490593760,'f13a5aa09626806a15f118cd22972cd0'),(305,'timgjpg',0,0,1,0,'jpg','','/attachment/all/201703/27_c0a648fd81e56c2549e67d6e9d245e3.jpg','',0,7841,1490593907,'3b3aa0e8ba5afa16bf73f47441f7f688'),(306,'timgjpg',0,0,1,0,'jpg','','/attachment/all/201703/27_af7e9c9f0054accd8f0a92b7de93b2c.jpg','',0,64475,1490594014,'c39ec2eed335a3c736fe65a09f712abb'),(307,'timgjpg',0,0,1,0,'jpg','','/attachment/all/201703/27_a06d72906aef22a1526402842a99fc8.jpg','',0,106285,1490594071,'b60794c2921f3ba5e500e31178613e38'),(308,'chip20png',0,0,1,0,'png','','/attachment/all/201704/15_dd1b1a25c2786c44336c88b88186094.png','',0,18912,1492190981,'6d56564eb2c420c19fcc1cc33a95d329'),(309,'rankfirstpng',0,0,1,0,'png','','/attachment/all/201704/15_60ebf995fce946960a97d064c682843.png','',0,37712,1492191066,'99419581d541be1ae5d3c332ea0cab2a'),(312,'掌上云logo512png',0,0,1,0,'png','','/attachment/image/201704/15_29dabf7d2dc3e7fa6377e98f5b01b32.png','',0,76062,1492230691,'8c559ef53f5ca08d23caa0c8247aad70'),(313,'108png',0,0,1,0,'png','','/attachment/image/201704/15_3b6d5cfa6f5fd26139b263b710da713.png','',0,6543,1492230700,'ad2377954505429d499987ddc4172d7b'),(315,'aspmahtml',0,0,1,0,'html','','/attachment/all/201704/19_1201e851a26465a6bfe0d77f36f62b1.html','',0,95895,1492537566,'5f2b5d9e60466269e3d55830f81cb6c0'),(316,'dollqrcode02png',0,0,1,0,'png','','/attachment/all/201704/25_b3527b4d25092e0440e677d612560f4.png','',0,50855,1493126623,'a926851958267cfb30bbf6f7748c0dc0'),(317,'shareiconpng',0,0,1,0,'png','','/attachment/all/201704/29_898226db12c3a4d64da6e695b1aae30.png','',0,3308,1493434794,'f24d7ab52edd99dcf0fbdc446e8945e6'),(318,'11png',0,0,1,0,'png','','/attachment/all/201705/17_ba2c98ce29ace84c0314656b9629693.png','',0,34556,1495035295,'b2de768bb59ffc78f3020bbdf73f6f45'),(319,'qrcodeforghe531d1f1e636258jpg',0,0,1,0,'jpg','','/attachment/all/201705/24_82a0b710692b107a564da06cc5bff71.jpg','',0,27025,1495567214,'e24027a885f8f8312829f37113723bdf');
/*!40000 ALTER TABLE `ay_fujian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_hongbao`
--

DROP TABLE IF EXISTS `ay_hongbao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_hongbao` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fuid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '发红包的用户uid',
  `sid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家uid',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '收到的用户的uid',
  `haobaojine` double(16,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '红包金额',
  `dayukeyong` double(16,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '红包大于多少消耗可用',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '红包生成时间',
  `gtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间备用',
  `stime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '红包使用时间',
  `off` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '红包状态',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理id',
  `shengyujine` double(16,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '红包剩余金额',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '红包类型',
  `beizhu` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `off` (`off`),
  KEY `uid_2` (`uid`,`off`),
  KEY `gtime` (`gtime`),
  KEY `atime` (`atime`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8
/*!50100 PARTITION BY LINEAR KEY (id)
PARTITIONS 60 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_hongbao`
--

LOCK TABLES `ay_hongbao` WRITE;
/*!40000 ALTER TABLE `ay_hongbao` DISABLE KEYS */;
INSERT INTO `ay_hongbao` VALUES (241,0,0,10,20.00,0.00,1480494576,1481358576,1480496088,1,0,0.00,0,''),(261,0,0,10,1.00,0.00,1480575477,1481439477,0,2,0,1.00,0,''),(256,0,0,10,3.00,0.00,1480575474,1481439474,0,2,0,3.00,0,''),(260,0,0,10,4.00,0.00,1480575477,1481439477,1480575948,2,0,0.00,0,''),(242,0,0,10,20.00,0.00,1480494578,1481358578,1480574367,1,0,0.00,0,''),(243,0,0,10,1.00,20.00,1480575427,1480661827,0,2,0,1.00,0,''),(244,0,0,10,1.00,20.00,1480575429,1480661829,0,2,0,1.00,0,''),(245,0,0,10,1.00,20.00,1480575430,1480661830,0,2,0,1.00,0,''),(263,0,0,10,2.00,0.00,1480575477,1481439477,1480575743,2,0,0.00,0,''),(257,0,0,10,3.00,0.00,1480575475,1481439475,0,2,0,3.00,0,''),(246,0,0,10,1.00,0.00,1480575470,1481439470,0,2,0,1.00,0,''),(247,0,0,10,5.00,0.00,1480575470,1481439470,1480575923,1,0,0.00,0,''),(240,0,0,10,20.00,10.00,1480494565,1481358565,1480574557,1,0,0.00,0,''),(254,0,0,10,1.00,0.00,1480575473,1481439473,0,2,0,1.00,0,''),(258,0,0,10,1.00,0.00,1480575476,1481439476,0,2,0,1.00,0,''),(259,0,0,10,5.00,0.00,1480575476,1481439476,1480575520,2,0,0.00,0,''),(252,0,0,10,4.00,0.00,1480575472,1481439472,0,2,0,4.00,0,''),(253,0,0,10,2.00,0.00,1480575472,1481439472,0,2,0,2.00,0,''),(249,0,0,10,2.00,0.00,1480575471,1481439471,0,2,0,2.00,0,''),(250,0,0,10,1.00,0.00,1480575472,1481439472,0,2,0,1.00,0,''),(251,0,0,10,1.00,0.00,1480575472,1481439472,0,2,0,1.00,0,''),(239,0,0,10,20.00,10.00,1480494564,1481358564,1480574423,1,0,0.00,0,''),(248,0,0,10,2.00,0.00,1480575471,1481439471,0,2,0,2.00,0,''),(262,0,0,10,1.00,0.00,1480575477,1481439477,0,2,0,1.00,0,''),(255,0,0,10,3.00,0.00,1480575473,1481439473,0,2,0,3.00,0,'');
/*!40000 ALTER TABLE `ay_hongbao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_huobilog`
--

DROP TABLE IF EXISTS `ay_huobilog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_huobilog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '日志分类',
  `jine` varchar(100) NOT NULL DEFAULT ' ' COMMENT '扩展币日志',
  `data` varchar(255) NOT NULL COMMENT '数据',
  `ip` varchar(36) NOT NULL COMMENT 'ip',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `atime` (`atime`),
  KEY `type` (`type`),
  KEY `type_2` (`type`,`atime`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_huobilog`
--

LOCK TABLES `ay_huobilog` WRITE;
/*!40000 ALTER TABLE `ay_huobilog` DISABLE KEYS */;
INSERT INTO `ay_huobilog` VALUES (1,150,1,'100.00','管理员更改佣金','111.37.2.88',1494508642),(2,150,6,'-11','佣金提现','111.37.2.88',1494508672),(3,0,0,' ','','',1495034872),(4,157,2,'5.00','a:4:{s:9:\"xiaofeiid\";s:3:\"161\";s:8:\"dedaouid\";s:3:\"157\";s:6:\"guanxi\";i:1;s:6:\"deqian\";s:5:\"10.00\";}','116.2.246.134',1495161125),(5,157,2,'0.30','a:4:{s:9:\"xiaofeiid\";s:3:\"161\";s:8:\"dedaouid\";s:3:\"157\";s:6:\"guanxi\";i:1;s:6:\"deqian\";s:4:\"0.60\";}','116.2.246.134',1495161151),(6,157,2,'0.20','a:4:{s:9:\"xiaofeiid\";s:3:\"161\";s:8:\"dedaouid\";s:3:\"157\";s:6:\"guanxi\";i:1;s:6:\"deqian\";s:4:\"0.40\";}','116.2.246.134',1495161164);
/*!40000 ALTER TABLE `ay_huobilog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_jifenlog`
--

DROP TABLE IF EXISTS `ay_jifenlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_jifenlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '日志分类',
  `jine` bigint(20) NOT NULL DEFAULT '0' COMMENT '积分日志',
  `data` varchar(255) NOT NULL COMMENT '数据',
  `ip` varchar(36) NOT NULL COMMENT 'ip',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `type_2` (`type`,`atime`),
  KEY `uid` (`uid`),
  KEY `atime` (`atime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_jifenlog`
--

LOCK TABLES `ay_jifenlog` WRITE;
/*!40000 ALTER TABLE `ay_jifenlog` DISABLE KEYS */;
INSERT INTO `ay_jifenlog` VALUES (1,1,0,0,'','',0),(2,2,0,0,'','',0);
/*!40000 ALTER TABLE `ay_jifenlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_jinelog`
--

DROP TABLE IF EXISTS `ay_jinelog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_jinelog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '日志分类',
  `jine` double(16,2) NOT NULL DEFAULT '0.00' COMMENT '金额日志',
  `data` varchar(255) NOT NULL COMMENT '数据',
  `ip` varchar(36) NOT NULL COMMENT 'ip',
  `atime` int(12) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `atime` (`atime`),
  KEY `uid` (`uid`),
  KEY `type_2` (`type`,`atime`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_jinelog`
--

LOCK TABLES `ay_jinelog` WRITE;
/*!40000 ALTER TABLE `ay_jinelog` DISABLE KEYS */;
INSERT INTO `ay_jinelog` VALUES (1,150,1,100.00,'管理员更改金额','111.37.2.88',1494508638),(2,150,3,-5.00,'','111.37.2.88',1494508650),(3,150,3,-5.00,'','111.37.2.88',1494508662),(4,150,4,0.20,'','111.37.2.88',1494508662),(5,150,3,-5.00,'','111.37.2.88',1494508787),(6,150,4,20.00,'','111.37.2.88',1494508787),(7,150,3,-5.00,'','111.37.2.88',1494508820),(8,150,4,15.00,'','111.37.2.88',1494508820),(9,150,3,-5.00,'','223.104.187.79',1494508895),(10,150,4,0.60,'','223.104.187.79',1494508895),(11,150,3,-5.00,'','223.104.187.79',1494508948),(12,150,4,0.20,'','223.104.187.79',1494508948),(13,149,1,5.00,'20170511212046826057','36.149.65.134',1494508980),(14,150,3,-5.00,'','223.104.187.79',1494509007),(15,150,4,0.33,'','223.104.187.79',1494509007),(16,150,3,-5.00,'','223.104.187.79',1494509015),(17,150,4,0.40,'','223.104.187.79',1494509015),(18,150,3,-5.00,'','223.104.187.79',1494509022),(19,150,4,0.08,'','223.104.187.79',1494509022),(20,149,3,-5.00,'','36.149.65.134',1494509025),(21,150,3,-5.00,'','223.104.187.79',1494509030),(22,150,4,0.06,'','223.104.187.79',1494509030),(23,150,3,-5.00,'','223.104.187.79',1494509037),(24,150,3,-5.00,'','223.104.187.79',1494509044),(25,150,3,-5.00,'','223.104.187.79',1494509052),(26,150,4,15.00,'','223.104.187.79',1494509052),(27,149,1,30.00,'20170511212351961945','36.149.65.134',1494509100),(28,151,1,100.00,'管理员更改金额','116.2.250.197',1495032069),(29,151,3,-5.00,'','116.2.250.197',1495032080),(30,151,4,0.06,'','116.2.250.197',1495032080),(31,151,3,-5.00,'','116.2.250.197',1495032818),(32,151,3,-20.00,'','116.2.250.197',1495032841),(33,151,4,1.50,'','116.2.250.197',1495032841),(34,151,3,-5.00,'','116.2.250.197',1495032851),(35,151,4,0.06,'','116.2.250.197',1495032851),(36,151,3,-20.00,'','116.2.246.134',1495035371),(37,151,3,-5.00,'','116.2.246.134',1495035379),(38,151,4,0.10,'','116.2.246.134',1495035379),(39,151,3,-5.00,'','116.2.246.134',1495035505),(40,151,4,1.11,'','116.2.246.134',1495035505),(41,151,3,-5.00,'','116.2.246.134',1495035515),(42,151,4,0.09,'','116.2.246.134',1495035515),(43,151,3,-20.00,'','116.2.246.134',1495035528),(44,151,4,3.00,'','116.2.246.134',1495035528),(45,151,3,-5.00,'','116.2.246.134',1495035543),(46,151,4,0.08,'','116.2.246.134',1495035543),(47,151,3,-5.00,'','116.2.246.134',1495035580),(48,151,4,0.40,'','116.2.246.134',1495035580),(49,151,3,-5.00,'','116.2.246.134',1495078183),(50,151,4,1.00,'','116.2.246.134',1495078183),(51,151,1,1000.00,'管理员更改金额','116.2.246.134',1495078257),(52,151,3,-5.00,'','116.2.246.134',1495078271),(53,151,4,1.00,'','116.2.246.134',1495078271),(54,151,3,-5.00,'','116.2.246.134',1495078282),(55,151,4,0.09,'','116.2.246.134',1495078282),(56,151,3,-5.00,'','116.2.246.134',1495078294),(57,151,4,15.00,'','116.2.246.134',1495078294),(58,151,6,-200.00,'提现金额','116.2.246.134',1495078438),(59,152,1,1000.00,'管理员更改金额','116.2.246.134',1495080020),(60,150,3,-5.00,'','1.68.1.174',1495080069),(61,150,4,2.00,'','1.68.1.174',1495080069),(62,150,3,-5.00,'','1.68.1.174',1495080080),(63,150,4,0.30,'','1.68.1.174',1495080080),(64,150,3,-5.00,'','1.68.1.174',1495080091),(65,150,4,0.20,'','1.68.1.174',1495080091),(66,150,3,-5.00,'','1.68.1.174',1495080102),(67,150,4,10.00,'','1.68.1.174',1495080102),(68,150,3,-5.00,'','1.68.1.174',1495080113),(69,150,4,0.09,'','1.68.1.174',1495080113),(70,150,3,-5.00,'','1.68.1.174',1495080125),(71,150,4,0.40,'','1.68.1.174',1495080125),(72,150,3,-5.00,'','1.68.1.174',1495080137),(73,150,4,20.00,'','1.68.1.174',1495080137),(74,150,3,-5.00,'','1.68.1.174',1495080155),(75,150,4,0.33,'','1.68.1.174',1495080155),(76,150,3,-5.00,'','1.68.1.174',1495080169),(77,150,4,1.00,'','1.68.1.174',1495080169),(78,150,3,-5.00,'','1.68.1.174',1495080182),(79,150,4,1.11,'','1.68.1.174',1495080182),(80,150,3,-5.00,'','1.68.1.174',1495080195),(81,150,4,0.07,'','1.68.1.174',1495080195),(82,150,3,-20.00,'','1.68.1.174',1495080211),(83,150,4,9.90,'','1.68.1.174',1495080211),(84,150,3,-5.00,'','1.68.1.174',1495080222),(85,150,4,0.70,'','1.68.1.174',1495080222),(86,150,3,-5.00,'','1.68.1.174',1495080232),(87,150,4,0.08,'','1.68.1.174',1495080232),(88,150,3,-5.00,'','1.68.1.174',1495080249),(89,150,4,0.06,'','1.68.1.174',1495080249),(90,150,3,-5.00,'','1.68.1.174',1495080260),(91,150,4,0.60,'','1.68.1.174',1495080260),(92,150,3,-5.00,'','1.68.1.174',1495080274),(93,151,3,-5.00,'','116.2.246.134',1495086249),(94,151,3,-5.00,'','116.2.246.134',1495086252),(95,151,3,-5.00,'','116.2.246.134',1495086252),(96,150,3,-5.00,'','118.113.201.247',1495109304),(97,150,4,1.00,'','118.113.201.247',1495109304),(98,150,3,-5.00,'','118.113.201.247',1495109510),(99,150,4,25.00,'','118.113.201.247',1495109510),(100,150,3,-5.00,'','117.136.95.53',1495112825),(101,150,4,0.06,'','117.136.95.53',1495112825),(102,150,3,-5.00,'','117.136.95.53',1495112826),(103,150,4,10.00,'','117.136.95.53',1495112826),(104,150,3,-5.00,'','117.136.95.53',1495113013),(105,150,1,5.01,'20170518213224485271','118.113.201.247',1495114357),(106,158,1,5.00,'20170518213646601717','118.113.201.247',1495114616),(107,159,1,5.01,'20170518214249146836','116.2.246.134',1495115240),(108,159,3,-5.00,'','116.2.246.134',1495115297),(109,159,4,15.00,'','116.2.246.134',1495115297),(110,159,1,5.01,'20170518214829367958','116.2.246.134',1495115330),(111,159,3,-20.00,'','116.2.246.134',1495115419),(112,159,1,5.00,'20170518215032250067','116.2.246.134',1495115450),(113,159,1,5.00,'20170518215055180520','116.2.246.134',1495115480),(114,159,1,15.01,'20170518215147854110','116.2.246.134',1495115525),(115,158,3,-5.00,'','118.113.201.247',1495115774),(116,159,1,5.01,'20170518231818353058','116.2.246.134',1495120722),(117,159,1,5.01,'20170519092953998919','116.2.246.134',1495157410),(118,159,3,-5.00,'','116.2.246.134',1495157444),(119,159,4,0.60,'','116.2.246.134',1495157444),(120,159,3,-5.00,'','116.2.246.134',1495157452),(121,159,3,-5.00,'','116.2.246.134',1495157460),(122,159,4,1.11,'','116.2.246.134',1495157460),(123,159,3,-5.00,'','116.2.246.134',1495157469),(124,159,4,0.70,'','116.2.246.134',1495157469),(125,159,3,-10.00,'','116.2.246.134',1495157503),(126,159,4,20.00,'','116.2.246.134',1495157504),(127,159,3,-5.00,'','116.2.246.134',1495157513),(128,159,4,0.30,'','116.2.246.134',1495157513),(129,159,3,-20.00,'','116.2.246.134',1495160632),(130,161,1,5.01,'20170519103125862659','116.2.246.134',1495161102),(131,161,3,-5.00,'','116.2.246.134',1495161125),(132,161,4,10.00,'','116.2.246.134',1495161125),(133,161,3,-5.00,'','116.2.246.134',1495161151),(134,161,4,0.60,'','116.2.246.134',1495161151),(135,161,3,-5.00,'','116.2.246.134',1495161164),(136,161,4,0.40,'','116.2.246.134',1495161164);
/*!40000 ALTER TABLE `ay_jinelog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_logac`
--

DROP TABLE IF EXISTS `ay_logac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_logac` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '日子分类英文名字',
  `name` varchar(255) NOT NULL COMMENT '日只菜单名字',
  `data` text NOT NULL COMMENT '参数分割显示',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统菜单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_logac`
--

LOCK TABLES `ay_logac` WRITE;
/*!40000 ALTER TABLE `ay_logac` DISABLE KEYS */;
INSERT INTO `ay_logac` VALUES (4,'adminlog','管理员日志','登录,退出,挤掉,修改数据,删除数据,添加数据'),(5,'xingbie','性别','女,男'),(6,'level','用户等级','普通会员'),(7,'upsui','图片水印位置','默认左上可定义,中上,右上,右中,右下,中下,左下,左中,中中'),(8,'jinelog','金额日志','消耗,充值,退货增加,抓娃娃消耗,抓娃娃获得,获取佣金,提现'),(9,'jifenlog','积分日志','消耗,增加'),(10,'huobilog','扩展货币','消耗,增加,获取佣金'),(11,'dengtuilog','登录推出日志','登录,退出,挤出'),(12,'fujian','附件上传分类','用户头像,附件上传'),(13,'off','开关状态','关闭,审核,开启'),(14,'yesno','是否判断','否,是'),(15,'off2','二种开关','关闭,开启'),(16,'chengshi','成功失败','失败,成功'),(17,'deloff','删除状态','未删除,已删除'),(18,'userlog','用户操作日志','登录,退出,邮箱发送,短信发送,新增收获地址,修改收获地址'),(19,'yunfs','运送方式','快递,EMS,平邮'),(20,'yunoff','是否包邮','自定义邮费,包邮'),(21,'yuntype','计价方式','(件),(kg),(m³ )'),(22,'yuntime','发货时间','1分钟内,4小时内,8小时内,12小时内,16小时内,20小时内,1天内,2天内,3天内,5天内,7天内,8天内,10天内,12天内,15天内,17天内,20天内,25天内,30天内,35天内,45天内'),(23,'shouhuo','收获状态','可用,默认收货'),(24,'shouhuotype','收获方式','默认方式'),(25,'hongbaooff','红包状态','可使用,使用完,到期,禁用'),(26,'dingtype','订单分类','直接购买'),(27,'dingxoff','订单详细状态','未支付,支付关闭,支付成功,处理成功'),(28,'dingpaytype','订单类型','产品订单,充值订单,支付订单'),(29,'payoff','支付状态','订单录入,提交订单,支付成功,交易关闭'),(30,'faoff','发货状态','确认订单,等待发货 ,发货运输中,收货确认成功,退换货声请,退换货运输中,退换货完成,退换货纠纷仲裁中,订单完成'),(31,'daohang','导航显示','显示关闭,显示开启'),(32,'pingluntype','评论分类','分类,分类2,分类3,分类4'),(33,'xgtype','限购分类','不用限购,每天限购,永久限购,每日时间限购,每日分钟限购,每月天数限购'),(34,'lanmuno','不用栏目','dddd');
/*!40000 ALTER TABLE `ay_logac` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_memcached`
--

DROP TABLE IF EXISTS `ay_memcached`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_memcached` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'KV名字',
  `keval` varchar(20000) NOT NULL COMMENT 'KV值',
  `atime` int(12) NOT NULL DEFAULT '0' COMMENT 'KV时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_memcached`
--

LOCK TABLES `ay_memcached` WRITE;
/*!40000 ALTER TABLE `ay_memcached` DISABLE KEYS */;
/*!40000 ALTER TABLE `ay_memcached` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_pay`
--

DROP TABLE IF EXISTS `ay_pay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '支付名字',
  `suoluetu` varchar(255) NOT NULL,
  `payid` varchar(255) NOT NULL COMMENT '支付id',
  `paykey` varchar(255) NOT NULL COMMENT '支付密码',
  `zhanghao` varchar(255) NOT NULL COMMENT '支付帐号',
  `off` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式关闭',
  `xianshi` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式前台可显示',
  `beizhu` varchar(255) NOT NULL COMMENT '备注',
  `paixu` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理id',
  `payfile` varchar(255) NOT NULL COMMENT '支付文件',
  `isapp` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是不是app支付',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_pay`
--

LOCK TABLES `ay_pay` WRITE;
/*!40000 ALTER TABLE `ay_pay` DISABLE KEYS */;
INSERT INTO `ay_pay` VALUES (5,'微信支付','https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png','111','111','111',1,1,'111',0,1,'weixin',1),(6,'支付宝','https://t.alipayobjects.com/images/T1HHFgXXVeXXXXXXXX.png','111','1521545','111',0,0,'',0,1,'alipay',0);
/*!40000 ALTER TABLE `ay_pay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_pinglun`
--

DROP TABLE IF EXISTS `ay_pinglun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_pinglun` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '评论名字',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理id',
  `cpid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品id',
  `zcid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '上级评论id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '评论分类1，评论，2,反馈',
  `off` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '关闭 审核 开启',
  `orderid` varchar(255) NOT NULL COMMENT '所属订单id',
  `tuijian` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `paixu` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `guanjian` varchar(255) NOT NULL COMMENT '关键词',
  `miaoshu` varchar(255) NOT NULL COMMENT '描述',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `xtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `neirong` longtext NOT NULL COMMENT '评论内容',
  `kuozan` longtext NOT NULL COMMENT '扩展内容',
  `renqi` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '人气',
  `pingfen` double(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '评分',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `shid` (`shid`),
  KEY `adminid` (`adminid`),
  KEY `cpid` (`cpid`),
  KEY `orderid` (`orderid`),
  KEY `off` (`off`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_pinglun`
--

LOCK TABLES `ay_pinglun` WRITE;
/*!40000 ALTER TABLE `ay_pinglun` DISABLE KEYS */;
INSERT INTO `ay_pinglun` VALUES (1,'45345',0,0,0,0,0,0,2,'',0,0,'','',0,0,'','',0,0.00),(3,'3466',0,0,0,0,0,0,2,'',0,0,'','',0,0,'','',0,0.00),(4,'346436546',456,45645,456,54654,456,0,2,'45645',456,546,'56456','456456',0,1476588325,'45645','a:2:{s:6:\"shouji\";s:3:\"厵\";s:7:\"neirong\";s:6:\"一样\";}',45645,0.00),(5,'Sdfafad',3,0,0,0,0,0,0,'',0,0,'','',1488868544,0,'fasdfasdf','',0,0.00),(6,'你好',3,0,0,0,0,2,0,'',0,0,'','',1488869736,0,'我很好','',0,0.00);
/*!40000 ALTER TABLE `ay_pinglun` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_shouhuo`
--

DROP TABLE IF EXISTS `ay_shouhuo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_shouhuo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户uid',
  `xingming` varchar(30) NOT NULL COMMENT '收货人姓名',
  `shouji` bigint(13) unsigned NOT NULL COMMENT '收货人电话',
  `zuoji` varchar(255) NOT NULL COMMENT '直充帐号',
  `diqu` int(12) unsigned NOT NULL COMMENT '收货人地区',
  `beizhu` varchar(255) NOT NULL COMMENT '用户备注',
  `dizhi` varchar(255) NOT NULL COMMENT '收货详细地址',
  `off` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址状态',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `ip` varchar(36) NOT NULL COMMENT '录入的ip',
  `token` varchar(32) NOT NULL COMMENT '验证重复是否',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型分类',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`),
  KEY `off` (`off`),
  KEY `uid_2` (`uid`,`off`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8
/*!50100 PARTITION BY LINEAR KEY (id)
PARTITIONS 30 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_shouhuo`
--

LOCK TABLES `ay_shouhuo` WRITE;
/*!40000 ALTER TABLE `ay_shouhuo` DISABLE KEYS */;
INSERT INTO `ay_shouhuo` VALUES (22,9,'8797869611799',13567424448,'',360105,'江西省 南昌市 湾里区 ui0870780780780780780','ui0870780780780780780',0,1478588143,'127.0.0.1','ff920671548dfc62c4d7e1c3d719402e',0),(23,9,'飞飞飞',13320908987,'',330624,'浙江省 绍兴市 新昌县 傻大个岁的德三国按时到岗撒旦个','傻大个岁的德三国按时到岗撒旦个',1,1478684832,'127.0.0.1','fad43e4c9a178c8c583c1a50d7eb4721',0),(24,3,'大帅哥',15679500112,'',150422,'内蒙古自治区 赤峰市 巴林左旗 啊但是gas的搞的撒阿萨德噶圣诞','啊但是gas的搞的撒阿萨德噶圣诞',1,1479277206,'127.0.0.1','62ac452f6a3de0ec2644d52230dd6ccb',0),(25,10,'56756756',13320908987,'567567',210101,'辽宁省 沈阳市 市辖区 567567567','567567567',1,1480670246,'127.0.0.1','3ef984146580ad4229ed045e6286439c',0);
/*!40000 ALTER TABLE `ay_shouhuo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_tixian`
--

DROP TABLE IF EXISTS `ay_tixian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_tixian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '1,现金提现，2，佣金提现',
  `jine` double(16,2) NOT NULL DEFAULT '0.00' COMMENT '金额日志',
  `data` varchar(255) NOT NULL COMMENT '数据',
  `ip` varchar(36) NOT NULL COMMENT 'ip',
  `atime` int(12) unsigned DEFAULT '0' COMMENT '时间',
  `name` varchar(100) NOT NULL,
  `zhanghao` varchar(255) NOT NULL,
  `fs` varchar(100) NOT NULL,
  `off` int(11) NOT NULL DEFAULT '0' COMMENT '0待审核，1已经审核，-1未审核',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `atime` (`atime`),
  KEY `uid` (`uid`),
  KEY `type_2` (`type`,`atime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_tixian`
--

LOCK TABLES `ay_tixian` WRITE;
/*!40000 ALTER TABLE `ay_tixian` DISABLE KEYS */;
INSERT INTO `ay_tixian` VALUES (1,150,2,11.00,'','111.37.2.88',1494508672,'11','11','支付宝',1),(2,151,1,200.00,'','116.2.246.134',1495078438,'444','4444','支付宝',1);
/*!40000 ALTER TABLE `ay_tixian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_type`
--

DROP TABLE IF EXISTS `ay_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '分类名字',
  `guanjian` varchar(255) NOT NULL COMMENT '关键词',
  `miaoshu` varchar(255) NOT NULL COMMENT '描述',
  `cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '子分类',
  `url` varchar(255) NOT NULL COMMENT '内容url',
  `http` varchar(255) NOT NULL COMMENT '外联url',
  `listmb` varchar(10) NOT NULL COMMENT '列表模版',
  `neromb` varchar(10) NOT NULL COMMENT '内容模版',
  `leixin` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型 0 单页 1 列表',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家uid',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `tuijian` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐参数',
  `paixu` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `renqi` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '人气',
  `tupian` varchar(255) NOT NULL COMMENT '图片',
  `tupianji` text NOT NULL COMMENT '图片集',
  `neirong` longtext NOT NULL COMMENT '分类内容',
  `kuozan` text NOT NULL COMMENT '扩展数据',
  `kuozanform` text NOT NULL COMMENT '扩展表单数据',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `xtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `xianoff` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '显示开关',
  `off` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0 关闭 1 审核 2 正常',
  `explx1` varchar(500) NOT NULL COMMENT '分类扩展1',
  `explx2` varchar(500) NOT NULL COMMENT '扩展2 的参数',
  `explx3` varchar(500) NOT NULL COMMENT '扩展3的参数',
  `explx4` varchar(500) NOT NULL COMMENT '扩展4的参数',
  `explx5` varchar(500) NOT NULL COMMENT '扩展5 参数',
  `explx6` varchar(500) NOT NULL COMMENT '扩展6的参数',
  `beizhu` varchar(500) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `cid` (`cid`),
  KEY `off` (`off`),
  KEY `xianoff` (`xianoff`),
  KEY `cid_2` (`cid`,`off`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_type`
--

LOCK TABLES `ay_type` WRITE;
/*!40000 ALTER TABLE `ay_type` DISABLE KEYS */;
INSERT INTO `ay_type` VALUES (66,'奖池','','',0,'jiangchi','','','',1,0,0,1,0,0,0,'','','','','',1491468793,1491468793,0,0,'','','','','','',''),(67,'dolls5','','',66,'dolls5','','','',1,0,0,1,0,0,0,'','','','','',1491469050,1491469050,0,0,'','','','','','',''),(68,'dolls10','','',66,'dolls10','','','',1,0,0,1,0,0,0,'','','','','',1491469206,1491469206,0,0,'','','','','','',''),(69,'dolls20','','',66,'dolls20','','','',1,0,0,1,0,0,0,'','','','','',1491469375,1491469387,0,0,'','','','','','','');
/*!40000 ALTER TABLE `ay_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_type1`
--

DROP TABLE IF EXISTS `ay_type1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_type1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '分类名字',
  `guanjian` varchar(255) NOT NULL COMMENT '关键词',
  `miaoshu` varchar(255) NOT NULL COMMENT '描述',
  `cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '子分类',
  `url` varchar(255) NOT NULL COMMENT '内容url',
  `http` varchar(255) NOT NULL COMMENT '外联url',
  `listmb` varchar(10) NOT NULL COMMENT '列表模版',
  `neromb` varchar(10) NOT NULL COMMENT '内容模版',
  `leixin` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型 0 单页 1 列表',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家uid',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `tuijian` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐参数',
  `paixu` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `renqi` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '人气',
  `tupian` varchar(255) NOT NULL COMMENT '图片',
  `tupianji` text NOT NULL COMMENT '图片集',
  `neirong` longtext NOT NULL COMMENT '分类内容',
  `kuozan` text NOT NULL COMMENT '扩展数据',
  `kuozanform` text NOT NULL COMMENT '扩展表单数据',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `xtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `xianoff` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '显示开关',
  `off` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0 关闭 1 审核 2 正常',
  `explx1` varchar(500) NOT NULL COMMENT '分类扩展1',
  `explx2` varchar(500) NOT NULL COMMENT '扩展2 的参数',
  `explx3` varchar(500) NOT NULL COMMENT '扩展3的参数',
  `explx4` varchar(500) NOT NULL COMMENT '扩展4的参数',
  `explx5` varchar(500) NOT NULL COMMENT '扩展5 参数',
  `explx6` varchar(500) NOT NULL COMMENT '扩展6的参数',
  `beizhu` varchar(500) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `cid` (`cid`),
  KEY `off` (`off`),
  KEY `xianoff` (`xianoff`),
  KEY `cid_2` (`cid`,`off`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_type1`
--

LOCK TABLES `ay_type1` WRITE;
/*!40000 ALTER TABLE `ay_type1` DISABLE KEYS */;
INSERT INTO `ay_type1` VALUES (1,'幻灯片','','',0,'huandengpian','','','',0,0,0,1,0,0,0,'','','这里是幻灯片','','',1488874041,1488874041,0,0,'','','','','','','');
/*!40000 ALTER TABLE `ay_type1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_user`
--

DROP TABLE IF EXISTS `ay_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_user` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户uid',
  `name` varchar(100) NOT NULL COMMENT '用户昵称',
  `zhanghao` varchar(200) NOT NULL COMMENT '登录帐号',
  `mima` varchar(64) NOT NULL COMMENT '密码',
  `ermima` varchar(64) NOT NULL COMMENT '二级密码',
  `email` varchar(100) NOT NULL COMMENT '用户邮箱',
  `shouji` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '手机号码',
  `weixin` varchar(128) NOT NULL COMMENT '微信openid',
  `weixinui` varchar(128) NOT NULL COMMENT '微信开放平台uopenid',
  `weibo` varchar(128) NOT NULL COMMENT '微薄openid',
  `qqopen` varchar(128) NOT NULL COMMENT 'qqopenid',
  `zhifubaoopen` varchar(128) NOT NULL COMMENT '支付宝openid',
  `openid` varchar(128) NOT NULL COMMENT 'openid备用',
  `openidd` varchar(128) NOT NULL COMMENT '备用openid1',
  `jine` double(16,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户金额',
  `jifen` double(16,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户积分',
  `huobi` double(16,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '扩展货币交易',
  `off` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态',
  `yanzhengip` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `touxiang` varchar(255) NOT NULL COMMENT '头像',
  `atime` int(12) unsigned NOT NULL COMMENT '注册时间',
  `ip` varchar(32) NOT NULL COMMENT '注册ip',
  `zhiye` varchar(100) NOT NULL COMMENT '用户职业',
  `xingbie` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '用户性别',
  `nianling` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `qqhaoma` varchar(100) NOT NULL COMMENT 'qq号码',
  `weixinhaoma` varchar(100) NOT NULL COMMENT '微信号码',
  `tuid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '推广uid',
  `tuid1` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tuid2` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '二级推广',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id用户',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户等级备用',
  `appid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'appid',
  `mhash` varchar(32) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `shouji` (`shouji`) USING BTREE,
  KEY `name` (`name`) USING BTREE,
  KEY `zhanghao` (`zhanghao`) USING BTREE,
  KEY `email` (`email`) USING BTREE,
  KEY `weixin` (`weixin`) USING BTREE,
  KEY `weixinui` (`weixinui`) USING BTREE,
  KEY `weibo` (`weibo`) USING BTREE,
  KEY `qqopen` (`qqopen`) USING BTREE,
  KEY `zhifubaoopen` (`zhifubaoopen`) USING BTREE,
  KEY `openid` (`openid`) USING BTREE,
  KEY `openidd` (`openidd`) USING BTREE,
  KEY `uidoff` (`uid`,`off`) USING BTREE,
  KEY `tuid` (`tuid`,`tuid1`,`tuid2`),
  KEY `tuid_2` (`tuid`),
  KEY `tuid1` (`tuid1`),
  KEY `tuid2` (`tuid2`),
  KEY `level` (`level`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 COMMENT='用户表'
/*!50100 PARTITION BY LINEAR KEY (uid)
PARTITIONS 10 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_user`
--

LOCK TABLES `ay_user` WRITE;
/*!40000 ALTER TABLE `ay_user` DISABLE KEYS */;
INSERT INTO `ay_user` VALUES (157,'123','123','dc7e3242b','dc7e3242b','',0,'','','','','','','',0.00,0.00,5.50,1,0,'',1495114546,'116.2.246.134','',-1,0,'','',0,0,0,0,0,0,''),(173,'dd','dd','8a9dc4','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495714297,'','',-1,0,'','',0,0,0,0,0,0,''),(160,'234555','234555','836bcfbee2651b90e5','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495121709,'','',-1,0,'','',159,0,0,0,0,0,''),(176,'zo317','zo317','a24d038b018d45129caa8','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495753303,'','',-1,0,'','',0,0,0,0,0,0,''),(159,'test','test','bcf78aaed771','','',0,'','','','','','','',2.76,0.00,0.00,1,0,'',1495114960,'','',-1,0,'','',0,0,0,0,0,0,''),(167,'qq8330410','qq8330410','5362eb060b615eb240d0e','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495617473,'','',-1,0,'','',0,0,0,0,0,0,''),(175,'251022816','251022816','0633c2aace84fea1183e910c','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495740824,'','',-1,0,'','',0,0,0,0,0,0,''),(162,'qqqqaaaa','qqqqaaaa','ad053d01fbc7d93ebdcbabde6231e3','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495563437,'','',-1,0,'','',0,0,0,0,0,0,''),(170,'wocao123','wocao123','d4e880a08e5a702aafd27ba3','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495700424,'','',-1,0,'','',0,0,0,0,0,0,''),(161,'abc','abc','fe5c1736e','','',0,'','','','','','','',1.01,0.00,0.00,1,0,'',1495161056,'','',-1,0,'','',157,0,0,0,0,0,''),(169,'qw2232397985','qw2232397985','008de1d6460149689c','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495678127,'','',-1,0,'','',0,0,0,0,0,0,''),(164,'wsx','wsx','dc7e3242b','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495602237,'','',-1,0,'','',0,0,0,0,0,0,''),(172,'wu762223299','wu762223299','422c50609dd88ee25d5ed8801cc0c0b','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495707480,'','',-1,0,'','',0,0,0,0,0,0,''),(163,'ghchghq','ghchghq','b5a6e215e3e07fe534','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495563516,'','',-1,0,'','',0,0,0,0,0,0,''),(171,'admin','admin','b5a6e215e3e07fe534','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495700503,'','',-1,0,'','',0,0,0,0,0,0,''),(158,'234','234','c97eea65d','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495114601,'','',-1,0,'','',0,0,0,0,0,0,''),(166,'huangcyd','huangcyd','2b410735780296d489ae74a1','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495606497,'','',-1,0,'','',0,0,0,0,0,0,''),(174,'123321','123321','91210f096f1171a5be','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495722062,'','',-1,0,'','',0,0,0,0,0,0,''),(165,'qwe123','qwe123','e23632bc392555bf825255d4324553d','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495605113,'','',-1,0,'','',0,0,0,0,0,0,''),(168,'111222333','111222333','df6fe870d25e52e0c34ef0caef4','','',0,'','','','','','','',0.00,0.00,0.00,1,0,'',1495638099,'','',-1,0,'','',0,0,0,0,0,0,'');
/*!40000 ALTER TABLE `ay_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_userlog`
--

DROP TABLE IF EXISTS `ay_userlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_userlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理uid',
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '日志类型',
  `data` text NOT NULL COMMENT '详细数据',
  `ip` varchar(36) NOT NULL COMMENT '产生ip',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `appid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作appid',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_userlog`
--

LOCK TABLES `ay_userlog` WRITE;
/*!40000 ALTER TABLE `ay_userlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `ay_userlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_wawa`
--

DROP TABLE IF EXISTS `ay_wawa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_wawa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '内容名字',
  `guanjian` varchar(255) NOT NULL COMMENT '关键词',
  `miaoshu` varchar(255) NOT NULL COMMENT '描述',
  `zcid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '第二子分类id',
  `cid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `url` varchar(255) NOT NULL COMMENT '内容url',
  `http` varchar(255) NOT NULL COMMENT '外联url',
  `neromb` varchar(10) NOT NULL COMMENT '指定内容模版',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商家id',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理员uid',
  `tuijian` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `paixu` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `renqi` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '人气',
  `tupian` varchar(255) NOT NULL COMMENT '图片',
  `tupianji` text NOT NULL COMMENT '图片集',
  `neirong` longtext NOT NULL COMMENT '分类内容',
  `kuozan` text NOT NULL COMMENT '扩展数据',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `xtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `off` smallint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态0 关闭 1 审核 2 正常',
  `explx1` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型1',
  `explx2` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型2',
  `explx3` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型3',
  `explx4` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型4',
  `explx5` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型5',
  `explx6` bigint(20) NOT NULL DEFAULT '0' COMMENT '扩展类型6',
  `yuanjia` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '产品原价',
  `jiage` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '现在单价',
  `yunid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '运费id',
  `xiaoliang` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `canshu` text NOT NULL COMMENT '产品选购参数+价格',
  `miaosufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '描述总分',
  `fuwufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '服务总分',
  `wuliufen` double(20,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '物流总分',
  `fenren` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '评分人数',
  `jinzhong` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '净重',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '处理方式',
  `kahao` varchar(255) NOT NULL COMMENT '授权或者网盘地址文件地址',
  `kamima` varchar(255) NOT NULL COMMENT '网盘密码或者压缩吧密码',
  `xiangou` double unsigned NOT NULL DEFAULT '0' COMMENT '限购数量',
  `xgtype` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '限购分类',
  `xgdata` varchar(255) NOT NULL COMMENT '限购时间端',
  `huobi` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '购买方式货币',
  `beizhu` varchar(255) NOT NULL COMMENT '备注',
  `lx` varchar(255) NOT NULL COMMENT '类型',
  `dedao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `url` (`url`),
  KEY `off` (`off`),
  KEY `cid_2` (`cid`,`off`),
  KEY `explx1` (`explx1`),
  KEY `explx2` (`explx2`),
  KEY `explx3` (`explx3`),
  KEY `explx4` (`explx4`),
  KEY `explx5` (`explx5`),
  KEY `explx6` (`explx6`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_wawa`
--

LOCK TABLES `ay_wawa` WRITE;
/*!40000 ALTER TABLE `ay_wawa` DISABLE KEYS */;
INSERT INTO `ay_wawa` VALUES (1,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494508662,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.20'),(2,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494508787,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','20.00'),(3,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494508820,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','15.00'),(4,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494508895,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.60'),(5,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494508948,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.20'),(6,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494509007,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.33'),(7,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494509015,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.40'),(8,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494509022,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.08'),(9,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494509030,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.06'),(10,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1494509052,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','15.00'),(11,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495032080,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.06'),(12,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495032841,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','20','1.50'),(13,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495032851,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.06'),(14,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495035379,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.10'),(15,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495035505,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','1.11'),(16,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495035515,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.09'),(17,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495035528,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','20','3.00'),(18,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495035543,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.08'),(19,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495035580,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.40'),(20,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495078183,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','1.00'),(21,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495078271,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','1.00'),(22,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495078282,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.09'),(23,'','','',0,0,'','','',151,0,0,0,0,0,'','','','',1495078294,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','15.00'),(24,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080069,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','2.00'),(25,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080080,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.30'),(26,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080091,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.20'),(27,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080102,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','10.00'),(28,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080113,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.09'),(29,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080125,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.40'),(30,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080137,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','20.00'),(31,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080155,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.33'),(32,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080169,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','1.00'),(33,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080182,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','1.11'),(34,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080195,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.07'),(35,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080211,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','20','9.90'),(36,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080222,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.70'),(37,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080232,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.08'),(38,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080249,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.06'),(39,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495080260,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.60'),(40,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495109304,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','1.00'),(41,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495109510,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','25.00'),(42,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495112825,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.06'),(43,'','','',0,0,'','','',150,0,0,0,0,0,'','','','',1495112826,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','10.00'),(44,'','','',0,0,'','','',159,0,0,0,0,0,'','','','',1495115297,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','15.00'),(45,'','','',0,0,'','','',159,0,0,0,0,0,'','','','',1495157444,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.60'),(46,'','','',0,0,'','','',159,0,0,0,0,0,'','','','',1495157460,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','1.11'),(47,'','','',0,0,'','','',159,0,0,0,0,0,'','','','',1495157469,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.70'),(48,'','','',0,0,'','','',159,0,0,0,0,0,'','','','',1495157504,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','10','20.00'),(49,'','','',0,0,'','','',159,0,0,0,0,0,'','','','',1495157513,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.30'),(50,'','','',0,0,'','','',161,0,0,0,0,0,'','','','',1495161125,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','10.00'),(51,'','','',0,0,'','','',161,0,0,0,0,0,'','','','',1495161151,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.60'),(52,'','','',0,0,'','','',161,0,0,0,0,0,'','','','',1495161164,0,1,0,0,0,0,0,0,0.00,0.00,0,0,'',0.0,0.0,0.0,0,0.00,0,'','',0,0,'',0,'','5','0.40');
/*!40000 ALTER TABLE `ay_wawa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_youqing`
--

DROP TABLE IF EXISTS `ay_youqing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_youqing` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '友情连接名称',
  `miaoshu` varchar(255) NOT NULL COMMENT '描述',
  `url` varchar(255) NOT NULL COMMENT '网站url',
  `tupian` varchar(255) NOT NULL COMMENT '缩略图',
  `leixing` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `off` smallint(1) unsigned NOT NULL DEFAULT '0' COMMENT '友情连接状态0 关闭 1 审核 2 正常',
  `paixu` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `adminuid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `dtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  `jine` double(20,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `tuijian` int(10) unsigned DEFAULT '0' COMMENT '推荐',
  `beizhu` varchar(255) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_youqing`
--

LOCK TABLES `ay_youqing` WRITE;
/*!40000 ALTER TABLE `ay_youqing` DISABLE KEYS */;
INSERT INTO `ay_youqing` VALUES (1,'安优企业建站','安优企业建站','http://www.anyou.org','',0,2,0,1475573673,0,0,0,0.00,0,''),(2,'D软件','Dsoft','http://www.dsoft.org','',0,2,0,1475573694,0,0,0,0.00,0,'');
/*!40000 ALTER TABLE `ay_youqing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ay_yunfei`
--

DROP TABLE IF EXISTS `ay_yunfei`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ay_yunfei` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '模版名字',
  `diquid` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '发货地区',
  `fatime` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `off` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否包邮',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '计价方式',
  `data` text NOT NULL COMMENT '运送方式',
  `baodata` text NOT NULL COMMENT '特定条件',
  `atime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `ip` varchar(36) NOT NULL COMMENT '添加的ip',
  `xtime` int(12) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户',
  `shid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商户id',
  `adminid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '管理id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ay_yunfei`
--

LOCK TABLES `ay_yunfei` WRITE;
/*!40000 ALTER TABLE `ay_yunfei` DISABLE KEYS */;
INSERT INTO `ay_yunfei` VALUES (9,'测试运费3',0,0,0,0,'a:1:{i:2;a:2:{s:4:\"ding\";i:2;i:0;a:5:{s:4:\"diqu\";s:1:\"0\";s:4:\"jian\";d:1;s:3:\"fei\";d:15;s:3:\"jia\";d:5;s:4:\"zeng\";d:2;}}}','a:0:{}',1475755195,'',1479180935,0,0,0),(10,'测试运费2',0,0,0,0,'a:1:{i:0;a:2:{s:4:\"ding\";i:0;i:0;a:5:{s:4:\"diqu\";s:1:\"0\";s:4:\"jian\";d:1;s:3:\"fei\";d:2;s:3:\"jia\";d:1;s:4:\"zeng\";d:1;}}}','a:2:{s:4:\"ding\";s:2:\"ok\";i:0;a:4:{s:4:\"diqu\";s:1:\"0\";s:4:\"type\";d:0;s:4:\"jian\";d:1;s:4:\"mian\";d:0;}}',1475755195,'',1479107997,0,0,0),(11,'测试运费',0,8,0,2,'a:2:{i:1;a:2:{s:4:\"ding\";i:1;i:0;a:5:{s:4:\"diqu\";s:1:\"0\";s:4:\"jian\";d:1;s:3:\"fei\";d:20;s:3:\"jia\";d:1;s:4:\"zeng\";d:2;}}i:2;a:2:{s:4:\"ding\";i:2;i:0;a:5:{s:4:\"diqu\";s:1:\"0\";s:4:\"jian\";d:1;s:3:\"fei\";d:15;s:3:\"jia\";d:1;s:4:\"zeng\";d:1;}}}','a:3:{s:4:\"ding\";s:2:\"ok\";i:0;a:4:{s:4:\"diqu\";s:1:\"0\";s:4:\"type\";d:1;s:4:\"jian\";d:1;s:4:\"mian\";d:0;}i:1;a:4:{s:4:\"diqu\";s:1:\"0\";s:4:\"type\";d:2;s:4:\"jian\";d:2;s:4:\"mian\";d:500;}}',1475755196,'',1480573377,0,0,0);
/*!40000 ALTER TABLE `ay_yunfei` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-28 14:31:23
