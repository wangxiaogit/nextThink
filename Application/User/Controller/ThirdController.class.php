<?php

/**
 * Third(第三方用户登录)
 */
namespace User\Controller;
use Common\Controller\AdminController;

class ThirdController extends AdminController
{
    public $thirdUserModel;
    
    public function _initialize() 
    {
        parent::_initialize();
        $this->thirdUserModel = M("ThirdUser");
    }
}
