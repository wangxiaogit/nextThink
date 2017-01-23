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
        $this->assign('meta_title', L('PASSWORD_RESET'));
        $this->display();
    }
    
    /**
     * 提交重置
     */
    public function do_reset() 
    {
        $rules = array(
            //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
            array('old_password', 'require', '原密码不能为空！', 1 ),
            array('new_password','require','新密码不能为空！',1),
            array('confirm_password','require','确认密码不能为空！',1),
            array('verify','require','验证码不能为空！',1),
            
            array('verify','check_verify','验证码错误！', 0, 'function'),
            array('old_password', session('ADMININFO.PASSWORD'), '原密码错误！',0,'equal'),
            array('comfirm_password','new_password','确认密码不正确！',0,'confirm')
        );
        
        if ($this->userModel->validate($rules)->create()===false) {
            $this->error($this->userModel->getError());
        }
               
        if ($this->userModel->where(array('id'=>session('ADMININFO.ID')))->setField("user_pass", sp_password(trim(I('new_password'))))) {
            $this->success(L('EDIT_SUCCESS'), U('Login/out'));
        } else {
            $this->error(L('EDIT_FAILED'));
        }
    }
    
    /**
     * 验证码
     */
    public function verify()
    {
        $config = array(
            'imageH'   => 36,  //高度
            'imageW'   => 120, //宽度 
            'fontSize' => 18,  //字体大小
            'length'   => 4    //验证码位数 
        );
        
        $verify = new \Think\Verify($config);
        $verify->entry(1);
    }        
}
