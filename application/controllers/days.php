<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class days extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('days_model');
    }

    function index()
    {
        $data = $this->days_model->get(array());

        echo json_encode($data['data']);
    }

    function update() {
        $arguments = json_decode(file_get_contents('php://input'));
        print_r($arguments);
        print_r($arguments['day']);
    }
}

/* End of file */
