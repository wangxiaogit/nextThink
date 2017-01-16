<?php

/**
 * Member(会员管理)
 */
namespace User\Controller;
use Common\Controller\AdminController;

class MemberController extends AdminController
{
    protected $userModel;
    
    public function _initialize() 
    {
        parent::_initialize();
        $this->userModel = D('Common/User');
    }
    
    
}
