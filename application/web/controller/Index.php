<?php  
namespace app\web\controller;


class Index {
	public function index(){
		$tpl = domainSelectTplPath();
		echo $tpl;
	}
}
