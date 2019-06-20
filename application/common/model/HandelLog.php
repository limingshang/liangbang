<?php

namespace app\common\model;

use think\Model;

class HandelLog extends Model
{
    public $page_info;

    /**
     * 新增净值
     */
    public function addHandelLogValue($data)
    {
        return db('handel_log')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editHandelLogValue($condition, $data)
    {
        return db('handel_log')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delHandelLogValue($condition)
    {
        return db('handel_log')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getHandelLogValueList($condition = array(),$limit='', $field = '*', $page = '', $order = 'create_time desc')
    {
        if ($page) {
            $res = db('handel_log')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('handel_log')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个数据
     */
    public function getOneHandelLogValueInfo($condition, $field = '*')
    {
        return db('handel_log')->field($field)->where($condition)->find();
    }
}
