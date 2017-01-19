<?php
/**
 * 获取当前登录的管事员id
 * @return int
 */
function get_current_admin_id(){
    return $_SESSION['ADMIN_ID'];
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name){
    $class = "Addons\\{$name}\\{$name}Addon";
    return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name){
    $class = get_addon_class($name);
    if (class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    } else {
        return array();
    }
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array $param 参数
 */
function addons_url($url, $param = array()){
    $url        = parse_url($url);
    $case       = C('URL_CASE_INSENSITIVE');
    $addons     = $case ? parse_name($url['scheme']) : $url['scheme'];
    $controller = $case ? parse_name($url['host']) : $url['host'];
    $action     = trim($case ? strtolower($url['path']) : $url['path'], '/');

    /* 解析URL带的参数 */
    if(isset($url['query'])){
        parse_str($url['query'], $query);
        $param = array_merge($query, $param);
    }

    /* 基础参数 */
    $params = array(
        '_addons'     => $addons,
        '_controller' => $controller,
        '_action'     => $action,
    );
    $params = array_merge($params, $param); //添加额外参数

    return U('Home/Addons/execute', $params);
}

/**
 * 处理标签扩展
 * @param string $tag 标签名称
 * @param mixed $params 传入参数
 * @return void
 */
function hook($tag, &$params=NULL) {
    \Think\Hook::listen($tag,$params);
}

/**
 * 检查权限
 * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
 * @param uid  int           认证用户的id
 * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
 * @return boolean           通过验证返回true;失败返回false
 */
function sp_auth_check($uid, $name=null, $relation='or'){
    if(empty($uid)){
        return false;
    }

    $iauth_obj = new Org\Util\iAuth();
    if(empty($name)){
            $name = strtolower(MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME);
    }
    return $iauth_obj->check($uid, $name, $relation);
}

/**
 * 替代scan_dir的方法
 * @param string $pattern 检索模式 搜索模式 *.txt,*.doc; (同glog方法)
 * @param int $flags
 */
function sp_scan_dir($pattern,$flags=null){
    $files = array_map('basename',glob($pattern, $flags));
    return $files;
}

/**
 * 调用系统的API接口方法（静态方法）
 * api('User/getName','id=5'); 调用公共模块的User接口的getName方法
 * api('Admin/User/getName','id=5');  调用Admin模块的User接口
 * @param  string  $name 格式 [模块名]/接口名/方法名
 * @param  array|string  $vars 参数
 */
function Api($name,$vars=array()){
    $array     = explode('/',$name);
    $method    = array_pop($array);
    $classname = array_pop($array);
    $module    = $array? array_pop($array) : 'Common';
    $callback  = $module.'\\Api\\'.$classname.'Api::'.$method;
    if(is_string($vars)) {
        parse_str($vars,$vars);
    }
    return call_user_func_array($callback,$vars);
}

/**
 * 获取所有方法名
 * 
 * @param string $url
 * @return array
 */
function get_action($url) {
    if (empty($url)) {
        return null;
    }
    //获取全部方法，包括被继承的方法
    $functions = get_class_methods($url);
    //排除部分方法
    $inherents_functions = array(
        '_initialize', '__construct', 'isAjax', 'display', 'show', 'fetch', 'buildHtml', 'assign', '__set', 'get',
        '__get', '__isset', '__call', 'error', 'success', 'ajaxReturn', 'redirect', '__destruct', '_empty', 'install',
        'uninstall', 'execute'
    );
    //排除以指定前缀开头的方法
    $pre_inherents_functions = array('_before_', '_after_');
    foreach ($functions as $func) {
        $func = trim($func);
        foreach ($pre_inherents_functions as $pre) {
            if (stripos($func, $pre) === 0) {
                continue 2;
            }
        }
        if (in_array($func, $inherents_functions)) {
            continue;
        }
        $customer_functions[] = $func;
    }
    
    return $customer_functions;
}