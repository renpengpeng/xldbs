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
		$this->setting 	=	getConfig();
		is_login('tpl',false,true);
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
		$username 	=	input('?username') ? input('username') : false;
		$password 	=	input('?password') ? input('password') : false;

		$login 		=	Login('tpl',$username,$password);

		if($login){
			return $this->success('登录成功');
		}else{
			return $this->error('登录失败');
		}
	}
}