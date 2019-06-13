<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/13 0013
 * Time: 11:04
 */

namespace app\admin\controller;


use think\Lang;

class Cases extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/cases.lang.php');
    }

    public function index()
    {
        $model_cases = Model('cases');
        $condition = array();
        $cases_list = $model_cases->getCasesList($condition,'*',5);

        $this->assign('show_page', $model_cases->page_info->render());
        $this->assign('cases_list', $cases_list);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    public function add()
    {
        if (request()->isPost()) {
            $column_id = intval(input('post.column_id'));
            if ($column_id <= 0) {
                $this->error('必须选择栏目');
            }
            $data = array(
                'cases_title' => input('post.cases_title'),
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'seo_description' => input('post.seo_description'),
                'cases_content' => input('post.cases_content'),
                'cases_order' => input('post.cases_order'),
                'cases_wap_ok' => input('post.cases_wap_ok') ? 1 : 0,
                'cases_displaytype' => input('post.cases_displaytype') ? 1 : 0,
                'cases_issue' => $this->admin_info['admin_name'],
                'lang' => config('default_lang'),
                'cases_recycle' => 0,
                'column_id' => $column_id,
            );
            if (!input('param.cases_addtime')) {
                $data['cases_addtime'] = TIMESTAMP;
            } else {
                $data['cases_addtime'] = strtotime(input('param.cases_addtime'));
            }

            //上传文件保存路径
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_CASES;
            if (!empty($_FILES['cases_imgurl']['name'])) {
                $file = request()->file('cases_imgurl');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    $data['cases_imgurl'] = $info->getSaveName();//图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $result = model('cases')->addCases($data);
            if ($result){
                $this->success(lang('add_succ'), url('cases/index'));
            }else{
                $this->error(lang('add_fail'));
            }
        } else {
            $cases = array(
                'cases_show' => 1,
                'cases_addtime' => TIMESTAMP,
                'cases_displaytype' => 1,
                'cases_wap_ok' => 1,
                'column_id' => 0,
            );
            $column_list = model('column')->getColumnList(['column_module'=>COLUMN_CASES]);
            $pic_list = model('pic')->getPicList(array('pic_id' => 0));
            $this->assign('cases', $cases);
            $this->assign('cases_pic_type', ['pic_type' => 'cases']);
            $this->assign('pic_list', $pic_list);
            $this->assign('column_list', $column_list);
            $this->setAdminCurItem('add');
            return $this->fetch('form');
        }
    }

    public function edit()
    {
        $cases_id = input('param.cases_id');
        if ($cases_id <= 0) {
            $this->error('系统错误');
        }
        $condition['pic_type'] = 'cases';
        $condition['pic_type_id'] = $cases_id;
        if (request()->isPost()) {
            $data = array(
                'cases_title' => input('post.cases_title'),
                'seo_title' => input('post.seo_title'),
                'seo_keywords' => input('post.seo_keywords'),
                'seo_description' => input('post.seo_description'),
                'cases_content' => input('post.cases_content'),
                'cases_order' => input('post.cases_order'),
                'cases_issue' => $this->admin_info['admin_name'],
                'column_id' => input('post.column_id'),
            );
            if (!input('param.cases_updatetime')) {
                $data['cases_updatetime'] = TIMESTAMP;
            } else {
                $data['cases_updatetime'] = strtotime(input('param.cases_updatetime'));
            }

            if (!empty($_FILES['cases_imgurl']['name'])) {
                //上传文件保存路径
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_CASES;
                $file = request()->file('cases_imgurl');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    //还需删除原来图片
                    $cases_img_ori = input('param.cases_img_ori');
                    if ($cases_img_ori) {
                        @unlink($upload_file . DS . $cases_img_ori);
                    }
                    $data['cases_imgurl'] = $info->getSaveName();//图片带路径
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            $result = model('cases')->editCases(['cases_id' => $cases_id], $data);
            if ($result >= 0) {
                $this->success(lang('edit_succ'), 'cases/index');
            } else {
                $this->error(lang('edit_fail'));
            }
        } else {
            $pic_list = model('pic')->getpicList($condition);
            $this->assign('pic_list', $pic_list);

            //获取当前帮助中心的内容
            $column_list = model('column')->getColumnList(['column_module'=>COLUMN_CASES]);
            $cases = model('cases')->getOneCases(['cases_id' => $cases_id]);
            $this->assign('cases_pic_type', ['pic_type' => 'cases']);
            $this->assign('cases', $cases);
            $this->assign('column_list', $column_list);
            $this->setAdminCurItem('edit');
            return $this->fetch('form');
        }
    }

    function del()
    {
        $cases_id = intval(input('param.cases_id'));
        if ($cases_id) {
            $condition['cases_id'] = $cases_id;
            $result = model('cases')->delCases($condition);
            model('pic')->delPic(['pic_type_id'=>$cases_id,'pic_type'=>'cases'],'cases');
            if ($result) {
                ds_json_encode(10000, lang('del_succ'));
            } else {
                ds_json_encode(10001, lang('del_fail'));
            }
        } else {
            ds_json_encode(10001, lang('param_error'));
        }
    }

    function ajax()
    {
        $branch = input('param.branch');
        switch ($branch) {
            case 'cases':
                $cases_mod = model('cases');
                $condition = array('cases_id' => intval(input('param.id')));
                $update[input('param.column')] = input('param.value');
                $cases_mod->editcases($condition, $update);
                echo 'true';
        }
    }

    function setcases()
    {
        $cases_type = input('param.cases_type');
        $cases_id = input('param.cases_id');
        $res = model('cases')->getOneCases(['cases_id' => $cases_id], $cases_type);
        $id = $res[$cases_type] == 0 ? 1 : 0;
        $update[$cases_type] = $id;
        $condition['cases_id'] = $cases_id;
        if (model('cases')->editCases($condition, $update)) {
            ds_json_encode(10000, lang('edit_succ'));
        } else {
            $this->error(lang('edit_fail'));
        }
    }

    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => '管理', 'url' => url('Cases/index')
            ), array(
                'name' => 'add', 'text' => '新增', 'url' => url('Cases/add')
            ),
        );
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => '编辑', 'url' => url('Cases/edit')
            );
        }
        return $menu_array;
    }
}