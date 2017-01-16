<?php

/**
 * RBAC(系统权限, 角色管理)
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class RbacController extends AdminController
{
    protected $roleModel;
    protected $authAccessModel; 

    public function _initialize() 
    {
        parent::_initialize();
        $this->roleModel = D('Common/Role');
    }
    
    /**
     * 角色管理  add添加,edit编辑,delete删除
     */
    public function index() 
    {
        $roles = $this->lists($this->roleModel, array(), "listorder ASC,id DESC");
        
        $this->assign('roles', $roles);
        $this->assign('meta_title', L('ADMIN_ROLE_MANAGE'));
        $this->display();
    }
    
    /**
     * 添加角色 
     */
    public function add()
    {
        $this->assign('meta_title', L('ROLE_ADD'));
        $this->display();
    }
    
    /**
     * 提交添加
     */
    public function do_add()
    {
        if (IS_POST) {
            if ($this->roleModel->create()) {
                if ($this->roleModel->add()!==false) {
                    $this->success(L('ADD_SUCCESS'), U('Rbac/index'));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error($this->roleModel->getError());
            }
        } 
    }        
    
    /**
     * 编辑角色
     */
    public function edit($id)
    {
        $role = $this->roleModel->find($id);
        
        if (false === $role) {
            $this->error("获取配置信息错误");
        }
        
        $this->assign('role', $role);
        $this->assign('meta_title', L('ROLE_EDIT'));
        $this->display();
    }        
    
    /**
     * 提交编辑
     */
    public function do_edit()
    {
        if (IS_POST) {
            if ($this->roleModel->create()) {
                if ($this->roleModel->save() !== false) {
                    $this->success(L('EDIT_SUCCESS'), U('Rbac/index'));
                } else {
                    $this->error(L('EDIT_FAILED'));
                }
            } else {
                $this->error($this->roleModel->getError());
            }
        } 
    }
    
    /**
     * 删除角色
     */
    public function delete()
    {
        $id = intval(I("get.id"));
        if ($id == 1) {
            $this->error("超级管理员角色不能被删除！");
        }
        
        if ($this->roleModel->delete($id) !== false) {
            $this->success(L('DEL_SUCCESS'));
        } else {
            $this->error(L('DEL_FAILED'));
        }
    }
    
    /**
     * 权限设置
     */
    public function authority()
    {
        $this->authAccessModel = D('Common/authAccess');
        
        $roleId = intval(I('get.id'));
        if (!$roleId) {
            $this->error("获取参数错误！");
        }
       
        $Tree = new \Org\Util\Tree();
        $Tree->icon = array('│ ', '├─ ', '└─ ');
        $Tree->nbsp = '&nbsp;&nbsp;&nbsp;';
       
        $newMenu = array();
        $result = $this->initMenu();
        $role_authority = $this->authAccessModel->where("role_id =".$roleId)->getField("rule_name");
        
        foreach ($result as $key => $val) {
            $newMenu[$val['id']] = $val;
        }
        
        foreach ($result as $n => $t) {
            $result[$n]['checked'] = ($this->_is_checked($t, $roleId, $role_authority)) ? ' checked' : '';
            $result[$n]['level'] = $this->_get_level($t['id'], $newMenu);
            $result[$n]['parentid_node'] = ($t['parentid']) ? ' class="child-of-node-' . $t['parentid'] . '"' : '';
        }
        
        $str = "<tr id='node-\$id' \$parentid_node>
                <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
                </tr>";
        $Tree->init($result);
        $categorys = $Tree->get_tree(0, $str);
        
        $this->assign("categorys", $categorys);
        $this->assign("roleid", $roleId);
        $this->display();
    }
    
    /**
     * 提交权限
     */
    public function do_authority()
    {
        $this->authAccessModel = D('Common/authAccess');
        
        if (IS_POST) {
            $roleId = I('post.roleid', 0, 'intval');
            
            if (!$roleId) {
                $this->error("授权角色不存在！");
            }
            
            if (is_array($_POST['menuid']) && count($_POST['menuid'])) {
                
                $menuModel = M('Menu');
                $this->authAccessModel->where("role_id =".$roleId)->delete();
                
                foreach ($_POST['menuid'] as $menuid) {
                    
                    $menu = $menuModel->field("app,model,action")->find($menuid); 
                    if ($menu) { 
                        
                        $data = array(
                            'role_id' => $roleId,
                            'rule_name' => strtolower($menu['app']."/".$menu['model']."/".$menu['action']),
                            'type' => 'admin_url'
                        );
                       $this->authAccessModel->add($data); 
                    }
                }
                
                $this->success("授权成功！");
            } else {
                $this->authAccessModel->where("roleid =".$roleId)->delete();
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        }
    }        
    
    /**
     * 检查指定菜单是否有权限
     * 
     * @param array $menu menu表中数组
     * @param int $roleid 需要检查的角色ID
     */
    private function _is_checked($menu, $roleid, $priv_data) 
    {
    	$app = $menu['app'];
    	$model = $menu['model'];
    	$action = $menu['action'];
    	$name = strtolower("$app/$model/$action");
        
    	if($priv_data){
            if (in_array($name, $priv_data)) {
                return true;
            } else {
                return false;
            }
    	}else{
            return false;
    	}	
    }

    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function _get_level($id, $array = array(), $i = 0) 
    {    
        if ($array[$id]['parentid']==0 || empty($array[$array[$id]['parentid']]) || $array[$id]['parentid']==$id){
            return  $i;
        }else{
            $i++;
            return $this->_get_level($array[$id]['parentid'],$array,$i);
        }    		
    }
}
