<?php
use think\Route;

// 查询站点主URL  并缓存
$url 		=	Db('Config')->where('id',1)->cache(3600)->find();
if(!$url){
	echo "站点配置读取失败！";die;
}

$weburl 		=	$url['web_url'];
if(strpos($weburl,',')){
	$weburl 	=	explode(',',$weburl);
}else{
	$weburl 	=	$weburl;
}

if(is_array($weburl)){
	foreach ($weburl as $key => $value) {
		Route::domain($value,'web');
	}
}else{
	Route::domain($weburl,'web');  
}


// 绑定后台域名到admin模型
Route::domain($url['admin_domain'],'admin');
