<?php
return array(
    //'ad'=>array('Behavior\\adBehavior'), //测试钩子
    //'showTest'=>array('Test'), //测试插件
    'app_init' => array('Common\Behavior\InitHookBehavior'),
    'app_begin' => array('Behavior\CheckLangBehavior'), //多语言
);

