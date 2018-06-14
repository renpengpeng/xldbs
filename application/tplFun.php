<?php
/**
 *	@author  任鹏鹏
 *	@version 1.0
*/

use think\Session;
use think\Cookie;
use think\Request;
use think\Config;

/**
 *	tplload  tpl引入自动加载
*/
function tplLoad(){

}



/**
 * 	获取admin当前方法的绝对使用模板
 *	@param file  可传入的文件名 不允许带入后缀
*/
function getSelectTplNowTpl($file=false){
	$controller 		=	strtolower(request()->controller());
	$action 			=	strtolower(request()->action());
	$ext 				=	Config::get('template.view_suffix');

	if($file){
		$path 			=	Config::get('xld.selecttpl_tpl').$controller.DS.$file.$ext;
	}else{
		$path 			=	Config::get('xld.selecttpl_tpl').$controller.DS.$action.'.'.$ext;
	}
	
	return $path;
}