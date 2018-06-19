<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Session;
use think\Config;
use \think\File;

class content extends Base {
	private $setting;

	public function _initialize(){
		adminLoad();
		$this->setting 	=	getConfig();
	}

	/**
 	 *	文章管理 重新定义到列表页面
	*/
	public function article(){
		$this->redirect(url('list'));
	}
	/**
	 *	列表页面
	*/
    public function article_list(){
    	$result    =   Model("article")->select();

    	$this->assign("list",$result);
    	return view(getNowActionTpl());
    }
	/**
	 *	文章添加页面
	*/
    public function article_add(){
        $data   =   input('post.');
    	return view(getNowActionTpl());
    }
    /**
     * 添加页面处理方法
     */
    public function article_add_oper(){
        $data   =   input('post.');
    }
}