<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class tag_api extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('tag_model');
    }

    public function index()
    {
        echo '';
    }

    public function getList()
    {
        $option = array(
            'module' => 'blog'
        );

        $query = $this->tag_model->get($option);

        echo json_encode($query['data']);
    }

    public function getListTotal()
    {
        $tags = $this->tag_model->getListTotal();

        echo json_encode($tags);
    }

    public function tag()
    {
        $request_body = file_get_contents('php://input', true);
        $body = json_decode($request_body, true);
        $cid = $body['blog_id'];
        $tag_id = $body['tag_id'];
        $is_tagged = $body['is_tagged'];

        if ($is_tagged === true) {
            $this->tag_model->add_tag($cid, $tag_id);
        } else {
            $this->tag_model->del_tag($cid, $tag_id);
        }
    }
}

/* End of file */