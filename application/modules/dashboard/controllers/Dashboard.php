<?php

/**
 *
 * File Name : Dashboard Controller
 *
 * Description : This is used process details for logged in users
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

class Dashboard extends MY_Controller
{

    function __construct()
    {
        $this->module = DASHBOARD;
        parent::__construct();
        if (!$this->checkLogin($this->module)) {
            if ($this->input->is_ajax_request()) {
                $response = array(
                    'login' => true,
                );
                $this->apiResponse($response);
            } else {
                redirect(base_url() . "login");
            }
        }
        $this->load->model('Dashdrivmodel');
        $this->load->model('Dashboardmodel');
    }

    /**
     * To show Dashboard of User
     *
     * based on user role 2 - renter / 3 - parker.
     *
     */
    public function index()
    {
        if (!$this->checkLogin($this->module)) {
            redirect(base_url() . LOGIN);
        }
        $this->load->model('usermanagement/Usermanagementmodel');
        $this->load->model('booking/Bookingmodel');
        if (isset($_SESSION[DRIVEWAYSETTING][DRIVEWAYID]) && !empty($_SESSION[DRIVEWAYSETTING][DRIVEWAYID])) {
            $data = $_SESSION[DRIVEWAYSETTING];
            $userData[DRIVEWAYID] = $data[DRIVEWAYID];
            $drivewayStatus = $this->Dashdrivmodel->getDrivewaystatus($userData[DRIVEWAYID]);
            $userData[STATUS] = $drivewayStatus->drivewayStatus;
            $userData[BUILDING] = $drivewayStatus->building;
            $userData[ROUTE] = $drivewayStatus->route;
            $userData[STREET_ADDRESS] = $drivewayStatus->streetAddress;
            $userData['city'] = $drivewayStatus->city;
            $userData[STATE] = $drivewayStatus->state;
            $userData['zip'] = $drivewayStatus->zip;
            $dateSetting = $this->Dashdrivmodel->getDatesetting($userData[DRIVEWAYID]);
            if ($dateSetting) {
                $userData[DATE_SETTING] = $dateSetting;
            }
            $timeSetting = $this->Dashdrivmodel->getTimesetting($userData[DRIVEWAYID]);
            if ($timeSetting) {
                $userData[TIME_SETTING] = $timeSetting;
            }
            $this->session->unset_userdata(DRIVEWAYSETTING);
            $this->_tpl(DRIVEWAY_SETTINGS, $userData);
        } elseif (isset($_SESSION[DRIVEWAY_VERIFY][DRIVEWAYID]) && !empty($_SESSION[DRIVEWAY_VERIFY][DRIVEWAYID])) {
            $data[DRIVEWAYID] = $_SESSION[DRIVEWAY_VERIFY][DRIVEWAYID];
            $this->session->unset_userdata(DRIVEWAY_VERIFY);
            $this->_tpl('Verifydriveway', $data);
        } else {
            $data = $this->session->userdata(LOGGED_IN);
            $userId = $data [USER_ID];
            $this->load->model('profile/Profilemodel');
            $userData ['result'] = $this->Usermanagementmodel->getUser($userId);
            if (isset($_SESSION[RESET])) {
                $userData['success'] = true;
                unset($_SESSION[RESET]);
            }
            $roles = $this->Usermanagementmodel->getUserInfo($userId);
            foreach ($roles as $row) {
                $userData ['role'] = $row->roleID;
            }
            $userData ['driveways'] = $this->Usermanagementmodel->getDriveway($userId);
            $userData ['account'] = $this->Dashboardmodel->checkAccountExist($userId);
            $userData ['card'] = $this->Dashboardmodel->checkCardExist($userId);
            $userData['parked_cust'] = $this->Bookingmodel->parkedCustomer($userId);
            $userData['cars'] = $this->Profilemodel->getCar($userId);
            $userData['cards'] = $this->Dashboardmodel->getUserCardInfo($userId);
            $booked = $this->Bookingmodel->checkBooking($userId);
            if (isset($booked)) {
                $userData['park_history'] = $this->Bookingmodel->parkingHistory($userId);
            }
            $userData['cities_parked'] = $this->Bookingmodel->citiesParked($userId);
            $userData['constants'] = $this->Bookingmodel->getConstants();
            $reviews = $this->Bookingmodel->getReviews($userId);
            $rw = array();
            $i = 0;
            foreach ($reviews as $review) {
                $rw[$i] = $review->bookingId;
                $i++;
            }

            $userData['reviewsbid'] = $rw;
            $this->_tpl('Dashboard', $userData);
        }
    }

    /**
     * To Logout the user
     * 
     * Destroys session created during User login, facebook login and driveway_search
     * 
     * If admin has logged into users account then it redirects to webadmin page
     */
    public function logout()
    {
        $this->session->unset_userdata(LOGGED_IN);
        $this->session->unset_userdata('logged_fb');
        $this->session->unset_userdata('driveway_search');
        if (isset($_SESSION['logged_in_admin']) && $_SESSION['logged_in_admin'] != NULL) {
            redirect(base_url() . "webadmin/");
        } else {
            redirect(base_url() . LOGIN);
        }
    }

    /**
     * To Logout the user who has logged in
     * via Facebook.
     */
    public function fbLogout()
    {
        $this->load->library('facebook');
        $data = $this->session->userdata(LOGGED_IN);
        $fbToken = $data ['fb_token'];
        require_once APPPATH . '/third_party/Facebook/autoload.php';
        require_once APPPATH . '/third_party/Facebook/Facebook.php';
        $facebook = new Facebook\Facebook([
            'app_id' => '1578367195791933',
            'app_secret' => '69e0d86137ce82e68f36dc2afd9058d0',
            'default_graph_version' => 'v2.2'
        ]);
        $helper = $facebook->getRedirectLoginHelper();
        $logoutUrl = $helper->getLogoutUrl($fbToken, 'http://' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . str_replace('index.php', '', $_SERVER ['SCRIPT_NAME']) . LOGIN);
        $this->session->unset_userdata(LOGGED_IN);
        $this->session->unset_userdata('logged_fb');
        $this->session->unset_userdata('driveway_search');
        redirect($logoutUrl);
    }

    /**
     * To load Account View page
     */
    public function account()
    {
        $this->_tpl('Account');
    }

    /**
     * To load Account View page
     */
    public function accounts()
    {
        if (isset($_SESSION[DRIVEWAYSETTING][USERID]) && !empty($_SESSION[DRIVEWAYSETTING][USERID])) {
            $data = $_SESSION[DRIVEWAYSETTING];
            $userData[DRIVEWAYID] = $data[DRIVEWAYID];
            $drivewayStatus = $this->Dashdrivmodel->getDrivewaystatus($userData[DRIVEWAYID]);
            $userData[STATUS] = $drivewayStatus->drivewayStatus;
            $userData[BUILDING] = $drivewayStatus->building;
            $userData[ROUTE] = $drivewayStatus->route;
            $userData[STREET_ADDRESS] = $drivewayStatus->streetAddress;
            $userData['city'] = $drivewayStatus->city;
            $userData[STATE] = $drivewayStatus->state;
            $userData['zip'] = $drivewayStatus->zip;
            $dateSetting = $this->Dashdrivmodel->getDatesetting($userData[DRIVEWAYID]);
            if ($dateSetting) {
                $userData[DATE_SETTING] = $dateSetting;
            }
            $timeSetting = $this->Dashdrivmodel->getTimesetting($userData[DRIVEWAYID]);
            if ($timeSetting) {
                $userData[TIME_SETTING] = $timeSetting;
            }
            $this->session->unset_userdata(DRIVEWAYSETTING);
            $this->_tpl(DRIVEWAY_SETTINGS, $userData);
        } else {
            redirect(base_url() . DASHBOARD);
        }
    }

    /**
     * To make the Account active
     *
     * @param integer $accountID drivewayID
     *
     * redirects to account view page
     */
    public function account_active($accountID)
    {
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];
        $this->Dashboardmodel->updateAccount($accountID, $userId);
        $userData[RESULTS] = $this->Dashboardmodel->getUserBankInfo($userId);
        $this->_tpl('Account_view', $userData);
    }

    /**
     * To make the Account active
     *
     * Accepts accountID as parameter
     *
     * redirects ti account view page
     */
    public function card_delete()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $user = $_SESSION[LOGGED_IN];
            $userId = $user[USER_ID];
            $billID = $this->input->post('id');
            $result = $this->Dashboardmodel->deleteCard($billID, $userId);
            $cards = $this->Dashboardmodel->getUserCardInfo($userId);
            if ($cards) {
                $cards = false;
            } else {
                $cards = true;
            }

            if ($result) {
                $response = array(
                    STATUS => true,
                    'cards' => $cards
                );
            } else {
                $response = array(
                    STATUS => false,
                    'cards' => $cards
                );
            }
            $this->apiResponse($response);
        }
    }

    /**
     * To load account view page
     *    
     * redirects to account view page
     */
    public function card()
    {
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];
        $userData[RESULTS] = $this->Dashboardmodel->getUserCardInfo($userId);
        $this->_tpl('Card', $userData);
    }

    /**
     * To load account view page
     *    
     * redirects to account view page
     */
    public function account_view()
    {
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];
        $userData[RESULTS] = $this->Dashboardmodel->getUserBankInfo($userId);
        $this->_tpl('Account_view', $userData);
    }

    /**
     * To reset the password
     *    
     * redirects to users dashboard on success
     *
     * Otherwise redirects to Reset page
     */
    public function reset()
    {
        $this->load->library('form_validation');
        $userID = $this->input->post(USERID);
        $this->Dashdrivmodel->userchck($userID);
        $this->form_validation->set_error_delimiters('<div class="alert_error" style="display:block">', '</div>');
        $this->form_validation->set_rules('old_password', 'Current Password', 'trim|required|min_length[7]|max_length[128]|callback_check_password');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[7]|max_length[128]');
        $this->form_validation->set_rules('password_conf', 'Confirm Password', 'required|min_length[7]|max_length[128]|matches[password]');
        if ($this->form_validation->run($this)) {
            $_SESSION[RESET] = true;
            redirect(base_url() . DASHBOARD);
        } else {
            $this->_tpl('Reset');
        }
    }

    /**
     * To Check the password during resetting
     *    
     * @returns true if password matches
     *
     * Otherwise return false
     */
    function check_password()
    {
        $this->load->model('usermanagement/Usermanagementmodel');
        $old_password = $this->input->post('old_password');
        $userID = $this->getUserId();
        $user = $this->Usermanagementmodel->checkPass($old_password, $userID);
        if ($user) {
            $this->Usermanagementmodel->reset_password($userID, $this->input->post('password'));
            return true;
        } else {
            $this->form_validation->set_message('check_password', 'Invalid Current Password');
            return false;
        }
    }

    /**
     * To verify the verification code
     *    
     * returns true if password matches
     *
     * Otherwise return false
     */
    public function verifyCode()
    {
        $verificationText = $this->input->post('vcode');
        $userID = $this->input->post(USERID);
        $noRecords = $this->Dashboardmodel->verifyEmailAddress($verificationText, $userID);
        if ($noRecords > 0) {
            echo "1";
        } else {
            echo "0";
        }
    }

    /**
     * To load the Account page
     *    
     * when user wants to add multiple account
     *
     * redirects to Account page
     */
    public function addAccount()
    {
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];
        $_SESSION[DRIVEWAYSETTING][USERID] = $userId;
        $this->_tpl('Account');
    }

    /**
     * To view driveway setting page of logged in user
     *
     */
    public function drivewaySettings()
    {
        
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];
        $drivewayId =  $this->input->post('drivewayId');
        $userData[DRIVEWAYID] = $this->input->post('drivewayId');
        $drivewayUser = $this->Dashdrivmodel->checkDrivewayUser($drivewayId, $userId);
        if (isset($userData[DRIVEWAYID]) && $drivewayUser ==1) {
            $drivewayStatus = $this->Dashdrivmodel->getDrivewaystatus($userData[DRIVEWAYID]);
            $userData[STATUS] = $drivewayStatus->drivewayStatus;
            $userData[BUILDING] = $drivewayStatus->building;
            $userData[ROUTE] = $drivewayStatus->route;
            $userData[STREET_ADDRESS] = $drivewayStatus->streetAddress;
            $userData['city'] = $drivewayStatus->city;
            $userData[STATE] = $drivewayStatus->state;
            $userData['zip'] = $drivewayStatus->zip;
            $dateSetting = $this->Dashdrivmodel->getDatesetting($userData[DRIVEWAYID]);
            if ($dateSetting) {
                $userData[DATE_SETTING] = $dateSetting;
            }
            $timeSetting = $this->Dashdrivmodel->getTimesetting($userData[DRIVEWAYID]);
            if ($timeSetting) {
                $userData[TIME_SETTING] = $timeSetting;
            }
            $this->_tpl(DRIVEWAY_SETTINGS, $userData);
        } else {
            redirect(base_url() . "dashboard");
        }
    }

    /**
     * To check whether driveway is verified by admin
     *
     * If verified return status as true with message verified
     *
     * Otherwise return status as false with message Not verified
     *
     */
    public function checkVerification()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $drivewayID = $this->input->post('drivewayid');
            $data = $this->session->userdata(LOGGED_IN);
            $userId = $data [USER_ID];
            $checkCode = $this->Dashboardmodel->checkadminVerification($drivewayID);
            if ($checkCode && $checkCode->verificationCode != '') {
                $checkVerification = $this->Dashboardmodel->checkdrivewayVerification($drivewayID);
                if (!$checkVerification) {
                    $sess_array = array(
                        DRIVEWAYID => $drivewayID
                    );
                    $this->session->set_userdata(DRIVEWAYSETTING, $sess_array);
                    $response = array(
                        STATUS => false,
                        MESSAGE => 'Not Verified'
                    );
                } else {
                    $checkAcnt = $this->Dashboardmodel->checkAccountExist($userId);
                    if (!$checkAcnt) {
                        $sess_array = array(
                            DRIVEWAYID => $drivewayID
                        );
                        $this->session->set_userdata(DRIVEWAYSETTING, $sess_array);
                        $response = array(
                            STATUS => false,
                            MESSAGE => 'No Account'
                        );
                    } else {
                        $response = array(
                            STATUS => true,
                            MESSAGE => 'Verified'
                        );
                    }
                }
            } else {
                $response = array(
                    STATUS => false,
                    MESSAGE => 'Admin not verified'
                );
            }
            $this->apiResponse($response);
        }
    }

    /**
     * To process Driveway setting done by logged in user
     *
     * Returns response in json format
     */
    public function saveSettings()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $user = $_SESSION[LOGGED_IN];
            $userId = $user[USER_ID];
            $this->load->model('driveway/drivewaymodel');
            $data_dayset = array();
            $data = array();
            $userdata = array();
            $drivewayID = $this->input->post(DRIVEWAYID, TRUE);
            $status = $this->input->post(STATUS, TRUE);
            if (!empty($this->input->post('startDate'))) {
                $data['start_date'] = date("Y-m-d", strtotime($this->input->post('startDate', TRUE)));
                $data['end_date'] = date("Y-m-d", strtotime($this->input->post('endDate', TRUE)));
                $data['driveway_id'] = $drivewayID;
                $data[STATUS] = 1;
                $dateID = $this->drivewaymodel->saveDatesetting($data, $drivewayID, $userId);
            } else {
                $this->drivewaymodel->updateDatesetting($drivewayID, $userId);
            }
            if (!empty($this->input->post(DAY_OPTION))) {
                foreach ($_POST[DAY_OPTION] as $selected) {
                    $data_dayset[DAY_OPTION] = $selected;
                    $data_dayset['driveway_id'] = $drivewayID;
                    if (!empty($this->input->post('fromdate' . $selected))) {
                        $data_dayset['from'] = date("H:i:s", strtotime($this->input->post('fromdate' . $selected)));
                    } else {
                        $data_dayset['from'] = '00:00:00';
                    }
                    if (!empty($this->input->post('todate' . $selected))) {
                        $data_dayset['to'] = date("H:i:s", strtotime($this->input->post('todate' . $selected)));
                    } else {
                        $data_dayset['to'] = '00:00:00';
                    }
                    if (isset($dateID)) {
                        $data_dayset['date_id'] = $dateID;
                    } else {
                        $data_dayset['date_id'] = 0;
                    }
                    $data_dayset[STATUS] = 1;
                    $dayset[] = $data_dayset;
                    unset($data_dayset);
                }
                $this->drivewaymodel->saveDaysetting($dayset, $drivewayID, $userId);
            } else {
                $this->drivewaymodel->updateDaysetting($drivewayID, $userId);
            }
            $userdata['drivewayStatus'] = $status;
            $this->drivewaymodel->updateStatus($userdata, $drivewayID, $userId);
            $response = array(
                STATUS => true,
                MESSAGE => 'success'
            );
            $this->apiResponse($response);
        }
    }

    /**
     * To load the edit driveway page
     *   
     * redirects to driveway edit
     */
    public function driveway_edit()
    {
        $drivewayId = $this->input->post('drivewayId');
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID]; 
        $drivewayUser = $this->Dashdrivmodel->checkDrivewayUser($drivewayId, $userId);
        if (isset($drivewayId) && $drivewayUser == 1) {
            $this->load->model('driveway/drivewaymodel');
            $driveway['driveway'] = $this->drivewaymodel->getmyDriveway($drivewayId);
            $this->_tpl('Driveway_edit', $driveway);
        } else {
            redirect(base_url() . "dashboard");
        }
    }

}
