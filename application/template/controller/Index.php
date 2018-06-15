<?php
namespace app\template\controller;

use app\common\controller\Base;
use think\Session;
use think\Config;

class Index extends Base {
	private $setting;

	public function _initialize(){
		tplLoad();
	}

	public function index(){
		return view(getNowActionTpl('tpl'));
	}
}