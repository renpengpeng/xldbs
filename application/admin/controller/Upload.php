<?php
namespace app\admin\controller;

use think\Session;
use think\Cookie;
use think\Request;
use think\Config;
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
		// 获取存放主题信息的文件名
		$tolInfoName 			=	Config::get('xld.tpl_version_filename');

		// 接收 只接受rar zip 后缀
		$file 					= 	request()->file('tplZIP');

		if($file){
			$info 		 		=	$file->rule('uniqid')->validate(['ext'=>'zip'])->move($uploadPath);
		}else{
			$info 				=	false;
		}

		if(!$info){
			return returnLayuiType(false,$this->code['uploadFileError'],null);
		}else{
			$fileName 			=	$info->getSaveName();
			$fname 				=	$info->getFilename();
			$filePath 			=	$uploadPath.$fileName;
			// 解压目录
			$decoPath 			=	noDrivePath($uploadPath,true);
		}

		// 如果打不开
		if($this->zip->open($filePath, \ZipArchive::CREATE) === FALSE){
			return returnLayuiType(false,$this->code['openRarError'],null);
		}

		// 开始解压
		$jieya 	=	$this->zip->extractTo($decoPath.$nowID.DS);

		// 解压失败
		if(!$jieya){
			// 关闭压缩包
			$this->zip->close();

			// 删除压缩包
			$delRar 			=	realpath(unlink($fileName));


			return returnLayuiType(false,$this->code['decompressionError'],null);
		}

<<<<<<< HEAD
		// 关闭压缩包
		$this->zip->close();

		unset($this->zip);
		unset($file);
		unset($info);

		// 切换路径
		chdir($uploadPath);

		// 解压完毕开始删除压缩包
		$delRar 				=	@unlink($fileName);

		// 判断是否符合主题规范
		$isTpl 					=	checkTplSpeci($nowID);

		// 如果不符合主题规范
		if(!$isTpl){
			// 删除文件夹
			$delDir 			=	delDir($decoPath.$nowID.DS,true);

			if(file_exists($fileName)){
				$delRar 		=	@unlink($fileName);
			}

			return returnLayuiType(false,$this->code['themeNoSpec'],null);
		}

		// 开始读取主题的基本信息
		$tplInfo 				=	include $nowID.DS.$tolInfoName;

		if(!$tplInfo){
			// 删除文件夹
			$delDir 			=	delDir($decoPath.$nowID.DS,true);

			return returnLayuiType(false,$this->code['readTplInfoError'],null);
		}

		// 主题名字
		$tpls['tpl_name']			=	isset($tplInfo['tpl_name']) ? $tplInfo['tpl_name'] : '';
		// 获得作者
		$tpls['author'] 			=	isset($tplInfo['author']) ? $tplInfo['author'] : '';
		// 获得主题版本
		$tpls['version'] 			=	isset($tplInfo['version']) ? $tplInfo['version'] : '';
		// 获得主题颜色
		$tpls['color']				=	isset($tplInfo['color']) ? $tplInfo['color'] : '';
		// 获得主题描述
		$tpls['description']		=	isset($tplInfo['description']) ? $tplInfo['description'] : '';

		// 过滤
		$tpls 						=	safeArray($tpls);

		// 插入数据
		$result 					=	$this->tplInfoModel->insert($tpls);
		$insertID 					=	$this->tplInfoModel->getLastInsID();

		if($result){
			// 返回成功
			return returnLayuiType(true,$this->code['uploadFileSuccess'],$insertID);
		}else{
			// 返回失败
			return returnLayuiType(false,$this->code['uploadFileError'],null);
		}		
=======
		
>>>>>>> f637b0b166ad1564206b4742e91c34c15c47ea43

	}
	public function upload(){
		//图片上传
        $file                   =   request()->file('titlepic');
        if($file){
        $info                   =   $file->move(Config::get('xld.uploads_path'));
        if($info){
            $a                  =   $info->getSaveName();  
            $imgp               =   str_replace("\\","/",$a);  
            $imgpath            =   $imgp;  
            $data['titlepic']   =   $imgpath;  
  
        }else{
            echo $file->getError();
        }
                 }
	}

}