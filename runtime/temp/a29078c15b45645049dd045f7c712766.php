<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:71:"/web/ztcl/public/../application/home/view/default/mall/index/index.html";i:1559461938;s:59:"/web/ztcl/application/home/view/default/base/base_home.html";i:1559461940;s:58:"/web/ztcl/application/home/view/default/base/mall_top.html";i:1559461940;s:61:"/web/ztcl/application/home/view/default/base/mall_header.html";i:1559461940;s:61:"/web/ztcl/application/home/view/default/base/mall_banner.html";i:1559461940;s:61:"/web/ztcl/application/home/view/default/base/mall_footer.html";i:1559461940;}*/ ?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo (isset($seo_title) && ($seo_title !== '')?$seo_title:''); ?></title>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta name="keywords" content="<?php echo (isset($seo_keywords) && ($seo_keywords !== '')?$seo_keywords:''); ?>" />
        <meta name="description" content="<?php echo (isset($seo_description) && ($seo_description !== '')?$seo_description:''); ?>" />
        <link rel="stylesheet" href="<?php echo HOME_SITE_ROOT; ?>/<?php echo $template_theme; ?>/styles/<?php echo $style_theme; ?>/css/common.css">
        <link rel="stylesheet" href="<?php echo HOME_SITE_ROOT; ?>/<?php echo $template_theme; ?>/styles/<?php echo $style_theme; ?>/css/home.css">
        <link rel="stylesheet" href="<?php echo PLUGINS_SITE_ROOT; ?>/font-awesome/css/font-awesome.min.css">
        <script type="text/javascript">
            var BASESITEROOT = "<?php echo BASE_SITE_ROOT; ?>";
            var BASESITEURL = "<?php echo BASE_SITE_URL; ?>";
            var HOMESITEURL = "<?php echo HOME_SITE_URL; ?>";
        </script>
        <script src="<?php echo BASE_SITE_ROOT; ?>/static/plugins/jquery-2.1.4.min.js"></script>
        <script src="<?php echo BASE_SITE_ROOT; ?>/static/plugins/layer/layer.js"></script>
        <script src="<?php echo BASE_SITE_ROOT; ?>/static/plugins/jquery.SuperSlide.2.1.1.js"></script>
        <script src="<?php echo HOME_SITE_ROOT; ?>/<?php echo $template_theme; ?>/styles/<?php echo $style_theme; ?>/js/common.js"></script>
    </head>
    <body>
<div class="blank115"></div>

<div class="header-top">
    <div class="w1200">
        <div class="top-link">欢迎来到德尚网络 DSCMS 企业网站</div>
<!--        <ul class="login-regin">
            <?php if(\think\Session::get('member_id')): ?>
            <li class="line"> <a href="<?php echo url('Member/index'); ?>"><?php echo \think\Session::get('member_name'); ?></a></li>
            <li> <a href="<?php echo url('Login/Logout'); ?>"><?php echo \think\Lang::get('exit'); ?></a></li>
            <?php else: ?>
            <li class="line"> <a href="<?php echo url('Login/login'); ?>"><?php echo \think\Lang::get('please_log'); ?></a></li>
            <li> <a href="<?php echo url('Login/register'); ?>"><?php echo \think\Lang::get('free_registration'); ?></a></li>
            <?php endif; ?>
        </ul>-->
        <span class="top-link">
            <strong style="margin-left:30px;"><?php echo \think\Lang::get('ds_attention'); ?>
                <a href="http://www.csdeshang.com" target="_blank">www.csdeshang.com</a><?php echo \think\Lang::get('ds_continuous_update'); ?>
            </strong>
            &nbsp;
            <?php echo \think\Lang::get('ds_qqgroup'); ?>
             <a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=1dcb185a87ceb15ca3736eee8d8b513a820bb56d2b7f47948bbdbd5132877e30"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="DSCMS开源官方群2" title="DSCMS开源官方群2"></a>
        </span>
    </div>
</div>
<div class="header">
    <div class="w1200">
        <div class="logo">
            <a href="<?php echo HOME_SITE_URL; ?>"><img src="<?php echo UPLOAD_SITE_URL; ?>/<?php echo ATTACH_COMMON; ?>/<?php echo \think\Config::get('site_logo'); ?>"/></a>
        </div>
        <ul class="nav">
            <li><a href="<?php echo HOME_SITE_URL; ?>">首页</a></li>
            <?php if(is_array($nav_header) || $nav_header instanceof \think\Collection || $nav_header instanceof \think\Paginator): $i = 0; $__LIST__ = $nav_header;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?>
            <li><a href="<?php echo $nav['nav_url']; ?>" <?php echo $nav['nav_new_open']; ?>><?php echo $nav['nav_title']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <li><a href="<?php echo url('Cases/search'); ?>">客户案例</a></li>
            <li><a href="<?php echo url('Product/search'); ?>">产品介绍</a></li>
            <li><a href="<?php echo url('News/search'); ?>">新闻资讯</a></li>
            <li><a href="<?php echo url('Job/index'); ?>">招贤纳士</a></li>
        </ul>
    </div>
</div>



<div class="index-focus-banner">
    <div class="bd">
        <ul>
            <?php $ap_id =1;$ad_position = db("advposition")->cache(3600)->column("ap_id,ap_name,ap_width,ap_height","ap_id");$result = db("adv")->where("ap_id=$ap_id  and adv_enabled = 1")->order("adv_order desc")->cache(36000)->limit("4")->select();
if(!in_array($ap_id,array_keys($ad_position)) && $ap_id)
{
  db("advposition")->insert(array(
         "ap_id"=>$ap_id,
         "ap_name"=>request()->module()."/".request()->controller()."/".request()->action()."页面自动增加广告位 $ap_id ",
  ));
  $ad_position[$ap_id]=array();
  \think\Cache::clear();  
}


$c = 4- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && input("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "adv_id" => 0,
          "adv_code" => "/public/images/not_adv.jpg",
          "adv_link" => ADMIN_SITE_URL."/Adv/adv_add/ap_id/$ap_id.html",
          "adv_title"   =>"暂无广告图片",
          "not_adv" => 1,
          "adv_target" => "_self",
          "ap_id"   =>$ap_id,
      );  
    }
}

foreach($result as $key=>$v):       

    $v["position"] = $ad_position[$v["ap_id"]]; 
    $v["adv_link"] = HOME_SITE_URL."/Advclick/Advclick/adv_id/".$v["adv_id"].".html";
    $v["adv_target"] = "_blank"; 
    if(input("get.edit_ad") && !isset($v["not_adv"]) )
    {
        
        $v["style"] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v["adv_link"] = ADMIN_SITE_URL."/Adv/adv_edit/adv_id/".$v['adv_id'].".html";
        $v["adv_title"] = $ad_position[$v["ap_id"]]["ap_name"]."===".$v["adv_title"];
        $v["adv_target"] = "_self";
        $v["adv_style"] = "filter:alpha(opacity=30); -moz-opacity:0.3; -khtml-opacity: 0.3; opacity: 0.3";
    }
    ?>
            <li>
                <a href="<?php echo $v['adv_link']; ?>" style="background-image: url(<?php echo get_adv_img($v['adv_code']); ?>);" target="_blank">&nbsp;</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="hd">
        <ul>
            <?php $ap_id =1;$ad_position = db("advposition")->cache(3600)->column("ap_id,ap_name,ap_width,ap_height","ap_id");$result = db("adv")->where("ap_id=$ap_id  and adv_enabled = 1")->order("adv_order desc")->cache(36000)->limit("4")->select();
if(!in_array($ap_id,array_keys($ad_position)) && $ap_id)
{
  db("advposition")->insert(array(
         "ap_id"=>$ap_id,
         "ap_name"=>request()->module()."/".request()->controller()."/".request()->action()."页面自动增加广告位 $ap_id ",
  ));
  $ad_position[$ap_id]=array();
  \think\Cache::clear();  
}


$c = 4- count($result); //  如果要求数量 和实际数量不一样 并且编辑模式
if($c > 0 && input("get.edit_ad"))
{
    for($i = 0; $i < $c; $i++) // 还没有添加广告的时候
    {
      $result[] = array(
          "adv_id" => 0,
          "adv_code" => "/public/images/not_adv.jpg",
          "adv_link" => ADMIN_SITE_URL."/Adv/adv_add/ap_id/$ap_id.html",
          "adv_title"   =>"暂无广告图片",
          "not_adv" => 1,
          "adv_target" => "_self",
          "ap_id"   =>$ap_id,
      );  
    }
}

foreach($result as $key=>$v):       

    $v["position"] = $ad_position[$v["ap_id"]]; 
    $v["adv_link"] = HOME_SITE_URL."/Advclick/Advclick/adv_id/".$v["adv_id"].".html";
    $v["adv_target"] = "_blank"; 
    if(input("get.edit_ad") && !isset($v["not_adv"]) )
    {
        
        $v["style"] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; // 广告半透明的样式
        $v["adv_link"] = ADMIN_SITE_URL."/Adv/adv_edit/adv_id/".$v['adv_id'].".html";
        $v["adv_title"] = $ad_position[$v["ap_id"]]["ap_name"]."===".$v["adv_title"];
        $v["adv_target"] = "_self";
        $v["adv_style"] = "filter:alpha(opacity=30); -moz-opacity:0.3; -khtml-opacity: 0.3; opacity: 0.3";
    }
    ?>
            <li class=""><a href="javascript:void(0)"></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <a href="javascript:void(0)" class="arrow prev"><</a>
    <a href="javascript:void(0)" class="arrow next">></a>
</div>
<script type="text/javascript">
    //首页轮播
    jQuery(".index-focus-banner").slide({mainCell: ".bd ul", autoPlay: true, delayTime: 3000});
</script>


<div class="w1200">
    <div class="index-cases clearfix">
        <div class="mt index-title">
            <h2>成功案例</h2>
            <p>国内最优秀的电商平台及相关系统服务商</p>
        </div>
        <div class="mc clearfix">
            <ul>
                <?php if(is_array($cases_list) || $cases_list instanceof \think\Collection || $cases_list instanceof \think\Paginator): if( count($cases_list)==0 ) : echo "" ;else: foreach($cases_list as $key=>$cases): ?>
                <li>
                    <a href="<?php echo url('cases/detail',['cases_id'=>$cases['cases_id']]); ?>" target="_blank">
                        <div class="p_img">
                            <img src="<?php echo get_cases_img($cases['cases_imgurl']); ?>"/>
                        </div>
                        <div class="p_name"><?php echo $cases['cases_title']; ?></div>
                    </a>
                </li>

                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>

<div class="w1200">
    <div class="index-product clearfix">
        <div class="mt index-title">
            <h2>热门产品</h2>
            <p>热门产品具体解释</p>
        </div>
        <div class="mc">
            <ul>
                <?php if(is_array($product_list) || $product_list instanceof \think\Collection || $product_list instanceof \think\Paginator): if( count($product_list)==0 ) : echo "" ;else: foreach($product_list as $key=>$product): ?>
                <li>
                    <a href="<?php echo url('product/detail',['product_id'=>$product['product_id']]); ?>" target="_blank">
                        <div class="p_img">
                            <img src="<?php echo get_product_img($product['product_imgurl']); ?>"/>
                        </div>
                        <div class="p_name"><?php echo $product['product_title']; ?></div>
                    </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>

<div class="index-article">
    <div class="w1200">
        <?php if(is_array($news_column) || $news_column instanceof \think\Collection || $news_column instanceof \think\Paginator): if( count($news_column)==0 ) : echo "" ;else: foreach($news_column as $key=>$column): ?>
        <div class="article-item clearfix">
            <div class="tit"><?php echo $column['column_name']; ?></div>
            <div class="blue-line"></div>
            <?php if(is_array($column['news_list']) || $column['news_list'] instanceof \think\Collection || $column['news_list'] instanceof \think\Paginator): if( count($column['news_list'])==0 ) : echo "" ;else: foreach($column['news_list'] as $hot_news=>$news): if($hot_news == 0): ?>
            <a class="top-new" href="<?php echo url('news/detail',['news_id'=>$news['news_id']]); ?>" target="_blank">
                <div class="new-img" style="background: url(<?php echo get_news_img($news['news_imgurl']); ?>) center center no-repeat;width: 373px;height: 170px;background-size:100%;"></div>
                <div class="top-txt">[<?php echo $column['column_name']; ?>] <?php echo $news['news_title']; ?></div>
            </a>
            <?php else: ?>
            <a class="other-ms-item" href="<?php echo url('news/detail',['news_id'=>$news['news_id']]); ?>" target="_blank">
                <div class="msg-con f_l">[<?php echo $column['column_name']; ?>] <?php echo $news['news_title']; ?></div>
                <div class="msg-date f_l"><?php echo date('m-d',$news['news_addtime']); ?></div>
            </a>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            <a href="<?php echo url('news/search',['column_id'=>$column['column_id']]); ?>" target="_blank" class="show-more-btn">查看更多</a>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>



<div class="footer-server clearfix">
    <div class="server w1200">
        <dl>
            <dt><a href="http://www.csdeshang.com" target="_blank">关于我们</a></dt>
            <dd><a href="http://www.csdeshang.com" target="_blank">公司简介</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
        </dl>
        <dl>
            <dt><a href="http://www.csdeshang.com" target="_blank">关于我们</a></dt>
            <dd><a href="http://www.csdeshang.com" target="_blank">公司简介</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
        </dl>
        <dl>
            <dt><a href="http://www.csdeshang.com" target="_blank">关于我们</a></dt>
            <dd><a href="http://www.csdeshang.com" target="_blank">公司简介</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
        </dl>
        <dl>
            <dt><a href="http://www.csdeshang.com" target="_blank">关于我们</a></dt>
            <dd><a href="http://www.csdeshang.com" target="_blank">公司简介</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
            <dd><a href="http://www.csdeshang.com" target="_blank">在线留言</a></dd>
        </dl>
        <dl>
            <dt>关注公众号</dt>
            <dd><img class="lazy" data-original="<?php echo UPLOAD_SITE_URL; ?>/<?php echo ATTACH_COMMON; ?>/<?php echo \think\Config::get('site_logowx'); ?>" width="120" style="display: inline-block;"></dd>
        </dl>
    </div>
    <div class="link w1200">
        <dl>
            <dt>友情链接:</dt>
            <dd>
                <?php if(is_array($link_list) || $link_list instanceof \think\Collection || $link_list instanceof \think\Paginator): $i = 0; $__LIST__ = $link_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$link): $mod = ($i % 2 );++$i;?>
                <a target="_blank" href="<?php echo $link['link_weburl']; ?>"><?php echo $link['link_webname']; ?></a>|
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </dd>
        </dl>
    </div>
</div>
<div class="footer clearfix">
    <div class="w1200">
        版权所有 <a href="http://www.csdeshang.com" target="_blank">德尚网络</a><br/>
        Powered by DSCMS 1.1.0 ©2008-2018  DSCMS Inc.
    </div>
</div>

<div class="common_right_fix">
    <ul>
        <li>
            <a href="javascript:;">在<br>线<br>客<br>服</a>
            <span>
                <h3>请咨询客服</h3>
                <a href="tencent://message/?uin=858761000&amp;Site=www.csdeshang.com&amp;Menu=yes">
                    <img border="0" src="http://pub.idqqimg.com/wpa/images/counseling_style_51.png" alt="点击这里给我发消息" title="点击这里给我发消息">&nbsp;&nbsp;德尚-售前
                </a>
                <a href="tencent://message/?uin=2931945788&amp;Site=www.csdeshang.com&amp;Menu=yes">
                    <img border="0" src="http://pub.idqqimg.com/wpa/images/counseling_style_51.png" alt="点击这里给我发消息" title="点击这里给我发消息">&nbsp;&nbsp;德尚-售前
                </a>
                <a href="tencent://message/?uin=181814630&amp;Site=www.csdeshang.com&amp;Menu=yes">
                    <img border="0" src="http://pub.idqqimg.com/wpa/images/counseling_style_51.png" alt="点击这里给我发消息" title="点击这里给我发消息">&nbsp;&nbsp;德尚-售后
                </a>
                <a href="tencent://message/?uin=2609394144&amp;Site=www.csdeshang.com&amp;Menu=yes">
                    <img border="0" src="http://pub.idqqimg.com/wpa/images/counseling_style_51.png" alt="点击这里给我发消息" title="点击这里给我发消息">&nbsp;&nbsp;德尚-售后
                </a>
            </span>
        </li>
        <li><a href="javascript:;"><br>咨<br>询<br>热<br>线</a><span><h3>咨询电话</h3><a>15364080101</a><a>13975846784</a></span></li>
    </ul>
</div>


<script src="<?php echo PLUGINS_SITE_ROOT; ?>/jquery.lazyload.min.js"></script>
<script>
    //懒加载
    $("img.lazy").lazyload({
        effect: "fadeIn"
    });
</script>
</body>
</html>