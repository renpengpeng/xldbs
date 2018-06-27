<?php
/*
	*	数据表设计
	*	数据表前缀：bs_
*/

#	bs_config 						#站点核心设置  &站点开关 	&创建站点开关	& 上传目录名	&上传最大大小
id 	web_on 		new_web_on  	web_url 		admin_domain    tpl_domain  	  	upload_path 	upload_size 	logo_path		cache_time		bind_domain_maxnum

#	bs_web_info 					#站点的基本信息  userid 	->	管理者ID   status ->	状态  0暂停  1正常     web_type 与 system_product_type 对应  
id 	web_type    title 		keywords 		description 	logo_file 		icp 	   userid 	  	status  	stop_reason		adddate 	addtime	   begintime  opentime  endtime  

# 	bs_web_domain 					#域名绑定储存  type 域名类型 可选 give ->  自带赠送  ordi  -> 	新增绑定  mobile ->	手机
id 	type 	web_id  	domain   		tpl_id 		module 	 		adddate   		  addtime

#	bs_index_tpl 					#站点设置   &首页模板  
id 	web_id 		index_tpl 		last_modify 	last_modify_date	version

#	bs_tpl_explode 					#模板分割设置 分隔到哪里：type->  header  /  banner /  footer / cust
id 	type 		reg 			adddate 		addtime

#	bs_tpl_modules_var      		#公共模块变量和用户自定义调用变量 type -> header  /  banner / footer / cust
id  web_id  	user_id 		type 			html  			adddate  		addtime  	last_modify

#	bs_tpl_info 					#所有主题的储存  tpl_type 与 system_product_type 对应
id 	tpl_port 	tpl_type  	tpl_cate 		tpl_name 		tpl_filename	color 			author 		description 	 adddate 		addtime

#	bs_tpl_cate 					#主题行业分类
id 	catename 	adddate 		addtime

#	bs_tpl_show_port				#主题展示类型
id 	alias 		portname		adddate			addtime

#	bs_art_cate						#文章分类
id 	web_id 		title 			keywords 		description 	titlepic 		alias 		pid 		level 		list_num 	 	adddate 	 	addtime 

#	bs_article 						#文章
id 	web_id 		title 			keywords 		description 	titlepic 		alias 		cate		tags 		content 		userid 			version			view		    adddate 	addtime	

#	bs_tag 							#标签
id 	web_id 		tag_name 		adddate 		addtime			

#	bs_page 						#页面
id 	web_id 		title 			keywords 		description 	titlepic 		alias 		content 	userid 		version 		view 			adddate 		addtime

#	bs_senior_page 					#高级页面配置  &全部自定义页面html
id 	web_id 		alias 			userid 			version 		view 			html 		adddate 	addtime 

#	bs_user 					# 管理员 与 站点后台用户表设计  如果is_agent为false  则不是代理  如果不是管理员也不是代理 则pagent生效
id 	web_id 		username 		bbsname 		password 		password_b 		sex 		auth 		is_admin 		is_agent   agent_level		createid	 agent_province  	agent_city	 agent_county   	headpic 			address 		status 		unblock_time	phone 	email  login_num 	 

#	bs_auth_admin 					#权限组 对应后台的controller  折率百分比
id 	name 		auth  			discount 		

#	bs_auth_admin_controller		#后台控制器
id 	name 		controller 	 

#	bs_web_library 					#内容上传 媒体库数据储存
id 	web_id 		userid  		file_name 		file_size 		file_type 		adddate 	addtime   

#	bs_agent_grade					#代理等级
id 	name 		discount 	

#	bs_enter_data 					#用户访问记录
id 	web_id 		domain 			url 			agent 			ip 				adddate  	addtime 			

#	bs_spider_data					#蜘蛛抓取记录
id 	web_id 		domain 			url 			agent 			ip 				spider 		adddate 	addtime 

#	bs_system_product				#系统的产品		
// id 	title 		keywords 		description 	content 		money 			unit		

#	bs_sysmtem_product_type 		#系统产品类型 && 站点类型   ->基础  www -> 企业站点  包括 (电脑/手机)
id 	alias 		name 			addtime			

#	bs_area 						#城市表 
areaid 			areaname 		parentid 		arrparentid 	 child 			arrchildid 	 listorder

#	bs_keywords_rank 				#
id 	web_id 		keywords 		baidu_rank 		haosou_rank 	sougou_rank 	google_rank	  last_update_time		addtime 	