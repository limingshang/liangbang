<?php

namespace app\common\model;

use think\Model;

class Cases extends Model
{
    public $page_info;

    /*
     * 新增案例
     */
    public function addCases($param)
    {
        return db('cases')->insertGetId($param);
    }

    /*
     * 编辑案例
     */
    public function editCases($condition, $update)
    {
        $condition['lang'] = config('default_lang');
        return db('cases')->where($condition)->update($update);
    }

    /**
     * 删除案例
     * @param unknown $condition
     * @return boolean
     */
    public function delCases($condition)
    {
        $condition['lang'] = config('default_lang');
        $cases_array = $this->getCasesList($condition, 'cases_id,cases_imgurl');
        $casesid_array = array();
        foreach ($cases_array as $value) {
            $casesid_array[] = $value['cases_id'];
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_CASES . DS . $value['cases_imgurl']);
        }
        return db('cases')->where(array('cases_id' => array('in', $casesid_array)))->delete();
    }

    /*
     * 案例列表
     */
    public function getCasesList($condition = [], $field = '*', $page = 0, $order = 'cases_order desc, cases_id desc', $limit = '')
    {
        if(gettype($condition) === 'string') {
            $condition = [];
            $condition['lang'] = config('default_lang');
        }
        if ($limit) {
            return db('cases')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        } else {
            $res = db('cases')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        }
    }

    /**
     * 取单个案例内容
     */
    public function getOneCases($condition, $field = '*')
    {
        $condition['lang'] = config('default_lang');
        return db('cases')->field($field)->where($condition)->find();
    }
}

?>
