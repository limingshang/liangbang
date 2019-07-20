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

        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 传递数据
     */
    public function getDailySignalList()
    {
        $dailySignalModel = new DailySignal();
        $condition = [
            'key'   => 'signal_time',
            'value' => [date("Y-m-d 00:00:00", time()), date("Y-m-d 23:59:59", time())],
        ];
        $dailySignalList = $dailySignalModel->getDailySignalList($condition);
        $data = [];
        foreach($dailySignalList as $key => $value) {
            $value['id'] = $key;
            $data[] = $value;
        }
        $data = ['code' => 0, 'data' => $dailySignalList, 'count' => count($dailySignalList)];
        return $data;
    }
}
