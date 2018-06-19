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