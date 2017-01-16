<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo ($meta_title); ?></title>
        <!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- HTML5 shim for IE8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <![endif]-->
        
        <link rel="stylesheet" href="/nexTthink1/Public/Static/bootstrap/css/bootstrap.min.css">
        <link href="/nexTthink1/Public/Admin/css/admin.css" rel="stylesheet">
        <link href="/nexTthink1/Public/Static/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
        <link href="/nexTthink1/Public/Admin/css/default.css" rel="stylesheet">
        
        <!--[if IE 7]>
                <link rel="stylesheet" href="/nexTthink1/Public/Static/css/font-awesome-ie7.min.css">
        <![endif]-->
        
        <script>
            var GV = {
                DIMAUB: "",
                JS_ROOT: "/nexTthink1/Public/Static/",//js版本号
                TOKEN : ''	//token ajax全局
            };
        </script>  
        <script src="/nexTthink1/Public/Static/jquery.js"></script>	
        <script src="/nexTthink1/Public/Static/wind.js"></script>	
        <script src="/nexTthink1/Public/Static/bootstrap/js/bootstrap.min.js"></script>	
        <script src="/nexTthink1/Public/Static/layer/layer.js"></script>	
    

</head>
<body>
    <?php echo hook('AdminIndex');?>
<!--    <div class="wrap js-check-wrap">
        <ul>
            <li class="active"><a href="<?php echo U('Config/index');?>"><?php echo L('ADMIN_ADDONS_MANAGE');?></a></li>
        </ul>
        <form method="post" class="js-ajax-form">
            <?php $status=array("1"=>L('ENABLED'),"0"=>L('DISABLED'),"3"=>L('UNINSTALLED')); ?>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th><?php echo L('NAME');?></th>
                        <th><?php echo L('TEXT_DOMAIN');?></th>
                        <th><?php echo L('HOOKS');?></th>
                        <th><?php echo L('DESCRIPTION');?></th>
                        <th><?php echo L('AUTHOR');?></th>
                        <th width="45"><?php echo L('STATUS');?></th>
                        <th width="150"><?php echo L('ACTIONS');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($addons)): foreach($addons as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["title"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["hooks"]); ?></td>
                            <td><?php echo ($vo["description"]); ?></td>
                            <td><?php echo ($vo["author"]); ?></td>
                            <td><?php echo ($status[$vo['status']]); ?></td>
                            <td>
                                <?php if($vo['status']==3): ?><a href="<?php echo U('Addons/install',array('name'=>$vo['name']));?>" class="js-ajax-dialog-btn" data-msg="确定安装该插件吗？"><?php echo L('INSTALL');?></a>
                                <?php else: ?>
                                    <?php $config=json_decode($vo['config'],true); ?>
                                    <?php if(!empty($config)): ?><a href="<?php echo U('Addons/setting',array('id'=>$vo['id']));?>"><?php echo L('SETTING');?></a>|
                                    <?php else: ?>
                                            <a href="javascript:;" style="color: #ccc;"><?php echo L('SETTING');?></a>|<?php endif; ?>

                                    <?php if(!empty($vo['has_admin'])): ?><a href="javascript:parent.openapp('<?php echo sp_plugin_url($vo['name'].'://AdminIndex/index');?>','plugin_<?php echo ($vo["name"]); ?>','<?php echo ($vo["title"]); ?>')"><?php echo L('MANAGE');?></a>|
                                    <?php else: ?>
                                            <a href="javascript:;" style="color: #ccc;"><?php echo L('MANAGE');?></a>|<?php endif; ?>

                                    <a href="<?php echo U('Addons/update',array('name'=>$vo['name']));?>" class="js-ajax-dialog-btn" data-msg="确定更新该插件吗？"><?php echo L('UPDATE');?></a>| 

                                    <?php if($vo['status']==0): ?><a href="<?php echo U('Addons/toggle',array('id'=>$vo['id'],'enable'=>1));?>" class="js-ajax-dialog-btn" data-msg="确定启用该插件吗？"><?php echo L('ENABLE');?></a>| 
                                    <?php else: ?>
                                            <a href="<?php echo U('Addons/toggle',array('id'=>$vo['id'],'disable'=>1));?>" class="js-ajax-dialog-btn" data-msg="确定禁用该插件吗？"><?php echo L('DISABLED');?></a>|<?php endif; ?>

                                    <a href="<?php echo U('Addons/uninstall',array('id'=>$vo['id']));?>" class="js-ajax-dialog-btn" data-msg="确定卸载该插件吗？"><?php echo L('DISINSTALLED');?></a><?php endif; ?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </form>    
    </div>-->
</body>
</html>