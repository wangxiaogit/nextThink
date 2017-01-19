<?php
namespace Common\Model; 
use Common\Model\CommonModel;

class AddonsModel extends CommonModel
{      
    /**
     * 插件列表
     */
    public function getList($addon_dir = '')
    {
        if(!$addon_dir) {
            $addon_dir = ADDONS_PATH;
        }  
        
        $dirs = array_map('basename',glob(ADDONS_PATH.'*', GLOB_ONLYDIR));
        if ($dirs == false) {
            $this->error('插件目录不可读');
            return ;
        }
        
        $addons = array();
        $where['name']= array('in',$dirs);
        $list =	$this->where($where)->field(true)->select();
        
        foreach($list as $addon){
            $addons[$addon['name']] = $addon;
        }
        
        foreach ($dirs as $value) {
            if(!isset($addons[$value])){
                $class = get_addon_class($value);
                if(!class_exists($class)){ // 实例化插件失败忽略执行
                    \Think\Log::record('插件'.$value.'的入口文件不存在！');
                    continue;
                }
                
                $obj = new $class;
		$addons[$value]	= $obj->info;
                
		if(!isset($obj->info['type']) || $obj->info['type']==1){//只获取普通插件，微信插件在微信中使用
                    $addons[$value]['status'] = 3;//未安装
                    
                    //hook
                    $url = '\\Addons\\'.$value.'\\' .$value. 'Addon';
                    
                    $addons[$value]['hooks'] = $hooks ? '': implode(',', get_action($url)); 
                }else{
                    unset($addons[$value]);
                }
            }
        }
        
        return $addons;
    }
    
    public function _before_write(&$data) 
    {    
        parent::_before_write($data);
    }
}
