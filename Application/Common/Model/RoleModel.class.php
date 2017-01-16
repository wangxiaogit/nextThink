<?php
namespace Common\Model;
use Common\Model\CommonModel;

class RoleModel extends CommonModel
{ 
    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '角色名称不能为空！', CommonModel::MUST_VALIDATE, 'regex', CommonModel:: MODEL_BOTH ),
    );
    
    //自动完成
    protected $_auto = array(
        //array(完成字段1,完成规则,[完成条件,附加规则])
        array('create_time', 'time', CommonModel::MODEL_INSERT, 'function'),
        array('update_time', 'time', CommonModel::MODEL_UPDATE, 'function')
    );

    public function _before_write(&$data) 
    {    
        parent::_before_write($data);
    }
}
