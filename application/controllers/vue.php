<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class vue extends CI_Controller
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
                '/css/blog.css'
            ),
            'js' => array(
                '/js/jquery-1.11.1.min.js',
                '/js/vue.min.js',
                '/js/marked.min.js',
                '/js/blog/blog.js'
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
            'offset' => ($page - 1) * $per_page,
            'sortBy' => 'ctime'
        );

        $data = $this->blog_model->get($option);

        echo json_encode($data);

    }

    public function save()
    {
        $cid = $this->input->post('cid', true);
        $text = $this->input->post('text', true);

        if ($cid == 0) {
            $this->insert($text);
        } else {
            $this->update($cid, $text);
        }
    }

    public function delete()
    {
        $cid = $this->input->post('cid', true);

        $option = array(
            'cid' => $cid
        );

        $this->blog_model->delete($option);
    }

    private function update($cid, $text)
    {
        $option = array(
            'mtime' => time(),
            'cid' => $cid,
            'text' => $text
        );

        $this->blog_model->update($option);

        echo json_encode(array(
            'success' => true,
            'op' => 'update'
        ));
    }

    private function insert($text)
    {
        $option = array(
            'ctime' => time(),
            'text' => $text
        );

        $this->blog_model->insert($option);

        echo json_encode(array(
            'success' => true,
            'cid' => $this->db->insert_id(),
            'op' => 'insert'
        ));

    }


}

/* End of file */
