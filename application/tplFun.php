<?php
/**
 *	@author  任鹏鹏
 *	@version 1.0
*/

use think\Session;
use think\Cookie;
use think\Request;
use think\Config;
use think\Model;

/**
 *	tplload  tpl引入自动加载
*/
function tplLoad(){
	is_login('tpl',true,false);
}

/**
 *	判断主题是否符合规范
 *	@param 	dirname 		文件夹名字
 *	@return boolean
*/
function checkTplSpeci($dirname){
	$configArr 	=	Config::get('xld');
	return $configArr;

	$tplPath 	=	$configArr['all_upload_tpl'].$dirname;

	if(!opendir($tplPath)){
		return false;
	}

	// 开发目录
	$devPath 	=	$tplPath.DS.$configArr['tpl_dev_dirname'];
	// 预览目录
	$lookPath 	=	$tplPath.DS.$configArr['tpl_look_dirname'];
	// 存放主题信息的文件
	$infoPath 	=	$tplPath.DS.$configArr['tpl_version_filename'];
	// 存放主题图片的文件
	$pngPath 	=	$tplPath.DS.$configArr['tpl_png_filename'];

	if(!is_dir($devPath) || !is_dir($lookPath) || !is_file($infoPath) || !is_file($pngPath)){
		return false;
	}else{
		return true;
	}
}

/**
 *	读取上传之后的模板的信息 读取模板的一些信息 根据config 的规则
 *	@param  dirname 	文件夹名字
 *	@return array 		
*/
function getTplInfoForDir($dirname){
	$tplPath 	=	Config::get('xld.all_upload_tpl').$dirname;
	if(!opendir($tplPath)){
		return false;
	}
}

/**
 *	去除绝对路径中的盘符 (windows)
 *	@param path 	传入路径地址
 *	@param convert 	是否转换左斜杠为右斜杠  默认为否
*/
function noDrivePath($path,$convert=false){
	if(preg_match("/[a-zA-Z]{0,1}\:\\\/",$path)){
		$path 	=	preg_replace("/[a-zA-Z]{0,1}\:\\\/",'/',$path);
	}

	if($convert){
		$path 	=	preg_replace("/\\\/",'/',$path);
	}

	return $path;
}

/**
 *	返回layui 接口类型的数据
 *	@param   code  		状态      boolean
 *	@param   msg 		提示信息  string
 *	@param 	 data 		返回数据  array
 *	@return  json
*/
function returnLayuiType($code,$msg,$data){
	if($code){
		$code 	=	0;
	}else{
		$code 	=	1;
	}

	$result 	=	[
		'code' 	=>	$code,
		'msg'	=>	$msg,
		'data' 	=>	$data
	];

	return json($result);
}

/**
 *	获取主题的信息
 *	@todo 	此函数已经作废
 *	@param  type 		all->所有主题信息  如果传入数字 则对应主题ID
 *	@return array 
*/
function getTplInfo($type='all'){
	$m 		=	Model('TplInfo');

	if($type == 'all'){
		$arr 	=	$m->all();
		if($arr){
			foreach ($arr as $key => $value) {
				$tplid 					=	$arr[$key]['id'];
				$arr[$key]['thumb'] 	=	getTplThumbPath($tplid);
			}
		}
	}else{
		$type 			=	intval($type);
		$arr 			=	$m->where('id',$type)->find();
		$arr['thumb']	=	getTplThumbPath($type);
	}

	return $arr;
}

/**
 *	获取主题的缩略图路径
 *	@todo 	主题机制更改  此函数已经作废
 *	@return string
*/
function getTplThumbPath($id){
	$xldArr 		=	Config::get('xld');
	$filename 		=	$xldArr['tpl_png_filename'];
	$filePath 		=	$xldArr['all_upload_tpl'];
	$nopngName 		=	$xldArr['tpl_nopng_filename'];

	$thumbPath 		=	$filePath.$id.DS.$filename;

	if(!is_file($thumbPath)){
		$thumbPath 	=	$filePath.$nopngName;
	}

	return $thumbPath;
}

/**
 *	把绝对路径转化为相对路径
 *	@param 	path 	传入绝对路径
 *	@param 	str 	定位的字符串 
 *	@param  len 	定位到字符串的前几位
 *	@return string
*/
function abPathToRePath($path,$str,$len){
	// 如果 匹配到 '\'  替换为 '/'
	if(preg_match("/\\\/",$path)){
		$path 	=	preg_replace("/\\\/",'/',$path);
	}

	// 开始定位
	$sublen 	=	strpos($path, $str);
	if(!$sublen){
		return false;
	}

	$endlen 	=	strlen($path);

	// 开始截取
	$path 		=	substr($path,$sublen-$len,$endlen);

	return $path;
}