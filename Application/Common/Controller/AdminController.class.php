<?php
namespace Common\Controller;
use Common\Controller\AppController;

/*
 * 后台Controller
 */

class AdminController extends AppController {
    
    public function __construct() 
    {
        session('ADMIN_ID', 1);
        parent::__construct();
    }
    
    public function _initialize() {
        parent::_initialize();
        $adminId = $_SESSION['ADMIN_ID'];
        if (isset($adminId)) {
            //网站配置
            S('WEB_CONFIG_DATA', null);
            $config =   S('WEB_CONFIG_DATA');
            if (empty($config)) {
                $config = Api('Config/lists');
                
                S('WEB_CONFIG_DATA',$config);
            }
            C($config);
            
            //用户信息
            $adminInfo = M("User")->find($adminId);
            $this->assign("admin", $adminInfo);
            
            //系统权限
            if (!$this->checkAccess($adminId)) {
                $this->error("你没有访问权限！");
                exit;
            }
               
        } else {
            if (IS_AJAX) {
                $this->error("您还没有登录！",U("Admin/Public/login"));
            } else {
                header("Location:".U("Admin/Public/login"));
                exit();
            }
        }
    }
    
    /**
     * 权限验证
     * 
     * @param int $uid 用户id
     */
    private function checkAccess($uid) 
    {
        if ($uid == 1) {
            return true;
        }
        
        $rule = MODULE_NAME.CONTROLLER_NAME.ACTION_NAME;
    	$no_Need_Check_Rules=array("AdminIndexindex","AdminMainindex");
    	
    	if( !in_array($rule,$no_Need_Check_Rules) ){
            return sp_auth_check($uid);
    	}else{
            return true;
    	}
    }
    
    /**
     * 初始化后台菜单
     */
    public function initMenu() {
        $Menu = F("Menu");
        if (!$Menu) {
            $Menu = D("Common/Menu")->menu_cache();
        }
        return $Menu;
    }
    
    /**
     * 消息提示
     * @param type $message
     * @param type $jumpUrl
     * @param type $ajax 
     */
    public function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
    }
    
    /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     * @author 朱亚杰 <xcoolcc@gmail.com>
     *
     * @return array|false
     * 返回数据集
     */
    protected function lists ($model,$where=array(),$order='',$field=true){
        $options    =   array();
        $REQUEST    =   (array)I('request.');
        if(is_string($model)){
            $model  =   M($model);
        }

        $OPT        =   new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);

        $pk         =   $model->getPk();
        if($order===null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

        if(empty($where)){
            $where  =   array('status'=>array('egt',0));
        }
        if( !empty($where)){
            $options['where']   =   $where;
        }
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        
        $Page = new \Think\Page($total, $listRows);
        if($total>$listRows){
            $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $show = $Page->show();
        $this->assign('_Page', $show ? $show : '');
        $this->assign('_Total',$total);
        
        $options['limit'] = $Page->firstRow.','.$Page->listRows;
        
        $model->setProperty('options',$options);

        return $model->field($field)->select();
    }
    
    
    /**
     * 数组分页
     * 
     * @param array $data 
     */
    public function array_lists($data = array()) {
        
        $total = empty($data) ? 1 : count($data);
        
        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        
        $Page = new \Think\Page($total, $listRows);
        if ($total>$listRows) {
            $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        
        $show = $Page->show();
        $this->assign('_Page', $show ? $show : '');
        $this->assign('_Total',$total);
        
        return array_slice($data, $Page->firstRow, $Page->listRows);
    } 
    
    /**
     * 排序 排序字段为listorders数组 POST 排序字段为：listorder
     * 
     * @param string $model 数据模型
     * @param string $sort_field  排序字段
     */
    protected function _listorders($model, $sort_field) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        
        foreach ($ids as $key => $r) {
            $data[$sort_field] = $r;
            $model->where(array($pk => $key))->save($data);
        }
        return true;
    }
    
    /**
     * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
     *
     * @param string $model 模型名称,供M函数使用的参数
     * @param array  $data  修改的数据
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     *
     */
    final protected function editRow ( $model, $data, $where, $msg ){
        $id    = array_unique((array)I('id',0));
        $id    = is_array($id) ? implode(',',$id) : $id;
        //如存在id字段，则加入该条件
        $fields = M($model)->getDbFields();
        if(in_array('id',$fields) && !empty($id)){
            $where = array_merge( array('id' => array('in', $id )) ,(array)$where );
        }

        $msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
        if( M($model)->where($where)->save($data)!==false ) {
            $this->success($msg['success'],$msg['url'],$msg['ajax']);
        }else{
            $this->error($msg['error'],$msg['url'],$msg['ajax']);
        }
    }
    
    /**
     * 假删除
     * @param string $model 模型名称,供D函数使用的参数
     * @param array  $where 查询时的where()方法的参数
     * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
     *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
     *
     */
    protected function delete ( $model , $where = array() , $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！')) {
        $data['status']         =   0;
        $this->editRow(   $model , $data, $where, $msg);
    }
           
}
