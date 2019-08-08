<?php

namespace app\admin\controller;

use app\common\model\StrategyInfo;
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
        $strategy_ids = array_column($handelLogList, 'strategy_id');
        $strategyInfo = new StrategyInfo();
        $strategyList = $strategyInfo->whereIn('strategy_id', $strategy_ids)->select();
        if(!$strategyList) {
            $this->assign('handelLogList', []);
            $this->assign('show_page', []);
            $this->setAdminCurItem('index');
            return $this->fetch();

        }
        $strategyList = $strategyList->toArray();
        $strategyList = array_column($strategyList, null, 'strategy_id');
        // 处理数据
        foreach ($handelLogList as $key => $value) {
            $handelLogList[$key] = array_merge($value, $strategyList[$value['strategy_id']]);

        }
        $this->assign('handelLogList', $handelLogList);
        $this->assign('show_page', $handelLog->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }
}
