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

    // 定义系统的路径
    'system_tpl_path'   =>  ROOT_PATH.'sysview'.DS,

    // 定义static 的绝对路径
    'static_path'		=>	ROOT_PATH.'public'.DS.'static'.DS,
    // 定义密码加密字符串
    'password_str' 		=>	'5Ko!MKud~+',
    // 加载code
    'code_path' 		=>	ROOT_PATH.'application'.DS.'CodeText.php',
];
