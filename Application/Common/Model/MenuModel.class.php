<?php
namespace Common\Model;
use Common\Model\CommonModel;

class MenuModel extends CommonModel
{
    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '菜单名称不能为空！', self::MUST_VALIDATE, 'regex', CommonModel:: MODEL_BOTH),
        array('app', 'require', '应用不能为空！', self::MUST_VALIDATE, 'regex', CommonModel:: MODEL_BOTH),
        array('model', 'require', '模块名称不能为空！', self::MUST_VALIDATE, 'regex', CommonModel:: MODEL_BOTH),
        array('action', 'require', '方法名称不能为空！', self::MUST_VALIDATE, 'regex', CommonModel:: MODEL_BOTH),
        array('app,model,action', 'checkAction', '记录已存在！', self::MUST_VALIDATE, 'callback', CommonModel:: MODEL_INSERT),
    	array('id,app,model,action', 'checkActionUpdate', '记录已存在！', self::MUST_VALIDATE, 'callback', CommonModel:: MODEL_UPDATE),
        array('parentid', 'checkParentid', '菜单只支持四级！', self::MUST_VALIDATE, 'callback', CommonModel:: MODEL_INSERT),
    );
    
    /**
     * 验证action是否重复添加
     * 
     * @param array $data
     */
    public function checkAction($data) 
    {
       $find = $this->where($data)->find();
       
       return $find ? false : true;
    }
    
    /**
     * 验证action是否重复
     * 
     * @param array $data
     */
    public function checkActionUpdate($data) 
    {
        $id = $data['id'];
        unset($data['id']);
        
        $find = $this->where($data)->find();
        if ($find && $find['id'] != $id) {
            return false;
        }
        return true;
    }
    
    /**
     * 验证菜单是否超出三级
     * 
     * @param int $parentid
     */
    public function checkParentid($parentid)
    {
        $checkId = $this->where("id = ".$parentid)->getField("parentid");
        if ($checkId) {
            $checkId2 = $this->where("id = ".$checkId)->getField("parentid");
            if ($checkId2) {
                $checkId3 = $this->where("id = ".$checkId2)->getField("parentid");
                if ($checkId3) {
                    return false;
                }
            }
        }
        return true;
    }        
    
    /**
     * 菜单缓存
     */
    public function menu_cache($data = null)
    {
        if (empty($data)) {
            $data = $this->select();
            F('Menu', $data);
        } else {
            F('Menu', $data);
        }
        
        return $data;
    }
    
    
    /** 
     * 树形菜单集合
     */
    public function admin_menu()
    {
        $menu = $this->get_tree(0);
        
        return $menu;
    }
    
    /**
     * 树形结构的菜单
     */
    public function get_tree($myid, $parent= '', $level= 1)
    {
        $menu = $this->sub_menu($myid);
        
        $level++;
        
        if (is_array($menu)) {
            
            $result = array();
            
            foreach ($menu as $m) {
                $id = $m['id'];
                $app = ucwords($m['app']);
                $model = ucwords($m['model']);
                $action = $m['action'];
                
                $params = $m['data'] ? "?" . htmlspecialchars_decode($m['data']) : "";
                
                $array = array(
                    "icon" => $m['icon'],
                    "id" => $id . $app,
                    "name" => $m['name'],
                    "parent" => $parent,
                    "url" => U("{$app}/{$model}/{$action}{$params}", array("menuid" => $id)),
                    'lang'=> strtoupper($app.'_'.$model.'_'.$action)
                );
                
                $result[$id . $app] = $array;
                $child = $this->get_tree($m['id'], $id, $level);
                //由于后台管理界面只支持三层，超出的不层级的不显示
                if ($child && $level <= 3) {
                    $result[$id . $app]['items'] = $child;
                }    
            }
            
            return $result;
        }
        
        return false;
    }
    
    /**
     * 按父ID查找菜单子项
     * @param integer $parentid   父菜单ID  
     * @param integer $with_self  是否包括他自己
     */
    public function sub_menu($parentid, $with_self = FALSE) 
    {
        $menu = $this->where(array("parentid"=>$parentid, "status"=>1))->order("listorder asc")->select();
        
        if ($with_self) {
            $selfMenu = $this->find($parentid);
            $menu = array_merge($menu, $selfMenu);
        }
        
        //权限检查
        if (get_current_admin_id() == 1) {
            return $menu;
        }
        
        $result = array();
        
        foreach ($menu as $m) {
            $action = $m['action'];
            if (preg_match('/^public_/', $action)) {  
                $result[] = $m;
            } else {
                if (preg_match('/^ajax_([a-z]+)_/', $action, $_match)){
                    $action = $_match[1];
                }   
                $rule_name=strtolower($m['app']."/".$m['model']."/".$action);
                if ( sp_auth_check(get_current_admin_id(), $rule_name)){
                    $result[] = $m;
                }       
            }
        }
        
        return $result;
    }
    
    public function _before_write(&$data) 
    {
	parent::_before_write($data);
    }
}
