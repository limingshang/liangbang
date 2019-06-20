<?php

namespace app\admin\controller;

use think\Log;
use think\View;
use think\Lang;
use think\Validate;

class Handellog extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/strategy.lang.php');
    }

    /**
     * 审核首页
     * @return mixed
     */
    public function index() {
        $handelLog = model('handelLog');
        $condition = [];
        $handelLogList = $handelLog->getHandelLogValueList($condition, '', '*', 20);
        $this->assign('handelLogList', $handelLogList);
        $this->assign('show_page', $handelLog->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }
}
