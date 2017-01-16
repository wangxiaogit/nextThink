<?php

/**
 * Main(欢迎页)
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class MainController extends AdminController{
    
    function _initialize() {
        parent::_initialize();
    }
    
    public function index()
    {
        $this->assign("meta_title", L('WELCOME'));
        $this->display();
    }        
}
