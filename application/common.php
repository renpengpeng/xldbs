<?php
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
function getTplActin($enter='admin',$file=false){
	$controller 		=	strtolower(request()->controller());
	$action 			=	strtolower(request()->action());
	$ext 				=	Config::get('template.view_suffix');

	switch ($enter) {
		case 'admin':
			# code...
		break;
		
		default:
			# code...
			break;
	}

	if($file){
		$path 			=	Config::get('xld.selecttpl_tpl').$controller.DS.$file.$ext;
	}else{
		$path 			=	Config::get('xld.selecttpl_tpl').$controller.DS.$action.'.'.$ext;
	}
	
	return $path;
}