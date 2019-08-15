<?php

/*
 * 首页相关基本调用
 */

namespace app\api\controller;

use app\common\model\DailySignal;
use app\common\model\UserConfirm;

class Strategy extends BaseApi
{

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 存储数据
     */
    public function AcceptDailySignal()
    {
        $strategy_id = input('strategy_id');
        if (!$strategy_id) {
            ds_json_encode(200, '存储失败，数据错误');
        }
        $strategy_id = substr($strategy_id, 0, -7);
//        $secu_code      = input('secu_code');
//        $direction      = input('direction');
//        $offset         = input('offset');
//        $price          = input('price');
//        $signal_time    = input('signal_time');
        $signal_info      = json_decode(input('signal_info'), true);
        $dailySignalModel = new DailySignal();
        if (is_array($signal_info)) {
            foreach ($signal_info as $key => $value) {
                $data                = $value;
                $data['strategy_id'] = $strategy_id;
                $condition           = [
                    'strategy_id' => $strategy_id,
                    'secu_code'   => $value['secu_code'],
                    'direction'   => $value['direction'],
                    'signal_time' => $value['signal_time'],
                ];
                $result              = $dailySignalModel->getOneDailySignalInfo($condition);
                if (!$result) {
                    $data = $dailySignalModel->addDailySignal($data);
                } else {
                    $dailySignalModel->editDailySignal($condition, $data);
                }
            }
        }
        ds_json_encode(200, '存储成功');
    }

    /**
     * 存储用户风险确认数据
     */
    public function saveUserConfirm()
    {
        $data['fund_code']      = input('fund_code');
        $data['risk_level']     = input('risk_level');
        $data['confirm_status'] = input('confirm_status');
        $data['updatetime']    = input('updatetime');
        $userConfirm = new UserConfirm();
        $condition = ['fund_code' => input('fund_code')];
        $userConfirmInfo = $userConfirm->getOneUserConfimInfo($condition);
        if ($userConfirmInfo) {
            $status = $userConfirm->editUserConfim($condition, $data);
        } else {
            $status = $userConfirm->addUserConfim($data);
        }
        ds_json_encode(200, '存储成功');
    }
    /**
     * 获取用户风险确认数据
     */
    public function getUserConfirm()
    {
        if(!input('fund_code')) {
            ds_json_encode(200, '数据获取成功', []);
        }
        $data['fund_code']      = input('fund_code');
        $userConfirm = new UserConfirm();
        $condition = ['fund_code' => input('fund_code')];
        $fields = 'fund_code, risk_level, confirm_status, updatetime';
        $userConfirmInfo = $userConfirm->getOneUserConfimInfo($condition, $fields);
        if ($userConfirmInfo) {
            ds_json_encode(200, '数据获取成功', $userConfirmInfo);
        } else {
            ds_json_encode(201, '数据获取为空', (object)[]);
        }
    }
}