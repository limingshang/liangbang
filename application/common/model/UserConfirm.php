<?php

namespace app\common\model;

use think\Db;
use think\Model;

class UserConfirm extends Model
{
    public $page_info;

    /**
     * 新增用户风险确认数据
     */
    public function addUserConfim($data)
    {
        return db('user_confirm')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editUserConfim($condition, $data)
    {
        return db('user_confirm')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delUserConfim($condition)
    {
        return db('user_confirm')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getUserConfimList($condition = array(),$limit='', $field = '*', $page = '', $order = 'id desc')
    {
        if ($page) {
            $res = db('user_confirm');
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
    public function getOneUserConfimInfo($condition, $field = '*')
    {
        return db('user_confirm')->field($field)->where($condition)->find();
    }
}
