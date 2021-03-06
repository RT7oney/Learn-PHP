<?php
namespace Admin\Controller;

class CollectController extends AdminController {
	private $Collect;
	private $CModel;
	
	public function _initialize(){
	 	parent::_initialize();
		$this->Collect = new \Org\Net\Http;
		$this->CModel =D('Collect');
	}

    public function index(){
		$listUrl=C('COLLECT_URL');
		$list=$this->Collect->doGet($listUrl);
		if(!$list){
			$this->error('获取列表数据失败！');
		}
		$this->assign('clist', json_decode($list,true));
        $this->meta_title = '一键采集列表';
        $this->display();
    }
	
	public function bind(){
		if(IS_POST){ //提交表单
            if(false !== $this->CModel->insertbind()){
				$this->success('绑定影片分类成功！');
            } else {
                $error = $this->CModel->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
			$Movie = D('Movie');
			$cid=I('cid');
			$fid=I('fid');
			$this->assign('bindid', bind_id($fid.'_'.$cid));
			$this->assign('cid', $cid);
			$this->assign('fid', $fid);
			$this->assign('category',  $Movie->getTree());
			$this->meta_title = '绑定分类';
			$this->display();
		}
	}
	
	public function pbind(){
		if(IS_POST){ //提交表单
            $this->binbplay();
        } else {
			$pid=I('pid');
			$ptitle=I('ptitle');
			$this->assign('pid', $pid);
			$this->assign('ptitle', $ptitle);
			$this->assign('playerlist',D("Movie")->getPlayer());
			$this->meta_title = '绑定播放器';
			$this->display();
		}
	}
		
	public function lists($url){
		$patterns =array("@","|","~","{ac}","{p}","{id}","{h}","{t}", "{wd}");  
		$replacements = array("=","/","&",I("ac"),I("p",1),I("id"),I("h"),I("t"),urlencode(I("wd","")));
		$url=str_replace($patterns, $replacements, $url);
		$list=$this->Collect->doGet($url);
		if(!$list){
			$this->error('获取数据失败！');
		}		
		switch (I("type")){
			case "xml":
			  	$list_array=$this->xml_to_array($list);
			  	//print_r($list_array);
			  	break;  
			case "json":
			  	$list_array=json_decode($list, true);
			  	break;
			default:
			$this->error('数据类型错误！');
		}
		$page = new \Think\Page($list_array["list"]["recordcount"],$list_array["list"]["pagesize"]);
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $p =$page->show();
		$this->meta_title = '一键采集列表';
        $this->assign('_page', $p? $p: '');
		$this->assign('movielist', $list_array['video']);
		$this->assign('typelist', $list_array['class']);
		$this->assign('playlist', $list_array['player']);
        $this->display();	
	}
	
	public function delCollect(){
		S("collect",null);
		dropDir(HTML_PATH);
		dropDir(TEMP_PATH);
	}

	public function collect($url){
		S("collect",array('url' =>__SELF__ ,'page'=>I('p')));
		$patterns =array("@","|","~","{ac}","{p}","{id}","{h}","{t}", "{wd}","list");
		$replacements = array("=","/","&",I("ac"),I("p",1),I("id"),I("h"),I("t"),urlencode(I("wd","")),"videolist");
		$url=str_replace($patterns, $replacements, $url);
		$list=$this->Collect->doGet($url);
		if(!$list){
			$this->error('获取数据失败！');
		}		
		switch (I("type")){
			case "xml":
				$list_array=$this->xml_to_array($list,1);
				break;  
			case "json":
				$list_array=$this->json2array($list);
			  	break;
			default:
			$this->error('数据类型错误！');
		}
		$list_array["return"]["num"]["count"]=$list_array["list"]["recordcount"];
		$list_array["return"]["num"]["pagesize"]=$list_array["list"]["pagesize"];
		$list_array["return"]["num"]["page"]=$list_array["list"]["pagecount"];
		$this->ajaxReturn($list_array["return"]);
	}
	
	public function listplay(){
		$this->assign('playlist', F('Play_bind'));
		$this->assign('playerlist',D("Movie")->getPlayer());
		$this->meta_title = '绑定播放器';
		$this->display();
	}
	
	public function binbplay(){
		$bindcache = F('Play_bind');
		if (!is_array($bindcache)) {
			$bindcache = array();
			$bindcache['1'] = array("play"=>"","bind"=>"");
		}
		$bindkey=I("pname",0);
		$bindinsert["p_".$bindkey] = array("play"=>$bindkey,"bind"=>I('bpname',0));
		$bindarray = array_merge($bindcache,$bindinsert);
		F('Play_bind',$bindarray);
		$this->success('绑定影片播放器成功！');
	}
	
	public function delplay(){
		$bindcache = F('Play_bind');
		unset($bindcache["p_".I('pname')]);
		F('Play_bind',$bindcache);
		$this->success('删除绑定影片播放器成功！');
	}
	
	 public function downpic(){
	 	if($_GET['p']){ //提交表单
			$down_num=5;
			$map['md5']=array('eq','');
			$map['sha1']=array('eq','');
			$map['url']=array('neq','');
			$map['path']=array('eq','');
			if($_GET['p']==1){
				$count = M("picture")->where($map)->count("id");
				S('down_pic_count',$count);
			}else{
				$count=S('down_pic_count');
			}
			$pic=M('picture')->where($map)->limit($down_num)->select();
            foreach($pic as $key=>$value){
				if($data=D('Picture')->down_img($value['url'])){
					$data['id']=$value['id'];
					$data['url']='';
					M('picture')->save($data);
				}
				$video['video'][]=array('title'=>$value["url"],'content'=>'下载完毕');
			}
			$totalPages=ceil($count/$down_num)?ceil($count/$down_num):1;
			$return=array('video'=>$video['video'],'num'=>array('pagesize'=>$down_num,'i'=>$key+1,'count'=>$count,'page'=>$totalPages));
			$this->ajaxReturn($return,'JSON');
        } else {
			$this->meta_title = '下载远程图片';
			$this->display();
		}
    }
	
	public function moviejson($url){
		$date=array();
		$patterns =array("@","|","~","{ac}","{p}","{id}","{h}","{t}", "{wd}","list");  
		$replacements = array("=","/","&",I("ac"),I("p",1),I("id"),I("h"),I("t"),urlencode(I("wd","")),"videolist");   
		$url=str_replace($patterns, $replacements, $url);
		$list=$this->Collect->doGet($url);
		if(!$list){
			$this->error('获取数据失败！');
		}		
		switch (I("type")){
			case "xml":
			  	$list_array=$this->json_to_array($list);
			  	$date["video"][0]["mid"]=$list_array["list"]["video"]["id"];
				$date["video"][0]["type"]=$list_array["list"]["video"]["type"];
				$date["video"][0]["title"]=$list_array["list"]["video"]["name"];
				$date["video"][0]["last"]=strtotime($list_array["list"]["video"]["last"]);
				$date["video"][0]["serialize"]=$list_array["list"]["video"]["note"];
				$date["video"][0]["actors"]=$list_array["list"]["video"]["actor"];
				$date["video"][0]["area"]=$list_array["list"]["video"]["area"];
				$date["video"][0]["language"]=$list_array["list"]["video"]["lang"];
				$date["video"][0]["pic"]=$list_array["list"]["video"]["pic"];
				$date["video"][0]["content"]=$list_array["list"]["video"]["des"];
				$date["video"][0]["play"]=$this->url_replace($list_array["list"]["video"]["dl"]["dd"]);
			  break;  
			case "json":
				$list=json_decode($list,true);
			  	$date["video"][0]=$list["video"][0];
			  break;
			default:
			$this->error('数据类型错误！');
		}
		$this->ajaxReturn($date["video"][0]);
	}
		
	private function xml_to_array($string,$collect=NULL){
		$i=0;
		$date=array();
		$fid=I('fid');
		$list_array=$this->json_to_array($string);
		$date["list"]["pagecount"]=$list_array["list"]["@attributes"]["pagecount"];
		$date["list"]["pagesize"]=$list_array["list"]["@attributes"]["pagesize"];
		$date["list"]["recordcount"]=$list_array["list"]["@attributes"]["recordcount"];
		
		foreach($list_array["type"]["id"] as $key=>$value){
			$date["class"][$key]["id"]=$value;
			$date["class"][$key]["title"]=$list_array["type"]["title"][$key];
		}
		
		if($list_array["list"]["video"][0]){
			foreach($list_array["list"]["video"] as $key=>$value){
				$title=$this->add_also_known_as($value["name"]);
				$date["video"][$key]["mid"]=$value["id"];
				$date["video"][$key]["tid"]=$value["tid"];
				$date["video"][$key]["type"]=$value["type"];
				$date["video"][$key]["title"]=$title["title"];
				$date["video"][$key]["last"]=strtotime($value["last"]);
				$date["video"][$key]["serialize"]=$value["note"];
				if($collect){
					$date["video"][$key]["category"]=bind_id($fid."_".$value["tid"]);
					$date["video"][$key]["actors"]=$value["actor"];
					$date["video"][$key]["area"]=$value["area"];
					$date["video"][$key]["language"]=$value["lang"];
					$date["video"][$key]["year"]=$value["year"];
					$date["video"][$key]["pic"]=$value["pic"];
					$date["video"][$key]["content"]=$value["des"];
					$date["video"][$key]["also_known_as"]=$title["aka"];
					$date["video"][$key]["directors"]=$value["director"];
					$date["video"][$key]["reurl"]=$value["reurl"]?$value["reurl"]:I('url')."/".$value["id"];
					$date["video"][$key]["play"]=$this->url_replace($value["dl"]["dd"]);
					$date["return"]["video"][]=$this->CModel->insert($date["video"][$key]);
					$i++;
					$date["return"]["num"]["i"]=$i;
				}
			}
		}else{
				$title=$this->add_also_known_as($list_array["list"]["video"]["name"]);
				$date["video"][0]["mid"]=$list_array["list"]["video"]["id"];
				$date["video"][0]["tid"]=$list_array["list"]["video"]["tid"];
				$date["video"][0]["type"]=$list_array["list"]["video"]["type"];
				$date["video"][0]["title"]=$title["title"];
				$date["video"][0]["last"]=strtotime($list_array["list"]["video"]["last"]);
				$date["video"][0]["serialize"]=$list_array["list"]["video"]["note"];
				if($collect){
					$date["video"][0]["category"]=bind_id($fid."_".$list_array["list"]["video"]["tid"]);
					$date["video"][0]["actors"]=$list_array["list"]["video"]["actor"];
					$date["video"][0]["area"]=$list_array["list"]["video"]["area"];
					$date["video"][0]["language"]=$list_array["list"]["video"]["lang"];
					$date["video"][0]["year"]=$list_array["list"]["video"]["year"];
					$date["video"][0]["pic"]=$list_array["list"]["video"]["pic"];
					$date["video"][0]["content"]=$list_array["list"]["video"]["des"];
					$date["video"][0]["also_known_as"]=$title["aka"];
					$date["video"][0]["directors"]=$list_array["list"]["video"]["director"];
					$date["video"][0]["reurl"]=$list_array["list"]["video"]["reurl"]?$list_array["list"]["video"]["reurl"]:I('url')."/".$date["video"][0]["mid"];
					$date["video"][0]["play"]=$this->url_replace($list_array["list"]["video"]["dl"]["dd"]);
					$date["return"]["video"][]=$this->CModel->insert($date["video"][0]);
					$i++;
					$date["return"]["num"]["i"]=$i;
				}
		}
		return $date;
	}
	
	public function json2array($string){
		$fid=I('fid');
		$i=0;
		$list_array=json_decode($string, true);
		foreach($list_array["video"] as $key=>$value){
			$list_array["video"][$key]["category"]=bind_id($fid."_".$value["tid"]);
			$list_array["return"]["video"][]=$this->CModel->insert($list_array["video"][$key]);
			$i++;
			$list_array["return"]["num"]["i"]=$i;
		}
		return $list_array;
	}
	
	public function player(){
		$type=I('type');
		$url=str_replace('@','//',I('url'));
		$this->show('<div id="_player" style="width:720px;height:535px;">'.D('Player')->getPlayerUrl($url,$type).'</div>');
	}
	
	private function json_to_array($string){
		$xml=simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA);
		$xml->addChild("type");
		foreach($xml->class->ty as $k=>$v){
			$xml->type->addChild("id",$v->attributes());
			$xml->type->addChild("title",$v);
		}
		return json_decode(json_encode($xml), true);
	}
	
	private function add_also_known_as($title){
		$title=explode('/',$title);
		return array('title' =>$title[0], 'aka'=>implode(',',array_slice($title,1)));
	}
	
	private function url_replace($playurl){
		$playx=explode('#',$playurl);
		$playname=explode('$',$playx[0]);
		$playurl=$playname[2]."$$".$playurl;
		$playerurl=array();
		$array_url = array();
		$array_play=explode('$$$',$playurl);
		foreach($array_play as $k=>$v){
			$arr_url = explode('$$',$v);
			$arr_ji = explode('#',$arr_url[1]);
			foreach($arr_ji as $key=>$value){
				$urlji = explode('$',$value);
				$array_url[$key] = $urlji[0].'$'.trim($urlji[1]);
			}
			$url=implode(chr(13),$array_url);
			$playerurl[$k]=array("name"=>$arr_url[0],"url"=>$url);
		}
		return $playerurl;
	}
}