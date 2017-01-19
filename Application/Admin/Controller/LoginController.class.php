<?php
/**
 * Login(后台登录)
 */
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller 
{
   protected $userModel;
   
   public function _initialize() 
   {
       $this->userModel = M('User');
   }        
   
    /**
     * 登录
     */
    public function index() 
    {
        
    }
    
    /**
     * 退出
     */
    public function out()
    {
        
    }
    
    /**
     * 验证码
     */
    public function verify() 
    {
        
    }
}
