<?php
namespace Org\Util;

class iAuth{

    protected $roleUserModel; //用户角色关系
    protected $authAccessModel; //角色权限关系
    protected $_config = array();//默认配置

    public function __construct() 
    {
        $this->roleUserModel = M("RoleUser");
        $this->authAccessModel = M("AuthAccess");
    }

    /**
      * 检查权限
      * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
      * @param uid  int           认证用户的id
      * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
      * @return boolean           通过验证返回true;失败返回false
     */
    public function check($uid, $name, $relation='or') 
    {
    	if (empty($uid)) {
            return false;
    	}
        
    	if ($uid == 1) {
            return true;
    	}
        
        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        
        $roles = $this->roleUserModel->alias("a")
                  ->join(C('DB_PREFIX').'role as b on a.role_id =b.id')
                  ->where(array("user_id"=>$uid,"status"=>1))->getField("role_id",true);
        
        if(in_array(1, $roles)){
            return true;
        }

        if(empty($roles)){
        	return false;
        }
        
        $rules = $this->authAccessModel->alias("a")
                 ->where(array("role_id"=>array("in",$roles),"rule_name"=>array("in",$name)))
                 ->select();
        
        return empty($rules) ? false : true;
    }

}
