/*
	*	提示框
	* 	code 		->	状态码 只限0 / 1
	*	msg  		->  提示的信息
	*	refresh 	->	是否刷新  true/false
	*	delay 		->	延时刷新 只限refresh  =  true 时生效  默认1000=1秒
*/
function alertMsg(code,msg,refresh = false,delay=1000){
	if(code){
		layer.msg(msg, {icon: 6});
	}else{
		layer.msg(msg, {icon:5});
	}

	if(refresh){
		setTimeout(function(){
			window.location.href  = window.location.href;
		},delay)
	}
}


/*
	*	显示loading框
	*	style 		->	风格 有 ：0,1,2
*/
function showLoading(style=0){
	if(!style){
		layer.load();
	}else{
		layer.load(style);
	}
}

/*
	*	隐藏loading框
*/
function hideLoading(){
	layer.closeAll('loading');
}


/*
	*	弹出全屏的网页
	*	href 		->	链接地址 必须http[s]://
*/
function popFullPage(href){
	if(href.length < 7){
		alertMsg(0,'网址不规范',0);
	}

	var index = layer.open({
	  type: 2,
	  content: href,
	  area: ['100%', '100%'],
	  maxmin: true
	});
	layer.full(index);
}