<?php
/** 
 * Menu(菜单管理)
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class MenuController extends AdminController
{
    protected $menuModel; 

    public function _initialize() 
    {
        parent::_initialize();
        $this->menuModel = D('Common/Menu');
    }
    
    /**
     * 菜单列表
     */
    public function index() 
    {
        $newMenus = array();
        $result = $this->menuModel->order(array("listorder" => "ASC"))->select();
        
        foreach ($result as $value) {
            $newMenus[$value['id']] = $value; 
        }
        
        foreach ($result as $n => $r) {
            $result[$n]['level'] = $this->_get_level($r['id'], $newMenus);
            $result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . '"' : '';

            $result[$n]['str_manage'] = '<a href="' . U("Menu/add", array("parentid" => $r['id'], "menuid" => I("get.menuid"))) . '">'.L('SUB_MENU_ADD').'</a> | <a href="' . U("Menu/edit", array("id" => $r['id'], "menuid" => I("get.menuid"))) . '">'.L('EDIT').'</a> | <a class="js-ajax-delete" href="' . U("Menu/delete", array("id" => $r['id'], "menuid" => I("get.menuid")) ). '">'.L('DELETE').'</a> ';
            $result[$n]['status'] = $r['status'] ? L('DISPLAY') : L('HIDDEN');
            $result[$n]['app']=$r['app']."/".$r['model']."/".$r['action'];
        }
        
        $Tree = new \Org\Util\Tree();
        $Tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $Tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        
        $Tree->init($result);
        $str = "<tr id='node-\$id' \$parentid_node>
                    <td style='padding-left:20px;'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-order'></td>
                    <td>\$id</td>
                    <td>\$app</td>
                    <td>\$spacer\$name</td>
                    <td>\$status</td>
                    <td>\$str_manage</td>
		</tr>";
        $categorys = $Tree->get_tree(0, $str);
        $this->assign("categorys", $categorys);
        $this->display();
    }
    
    /**
     * 菜单添加
     */
    public function add()
    {
        $Tree = new \Org\Util\Tree();
        $parentid = intval(I("get.parentid"));

        $result = $this->menuModel->order(array("listorder" => "ASC"))->select();
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentid ? 'selected' : '';
            $array[] = $r;
        }

        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $Tree->init($array);
        $select_categorys = $Tree->get_tree(0, $str);

        $this->assign("select_categorys", $select_categorys);
        $this->display();    
    }
    
    /**
     * 提交添加
     */
    public function do_add()
    {
        if (IS_POST) {
            if ($this->menuModel->create()) {
                if (false !== $this->menuModel->add()) {
                    $this->success(L('ADD_SUCCESS'), U('Menu/index'));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error($this->menuModel->getError());
            }
        } 
    }
    
    /**
     * 菜单编辑
     */
    public function edit($id)
    {
        $data = $this->menuModel->where(array("id" => $id))->find();
        if(false === $data) {
            $this->error("获取菜单信息错误！");
        }

        $result = $this->menuModel->order(array("listorder" => "ASC"))->select();
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $data['parentid'] ? 'selected' : '';
            $array[] = $r;
        }

        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $Tree = new \Org\Util\Tree();
        $Tree->init($array);
        $select_categorys = $Tree->get_tree(0, $str);

        $this->assign("data", $data);
        $this->assign("select_categorys", $select_categorys);
        $this->display();     
    }
    
    /**
     * 提交编辑
     */
    public function do_edit($id) 
    {
        if (IS_POST) {
           if ($this->menuModel->create()) {
                if (false !== $this->menuModel->save()) {
                    $this->success(L('EDIT_SUCCESS'), U('Menu/index'));
                } else {
                    $this->error(L('EDIT_FAILED'));
                }
            } else {
                $this->error($this->menuModel->getError());
            }
        } 
    }
    
    public function delete()
    {
        $id = intval(I("get.id"));
        $count = $this->menuModel->where(array("parentid" => $id))->count();
        if ($count > 0) {
            $this->error("该菜单下还有子菜单，无法删除！");
        }
        if ($this->menuModel->delete($id)!==false) {
            $this->success(L('DEL_SUCCESS'));
        } else {
            $this->error(L("DEL_FAILED"));
        }
    }
    
    /**
     * 菜单排序
     *
     */
    public function sort()
    {
        $status = parent::_listorders($this->menuModel, 'listorder');
        if ($status) {
            $this->success(L('SORT_SUCCESS'));
        } else {
            $this->error(L('SORT_FAILED'));
        }
    }
    
    /**
     * 菜单导入
     * 
     */
    /*public function import() 
    {
        $apps = C("MODULE_ALLOW_LIST");
        $app = I('get.app') ? (string)I('get.app') : $apps[1];
        
        if (is_dir(APP_PATH.$app) && !(strpos($app, '.') === 0)) {
            
            $moudleDir = APP_PATH.$app."/Controller";
            $moudles = sp_scan_dir($moudleDir."/*");
            
            if (count($moudles)) {
                foreach ($moudles as $val) {
                    if (strpos($val, ".") && end(explode(".", $val)) == "php") {
                        $moudle = str_replace("Controller.class.php", "", $val);
                    }
                    $class = A($app."/".$moudle);
                    $actions = get_class_methods($class);
                    
                    foreach ($actions as $action) {
                        if (!(strpos($action, '_') === 0)) {
                            $check = $this->menuModel->where(array('app' =>$app, 'model' =>$moudle, 'action' =>$action))->find();
                            
                            if (!$check) {
                                $data = array(
                                    'parentid' => $parentid,
                                    'app' => $app,
                                    'model' => $moudle,
                                    'action' => $action,
                                    'type' => 1,
                                    'status' => 0,
                                    'name' => '未定义',
                                    'listorder' => 0
                                );
                                
                                $parentid = $this->menuModel->add($data); 
                                
                            }
                        }
                    }    
                }
            }
        }
         
    }*/
    
    /**
     * 获取菜单深度
     * 
     * @param $id
     * @param $array
     * @param $i
     */
    public function _get_level($id, $array = array(), $i = 0) 
    {
    	if ($array[$id]['parentid']==0 || empty($array[$array[$id]['parentid']]) || $array[$id]['parentid']==$id){
            return  $i;
    	}else{
            $i++;
            return $this->_get_level($array[$id]['parentid'],$array,$i);
    	}
    }
}
