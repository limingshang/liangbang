<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/13 0013
 * Time: 11:27
 */

namespace app\common\model;


use think\Model;

class Pic extends Model
{
    public function addPic($data)
    {
        return db('pic')->insertGetId($data);
    }

    public function editPic($condition, $data)
    {
        return db('pic')->where($condition)->update($data);
    }

    public function getPicList($condition, $page = '', $order = 'pic_id desc')
    {
        if ($page) {
            $res = db('pic')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('pic')->where($condition)->order($order)->select();
        }
    }

    public function delPic($condition, $attach_type)
    {
        switch ($attach_type) {
            case 'cases':
                $attach_type = ATTACH_CASES;
                break;
            case 'news':
                $attach_type = ATTACH_NEWS;
                break;
            case 'product':
                $attach_type = ATTACH_PRODUCT;
            default:
                break;
        }
        $casespic_list = $this->getpicList($condition);
        foreach ($casespic_list as $key => $casespic) {
            @unlink(BASE_UPLOAD_PATH . DS . $attach_type . DS . $casespic['pic_cover']);
        }
        return db('pic')->where($condition)->delete();
    }
}