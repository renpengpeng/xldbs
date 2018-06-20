<?php
namespace app\template\controller;

use app\common\controller\Base;
use think\Session;

class Tpl extends Base {
	/**
	 *	头部
	*/
	public function header(){
		return view(getNowActionTpl('tpl'));
	}

	/**
	 *  公共底部
	*/
	public function footer(){
		return view(getNowActionTpl('tpl'));
	}

}