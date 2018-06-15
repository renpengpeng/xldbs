<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Session;
use think\Cookie;

class Tpl extends Base {
	public function _initialize(){
		adminLoad();
	}
	public function header(){
		return getNowActionTpl();
	}
	public function footer(){
		return view(getNowActionTpl());
	}
	
}