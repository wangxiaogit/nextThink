<?php
namespace Admin\Controller;
use Common\Controller\AdminController;

class PublicController extends AdminController
{
    public function _initialize() 
    {
        
    }
    
    /**
     * 后台登录
     * 
     */
    public function login() 
    {
        if ($_SESSION['ADMIN_ID']) {
           
           $this->success(L("LOGIN_SUCCESS"), U('Index/index'));
        } else {
           $site_admin_url_password = C('SP_SITE_ADMIN_URL_PASSWORD');
           $upw = session('SP_UPW');
           
           if(!empty($site_admin_url_password) && $upw!=$site_admin_url_password){
                redirect(__ROOT__."/");
            }else{
                session("SP_ADMIN_LOGIN_PAGE_SHOWED_SUCCESS",true);
                $this->display();
            }
        }
    }
    
    public function do_login() 
    {
        $login_page_showed_success = session("SP_ADMIN_LOGIN_PAGE_SHOWED_SUCCESS");
        if(!$login_page_showed_success){
            $this->error('login error!');
        }
        
    	$name = I("post.username");
    	if(empty($name)){
    		$this->error(L('USERNAME_OR_EMAIL_EMPTY'));
    	}
        
    	$pass = I("post.password");
    	if(empty($pass)){
    		$this->error(L('PASSWORD_REQUIRED'));
    	}
    	$verrify = I("post.verify");
    	if(empty($verrify)){
    		$this->error(L('CAPTCHA_REQUIRED'));
    	}
    	//验证码
    	if(!sp_check_verify_code()){
    		$this->error(L('CAPTCHA_NOT_RIGHT'));
    	}else{
            $user = D("Common/User");
            if(strpos($name,"@")>0){//邮箱登陆
                $where['user_email'] = $name;
            }else{
                $where['user_login'] = $name;
            }

            $result = $user->where($where)->find();
//            if(!empty($result) && $result['user_type']==1){
//                if(sp_compare_password($pass,$result['user_pass'])){
//
//                    $role_user_model=M("RoleUser");
//
//                    $role_user_join = C('DB_PREFIX').'role as b on a.role_id =b.id';
//
//                    $groups=$role_user_model->alias("a")->join($role_user_join)->where(array("user_id"=>$result["id"],"status"=>1))->getField("role_id",true);
//
//                    if( $result["id"]!=1 && ( empty($groups) || empty($result['user_status']) ) ){
//                            $this->error(L('USE_DISABLED'));
//                    }
//                    //登入成功页面跳转
//                    $_SESSION["ADMIN_ID"]=$result["id"];
//                    $_SESSION['name']=$result["user_login"];
//                    $result['last_login_ip']=get_client_ip(0,true);
//                    $result['last_login_time']=date("Y-m-d H:i:s");
//                    $user->save($result);
//                    setcookie("admin_username",$name,time()+30*24*3600,"/");
//                    $this->success(L('LOGIN_SUCCESS'),U("Index/index"));
//                }else{
//                    $this->error(L('PASSWORD_NOT_RIGHT'));
//                }
//            }else{
//                    $this->error(L('USERNAME_NOT_EXIST'));
//            }
    	}
    }
    
    /**
     * 退出登录
     */
    public function loginout() 
    {
        session('ADMIN_ID',null); 
    	redirect(__ROOT__."/");
    }
    
}
