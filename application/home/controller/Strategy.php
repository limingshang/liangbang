<?php

/*
 * 首页相关基本调用
 */

namespace app\home\controller;

use app\common\model\StrategyHold;
use app\common\model\StrategyInfo;
use app\common\model\UserFocus;
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
        $code            = input('code');
        $strategy_status = input('strategy_status');
        // $review_status = input('review_status');
        $strategy_type = input('strategy_type');
        if (request()->isPost()) {
            $model_strategy = model('strategyInfo');
            if ($strategy_type != '') {
                $model_strategy = $model_strategy
                    ->where('strategy_type', 'eq', $strategy_type);
            }
            if ($strategy_status != '') {
                $model_strategy = $model_strategy
                    ->where('strategy_status', 'eq', $strategy_status);
            }
//            if ($review_status != '') {
//                $model_strategy = $model_strategy
//                    ->where('review_status', 'eq', $review_status);
//            } else {
//                $model_strategy = $model_strategy
//                    ->where('review_status', 'eq', 0);
//            }
            $result = $model_strategy
                ->field('strategy_id, strategy_name, sharpe_ratio, net_value, daily_ratio')
                ->select()->toArray();
            ds_json_encode(200, '数据获取成功共：' . (string)count($result), $result);
        } else {
            ds_json_encode(200, '请求方式不正确');
        }
    }

    /**
     * 获取策略详情
     */
    public function getStrategyInfo()
    {
        $code        = input('code');
        $strategy_id = input('strategy_id');      // 策略id
        if (request()->isPost() && $strategy_id) {
            $model_strategy = model('strategyInfo');
            $result         = $model_strategy
                ->where('strategy_id', 'eq', $strategy_id)
                ->field('strategy_id, strategy_name, strategy_type,real_ratio,annualized_volatility,annualized_ratio,profit_ratio_monthly,daily_ratio,daily_ratio,sharpe_ratio,max_drawdown,net_value,net_value,net_value_date,adjust_cycle,sub_index,sub_index_value,sub_index_ratio,hold_secu_num,run_num,review_status,strategy_status,strategy_describe,update_time')
                ->find();
            if ($result) {
                $result = $result->toArray();
            } else {
                $result = [];
            }
            ds_json_encode(200, '数据获取成功', $result);
        } else {
            ds_json_encode(200, '请求方式不正确，或策略id未传递');
        }
    }

    /**
     * 获取策略净值
     */
    public function getStrategyNetValue()
    {
        $code        = input('code');
        $strategy_id = input('strategy_id');      // 策略id
        if (request()->isPost() && $strategy_id) {
            $strategyNetValue       = model('strategyNetValue');
            $condition              = ['strategy_id' => $strategy_id];
            $fields                 = 'trading_date,net_value,index_value';
            $result                 = $strategyNetValue->getStrategyNetValueList($condition, null, $fields);
            $results['strategy_id'] = $strategy_id;
            $results['value_info']  = $result;
            ds_json_encode(200, '数据获取成功', $results);
        } else {
            ds_json_encode(200, '请求方式不正确，或策略id未传递');
        }
    }

    /**
     * 获取策略调仓信息
     */
    public function getStrategyHoldList()
    {
        $code         = input('code');
        $strategy_id  = input('strategy_id');   // 策略id
        $periods_date = input('periods_date');  // 策略调仓期数ID
        $start_date   = input('start_date');    // 开始时间
        $end_date     = input('end_date');      // 截止时间
        if (request()->isPost() && $strategy_id) {
            $model_strategy = model('strategyInfo');
            $strategyInfo   = $model_strategy
                ->where('strategy_id', 'eq', $strategy_id)
                ->field('strategy_id, strategy_name, review_status')
                ->find();
            // 获取最新的一期
            $strategyHold = model('strategyHold');
            $newstrategyHoldInfo = $strategyHold
                ->where('strategy_id', 'eq', $strategy_id)
                ->field('periods_date')
                ->order('periods_date', 'desc')
                ->find();
            if ($strategyInfo) {
                $strategyHold = model('strategyHold');
                if (!$periods_date) {
                    $strategyHoldInfo = $strategyHold
                        ->where('strategy_id', 'eq', $strategy_id);
                    if($strategyInfo['review_status'] != 0) {
                        $strategyHoldInfo = $strategyHoldInfo->where('periods_date', 'neq', $newstrategyHoldInfo['periods_date']);
                    }
                    $strategyHoldInfo = $strategyHoldInfo->field('periods_date')
                        ->order('periods_date', 'desc')
                        ->find();
                    if ($strategyHoldInfo) {
                        $periods_date     = $strategyHoldInfo['periods_date'];
                        $condition        = [
                            'strategy_id'  => $strategy_id,
                            'periods_date' => $periods_date,
                        ];
                        if ($start_date && $end_date) {
                            if($strategyInfo['review_status'] != 0) {
                                $condition['periods_date'] = [
                                    ['neq', $newstrategyHoldInfo['periods_date']],
                                    ['between', array($start_date, $end_date)]
                                ];
                            } else{
                                $condition['periods_date'] = ['between', array($start_date, $end_date)];
                            }

                        }
                        $fields           = ['id, secu_name,periods_date, secu_code, pre_hold, adjust_num, trade_direction, adjust_hold'];
                        $strategyHoldList = $strategyHold->getStrategyHoldList($condition, null, $fields);
                    } else {
                        ds_json_encode(200, '未查询到任何调仓数据');
                    }
                } else {
                    $condition        = [
                        'strategy_id'  => $strategy_id,
                        'periods_date' => $periods_date,
                    ];
                    if($strategyInfo['review_status'] != 0) {
                        $condition['periods_date'] = [
                            ['eq', $periods_date],
                            ['neq', $newstrategyHoldInfo['periods_date']],
                        ];
                    }
                    $fields           = ['id, secu_name, periods_date, secu_code, pre_hold, adjust_num, trade_direction, adjust_hold'];
                    $strategyHoldList = $strategyHold->getStrategyHoldList($condition, null, $fields);
                }
                $holdListInfo = [];
                foreach($strategyHoldList as $key => $value) {
                    $holdListInfo[$value['periods_date']][] = [
                        'periods_date' => $value['periods_date'],
                        'adjust_secu'  => $value,
                    ];
                }
                $strategyInfo['adjust_info'] = array_values($holdListInfo);
                ds_json_encode(200, '数据获取成功', $strategyInfo);
            } else {
                ds_json_encode(200, '未查询到此策略数据');
            }
        } else {
            ds_json_encode(200, '请求方式不正确，或策略id未传递');
        }
    }

    /**
     * 获取调仓日期
     */
    public function getAdjustDate()
    {
        $code        = input('code');
        $strategy_id = input('strategy_id');      // 策略id
        if (request()->isPost() && $strategy_id) {
            $result = model('strategyHold')
                ->distinct('periods_date')
                ->where('strategy_id', 'eq', $strategy_id)
                ->order('periods_date', 'desc')
                ->field('periods_date')
                ->select();
            if ($result) {
                $result = $result->toArray();
            } else {
                $result = [];
            }
            $model_strategy = model('strategyInfo');
            $strategyInfo   = $model_strategy
                ->where('strategy_id', 'eq', $strategy_id)
                ->field('strategy_id, strategy_name,review_status')
                ->find();
            if($strategyInfo['review_status'] != 0) {
                unset($result[0]);
            }
            $results                 = [];
            $results['strategy_id']  = $strategy_id;
            $results['periods_date'] = array_column($result, 'periods_date');

            ds_json_encode(200, '数据获取成功', $results);
        } else {
            ds_json_encode(200, '请求方式不正确，或策略id未传递');
        }
    }

    /**
     * 修改策略主体
     */
    public function updateStrategy()
    {
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
            'max_drawdown'          => input('max_drawdown'),
            'net_value'             => input('net_value'),
            'net_value_date'        => input('net_value_date'),
            'adjust_cycle'          => input('adjust_cycle'),
            'sub_index'             => input('sub_index'),
            'sub_index_value'       => input('sub_index_value'),
            'sub_index_ratio'       => input('sub_index_ratio'),
            'hold_secu_num'         => input('hold_secu_num'),
            'run_num'               => input('run_num'),
            'review_status'         => input('review_status') ? input('review_status') : 0,
            'strategy_status'       => input('strategy_status'),
            'strategy_describe'     => input('strategy_describe'),
            'update_time'           => input('update_time'),
        ];
        if (!input('strategy_id')) {
            ds_json_encode(200, '策略id参数错误');
        }
        $condition         = ['strategy_id' => input('strategy_id')];
        $strategyInfoModel = model('strategyInfo');
        $strategyInfo      = $strategyInfoModel->getOneStrategyInfo($condition);
        if ($strategyInfo) {
            $strategyInfoModel = model('strategyInfo');
            $condition         = ['strategy_id' => input('strategy_id')];
            $strategyInfoModel->editStrategy($condition, $data);
        } else {
            $strategyInfoModel = model('strategyInfo');
            $strategyInfoModel->addStrategy($data);
        }
        ds_json_encode(200, '存储成功');
    }

    /**
     * 更新策略持仓
     */
    public function updateStrategyHold()
    {
        $data         = input('data');
        $periods_date = input('periods_date');
        // $condition = ['strategy_id' => input('strategy_id')];
        // $strategyInfoModel = model('strategyInfo');
        // $strategyInfo = $strategyInfoModel->getOneStrategyInfo($condition);
        if (!input('strategy_id')) {
            ds_json_encode(200, '策略id参数错误');
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
                        'strategy_id'  => input('strategy_id')
                    ];
                    $strategyHold->delStrategyHold($condition);
                }
                foreach ($data as $key => $value) {
                    $value['strategy_id']  = input('strategy_id');
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

        ds_json_encode(200, '存储成功');
    }

    /**
     * 更新策略净值
     */
    public function updateStrategyNetValue()
    {
        $data        = input('data');
        $strategy_id = input('strategy_id');
        $data        = json_decode($data, true);
        if (is_array($data) && $strategy_id) {
            Db::startTrans();
            try {
                $strategyNetValue = model('strategyNetValue');
                foreach ($data as $key => $value) {
                    $condition = [
                        'strategy_id'  => $strategy_id,
                        'trading_date' => $value['trading_date'],
                    ];
                    $strategyNetValue->delStrategyNetValue($condition);
                    $result['strategy_id']  = $strategy_id;
                    $result['trading_date'] = $value['trading_date'];
                    $result['net_value']    = $value['net_value'];
                    $result['index_value']  = $value['index_value'];
                    $strategyNetValue->addStrategyNetValue($result);
                }
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                ds_json_encode(404, $e->getMessage());
            }

        }

        ds_json_encode(200, '存储成功');
    }

    /**
     * 更新用户关注信息
     */
    public function updateFocusStatus()
    {
        $phone_num    = input('phone_num');       // 用户手机号
        $strategy_id  = input('strategy_id');     // 策略ID
        $focus_status = input('focus_status');    // 关注状态[0-已关注;1-未关注]
        $focus_date   = input('focus_date');      // 操作日期
        if (!$phone_num || !$strategy_id) {
            ds_json_encode(200, '内容有参数不正确');
        }
        $condition     = [
            'phone_num'   => $phone_num,
            'strategy_id' => $strategy_id,
        ];
        $editData      = [
            'phone_num'    => $phone_num,
            'strategy_id'  => $strategy_id,
            'focus_status' => $focus_status,
            'focus_date'   => $focus_date,
        ];
        $userFocus     = new UserFocus();
        $userFOcusInfo = $userFocus->getOneUserFocusInfo($condition);
        if ($userFOcusInfo) {
            $userFocus->editUserFocus($condition, $editData);
        } else {
            $userFocus->addUserFocus($editData);
        }
        ds_json_encode(200, '存储成功');
    }

    /**
     * 获取用户关注（取消列表）
     */
    public function getFocusList()
    {
        $phone_num    = input('phone_num');       // 用户手机号
        $focus_status = input('focus_status');    // 关注状态[0-已关注;1-未关注]
        if (!$phone_num) {
            ds_json_encode(200, '内容有参数不正确');
        }
        $condition            = [
            'phone_num'    => $phone_num,
            'focus_status' => $focus_status,
        ];
        $fields               = 'focus_status,focus_date,ds_strategy_info.strategy_name,ds_strategy_info.strategy_id,ds_strategy_info.sharpe_ratio,ds_strategy_info.net_value,ds_strategy_info.daily_ratio';
        $userFocus            = new UserFocus();
        $userFOcusList        = $userFocus->getUserFocusList($condition, '', $fields);
        $result['phone_num']  = $phone_num;
        $result['focus_info'] = $userFOcusList;
        ds_json_encode(200, '数据获取成功', $result);
    }

    /**
     * 获取用户策略关注状态
     */
    public function getFocusStatus()
    {
        $phone_num   = input('phone_num');       // 用户手机号
        $strategy_id = input('strategy_id');     // 关注状态[0-已关注;1-未关注]
        if (!$phone_num || !$strategy_id) {
            ds_json_encode(200, '内容有参数不正确');
        }
        $condition     = [
            'phone_num'   => $phone_num,
            'strategy_id' => $strategy_id,
        ];
        $field         = "phone_num, strategy_id, focus_status, focus_date";
        $userFocus     = new UserFocus();
        $userFocusInfo = $userFocus->getOneUserFocusInfo($condition, $field);
        ds_json_encode(200, '数据获取成功', $userFocusInfo);
    }

    public function getUserAdjustList()
    {
        $oper_type   = input('oper_type');       // 操作类型[0-启动;1-调仓;2-停止;]
        $strategy_id = input('strategy_id');     // 关注状态[0-已关注;1-未关注]
        if (!$strategy_id) {
            ds_json_encode(200, '内容有参数不正确');
        }
        $result           = [];
        $strategyHold     = new StrategyHold();
        $strategyHoldInfo = $strategyHold
            ->where('strategy_id', 'eq', $strategy_id)
            ->field('periods_date')
            ->order('periods_date', 'desc')
            ->find();
        $trade_direction = '';
        if ($strategyHoldInfo) {
            $periods_date = $strategyHoldInfo['periods_date'];
            switch ($oper_type) {
                case 0:             // 就把所有买入和持有的数据返出来+与现在是卖出状态并且目标持仓不为0的状态变为：买入
                    $result = $strategyHold
                        ->where('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and trade_direction = "买入"')
                        ->whereOr('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and trade_direction = "持有"')
                        ->whereOr('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and trade_direction = "卖出" and adjust_hold > 0')
                        ->field("id, secu_name, secu_code, pre_hold, adjust_num, trade_direction, adjust_hold")
                        ->order("FIELD(trade_direction,  '买入',   '卖出',   '持有')   ASC")
                        ->select();
                    $trade_direction = '买入';
                    break;
                case 1:             // 就把买入和卖出的数据返回出来
                    $result = $strategyHold
                        ->where('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and trade_direction = "买入"')
                        ->whereOr('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and trade_direction = "卖出"')
                        ->field("id, secu_name, secu_code, pre_hold, adjust_num, trade_direction, adjust_hold")
                        ->order("FIELD(trade_direction,  '买入',   '卖出',   '持有')   ASC")
                        ->select();
                    break;
                case 2:             // 就把所有买入和持有的也返出来
                    $result = $strategyHold
                        ->where('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and trade_direction = "买入"')
                        ->whereOr('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and trade_direction = "持有"')
                        ->field("id, secu_name, secu_code, pre_hold, adjust_num, trade_direction, adjust_hold")
                        ->whereOr('strategy_id = "' . $strategy_id . '" and periods_date = ' . $periods_date . ' and adjust_hold > 0')
                        ->order("FIELD(trade_direction,  '买入',   '卖出',   '持有')   ASC")
                        ->select();
                        $trade_direction = '卖出';
                    break;
            }
        }

        $condition       = ['strategy_id' => $strategy_id];
        $fidlds          = ['strategy_name', 'strategy_id'];
        $strategyInfo    = new StrategyInfo();
        $strategyInfoRes = $strategyInfo->getOneStrategyInfo($condition, $fidlds);
        if (!$strategyInfoRes) {
            ds_json_encode(200, '内容有参数不正确');
        }
        foreach ($result as $key => $value) {
            $result[$key]['id'] = $key + 1;
            if($trade_direction == '买入') {
                if($value['trade_direction'] == '卖出') {
                    $result[$key]['adjust_num'] = $value['adjust_hold'];
                }
                $result[$key]['trade_direction'] = '买入';
            } elseif($trade_direction == '卖出') {
                if($value['adjust_hold'] > 0){
                    $result[$key]['adjust_num'] = $value['adjust_hold'];
                }
                $result[$key]['trade_direction'] = '卖出';
            }
        }

        $strategyInfoRes['periods_date'] = $periods_date;
        $strategyInfoRes['adjustInfo']   = $result;
        ds_json_encode(200, '数据获取成功', $strategyInfoRes);
    }
}