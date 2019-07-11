<?php

namespace app\common\model;

use think\Db;
use think\Model;

class UserFocus extends Model
{
    public $page_info;

    /**
     * 新增策略
     */
    public function addUserFocus($data)
    {
        return db('user_focus')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editUserFocus($condition, $data)
    {
        return db('user_focus')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delUserFocus($condition)
    {
        return db('user_focus')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getUserFocusList($condition = array(),$limit='', $field = '*', $page = '', $order = 'u.id desc')
    {
        if ($page) {
            $res = db('user_focus')->alias('u')
                ->join('ds_strategy_info', "user_focus.strategy_id = ds_strategy_info.strategy_id")
                ->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('user_focus')->alias('u')
                ->join('ds_strategy_info', "u.strategy_id = ds_strategy_info.strategy_id", 'left')
                ->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个数据
     */
    public function getOneUserFocusInfo($condition, $field = '*')
    {
        return db('user_focus')->field($field)->where($condition)->find();
    }
}
