<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller
{
    public function index()
    {
        session_start();
        $admin = false;
        if (isset($_SESSION['admin'])) {
            $admin = $_SESSION['admin'];
        } else if (isset($_COOKIE['admin'])) {
            $admin = $_COOKIE['admin'];
        }

        if (! $admin) {
            header('Location: /admin/login');
        }

        $data = array(
            'user' => $admin,
            'msg' => 'admin',
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/extjs4/locale/ext-lang-zh_CN.js',
                '/js/admin/main/config.js',
                '/js/admin/main/config_user.js',
                '/js/admin/main/config_general.js',
                '/js/admin/main/config_user_general.js',
                '/js/extjs4/ux/TabCloseMenu.js',
                '/js/admin/common/utils.js',
                '/js/admin/main/main.js'
            )
        );

        $this->load->view('admin/home_header', $data);
        $this->load->view('admin/script', $data);
    }

    //显示登入页面
    public function login()
    {
        $data = array(
            'msg' => '后台登入',
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'

            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/login_form.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    //登入验证
    public function login2()
    {
        $name = $_POST['name'];
        $password = $_POST['password'];

        $users = array(
            'admin' => 'admin',
            'user' => 'user',
            'system' => 'system',
            'dba' => 'dba',
            'guest' => 'guest'
        );

        if (isset($users[$name])) {
            if ($users[$name] == $password) {
                echo json_encode(array(
                    'success' => true
                ));
                session_start();
                $_SESSION['admin'] = $name;

                $expire = time() + 30 * 86400; // 30 day
                setcookie('admin', $name, $expire, '/');
            } else {
                echo json_encode(array(
                    'success' => false,
                    'msg' => 'password incorrect'
                ));
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'msg' => 'no user'
            ));
        }
    }

    public function logout()
    {

        session_start();
        unset($_SESSION['admin']);

        $expire = -1;
        setcookie('admin', '', $expire, '/');

        $this->login();
    }

    public function jobs_userFavorites()
    {
        $data = array(
            'msg' => 'admin-articles',
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/extjs4/locale/ext-lang-zh_CN.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/ZeroClipboard/ZeroClipboard.min.js',
                '/js/admin/jobs/userFavorites.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function articles()
    {
        $data = array(
            'msg' => 'admin-articles',
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'

            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/cms_add_form.js',
                '/js/admin/cms.js',
                '/js/admin/articles.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function gallery()
    {
        $data = array(
            'msg' => 'Admin-Gallery',
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'

            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/gallery_form.js',
                '/js/admin/gallery_grid.js',
                '/js/admin/cms.js',
                '/js/admin/gallery.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function products()
    {
        $data = array(
            'msg' => 'admin-products',
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/cms_add_form.js',
                '/js/admin/cms.js',
                '/js/admin/products.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function faqs()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/faqs.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function users()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/users.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function enquiries()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/enquiries.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function settings()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/grid_form.js',
                '/js/admin/settings.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function subscriptions()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/subscriptions.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function sample_request()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/sample_request.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function po_request()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/po_request.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    public function rfq_requirement()
    {
        $data = array(
            'msg' => 'admin-' . __FUNCTION__,
            'base_url' => $this->config->config['base_url'],
            'css' => array(
                '/js/extjs4/resources/css/ext-all.css',
                '/css/admin/themes/ijobs-v3/css/index.css',
                '/css/admin/themes/ijobs-v3/css/ijobs.css'
            ),
            'js' => array(
                '/js/extjs4/bootstrap.js',
                '/js/admin/common/common.js',
                '/js/admin/common/utils.js',
                '/js/admin/common/ux/LinkColumn.js',
                '/js/admin/grid.js',
                '/js/admin/rfq_requirement.js'
            )
        );

        $this->load->view('admin/header', $data);
        $this->load->view('admin/script', $data);
    }

    //根据module，返回相应grid数据
    public function getList()
    {
        $option = $_POST;
        $model = $option['module'] . '_model';

        $this->load->model($model);
        $data = $this->$model->getList($option);

        echo json_encode($data);
    }

    public function gridDelete()
    {
        $id = $_POST['id'];
        $option = $_POST;
        $model = $option['module'] . '_model';

        $this->load->model($model);
        $this->$model->deleteByID($id);

        echo json_encode(array(
            'success' => true
        ));
    }

    // todo: 两个是一样的，优化一下
    public function products_tree()
    {
        $this->load->model('types_model');
        $data = $this->types_model->get_menu('products');

        $menu = array();

        //取根分类
        foreach ($data as $key => $row) {
            if ($row->belong == 0) {
                $id = $row->id;
                array_push($menu, array(
                    'text' => $row->name,
                    'id' => $id
                ));
            }
        }

        foreach ($menu as $i => $item) {
            $menu[$i] = $this->get_submenu($item, $data);
        }

        //print_r($menu); //输出测试数据
        echo json_encode($menu);
    }

    // todo: 三个是一样的，优化一下
    public function articles_tree()
    {
        $this->load->model('types_model');

        $data = $this->types_model->get_menu('articles');

        $menu = array();

        //取根分类
        foreach ($data as $key => $row) {
            if ($row->belong == 0) {
                $id = $row->id;
                array_push($menu, array(
                    'text' => $row->name,
                    'id' => $id
                ));
            }
        }

        foreach ($menu as $i => $item) {
            $menu[$i] = $this->get_submenu($item, $data);
        }

        echo json_encode($menu);
    }

    // todo: 三个是一样的，优化一下
    public function gallery_tree()
    {
        $this->load->model('types_model');

        $data = $this->types_model->get_menu('gallery');

        $menu = array();

        //取根分类
        foreach ($data as $key => $row) {
            if ($row->belong == 0) {
                $id = $row->id;
                array_push($menu, array(
                    'text' => $row->name,
                    'id' => $id
                ));
            }
        }

        foreach ($menu as $i => $item) {
            $menu[$i] = $this->get_submenu($item, $data);
        }

        echo json_encode($menu);
    }

    //递归查询子分类
    public function get_submenu($item, $data)
    {
        $sub = array();
        foreach ($data as $j => $row) {
            if ($row->belong == $item['id']) {
                array_push($sub, array(
                    'text' => $row->name,
                    'id' => $row->id
                ));
            }
        }


        if (count($sub) == 0) {
            $item['leaf'] = true;
        } else {
            foreach ($sub as $j => $ob) {
                $sub[$j] = $this->get_submenu($ob, $data);
            }
            $item['children'] = $sub;
        }

        return $item;
    }


    public function getTypeInfo()
    {
        $this->load->model('types_model');

        $data = $this->types_model->getByID($_POST['id']);
        echo json_encode($data);
    }

    public function saveTypeInfo()
    {
        $this->load->model('types_model');
        $data = $this->types_model->saveTypeInfo($_POST);
    }

    public function addType()
    {
        $this->load->model('types_model');
        $this->types_model->addType($_POST);

        echo json_encode(array(
            'success' => true
        ));
    }

    public function deleteType()
    {
        $this->load->model('types_model');

        $this->types_model->deleteByID($_POST['id']);

        echo json_encode(array(
            'success' => true
        ));
    }
}

/* End of file */