<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"/web/ztcl/public/../application/admin/view/login/index.html";i:1564968952;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>审核管理系统</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo PLUGINS_SITE_ROOT; ?>/layui/css/layui.css">
    <link rel="stylesheet" href="<?php echo ADMIN_SITE_ROOT; ?>/css/admin.css">
    <script src="<?php echo PLUGINS_SITE_ROOT; ?>/jquery-2.1.4.min.js"></script>
    <script src="<?php echo ADMIN_SITE_ROOT; ?>/js/admin.js"></script>
    <link rel="stylesheet" href="<?php echo PLUGINS_SITE_ROOT; ?>/font-awesome/css/font-awesome.min.css">
    <script type="text/javascript">
        var BASESITEROOT = "<?php echo BASE_SITE_ROOT; ?>";
        var ADMINSITEROOT = "<?php echo ADMIN_SITE_ROOT; ?>";
        var BASESITEURL = "<?php echo BASE_SITE_URL; ?>";
        var HOMESITEURL = "<?php echo HOME_SITE_URL; ?>";
        var ADMINSITEURL = "<?php echo ADMIN_SITE_URL; ?>";
    </script>
</head>
<body style="background-image:url(<?php echo ADMIN_SITE_ROOT; ?>/wallpage/bg_<?php echo rand(0,8)?>.jpg);background-size: cover;">
<div class="login">
    <div class="login_body">
        <div class="login_header">
            <img src="<?php echo ADMIN_SITE_ROOT; ?>/images/logo.png"/>
        </div>
        <div class="login_content">
            <form method="post">
                <div class="form-group">
                    <input type="text" name="admin_name" placeholder="<?php echo lang('login_admin_name'); ?>" required class="text">
                </div>
                <div class="form-group">
                    <input type="password" name="admin_password" placeholder="<?php echo lang('login_admin_password'); ?>" required class="text">
                </div>
                <div class="form-group">
                    <input type="submit" class="layui-btn" value="<?php echo lang('login_sumbit'); ?>" lay-submit lay-filter="login"/>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#change_captcha').click(function () {
        $(this).attr('src', '<?php echo captcha_src(); ?>?'+(new Date().getTime()));
    });
    //判断是否在iframe中
    if(self!=top){
        parent.window.location.replace(window.location.href);
    }
</script>
</body>
</html>