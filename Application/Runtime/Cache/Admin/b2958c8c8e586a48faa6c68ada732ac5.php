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
    

<style>
li {
	list-style: none;
}
</style>
</head>
<body>
    <div class="wrap">
        <div id="error_tips">
            <h2><?php echo ($msgTitle); ?></h2>
            <div class="error_cont">
                <ul>
                    <li><?php echo ($error); ?></li>
                </ul>
                <div class="error_return">
                    <a href="<?php echo ($jumpUrl); ?>" class="btn">返回</a>
                </div>
            </div>
        </div>
    </div>
<script src="/nexTthink1/Public/Static/common.js"></script>
<script>
        setTimeout(function() {
                location.href = '<?php echo ($jumpUrl); ?>';
        }, 3000);
</script>
</body>
</html>