<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Addons\DevTeam\Controller;
use Home\Controller\AddonsController; 

class DevTeamController extends AddonsController{
	
	public function detail(){
		/* 获取附件ID */
		$id = I('get.id');
		if(empty($id) || !is_numeric($id)){
			$this->error('附件ID无效！');
		}
                
                $this->display(T('Addons://DevTeam@DevTeam/detail'));
	}

	

}
