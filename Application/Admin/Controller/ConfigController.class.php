<?php
/**
 * Config(配置管理)
 */
namespace Admin\Controller;
use Common\Controller\AdminController;

class ConfigController extends AdminController{
    
    protected $configModel;
            
    public function _initialize() 
    {
        parent::_initialize();
        $this->configModel = D("Common/Config");
    }
    
   /**
    * 配置分组
    */
    public function group() 
    {
       $groupId = I('get.groupId', 1);
       
       $list = $this->configModel->where(array('status'=>1, 'group'=>$groupId))->field('id,name,title,extra,value,remark,type')->order('sort')->select();
       if ($list) {
           $this->assign('list', $list);
       }
       
       $this->assign('groupId', $groupId); 
       
       $this->display();
    }
    
    /**
     * 配置列表 
     */
    public function index() 
    {
        $map = array('status' => 1);
        if (!empty($_GET['group'])) {
            $map['group'] = intval(I('group'));
        }
        if (!empty($_GET['keywords'])) {
            $map['name|title'] = array('like', '%'.(string)I('keywords').'%');
        }
        
        $lists = $this->lists('Config', $map, 'sort ASC');
        
        $this->assign('lists', $lists);
        $this->assign('formget', $_POST);
        $this->assign('meta_title', L('WEBSITE_CONFIG_MANAGE'));
        $this->display();
    }
    
    /**
     * 配置添加 
     */
    public function add()
    {
        $this->assign('meta_title', L('WEBSITE_CONFIG_ADD'));
        $this->display();   
    }
    
    /**
     * 提交添加
     */
    public function do_add()
    {
        if (IS_POST) {
            if ($this->configModel->create()) {
                if ($this->configModel->add()!==false) {
                    S('WEB_CONFIG_DATA',null);
                    $this->success(L('ADD_SUCCESS'), U('Config/index'));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error($this->configModel->getError());
            }
        }    
    }        
    
    /**
     * 配置编辑
     */
    public function edit($id)
    {
        $config = $this->configModel->find($id);

        if (false === $config) {
            $this->error("获取配置信息错误");
        }

        $this->assign('config', $config);
        $this->assign('meta_title', L('WEBSITE_CONFIG_EDIT'));
        $this->display();    
    }
    
    /**
     * 提交编辑
     */
    public function do_edit($id)
    {
        if (IS_POST) {
            if ($this->configModel->create()) {
                if ($this->configModel->save()!==false) {
                    S('WEB_CONFIG_DATA',null);
                    $this->success(L('EDIT_SUCCESS'), U('Config/index'));
                } else {
                    $this->error(L('EDIT_FAILED'));
                }
            } else {
                $this->error($this->configModel->getError());
            }
        } 
    }        
    
    /**
     * 配置删除
     */
    public function delete()
    {
        $id = I("get.id",0,"intval");
        
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        
        if ($this->configModel->delete($id)!==false) {
            S('WEB_CONFIG_DATA',null);
            $this->success(L('DEL_SUCCESS'));
        } else {
            $this->error(L('DEL_FAILED'));
        }
    }
    
    /**
     * 配置批量保存
     */
    public function save($config)
    {
        if($config && is_array($config)){
            foreach ($this->configModel as $name => $value) {
                $map = array('name' => $name);
                $Config->where($map)->setField('value', $value);
            }
        }
        
        S('WEB_CONFIG_DATA',null);
        $this->success(L('SAVE_SUCCESS'));
    } 
    
    /**
     * 排序 
     */
    public function sort() 
    {
        $status = parent::_listorders($this->configModel, 'sort');
        if ($status) {
            $this->success(L('SORT_SUCCESS'));
        } else {
            $this->error(L('SORT_FAILED'));
        }
    }
    
}
