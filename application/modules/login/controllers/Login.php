<?php

/**
 *
 * File Name : Login Controller
 *
 * Description : Handles login of users
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

class Login extends MY_Controller
{

    function __construct()
    {
        $this->module = LOGIN;
        parent::__construct();
        if ($this->checkLogin($this->module)) {
            redirect(base_url() . DASHBOARD);
        }
        $this->load->model('user', '', TRUE);
        $this->load->library('facebook');
        $this->load->model('usermanagement/Usermanagementmodel');
    }

    /**
     * Login
     *
     * @redirects to dashboard for logged or else login
     */
    public function index()
    {
        $drivewayID = $this->input->post('drivewayId');
        if (isset($drivewayID)) {
            $fromDate = $this->input->post('fromDate');
            $fromTime = $this->input->post('fromTime');
            $toDate = $this->input->post('toDate');
            $toTime = $this->input->post('toTime');
            $price = $this->input->post('price');
            $totalPrice = $this->input->post('totalPrice');
            $ownerId = $this->input->post('ownerId');
            $filterPrice = $this->input->post('filterPrice');
            $location = $this->input->post('location');
            $totalHours = $this->input->post('totalHours');
            $latitude = $this->input->post('latitude');
            $longitude = $this->input->post('longitude');
            $option = $this->input->post('option');
            $stripefees = $this->input->post('stripefees');
            $stripeprocessingfees = $this->input->post('stripeprocessingfees');
            $applicationfees = $this->input->post('applicationfees');
            $sess_array = array(
                'driveway_id' => $drivewayID,
                'fromDate' => $fromDate,
                'fromTime' => $fromTime,
                'toDate' => $toDate,
                'toTime' => $toTime,
                'price' => $price,
                'totalPrice' => $totalPrice,
                'ownerId' => $ownerId,
                'filterPrice' => $filterPrice,
                'location' => $location,
                'totalHours' => $totalHours,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'option' => $option,
                'stripefees' => $stripefees,
                'stripeprocessingfees' => $stripeprocessingfees,
                'applicationfees' => $applicationfees
            );
            // set session values
            $this->session->set_userdata('driveway_search', $sess_array);
        }
        if ($this->checkLogin($this->module)) {
            redirect(base_url() . DASHBOARD);
        } else {
            $this->_tpl(LOGIN);
        }
    }

    /**
     * validates the login
     *
     * @redirects to dashboard on successfull login
     */
    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert_error" style="display:block">', '</div>');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');
        if (!($this->form_validation->run($this))) {
            // Field validation failed. User redirected to login page
            $this->_tpl(LOGIN);
        } else {
            $drivewayinfo = $this->session->userdata('driveway_search');
            $driveway_id = $drivewayinfo['driveway_id'];
            if ($driveway_id) {
                redirect(base_url() . "driveway");
            } else {
                redirect(base_url() . DASHBOARD);
            }
        }
    }

    /**
     * Login using facebook
     *
     * @redirects to dashboard for logged or else login
     */
    public function facebook()
    {
        if (isset($_POST ['accessToken'])) {
            $token = $_POST ['accessToken'];
            require_once APPPATH . '/third_party/Facebook/autoload.php';
            require_once APPPATH . '/third_party/Facebook/Facebook.php';

            $fb = new Facebook\Facebook([
                'app_id' => '1578367195791933',
                'app_secret' => '69e0d86137ce82e68f36dc2afd9058d0',
                'default_graph_version' => 'v2.2'
            ]);
            $fb->getRedirectLoginHelper();
            try {
                $response = $fb->get('/me?fields=id,name,email', $token);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit();
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit();
            }

            $user = $response->getGraphUser();
            $fb_email = $user [EMAIL];
            $fb_userID = $this->Usermanagementmodel->fb_email_exist($fb_email);
            if ($fb_userID) {
                $result = $this->Usermanagementmodel->getUserInfo($fb_userID->userID);
                if ($result) {
                    $sess_array = array();
                    foreach ($result as $row) {
                        $sess_array = array(
                            'user_id' => $row->userID,
                            'user_name' => $row->userName,
                            STATUS => $row->status,
                            'role' => $row->roleID,
                            PROFILE => $row->profileImage,
                            FB_TOKEN => $token
                        );
                        // set session values
                        $this->session->set_userdata('logged_in', $sess_array);
                    }
                }
                $message = "exist";
            } else {
                $fbId = $user ['id'];
                $fullName = $user ['name'];
                $name = explode(' ', $fullName);
                $request = $fb->get('/me/picture?redirect=false&width=140&height=140', $token);
                $pic = $request->getGraphObject()->asArray();
                $profile_pic = $pic ['url'];
                $sess_array = array(
                    'fbId' => $fbId,
                    'fname' => $name [0],
                    'lname' => $name [1],
                    'fb_email' => $fb_email,
                    'role' => 2,
                    PROFILE => $profile_pic,
                    FB_TOKEN => $token
                );

                // set session values
                $this->session->set_userdata('logged_fb', $sess_array);
                $message = "new";
            }
        } else {
            $message = "invalid";
        }
        $response = array(
            STATUS => true,
            "message" => $message
        );
        $this->apiResponse($response);
    }

    /**
     * To validate the password enterd during login
     *
     * if valid then set the session 'logged_in'
     */
    function check_password($password)
    {
        $username = $this->input->post('username');
        // query the database
        $result = $this->user->login($username, $password);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'user_id' => $row->userID,
                    'user_name' => $row->userName,
                    STATUS => $row->status,
                    'role' => $row->roleID,
                    PROFILE => $row->profileImage,
                    FB_TOKEN => ''
                );

                if ($sess_array [STATUS] == '0') {

                    $this->form_validation->set_message('check_password', 'Inactive User, Please contact LouiePark');

                    return false;
                } else {
                    // set session values
                    $this->session->set_userdata('logged_in', $sess_array);
                }
            }
            return TRUE;
        } else {
            $this->form_validation->set_message('check_password', 'Invalid username/email or password');
            return false;
        }
    }

    /**
     * To handle forgot password
     *
     * sends email to registered email ID with the reset password link
     */
    public function forgot()
    {
        $useremail = $this->input->post(EMAIL);
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        $user = $this->user->get_user_by_email_password($useremail);
        if ($user) {
            $slug = md5($user->userID . $user->emailID);
            $message = '<img src="' . base_url('assets/images/logo.png') . '" border="0"><br>It looks like you forgot your password. No problem, we’ll get this cleared up.<br><br>
            <b>To reset your password please click the link below and follow the instructions:</b><br><br>
            **<a href="' . base_url('login/reset/' . $user->userID . '/' . $slug) . '"> ' . base_url('login/reset/' . $user->userID . '/' . $slug) . '</a>
            <br><br>
            If you did not request to reset your password then please ignore this email and no changes will occur.';
            $this->load->library(EMAIL);
            $this->email->from($constants->fromEmail);
            $this->email->to($useremail);
            $this->email->subject('Reset Password');
            $this->email->message($message);
            if (!$this->email->send()) {
                $emailInfo['emailStatus'] = 0;
                $emailInfo['toEmail'] = $useremail;
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
