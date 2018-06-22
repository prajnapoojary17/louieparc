<?php

/**
 * File Name : Parker Controller
 *
 * Description : This is used to Handle Parker 
 *
 * Created By : Reshma N
 *
 * Created Date : 10/18/2016
 *
 * Last Modified By : Reshma N
 *
 * Last Modified Date : 11/29/2016
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Parker extends MY_Controller
{

    function __construct()
    {
        $this->module = "parker";
        parent::__construct();
        $this->load->model('Parkermodel');
    }

    /**
     * Index function to view parker sign-up page
     *  
     */
    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url() . 'dashboard');
        } else {
            $this->_tpl('parker');
        }
    }

}
