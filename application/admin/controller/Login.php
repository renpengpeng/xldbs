<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Config;
use think\Session;

class Login extends Base {
	private $systemName;
	private $systemVersion;
	private $code;

	public function _initialize(){
		// 检测是否已经登录 
		is_login(false,true);

		$this->systemName 		=	Config::get('xld.system_name');
		$this->systemVersion 	=	Config::get('xld.system_version');	
		$this->companyName	 	=	Config::get('xld.company_name');	

		$this->assign('systemName',$this->systemName);
		$this->assign('systemVersion',$this->systemVersion);
		$this->assign('companyName',$this->companyName);

		$this->code 			=	loadCode();
	}
	public function index(){
		return view(getAdminNowActionTpl());
	}
	public function login(){
		$username 	=	input('?post.username') ? htmlspecialchars(input('post.username')) : false;
		$password 	=	input('?password') ? htmlspecialchars(input('post.password')) : false;

		if(!$username || !$password){
			return $this->error($this->code['noEnterUsernameOrPass']);
		}

		$result 	=	Login('admin',$username,$password);
		if($result){
			return $this->success($this->code['loginSuccess']);
		}else{
			return $this->error($this->code['loginError']);
		}

	}
}