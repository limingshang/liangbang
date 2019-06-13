<?php



namespace app\admin\controller;
use think\Lang;
class Admin extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/admin.lang.php');
    }

    /**
     * 管理员列表
     * @return mixed
     */
    public function index()
    {
        $model_admin = Model('admin');
        $condition = array();
        $admin_list = $model_admin->getAdminList($condition, '*', 5);
        $this->assign('admin_list', $admin_list);
        $this->assign('show_page', $model_admin->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 添加管理员
     * @return mixed
     */
    public function add()
    {
        if (request()->isPost()) {
            $model_admin = Model('admin');
            //判断用户名是否存在
            if ($model_admin->getOneAdmin(['admin_name' => input('post.admin_name')])) {
                $this->error(lang('admin_existence'));
            }
            $data = array(
                'admin_name' => input('post.admin_name'),
                'admin_password' => input('post.admin_password') ? md5(input('post.admin_password')) : md5('123'),
                'admin_group_id' => input('post.group_id'),
                'admin_add_time' => TIMESTAMP,
            );
            //添加到数据库
            $result = $model_admin->addAdmin($data);
            if ($result) {
                dsLayerOpenSuccess(lang('admin_add_succ'));
            } else {
                $this->error(lang('admin_add_fail'));
            }
        } else {
            $admin_array = array('add' => 1);
            $admin_group = model('admingroup')->getAdminGroupList('group_name,group_id');
            $this->assign('admin_group', $admin_group);
            $this->assign('admin', $admin_array);
            return $this->fetch('form');
        }
    }

    public function edit()
    {
        $admin_id = input('param.admin_id');
        if (empty($admin_id)) {
            $this->error(lang('param_error'));
        }
        $model_admin = Model('admin');
        if (!request()->isPost()) {
            $condition['admin_id'] = $admin_id;
            $admin_array = $model_admin->getOneAdmin($condition);
            $admin_array['add'] = 0;
            $admin_group = model('admingroup')->getAdminGroupList('group_name,group_id');
            $this->assign('admin_group', $admin_group);
            $this->assign('admin', $admin_array);
            return $this->fetch('form');
        } else {
            $data = array(
                'admin_name' => input('post.admin_name'),
                'admin_group_id' => input('post.group_id')
            );
            if (input('post.admin_password')) {
                $data['admin_password'] = md5(input('post.admin_password'));
            }
            //验证数据  END
            $result = $model_admin->editAdmin(array('admin_id' => intval($admin_id)), $data);
            if ($result) {
                dsLayerOpenSuccess(lang('admin_edit_succ'));
            } else {
                $this->error(lang('admin_edit_fail'));
            }
        }
    }

    public function del()
    {
        $admin_id = input('param.admin_id');
        if (empty($admin_id)) {
            $this->error(lang('param_error'));
        }
        $result = db('admin')->delete($admin_id);
        if ($result) {
            ds_json_encode(10000, lang('admin_del_succ'));
        } else {
            ds_json_encode(10001, lang('admin_del_fail'));
        }
    }

    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'index', 'text' => lang('ds_manage'), 'url' => url('Admin/index')
            ), array(
                'name' => 'add', 'text' => lang('ds_add'), 'url' => "javascript:dsLayerOpen('".url('Admin/add')."','".lang('ds_add')."')"
            ),
        );
        return $menu_array;
    }
}