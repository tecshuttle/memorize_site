<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ng extends CI_Controller
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
            'appName' => 'blog',
            'css' => array(
                '/css/bootstrap-3.1.1/css/bootstrap.min.css',
                '/css/blog.css'
            ),
            'js' => array(
                '/js/angular.1.3.15.js',
                '/js/angular-route.1.3.16.js',
                '/js/ionic-v1.0.0/js/angular/angular-sanitize.js',
                '/js/showdown.min.js',
                '/js/blog/ngblog.js'
            )
        );

        $this->load->view('header', $data);
        $this->load->view('blog/ngIndex', $data);
        $this->load->view('footer', $data);
    }

    public function test()
    {
        $data = array(
            'title' => 'Test',
            'appName' => 'blog',
            'css' => array(),
            'js' => array(
                '/js/blog/test.js'
            )
        );

        $this->load->view('header', $data);
        $this->load->view('footer', $data);
    }

    public function memo_type()
    {
        $data = array(
            'title' => 'memo分类',
            'appName' => 'memoType',
            'css' => array(
                '/css/bootstrap-3.1.1/css/bootstrap.min.css',
                '/css/blog.css'
            ),
            'js' => array(
                '/js/angular.1.3.15.js',
                '/js/angular-route.1.3.16.js',
                '/js/memo/ng-type.js'
            )
        );

        $this->load->view('header', $data);
        $this->load->view('memo/ng-type', $data);
        $this->load->view('footer', $data);
    }

    public function getList()
    {
        $request_body = file_get_contents('php://input', true);
        $body = json_decode($request_body, true);
        $tagged_id = $body['tagged_id'];

        if ($tagged_id === '') {
            $blogs = $this->blog_model->getUnTagged();

            foreach ($blogs as &$blog) {
                $blog->title = $this->getTitle($blog->text);
                unset($blog->text);
                unset($blog->ctime);
                unset($blog->mtime);
            }

            echo json_encode($blogs);
        } else {
            $data = $this->blog_model->getTagged($tagged_id);

            foreach ($data as &$blog) {
                $blog->title = $this->getTitle($blog->text);
                unset($blog->text);
                unset($blog->ctime);
                unset($blog->mtime);
            }

            echo json_encode($data);
        }
    }

    private function getTitle($text)
    {
        $lines = explode("\n", $text);
        $title = $lines[0];

        return trim(str_replace('#', '', $title));
    }

    public function getBlog()
    {
        $request_body = file_get_contents('php://input', true);
        $body = json_decode($request_body, true);
        $cid = $body['cid'];

        $option = array(
            'cid' => $cid
        );

        $blog = $this->blog_model->get($option);
        $tags = $this->blog_model->getTags($cid);

        $blog->tags = $tags;

        echo json_encode($blog);
    }

    public function save()
    {
        $request_body = file_get_contents('php://input', true);
        $body = json_decode($request_body, true);
        $cid = $body['cid'];
        $text = $body['text'];

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
            'cid' => $cid,
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
