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


/**
 *	获取系统设置
 *	get_config
*/
function getConfig(){
	$find 	=	Model('Config')->where('id',1)->find();
	if($find){
		return $find;
	}else{
		return false;
	}
}

/**
 *  没有http https的域名
 *	@param  domain   传入的域名
*/
function noHttpDomain($domain=null){
	// 如果有域名  判断有无http  无域名 获取当前域名
	if($domain == null){
		$domain 	=	request()->domain();
	}

	if(preg_match("/http:\/\/s{0,1}/i",$domain)){
		$domain  	=	preg_replace("/http:\/\/s{0,1}/i",'',$domain);
	}

	return $domain;
}


/**
 *	没有域名  没有最前面和后面斜杠/的网址
 *	@param url 	传入的网址
*/
function noDomainUrl($url=null){
	if($url == null){
		$url 		=	request()->url();
	}

	if(preg_match("/http:\/\/s{0,1}/i",$url)){
		$url 		=	noHttpDomain($url);
	}

	// 检测最前斜杠
	if(strpos($url , '/') == 0){
		$url 		=	substr($url,1);
	}

	// 检测最后面斜杠
	if(strripos($url,'/')){
		$url 		=	substr($url,0,strlen($url)-1);
	}

	return $url;
}

/**
 *	根据域名来判断使用的模板文件夹
 *	@param domain
*/
function domainSelectTplPath($domain=null){
	$selectTplPath 	=	Config::get('xld.web_select_tpl');
	if($domain == null){
		$domain 	=	request()->domain();
	}
	$domain 		=	noHttpDomain($domain);

	$find  			=	Model('WebDomain')->where('domain',$domain)->find();
	if(!$find){
		$config 	=	getConfig();
		if(!$config){
			echo '读取Config配置失败[webFun]';die;
		}

		$url 		=	$config['web_url'];

		if(!preg_match("/{$domain}/",$url)){
			echo '未绑定的域名！请先绑定域名后再访问！';die;
		}else{
			$tpl 	=	Config::get('xld.index_tpl');
		}
	}else{
		$tpl 		=	Config::get('xld.web_select_tpl').$find['tpl_name'];
	}

	return $tpl;
}

/**
 *	用户访问时  判断是否为蜘蛛 如果为蜘蛛 
 * 	判断蜘蛛并添加蜘蛛记录 否则添加用户访问记录
*/
function getEnterData(){
	$header 		=	request()->header();
	$domain 		=	$header['host'];
	$agent 			=	strtolower($header['user-agent']);
	$url 			=	noDomainUrl(request()->url());

	if(strpos($agent,'spider') || strpos($agent,'bot')){
		// 为蜘蛛
		if(strpos($agent,'googlebot')){
			$bot 	=	'Google';
		}else if(strpos($agent,'360spider') || strpos($agent,'haosouspider')){
			$bot  	=	'360搜索';
		}else if(strpos($agent,'sogou')){
			$bot 	=	'搜索搜索';
		}else if(strpos($agent,'bingbot')){
			$bot 	=	'必应搜索';
		}else if(strpos($agent,'yisouspider')){
			$bot 	=	'神马搜索';
		}else if(strpos($agent,'youdaobot')){
			$bot 	=	'有道搜索';
		}else{
			$bot 	=	'其他蜘蛛';
		}

		// $data['web'] 	=	
	}else{
		// 为真实用户
		echo 1;
	}

	return $header;
}
