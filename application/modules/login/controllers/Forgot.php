<?php

/**
 *
 * File Name : Forgot Controller
 *
 * Description : This is used to handle forgot password
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

class Forgot extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user', '', TRUE);
    }

    function _remap($method, $params = array())
    {
        $methodToCall = method_exists($this, $method) ? $method : 'index';
        return call_user_func_array(array(
            $this,
            $methodToCall
                ), $params);
    }

    /**
     *
     * To handle forgot password
     * 
     */
    public function index()
    {
        $userId = $this->uri->segment(3);
        $user = $this->user->userchck($userId);
        if (!$userId) {
            $data ['msg'] = INVALID_RESET_CODE;
        }
        $hash = $this->uri->segment(4);
        if (!$hash) {
            $data ['msg'] = INVALID_RESET_CODE;
        }
        $data ['success'] = false;
        if ($user) {
            $slug = md5($user->userID . $user->emailID . date('Ymd'));
            if ($hash != $slug) {
                $data ['msg'] = INVALID_RESET_CODE;
            }
        } else {
            $data ['msg'] = INVALID_RESET_CODE;
        }
        $this->form_validation->set_error_delimiters('<div class="error_box" style="display:block">', '</div>');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('password_conf', 'Confirm Password', 'required|matches[password]');
        if ($this->form_validation->run($this)) {
            if ($user) {
                $this->user->reset_password($user->userID, $this->input->post('password'));
            }
            $data ['success'] = true;
            $this->load->view('login', $data);
        }

        $this->_tpl('forgot', $data);
    }

}
