<?php
/**
 * User(管理员)
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class UserController extends AdminController
{
    protected $userModel;
    protected $roleModel;
    protected $roleUserModel;
    
    public function _initialize()
    {
        parent::_initialize();
        $this->userModel = D('Common/User');
        $this->roleModel = D('Common/Role');
        $this->roleUserModel = M('RoleUser');
    }
    
    public function index() 
    {
        $map = array('user_type' => 1);
        if (isset($_POST['user_login'])) {
            $map['user_login'] = array('like', '%'.I('user_login').'%');
        }
        if (isset($_POST['user_email'])) {
           $map['user_email'] = array('like', '%'.I('user_email').'%'); 
        }
        
        $users = $this->lists($this->userModel, $map, 'create_time DESC');  
        $this->assign('meta_title', L('ADMIN_USER_MANAGE'));
        $this->assign('users', $users);
        $this->display();
    }
    
    public function add()
    {
        $roles = $this->roleModel->where("status = 1")->order("id DESC")->select();
        
        $this->assign("roles", $roles);
        $this->assign('meta_title', L('ADMIN_USER_ADD'));
        $this->display();
    }
    
    public function do_add()
    {
        if (IS_POST) {
            if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
                $role_ids =  $_POST['role_id'];
                
                if ($this->userModel->create()) {
                    
                    $user_id = $this->userModel->add();
                    if (false !== $user_id) {
                        foreach ($role_ids as $role_id) {
                            $this->roleUserModel->add(array("role_id"=>$role_id,"user_id"=>$user_id));
                        }
                        $this->success(L('ADD_SUCCESS'), U('User/index'));
                    } else {
                        $this->success(L('ADD_FAILED'));
                    }
                }
            } else {
                $this->error("请为此用户指定角色！");
            }
        }
    }   
    
    public function edit()
    {
        $id = I('get.id', 0, 'intval');
        if (empty($id)) {
            $this->error("参数不能为空！");
        }
        
        $user = $this->userModel->find($id);
        $roles = $this->roleModel->where("status = 1")->order("id DESC")->select();
        $role_user = $this->roleUserModel->where("user_id = ".$id)->select();
        
        $this->assign("user", $user);
        $this->assign("roles", $roles);
        $this->assign("role_user", $role_user);
        $this->assign('meta_title', L('ADMIN_USER_EDIT'));
        $this->display();
    }
    
    public function do_edit()
    {
        if (IS_POST) {
            if(!empty($_POST['role_id']) && is_array($_POST['role_id'])){
                $role_ids = $_POST['role_id'];
                if (empty($_POST['user_pass'])) {
                    unset($_POST['user_pass']);
                }
                
                if ($this->userModel->create()) {
                    if (false !== $this->userModel->save()) {
                        $user_id = intval(I('post.id'));
                        $this->roleUserModel->where("user_id =".$user_id)->delete();
                        
                        foreach($role_ids as $role_id) {
                            $this->roleUserModel->add(array("role_id"=>$role_id,"user_id"=>$user_id));
                        }
                        
                         $this->success(L('ADD_SUCCESS'), U('User/index'));
                    } else {
                         $this->error(L('ADD_FAILED'));
                    }    
                }    
            } else {
                $this->error("请为此用户指定角色！"); 
            }
        }
    }        
    
    public function delete()
    {
        $id = intval(I("get.id"));

        if ($this->usermodel->delete($id) !== false) {
            $this->roleUserModel->where(array("user_id"=>$id))->delete();
            $this->success(L('DEL_SUCCESS'), U('User/index'));
        } else {
            $this->error(L('DEL_FAILED'));
        }
    }
    
    /**
     * 拉黑
     */
    public function ban()
    {
        $id = I('get.id', 0, 'intval');
        
    	if ($id) {
            if ( $this->userModel->where(array("id" => $id,"user_type"=>1))->setField('user_status', 0)) {
                $this->success(L('BAN_SUCCESS'), U("User/index"));
            } else {
                $this->error(L('BAN_FAILED'));
            }
    	} else {
            $this->error('参数不能为空！');
    	}
    }
    
    /**
     * 启用
     */
    public function open()
    {
        $id = I('get.id', 0, 'intval');
        
    	if ($id) {
            if ($this->userModel->where(array("id" =>$id,"user_type" =>1))->setField('user_status', 1)) {
                $this->success(L('OPEN_SUCCESS'), U("User/index"));
            } else {
                $this->error(L('BAN_FAILED'));
            }
    	} else {
            $this->error('参数不能为空！');
    	}
    }
    
}
