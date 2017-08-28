<?php if(!defined('ONGPHP'))exit('Error ONGSOFT');?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $CONN['title']?> | 抽奖活动</title>
<meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"/>
<meta name="apple-mobile-web-app-capable" content="yes"/>
<meta name="full-screen" content="true"/>
<meta name="screen-orientation" content="portrait"/>
<meta name="x5-fullscreen" content="true"/>
<meta name="360-fullscreen" content="true"/>
<style>
        html, body {
            -ms-touch-action: none;
            background: #FFD44A;
            padding: 0;
            border: 0;
            margin: 0;
            height: 100%;
        }
</style>

<script src="/tpl/tg/img/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" egret="lib" src="/tpl/tg/img/libs/modules/egret/egret.min.js"></script>
<script type="text/javascript" egret="lib" src="/tpl/tg/img/libs/modules/egret/egret.web.min.js"></script>
<script type="text/javascript" egret="lib" src="/tpl/tg/img/libs/modules/game/game.min.js"></script>
<script type="text/javascript" egret="lib" src="/tpl/tg/img/libs/modules/game/game.web.min.js"></script>
<script type="text/javascript" egret="lib" src="/tpl/tg/img/libs/modules/tween/tween.min.js"></script>
<script  type="text/javascript" egret="lib" src="/tpl/tg/img/libs/modules/res/res.min.js"></script>
<script type="text/javascript" src="/tpl/tg/img/main.min.js"></script>
</head>
<body>
<div id="v" data-value="v20Q" style="display:none"></div>
<div <?php if(!$SHOUJI){?>style="margin: auto;width: 600px;height:100%"<?php }else{ ?>style="margin: auto;width: 100%;height: 100%;"<?php } ?>  id="gameDiv" class="egret-player" data-entry-class="Main" data-orientation="portrait" data-scale-mode="showAll" data-frame-rate="30" data-content-width="750" data-content-height="1334" data-show-paint-rect="false" data-multi-fingered="2" data-show-fps="false" data-show-log="false" data-log-filter="" data-show-fps-style="x:0,y:0,size:30,textColor:0x00c200,bgAlpha:0.9">
<script>

var TUID = '<?php  echo isset( $_SESSION['tuid'] ) && $_SESSION['tuid'] > 0 ? $_SESSION['tuid'] : 0;?>';
    		function IsPC() {
	    		var userAgentInfo = navigator.userAgent;
	    		var Agents = ["Android", "iPhone",
	    		"SymbianOS", "Windows Phone",
	    		"iPad", "iPod"];
	    		var flag = true;
	    		for (var v = 0; v < Agents.length; v++) {
		    		if (userAgentInfo.indexOf(Agents[v]) > 0) {
			    			flag = false;
			    			break;
		    			}
    			}
    			return flag;
    		  }
    		function setSize(){
    			if(IsPC()){
	    			document.getElementById("gameDiv").setAttribute("data-content-width",""+750);
	    			document.getElementById("gameDiv").setAttribute("data-content-height",""+1334);
    			}else{
	    			document.getElementById("gameDiv").setAttribute("data-content-width",""+document.documentElement.clientWidth*2);
	    			document.getElementById("gameDiv").setAttribute("data-content-height",""+document.documentElement.clientHeight*2);	
    			}		
    		}
    	setSize();   
        
    
    		</script>
</div>
<script>
    egret.runEgret();

function download(){


      window.location.href= '<?php echo WZHOST;?>user.php?y=reg';
     

}
</script>
</body>
</html>
