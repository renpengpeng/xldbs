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
		$this->setting 			=	getConfig();
		$this->setting 			=	loadCode();
		$this->uplInfoModel 	=	Model('tplInfo');
	}
 
	/**
	 *	模板上传
	*/
	public function tpl_upload(){
		// 获取模板的最后一个ID
		$getLastId 			=	
		// 获取上传后的文件夹
		$uploadPath 		=	Config::get('xld.all_upload_tpl');

		// 接收 只接受rar zip 后缀
		$file 				= 	request()->file('tplZIP');

		if($file){
			$info 		 	=	$file->validate(['ext'=>'zip,rar'])->move($uploadPath);

		}
	}
}