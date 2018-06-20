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
	is_login('admin',true,false);
	// checkAuth();
}

/**
 *	is_login
 *	@param type  			admin->后台   tpl->模板选择   agent->代理后台
 *	@param refresh  		未登录是否跳转
 *	@param hasLoginRefresh 	已经登录是否跳转
*/
function is_login($type='admin',$refresh=false,$hasLoginRefresh=false){
	switch ($type) {
		case 'admin':
			$data 		=	Session::has('admin_data');
			$loca 		=	url('admin/login/index');
			$index 		=	url('admin/index/index');
		break;
		
		case 'tpl':
			$data 		=	Session::has('tpl_data');
			$loca 		=	url('template/login/index');
			$index 		=	url('template/index/index');
		break;

		case 'agent':
			$data 		=	Session::has('agent_data');
			$loca 		= 	url('agent/login/index');
			$index 		=	url('agent/index/index');	
		break;
		
		default:
			return false;
		break;
	}
	   
	if(!$data){
		if($refresh){
			header('location:'.$loca);
		}else{
			return false;
		}
	}else{
		if($hasLoginRefresh){
			header('location:'.$index);
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

	// 如果是模板选择后台 如果不是管理员或者代理
	if($type == 'tpl'){
		if(!$find['is_agent']){
			if(!$find['is_admin']){
				return false;
			}
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

		case 'tpl':
			$sessionName 	=	'tpl_data';
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

		case 'tpl':
			$sessionName 	=	'tpl_data';
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

/**
 *	获取文件夹的大小 包括子文件 / 文件夹
 *	@param dir  传入的文件夹路径
*/
function getDirSize($dir){
    $size  	= 	0;
    $op  	= 	opendir($dir);
    $re 	=	scandir($dir);
    foreach ($re as $key => $value) {
    	if($value != '.' && $value != '..'){
    		if(is_dir($dir.DS.$value)){
    			$size += getDirSize($dir.DS.$value);
    		}else{
    			$size += filesize($dir.DS.$value);
    		}
    	}
    }
    return $size;
}

/**
 *	获取文件夹下的文件个数
 *	@param dir 传入文件夹路径 
*/
function getfilecounts($dir){
	$sl=0;
    $arr = glob($dir);
    foreach ($arr as $v)
    {
        if(is_file($v))
        {
            $sl++;
        }
        else
        {
            $sl+=getfilecounts($v."/*");
        }
    }
    return $sl;
}

/**
 *	删除某个文件夹
 *	@param path
*/
function delDir($path) {
	if(is_dir($path)){
	   $p = scandir($path);
	   foreach($p as $val){
	    if($val !="." && $val !=".."){
	     if(is_dir($path.$val)){
	        deldir($path.$val.'/');
	        @rmdir($path.$val.'/');
	     }else{
	        unlink($path.$val);
	     }
	    }
	}
  }
}

/**
 *	单位换算
 *	@param size  		传入的大小 默认字节(bit)  不存在的单位 返回0
 *	@param sizeType 	传入的单位
 *	@param getType 		要获取的单位
*/
function sizeConversion($size=1024,$sizeType='bytes',$getType='bit'){
	$sizeType 		=	strtolower($sizeType);
	$typeArr 		=	['bit','bytes','kb','mb','gb','tb'];
	$result 		=	[];
	if(!in_array($sizeType,$typeArr)){
		return 0;
	}

	switch ($sizeType) {
		case 'bit':
			$result['bit'] 		=	$size;
			$result['bytes'] 	=	$result['bit']/8;
			$result['kb'] 		=	$result['bytes']/1024;
			$result['mb'] 		=	$result['kb']/1024;
			$result['gb'] 		=	$result['mb']/1024;
			$result['tb'] 		=	$result['gb']/1024;
		break;

		case 'bytes':
			$result['bit'] 		=	$size * 8;
			$result['bytes'] 	=	$size;
			$result['kb'] 		=	$result['bytes'] / 1024;
			$result['mb'] 		=	$result['kb']/1024;
			$result['gb'] 		=	$result['mb']/1024;
			$result['tb'] 		=	$result['gb']/1024;
		break;

		case 'kb':
			$result['bit'] 		=	$size * 1024 * 8;
			$result['bytes'] 	=	$size * 1024;
			$result['kb'] 		=	$size;
			$result['mb'] 		=	$result['kb']/1024;
			$result['gb'] 		=	$result['mb']/1024;
			$result['tb'] 		=	$result['gb']/1024;
		break;
		
		case 'mb':
			$result['bit'] 		=	$size * 1024 * 1024 * 8;
			$result['bytes'] 	=	$size * 1024 * 1024;
			$result['kb'] 		=	$size * 1024;
			$result['mb'] 		=	$size;
			$result['gb'] 		=	$result['mb']/1024;
			$result['tb'] 		=	$result['gb']/1024;
		break;

		case 'gb':
			$result['bit'] 	=	$size * 1024 * 1024 * 1024 * 8;
			$result['bytes'] 	=	$size * 1024 * 1024 * 1024;
			$result['kb'] 	=	$size * 1024 * 1024;
			$result['mb'] 	=	$size * 1024 ;
			$result['gb'] 	=	$size;
			$result['tb'] 	=	$result['gb']/1024;
		break;
		default:
			return 0;
		break;
	}

	foreach ($result as $key => $value) {
		if(strripos($value,'.')){
			$len 			=	strripos($value,'.');
			$lenone 		=	$len + 3;
			$result[$key]	=	substr($value,0,$lenone);
		}
	}

	switch ($getType) {
		case 'bit':
			return $result['bit'];
		break;

		case 'bytes':
			return $result['bytes'];
		break;

		case 'kb':
			return $result['kb'];
		break;

		case 'mb':
			return $result['mb'];
		break;

		case 'gb':
			return $result['gb'];
		break;
		
		default:
			return 0;
		break;
	}
}
/**
 * kb，mb，gb自动转换大小
 * @param size 	传入的大小
*/
function automaticSize($size) { 
	$units = array(' B', ' KB', ' MB', ' GB', ' TB'); 
	for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024; 
	return round($size, 2).$units[$i]; 
} 