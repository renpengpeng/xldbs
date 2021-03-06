<?php
/**
 *	@author  任鹏鹏
 *	@version 1.0
*/
namespace app\admin\controller;

use app\common\controller\Base;
use think\Config;
use think\Session;
use think\helper\Time;

class Index extends Base {
	private $setting;
	private $cacheTime;
	public function _initialize(){
		adminLoad();
		$this->setting 		=	getConfig();
		$this->cacheTime 	=	$this->setting['cache_time'];	
	}
	public function index(){
		//  -----------
			# 总访问量PV
			$totalPV 	=	Model('EnterData')->cache($this->cacheTime)->count();

			# 站点总数量数据
			$totalWEB 	=	Model('WebInfo')->cache($this->cacheTime)->count();

			# 统计样式风格
			$totalStyle =	Model('TplInfo')->cache($this->cacheTime)->count();

			# 统计代理数量
			$totalAgent =	Model('User')->where('is_agent','1')->cache($this->cacheTime)->count();

			$this->assign('totalPV',$totalPV);
			$this->assign('totalWEB',$totalWEB);
			$this->assign('totalStyle',$totalStyle);
			$this->assign('totalAgent',$totalAgent);


		// 	-----------
			#    最近6天统计图
		    #->  新增站点
		    #->  新增代理
		    #->  新增模板
		    #->  新增文章
		    #->  PV访问量
		    #->  蜘蛛访问量  

		    // 获取过去其他的天数
		   	$lastDay 		=	getLastDay();

		   	// 获取过去7天的数据等
		   	$lastDate 		=	'';
		   	$newWEB 		=	'';
		   	$newAgent 		=	'';
		   	$newTpl 		=	'';
		   	$newArt 	    =	'';
		   	$pvnum 			=	'';
		   	$spidernum 		=	'';

		   	for ($i=0; $i < count($lastDay) ; $i++) { 
		   		$lastDate    .=	",'".date('m月d日',$lastDay[$i][0])."'";
		   		
		   		// 获取新增站点
		   		$newWEBnum 	  =	Model('WebInfo')->where('addtime','between',$lastDay[$i])->cache($this->cacheTime)->count();
		   		$newWEB 	 .=	",".$newWEBnum;

		   		// 获取新增代理
		   		$newAgentnum  =	Model('User')->where('is_agent',1)->where('addtime','between',$lastDay[$i])->cache($this->cacheTime)->count();
		   		$newAgent 	 .=	','.$newAgentnum;

		   		// 获取新增模板
		   		$newTplnum 	  =	Model('TplInfo')->where('addtime','between',$lastDay[$i])->cache($this->cacheTime)->count();
		   		$newTpl 	 .= ','.$newTplnum;

		   		// 新增文章
		   		$newArtnum    =	Model('Article')->where('addtime','between',$lastDay[$i])->cache($this->cacheTime)->count();
		   		$newArt 	  =	','.$newArtnum;

		   		// PV量
		   		$pvnums       = Model('EnterData')->where('addtime','between',$lastDay[$i])->cache($this->cacheTime)->count();
		   		$pvnum 		  =	','.$pvnums;

		   		// 蜘蛛访问量
		   		$spiders 	  =	Model('SpiderData')->where('addtime','between',$lastDay[$i])->cache($this->cacheTime)->count();
		   		$spidernum 	  = ','.$spiders;

		   	}

		   	$lastDate 		=	substr($lastDate,1);
		   	$newWEB 		=	substr($newWEB,1);
		   	$newAgent 		=	substr($newAgent,1);
		   	$newTpl 		=	substr($newTpl,1);
		   	$newArt 		=	substr($newArt,1);
		   	$pvnum 			=	substr($pvnum,1);
		   	$spidernum 		=	substr($spidernum,1);


			$this->assign('lastDate',$lastDate);
			$this->assign('newWEB',$newWEB);
			$this->assign('newAgent',$newAgent);
			$this->assign('newTpl',$newTpl);
			$this->assign('newArt',$newArt);
			$this->assign('pvnum',$pvnum);
			$this->assign('spidernum',$spidernum);
		// ------------

			#	获取所有城市

			$citys 			=	Model('Area')->getSpaceCity();
			$userM 			=	Model('User');


			$cityName 		=	[];
			$cityseries		=	[];
			foreach ($citys as $key => $value) {
				array_push($cityName,$citys[$key]['areaname']);

				// 获取各个城市的代理数量
				$findNUM 	=	$userM->where(['is_agent'=>1,'agent_province'=>$citys[$key]['areaid']])->count();
				$re 		=	json(['name'=>$citys[$key]['areaname'],'value'=>$findNUM]);
				array_push($cityseries,$re);

			}

			$this->assign('cityName',$cityName);
			$this->assign('cityseries',$cityseries);

		return view(getNowActionTpl());
	}
}