<?php

namespace app\common\model;

use think\Model;

class StrategyHold extends Model
{
    public $page_info;

    /**
     * 新增持仓
     */
    public function addStrategyHold($data)
    {
        return db('strategy_hold')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editStrategyHold($condition, $data)
    {
        return db('strategy_hold')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delStrategyHold($condition)
    {
        return db('strategy_hold')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getStrategyHoldList($condition = array(),$limit='', $field = '*', $page = '', $order = 'periods_date desc')
    {
        if ($page) {
            $res = db('strategy_hold')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('strategy_hold')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 取单个数据
     */
    public function getOneStrategyHoldInfo($condition, $field = '*')
    {
        return db('strategy_hold')->field($field)->where($condition)->find();
    }
}
