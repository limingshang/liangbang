<?php

namespace app\common\model;

use think\Model;

class StrategyNetValue extends Model
{
    public $page_info;

    /**
     * 新增净值
     */
    public function addStrategyNetValue($data)
    {
        return db('strategy_net_value')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editStrategyNetValue($condition, $data)
    {
        return db('strategy_net_value')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delStrategyNetValue($condition)
    {
        return db('strategy_net_value')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getStrategyNetValueList($condition = array(),$limit='', $field = '*', $page = '', $order = 'trading_date asc')
    {
        if ($page) {
            $res = db('strategy_net_value')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('strategy_net_value')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个数据
     */
    public function getOneStrategyNetValueInfo($condition, $field = '*')
    {
        return db('strategy_net_value')->field($field)->where($condition)->find();
    }
}
