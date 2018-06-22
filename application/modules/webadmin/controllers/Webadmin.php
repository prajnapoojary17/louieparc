<?php

/**
 *
 * File Name : Webadmin Controller
 *
 * Description : This is used by Admin
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

class Webadmin extends MY_Controller
{

    function __construct()
    {
        $this->module = "webadmin";
        parent::__construct();
        if (!$this->checkadminLogin($this->module)) {
            redirect(base_url() . "webadmin/login");
        }
        $this->load->model('Webadminmodel');
    }

    /**
     * To show admin page
     */
    public function index()
    {
        $feedbackarray = array();
        $userData['users'] = $this->Webadminmodel->getallUsers();
        $feedbackcount = $this->Webadminmodel->getfeedbackCount();
        if ($feedbackcount) {
            foreach ($feedbackcount as $count) {
                $feedbackarray[$count[USERID]] = $count[FEEDBACK_COUNT];
            }
        }
        $userData[FEEDBACK_COUNT] = $feedbackarray;
        $this->_tpladmin('Manage_users', $userData);
    }

    /**
     * To show manage users page
     *
     * pass all users detail with ststus 1   
     */
    public function Manage_users()
    {
        $feedbackarray = array();
        $userData['users'] = $this->Webadminmodel->getallUsers();
        $feedbackcount = $this->Webadminmodel->getfeedbackCount();
        if ($feedbackcount) {
            foreach ($feedbackcount as $count) {
                $feedbackarray[$count[USERID]] = $count[FEEDBACK_COUNT];
            }
        }
        $userData[FEEDBACK_COUNT] = $feedbackarray;
        $this->_tpladmin('Manage_users', $userData);
    }

    /**
     * To Logout the admin user
     */
    public function logout()
    {
        $this->session->unset_userdata('logged_in_admin');
        redirect(base_url() . "webadmin/login");
    }

    /**
     * To update the users info 
     * 
     */
    public function update_userinfo()
    {

        $userID = $this->input->post('id', TRUE);
        $data[USERNAME] = $this->input->post('username', TRUE);
        $data['emailID'] = $this->input->post(EMAIL, TRUE);
        $data['phone'] = $this->input->post('phone', TRUE);
        $data['birthDate'] = $this->input->post('dob', TRUE);
        $data[BUILDING] = $this->input->post(BUILDING, TRUE);
        $data[STREET_ADDRESS] = $this->input->post(STREET_ADDRESS, TRUE);
        $data[ROUTE] = $this->input->post(ROUTE, TRUE);
        $data['city'] = $this->input->post('city', TRUE);
        $data[STATE] = $this->input->post(STATE, TRUE);
        $data['zip'] = $this->input->post('zip', TRUE);
        $result = $this->Webadminmodel->updateUser($data, $userID);
        if ($result) {
            $response = array(
                STATUS => true,
            );
        } else {
            $response = array(
                STATUS => false,
            );
        }
        $this->apiResponse($response);
    }

    /**
     * To show update driveway page
     * 
     */
    public function updateDriveway()
    {
        $feedback = array();
        $feedbackcount = 0;
        $userID = $this->input->post(USRID, TRUE);
        if (isset($userID)) {
            $userData['driveways'] = $this->Webadminmodel->getallDriveway($userID);
            $userDetail = $this->Webadminmodel->getUserdetail($userID);
            $feedbackcount = $this->Webadminmodel->getreviewCount($userID);
            if ($feedbackcount) {
                foreach ($feedbackcount as $count) {
                    $feedback[$count[DRIVEWAYID]] = $count[FEEDBACK_COUNT];
                }
            }
            $userData['feedbackcnt'] = $feedback;
            $userData[USERNAME] = $userDetail[USERNAME];
            $userData[USERID] = $userID;
            $this->_tpladmin('Update_driveway', $userData);
        } else {
            redirect(base_url() . "webadmin");
        }
    }

    /**
     * To update the driveway info of users
     * 
     */
    public function update_drivewayinfo()
    {
        $drivewayID = $this->input->post(DRIVEWAY_ID, TRUE);
        $data['description'] = $this->input->post('description', TRUE);
        $data['instructions'] = $this->input->post('instructions', TRUE);
        $data['price'] = $this->input->post('price', TRUE);
        $data['dailyprice'] = $this->input->post('dailyprice', TRUE);
        $data[BUILDING] = $this->input->post(BUILDING, TRUE);
        $data[STREET_ADDRESS] = $this->input->post(STREET_ADDRESS, TRUE);
        $data[ROUTE] = $this->input->post(ROUTE, TRUE);
        $data['city'] = $this->input->post('city', TRUE);
        $data[STATE] = $this->input->post(STATE, TRUE);
        $data['zip'] = $this->input->post('zip', TRUE);
        $data['drivewayStatus'] = $this->input->post('drivewaystatus', TRUE);
        $data['slot'] = $this->input->post('slot', TRUE);
        $result = $this->Webadminmodel->updateDrivewayinfo($data, $drivewayID);
        if ($result) {
            $response = array(
                STATUS => true,
            );
        } else {
            $response = array(
                STATUS => false,
            );
        }
        $this->apiResponse($response);
    }

    /**
     * To delete the users
     * 
     */
    public function delete_user()
    {
        $userID = $this->input->post('id', TRUE);
        $data[STATUS] = 0;
        $result = $this->Webadminmodel->deleteUser($data, $userID);
        if ($result) {
            $response = array(
                STATUS => true,
            );
        } else {
            $response = array(
                STATUS => false,
            );
        }
        $this->apiResponse($response);
    }

    /**
     * To delete the driveway
     * 
     */
    public function delete_driveway()
    {

        $drivewayID = $this->input->post('id', TRUE);
        $data['drivewayStatus'] = 0;
        $result = $this->Webadminmodel->deleteDriveway($data, $drivewayID);
        if ($result) {
            $response = array(
                STATUS => true,
            );
        } else {
            $response = array(
                STATUS => false,
            );
        }
        $this->apiResponse($response);
    }

    /**
     * To check whether username already exits
     * 
     */
    public function check_username()
    {

        $id = $this->input->post('id', TRUE);
        $username = $this->input->post('username', TRUE);
        $email = $this->input->post(EMAIL, TRUE);
        $user = $this->Webadminmodel->checkUsername($username, $id);
        $emails = $this->Webadminmodel->checkEmail($email, $id);
        if ($user || $emails) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     * To show driveway images
     * 
     */
    public function viewDrivewayphoto()
    {
        $drivewayID = $this->input->post(DRIVEWAYID, TRUE);
        if (isset($drivewayID)) {
            $userID = $this->input->post(USERID, TRUE);
            $userData['drivewayinfo'] = $this->Webadminmodel->getDrivewayinfo($drivewayID);
            $userData[USERID] = $userID;
            $this->_tpladmin('View_drivewayphoto', $userData);
        } else {
            redirect(base_url() . "webadmin");
        }
    }

    /**
     * To delete driveway images
     * 
     */
    public function deleteDrivewayphoto()
    {
        $key = $this->input->post('key');
        $image = $this->input->post('imgName');
        $drivewayId = $this->input->post(DRIVEWAY_ID);
        $image = FCPATH . 'assets/uploads/driveway/' . $image;
        if (unlink($image)) {
            $data = array(
                $key => null
            );
            $this->db->where(DRIVEWAYID, $drivewayId);
            $this->db->update('tbl_driveway', $data);
            $result = array(
                STATUS => true,
                MESSAGE => 'success'
            );
        } else {
            $result = array(
                STATUS => false,
                MESSAGE => 'failed'
            );
        }
        $this->apiResponse($result);
    }

    /**
     * To show verify driveway page
     * 
     */
    public function Verify_driveway()
    {

        $userData['driveways'] = $this->Webadminmodel->getDriveways();
        $this->_tpladmin('Verify_driveway', $userData);
    }

    /**
     * To log in to parker/renter accont from admin panel
     * 
     */
    public function logintoaccount()
    {
        $userID = $this->input->post(USRID, TRUE);
        $result = $this->Webadminmodel->getUser($userID);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    'user_id' => $row->userID,
                    'user_name' => $row->userName,
                    STATUS => $row->status,
                    'role' => $row->roleID,
                    'profile' => $row->profileImage,
                    'fb_token' => ''
                );

                $this->session->set_userdata('logged_in', $sess_array);
                redirect(base_url() . 'dashboard');
            }
        }
    }

    /**
     * To log in to parker/renter accont from admin panel
     * 
     */
    public function send_verificationcode()
    {
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        $drivewayID = $this->input->post(DRIVEWAY_ID, TRUE);
        $userID = $this->input->post(USRID, TRUE);
        $this->load->helper('string');
        $verificationCode = random_string('alnum', 5);
        $result = $this->Webadminmodel->getUser($userID);
        if ($result) {
            $data['verificationCode'] = $verificationCode;
            $this->Webadminmodel->saveVerification($drivewayID, $data);
            $drivewayinfo = $this->Webadminmodel->getDrivewayinfo($drivewayID);
            foreach ($result as $row) {
                $message = '
                        <html>
                            <head>
                                <title>Welcome to the LouiePark community!</title>
                            </head>
                            <body>
                            <h2>Welcome to LouiePark ' . $row->userName . '</h2>
                            <p>Following Driveway is verified.</p><br>
                                ' . $drivewayinfo->building . '
                                <br>
                                ' . $drivewayinfo->route . ' ' . $drivewayinfo->streetAddress . '    
                                <br>
                                ' . $drivewayinfo->city . '    ' . $drivewayinfo->state . '-' . $drivewayinfo->zip . '
                                <br><br>
                            <p>Your Verification code is: &nbsp; </p>                           
                                ' . $verificationCode . '<br> <br>                                       
                                    <p>Please click on below URL or paste into your browser and enter verification code to verify your Driveway</p><br/>
                        <a href="' . base_url('dashboard/verifydriveway/' . $drivewayID) . '">' . base_url('dashboard/verifydriveway/' . $drivewayID) . '</a>
                                
                               <br><br><br>
                                Thanks<br>LouiePark
                            </body>
                        </html>
                        ';
                // Send welcome email
                $useremail = $row->emailID;
                $this->load->library(EMAIL);
                $this->email->from($constants->fromEmail);
                $this->email->to($useremail);
                $this->email->subject('LouiePark - Driveway Verification Code');
                $this->email->message($message);
                if (!$this->email->send()) {
                    $emailInfo['emailStatus'] = 0;
                    $emailInfo['toEmail'] = $useremail;
                    $emailInfo['fromEmail'] = $constants->fromEmail;
                    $emailInfo['content'] = $message;
                    $emailInfo['subject'] = 'LouiePark - Driveway Verification Code';
                    $this->load->model('profile/Profilemodel');
                    $this->Profilemodel->saveEmailStatus($emailInfo);
                }
            }
            $result = array(
                STATUS => true,
                MESSAGE => 'success'
            );
        } else {
            $result = array(
                STATUS => false,
                MESSAGE => 'failed'
            );
        }
        $this->apiResponse($result);
    }

    /**
     * To show driveway images
     * 
     */
    public function viewFeedback()
    {
        $drivewayID = $this->input->post(DRIVEWAYID, TRUE);
        if (isset($drivewayID)) {
            $userID = $this->input->post(USERID, TRUE);
            $userData['feedbacks'] = $this->Webadminmodel->getFeedback($drivewayID);
            $userData[DRIVEWAYID] = $drivewayID;
            $userData[USERID] = $userID;
            $this->_tpladmin('View_feedback', $userData);
        } else {
            redirect(base_url() . "webadmin");
        }
    }

    /**
     * To delete the driveway
     * 
     */
    public function approve_feedback()
    {
        $reviewID = $this->input->post('reviewID', TRUE);
        $data['approvedStatus'] = 1;
        $result = $this->Webadminmodel->approveFeedback($data, $reviewID);
        if ($result) {
            $response = array(
                STATUS => true,
            );
        } else {
            $response = array(
                STATUS => false,
            );
        }
        $this->apiResponse($response);
    }

    /**
     * To show settings page
     * 
     */
    public function Settings()
    {
        $userData['settings'] = $this->Webadminmodel->getSettings();
        $this->_tpladmin('Settings', $userData);
    }

    /**
     * To show settings page
     * 
     */
    public function savesettings()
    {

        $data['fromEmail'] = $this->input->post('fromEmail', TRUE);
        $data['hourlypriceIncrement'] = $this->input->post('hourlypriceIncrement', TRUE);
        $data['dailypriceIncrement'] = $this->input->post('dailypriceIncrement', TRUE);
        $data['applicationFees'] = $this->input->post('applicationFees', TRUE);
        $data['applicationFeesdolars'] = $this->input->post('applicationFeesdolars', TRUE);
        $data['startReminder'] = $this->input->post('startReminder', TRUE);
        $data['endReminder'] = $this->input->post('endReminder', TRUE);
        $data['totalBookingdays'] = $this->input->post('totalBookingdays', TRUE);
        $data['drivewayDistance'] = $this->input->post('drivewayDistance', TRUE);
        $data['minutesLock'] = $this->input->post('minutesLock', TRUE);
        $data['stripeFee'] = $this->input->post('stripeFee', TRUE);
        $data['stripeProcessfee'] = $this->input->post('stripeProcessfee', TRUE);
        $status = $this->Webadminmodel->updateSettings($data);

        if ($status) {
            $response = array(
                STATUS => true,
                MESSAGE => 'success'
            );
        } else {
            $response = array(
                STATUS => false,
                MESSAGE => 'failed'
            );
        }
        $this->apiResponse($response);
    }

    /**
     * To show settings page
     * 
     */
    public function getverifyCount()
    {
        $verifyCount = $this->Webadminmodel->getverifyCount();
        $response = array(
            'count' => $verifyCount->verifycount
        );
        $this->apiResponse($response);
    }

}
