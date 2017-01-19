<?php

/**
 * Addons(插件管理)
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class AddonsController extends AdminController
{
    protected $addonsModel;
    
    public function _initialize() 
    {
        parent::_initialize();
        $this->addonsModel = D('Common/Addons');
    }
    
    /**
     * 插件列表
     */
    public function index() 
    {
        $list       =   $this->addonsModel->getList();
            
        $addons     =   $this->array_lists($list);
        
        $this->assign('meta_title', L('ADMIN_ADDONS_MANAGE'));
        $this->assign('addons', $addons);  
        $this->display();
    }
    
}
