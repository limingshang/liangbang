<?php

namespace app\common\model;

use think\Model;

class Product extends Model
{
    public $page_info;

    /*
     * 新增产品
     */
    public function addProduct($param)
    {
        return db('product')->insertGetId($param);
    }

    /*
     * 编辑产品
     */
    public function editProduct($condition, $update)
    {
        return db('product')->where($condition)->update($update);
    }

    /**
     * 删除产品
     * @param unknown $condition
     * @return boolean
     */
    public function delProduct($condition)
    {
        $product_array = $this->getProductList($condition, 'product_id,product_imgurl');
        $productid_array = array();
        foreach ($product_array as $value) {
            $productid_array[] = $value['product_id'];
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_PRODUCT . DS . $value['product_img']);
        }
        return db('product')->where(array('product_id' => array('in', $productid_array)))->delete();
    }

    /*
     * 产品列表
     */
    public function getProductList($condition, $field = '*', $page = 0, $order = 'product_order desc, product_id desc', $limit = '')
    {
        if ($limit) {
            return db('product')->where($condition)->field($field)->order($order)->page($page)->limit($limit)->select();
        } else {
            $res = db('product')->where($condition)->field($field)->order($order)->paginate($page);
            $this->page_info = $res;
            return $res->items();
        }
    }

    /**
     * 取单个产品内容
     */
    public function getOneProduct($condition, $field = '*')
    {
        return db('product')->field($field)->where($condition)->find();
    }
}

?>
