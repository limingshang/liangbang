<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:62:"/web/ztcl/public/../application/admin/view/strategy/index.html";i:1564111356;s:49:"/web/ztcl/application/admin/view/layout/home.html";i:1560673080;s:58:"/web/ztcl/application/admin/view/strategy/index_title.html";i:1560564140;}*/ ?>
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
        
<div class="layui-tab layui-tab-card">
    <div class="layui-tab-title">
    <span class="layui-breadcrumb">
      <a href="<?php echo url('strategy/index'); ?>">半自动信号审核</a>
      <!--<a href="/demo/">演示</a>-->
      <!--<a><cite>导航元素</cite></a>-->
    </span>
    <div class="tool-btns">
        <a href="javascript:location.reload();" title="刷新当前页面" class="iconfont icon-reload"></i></a>
    </div>
</div>
<div class="layui-tab-title">
    <form method="get" action="<?php echo url('strategy/index'); ?>">
        <select name="review_status" id="review_status" class="mySelect" lay-filter="aihao">
            <option value="null">全部状态(3)</option>
            <option value="0">审核通过</option>
            <option value="1">待审核</option>
            <option value="2">被驳回</option>
        </select>
        <input type="text" name="strategy_info" class="myInput" value="<?php echo input('strategy_info'); ?>" placeholder = '策略名称/策略分类'>
        <button type="submit" class="layui-btn layui-btn-normal myButton">搜索</button>

        <!--<select class="rightSelect" lay-filter="aihao">-->
            <!--<option>默认排序</option>-->
            <!--<option value="0">排序条件1</option>-->
            <!--<option value="1">排序条件2</option>-->
            <!--<option value="2">排序条件3</option>-->
        <!--</select>-->
    </form>
</div>
<script>
    function set_select_checked(selectId, checkValue){
        var select = document.getElementById(selectId);
        for (var i = 0; i < select.options.length; i++){
            if (select.options[i].value == checkValue){
                select.options[i].selected = true;
                break;
            }
        }
    }
    set_select_checked("review_status", <?php echo input('review_status'); ?>);
</script>
    <div>

    </div>
    <div class="layui-tab-content page-tab-content">
        <table class="layui-table lay-even myTable">
            <colgroup>
                <col width="150">
                <col>
            </colgroup>
            <thead>
            <tr>
                <th style="text-align: center"><?php echo \think\Lang::get('policy_id'); ?></th>
                <th style="text-align: center"><?php echo \think\Lang::get('policy_title'); ?></th>
                <th><?php echo \think\Lang::get('policy_period'); ?></th>
                <th><?php echo \think\Lang::get('policy_type'); ?></th>

                <th><?php echo \think\Lang::get('policy_status'); ?></th>
                <th><?php echo \think\Lang::get('policy_handle'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($strategy_list) || $strategy_list instanceof \think\Collection || $strategy_list instanceof \think\Paginator): $key = 0; $__LIST__ = $strategy_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$strategy): $mod = ($key % 2 );++$key;?>
            <tr>
                <td style="text-align: center"><?php echo $key; ?></td>
                <td style="text-align: center"><?php echo $strategy['strategy_name']; ?></td>
                <td><?php echo (isset($strategy['periods_date']) && ($strategy['periods_date'] !== '')?$strategy['periods_date']: '--'); ?></td>
                <td>
                    <?php switch($strategy['strategy_type']): case "1": ?>
                            主题行业
                        <?php break; case "2": break; case "0": ?>
                            指数增强
                        <?php break; endswitch; ?></td>

                <td>
                    <?php switch($strategy['review_status']): case "1": ?><font color="#deb887">待审核</font><?php break; case "0": ?><font color="green">通过</font><?php break; case "2": ?><font color="#dc143c">驳回</font><?php break; case "3": ?>暂无此状态<?php break; default: ?><font color="#dc143c">驳回</font>{/case}
                    <?php endswitch; ?>
                <td><!--
                    <?php switch($strategy['review_status']): case "1": ?>
                        <a href="javascript:dsLayerOpen('<?php echo url('strategy/controstrategy',['id'=>$strategy['id'],'status'=>'2']); ?>')" class="layui-btn layui-btn-xs">驳回</a>
                        <a href="javascript:dsLayerConfirm('<?php echo url('strategy/controstrategy',['id'=>$strategy['id'],'status'=>'2']); ?>')" class="layui-btn layui-btn-xs">驳回</a>
                        <a href="javascript:dsLayerConfirm('<?php echo url('strategy/controstrategy',['id'=>$strategy['id'],'status'=>'0']); ?>')" class="layui-btn layui-btn-xs layui-btn-danger">通过</a>
                    <?php break; case "2": ?>已处理<?php break; case "0": ?>已处理<?php break; endswitch; ?>
                    -->
                <a href="<?php echo url('strategy/info',['id'=>$strategy['id']]); ?>">查看</a>
                </td>

            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <?php echo $show_page; ?>
    </div>
</div>
<script type="text/javascript" src="<?php echo ADMIN_SITE_ROOT; ?>/js/jquery.edit.js"></script>

    </body>
</html>



