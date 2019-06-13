<?php

namespace app\common\model;

use think\Model;

class Message extends Model
{
    public $page_info;
    
    
    /**
     * 添加留言
     * @param type $param
     * @return type
     */
    public function addMessage($param)
    {
        return db('message')->insertGetId($param);
    }

    /**
     * 删除留言
     * @param unknown $condition
     * @return boolean
     */
    public function delMessage($condition)
    {
        return db('message')->where($condition)->delete();
    }

    /*
     * 回复留言
     */
    public function editMessage($condition, $update)
    {
        return db('message')->where($condition)->update($update);
    }

    /*
     * 留言列表
     */
    public function getMessageList($condition, $field = '*', $page = 0, $order = 'message_addtime asc, message_id desc', $limit = '')
    {
        if ($limit) {
            return db('message')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        } else {
            $res = db('message')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        }
    }

    /**
     * 取单个留言内容
     */
    public function getOneMessage($condition, $field = '*')
    {
        return db('message')->field($field)->where($condition)->find();
    }
}

?>
