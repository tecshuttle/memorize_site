<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct($type = NULL)
    {
        parent::__construct();

        if (ENVIRONMENT !== 'production') {

            //$this->output->enable_profiler(TRUE);
        }

    }
}


/* End of file Controller.php */