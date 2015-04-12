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
        $method = $_SERVER['REQUEST_METHOD'];

        $week = $this->f->get_time_range_of_week(date('Y-m-d', time()));


        if ($method == 'GET') {
            $data = $this->days_model->get_days(array(
                'time' => "$week->start",
            ));

            echo json_encode($data);
            exit;
        }


        print_r($_SERVER['REQUEST_METHOD']);
        print_r($_POST);
        echo file_get_contents('php://input');
    }

    function update()
    {
        $this->days_model->update($_POST);

        echo 'ok';
    }

    function insert()
    {

        $data = $this->days_model->get(array(
            'sortBy' => 'time',
            'sortDirection' => 'DESC',
            'limit' => 1
        ));

        $time = strtotime(date('Y-m-d', $data['data'][0]->time));

        for ($i = 1; $i < 30; $i++) {

            $time += 3600 * 24;

            echo date('Y-m-d', $time);

            $this->days_model->insert(array(
                'time' => $time
            ));
        }
    }
}

/* End of file */
