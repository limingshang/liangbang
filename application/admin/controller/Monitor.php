<?php

namespace app\admin\controller;

use app\common\model\DailySignal;
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
     * 全自动信号监控
     * @return mixed
     */
    public function index() {
        $dailySignalModel = new DailySignal();
        $dailySignalList = $dailySignalModel->getDailySignalList();

        $this->assign('dailySignalList', $dailySignalList);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }
}
