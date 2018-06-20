<?php
namespace app\admin\controller;

use think\Session;
use think\Cookie;
use think\Request;
use think\Config;
use app\common\controller\Base;
use think\Cache;

class System extends Base {
	private $setting;
	private $cacheTime;
	private $code;

	public function _initialize(){
		$this->setting 		=	getConfig();
		$this->cacheTime 	=	$this->setting['cache_time'];
		$this->code 		=	loadCode();
	}

	/**
	 *	清除缓存 （视图）
	*/
	public function cache_view(){
		$runtimePath 		=	Config::get('xld.cache_path');

		// 获取缓存的模板文件夹个数 *  大小  *   路径
		$cacheTplPath 		=	$runtimePath.'temp';
		$cacheTplCount 		=	getfilecounts($cacheTplPath);
		$cacheTplSize 		=	getDirSize($cacheTplPath);
		$cacheTplSize 		=	automaticSize($cacheTplSize);

		// 获取缓存的数据 的文件夹个数  *  大小 * 路径
		$cacheDataPath 		=	$runtimePath.'cache';
		$cacheDataCount 	=	getfilecounts($cacheDataPath);
		$cacheDataSize 		=	getDirSize($cacheDataPath);
		$cacheDataSize 		=	automaticSize($cacheDataSize);

		// 获取缓存的日志 的文件夹个数  * 大小  *  路径
		$cacheLogPath 		=	$runtimePath.'log';
		$cacheLogCount 		=	getfilecounts($cacheLogPath);
		$cacheLogSize 		=	getDirSize($cacheLogPath);
		$cacheLogSize 		=	automaticSize($cacheLogSize);

		
		$this->assign('cacheTplCount',$cacheTplCount);
		$this->assign('cacheTplSize',$cacheTplSize);
		$this->assign('cacheDataCount',$cacheDataCount);
		$this->assign('cacheDataSize',$cacheDataSize);
		$this->assign('cacheLogCount',$cacheLogCount);
		$this->assign('cacheLogSize',$cacheLogSize);

		return view(getNowActionTpl());
	}

	/**
	 *	清除缓存 (操作)
	 *	@param type   ->	清除内容  all为所有
	*/
	public function cache_clear($type='all'){
		$runTimePath 	=	Config::get('xld.cache_path');
		$cacheTplPath 	=	$runTimePath.'temp'.DS;
		$cacheDataPath 	=	$runTimePath.'cache'.DS;
		$cacheLogPath 	=	$runTimePath.'log'.DS;

		switch ($type) {
			// 清除所有缓存
			case 'all':
				delDir($cacheTplPath);	
				delDir($cacheDataPath);
				delDir($cacheLogPath);
			break;

			// 清除模板缓存
			case 'tpl':
				delDir($cacheTplPath);
			break;

			// 清除数据缓存
			case 'data':
				delDir($cacheDataPath);
			break;

			// 清除日志缓存
			case 'log':
				delDir($cacheLogPath);
			break;
			
			default:
				// 无任何操作
				return $this->error($this->code['noneOper']);
			break;
		}

		return $this->success($this->code['operSuccess']);
	}

	/**
	 *	系统设置(视图)
	*/
	public function setting_view(){
		return view(getNowActionTpl());
	}
}