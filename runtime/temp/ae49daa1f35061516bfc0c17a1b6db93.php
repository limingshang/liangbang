<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"/web/ztcl/public/../application/admin/view/index/index.html";i:1565142020;}*/ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>审核系统</title>
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
    </script>
</head>
<body style="min-width: 1280px; max-width: 1400px; padding: 0; margin: auto;">
<style type="text/css">
    .layui-tab {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        z-index: 10;
        margin: 0;
        border: none;
        overflow: hidden;
    }

    .layui-tab-content {
        padding: 0 0 0 10px;
        height: 100%;
    }

    .layui-tab-item {
        height: 100%;
    }
</style>
<div class="admincp-header">
    <div class="logo">
        <img width="200" src="<?php echo ADMIN_SITE_ROOT; ?>/images/backlogo.png"/>
    </div>
    <div class="navbar">
        <ul class="fr" style="float:right" id="nav">
            <li><span><?php echo \think\Lang::get('ds_shalom'); ?>,<?php echo \think\Session::get('admin_name'); ?></span></li>
            <!--<li><a href="javascript:dsLayerOpen('<?php echo url('Index/modifypw'); ?>','<?php echo \think\Lang::get('ds_change_password'); ?>')"><?php echo \think\Lang::get('ds_change_password'); ?></a></li>-->
            <!--<li><a href="javascript:dsLayerConfirm('<?php echo url('Index/clear'); ?>','<?php echo \think\Lang::get('ds_clear_cache_confirm'); ?>')"><?php echo \think\Lang::get('ds_clear_cache'); ?></a></li>-->
            <!--<li><a href="<?php echo url('Home/index/index'); ?>" target="_blank"><?php echo \think\Lang::get('ds_visit_home'); ?></a></li>-->
            <li><a href="<?php echo url('Login/logout'); ?>"><?php echo \think\Lang::get('ds_safe_withdrawing'); ?></a></li>
            <!--<li class="treeview">-->
                <!--<span id="nav1"><?php echo \think\Lang::get('ds_language_switch'); ?><?php echo \think\Cookie::get('language'); ?></span>-->
                <!--<ul style="display:none;" id="nav2">-->
                    <!--<?php if(is_array($language_list) || $language_list instanceof \think\Collection || $language_list instanceof \think\Paginator): if( count($language_list)==0 ) : echo "" ;else: foreach($language_list as $key=>$language): ?>-->
                    <!--<li class="nav-style">-->
                        <!--<a href="<?php echo url('Index/setLanguageCookie',['language'=>$language['lang_mark']]); ?>"><?php echo $language['lang_name']; ?></a>-->
                    <!--</li>-->
                    <!--</br>-->
                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                <!--</ul>-->
            <!--</li>-->
        </ul>
    </div>
</div>
<div class="admincp-container">
    <div class="admincp-container-left">
        <ul class="sidebar-menu" id="gloMenu">
            <?php if(is_array($menu_list) || $menu_list instanceof \think\Collection || $menu_list instanceof \think\Paginator): if( count($menu_list)==0 ) : echo "" ;else: foreach($menu_list as $fe_menu=>$menu): ?>
            <li class="treeview">
                <div class="title" id="navT"><i class="iconfont icon-<?php echo $fe_menu; ?>"></i><span> <?php echo $menu['text']; ?></span></div>
                <ul class="treeview-menu" id="navC" style="display:none;">
                    <?php if(is_array($menu['children']) || $menu['children'] instanceof \think\Collection || $menu['children'] instanceof \think\Paginator): if( count($menu['children'])==0 ) : echo "" ;else: foreach($menu['children'] as $fe_submenu=>$submenu): ?>
                    <li><a data-id="<?php echo $fe_menu; ?>-<?php echo $fe_submenu; ?>" href="<?php echo $submenu['url']; ?>" class="admin-nav-item"><?php echo $submenu['text']; ?></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>

    <div class="admincp-container-right">
        <div class="layui-tab layui-tab-card" lay-filter="dsTab" lay-allowclose="true">
            <ul class="layui-tab-title">
                <li class="layui-this" lay-id="0">
                    <cite><?php echo \think\Lang::get('ds_welcome'); ?></cite>
                </li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe lay-id="0" src="<?php echo url('Index/welcome'); ?>" width="100%" height="100%" frameborder="0" scrolling="yes"></iframe>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    layui.use(['jquery', 'element', 'layer'], function () {
        var $ = layui.jquery, element = layui.element, layer = layui.layer;
        $('.layui-tab-content').height($(window).height() - 120);
        var tab = {
            add: function (title, url, id) {
                element.tabAdd('dsTab', {
                    title: title,
                    content: '<iframe width="100%" height="100%" lay-id="' + id + '" frameborder="0" src="' + url + '" scrolling="yes" class="x-iframe"></iframe>',
                    id: id
                });
            }, change: function (id) {
                element.tabChange('dsTab', id);
            }
        };
        $('.admin-nav-item').click(function (event) {
            var that = $(this);
            if ($('iframe[src="' + that.attr('href') + '"]')[0]) {
                tab.change(that.attr('data-id'));
                var dataName  = that.attr('data-id');
                $("iframe[lay-id='"+dataName+"']").attr('src', $("iframe[lay-id='"+dataName+"']").attr('src'));
                event.stopPropagation();
                return false;
            }
            if ($('iframe').length == 20) {
                layer.msg('最多可打开20个标签页');
                return false;
            }
            that.css({color: '#fff'});
            tab.add(that.text(), that.attr('href'), that.attr('data-id'));
            tab.change(that.attr('data-id'));
            event.stopPropagation();
            return false;
        });
        $(document).on('click', '.layui-tab-close', function () {
            $('.layui-nav-child a[data-id="' + $(this).parent('li').attr('lay-id') + '"]').css({color: 'rgba(255,255,255,.7)'});
        });
    });
    $('#gloMenu').on('click', '#navT', function () {
        var parent = $(this).closest('li');
        var index = parent.index();
        if (parent.find('#navC').find('li').length) {
            if (parent.hasClass('open')) {
                parent.find('#navC').stop(true).slideUp(300, function () {
                    parent.removeClass('open')
                });
            } else {
                var openLi = $('.sidebar-menu').find('li.open');
                openLi.removeClass('open').find('#navC').stop(true).slideUp(300);
                parent.addClass('open').find('#navC').stop(true).slideDown(300);
            }
        }
    })
    $('#nav').on('click', '#nav1', function () {
        var parent = $(this).closest('li');
        var index = parent.index();
        if (parent.find('#nav2').find('li').length) {
            if (parent.hasClass('open')) {
                parent.find('#nav2').stop(true).slideUp(300, function () {
                    parent.removeClass('open')
                });
            } else {
                var openLi = $('.sidebar-menu').find('li.open');
                openLi.removeClass('open').find('#nav2').stop(true).slideUp(300);
                parent.addClass('open').find('#nav2').stop(true).slideDown(300);
            }
        }
    })
</script>
</body>


</html>



