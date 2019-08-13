<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"/web/ztcl/public/../application/admin/view/strategy/info.html";i:1565687853;s:49:"/web/ztcl/application/admin/view/layout/home.html";i:1560673080;s:57:"/web/ztcl/application/admin/view/strategy/info_title.html";i:1560820498;}*/ ?>
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
        
<form class="layui-form Myinfo" method="post" enctype="multipart/form-data">
    <div class="layui-tab layui-tab-card">
        <div class="layui-tab-title">
    <span class="layui-breadcrumb" lay-separator=">">
      <a href="<?php echo url('strategy/index'); ?>">半自动信号审核</a> >
      <a>策略详情</a>
    </span>
    <div class="tool-btnss myOpenFile">
        <a href="javascript:dsLayerOpen('<?php echo url('strategy/strategy',['id'=>$strategy_info['id']]); ?>','审核')" class="layui-btn layui-btn-xs"><i class="layui-icon layui-icon-edit"></i>审核</a>
    </div>
</div>

        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show ">
                <div class="layui-collapse">
                    <div class="layui-colla-item">
                        <div class="layui-colla-content layui-show">
                            <div class="my_black">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">策略名称：</label>
                                    <div class="layui-input-block">
                                        <span class="my_label"><?php echo $strategy_info['strategy_name']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="my_black">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">审核状态：</label>
                                    <div class="layui-input-block">
                                        <span class="my_label">
                                            <?php switch($strategy_info['review_status']): case "1": ?><font color="#deb887">待审核</font><?php break; case "0": ?><font color="green">通过</font><?php break; case "2": ?><font color="#dc143c">驳回</font><?php break; endswitch; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="my_black">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">策略ID：</label>
                                    <div class="layui-input-block">
                                        <span class="my_label"><?php echo $strategy_info['strategy_id']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="my_black">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">更新时间：</label>
                                    <div class="layui-input-block">
                                        <span class="my_label"><?php echo $strategy_info['update_time']; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item"></div>
                        </div>
                    </div>
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">策略详情</h2>
                        <div class="layui-colla-content layui-show">
                            <div class="my_black_two">
                                <p class="p1">实盘收益率</p>
                                <p class="p2">
                                    <?php if(strtoupper($strategy_info['real_ratio']) < 0): ?>
                                        <font color="green"><?php echo $strategy_info['real_ratio']; ?>%</font>
                                    <?php else: ?>
                                        <font color="#dc143c"><?php echo $strategy_info['real_ratio']; ?>%</font>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">年化收益率</p>
                                <p class="p2">
                                    <?php if(strtoupper($strategy_info['annualized_ratio']) < 0): ?>
                                    <font color="green"><?php echo $strategy_info['annualized_ratio']; ?>%</font>
                                    <?php else: ?>
                                    <font color="#dc143c"><?php echo $strategy_info['annualized_ratio']; ?>%</font>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">年化波动率</p>
                                <p class="p2">
                                    <?php if(strtoupper($strategy_info['annualized_volatility']) < 0): ?>
                                    <font color="green"><?php echo $strategy_info['annualized_volatility']; ?>%</font>
                                    <?php else: ?>
                                    <font color="#dc143c"><?php echo $strategy_info['annualized_volatility']; ?>%</font>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">月度利润率</p>
                                <p class="p2">
                                    <?php if(strtoupper($strategy_info['profit_ratio_monthly']) < 0): ?>
                                    <font color="green"><?php echo $strategy_info['profit_ratio_monthly']; ?>%</font>
                                    <?php else: ?>
                                    <font color="#dc143c"><?php echo $strategy_info['profit_ratio_monthly']; ?>%</font>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">年化超额收益率</p>
                                <p class="p2">
                                    <?php if(strtoupper($strategy_info['sharpe_ratio']) < 0): ?>
                                    <font color="green"><?php echo $strategy_info['sharpe_ratio']; ?>%</font>
                                    <?php else: ?>
                                    <font color="#dc143c"><?php echo $strategy_info['sharpe_ratio']; ?>%</font>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">策略状态</p>
                                <p class="p2">
                                    <?php switch($strategy_info['strategy_status']): case "1": ?><font color="green">上架</font><?php break; case "0": ?><font color="red">下架</font><?php break; endswitch; ?></p>
                            </div>
                            <div class="layui-form-item"></div>

                            <div class="my_black_two">
                                <p class="p1">当日收益率</p>
                                <p class="p2">
                                    <?php if(strtoupper($strategy_info['daily_ratio']) < 0): ?>
                                    <font color="green"><?php echo $strategy_info['daily_ratio']; ?>%</font>
                                    <?php else: ?>
                                    <font color="#dc143c"><?php echo $strategy_info['daily_ratio']; ?>%</font>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">当日净值</p>

                                <p class="p2"><?php echo $strategy_info['net_value']; ?></p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">标的指数</p>
                                <p class="p2"><?php echo $strategy_info['sub_index']; ?></p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">调仓周期</p>
                                <p class="p2"><?php echo (isset($strategy_info['adjust_cycle']) && ($strategy_info['adjust_cycle'] !== '')?$strategy_info['adjust_cycle']: '--'); ?></p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">持仓证券数量</p>
                                <p class="p2"><?php echo (isset($strategy_info['hold_secu_num']) && ($strategy_info['hold_secu_num'] !== '')?$strategy_info['hold_secu_num']: '--'); ?>只</p>
                            </div>
                            <div class="my_black_two">
                                <p class="p1">最新净值日期</p>
                                <p class="p2"><?php echo (isset($strategy_info['net_value_date']) && ($strategy_info['net_value_date'] !== '')?$strategy_info['net_value_date']: '--'); ?></p>
                            </div>
                            <div class="layui-form-item"></div>
                        </div>
                    </div>
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title">策略简介</h2>
                        <div class="layui-colla-content layui-show">
                            <div class="my_black_three">
                                <p>
                                    <?php echo (isset($strategy_info['strategy_describe']) && ($strategy_info['strategy_describe'] !== '')?$strategy_info['strategy_describe']: '--'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="layui-form-item"></div>
                    </div>
                    <div class="layui-colla-item">
                        <div class="myDqtc">
                            <span class="dqtc">调仓信息 &nbsp;&nbsp;<i id="isTC"></i><i id="isNew"></i></span>
                            <div class="layui-inline">
                                <label class="layui-form-label">历史调仓</label>
                                <div class="layui-input-inline">
                                    <select name="modules" lay-verify="required" lay-search="" id = 'dataReload'  lay-filter="modules">
                                        <?php if(is_array($periods_date_list) || $periods_date_list instanceof \think\Collection || $periods_date_list instanceof \think\Paginator): $i = 0; $__LIST__ = $periods_date_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$periods_date): $mod = ($i % 2 );++$i;?>
                                            <option value="<?php echo $periods_date; ?>"><?php echo $periods_date; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>

                                </div>
                                <input type="button" class="layui-btn" data-type="reload" value="搜索">
                            </div>
                        </div>

                        <div class="layui-colla-content layui-show">
                            <table class="layui-hide" id="test"></table>
                            <script type="text/html" id="trade_direction">
                                {{#  if(d.trade_direction == '买入'){ }}
                                <span style="color: red;">{{ d.trade_direction }}</span>
                                {{#  } else if(d.trade_direction == '卖出') { }}
                                <span style="color: green;">{{ d.trade_direction }}</span>
                                {{#  } else{ }}
                                {{ d.trade_direction }}
                                {{#  } }}
                            </script>
                            <script type="text/html" id="adjust_num">
                                {{#  if(d.trade_direction == '买入'){ }}
                                <span style="color: red;">{{ d.adjust_num }}</span>
                                {{#  } else if(d.trade_direction == '卖出') { }}
                                <span style="color: green;">{{ d.adjust_num }}</span>
                                {{#  } else{ }}
                                {{ d.adjust_num }}
                                {{#  } }}
                            </script>
                        </div>
                        <div class="layui-form-item"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    /**
     * Layer 通用ifram弹出窗口
     */
    function dsLayerOpen(url, title,width,height) {
        if (!width)	width = '50%';
        if (!height) height = '40%';
        layer.open({
            type: 2,
            title: title,
            area: [width,height],
            fixed: true, //不固定
            content: url
        });
    }
    layui.use('laydate', function () {
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
            elem: '#news_addtime' //指定元素
        });
    });
</script>

<script>
    layui.use('form', function () {
        var form = layui.form;
    });

    layui.use('laydate', function(){
        var laydate = layui.laydate;
        laydate.render({
            elem: '#news_addtime'
        });
    });


</script>
<script>
    layui.use('table', function(){
        var table = layui.table;
        //方法级渲染
        table.render({
            elem: '#test'
            ,url: "<?php echo url('strategy/getStrategyHold', ['strategy_id'=>$strategy_info['strategy_id']]); ?>"
            ,cols: [[
                {field: 'id', title: '序号', style:'text-align: center;'}
                , {field: 'secu_name', title: '证券名称', style:'text-align: center;'}
                , {field: 'secu_code', title: '证券代码', style:'text-align: center;'}
                , {field: 'pre_hold', title: '调整前持仓', style:'text-align: center;'}
                , {field: 'adjust_num', title: '当期调整手数', style:'text-align: center;', templet: '#adjust_num'}
                , {field: 'trade_direction', title: '买卖方向', templet: '#trade_direction', style:'text-align: center;'}
                , {field: 'adjust_hold', title: '调整后持仓', style:'text-align: center;'}
            ]]
            ,id: 'test'
            ,page: false
            ,height:500
        });

        var $ = layui.$, active = {
            reload: function(){
                var dataReload = $('#dataReload');
                if(dataReload.val()) {
                    checkIsNew(dataReload.val());
                    //执行重载
                    table.reload('test', {
                        where: {
                            periods_date:dataReload.val()
                        }
                    }, 'data');
                }

            }
        };

        $('.layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
<script>
    function checkIsNew(nowData){
        if(nowData == <?php echo $periods_date_list[0]; ?>) {
            $("#isNew").html('（最新持仓）');
            $("#isTC").html(nowData);
        } else {
            $("#isNew").html('');
            $("#isTC").html(nowData);
        }
    }
    <?php if($periods_date_list[0]): ?>
        checkIsNew("<?php echo $periods_date_list[0]; ?>");
    <?php endif; ?>

</script>

    </body>
</html>



