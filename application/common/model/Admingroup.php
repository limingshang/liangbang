<?php
namespace app\common\model;
use think\Model;

class Admingroup extends Model
{
    /**
     * 权限组列表
     */
    public function getAdminGroupList($field = '*')
    {
        return db('admingroup')->field($field)->select();
    }

    /**
     * 新增管理员权限组
     */
    public function addAdminGroup($data)
    {
        return db('admingroup')->insertGetId($data);
    }

    /**
     * 编辑管理员权限组
     */
    public function editAdminGroup($condition, $data)
    {
        return db('admingroup')->where($condition)->update($data);
    }

    /**
     * 删除权限组
     */
    public function delAdminGroup($condition)
    {
        return db('admingroup')->where($condition)->delete();
    }

    /**
     * 取单个权限组
     */
    public function getOneAdmingroup($condition, $field = '*')
    {
        return db('admingroup')->field($field)->where($condition)->find();
    }
}