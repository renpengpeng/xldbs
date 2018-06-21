<?php
namespace app\admin\controller;

use think\Session;
use think\Cookie;
use think\Request;
use app\common\controller\Base;

class Template extends Base {
	private $setting;

	public function _initialize(){
		$this->setting 	=	getConfig();
	}
	/**
	 *	跳转到模板列表页面
	*/
	public function index(){
		$this->redirect(url('admin/template/list'));
	}

	/**
	 *	模板列表
	*/
	public function list(){
		return view(getNowActionTpl('admin'));
	}

	/**
	 *	添加模板
	*/
	public function add(){
		return view(getNowActionTpl('admin'));
	}
}