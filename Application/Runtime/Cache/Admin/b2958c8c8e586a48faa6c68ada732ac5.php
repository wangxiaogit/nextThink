<?php if (!defined('THINK_PATH')) exit();?>
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