<?php

namespace app\admin\controller;

use think\Log;
use think\View;
use think\Lang;
use think\Validate;

class Strategy extends AdminControl {

    const GET_URL = "http://api.wquant.com/API4/";
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/strategy.lang.php');
    }

    /**
     * 审核首页
     * @return mixed
     */
    public function index() {
        $model_stratesgy = model('strategyInfo');
        $review_status = input('param.review_status');
        $strategy_info = input('param.strategy_info');
        $condition = array();
        if(!is_null($review_status) && $review_status != 'null') {
            $condition['review_status'] = $review_status;
        }
        if(!empty($strategy_info)) {
            $condition['strategy_info'] = $strategy_info;
        }
        $strategy_list = $model_stratesgy->getStrategyList($condition,'', '*', 20);
        $strategyHold  = model('strategyHold');
        foreach ($strategy_list as $key => $value) {
            $strategyHoldInfo = $strategyHold
                ->where('strategy_id', 'eq', $value['strategy_id'])
                ->field('periods_date')
                ->order('periods_date', 'desc')
                ->find();
            if($strategyHoldInfo) {
                $strategy_list[$key]['periods_date'] = $strategyHoldInfo['periods_date'];
            } else {
                $strategy_list[$key]['periods_date'] = '';
            }
        }
        $this->assign('strategy_list', $strategy_list);
        $this->assign('show_page', $model_stratesgy->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 详情页面
     * @return mixed
     */
    function info(){
        $id = input('id');
        $model_strategy = model('strategyInfo');
        $condition = array('id' => $id);
        $strategy_info = $model_strategy->getOneStrategyInfo($condition,'', '*');
        $periods_date_list = model('strategyHold')
            ->distinct('periods_date')
            ->where('strategy_id', 'eq', $strategy_info['strategy_id'])
            ->order('periods_date','desc')
            ->field('periods_date')
            ->select();
        if ($periods_date_list) {
            $periods_date_list = $periods_date_list->toArray();
        } else {
            $periods_date_list = [];
        }
        $periods_date_list = array_column($periods_date_list, 'periods_date');

        $this->assign('periods_date_list', $periods_date_list);
        $this->assign('strategy_info', $strategy_info);
        $this->setAdminCurItem('info');
        return $this->fetch();
    }

    /**
     * 获取策略调整持仓
     * @return array
     */
    public function getStrategyHold(){
        $model_strategy_hold = model('strategy_hold');
        $strategy_id     = input('param.strategy_id');
        $periods_date     = input('param.periods_date');
        if(!$strategy_id) {
            return [];
        }
        if (!$periods_date) {
            $strategyHold = model('strategyHold');
            $strategyHoldInfo = $strategyHold
                ->where('strategy_id', 'eq', $strategy_id)
                ->field('periods_date')
                ->order('periods_date', 'desc')
                ->find();
            if($strategyHoldInfo) {
                $periods_date = $strategyHoldInfo['periods_date'];
            }
        }
        $condition = array(
            'strategy_id' => $strategy_id,
            'periods_date' => $periods_date,
        );
        $strategy_hold_list = $model_strategy_hold->getStrategyHoldList($condition,'', '*');
        $data = ['code' => 0, 'data' => $strategy_hold_list, 'count' => count($strategy_hold_list)];
        return $data;
    }

    /**
     * 处理审核
     * @return mixed
     */
    public function strategy(){
        if (request()->isPost()) {
            $id     = input('param.id');
            $condition = ['id' => $id];
            $model_strategy = model('strategyInfo');
            $strategyInfo = $model_strategy->getOneStrategyInfo($condition);
            if (!$strategyInfo) {
                dsLayerOpenSuccess('数据不存在');
            } else {
                $review_status     = input('param.review_status');
                $review_describe     = input('param.review_describe');
                switch ($review_status) {
                    case 0:
                        $policyStatus = 0;
                        break;
                    case 2:
                        $policyStatus = 2;
                    break;
                    default:
                        $policyStatus = 1;
                        break;
                }
                $url = self::GET_URL."Grit/ReceiveVerifyStatus.ashx";
                $postData = [
                    'strategyid' => $strategyInfo['strategy_id'],
                    'touser'     => 'wk',
                    'status'     => $policyStatus,
                    'desc'       => $review_describe,
                    'curtime'    => date("Y-m-d H:i:s", time()),
                ];
                $result = request_post($url, $postData);
                Log::write('请求Url:'.$url.json_encode($postData, JSON_UNESCAPED_UNICODE));
                Log::write('successData:'.$result);
                $condition = ['id' => $id];
                $data['review_status'] = $policyStatus;
                $data['review_describe'] = $review_describe;
                $model_strategy = model('strategyInfo');
                $model_strategy->editStrategy($condition, $data);
                dsLayerOpenSuccess('处理成功');
            }

        } else {
            $this->setAdminCurItem('strategy');
            return $this->fetch();
        }
    }
}
