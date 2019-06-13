<?php

namespace app\common\model;

use think\Model;

class Nav extends Model
{
    public $page_info;

    /*
     * 新增导航
     */
    public function addNav($param)
    {
        return db('nav')->insertGetId($param);
    }

    /*
     * 编辑导航
     */
    public function editNav($condition, $update)
    {
        return db('nav')->where($condition)->update($update);
    }

    /**
     * 删除导航
     * @param unknown $condition
     * @return boolean
     */
    public function delNav($condition)
    {
        return db('nav')->where($condition)->delete();
    }

    /*
     * 导航列表
     */
    public function getNavList($condition, $field = '*', $page = 0, $order = 'nav_order asc, nav_id desc')
    {
        if ($page) {
            $res = db('nav')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('nav')->where($condition)->field($field)->order($order)->select();
        }
    }

    /**
     * 取单个导航内容
     */
    public function getOneNav($condition, $field = '*')
    {
        return db('nav')->field($field)->where($condition)->find();
    }
}

?>
