<?php

namespace app\common\model;

use think\Model;

class link extends Model
{
    public $page_info;

    /*
     * 新增友链
     */
    public function addLink($param)
    {
        return db('link')->insertGetId($param);
    }

    /*
     * 编辑友链
     */
    public function editLink($condition, $update)
    {
        return db('link')->where($condition)->update($update);
    }

    /**
     * 删除友链
     * @param unknown $condition
     * @return boolean
     */
    public function delLink($condition)
    {
        $link_array = $this->getlinkList($condition, 'link_id,link_weblogo');
        $linkid_array = array();
        foreach ($link_array as $value) {
            $linkid_array[] = $value['link_id'];
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_CASES . DS . $value['link_weblogo']);
        }
        return db('link')->where(array('link_id' => array('in', $linkid_array)))->delete();
    }

    /*
     * 友链列表
     */
    public function getLinkList($condition, $field = '*', $page = 0, $order = 'link_order asc, link_id desc')
    {
        if ($page) {
            $res = db('link')->where($condition)->field($field)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('link')->where($condition)->field($field)->order($order)->select();
        }
    }

    /**
     * 取单个友链内容
     */
    public function getOneLink($condition, $field = '*')
    {
        return db('link')->field($field)->where($condition)->find();
    }
}

?>
