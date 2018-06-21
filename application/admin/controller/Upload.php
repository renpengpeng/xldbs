<?php
namespace app\admin\controller;

use think\Session;
use think\Cookie;
use think\Request;
use app\common\controller\Base;

class Upload extends Base {
	private $setting;
	private $code;
	private $tpl_upload;
	private $zip;

	public function _initialize(){
		$this->setting 			=	getConfig();
		$this->setting 			=	loadCode();
		$this->tplInfoModel 	=	Model('tplInfo');
		$this->code 			=	loadCode();
		$this->zip 				=	new \ZipArchive();
	}
 
	/**
	 *	模板上传
	*/
	public function tpl_upload(){
		// 获取模板的最后一个ID
		$getLastId 				=	getTableLastID($this->tplInfoModel,'id');
		$nowID 					=	$getLastId+1;
		
		// 获取上传后的文件夹
		$uploadPath 			=	Config::get('xld.all_upload_tpl');

		// 接收 只接受rar zip 后缀
		$file 					= 	request()->file('tplZIP');

		if($file){
			$info 		 		=	$file->validate(['ext'=>'zip,rar'])->move($uploadPath);
		}else{
			$info 				=	false;
		}

		if(!$info){
			return $this->error($this->code['uploadFileError']);
		}else{
			$fileName 			=	$info->getFilename();
			$filePath 			=	$uploadPath.$fileName;
		}

		// 如果打开
		if($this->zip->open($filePath)){
			// 开始解压
			$this->extractTo($filePath);

			// 解压完毕开始删除压缩包
			$delRar 			=	unlink($filePath);

			

		}else{
			return $this->error($this->code['openRarError']);
		}


	}
}