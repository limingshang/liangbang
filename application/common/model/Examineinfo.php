<?php

namespace app\common\model;

use think\Model;

class Examineinfo extends Model
{
    public $page_info;

    /**
     * 新增用户
     */
    public function addExamine($data)
    {
        return db('examineinfo')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editExamine($condition, $data)
    {
        return db('examineinfo')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delExamine($condition)
    {
        return db('examineinfo')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getExamineList($condition = array(),$limit='', $field = '*', $page = '', $order = 'id desc')
    {
        if ($page) {
            $res = db('examineinfo')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('examineinfo')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个新闻
     */
    public function getOneExamine($condition, $field = '*')
    {
        return db('examineinfo')->field($field)->where($condition)->find();
    }
}
