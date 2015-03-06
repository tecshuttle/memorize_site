<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class blog extends CI_Controller
{
    var $uid = 0;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('blog_model');

        session_start();
        if (isset($_SESSION['uid'])) {
            $this->uid = $_SESSION['uid'];
        }

        header("Access-Control-Allow-Origin: *");
    }

    public function index()
    {
        $data = array(
            'title' => 'Blog',
            'css' => array(
                'http://www.tomtalk.net/blog/css/bootstrap.css',
                //'http://www.tomtalk.net/blog/css/bootstrap-responsive.css',
                '/vue/css/blog.css'
            ),
            'js' => array(
                '/vue/js/jquery-1.11.1.min.js',
                '/vue/js/vue.min.js',
                '/vue/js/marked.min.js',
                '/vue/js/blog/blog.js'
            )
        );

        $this->load->view('header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('footer', $data);
    }

    public function getList()
    {
        $page = $this->input->get('page', true);

        $page = ($page ? $page : 1);
        $per_page = 10;

        $option = array(
            'limit' => $per_page,
            'offset' => ($page - 1) * $per_page
        );

        $data = $this->blog_model->get($option);

        echo json_encode($data);

    }

    public function save()
    {
        $cid = $this->input->post('cid', true);
        $text = $this->input->post('text', true);

        $option = array(
            'cid' => $cid,
            'text' => $text
        );

        $this->blog_model->update($option);

        echo json_encode(array(
            'success' => true

        ));

    }


}

/* End of file */
