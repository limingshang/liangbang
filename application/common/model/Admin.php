<?php
namespace app\common\model;
use think\Model;
class Admin extends Model
{
    /**
     * 管理员列表
     */
    public function getAdminList($condition = array(), $field = '*', $page = 0, $order = 'admin_id desc')
    {
        if ($page) {
            $member_list = db('admin')->alias('a')->join('__ADMINGROUP__ g', 'g.group_id = a.admin_group_id', 'LEFT')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $member_list;
            return $member_list->items();
        } else {
            return db('admin')->alias('a')->join('__ADMINGROUP__ g', 'g.group_id = a.admin_group_id', 'LEFT')->where($condition)->order($order)->select();
        }
    }

    /**
     * 新增管理员
     */
    public function addAdmin($data)
    {
        return db('admin')->insertGetId($data);
    }

    /**
     * 编辑管理员
     */
    public function editAdmin($condition, $data)
    {
        return db('admin')->where($condition)->update($data);
    }

    /**
     * 删除管理员
     */
    public function delAdmin($condition)
    {
        return db('admin')->where($condition)->delete();
    }

    /**
     * 取单个管理员
     */
    public function getOneAdmin($condition, $field = '*')
    {
        return db('admin')->field($field)->where($condition)->find();
    }
}