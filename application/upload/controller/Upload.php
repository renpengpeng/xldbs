<?php
namespace app\admin\controller;

use think\Session;
use think\Cookie;
use think\Request;
use app\common\controller\Base;

class Upload extends Base {
	private $setting;
	private $code;

	public function _initialize(){
		$this->setting 	=	getConfig();
		$this->setting 	=	loadCode();
	}
 
	/**
	 *	模板上传
	*/
	public function tpl_upload(){
		$uploadPath 	=	Config::get('xld.all_upload_tpl');

		// 接收
		
	}
}