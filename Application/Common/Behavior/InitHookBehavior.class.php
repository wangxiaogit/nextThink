<?php

/**
 * InitHook(初始华钩子)
 */
namespace Common\Behavior;
use Think\Behavior;
use Think\Hook;

class InitHookBehavior extends Behavior {
    
    /**
     * 行为拓展入口
     */
    public function run(&$content) 
    {    
        $data = S('hooks');
        
        if (!$data) {
            $addons = M('Addons')->where("status = 1")->getField("name, hooks");
           
            if (!empty($addons)) {
                foreach ($addons as $addon=>$hooks) {
                    if ($hooks) {
                       $hooks = explode(",", $hooks);
                       foreach ($hooks as $hook){
                           Hook::add($hook,$addon);
                       }
                   }
                }
            }
            
            S('hooks',Hook::get());
        } else {
            Hook::import($data, FALSE);
        }
    }
}
