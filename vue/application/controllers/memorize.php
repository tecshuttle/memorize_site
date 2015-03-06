<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class memorize extends CI_Controller
{
    var $uid = 1;

    function __construct()
    {
        parent::__construct();
        $this->load->model('type_model');
        $this->load->model('memo_model');
    }

    public function getType()
    {
        $type = $this->type_model->get(array(
            'uid' => $this->uid
        ));


        echo json_encode($type['data']);
    }

    public function getMemo()
    {
        $data = $this->memo_model->getMemo(array(
            'uid' => $this->uid
        ));

        echo json_encode($data);
    }

    public function saveType()
    {
        $this->type_model->update(array(
            'id' => $this->input->post('_id', true),
            'uid' => $this->input->post('uid', true),
            'name' => $this->input->post('type_name', true),
            'priority' => $this->input->post('priority', true),
            'color' => $this->input->post('color', true),
            'sync_state' => $this->input->post('sync_state', true)
        ));
    }
}

/* End of file */
