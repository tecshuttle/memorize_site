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
            'title' => 'Company profile',
            'css' => array(
                '/vue/css/blog.css'
            ),
            'js' => array(
                '/vue/js/vue.min.js',
                '/vue/js/marked.min.js',
                '/vue/js/blog/blog.js'
            )
        );

        $this->load->view('header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('footer', $data);
    }
}

/* End of file */
