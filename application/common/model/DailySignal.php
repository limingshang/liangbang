<?php

namespace app\common\model;

use think\Db;
use think\Model;

class DailySignal extends Model
{
    public $page_info;

    /**
     * 新增数据
     */
    public function addDailySignal($data)
    {
        return db('daily_signal')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editDailySignal($condition, $data)
    {
        return db('daily_signal')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delDailySignal($condition)
    {
        return db('daily_signal')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getDailySignalList($condition = array(),$limit='', $field = '*', $page = '', $order = 'ds_daily_signal.id desc, signal_time desc')
    {
        if ($page) {
            $res = db('daily_signal')
                ->join('ds_strategy_info', "ds_daily_signal.strategy_id = ds_strategy_info.strategy_id",'left')
                ->whereBetween($condition['key'], $condition['value'])
                ->field($field)->order($order)->paginate($limit, $page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('daily_signal')
                ->join('ds_strategy_info', "ds_daily_signal.strategy_id = ds_strategy_info.strategy_id",'left')
                ->whereBetween($condition['key'], $condition['value'])
                ->field($field)->order($order)
                ->limit($limit)->select();
        }
    }


    /**
     * 取单个数据
     */
    public function getOneDailySignalInfo($condition, $field = '*')
    {
        return db('daily_signal')->field($field)->where($condition)->find();
    }
    /**
     * 取单个数据
     */
    public function getCount($condition, $field = '*')
    {
        return db('daily_signal')->field($field)
            ->whereBetween($condition['key'], $condition['value'])
            ->count();
    }
}
