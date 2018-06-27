<?php
namespace app\admin\controller;

use think\Session;
use think\Cookie;
use think\Request;
use app\common\controller\Base;

class Template extends Base {
	private $setting;
	private $tplCateModel;
	private $productTypeModel;
	private $showPortTypeModel;
	private $tplInfoModel;
	private $showPortTypeData;
	private $productTypeData;
	private $cache_time;
	private $code;

	public function _initialize(){
		$this->setting 				=	getConfig();

		$this->tplCateModel 		=	Model('TplCate');
		$this->productTypeModel		=	Model('SystemProductType');
		$this->showPortTypeModel 	=	Model('TplShowPort');
		$this->tplInfoModel 		=	Model('TplInfo');

		$this->productTypeData 		=	$this->productTypeModel->getTableFields();
		$this->productCateData 		=	$this->tplCateModel->getTableFields();
		$this->productPortData 		=	$this->showPortTypeModel->getTableFields();

		$this->cache_time 			=	$this->setting['cache_time'];
		$this->code 				=	loadCode();
	}
	/**
	 *	跳转到模板列表页面
	*/
	public function index(){
		$this->redirect(url('admin/template/list'));
	}

	/**
	 *	模板列表
	*/
	public function list(){
		$page 		=	input('?page') ? intval(input('page')) : 1;
		$port 	 	=	input('?port') ? intval(input('port')) : false;
		$cate 		=	input('?cate') ? intval('cate') : false;
		$sort 		=	input('?sort') ? input('sort') : 'desc';

		$listData 	=	$this->tplInfoModel->cache($this->cache_time);

		if($port){
			$listData .=	"->where('tpl_port',{$port})";
		}

		if($cate){
			$listData .=	"->where('tpl_cate',{$cate})";
		}

		$listData 	=	$listData->order("id {$sort}")->select();
		if($listData){
			foreach ($listData as $key => $value) {
				$id 						=	$listData[$key]['id'];
				$listData[$key]['thumb'] 	=	getTplThumbPath($id);
			}
		}

		$this->assign('listData',$listData);

		return view(getNowActionTpl('admin'));
	}

	/**
	 *	添加模板
	*/
	public function add(){
		return view(getNowActionTpl('admin'));
	}

	/**
	 * 添加模板选择分类
	*/
	public function add_select_cate(){
		$id 			=	input('?id') ? intval(input('id')) : false;
		if(!$id){
			return $this->error($this->code['noID']);
		}

		// 获取所有主题分类
		$tplCateList 	=	$this->tplCateModel->cache($this->cache_time)->order('id asc')->select();

		// 获得产品  类型
		$productType 	=	$this->productTypeModel->cache($this->cache_time)->order('id asc')->select();

		// 获取展示端
		$showPort 		=	$this->showPortTypeModel->cache($this->cache_time)->order('id asc')->select();


		$this->assign('tplCateList',$tplCateList);
		$this->assign('productType',$productType);
		$this->assign('showPort',$showPort);

		return view(getNowActionTpl('admin'));
	}

	/**
	 *	管理模板分类(视图)
	*/
	public function tpl_cate_view(){
		$id 			=	input('?id') ? intval(input('id')) : false;

		// 查询所有的分类  
		$allCate 		=	$this->tplCateModel->cache($this->cache_time)->order('id asc')->select();

		if($id){
			$operType 	=	'edit';
			$message 	=	$this->tplCateModel->cache($this->cache_time)->where('id',$id)->find();
		}else{
			$operType 	=	'new';
			foreach ($this->productCateData as $key => $value) {
				$message[$value] 	=	'';
			}
		}
		
		$this->assign('message',$message);
		$this->assign('operType',$operType);
		$this->assign('allCate',$allCate);
		return view(getNowActionTpl('admin'));
	}

	/**
	 *	管理模板分类 (oper)
	*/
	public function tpl_cate_oper(){
		$type 		=	input('?type') ? input('type') : false;
		$id 		=	input('?id') ? intval(input('id')) : false;
		$catename 	=	input('?catename') ? input('catename') : false;
		$up_data 	=	['catename'=>$catename];
		$new_data 	=	['catename'=>$catename,'adddate'=>date('Y-m-d H:i:s',time()),'addtime'=>time()];

		if(!$type){
			return $this->error($this->code['noData']);
		}

		if($type == 'del' || $type == 'edit'){
			if(!$id){
				return $this->error($this->code['noData']);
			}
		}

		switch ($type) {
			case 'edit':
				if(!$username){
					return $this->error($this->code['cateNameNotNull']);
				}

				$oper 	=	$this->tplCateModel->where('id',$id)->update($data);
			break;

			case 'new':
				$oper 	=	$this->tplCateModel->insert($new_data);
			break;

			case 'del':
				$oper 	=	$this->tplCateModel->where('id',$id)->delete();
			break;
			
			default:
				return false;
			break;
		}

		if(!$type){
			return $this->error($this->code['operError']);
		}else{
			return $this->success($this->code['operSuccess']);
		}
	}

	/**
	 *	获取单个分类信息
	 *	@param id 	分类id
	*/
	public function getonemessage(){
		$id 	=	input('?id') ? intval(input('id')) : false;
		$type 	=	input('?type') ? input('type') : false;
		if(!$type){
			return false;
		}

		switch ($type) {
			case 'cate':
				$m 	=	$this->tplCateModel;
			break;
			
			case 'port':
				$m 	=	$this->showPortTypeModel;
			break;

			default:
				return false;
			break;
		}

		$get 	=	$m->cache($this->cache_time)->where('id',$id)->find();
		if($get){
			return $this->success($get);
		}else{
			return $this->error($this->code['getInfoError']);
		}
	}

	/**
	 *	管理 模板访问端 （视图）
	*/
	public function tpl_port_view(){
		$id 			=	input('?id') ? intval(input('id')) : false;

		// 查询所有的分类  
		$allCate 		=	$this->showPortTypeModel->cache($this->cache_time)->order('id asc')->select();

		if($id){
			$operType 	=	'edit';
			$message 	=	$this->showPortTypeModel->cache($this->cache_time)->where('id',$id)->find();
		}else{
			$operType 	=	'new';
			foreach ($this->productPortData as $key => $value) {
				$message[$value] 	=	'';
			}
		}

		
		$this->assign('message',$message);
		$this->assign('operType',$operType);
		$this->assign('allCate',$allCate);

		return view(getNowActionTpl('admin'));
	}

	/**
	 *	管理 模板访问端（操作）
	*/
	public function tpl_port_oper(){
		$type 		=	input('?type') ? input('type') : false;
		$id 		=	input('?id') ? intval(input('id')) : false;
		$portname 	=	input('?portname') ? input('portname') : false;
		$up_data 	=	['portname'=>$portname];
		$new_data 	=	['portname'=>$portname,'adddate'=>date('Y-m-d H:i:s',time()),'addtime'=>time()];

		if(!$type){
			return $this->error($this->code['noData']);
		}

		if($type == 'del' || $type == 'edit'){
			if(!$id){
				return $this->error($this->code['noData']);
			}
		}

		switch ($type) {
			case 'edit':
				if(!$username){
					return $this->error($this->code['cateNameNotNull']);
				}

				$oper 	=	$this->showPortTypeModel->where('id',$id)->update($data);
			break;

			case 'new':
				$oper 	=	$this->showPortTypeModel->insert($new_data);
			break;

			case 'del':
				$oper 	=	$this->showPortTypeModel->where('id',$id)->delete();
			break;
			
			default:
				return false;
			break;
		}

		if(!$type){
			return $this->error($this->code['operError']);
		}else{
			return $this->success($this->code['operSuccess']);
		}
	}
}