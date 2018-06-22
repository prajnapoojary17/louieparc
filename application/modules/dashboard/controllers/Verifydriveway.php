<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * File Name : Cron Controller
 *
 * Description : Keep verify the driveway
 *               using verification code sent via email
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
class Verifydriveway extends MY_Controller
{

    function __construct()
    {
        $this->module = "dashboard";
        parent::__construct();
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
     * To verify the driveway
     * 
     * Renter receives email after adding driveway.
     *     
     * On click of link redirects to verify page
     * 
     * If user is not logged in the redirects to login page
     *
     */
    public function index()
    {

        if (isset($_POST[DRIVEWAYID])) {
            $drivewayId = $_POST[DRIVEWAYID];
        } else {
            $drivewayId = $this->uri->segment(3);
        }
        if (!$drivewayId) {
            $data ['msg'] = 'Invalid URL.';
        }
        if (!$this->checkLogin($this->module)) {
            $sess_array = array(
                DRIVEWAYID => $drivewayId
            );
            $this->session->set_userdata('drivewayverify', $sess_array);
            redirect(base_url() . "login");
        } else {
            $data[DRIVEWAYID] = $drivewayId;
            $this->_tpl('Verifydriveway', $data);
        }
    }

    /**
     * To verify the verification code
     *    
     * returns true if password matches
     *
     * Otherwise return false
     */
    public function verify()
    {

        $verificationText = $this->input->post('vcode');
        $userID = $this->input->post('userID');
        $drivewayID = $this->input->post(DRIVEWAYID);
        if ($drivewayID == '') {
            echo "0";
        } else {
            $this->load->model('Dashboardmodel');
            $check = $this->Dashboardmodel->verifyDriveway($verificationText, $drivewayID, $userID);
            if ($check > 0) {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

}
