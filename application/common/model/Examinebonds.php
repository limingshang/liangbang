<?php

namespace app\common\model;

use think\Model;

class Examinebonds extends Model
{
    public $page_info;

    /**
     * 新增用户
     */
    public function addExamine($data)
    {
        return db('examinebonds')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editExamine($condition, $data)
    {
        return db('examinebonds')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delExamine($condition)
    {
        return db('examinebonds')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getExamineList($condition = array(),$limit='', $field = '*', $page = '', $order = 'periodsNum desc')
    {
        if ($page) {
            $res = db('examinebonds')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('examinebonds')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个新闻
     */
    public function getOneExamine($condition, $field = '*')
    {
        return db('examinebonds')->field($field)->where($condition)->find();
    }
}
