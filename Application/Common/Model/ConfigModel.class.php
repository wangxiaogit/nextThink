<?php

namespace Common\Model;
use Common\Model\CommonModel;

class ConfigModel extends CommonModel
{
    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '标识不能为空！', self::EXISTS_VALIDATE, 'regex', CommonModel:: MODEL_BOTH  ),
        array('name', '', '标识已存在！', self::VALUE_VALIDATE, 'unique', CommonModel:: MODEL_BOTH  ),
        array('title', 'require', '标题不能为空！',  self::MUST_VALIDATE, 'regex', CommonModel:: MODEL_BOTH ),
        
    );
    //自动完成
    protected $_auto = array(
        //array(完成字段1,完成规则,[完成条件,附加规则]),
        array('name', 'strtoupper', self::MODEL_BOTH, 'function'),
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', '1', self::MODEL_BOTH),
    );
    
    public function _before_write(&$data) 
    {
	parent::_before_write($data);
    }
}
