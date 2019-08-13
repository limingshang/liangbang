<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"/web/ztcl/public/../application/admin/view/strategy/strategy.html";i:1565688403;s:49:"/web/ztcl/application/admin/view/layout/home.html";i:1560673080;}*/ ?>
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
        
<form class="layui-form layui-form-pane" id="formSubmit" method="post">
    <div class="layui-tab layui-tab-card">
        <div class="layui-tab-content page-tab-content">
                <div class="layui-tab-item layui-show ">
                    <!--<div class="layui-form-item">-->
                        <!--<label class="layui-form-label">审核结果：</label>-->
                        <!--<div class="layui-input-block">-->
                            <!--<input type="radio" name="review_status" value="0" title="审核通过" checked="">-->
                            <!--<input type="radio" name="review_status" value="2" title="驳回">-->
                        <!--</div>-->
                    <!--</div>-->
                    <input type="hidden" name="review_status" id = 'review_status' value="0">
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">备注</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入内容" class="layui-textarea" name="review_describe"></textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <?php if(($strategyInfo['review_status'] == 0)): ?>
                                <input type="button" class="layui-btn layui-btn-disabled" disabled = 'true' lay-submit value="审核通过" style="width: 110px" />
                                <input type="button" class="layui-btn layui-btn-normal" onclick="submitForm(2)" style="width: 110px" lay-submit value="驳回" />
                                <?php elseif($strategyInfo['review_status'] == 2): ?>
                                <input type="button" class="layui-btn layui-btn-normal" onclick="submitForm(1)" style="width: 110px" lay-submit value="审核通过" />
                                <input type="button" class="layui-btn layui-btn-disabled" disabled="true" style="width: 110px" lay-submit value="驳回" />
                                <?php else: ?>
                                <input type="button" class="layui-btn layui-btn-normal" onclick="submitForm(1)" style="width: 110px" lay-submit value="审核通过" />
                                <input type="button" class="layui-btn layui-btn-normal" onclick="submitForm(2)" style="width: 110px" lay-submit value="驳回" />

                            <?php endif; ?>


                        </div>
                    </div>
                </div>
        </div>
    </div>
</form>
<script>
    function submitForm(review_status)
    {
        $("#review_status").val(review_status);
        $("#formSubmit").submit();
    }
    layui.use('form', function() {
        var form = layui.form;
    });
</script>

    </body>
</html>



