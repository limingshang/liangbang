<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:61:"/web/ztcl/public/../application/admin/view/index/welcome.html";i:1559467958;s:49:"/web/ztcl/application/admin/view/layout/home.html";i:1560673080;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo PLUGINS_SITE_ROOT; ?>/layui/css/layui.css">
        <link rel="stylesheet" href="<?php echo ADMIN_SITE_ROOT; ?>/css/admin.css">
        <link rel="stylesheet" href="<?php echo ADMIN_SITE_ROOT; ?>/iconfont/iconfont.css">
        <script src="<?php echo PLUGINS_SITE_ROOT; ?>/jquery-2.1.4.min.js"></script>
        <script src="<?php echo ADMIN_SITE_ROOT; ?>/js/admin.js"></script>
        <script type="text/javascript" src="<?php echo PLUGINS_SITE_ROOT; ?>/layui/layui.js"></script>
        <script type="text/javascript">
            var BASESITEROOT = "<?php echo BASE_SITE_ROOT; ?>";
            var ADMINSITEROOT = "<?php echo ADMIN_SITE_ROOT; ?>";
            var BASESITEURL = "<?php echo BASE_SITE_URL; ?>";
            var HOMESITEURL = "<?php echo HOME_SITE_URL; ?>";
            var ADMINSITEURL = "<?php echo ADMIN_SITE_URL; ?>";
            layui.use('layer', function () {
                var layer = layui.layer;
            });
        </script>
    </head>
    <body>
        
<div class="layui-tab-content page-tab-content">
    <h1><?php echo \think\Lang::get('wel_sys_info'); ?></h1>
    <table class="layui-table lay-even">
        <colgroup>
            <col width="300">
            <col width="530">
        </colgroup>
        <tbody>
        <tr>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_thinkphp_version'); ?></td>
            <td><?php echo THINK_VERSION; ?></td>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_class_library_file_suffix'); ?></td>
            <td><?php echo EXT; ?></td>
        </tr>
        <tr>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_server_os'); ?></td>
            <td><?php echo $statistics['os']; ?></td>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_server_domain_ip'); ?></td>
            <td><?php echo $statistics['domain']; ?> [ <?php echo $statistics['ip']; ?> ]</td>
        </tr>
        <tr>
            <td class="gray_bg">WEB <?php echo \think\Lang::get('wel_server'); ?></td>
            <td><?php echo $statistics['web_server']; ?></td>
            <td class="gray_bg">PHP <?php echo \think\Lang::get('wel_version'); ?></td>
            <td><?php echo $statistics['php_version']; ?></td>
        </tr>
        <tr>
            <td class="gray_bg">MYSQL <?php echo \think\Lang::get('wel_version'); ?></td>
            <td><?php echo $statistics['sql_version']; ?></td>
            <td class="gray_bg">GD <?php echo \think\Lang::get('wel_version'); ?></td>
            <td><?php echo $statistics['gdinfo']; ?></td>
        </tr>
        <tr>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_file_uplode_limit'); ?></td>
            <td><?php echo $statistics['fileupload']; ?></td>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_max_occupied_memory'); ?></td>
            <td><?php echo $statistics['memory_limit']; ?></td>
        </tr>
        <tr>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_max_ex_time'); ?></td>
            <td><?php echo $statistics['max_ex_time']; ?></td>
            <td class="gray_bg"><?php echo \think\Lang::get('wel_safe_mode'); ?></td>
            <td><?php echo $statistics['safe_mode']; ?></td>
        </tr>
        <tr>
            <td class="gray_bg">Zlib <?php echo \think\Lang::get('wel_support'); ?></td>
            <td><?php echo $statistics['zlib']; ?></td>
            <td class="gray_bg">Curl <?php echo \think\Lang::get('wel_support'); ?></td>
            <td><?php echo $statistics['curl']; ?></td>
        </tr>
        </tbody>
    </table>
</div>


    </body>
</html>



