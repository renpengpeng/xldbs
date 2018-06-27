<?php

return [
	// 定义系统名称
	'system_name' 		=>	'XLDWEB',
	// 定义系统版本
	'system_version' 	=>	'0.1',
	// 定义公司名字
	'company_name'		=>	'郑州新领地网络科技',



    // 定义站点选择模板后复制到的文件夹的绝对路径
    'web_select_tpl' 	=>	ROOT_PATH.'determined'.DS,


    // 定义统一所有模板上传后的文件夹
    'all_upload_tpl'    =>  ROOT_PATH.'template'.DS,
    // 定义开发的文件夹名字
    'tpl_dev_dirname'   =>  'dev',
    // 定义预览的文件夹名字
    'tpl_look_dirname'  =>  'look',
    // 定义存放版本信息的文件名称
    'tpl_version_filename'  =>  'version.php',
    // 定义主题截图的文件名称
    'tpl_png_filename'  =>  'screenshots.png',
    // 如果没有主题图片的图片名称
    'tpl_nopng_filename'    =>  'error.png',


    // 定义系统的路径
    'system_tpl_path'   =>  ROOT_PATH.'sysview'.DS,

    // 定义static 的绝对路径
    'static_path'		=>	ROOT_PATH.'public'.DS.'static'.DS,

    // 缓存的路径
    'cache_path'        =>  ROOT_PATH.'runtime'.DS,

    //上传的路径
    'uploads_path'      =>  ROOT_PATH . 'public' . DS . 'static/uploads',


    
    // 定义密码加密字符串
    'password_str' 		=>	'5Ko!MKud~+',

    // 有道翻译API地址
    'youdao_url'        =>  'http://openapi.youdao.com/api',
    // 有道翻译APPID
    'youdao_appid'      =>  '45d6b6073f54a3af',
    // 有道翻译APPKEY
    'youdao_appkey'     =>  'ThtQGhRfs4Ltzi6UWAEsj9yhwGqUPgGj',
];
