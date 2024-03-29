<?php

namespace app\admin\controller;

use think\Controller;
use think\Lang;

class AdminControl extends Controller
{

    /**
     * 管理员资料 name id group
     */
    protected $admin_info;

    public function _initialize()
    {
        if (time() - session('session_start_time') > 60*60) {
            session_destroy();//真正的销毁在这里！
            $this->redirect('/Admin/login/index',302);
        }
        if (in_array(cookie('ds_admin_lang'), array('zh-cn', 'en-us'))) {
            config('default_lang', cookie('ds_admin_lang'));
        }
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '.php');
        $this->admin_info = $this->systemLogin();
        if ($this->admin_info['admin_id'] != 1) {
            // 验证权限
//            $this->checkPermission();
        }
        $this->setMenuList();
        $this->getlanguageList();
    }

    /**
     * 取得当前管理员信息
     *
     * @param
     * @return 数组类型的返回结果
     */
    protected final function getAdminInfo()
    {
        return $this->admin_info;
    }

    /**
     * 系统后台登录验证
     *
     * @param
     * @return array 数组类型的返回结果
     */
    protected final function systemLogin()
    {
        $admin_info = array(
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'admin_group_id' => session('admin_group_id'),
            'admin_is_super' => session('admin_is_super'),
        );
        if (empty($admin_info['admin_id']) || empty($admin_info['admin_name']) || !isset($admin_info['admin_group_id']) || !isset($admin_info['admin_is_super'])) {
            $this->redirect('Admin/Login/index');
        }

        return $admin_info;
    }

    /**
     * 侧边栏
     */
    public function setMenuList()
    {
        $menu_list = $this->menuList();
        $this->assign('menu_list', $menu_list);
    }

    /**
     * 当前选中的栏目
     */
    protected function setAdminCurItem($curitem = '')
    {
        $this->assign('admin_item', $this->getAdminItemList());
        $this->assign('curitem', $curitem);
    }

    /**
     * 获取语言列表
     */
    public function getlanguageList()
    {
        $languageList = db('lang')->where('lang_useok', 1)->select();
        $this->assign('language_list', $languageList);
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList()
    {
        return array();
    }

    /**
     * 侧边栏列表
     */
    function menuList()
    {
        return array(
//            'dashboard_manage' => array(
//                'name' => 'dashboard_manage',
//                'text' => lang('ds_dashboard_manage'),
//                'children' => array(
//                    'welcome' => array(
//                        'text' => lang('ds_welcome'), 'url' => url('Index/welcome'),
//                    ),
//                ),
//            ),
//            'setting_manage' => array(
//                'name' => 'setting_manage',
//                'text' => lang('ds_setting_manage'),
//                'children' => array(
//                    'config' => array(
//                        'text' => lang('ds_config'),
//                        'url' => url('Config/index'),
//                    ),
//                    'db' => array(
//                        'text' => lang('ds_db'),
//                        'url' => url('Db/index'),
//                    ),
//                    'adminlog' => array(
//                        'text' => lang('ds_adminlog'),
//                        'url' => url('Adminlog/index'),
//                    ),
//                    'theme' => array(
//                        'text' => lang('ds_theme'),
//                        'url' => url('Theme/index'),
//                    ),
//                ),
//            ),


            'content_manage' => array(
                'name' => 'content_manage',
                'text' => lang('ds_content_manage'),
                'children' => array(
//                    'column' => array(
//                        'text' => lang('ds_column'),
//                        'url' => url('Column/index'),
//                    ),
//                    'news' => array(
//                        'text' => lang('ds_news'),
//                        'url' => url('News/index'),
//                    ),
                    'strategy' => array(
                        'text' => lang('ds_strategy'),
                        'url' => url('Strategy/index'),
                    ),
                    'monitor' => array(
                        'text' => lang('ds_monitor'),
                        'url' => url('Monitor/index'),
                    ),
                    'handelLog' => array(
                        'text' => lang('ds_handellog'),
                        'url' => url('Handellog/index'),
                    ),
//                    'product' => array(
//                        'text' => lang('ds_product'),
//                        'url' => url('Product/index'),
//                    ),
//                    'cases' => array(
//                        'text' => lang('ds_cases'),
//                        'url' => url('Cases/index'),
//                    ),
//                    'adv' => array(
//                        'text' => lang('ds_adv'),
//                        'url' => url('Adv/adv_manage'),
//                    ),
                ),
            ),
//            'operation_manage' => array(
//                'name' => 'operation_manage',
//                'text' => lang('ds_operation_manage'),
//                'children' => array(
//                    'message' => array(
//                        'text' => lang('ds_message'),
//                        'url' => url('Message/index'),
//                    ),
//                    'job' => array(
//                        'text' => lang('ds_job'),
//                        'url' => url('Job/index'),
//                    ),
//                    'jobcv' => array(
//                        'text' => lang('ds_jobcv'),
//                        'url' => url('Jobcv/index'),
//                    ),
//                    'link' => array(
//                        'text' => lang('ds_link'),
//                        'url' => url('Link/index'),
//                    ),
//                    'navigation' => array(
//                        'text' => lang('ds_nav'),
//                        'url' => url('Navigation/index'),
//                    ),
//                ),
//            ),
            'personnel_manage' => array(
                'name' => 'personnel_manage',
                'text' => lang('ds_personnel_manage'),
                'children' => array(
                    'member' => array(
                        'text' => lang('ds_member'),
                        'url' => url('Member/index'),
                    ),
                    'admin' => array(
                        'text' => lang('ds_admin'),
                        'url' => url('Admin/index'),
                    ),
                    'admingroup' => array(
                        'text' => lang('ds_admin_group'),
                        'url' => url('Admingroup/index'),
                    ),
                ),
            ),
            /*
            'wechat_manage' => array(
                'name' => 'wechat_manage',
                'text' => lang('ds_wechat_manage'),
                'children' => array(
                    'wechat_setting' => array(
                        'text' => lang('ds_wechat_setting'), 'url' => url('Wechat/setting'),
                    ),
                    'wechat_menu' => array(
                        'text' => lang('ds_wechat_menu'), 'url' => url('Wechat/menu'),
                    ),
                    'wechat_keywords' => array(
                        'text' => lang('ds_wechat_keywords'), 'url' => url('Wechat/keywords'),
                    ),
                    'wechat_member' => array(
                        'text' => lang('ds_wechat_member'), 'url' => url('Wechat/member'),
                    ),
                    'wechat_push' => array(
                        'text' => lang('ds_wechat_push'), 'url' => url('Wechat/SendList'),
                    ),
                ),
            ),
             */
            
        );
    }

    /**
     * 记录系统日志
     *
     * @param $lang 日志语言包
     * @param $state 1成功0失败null不出现成功失败提示
     * @param $admin_name
     * @param $admin_id
     */
    protected final function log($lang = '', $state = 1, $admin_name = '', $admin_id = 0)
    {
        if ($admin_name == '') {
            $admin_name = session('admin_name');
            $admin_id = session('admin_id');
        }
        $data = array();
        if (is_null($state)) {
            $state = null;
        } else {
            $state = $state ? '' : lang('nc_fail');
        }
        $data['content'] = $lang . $state;
        $data['admin_name'] = $admin_name;
        $data['createtime'] = TIMESTAMP;
        $data['admin_id'] = $admin_id;
        $data['ip'] = request()->ip();
        $data['url'] = request()->controller() . '&' . request()->action();
        $data['lang'] = config('default_lang');
        return db('adminlog')->insertGetId($data);
    }
}

?>
