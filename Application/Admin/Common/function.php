<?php

/**
 * 获取配置的类型
 * @param string $type 配置类型
 * @return string
 */
function get_config_type($type=0){
    $list = C('CONFIG_TYPE_LIST');
    return $list[$type];
}

/**
 * 获取配置的分组
 * @param string $group 配置分组
 * @return string
 */
function get_config_group($group=0){
    $list = C('CONFIG_GROUP_LIST');
    return $group?$list[$group]:'';
}

/**
 * 分析枚举类型配置值 格式 a:名称1,b:名称2
 * @param string $string 字符串
 * @return  array
 */
function parse_config_attr ($string) {
    $array  = preg_split('/[,;\n\r]+/', trim($string, ",;\n\r"));
    if (strpos($string, ":")) {
        $value = array();
        foreach ($array as $val) {
            list($k, $v) = explode(":", $val);
            $value[$k] = $v;
        }
    } else {
        $value =  $array;
    }
    
    return $value;
}
