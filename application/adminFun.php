<?php 
#--------------------------------------------
#		filename 	: 	webFun.php
#		firstTime 	:	2018/6/7
#		lastTime    :	
#		author  	:	任鹏鹏
#
#		░░░░░░░░░░░░░░░░░░░░░░░░▄░░
#		░░░░░░░░░▐█░░░░░░░░░░░▄▀▒▌░
#		░░░░░░░░▐▀▒█░░░░░░░░▄▀▒▒▒▐
#		░░░░░░░▐▄▀▒▒▀▀▀▀▄▄▄▀▒▒▒▒▒▐
#		░░░░░▄▄▀▒░▒▒▒▒▒▒▒▒▒█▒▒▄█▒▐
#		░░░▄▀▒▒▒░░░▒▒▒░░░▒▒▒▀██▀▒▌
#		░░▐▒▒▒▄▄▒▒▒▒░░░▒▒▒▒▒▒▒▀▄▒▒
#		░░▌░░▌█▀▒▒▒▒▒▄▀█▄▒▒▒▒▒▒▒█▒▐
#		░▐░░░▒▒▒▒▒▒▒▒▌██▀▒▒░░░▒▒▒▀▄
#		░▌░▒▄██▄▒▒▒▒▒▒▒▒▒░░░░░░▒▒▒▒
#		▀▒▀▐▄█▄█▌▄░▀▒▒░░░░░░░░░░▒▒▒
#--------------------------------------------

use think\Request;
use think\Session;
use think\Cookie;
use think\Config;
use think\helper\Time;

/**
 *	adminLoad
 *	后台自动加载项
*/
function adminLoad(){
	is_login(true,false);
	// checkAuth();
}

/**
 *	is_login
 *	@param refresh  		未登录是否跳转
 *	@param hasLoginRefresh 	已经登录是否跳转
*/
function is_login($refresh=false,$hasLoginRefresh=false){
	$data =	Session::has('admin_data');
	if(!$data){
		if($refresh){
			header('location:'.url('admin/login/index'));
		}else{
			return false;
		}
	}else{
		if($hasLoginRefresh){
			header('location:'.url('admin/index/index'));
		}else{
			return true;
		}
	}
}

/**
 *	安全的数组
 *	@var arr 	传入的数组
*/
function safeArray($arr){
	if(!is_array($arr) || !$arr){
		return false;
	}

	foreach ($arr as $key => $value) {
		if(is_array($value)){
			$value 	=	safeArray($value);
		}else{
			$arr[$key] 	=	htmlspecialchars($value);
		}

		if(strlen($value) <= 0){
			unset($arr[$key]);
		}
	}
	
	return $arr;
}

/**
 *	反过滤安全的数组
 *	@var arr  传入的数组
*/
function noSafeArray($arr){
	if(!is_array($arr) || !$arr){
		return false;
	}

	foreach ($arr as $key => $value) {
		if(is_array($value)){
			$value 	=	safeArray($value);
		}else{
			$arr[$key] 	=	htmlspecialchars_decode($value);
		}

		if(strlen($value) <= 0){
			unset($arr[$key]);
		}
	}
	return $arr;
}

/**
 *	判断AUTH
*/
function checkAuth(){
	$code 			=	loadCode();

	// 获取当前模块
	$module 		=	request()->module();
	// 获取当前控制器
	$controller 	=	request()->controller();
	// 获取当前方法
	$action 		=	request()->action();

	// 获取 当前的auth 等级
	$auth 			=	Session::get('admin_data')['auth'];
	// 查询 权限组
	if(!$auth || $auth < 1){
		echo $code['noAuthGroup'];die;
	}

	// 查询权限组
	$findAuth 		=	Model('AuthAdmin')->get($auth);
	if(!$findAuth){
		echo $code['noCossAuthGroup'];die;
	}

	// 开始判断
	$colls 			=	$findAuth['auth'];
	if($findAuth != 'all'){
		if(strpos($colls, ',')){
			$colls 		=	explode(',',$colls);
			$colls 		=	safeArray($colls);
			if(!in_array($controller,$colls)){
				echo $code['noAuthEnter'];die;
			}
		}else{
			if($controller != 	$colls){
				echo $code['noAuthEnter'];die;
			}
		}
	}

	// 正常访问
	return true;
}

/**
 *	用户登录
 *	@param 	type 		传入登录类型 暂定:index / admin
 *	@param  username 	传入登录的用户名
 *	@param 	password 	传入登录的密码
 *	
*/
function Login($type=false,$username=false,$password=false){

	if(!$type || !$username || !$password){
		return false;
	}
	$md5Str 	=	Config::get('xld.password_str');
	$password 	=	md5($password.$md5Str);

	// 查找是否有对应的用户
	$find 		=	Model('User')->where(['username'=>$username,'password'=>$password])->find();

	if(!$find){
		return false;
	}

	// 如果是管理后台 如果不是管理员 退出
	if($type == 'admin'){
		if(!$find['is_admin']){
			return false;
		}
	}

	// 如果是代理后台 如果不是代理
	if($type == 'agent'){
		if(!$find['is_agent']){
			return false;
		}
	}

	// 判断用户状态
	$userStatus =	$find['status'];
	if(!$userStatus){
		return 0;
	}else{
		// 判断是否被加入黑名单
		if($userStatus == 2){
			$unLockTime 	=	$find['unblock_time'];
			if(time() < $unLockTime){
				return false;
			}
		}
	}

	switch ($type) {
		case 'index':
			$sessionName 	=	'index_data';
		break;
		
		case 'admin':
			$sessionName 	=	'admin_data';
		break;
		default:
			return false;
		break;
	}

	Session::set($sessionName,$find->toArray());

	return true;
}

/**
 * 	退出登录
 *	@param type   登录类型  
*/
function LoginOut($type){
	switch ($type) {
		case 'index':
			$sessionName 	=	'index_data';
		break;
		
		case 'admin':
			$sessionName 	=	'admin_data';
		break;
		default:
			return false;
		break;
	}

	Session::delete($sessionName);
	return true;
}

/**
 *	获取admin模板的文件夹
*/
function getAdminTplPath(){
	$path 	= 	Config::get('xld.admin_tpl');

	return $path;
}

/**
 * 	获取admin当前方法的绝对使用模板
 *	@param file  可传入的文件名 不允许带入后缀
*/
function getAdminNowActionTpl($file=false){
	$controller 		=	strtolower(request()->controller());
	$action 			=	strtolower(request()->action());
	$ext 				=	Config::get('template.view_suffix');

	if($file){
		$path 			=	getAdminTplPath().$controller.DS.$file.$ext;
	}else{
		$path 			=	getAdminTplPath().$controller.DS.$action.'.'.$ext;
	}
	
	return $path;
}

/**
 *	自动加载code
*/
function loadCode(){
	$code = Config::get('code');
	return $code;
}


/**
 *	获取过去N天的数组
 *  @param day 传入的天数  如果不传 默认等于7（过去一周）
*/
function getLastDay($day=7){
	$today 	=	Time::today();

	if(!is_numeric($day)){
		return false;
	}

	$t1 	=	$today[0];
	$t2 	=	$today[1];

	$newArr	=	[];
	for ($i=0; $i < $day ; $i++) { 
		$sub 			=	$day-$i;
		$newArr[$i][0] 	=	$t1 - (60*60*24) * $sub;
		$newArr[$i][1] 	=	$t2 - (60*60*24) * $sub;
	}

	return $newArr;
}

/**
 *	只获取省份 /  二级城市 /  地县级
 *	@param type     ->	province(省级)  city(市级)   (county)县区级
 *	@param partent 	->	如果为null 则获取指定父级的市级 / 县级 省级传入无效果
*/
function getSpaceCity($type='province',$partent=null){
	$m 		=	Model('Area');

	switch ($type) {
		case 'province':
			$result 		=	$m->where('parentid',0)->select();
		break;
		
		case 'city':
			if($partent){
				$result 	=	$m->where('parentid',$partent)->select();
			}else{	
				// 先获取所有的省
				$province 	=	getSpaceCity('province');
				$ids 		=	'';
				foreach ($province as $key => $value) {
					$ids 	.=	','.$province[$key]['areaid'];
				}
				$ids 		=	substr($ids,1);

				// 开始查所有的城市
				$result 	=	$m->where('parentid','in',$ids)->select();
			}
		break;

		case 'county':
			if($partent){
				$result 	=	$m->where('parentid')->select();
			}else{
				// 获取所有的市
				$city 		=	getSpaceCity('city');

				$ids 		=	'';
				foreach ($city as $key => $value) {
					$ids 	.=	','.$city[$key]['areaid'];
				}
				$ids 		=	substr($ids,1);

				// 查找所有县区
				$result 	=	$m->where('parentid','in',$ids)->select();

			}
		break;

		default:
			return false;
		break;
	}

	return $result;
}