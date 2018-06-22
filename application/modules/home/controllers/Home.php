<?php

/**
 *
 * File Name : Home Controller
 *
 * Description : Home controller
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

class Home extends MY_Controller
{

    function __construct()
    {
        $this->module = "home";
        parent::__construct();
    }

    /**
     * To show the home page after login
     *
     */
    public function index()
    {
        if ($this->checkLogin($this->module)) {
            $this->load->model('usermanagement/Usermanagementmodel');
            $data = $this->session->userdata('logged_in');
            $userId = $data ['user_id'];
            $userData ['result'] = $this->Usermanagementmodel->getUser($userId);
            $this->_tpl('Userhome', $userData);
        } else {
            $this->_tpl('Home');
        }
    }

}
