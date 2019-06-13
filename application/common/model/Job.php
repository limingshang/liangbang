<?php

namespace app\common\model;

use think\Model;

class job extends Model
{
    public $page_info;

    /*
     * 新增职位
     */
    public function addjob($param)
    {
        return db('job')->insertGetId($param);
    }

    /*
     * 编辑职位
     */
    public function editjob($condition, $update)
    {
        return db('job')->where($condition)->update($update);
    }

    /**
     * 删除职位
     * @param unknown $condition
     * @return boolean
     */
    public function deljob($condition)
    {
        return db('job')->where($condition)->delete();
    }

    /*
     * 职位列表
     */
    public function getjobList($condition, $field = '*', $page = 0, $order = 'job_order desc, job_id desc', $limit = '')
    {
        if ($limit) {
            return db('job')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        } else {
            $res = db('job')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        }
    }

    /**
     * 取单个职位内容
     */
    public function getOneJob($condition, $field = '*')
    {
        return db('job')->field($field)->where($condition)->find();
    }
}

?>
