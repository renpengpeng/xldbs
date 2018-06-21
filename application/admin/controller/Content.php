<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Session;
use think\Config;
use think\Request;


class Content extends Base {
	private $setting;
    private $code;
    private $articleTable;
    private $articleModel;

	public function _initialize(){
		adminLoad();
		$this->setting 	        =	getConfig();
        $this->code             =   loadCode();
        $this->articleModel     =   Model('Article');
        $this->articleTable     =   $this->articleModel->getTableFields();
	}

	/**
 	 *	文章管理 重新定义到列表页面
	*/
	public function index(){
		$this->redirect(url('list'));
	}
	/**
	 *	列表页面
	*/
    public function list(){
    	$result    =    $this->articleModel->select();
    	$this->assign("list",$result);
    	return view(getNowActionTpl());
    }
    
    /**
     * 添加页面显示
     */
    public function article_add(){
        $web_result     =    Model("webInfo")->select();
        $cate_result    =    Model("artCate")->select();
        $id             =    input('?id') ? intval(input('id')) : false;
        if(!$id){
            foreach ($this->articleTable as $key => $value) {
                $message[$value]    =   '';
            }
        }else{
            $message    =   $this->articleModel->get($id);
        }

        $this->assign('message',$message);
        $this->assign('catelist',$cate_result);
        $this->assign("weblist",$web_result);
        return view(getNowActionTpl());
    }
    /**
     * 文章 / 编辑添加文章处理方法
     */
    public function article_add_oper(){
        $data           =   input('post.');
        $data           =   safeArray($data);
        $id             =   isset($data['id']) ? intval($data['id']) : false;
        if($id){
            $result     =   $this->articleModel->insert($data);    
        }else{
            $result     =   $this->articleModel->where('id',$id)->update($data);
        }
        if(!$result){
                    return $this->success($this->code['newArticleSuccess']);
        }else{
                    return $this->error($this->code['editArticleError']);
        }
    }
    public function article_del(){
        $data           =   input("post.");
        $id             =   isset($data['id']) ? intval($data['id']) : false;
        $result=$this->articleModel->where('id',$id)->delete();
        if($result){
                   return $this->success($this->code['delArticleSuccess']);
        }else{
                   return $this->success($this->code['delArticleError']);
        }
    }
}