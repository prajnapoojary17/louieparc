<?php

/**
 *
 * File Name : Cron Controller
 *
 * Description : Keep track of billing details
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

class Confirm extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('login/user', '', TRUE);
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
     * To confirm the driveway booking
     * 
     * Parker receives email after booking.
     *     
     * On click of link redirects to confirmed page
     */
    public function index()
    {
        $userId = $this->uri->segment(2);
        $user = $this->user->userchck($userId);
        if (!$userId) {
            $data ['msg'] = INVALID_CONFIRM_CODE;
        }
        $hash = $this->uri->segment(4);
        if (!$hash) {
            $data ['msg'] = INVALID_CONFIRM_CODE;
        }
        $data ['success'] = false;
        if ($user) {
            $slug = md5($user->userID . $user->emailID);
            if ($hash != $slug) {
                $data ['msg'] = INVALID_CONFIRM_CODE;
            }
        } else {
            $data ['msg'] = INVALID_CONFIRM_CODE;
        }
        $this->load->model('booking/Bookingmodel');
        $bookingId = $this->uri->segment(3);
        $this->load->model('booking/Bookingmodel');
        $user = $this->Bookingmodel->getUserEmail($userId);
        $ownerdriveway = $this->Bookingmodel->getDrivewaydetail($bookingId);
        $owneremail = $this->Bookingmodel->getownerEmail($ownerdriveway->drivewayID);
        $constants = $this->Bookingmodel->getConstants();
        $message1 = '<html>
                            <head>
                                <title>Driveway booking is confirmed</title>
                            </head>
                            <body>
                             <img src="' . base_url('assets/images/logo.png') . '" border="0"><br>
                        <h4>' . $user->firstName . '&nbsp;' . $user->lastName . ' has confirmed his booking</h4>
                            <h4>Driveway Address:</h4>
                                ' . $ownerdriveway->building . '
                                <br>
                                ' . $ownerdriveway->route . '
                                <br>
                                ' . $ownerdriveway->streetAddress . ' ,  ' . $ownerdriveway->city . '
                                <br>
                                ' . $ownerdriveway->state . '   -  ' . $ownerdriveway->zip . '                                   
                                <br><br>
                           </body>
                        </html>';
        $this->load->library('email');
        $this->email->from($constants->fromEmail);
        $this->email->to($owneremail->emailID);
        $this->email->subject('Driveway Booking confirmed');
        $this->email->message($message1);
        $this->email->send();
        $this->_tpl('Confirm', $data);
    }

}
