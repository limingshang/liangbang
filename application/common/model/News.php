<?php

namespace app\common\model;

use think\Model;

class News extends Model
{
    public $page_info;

    /**
     * 新增用户
     */
    public function addNews($data)
    {
        return db('news')->insertGetId($data);
    }

    /**
     * 编辑
     */
    public function editNews($condition, $data)
    {
        return db('news')->where($condition)->update($data);
    }

    /**
     * 删除
     */
    public function delNews($condition)
    {
        return db('news')->where($condition)->delete();
    }

    /**
     * 取列表
     */
    public function getNewsList($condition = array(),$limit='', $field = '*', $page = '', $order = 'news_order desc,news_id desc')
    {
        if ($page) {
            $res = db('news')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('news')->where($condition)->field($field)->order($order)->limit($limit)->select();
        }
    }


    /**
     * 取单个新闻
     */
    public function getOneNews($condition, $field = '*')
    {
        return db('news')->field($field)->where($condition)->find();
    }
}
