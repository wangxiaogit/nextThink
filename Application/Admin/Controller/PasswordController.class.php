<?php
/**
 * Password(用户密码)
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class PasswordController extends AdminController 
{
    protected $userModel;
    
    public function _initialize() 
    {
        $this->userModel = M('User');
        parent::_initialize();
    }
    
    /**
     * 重置
     */
    public function reset() 
    {
        
    }
    
    /**
     * 提交重置
     */
    public function do_reset() 
    {
        
    }
}
