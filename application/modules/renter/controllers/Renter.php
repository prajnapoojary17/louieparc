<?php

/**
 * File Name : Renter Controller
 *
 * Description : This is used to Handle Renter 
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

class Renter extends MY_Controller
{

    function __construct()
    {
        $this->module = "renter";
        parent::__construct();
        $this->load->model('Rentermodel');
    }

    /**
     * Index function to load renter sign-up first view page
     *  
     */
    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url() . 'dashboard');
        } else {
            $this->_tpl('Renter');
        }
    }

    /**
     * Function to view sign up for Renter Page
     *    
     */
    public function signup()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url() . 'dashboard');
        } else {
            $this->_tpl('Signup');
        }
    }

}
