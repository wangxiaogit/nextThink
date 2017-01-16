<?php if (!defined('THINK_PATH')) exit();?><div class="well well-warning">
    <h2><?php echo ($addons_config["title"]); ?></h2>
    <p>
        <b>版本:</b>
        1.1
        &nbsp;&nbsp;&nbsp;
        <?php if(!empty($addons_config["new_version"])): ?><a href="http://www.onethink.cn" target="_blank">发现新版本[<?php echo ($addons_config["new_version"]); ?>]</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo U('/update/index');?>" target="_blank">在线更新</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo addons_url('DevTeam://DevTeam/detail?id=1');?>">Jump测试</a><?php endif; ?>
    </p>
    
    <p><b>服务器操作系统:</b><?php echo (PHP_OS); ?></p>
    
    <p><b>ThinkPHP版本:</b><?php echo (THINK_VERSION); ?></p>
    
    <p><b>运行环境:</b><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></p>
    
    <p>
        <b>MYSQL版本:</b>
        <?php $system_info_mysql = M()->query("select version() as v;"); ?>
        <?php echo ($system_info_mysql["0"]["v"]); ?>
    </p>
    
    <p>
        <b>上传限制:<?php echo ini_get('upload_max_filesize');?></b>
    </p>