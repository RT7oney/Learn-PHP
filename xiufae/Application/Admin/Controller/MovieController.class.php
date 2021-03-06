<?php
namespace Admin\Controller;

/**
 * 后台配置控制器
 */
class MovieController extends AdminController {
	 /**
     * 影片列表
     */
    public function index(){
		$Movie = D('Movie');
        $map = array();
        if(isset($_GET['keyword'])){
            $where['title']  = array('like', '%'.I('keyword').'%');
			$where['actors']  = array('like', '%'.I('keyword').'%');
			$where['also_known_as']  = array('like', '%'.I('keyword').'%');
			$where['directors']  = array('like', '%'.I('keyword').'%');
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
        }
		if(isset($_GET['category'])){
			$cid=$Movie->getId(I('category'));
			if(is_numeric($cid)){
				$map['category']  = $cid;
			} else {
				
				$map['category'] = array('in', $cid);
			}
        }
		if(isset($_GET["order"])){
			$order=I('order')." ".I('type');
		}else{
			$order="id desc";
		}
        $list   =   $this->lists('movie', $map ,$order);
        $this->assign('movielist', $list);
		$this->assign('category',   $Movie->getTree());
        $this->meta_title = '影片管理';
        $this->display();
    }

    /* 编辑影片 */
    public function edit($id = null){
        $Movie = D('Movie');

        if(IS_POST){ //提交表单
            if(false !== $Movie->update()){
                $this->success('编辑成功！', U('index'));
            } else {
                $error = $Movie->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
			$info=$Movie->info($id);
            $this->assign('info',       $info);
            $this->assign('category',   $Movie->getTree());
			$this->assign('playerlist',   $Movie->getPlayer());
            $this->meta_title = '编辑影片';
            $this->display();
        }
    }

    /* 新增影片 */
    public function add(){
        $Movie = D('Movie');

        if(IS_POST){ //提交表单
            if(false !== $Movie->update()){
                $this->success('新增成功！', U('index'));
            } else {
                $error = $Movie->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        } else {
           
            /* 获取影片信息 */
            $this->assign('category', $Movie->getTree());
			$this->assign('playerlist',   $Movie->getPlayer());
            $this->meta_title = '新增影片';
            $this->display('edit');
        }
    }
	
	public function delurl($pid = null){
        //删除影片地址
        $res = M('movie_url')->delete($pid);
        if($res !== false){
            $this->success('删除影片播放地址成功！');
        }else{
            $this->error('删除影片播放地址失败！');
        }
	}
	
	/**
     * 删除影片
     */
    public function del(){
		$id = array_unique((array)I('id',0));
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $res = D('Movie')->remove($id);
        if($res !== false){
            $this->success('删除影片成功！');
        }else{
            $this->error('删除影片失败！');
        }
    }
}
