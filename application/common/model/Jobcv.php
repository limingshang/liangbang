<?php

namespace app\common\model;

use think\Model;

class Jobcv extends Model
{
    public $page_info;

    /**
     * 添加简历
     * @param unknown $condition
     * @return boolean
     */
    public function addJobcv($data)
    {
        return db('jobcv')->insert($data);
    }
    /*
     * 编辑职位
     */
    public function editJobcv($condition, $update)
    {
        return db('jobcv')->where($condition)->update($update);
    }
    /**
     * 删除简历
     * @param unknown $condition
     * @return boolean
     */
    public function delJobcv($condition)
    {
        return db('jobcv')->where($condition)->delete();
    }

    /*
     * 简历列表
     */
    public function getJobcvList($condition, $field = '*', $page = 0, $order = 'jobcv_addtime desc, jobcv_id desc', $limit = '')
    {
        if ($limit) {
            return db('jobcv')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        } else {
            $res = db('jobcv')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        }
    }

    /**
     * 取单个简历内容
     */
    public function getOneJobcv($condition, $field = '*')
    {
        return db('jobcv')->field($field)->where($condition)->find();
    }
}

?>
