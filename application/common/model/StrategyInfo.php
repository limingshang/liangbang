<?php

namespace app\common\model;

use think\Db;
use think\Model;

class StrategyInfo extends Model
{
    public $page_info;

    /**
     * 新增策略
     */
    public function addStrategy($data)
    {
        return db('strategy_info')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editStrategy($condition, $data)
    {
        return db('strategy_info')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delStrategy($condition)
    {
        return db('strategy_info')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getStrategyList($condition = array(),$limit='', $field = '*', $page = '', $order = 'id desc')
    {
        if ($page) {
            $res = db('strategy_info');

            if(isset($condition['review_status'])) {
                $res = $res
                    ->where('review_status', 'eq', $condition['review_status']);
            }
            if(isset($condition['strategy_status'])) {
                $res = $res
                    ->where('strategy_status', 'eq', $condition['strategy_status']);
            }
            if(isset($condition['strategy_info'])) {
                $res = $res
                    ->where('strategy_name', 'eq', $condition['strategy_info'])
                    ->whereOr('strategy_type', 'eq', $condition['strategy_info']);
            }
            $res = $res->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('strategy_info')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个数据
     */
    public function getOneStrategyInfo($condition, $field = '*')
    {
        return db('strategy_info')->field($field)->where($condition)->find();
    }
}
