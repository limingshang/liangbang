<?php

/*
 * 首页相关基本调用
 */
namespace app\home\controller;
use think\Db;
use think\Log;

class Strategy extends BaseMall
{
    const CODE = 'ienkdfiennzl123lkjas93023j';
    public function _initialize()
    {
        parent::_initialize();
    }



    /**
     * 获取策略名称列表
     */
    public function getStrategyList()
    {
        $code = input('code');
        $review_status = input('review_status');
        if (request()->isPost()) {
            $model_strategy = model('strategyInfo');
            if ($review_status != '') {
                $model_strategy = $model_strategy
                    ->where('review_status', 'eq', $review_status);
            }
            $result = $model_strategy
                ->field('strategy_id, strategy_name, sharpe_ratio, net_value, daily_ratio')
                ->select()->toArray();
            ds_json_encode(10000, '数据获取成功', $result);
        } else {
            ds_json_encode(404, '失败');
        }
    }
    /**
     * 获取策略详情
     */
    public function getStrategyInfo()
    {
        $code     = input('code');
        $strategy_id = input('strategy_id');      // 策略id
        if (request()->isPost() && $strategy_id) {
            $model_strategy = model('strategyInfo');
            $result = $model_strategy
                ->where('strategy_id', 'eq', $strategy_id)
                ->field('strategy_id, strategy_name, strategy_type,real_ratio,annualized_volatility,annualized_ratio,profit_ratio_monthly,daily_ratio,daily_ratio,sharpe_ratio,net_value,net_value,net_value_date,adjust_cycle,sub_index,subIndexValue,subIndexRatio,hold_secu_num,run_num,review_status,strategy_status,strategy_describe,update_time')
                ->find();
            if($result) {
                $result = $result->toArray();
            } else {
                $result = [];
            }
            ds_json_encode(10000, '数据获取成功', $result);
        } else {
            ds_json_encode(404, '失败');
        }
    }

    /**
     * 获取策略净值
     */
    public function getStrategyNetValue()
    {
        $code     = input('code');
        $strategy_id = input('strategy_id');      // 策略id
        if (request()->isPost() && $strategy_id) {
            $strategyNetValue = model('strategyNetValue');
            $condition = ['strategy_id' => $strategy_id];
            $result = $strategyNetValue->getStrategyNetValueList($condition);
            ds_json_encode(10000, '数据获取成功', $result);
        } else {
            ds_json_encode(404, '失败');
        }
    }
    /**
     * 获取策略调仓信息
     */
    public function getStrategyHoldList()
    {
        $code     = input('code');
        $strategy_id = input('strategy_id');      // 策略id
        $periods_date = input('periods_date');      // 策略调仓期数ID
        if (request()->isPost() && $strategy_id) {
            $model_strategy = model('strategyInfo');
            $strategyInfo = $model_strategy
                ->where('strategy_id', 'eq', $strategy_id)
                ->field('strategy_id, strategy_name')
                ->find();
            if ($strategyInfo) {
                $strategyHold = model('strategyHold');
                if (!$periods_date) {
                    $strategyHoldInfo = $strategyHold
                        ->where('strategy_id', 'eq', $strategy_id)
                        ->field('periods_date')
                        ->order('periods_date', 'desc')
                        ->find();
                    if($strategyHoldInfo) {
                        $periods_date = $strategyHoldInfo['periods_date'];
                        $condition = [
                            'strategy_id' => $strategy_id,
                            'periods_date' => $periods_date,
                        ];
                        $fields = ['id, secu_name, secu_code, pre_hold, adjust_num, trade_direction, adjust_hold'];
                        $strategyHoldList = $strategyHold->getStrategyHoldList($condition, null, $fields);
                    } else {
                        ds_json_encode(404, '失败');
                    }
                } else {
                    $condition = [
                        'strategy_id' => $strategy_id,
                        'periods_date' => $periods_date,
                    ];
                    $fields = ['id, secu_name, secu_code, pre_hold, adjust_num, trade_direction, adjust_hold'];
                    $strategyHoldList = $strategyHold->getStrategyHoldList($condition, null, $fields);
                }
                $strategyInfo['periods_date'] = $periods_date;
                $strategyInfo['adjustInfo'] = $strategyHoldList;

                ds_json_encode(10000, '数据获取成功', $strategyInfo);
            } else {
                ds_json_encode(404, '失败');
            }
        } else {
            ds_json_encode(404, '失败');
        }
    }

    /**
     * 修改策略主体
     */
    public function updateStrategy(){
        $data = [
            'strategy_id'           => input('strategy_id'),
            'strategy_name'         => input('strategy_name'),
            'strategy_type'         => input('strategy_type'),
            'real_ratio'            => input('real_ratio'),
            'annualized_volatility' => input('annualized_volatility'),
            'annualized_ratio'      => input('annualized_ratio'),
            'profit_ratio_monthly'  => input('profit_ratio_monthly'),
            'daily_ratio'           => input('daily_ratio'),
            'sharpe_ratio'          => input('sharpe_ratio'),
            'net_value'             => input('net_value'),
            'net_value_date'        => input('net_value_date'),
            'adjust_cycle'          => input('adjust_cycle'),
            'sub_index'             => input('sub_index'),
            'subIndexValue'         => input('subIndexValue'),
            'subIndexRatio'         => input('subIndexRatio'),
            'hold_secu_num'         => input('hold_secu_num'),
            'run_num'               => input('run_num'),
            'review_status'         => input('review_status'),
            'strategy_status'       => input('strategy_status'),
            'strategy_describe'     => input('strategy_describe'),
            'update_time'           => date("Y-m-d H:i:s"),
        ];
        $condition = ['strategy_id' => input('strategy_id')];
        $strategyInfoModel = model('strategyInfo');
        $strategyInfo = $strategyInfoModel->getOneStrategyInfo($condition);
        if($strategyInfo) {
            $strategyInfoModel = model('strategyInfo');
            $condition = ['strategy_id' => input('strategy_id')];
            $strategyInfoModel->editStrategy($condition, $data);
        } else{
            $strategyInfoModel = model('strategyInfo');
            $strategyInfoModel->addStrategy($data);
        }
        ds_json_encode(10000, '存储成功');
    }

    /**
     * 更新策略持仓
     */
    public function updateStrategyHold(){
        $data = input('data');
        $periods_date = input('periods_date');
        // $condition = ['strategy_id' => input('strategy_id')];
        // $strategyInfoModel = model('strategyInfo');
        // $strategyInfo = $strategyInfoModel->getOneStrategyInfo($condition);
        if(!input('strategy_id')) {
            ds_json_encode(404, '失败');
        }
        // if($strategyInfo) {
            $data = json_decode($data, true);
            if (is_array($data)) {
                Db::startTrans();
                try {
                    $strategyHold = model('strategyHold');
                    if ($periods_date) {
                        $condition = [
                            'periods_date' => $periods_date,
                            'strategy_id' => input('strategy_id')
                        ];
                        $strategyHold->delStrategyHold($condition);
                    }
                    foreach ($data as $key => $value) {
                        $value['strategy_id'] = input('strategy_id');
                        $value['periods_date'] = $periods_date;
                        // $value['strategy_name'] = $strategyInfo['strategy_name'];
                        $strategyHold = model('strategyHold');
                        $strategyHold->addStrategyHold($value);
                    }
                    // 提交事务
                    Db::commit();
                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    ds_json_encode(404, $e->getMessage());
                }

            }
        // }

        ds_json_encode(10000, '存储成功');
    }

    /**
     * 更新策略净值
     */
    public function updateStrategyNetValue(){
        $data = input('data');
        $data = json_decode($data, true);
        if (is_array($data)) {
            Db::startTrans();
            try {
                $strategyNetValue = model('strategyNetValue');
                foreach ($data as $key => $value) {
                    $condition = [
                        'strategy_id' => $value['strategy_id'],
                        'trading_date' => $value['trading_date'],
                    ];
                    $strategyNetValue->delStrategyNetValue($condition);

                    $strategyNetValue->addStrategyNetValue($value);
                }
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                ds_json_encode(404, $e->getMessage());
            }

        }

        ds_json_encode(10000, '存储成功');
    }
}