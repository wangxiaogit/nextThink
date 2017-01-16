<?php

/**
 * Index（网站首页）
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class IndexController extends AdminController {
    
    public function _initialize() 
    {
        empty($_GET['upw'])?"":session("SP_UPW",$_GET['upw']);//设置后台登录加密码
        parent::_initialize();
        $this->initMenu();
    }
    
    /**
     * 网站首页
     */
    public function index()
    {
        $admin_menu = D('Common/Menu')->admin_menu();
        
        $this->assign("admin_menu", $admin_menu);
        $this->display();      
    }
    
}