<?php 

namespace app\common\model;

use think\Model;

class Area extends Model {
	protected $pk = 'uid';

	/**
	 *	只获取省份 /  二级城市 /  地县级
	 *	@param type     ->	province(省级)  city(市级)   (county)县区级
	 *	@param partent 	->	如果为null 则获取指定父级的市级 / 县级 省级传入无效果
	*/
	static function getSpaceCity($type='province',$partent=null){

		switch ($type) {
			case 'province':
				$result 		=	self::where('parentid',0)->select();
			break;
			
			case 'city':
				if($partent){
					$result 	=	self::where('parentid',$partent)->select();
				}else{	
					// 先获取所有的省
					$province 	=	self::getSpaceCity('province');
					$ids 		=	'';
					foreach ($province as $key => $value) {
						$ids 	.=	','.$province[$key]['areaid'];
					}
					$ids 		=	substr($ids,1);

					// 开始查所有的城市
					$result 	=	self::where('parentid','in',$ids)->select();
				}
			break;

			case 'county':
				if($partent){
					$result 	=	self::where('parentid')->select();
				}else{
					// 获取所有的市
					$city 		=	self::getSpaceCity('city');

					$ids 		=	'';
					foreach ($city as $key => $value) {
						$ids 	.=	','.$city[$key]['areaid'];
					}
					$ids 		=	substr($ids,1);

					// 查找所有县区
					$result 	=	self::where('parentid','in',$ids)->select();

				}
			break;

			default:
				return false;
			break;
		}

		return $result;
	}
}
?>