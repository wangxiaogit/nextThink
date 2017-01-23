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
    <div class="wrap js-check-wrap">
        <ul class="nav nav-tabs">
            <li class="active"><a href="<?php echo U('Config/index');?>"><?php echo L('ADMIN_ADDONS_MANAGE');?></a></li>
        </ul>
        <form method="post" class="js-ajax-form">
            <?php $status=array("1"=>L('ENABLED'),"0"=>L('DISABLED'),"3"=>L('UNINSTALLED')); ?>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="120"><?php echo L('TEXT_DOMAIN');?></th>
                        <th width="150"><?php echo L('NAME');?></th>
                        <th width="150"><?php echo L('HOOKS');?></th>
                        <th><?php echo L('DESCRIPTION');?></th>
                        <th width="100"><?php echo L('AUTHOR');?></th>
                        <th width="60"><?php echo L('STATUS');?></th>
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
                        </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </form>    
    </div>
</body>
</html>