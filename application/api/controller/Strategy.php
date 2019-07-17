<?php

/*
 * 首页相关基本调用
 */
namespace app\api\controller;

use app\common\model\DailySignal;

class Strategy extends BaseApi
{

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 存储数据
     */
    public function saveData()
    {
        $strategy_id    = input('strategy_id');
        $secu_code      = input('secu_code');
        $direction      = input('direction');
        $offset         = input('offset');
        $price          = input('price');
        $signal_time    = input('signal_time');
        $data = [
            'strategy_id' => $strategy_id,
            'secu_code' => $secu_code,
            'direction' => $direction,
            'offset' => $offset,
            'price' => $price,
            'signal_time' => $signal_time,
        ];
        $dailySignalModel = new DailySignal();
        $condition = [
            'strategy_id' => $strategy_id,
            'secu_code'   => $secu_code,
            'direction'   => $direction,
            'signal_time' => $signal_time,
        ];
        $result = $dailySignalModel->getOneDailySignalInfo($condition);
        if (!$result) {
            $data = $dailySignalModel->addDailySignal($data);
        } else {
            $dailySignalModel->editDailySignal($condition, $data);
        }

        ds_json_encode(10000, '存储成功');
    }
}