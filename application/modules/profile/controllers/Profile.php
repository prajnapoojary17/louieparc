<?php

/**
 * File Name : Profile Controller
 *
 * Description : This is used to Handle Dashboard profile details 
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

class Profile extends MY_Controller
{

    function __construct()
    {
        $this->module = PROFILE;
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
        $this->load->model('Profilemodel');
        $this->load->model('usermanagement/Usermanagementmodel');
        $this->load->library('image_lib');
    }

    /**
     * To view profile info from dashboard
     *  
     */
    public function index()
    {
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];
        $userData[RESULT] = $this->Usermanagementmodel->getUser($userId);
        $userData['cars'] = $this->Profilemodel->getCar($userId);
        $this->_tpl('Profile_info', $userData);
    }

    /**
     * To view  dashboard from profile info 
     *
     */
    public function profile_view()
    {
        $user = $_SESSION[LOGGED_IN];
        $userId = $user[USER_ID];

        $userData[RESULT] = $this->Usermanagementmodel->getUser($userId);
        $userData['cars'] = $this->Profilemodel->getCar($userId);
        redirect(base_url() . "dashboard");
    }

    /**
     * To update the profile info
     * 
     * @returns response in json format
     */
    public function update_profile()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $userID = $this->getUserId();
           // $userID = $this->input->post('userid', TRUE);
            $profileImage = $this->uploadImage();
            if ($profileImage) {
                $data['profileImage'] = $profileImage;
                $_SESSION[LOGGED_IN][PROFILE] = $profileImage;
            }
            $data['firstName'] = $this->input->post('firstname', TRUE);
            $data['lastName'] = $this->input->post('lastname', TRUE);
            $data['phone'] = $this->input->post('mobileno', TRUE);
            $bmonth = $this->input->post('bmonth', TRUE);
            $bday = $this->input->post('bday', TRUE);
            $byear = $this->input->post('byear', TRUE);
            $ts = mktime(0, 0, 0, $bmonth, $bday, $byear);
            $data['birthDate'] = date('Y-m-d', $ts);
            $this->Profilemodel->updateProfile($data, $userID);
            $response = array(
                STATUS => true,
                USER_ID => $userID
            );
            $this->apiResponse($response);
        }
    }

    /**
     * To upload the profile Image
     * 
     * @returns filename
     */
    public function uploadImage()
    {
        $this->load->helper('form');
        $imgName = $_FILES[PROF_IMAGE]['name'];
        $nameExplode = explode(".", $imgName);
        $path1 = $this->config->item('location_image_path');
        $path2 = "profilephoto";
        $config[UPLOAD_PATH] = $path1 . $path2;
        $config['allowed_types'] = 'gif|png|jpeg|jpg';
        $config['file_name'] = time() . rand(0, 10) . '.' . end($nameExplode);
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (isset($_FILES[PROF_IMAGE]) && isset($_FILES[PROF_IMAGE]['name']) && ($imgName != '') && ($this->upload->do_upload(PROF_IMAGE))) {
            $fileData = $this->upload->data();
            $this->resizeImage($fileData [FILE_NAME], $config [UPLOAD_PATH]);
            return "thumb_" . $fileData [FILE_NAME];
        }
        return false;
    }

    /**
     * To update the car info of user
     * 
     * @returns response in json format
     */
    public function update_carinfo()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $user = $_SESSION [LOGGED_IN];
            $userId = $user [USER_ID];
            $vehicleID = $this->input->post('id', TRUE);
            $data[MODEL] = $this->input->post(MODEL, TRUE);
            $data['year'] = $this->input->post('year', TRUE);
            $data[COLOR] = $this->input->post(COLOR, TRUE);
            $data[VEHICLE_NUMBER] = $this->input->post(VEHICLE_NUMBER, TRUE);
            $result = $this->Profilemodel->updateCar($data, $vehicleID, $userId);
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
    }

    /**
     * To view profile info logged in user
     *
     */
    public function Addcard()
    {
        $this->_tpl('Addcard');
    }

    /**
     * To view profile info logged in user
     *
     */
    public function Addcar()
    {
        $this->_tpl('Addcar');
    }

    /**
     * To view profile info logged in user
     *
     */
    public function savecarinfo()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $model = $this->input->post(MODEL);
            $year = $this->input->post('year');
            $color = $this->input->post(COLOR);
            $vnumber = $this->input->post('vnumber');
            $user = $_SESSION [LOGGED_IN];
            $userId = $user [USER_ID];
            $data [USERID] = $userId;
            $data [MODEL] = $model;
            $data ['year'] = $year;
            $data [COLOR] = $color;
            $data [VEHICLE_NUMBER] = $vnumber;
            $data [STATUS] = 1;
            $result = $this->Profilemodel->savecarInfo($data);
            if ($result) {
                $response = array(
                    STATUS => true,
                    MESSAGE => 'success'
                );
            } else {
                $response = array(
                    STATUS => false,
                    MESSAGE => 'Failed'
                );
            }
            $this->apiResponse($response);
            return true;
        }
    }

    /**
     * To  view Add reviews
     *
     * @param integer $drivewayID Driveway ID
     */
    public function addReview($drivewayID)
    {
        $userData[DRIVEWAYID] = $drivewayID;
        $this->_tpl('Reviews', $userData);
    }

    /**
     * To view Add reviews
     *
     */
    public function addReviews()
    {
        $drivewayId = $this->input->post(DRIVEWAY_ID);
        if (isset($drivewayId)) {
            $userData[DRIVEWAYID] = $drivewayId;
            $userData['bookingID'] = $this->input->post('bookingId');
            $userId = $this->input->post('userId');
            $userData[RESULT] = $this->Profilemodel->renterInfo($userId, $drivewayId);
            $this->_tpl('Reviews', $userData);
        } else {
            redirect(base_url() . "dashboard");
        }
    }

    /**
     * To view reviews
     *
     */
    public function view_review()
    {
        $drivewayId = $this->input->post(DRIVEWAY_ID);
        if (isset($drivewayId)) {
            $response = array();
            if (isset($drivewayId)) {
                $this->load->model('driveway/drivewaymodel');
                $drivewayData = $this->drivewaymodel->getOwnerDriveway($drivewayId);
                $reviews = $this->drivewaymodel->getReviews($drivewayId);
                $starrating = $this->drivewaymodel->getRatings($drivewayId);
                $rating = floor($starrating->rating);
                $response['driveway'] = array(
                    BUILDING => $drivewayData->building,
                    "streetAddress" => $drivewayData->streetAddress,
                    "route" => $drivewayData->route,
                    "city" => $drivewayData->city,
                    "state" => $drivewayData->state,
                    "zip" => $drivewayData->zip
                );
                if ($starrating) {
                    $response[RATINGS] = $rating;
                } else {
                    $response[RATINGS] = 0;
                }
                if ($reviews) {
                    $response[REVIEWS] = $reviews;
                } else {
                    $response[REVIEWS] = 0;
                }
            }
            $this->_tpl('Review_view', $response);
        } else {
            redirect(base_url() . "dashboard");
        }
    }

    /**
     * To Save reviews
     *
     * @returns response in json format
     */
    public function saveReview()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            
            $user = $_SESSION [LOGGED_IN];
            $userId = $user [USER_ID];
            $drivewayid = $this->input->post('drivewayid');
            $bookingid = $this->input->post('bookingid');
            $reviewtitle = $this->input->post('reviewtitle');
            $review = $this->input->post('review');
            $bookedUser = $this->Profilemodel->bookedUser($userId, $bookingid);
           
           if($bookedUser == 1){
            if (!empty($this->input->post('starrating'))) {
                $starrating = $this->input->post('starrating');
                $ratings[USERID] = $userId;
                $ratings [DRIVEWAYID] = $drivewayid;
                $ratings ['rating'] = $starrating;
                $data[RATINGS] = $ratings;
            }
            $reviews[USERID] = $userId;
            $reviews['bookingId'] = $bookingid;
            $reviews [DRIVEWAYID] = $drivewayid;
            $reviews ['title'] = $reviewtitle;
            $reviews ['comments'] = $review;
            $data[REVIEWS] = $reviews;
            $result = $this->Profilemodel->saveReviews($data);
            if ($result) {
                $response = array(
                    STATUS => true,
                    MESSAGE => 'success'
                );
            } else {
                $response = array(
                    STATUS => false,
                    MESSAGE => 'Failed'
                );
            }
            
           }
           else{
               
               $response = array(
                    STATUS => false,
                    MESSAGE => 'Failed'
                );
           }
            $this->apiResponse($response);
            return true;
        }
    }

    /**
     * To view profile info of renter
     *
     * @param integer $bookingID Booking ID
     */
    public function parkhistory_view()
    {
        $bookingID = $this->input->post('bookingID', TRUE);
        $user = $_SESSION [LOGGED_IN];
        $userId = $user [USER_ID];
        $bookedUser = $this->Profilemodel->bookedUser($userId, $bookingID);
        if (isset($bookingID) && $bookedUser ==1) {
            $this->load->model('booking/Bookingmodel');
            $userData[RESULT] = $this->Bookingmodel->getParkinghistory($bookingID);
            $this->_tpl('Parkinghistory_view', $userData);
        } else {
            redirect(base_url() . "dashboard");
        }
    }

    /**
     * To view profile info logged in user
     *
     * @param integer $userID User ID
     */
    public function renterInfo()
    {
        $userID = $this->input->post('userID', TRUE);
        if (isset($userID)) {
            $userData[RESULT] = $this->Usermanagementmodel->getUser($userID);
            $userData['driveways'] = $this->Usermanagementmodel->getDriveway($userID);
            $this->_tpl('Renterinfo', $userData);
        } else {
            redirect(base_url() . "dashboard");
        }
    }

    /**
     * To add driveway
     *
     */
    public function addDriveway()
    {
        $data = $this->session->userdata(LOGGED_IN);
        $userId = $data [USER_ID];
        $roles = $this->Usermanagementmodel->getUserInfo($userId);
        foreach ($roles as $row) {
            $userData ['role'] = $row->roleID;           
        }      
        $address = $this->Profilemodel->address_exist($userId);
         if($address){
              $userData ['building'] = 0;
         }
        else {
              $userData ['building'] = 1;
        }         
        $this->_tpl('Adddriveway', $userData);
    }

    /**
     * To save driveway
     *
     * @returns response in json format
     */
    public function saveDriveway()
    {
        
            if (isset($_SESSION [LOGGED_IN])) {
                
            $building = $this->input->post('h_name', TRUE);
            $streetaddres = $this->input->post('streetaddres', TRUE);
            $route = $this->input->post(ROUTE, TRUE);
            $city = $this->input->post('city', TRUE);
            $state = $this->input->post(STATE, TRUE);
            $zip = $this->input->post('zip', TRUE);
            $drivewayadd = $this->input->post('about', TRUE);
            $additional = $this->input->post('additional', TRUE);
            
            if ($drivewayadd == 'no' || $additional == 1) {
                $d_name = $this->input->post('d_name', TRUE);
                $d_streetaddres = $this->input->post('rent_streetaddres', TRUE);
                $d_route = $this->input->post('route2', TRUE);
                $d_city = $this->input->post('rent_city', TRUE);
                $d_state = $this->input->post('rent_state', TRUE);
                $d_zip = $this->input->post('rent_zip', TRUE);
                if (($d_streetaddres == "")) {
                    $invalidMsg = "Street Address is required";
                } else if (($d_city == "")) {
                    $invalidMsg = "City is required";
                } else if (($d_state == "")) {
                    $invalidMsg = "State is required";
                } else if (($d_zip == "")) {
                    $invalidMsg = "ZIP is required";
                }
            } else {
                $d_name = $building;
                $d_streetaddres = $streetaddres;
                $d_route = $route;
                $d_city = $city;
                $d_state = $state;
                $d_zip = $zip;
            } 
            $address = str_replace(" ", "+", $d_streetaddres) . ",+" . str_replace(" ", "+", $d_route) . ",+" . str_replace(" ", "+", $d_city) . ",+" . str_replace(" ", "+", $d_zip) . ",+US";
            $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response_a = json_decode($response);
            if ($response_a->status == "ZERO_RESULTS") {
                $invalidMsg = "Please provide valid  Driveway Address";
                $response = array(
                    STATUS => false,
                    MESSAGE => $invalidMsg
                );
                $this->apiResponse($response);
                return true;
            }            
            $driveway_add = array(
                STREET => $d_streetaddres,
                ROUTE => $d_route,
                'city' => $d_city,
                STATE => $d_state,
                'zip' => $d_zip
            );
            $driveway = $this->Usermanagementmodel->driveway_exist($driveway_add);
            if ($driveway) {
                $invalidMsg = "Driveway already exist";
                $response = array(
                    STATUS => false,
                    MESSAGE => $invalidMsg
                );
                $this->apiResponse($response);
                return true;
            }

            $lat = $response_a->results [0]->geometry->location->lat;
            $long = $response_a->results [0]->geometry->location->lng;
            $url = 'https://maps.googleapis.com/maps/api/timezone/json?location=' . $lat . ',' . $long . '&timestamp=1331161200&sensor=false';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $apiResult = curl_exec($ch);
            $json = json_decode($apiResult, true);
            $time_zone = $json['timeZoneId'];
            $user = $_SESSION [LOGGED_IN];
            $data[USERID] = $user [USER_ID];
            $data[BUILDING] = $this->input->post('d_name', TRUE);
            $data['streetAddress'] = $d_streetaddres;
            $data['route'] = $d_route;
            $data['city'] = $d_city;
            $data['state'] = $d_state;
            $data['zip'] = $d_zip;
            $data['latitude'] = $lat;
            $data['longitude'] = $long;
            $data['timeZone'] = $time_zone;
            $data[DESCRIPTION] = $this->input->post(DESCRIPTION, TRUE);
            $data[INSTRUCTIONS] = $this->input->post(INSTRUCTIONS, TRUE);
            $data['price'] = $this->input->post('hourlyprice', TRUE);
            $data['dailyprice'] = $this->input->post('flatprice', TRUE);
            $data['slot'] = $this->input->post('slot', TRUE);
            $data['drivewayStatus'] = 0;
            $path = $this->input->post('flname', TRUE);
            if (!empty($path)) {
                $json_file = file_get_contents($path);
                $jfo = json_decode($json_file);
                foreach ($jfo as $fl) {
                    $photo [] = $fl;
                }
                $i = 1;
                foreach ($photo as $p) {
                    $data ['photo' . $i] = $p;
                    $i = $i + 1;
                }
            }
            
            $drivewayId = $this->Profilemodel->saveDriveway($data);
            if ($user['role'] == 3) {
                $userData['roleID'] = 4;
                $this->Profilemodel->updateUserrole($userData, $user [USER_ID]);
            }
            $data_u ['building'] = $building;
            $data_u ['streetAddress'] = $streetaddres;
            $data_u [ROUTE] = $route;
            $data_u ['city'] = $city;
            $data_u [STATE] = $state;
            $data_u ['zip'] = $zip;
          
            $this->Profilemodel->updateUserAddress($data_u, $user [USER_ID]);
            //$this->load->library('encrypt');
           // $drivewayIdnew =  $this->encrypt->encode($drivewayId);
            
            $drivewayIdnew = $this->my_encrypt($drivewayId, ENCRYPTION_KEY_256BIT);
            $this->sendEmail($drivewayIdnew);

            $response = array(
                STATUS => true,
                USER_ID => $drivewayId
            );
            $this->apiResponse($response);
        }
    }

    /**
     * To update the driveway info 
     * 
     * @returns response in json format
     */
    public function update_driveway()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $user = $_SESSION[LOGGED_IN];
            $userId = $user[USER_ID];
            $drivewayId = $this->input->post(DRIVEWAY_ID, TRUE);
            $data[BUILDING] = $this->input->post(BUILDING, TRUE);
            $data[DESCRIPTION] = $this->input->post(DESCRIPTION, TRUE);
            $data[INSTRUCTIONS] = $this->input->post(INSTRUCTIONS, TRUE);
            $data['price'] = $this->input->post('hourlyprice', TRUE);
            $data['dailyprice'] = $this->input->post('flatprice', TRUE);
            $data['slot'] = $this->input->post('slot', TRUE);
            $path = $this->input->post('flname', TRUE);
            if (!empty($path)) {
                $json_file = file_get_contents($path);
                $jfo = json_decode($json_file);
                foreach ($jfo as $fl) {
                    $photo [] = $fl;
                }
                $i = 1;
                foreach ($photo as $p) {
                    $data['photo' . $i] = $p;
                    $i = $i + 1;
                }
            }
            $this->Profilemodel->updateDriveway($data, $drivewayId, $userId);
            $_SESSION[DRIVEWAY_ID] = $drivewayId;
            $response = array(
                STATUS => true,
                DRIVEWAY_ID => $drivewayId
            );
            $this->apiResponse($response);
        }
    }

    /**
     * To view report user page
     *
     */
    public function reportUser()
    {
        $this->_tpl('ReportUser');
    }

    /**
     * To send email Louiepak
     * 
     * @param integer $drivewayID drivewayID
     * 
     * On success sends email to parker and renter
     *     
     */
    function sendEmail($drivewayID)
    {
       // $this->load->library('encrypt');
       // $drivewayID =  $this->encrypt->decode($drivewayID); 
        $drivewayID = $this->my_decrypt($drivewayID, ENCRYPTION_KEY_256BIT);
        $this->load->model('booking/Bookingmodel');
        $driveway = $this->Bookingmodel->getdrivewayInfo($drivewayID);
        $constants = $this->Bookingmodel->getConstants();
        $adminuser = $this->Bookingmodel->getadmin();
        $message = '
                        <html>
                            <head>
                                <title>Added New driveway</title>
                            </head>
                            <body>
                           
                            <h2>LouiePark Renter added new driveway!</h2>
                            <h4>Driveway Address:</h4>
                                ' . $driveway->building . '
                                <br>
                                ' . $driveway->route . '
                                <br>
                                ' . $driveway->streetAddress . ' ,  ' . $driveway->city . '
                                <br>
                                ' . $driveway->state . '   -  ' . $driveway->zip . '
                                   
                                <br><br>
                          
                                Thanks<br>LouiePark
                            </body>
                        </html>';
        // Send email 
        $this->load->library(EMAIL);
        $this->email->from($constants->fromEmail);
        $this->email->to($adminuser->emailID);
        $this->email->subject('Added New Driveway');
        $this->email->message($message);
        if (!$this->email->send()) {
            $emailInfo['emailStatus'] = 0;
            $emailInfo['toEmail'] = $adminuser->emailID;
            $emailInfo['fromEmail'] = $constants->fromEmail;
            $emailInfo['content'] = $message;
            $emailInfo['subject'] = 'Added New Driveway';
            $this->Profilemodel->saveEmailStatus($emailInfo);
        }
    }

    /**
     * To Resize image
     *
     * Images will be resized
     */
    private function resizeImage($imageName, $imagePath)
    {
        $config ['image_library'] = 'gd2';
        $config ['source_image'] = $imagePath . "/" . $imageName;
        $config ['new_image'] = $imagePath . "/thumb_" . $imageName;
        $config ['maintain_ratio'] = FALSE;
        $config ['width'] = 1000;
        $config ['height'] = 600;
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

}
