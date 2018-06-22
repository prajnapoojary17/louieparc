<?php

/**
 *
 * File Name : Login Controller
 *
 * Description : Handles admin login page
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
class Login extends MY_Controller
{

    function __construct()
    {
        $this->module = LOGIN;
        parent::__construct();
        if ($this->checkadminLogin($this->module)) {
            redirect(base_url() . "webadmin");
        }
        $this->load->model('Loginmodel');
    }

    /**
     * To show login page
     * 
     */
    public function index()
    {
        $this->load->view(LOGIN);
    }

    /**
     * To validate user while logging in.
     * 
     * If valid user then redirect to admin dashboard page
     * 
     * else redirect to login page 
     */
    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert_error" style="display:block">', '</div>');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('psw', 'Password', 'trim|required|callback_check_password');
        if (!($this->form_validation->run($this))) {
            $this->load->view(LOGIN);
        } else {
            redirect(base_url() . 'webadmin/Manage_users');
        }
    }

    /**
     * To validate password while logging in.
     * 
     * Accepts password as parameter
     * 
     * If valid set the logged_in_admin session value 
     */
    function check_password($password)
    {
        $username = $this->input->post('username');
        $result = $this->Loginmodel->login($username, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'user_id' => $row->userID,
                    'user_name' => $row->userName,
                    'status' => $row->status,
                    'role' => $row->roleID
                );

                if ($sess_array ['status'] == '0') {
                    $this->form_validation->set_message('check_password', 'Inactive User, Please contact LouiePark');

                    return false;
                } else {
                    // set session values
                    $this->session->set_userdata('logged_in_admin', $sess_array);
                }
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_password', 'Invalid Username/Email or Password');
            return false;
        }
    }

    /**
     * To show forgot password page
     * 
     */
    public function forgot()
    {
        $this->load->view('forgot');
    }

    /**
     * To send forgot password likn to user.
     * 
     */
    public function forgotpassword()
    {
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        $useremail = $this->input->post('email');
        $user = $this->Loginmodel->get_user_by_email($useremail);
        if ($user) {
            $slug = md5($user->userID . $user->emailID);
            $message = '<img src="' . base_url('assets/images/logo.png') . '" border="0"><br>
            It looks like you forgot your password. No problem, we’ll get this cleared up.<br><br>
            <b>To reset your password please click the link below and follow the instructions:</b><br><br>
            **<a href="' . base_url('webadmin/reset/' . $user->userID . '/' . $slug) . '"> ' . base_url('webadmin/reset/' . $user->userID . '/' . $slug) . '</a>
            <br><br>
            If you did not request to reset your password then please ignore this email and no changes will occur.';

            $adminuser = $this->Bookingmodel->getadmin();
            $this->load->library('email');
            $this->email->from($constants->fromEmail);
            $this->email->to($adminuser->emailID);
            $this->email->subject('Reset Password');
            $this->email->message($message);
            if (!$this->email->send()) {
                $emailInfo['emailStatus'] = 0;
                $emailInfo['toEmail'] = $adminuser->emailID;
                $emailInfo['fromEmail'] = $constants->fromEmail;
                $emailInfo['content'] = $message;
                $emailInfo['subject'] = 'Reset Password';
                $this->load->model('profile/Profilemodel');
                $this->Profilemodel->saveEmailStatus($emailInfo);
            }
            echo "1";
        } else {
            echo "0";
        }
    }

}
