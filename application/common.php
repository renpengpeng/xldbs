<?php
use think\Config;
use think\Session;

// 引入web公共文件
require_once 'webFun.php';

// 引入admin函数文件
require_once 'adminFun.php';

// 引入tpl模板控制器的函数文件
require_once 'tplFun.php';

/**
 * 	获取后台当前方法的绝对使用模板
 *	@param enter 模型  默认admin
 *	@param file  可传入的文件名 不允许带入后缀
*/
function getNowActionTpl($enter='admin',$file=false){
	$module 			=	strtolower(request()->module());
	$controller 		=	strtolower(request()->controller());
	$action 			=	strtolower(request()->action());
	$ext 				=	Config::get('template.view_suffix');

	$syspath 			=	Config::get('xld.system_tpl_path');		

	if($file){
		$path 			=	$syspath.$module.DS.$controller.DS.$file.$ext;
	}else{
		$path 			=	$syspath.$module.DS.$controller.DS.$action.'.'.$ext;
	}
	
	return $path;
}

/**
 *	获取数据库的最后一个ID
 *	@param table   resource类型 传入model
 *	@param key 	   传入表的主键
*/
function getTableLastID($table,$key){
	$find 	=	$table->order("{$key} desc")->limit(1)->find();

	$id 	=	$find[$key];

	return $id;
}