<?php

/**
 *
 * File Name : Reset Controller
 *
 * Description : Handles admin resetting password
 *
 * Created By : Reshma N
 *
 * Created Date : 11/05/2016
 *
 * Last Modified By : Reshma N
 *
 * Last Modified Date : 12/07/2016
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Reset extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Loginmodel', '', TRUE);
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
     * To validate reset password
     * 
     */
    public function index()
    {
        $userId = $this->uri->segment(3);
        $user = $this->Loginmodel->userchck($userId);
        if (!$userId) {
            $data ['msg'] = INVALID_RESET_CODE;
        }
        $hash = $this->uri->segment(4);
        if (!$hash) {
            $data ['msg'] = INVALID_RESET_CODE;
        }
        $data ['success'] = false;
        if ($user) {
            $slug = md5($user->userID . $user->emailID);
            if ($hash != $slug) {
                $data ['msg'] = INVALID_RESET_CODE;
            }
        } else {
            $data ['msg'] = INVALID_RESET_CODE;
        }
        $this->form_validation->set_error_delimiters('<div class="error_box" style="display:block">', '</div>');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[7]|max_length[12]');
        $this->form_validation->set_rules('password_conf', 'Confirm Password', 'required|min_length[7]|max_length[12]|matches[password]');
        if ($this->form_validation->run($this)) {
            if ($user) {
                $this->Loginmodel->reset_password($user->userID, $this->input->post('password'));
            }
            $data ['success'] = true;
            $this->load->view(LOGIN, $data);
        } else {
            $this->load->view('reset', $data);
        }
    }

}
