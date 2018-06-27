<?php
use think\Config;
use think\Session;

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
function getNowActionTpl($enter='admin',$file=false){
	$module 			=	strtolower(request()->module());
	$controller 		=	strtolower(request()->controller());
	$action 			=	strtolower(request()->action());
	$ext 				=	Config::get('template.view_suffix');

	$syspath 			=	Config::get('xld.system_tpl_path');		

	if($file){
		$path 			=	$syspath.$module.DS.$controller.DS.$file.$ext;
	}else{
		$path 			=	$syspath.$module.DS.$controller.DS.$action.'.'.$ext;
	}
	
	return $path;
}

/**
 *	获取数据库的最后一个ID
 *	@param table   resource类型 传入model
 *	@param key 	   传入表的主键
*/
function getTableLastID($table,$key){
	$find 	=	$table->order("{$key} desc")->limit(1)->find();

	$id 	=	$find[$key];

	return $id;
}

/**
 *	随机字符串
 *	@param type 	mixing 	->	字母与数字的混合  num 	-> 	纯数字 		str->纯字符串
 *	@param len 		需要的长度
 *	@param header 	前缀
 *	@param end 		结束符
 *	@param separ 	分隔符
*/
function randStr($type='mixing',$len=10,$header='',$end='',$separ=''){
	$str 	=	range('a','z');
	$num 	=	range(0,9);
	$hun 	=	array_merge($str,$num);

	// 统计长度
	$strlen =	count($str);
	$numlen =	count($num);
	$hunlen =	count($hun);

	// 打乱
	shuffle($str);
	shuffle($num);
	shuffle($hun);

	$result =	$header.$separ;

	switch ($type) {
		case 'mixing':
			for ($i=0; $i < $len; $i++) { 
				$result		.=	 $hun[rand(0,$hunlen-1)];
			}
		break;
		
		case 'num':
			for ($i=0; $i < $len; $i++) { 
				$result		.=	 $num[rand(0,$numlen-1)];
			}
		break;

		case 'str':
			for ($i=0; $i < $len; $i++) { 
				$result		.=	 $str[rand(0,$strlen-1)];
			}
		break;

		default:
			for ($i=0; $i < $len; $i++) { 
				$result		.=	 $hun[rand(0,$hunlen-1)];
			}
		break;
	}

	$result 	.=	$end;
	return $result;
}

/**
 *	翻译服务 语言互转 利用：有道云api
 *	@param  q 				传入要翻译的字符	
 *	@param 	fromLanguage 	传入的字符语言		auto 	->  自动
 *	@param 	toLanguage 		要翻译成什么语言 	auto 	->  自动
 *	@param 	size 			是否转换大小写 		big 	->	全部大写	small 	->	全部小写 	auto ->	自动	first ->单词首字母大写
 *	@param 	space 			空格是否被代替 		false 	->	不代替 	如果不为false 则使用该字符串替换
 *	@link 	http://openapi.youdao.com/api
 *	@link 	语言列表参考：https://ai.youdao.com/docs/doc-trans-api.s#p05
 *	@return string 	
*/
function translate($q='你好 世界！',$fromLanguage='auto',$toLanguage='auto',$size='auto',$space=false){
	$appid 		=	Config::get('xld.youdao_appid');
	$appkey 	=	Config::get('xld.youdao_appkey');
	// 生成随机数
	$salt 		=	randStr('mixing');
	// 开始签名
	$sign 		=	md5($appid.$q.$salt.$appkey);

	$openUrl 	=	Config::get('xld.youdao_url')."?q=".urlencode($q)."&form={$fromLanguage}&to={$toLanguage}&appKey={$appid}&salt={$salt}&sign={$sign}";

	$result 	=	http_get($openUrl);

	if(!isset($result['errorCode'])){
		return false;
	}

	if($result['errorCode'] != 0){
		return false;
	}

	$str 			=	$result['translation'][0];

	switch ($size) {
		case 'auto':
			continue;
		break;
		
		case 'big':
			$str 	=	strtoupper($str);
		break;

		case 'small':
			$str 	=	strtolower($str);
		break;

		case 'first':
			$str 	=	ucwords($str);
		break;	
		default:
			continue;
		break;
	}

	if($space){
		$str 		=	preg_replace("/\s+/", $space, $str);
	}

	return $str;
}

/*
    *   普通get访问
*/
function http_get($url){
    $curl = curl_init();  
    curl_setopt($curl, CURLOPT_URL, $url);  
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
    $res=json_decode(curl_exec($curl),true);  
    curl_close($curl);  
    return $res;  
}
/*
    *   https get访问
*/
function https_get($url){
    $curl = curl_init();  
    curl_setopt($curl, CURLOPT_URL, $url);  
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);// https请求不验证证书和hosts  
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
    $res=json_decode(curl_exec($curl),true);  
    curl_close($curl);  
    return $res;  
}
/*
    *   http post访问
*/
function http_post($url,$post_data){   
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    // post数据  
    curl_setopt($ch, CURLOPT_POST, 1);  
    // post的变量  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  
    $output=json_decode(curl_exec($ch),true);  
    curl_close($ch);  
    return $data;  
}
/*
    https post访问
*/
function https_post($url,$post_data) {
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    // post数据  
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  
    // post的变量  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  
    $output=json_decode(curl_exec($ch),true);  
    curl_close($ch);  
    return $output;  
}
/*
    *   携带证书的访问
*/
function curl_post_ssl($url, $vars, $second=30,$aHeader=array()){
    $certPath   =   getCertPATH();
    $ch = curl_init();
    //超时时间
    curl_setopt($ch,CURLOPT_TIMEOUT,$second);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    //这里设置代理，如果有的话
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    //cert 与 key 分别属于两个.pem文件
    //请确保您的libcurl版本是否支持双向认证，版本高于7.20.1
    curl_setopt($ch,CURLOPT_SSLCERT,$certPath.DIRECTORY_SEPARATOR.'apiclient_cert.pem');
    curl_setopt($ch,CURLOPT_SSLKEY,$certPath.DIRECTORY_SEPARATOR.'apiclient_key.pem');
    curl_setopt($ch,CURLOPT_CAINFO,$certPath.DIRECTORY_SEPARATOR.'rootca.pem');
    if( count($aHeader) >= 1 ){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    }
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
    $data = curl_exec($ch);
    if($data){
        curl_close($ch);
        return $data;
    }
    else {
        $error = curl_errno($ch);
        echo "call faild, errorCode:$error\n";
        curl_close($ch);
        return false;
    }
}