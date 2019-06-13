<?php

namespace app\common\model;

use think\Model;

class Examine extends Model
{
    public $page_info;

    /**
     * 新增用户
     */
    public function addExamine($data)
    {
        return db('examine')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editExamine($condition, $data)
    {
        return db('examine')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delExamine($condition)
    {
        return db('examine')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getExamineList($condition = array(),$limit='', $field = '*', $page = '', $order = 'reviewStatus asc,id desc')
    {
        if ($page) {

            $res = db('examine');
            if(isset($condition['reviewStatus'])) {
                $res = db('examine')
                    ->where('reviewStatus', 'eq', $condition['reviewStatus']);
            }
            if(isset($condition['strategyInfo'])) {
                $res = db('examine')
                    ->where('strategyName', 'eq', $condition['strategyInfo'])
                    ->whereOr('strategyType', 'eq', $condition['strategyInfo']);
            }

            $res = $res->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('examine')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个新闻
     */
    public function getOneExamine($condition, $field = '*')
    {
        return db('examine')
            ->join('ds_examineinfo', "ds_examine.id = ds_examineinfo.examineId")
            ->field($field)->where($condition)->find();
    }
}
