<?php

namespace app\admin\controller;

use think\Log;
use think\View;
use think\Lang;
use think\Validate;

class Monitor extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/strategy.lang.php');
    }

    /**
     * 审核首页
     * @return mixed
     */
    public function index() {
        echo '';die;
    }
}
