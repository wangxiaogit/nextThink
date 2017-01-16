<?php

namespace Common\Model;
use Common\Model\CommonModel;

class AuthAccessModel extends CommonModel
{
    
    public function _before_write(&$data) 
    {
        parent::_before_write($data);
    }
}
