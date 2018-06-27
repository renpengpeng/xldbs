<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Session;
use think\Config;
use think\Request;
use think\File;


class Content extends Base {
	private $setting;
    private $code;
    private $xld;
    private $articleTable;
    private $articleModel;
    private $pageModel;
    private $pageTable;
    private $seniorPageModel;
    private $seniorPageTable;
    private $webInfoModel;
    private $newPicSuccess;

	public function _initialize(){
		adminLoad();
		$this->setting 	           =   getConfig();
        $this->code                =   loadCode();

        $this->articleModel        =   Model('Article');
        $this->articleTable        =   $this->articleModel->getTableFields();

        $this->pageModel           =   Model('Page');
        $this->pageTable           =   $this->pageModel->getTableFields();

        $this->seniorPageModel     =   Model('SeniorPage');
        $this->seniorPageTable     =   $this->seniorPageModel->getTableFields();

        $this->webInfoModel        =    Model('webInfo');
	}

	/**
 	 *	文章管理 重新定义到列表页面
	*/
	public function index(){
		$this->redirect(url('list'));
	}
	/**
	 *	文章 / 列表页面
	*/
    public function list(){
        $id            =    input("get.web_id");
    	$result        =    $this->articleModel->select();
        $webResult     =    $this->webInfoModel->where('id',$id)->find();
        $this->assign("webResult",$webResult);
    	$this->assign("list",$result);
    	return view(getNowActionTpl());
    }
    
    /**
     * 文章 / 添加页面显示
     */
    public function article_add(){
        $web_result     =    Model("webInfo")->select();
        $cate_result    =    Model("artCate")->select();
        $id             =    input('?id') ? intval(input('id')) : false;
        if(!$id){
            foreach ($this->articleTable as $key => $value) {
                $message[$value]    =   '';
            }
        }else{
            $message    =   $this->articleModel->get($id);
        }

        $this->assign('message',$message);
        $this->assign('catelist',$cate_result);
        $this->assign("weblist",$web_result);
        return view(getNowActionTpl());
    }
    /**
     * 文章 / 编辑添加文章处理方法
     */
    public function article_add_oper(){
        $data                   =   input('post.');

        $file                   =   request()->file('titlepic');
        if($file){
        $info                   =   $file->move(Config::get('xld.uploads_path'));
        if($info){
            $a                  =   $info->getSaveName();  
            $imgp               =   str_replace("\\","/",$a);  
            $imgpath            =   $imgp;  
            $data['titlepic']   =   $imgpath;  
        }else{
            echo $file->getError();
        }
                 }
    
        $data           =   safeArray($data);
        $id             =   isset($data['id']) ? intval($data['id']) : false;
        if(!$id){
            $result     =   $this->articleModel->insert($data);    
        }else{
            $result     =   $this->articleModel->where('id',$id)->update($data);
        }
        if($result){
            return $this->success($this->code['newArticleSuccess']);
        }else{
            return $this->error($this->code['editArticleError']);
        }
    }
    /**
     * 文章 / 删除文章处理方法
     */
    public function article_del(){
        $id             =   input("get.id");
        $result         =   $this->articleModel->where('id',$id)->delete();
        if($result){
            return $this->success($this->code['delArticleSuccess']);
        }else{
            return $this->error($this->code['delArticleError']);
        }
    }
    
    /**
     *  页面 / 列表页面
    */
    public function page_list(){
        $result             =    $this->pageModel->select();
        $this->assign("list",$result);
        return view(getNowActionTpl());
    }
    
    /**
     * 页面 / 添加页面显示
     */
    public function page_add(){
        $web_result     =    Model("webInfo")->select();
        $cate_result    =    Model("artCate")->select();
        $id             =    input('?id') ? intval(input('id')) : false;
        if(!$id){
            foreach ($this->pageTable as $key => $value) {
                $message[$value]    =   '';
            }
        }else{
            $message    =   $this->pageModel->get($id);
        }

        $this->assign('message',$message);
        $this->assign('catelist',$cate_result);
        $this->assign("weblist",$web_result);
        return view(getNowActionTpl());
    }
    /**
     * 页面 / 编辑添加页面处理方法
     */
    public function page_add_oper(){
        $data                   =   input('post.');

        $file                   =   request()->file('titlepic');
        if($file){
        $info                   =   $file->move(Config::get('xld.uploads_path'));
        if($info){
            $a                  =   $info->getSaveName();  
            $imgp               =   str_replace("\\","/",$a);  
            $imgpath            =   $imgp;  
            $data['titlepic']   =   $imgpath;  
        }else{
            echo $file->getError();
        }
                 }

        $data                   =   safeArray($data);
        $id                     =   isset($data['id']) ? intval($data['id']) : false;
        if(!$id){
            $result             =   $this->pageModel->insert($data);    
        }else{
            $result             =   $this->pageModel->where('id',$id)->update($data);
        }
        
        if($result){
            return $this->success($this->code['newPageSuccess']);
        }else{
            return $this->error($this->code['newPageError']);
        }
    }
    /**
     * 页面 / 删除页面处理方法
     */
    public function page_del(){
        $id             =   input("get.id");
        $result         =   $this->pageModel->where('id',$id)->delete();
        if($result){
            return $this->success($this->code['delPageSuccess']);
        }else{
            return $this->error($this->code['delPageError']);
        }
    }



    /**
     *  自定义页面 / 列表自定义页面
    */
    public function seniorPage_list(){
        $result    =    $this->seniorPageModel->select();
        $this->assign("list",$result);
        return view(getNowActionTpl());
    }
    
    /**
     * 自定义页面 / 添加自定义页面显示
     */
    public function seniorPage_add(){
        $web_result     =    Model("webInfo")->select();
        $cate_result    =    Model("artCate")->select();
        $id             =    input('?id') ? intval(input('id')) : false;
        if(!$id){
            foreach ($this->seniorPageTable as $key => $value) {
                $message[$value]    =   '';
            }
        }else{
            $message    =   $this->seniorPageModel->get($id);
        }

        $this->assign('message',$message);
        $this->assign('catelist',$cate_result);
        $this->assign("weblist",$web_result);
        return view(getNowActionTpl());
    }
    /**
     * 自定义页面 / 编辑添加自定义处理方法
     */
    public function seniorPage_add_oper(){
       $data         =      input("post.");
       $data         =      safeArray($data);
       $id           =      isset($data['id']) ? intval($data['id']) : false;
       if($id){
            $result=$this->seniorPageModel->where('id',$id)->update($data);
       }else{
            $result=$this->seniorPageModel->insert($data);
       }
       if(!$result){
            return $this->success($this->code['newSeniorPageSuccess']);
       }else{
            return $this->error($this->code['newSeniorPageError']);
       }
        
    }
    /**
     * 自定义页面 / 删除自定义处理方法
     */
    public function seniorPage_del(){
        $id             =   input("get.id");
        $result         =   $this->seniorPageModel->where('id',$id)->delete();
        if($result){
            return $this->success($this->code['delSeniorPageSuccess']);
        }else{
            return $this->error($this->code['delSeniorPageError']);
        }
    }

}