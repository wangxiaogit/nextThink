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
        $this->display();
    }
    
    /**
     * 提交登录
     */
    public function do_login()
    {
        if (IS_POST) {
            
            $rules = array(
                //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
                array('username', 'require', '用户名\手机号码不能为空！', 1),
                array('password', 'require', '密码不能为空！', 1),
                array('verify', 'require', '验证码不能为空！', 1)
            );
            if ($this->userModel->validate($rules)->create()===false) {
                $this->error($this->userModel->getError());
            }
            
            $verify = trim(I('post.verify')); 
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }
            
            $adminInfo = $this->userModel
                         ->field('id, user_login, user_pass, user_nicename, user_email, user_type, mobile')
                         ->where(array('status'=>1, 'user_type'=>array('neq', 2), 'user_login|user_email'=> I('post.username', '', 'trim')))
                         ->find();
            if (!$adminInfo) {
                $this->error('帐号不存在或被禁用！');
            } 
            
            $password = I('post.password', '', 'trim');
            if (sp_password($password) === $adminInfo['user_pass']) {
                session('ADMININFO', array_change_key_case($adminInfo, CASE_UPPER));
                
                $this->userModel->where(array('id'=>$adminInfo['id']))->save(array('last_login_ip'=> get_client_ip(), 'last_login_time'=> date('Y-m-d h:i:s')));
                
                $this->success('登陆成功！',U('Index/index'));
            } else {
                $this->error('密码错误！');
            }  
        }    
    }        
    
    /**
     * 退出
     */
    public function out()
    {
        session('ADMIN_ID',null); 
    	redirect(U('Login/index'));
    }
    
    /**
     * 验证码
     */
    public function verify() 
    {
        $config = array(
            'imageH'   => 42, //高度
            'fontSize' => 21  //字体大小
        );
        
        $verify = new \Think\Verify($config);
        $verify->entry(1);
    }
}
