<?php 

namespace app\common\model;

use think\Model;

class WebDomain extends Model {

	/**
	 *	获取站点域名
	 *	@param  id 		站点ID
	 *	@param  explode 分隔符 默认为英文逗号
	 *	@return string
	*/
	static function getWebDomain($id,$explode=','){
		$where 	=	['web_id'=>$id];
		$find 	=	self::where($where)->count();
		if(!$find){
			return '暂无';
		}

		$result 		=	'';
		if($find == 1){
			$select 	=	self::where($where)->find();
			$result 	=	$select['domain'];
		}else{
			$select 	=self::where($where)->select();
			foreach ($select as $key => $value) {
				$result .=	$explode.$select['domain'];
			}
			$result 	=	substr($result,1);
		}

		return $result;

	}
}
?>