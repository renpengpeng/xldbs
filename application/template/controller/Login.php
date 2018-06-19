<?php
namespace app\template\controller;

use app\common\controller\Base;
use think\Session;

class Login extends Base {
	private $setting;

	/**
	 *	初始化
	*/
	public function _initialize(){
		
	}

	/**
	 * 	登录（视图）
	*/
	public function index(){
		return view(getNowActionTpl());
	}

	/**
	 *	登录处理
	*/
	public function login(){
		$username 	=	input();
	}
}