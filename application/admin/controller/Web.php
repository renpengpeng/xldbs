<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Session;
use think\Config;

class Web extends Base {
	private $setting;

	public function _initialize(){
		adminLoad();
		$this->setting 	=	getConfig();
	}

	/**
 	 *	首页 重新定义到列表页面
	*/
	public function index(){
		$this->redirect(url('list'));
	}

	/**
	 *	添加新站点(视图) 
	*/
	public function newWeb(){
		return view(getAdminNowActionTpl());
	}

	/**
	 *	添加新站点(数据处理) 安全起见 只接受POST
	 *	
	*/
	public function newWeb_out(){

	}

	/**
	 *	列表页面
	*/
	public function list(){
		$page 	=	input('?page') ? intval(input('page')) : false;
		$limit 	=	input('?limit') ? intval(input('limit')) : $this->setting['admin_limit'];

		$result =	Model('WebInfo')->order('id desc')->page($page)->limit($limit)->select();
		$all 	=	Model('WebInfo')->count();

		if($result){
			
			foreach ($result as $key => $value) {
				// 获取域名
				$result[$key]['domain'] 	=	Model('webDomain')::getWebDomain($result[$key]['id']);

				// 获取管理员
				$getuserInfo 				=	Model('User')->get($result[$key]['userid']);
				if(!$getuserInfo){
					$result[$key]['adminusername'] 	=	'获取失败';
					$result[$key]['adminpassword'] 	=	'获取失败';
				}else{
					$result[$key]['adminusername'] 	=	$getuserInfo['username'];
					$result[$key]['adminpassword']	=	$getuserInfo['password_b'];
				}

				// 转化status为数据
				$status 					=	$result[$key]['status'];
				if($status){
					$result[$key]['status_b'] 		=	'正常';
				}else{
					$result[$key]['status_b']		=	'已暂停，暂停原因：'.$result[$key]['stop_reason'];
				}

				// 开始时间
				$result[$key]['begindate']			=	date('Y-m-d H:i:s',$result[$key]['begintime']);
				// 结束时间
				$result[$key]['enddate']			=	date('Y-m-d H:i:s',$result[$key]['endtime']);
 			}

		}

		$this->assign('listData',$result);

		return view(getAdminNowActionTpl());
	}

	/**
	 *	
	*/
}