<?php

/**
 * File Name : Api Controller
 *
 * Description : This is used to Handle User management page for both Parker and Renter 
 *
 * Created By : Reshma N
 *
 * Created Date : 18/10/2016
 *
 * Last Modified By : Reshma N
 *
 * Last Modified Date : 29/11/2016
 *
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Api extends MY_Controller
{

    function __construct()
    {
        $this->module = "usermanagement";
        parent::__construct();
        $this->load->model('Usermanagementmodel');
        $this->load->library(UPLOAD);
        $this->load->library('image_lib');
    }

    /**
     * Api function to save Sign Up data of Parker
     *
     * Processes the input data and save in database
     *
     * WElcome E_mail is sent to Parker
     * 
     * @returns response in json format 
     */
    public function saveParker()
    {
        $data_u = array();
        $data_v = array();
        $data_r = array();
        $invalidMsg = false;
        $roleid = $this->input->post('role', TRUE);
        $signupType = $this->input->post(SIGNUP_TYPE, TRUE);
        $status = $this->input->post(STATUS, TRUE);
        $username = $this->input->post(USER_NAME, TRUE);
        $password = $this->input->post('password', TRUE);
        $rpassword = $this->input->post('rpassword', TRUE);
        $email = $this->input->post(EMAIL, TRUE);
        $pic = $this->input->post(FB_PROFILE);
        $contactnum1 = $this->input->post('contactnum', TRUE);
        $contactnum = preg_replace(REGEXP_NUMBER, '', $contactnum1);
        if (empty($_POST [FB_PROFILE])) {
            $profileImage = $this->uploadImage();
        } else {
            $profileImage = $this->uploadFbImage($pic);
        }
        $firstName = $this->input->post(FIRST_NAME, TRUE);
        $lastName = $this->input->post(LAST_NAME, TRUE);
        if (!empty($this->input->post(MODEL))) {
            $model = $this->input->post(MODEL, TRUE);
            $year = $this->input->post('year', TRUE);
            $color = $this->input->post('color', TRUE);
            $vehiclenumber = $this->input->post('vehiclenumber', TRUE);
            if (isset($userID)) {
                $data_v [USERID] = $userID;
            }
            $data_v [MODEL] = $model;
            $data_v ['year'] = $year;
            $data_v ['color'] = $color;
            $data_v ['vehicleNumber'] = $vehiclenumber;
            $data_v [STATUS] = 1;
            $data ['data_v'] = $data_v;
        }
        $user = $this->Usermanagementmodel->username_exist($username);
        $emails = $this->Usermanagementmodel->email_exist($email);
        if (($username == "")) {
            $invalidMsg = "username is required";
        } else if (($password == "")) {
            $invalidMsg = "password is required";
        } else if (($rpassword == "")) {
            $invalidMsg = "Confirm password is required";
        } else if (($password != $rpassword)) {
            $invalidMsg = "passwords doesn't match";
        } else if (($email == "")) {
            $invalidMsg = "Email is required";
        } else if ($contactnum == "") {
            $invalidMsg = "Contact num is required";
        } else if (($user)) {
            $invalidMsg = "user name already exist";
        } else if (($emails)) {
            $invalidMsg = "email  already exist";
        }
        if ($invalidMsg) {
            $response = array(
                STATUS => false,
                MESSAGE => $invalidMsg
            );
            $this->apiResponse($response);
            return true;
        }  
        $pass = md5($password); 
        $data_u [USERNAME] = $username;       
        $data_u ['userCode'] = $pass;        
        $data_u ['emailID'] = $email;
        $data_u [PHONE] = $contactnum;
        $data_u ['profileImage'] = $profileImage;
        $data_u [STATUS] = $status;
        $data_u [SIGNUP_TYPE] = $signupType;
        $data_u [FIRST_NAME] = $firstName;
        $data_u [LAST_NAME] = $lastName;
        $data_u [VERIFICATION_STATUS] = 1;       
        $data_r ['roleID'] = $roleid;
        $data ['data_u'] = $data_u;
        $data ['data_r'] = $data_r;
        $userID = $this->Usermanagementmodel->saveParker($data);
        $response = array(
            STATUS => true,
            USER_ID => $userID
        );
        $this->apiResponse($response);
    }

    /**
     * Api function to login and build session of both Parker and Renter     
     * 
     * @returns response in json format 
     */
    public function saveParkerInfo($userID)
    {
        $result = $this->Usermanagementmodel->getUserInfo($userID);
        if ($result) {
            $sess_array = array();
            foreach ($result as $row) {
                $sess_array = array(
                    USER_ID => $row->userID,
                    'user_name' => $row->userName,
                    STATUS => $row->status,
                    'role' => $row->roleID,
                    'profile' => $row->profileImage,
                    'fb_token' => ''
                );

                $this->session->set_userdata('logged_in', $sess_array);
                if ($row->roleID == 2) {
                    $message = '
                        <html>
                            <head>
                                <title>Welcome to the Louiepark community!</title>
                            </head>
                            <body>
                            <h2>Welcome to Louiepark ' . $row->userName . '</h2>    
                            <p>Thank you for becoming a renter on LouieParc, we’re very excited to have you here! Our renters are our most valuable assets, without you, this wouldn’t be possible.</p><br>                                
                                                                       
                                    <p>We’re doing some final checks on your profile, then you should be good to go! You will receive a verification code in the next 24 hours. Once you make your driveway live, you can begin earning money!</p><br/>
                       <p>We hope you have a great experience with us and pass our name along to a friend! </p>
                                <br><br><br>
                                Kramer Caswell<br>Co-Founder of LouiePark
                            </body>
                        </html>
                        ';
                } else {
                    $message = '
                        <html>
                            <head>
                                <title>Welcome to the Louiepark community!</title>
                            </head>
                            <body>    
                            <img src="' . base_url('assets/images/logo.png') . '" border="0"><br>
                            <h2>Welcome to the Louiepark community!</h2>                            
                                <br><br>
                                <p>Thank you for creating a profile on Louiepark. We’re excited to have you here. Parking can be stressful, that’s why we’re here to serve you!<br> We hope you have a great experience with us and pass our name along to a friend.</p>
                                <br><br><br>
                                Kramer Caswell<br><br>
                                Co-Founder of Louiepark
                            </body>
                        </html>
                        ';
                }
                // Send welcome email
                $useremail = $row->emailID;
                $this->load->library(EMAIL);
                $this->email->from(FROM_EMAIL);
                $this->email->to($useremail);
                $this->email->subject('Welcome to Louiepark');
                $this->email->message($message);
                $this->email->send();
            }
        }
        $drivewayinfo = $this->session->userdata('driveway_search');
        $driveway_id = $drivewayinfo['driveway_id'];
        if ($driveway_id) {
            redirect(base_url() . "driveway");
        } else {
            redirect(base_url() . 'dashboard');
        }
    }

    /**
     * Api function to save Sign Up data of Renter
     * 
     * @returns response in json format 
     */
    public function saveRenter()
    {
        $this->load->helper('string');
        $invalidMsg = false;
        $roleid = $this->input->post('role', TRUE);
        $signupType = $this->input->post(SIGNUP_TYPE, TRUE);
        $status = $this->input->post(STATUS, TRUE);
        $verificationStatus = $this->input->post(VERIFICATION_STATUS, TRUE);
        $email = $this->input->post(EMAIL, TRUE);
        $password = $this->input->post('password', TRUE);
        $rpassword = $this->input->post('rpassword', TRUE);
        $username = $this->input->post(USER_NAME, TRUE);
        $contactnum1 = $this->input->post('contactnum', TRUE);
        $contactnum = preg_replace(REGEXP_NUMBER, '', $contactnum1);
        if (empty($_POST [FB_PROFILE])) {
            $profileImage = $this->uploadImage();
        } else {
            $profileImage = $this->uploadFbImage($pic);
        }
        $firstName = $this->input->post(FIRST_NAME, TRUE);
        $lastName = $this->input->post(LAST_NAME, TRUE);
        $bmonth = $this->input->post(BMONTH, TRUE);
        $bday = $this->input->post('bday', TRUE);
        $byear = $this->input->post(BYEAR, TRUE);
        $ts = mktime(0, 0, 0, $bmonth, $bday, $byear);
        $birthDate = date('Y-m-d', $ts);
        $building = $this->input->post('h_name', TRUE);
        $streetaddres = $this->input->post('streetaddres', TRUE);
        $route = $this->input->post(ROUTE, TRUE);
        $city = $this->input->post('city', TRUE);
        $state = $this->input->post(STATE, TRUE);
        $zip = $this->input->post('zip', TRUE);
        $hearfrom = $this->input->post('hearfrom', TRUE);
        $drivewayadd = $this->input->post('about', TRUE);
        if ($drivewayadd == 'no') {
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
        $description = $this->input->post('description', TRUE);
        $instructions = $this->input->post('instructions', TRUE);
        $price = $this->input->post('hourlyprice', TRUE);
        $dailyprice = $this->input->post('flatprice', TRUE);
        $slot = $this->input->post('slot', TRUE);
        $address = str_replace(" ", "+", $d_streetaddres) . ",+" . str_replace(" ", "+", $d_route) . ",+" . str_replace(" ", "+", $d_city) . ",+" . str_replace(" ", "+", $d_zip) . ",+US";        
        $validAddress = $this->getTimeZone($address);
            if ($validAddress [MESSAGE] == SUCCESS) {
                $time_zone = $validAddress ['time_zone'];
                $lat = $validAddress ['lat'];
                $long = $validAddress ['long'];
            } else {
                $invalidMsg = $validAddress [MESSAGE];
            }            
        $user = $this->Usermanagementmodel->username_exist($username);
        $emails = $this->Usermanagementmodel->email_exist($email);
        if (($roleid == "")) {
            $invalidMsg = "Role Id is required";
        } else if (($signupType == "")) {
            $invalidMsg = "Signup Type value is required";
        } else if (($status == "")) {
            $invalidMsg = "Status is required";
        } else if (($username == "")) {
            $invalidMsg = "username is required";
        } else if (($password == "")) {
            $invalidMsg = "password is required";
        } else if (($rpassword == "")) {
            $invalidMsg = "Confirm password is required";
        } else if (($password != $rpassword)) {
            $invalidMsg = "passwords doesn't match";
        } else if (($email == "")) {
            $invalidMsg = "Email is required";
        } else if (($firstName == "")) {
            $invalidMsg = "First Name is required";
        } else if (($lastName == "")) {
            $invalidMsg = "Last Name is required";
        } else if (($bmonth == "")) {
            $invalidMsg = "Month Name is required";
        } else if (($bday == "")) {
            $invalidMsg = "Date is required";
        } else if (($byear == "")) {
            $invalidMsg = "Year is required";
        } else if ($contactnum == "") {
            $invalidMsg = "Contact num is required";
        } else if (($streetaddres == "")) {
            $invalidMsg = "Streetaddres is required";
        } else if (($city == "")) {
            $invalidMsg = "City is required";
        } else if (($state == "")) {
            $invalidMsg = "State is required";
        } else if (($zip == "")) {
            $invalidMsg = "ZIP is required";
        } else if (($hearfrom == "")) {
            $invalidMsg = "Hear From is required";
        } else if (($description == "")) {
            $invalidMsg = "Driveway Description is required";
        } else if (($instructions == "")) {
            $invalidMsg = "Driveway Instructions is required";
        } else if (($price == "")) {
            $invalidMsg = "Driveway Price is required";
        } else if (($user)) {
            $invalidMsg = "User Name already exist";
        } else if (($emails)) {
            $invalidMsg = "Email ID already exist";
        }
        $pass = md5($password);
        $data_b = array();
        if (!empty($this->input->post('card_number'))) {
            $accHolderType = $this->input->post(ACCOUNTHOLDER_TYPE, TRUE);
            $name_on_card = $this->input->post('nameon_card', TRUE);
            $billingphone = $this->input->post('billing_phone', TRUE);
            $billing_phone = preg_replace(REGEXP_NUMBER, '', $billingphone);
        }
        if (isset($name_on_card)) {
            $accDetails = $this->createBankAccount();
            if ($accDetails [MESSAGE] != SUCCESS) {
                $invalidMsg = $accDetails [MESSAGE];
            } else {
                $data_b [COUNTRY] = US;
                $data_b [CURRENCY] = 'usd';
                $data_b [ACCOUNTHOLDER_TYPE] = $accHolderType;
                $data_b [ACCHOLDER_NAME] = $name_on_card;
                $data_b [PHONE] = $billing_phone;
                $data_b [SECRET_KEY] = $accDetails [SECRET_KEY];
                $data_b [PUB_KEY] = $accDetails [PUB_KEY];
                $data_b ['token'] = $accDetails ['bankAccToken'];
                $data_b [STATUS] = 1;
            }
        }
        if ($invalidMsg) {
            $response = array(
                STATUS => false,
                MESSAGE => $invalidMsg
            );
            $this->apiResponse($response);
        } else {
            $data_u = array();
            $data_d = array();
            $data_r = array();
            if (isset($userID)) {
                $data_u [USERID] = $userID;
            }
            $data_u [USERNAME] = $username;
            $data_u ['userCode'] = $pass;
            $verificationCode = random_string('alnum', 5);
            $data_u [FIRST_NAME] = $firstName;
            $data_u [LAST_NAME] = $lastName;
            $data_u ['emailID'] = $email;
            $data_u [PHONE] = $contactnum;
            $data_u ['birthDate'] = $birthDate;
            $data_u ['profileImage'] = $profileImage;
            $data_u ['building'] = $building;
            $data_u ['streetAddress'] = $streetaddres;
            $data_u [ROUTE] = $route;
            $data_u ['city'] = $city;
            $data_u [STATE] = $state;
            $data_u ['zip'] = $zip;
            $data_u [SIGNUP_TYPE] = $signupType;
            $data_u ['hearfrom'] = $hearfrom;
            $data_u [STATUS] = $status;
            $data_u [VERIFICATION_STATUS] = $verificationStatus;
            $data_u ['verificationCode'] = $verificationCode;            
            $data_d ['building'] = $d_name;
            $data_d ['streetAddress'] = $d_streetaddres;
            $data_d [ROUTE] = $d_route;
            $data_d ['city'] = $d_city;
            $data_d [STATE] = $d_state;
            $data_d ['zip'] = $d_zip;
            $data_d ['latitude'] = $lat;
            $data_d ['longitude'] = $long;
            $data_d ['description'] = $description;
            $data_d ['instructions'] = $instructions;
            $data_d ['price'] = $price;
            $data_d ['dailyprice'] = $dailyprice;
            $data_d ['timeZone'] = $time_zone;
            $data_d ['slot'] = $slot;
            $path = $this->input->post('flname', TRUE);
            if (!empty($path)) {
                $json_file = file_get_contents($path);
                $jfo = json_decode($json_file);
                foreach ($jfo as $fl) {
                    $photo [] = $fl;
                }
                $i = 1;
                foreach ($photo as $p) {
                    $data_d ['photo' . $i] = $p;
                    $i = $i + 1;
                }
            }            
            $data_r ['roleID'] = $roleid;
            $data ['data_u'] = $data_u;
            $data ['data_r'] = $data_r;
            $data ['data_d'] = $data_d;
            if (!empty($data_b)) {
                $data ['data_b'] = $data_b;
            }
            $userID = $this->Usermanagementmodel->saveRenter($data);
            $response = array(
                STATUS => true,
                USER_ID => $userID
            );
            $this->apiResponse($response);
        }
    }    
    
    /**
     * function to get address timezone
     *
     * @returns timezon
     */
    public function getTimeZone($address)
    {
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
            return array(                
                 MESSAGE => $invalidMsg
            );
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
             return array(               
                MESSAGE => SUCCESS,
                "time_zone" => $time_zone,
                "lat" => $lat,
                "long" => $long 
            );
    }
    
    /**
     * Api function for validating Users
     *
     * @returns true or false
     */
    public function validation()
    {
        $username = $this->input->post(USER_NAME, TRUE);
        $email = $this->input->post(EMAIL, TRUE);
        $user = $this->Usermanagementmodel->username_exist($username);
        $emails = $this->Usermanagementmodel->email_exist($email);
        if ($user || $emails) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     * To Upload the Profile Image
     *
     * Images will be saved in assets/uploads/profilephoto folder
     * 
     * @returns filename
     */
    private function uploadImage()
    {
        $this->load->helper('form');
        $imgName = $_FILES [PROF_IMAGE] ['name'];
        $nameExplode = explode(".", $imgName);
        $path1 = $this->config->item(LOCATION_IMAGE_PATH);
        $path2 = "profilephoto";
        $config [UPLOAD_PATH] = $path1 . $path2;
        $config ['allowed_types'] = 'gif|png|jpeg|jpg';
        $config ['max_size'] = $this->config->item('location_image_size');
        $config [FILE_NAME] = time() . rand(0, 10) . '.' . end($nameExplode);
        $this->load->library(UPLOAD, $config);
        $this->upload->initialize($config);
        if (isset($_FILES [PROF_IMAGE]) && isset($_FILES [PROF_IMAGE] ['name']) && ( $imgName != '' ) && ($this->upload->do_upload(PROF_IMAGE))) {
            $fileData = $this->upload->data();
            return $fileData [FILE_NAME];
        }
        return false;
    }

    /**
     * To Upload the Profile Image
     *
     * Images will be saved in assets/uploads/profilephoto folder
     * 
     * @returns filename
     */
    public function uploadFbImage($pic)
    {
        $path1 = $this->config->item(LOCATION_IMAGE_PATH);
        $path2 = "profilephoto";
        $imagePath = $path1 . $path2;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pic);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $fileName = time() . rand(0, 10);
        $file = fopen($imagePath . '/' . $fileName, 'w+');
        fputs($file, $data);
        fclose($file);
        return $fileName;
    }

    /**
     * To Upload the driveway Image
     *
     * Images will be saved in assets/uploads/driveway folder
     * 
     * @returns filename
     */
    public function uploaddriveway()
    {
        $this->load->helper('form');
        $filesCount = count($_FILES [DRIVEWAY_PHOTOS] ['name']);
        $names = [];
        for ($i = 0; $i < $filesCount; $i ++) {
            $nameExplode = explode('.', basename($_FILES [DRIVEWAY_PHOTOS] ['name'] [$i]));
            $_FILES [USER_FILE] ['name'] = time() . rand(0, 10) . '.' . end($nameExplode);
            $_FILES [USER_FILE] ['type'] = $_FILES [DRIVEWAY_PHOTOS] ['type'] [$i];
            $_FILES [USER_FILE] ['tmp_name'] = $_FILES [DRIVEWAY_PHOTOS] ['tmp_name'] [$i];
            $_FILES [USER_FILE] [ERROR] = $_FILES [DRIVEWAY_PHOTOS] [ERROR] [$i];
            $_FILES [USER_FILE] ['size'] = $_FILES [DRIVEWAY_PHOTOS] ['size'] [$i];
            $path1 = $this->config->item(LOCATION_IMAGE_PATH);
            $path2 = "driveway";
            $config [UPLOAD_PATH] = $path1 . $path2;
            $config ['allowed_types'] = 'gif|png|jpeg|jpg';
            $this->load->library(UPLOAD, $config);
            $this->upload->initialize($config);
            $this->upload->do_upload(USER_FILE);
            $fileData = $this->upload->data();
            $this->resizeImage($fileData [FILE_NAME], $config [UPLOAD_PATH]);
            $names [$i] = "thumb_" . $fileData [FILE_NAME];
        }
        $fp = '';
        $path1 = $this->config->item(LOCATION_IMAGE_PATH);
        $path2 = "driveway/";
        $filename = $path1 . $path2 . time() . rand(0, 10) . '.json';
        $fp = fopen($filename, "w");
        fwrite($fp, json_encode($names));
        fclose($fp);
        echo json_encode($filename);
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

    /**
     * To created Bank account using stripe
     *
     * create managed stripe account add bank account for transfer
     * 
     * @returns account details
     */
    public function createBankAccount()
    {
        require_once (APPPATH . STRIPE_PATH);
        require_once (APPPATH . STRIPE_LIB_PATH);
        Stripe\Stripe::setApiKey(STRIPE_KEY);
        try {
            $accountInfo = \Stripe\Token::create(array(
                        "bank_account" => array(
                            COUNTRY => US,
                            CURRENCY => "usd",
                            "account_holder_name" => $this->input->post('nameon_card'),
                            "account_holder_type" => $this->input->post(ACCOUNTHOLDER_TYPE),
                            ROUTING_NUMBER => $this->input->post(ROUTING_NUMBER),
                            ACCOUNT_NUMBER => $this->input->post('card_number')
                        )
            ));
            $bankAccToken = $accountInfo->id;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $body = $e->getJsonBody();
            $err = $body [ERROR];           
            return array(
                MESSAGE => $err [MESSAGE],
                'accToken' => ''
            );
        }
        $accountInfo = Stripe\Account::create(array(
                    "managed" => true,
                    COUNTRY => US,
                    EMAIL => $this->input->post(EMAIL),
                    "legal_entity" => array(
                        'address' => array(
                            'city' => $this->input->post('city'),
                            COUNTRY => US,
                            "line1" => $this->input->post('streetaddres'),
                            "line2" => $this->input->post(ROUTE),
                            "postal_code" => $this->input->post('zip'),
                            STATE => $this->input->post(STATE),
                        ),
                        'business_name' => 'Louiepark',
                        'dob' => array(
                            'day' => $this->input->post('bday'),
                            'month' => $this->input->post(BMONTH),
                            'year' => $this->input->post(BYEAR),
                        ),
                        'first_name' => $this->input->post(FIRST_NAME),
                        'last_name' => $this->input->post(LAST_NAME),
                        SSN_LAST_4 => $this->input->post(SSN_LAST_4),
                        'type' => 'sole_prop'
                    ),
                    'tos_acceptance' => array(
                        'date' => time(),
                        'ip' => $_SERVER['REMOTE_ADDR']
                    )
        ));
        $accountID = $accountInfo->id;
        $secretKey = $accountInfo->keys ['secret'];
        $pubKey = $accountInfo->keys ['publishable'];

        // Aadd bank account for transfer
        $account = Stripe\Account::retrieve($accountID);
        $account->external_accounts->create(array(
            "external_account" => $bankAccToken
        ));
        if ($account) {         
            return array(
                MESSAGE => SUCCESS,
                "accountID" => $accountID,
                SECRET_KEY => $secretKey,
                PUB_KEY => $pubKey,
                "bankAccToken" => $bankAccToken
            );
        }
    }

    /**
     * To save Bank account using stripe
     *
     * create managed stripe account add bank account for transfer
     * 
     * @returns account details
     */
    public function saveBankAccount()
    {
        require_once (APPPATH . STRIPE_PATH);
        require_once (APPPATH . STRIPE_LIB_PATH);
        Stripe\Stripe::setApiKey(STRIPE_KEY);
        $name = $this->input->post(ACCHOLDER_NAME);
        $type = $this->input->post(ACCOUNTHOLDER_TYPE);
        $accNo = $this->input->post(ACCOUNT_NUMBER);
        $rtNo = $this->input->post(ROUTING_NUMBER);
        $phone = $this->input->post(PHONE);
        $line1 = $this->input->post('acc_address1');
        $line2 = $this->input->post('acc_address2');
        $city = $this->input->post('acc_city');
        $state = $this->input->post('acc_state');
        $zip = $this->input->post('acc_zip');
        $day = $this->input->post('bday');
        $month = $this->input->post(BMONTH);
        $year = $this->input->post(BYEAR);
        $user = $_SESSION ['logged_in'];
        $userId = $user [USER_ID];
        $userData = $this->Usermanagementmodel->getUser($userId);
        try {
            $accountInfo = \Stripe\Token::create(array(
                        "bank_account" => array(
                            COUNTRY => US,
                            CURRENCY => "usd",
                            "account_holder_name" => $name,
                            "account_holder_type" => $type,
                            ROUTING_NUMBER => $rtNo,
                            ACCOUNT_NUMBER => $accNo
                        )
            ));
            $bankAccToken = $accountInfo->id;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $body = $e->getJsonBody();
            $err = $body [ERROR];
            $result = array(
                STATUS => false,
                MESSAGE => $err [MESSAGE]
            );
            $this->apiResponse($result);
            return true;
        }
        if ($bankAccToken) {
            $accountInfo = Stripe\Account::create(array(
                        "managed" => true,
                        COUNTRY => US,
                        EMAIL => $userData->emailID,
                        "legal_entity" => array(
                            'address' => array(
                                'city' => $city,
                                COUNTRY => US,
                                "line1" => $line1,
                                "line2" => $line2,
                                "postal_code" => $zip,
                                STATE => $state,
                            ),
                            'business_name' => 'Louiepark',
                            'dob' => array(
                                'day' => $day,
                                'month' => $month,
                                'year' => $year,
                            ),
                            'first_name' => $userData->firstName,
                            'last_name' => $userData->lastName,
                            SSN_LAST_4 => $this->input->post(SSN_LAST_4),
                            'type' => 'sole_prop'
                        ),
                        'tos_acceptance' => array(
                            'date' => time(),
                            'ip' => $_SERVER['REMOTE_ADDR']
                        )
            ));
            $accountID = $accountInfo->id;
            $secretKey = $accountInfo->keys ['secret'];
            $pubKey = $accountInfo->keys ['publishable'];
            $account = Stripe\Account::retrieve($accountID);
            $ext_acc = $account->external_accounts->create(array(
                "external_account" => $bankAccToken
            ));
            if ($account) {
                $accDetails = array(
                    STATUS => true,
                    MESSAGE => SUCCESS
                );
                $this->load->model('dashboard/Dashboardmodel');
                $checkAcnt = $this->Dashboardmodel->checkAccountExist($userId);
                if ($checkAcnt) {
                    $status = 0;
                } else {
                    $status = 1;
                }
                $data [USERID] = $userId;
                $data [COUNTRY] = US;
                $data [CURRENCY] = 'usd';
                $data [ACCOUNTHOLDER_TYPE] = $type;
                $data [ACCHOLDER_NAME] = $name;
                $data [PHONE] = $phone;
                $data [SECRET_KEY] = $secretKey;
                $data [PUB_KEY] = $pubKey;
                $data ['token'] = $bankAccToken;
                $data ['accID'] = $accountID;
                $data ['bankAccID'] = $ext_acc->id;
                $data [STATUS] = $status;
                $this->Usermanagementmodel->saveBankToken($data);
                $this->apiResponse($accDetails);
                return true;
            } else {
                $result = array(
                    STATUS => false,
                    MESSAGE => 'Something went wrong'
                );
                $this->apiResponse($result);
                return true;
            }
        }
    }

    /**
     * To dlete driveway image
     *
     * Images will get deleted from folder
     */
    public function delete_file($drivewayId)
    {
        $path = $this->input->post('key');
        $arr = explode(",", $path, 2);
        $image = $arr[0];
        $name = $arr[1];
        $image = FCPATH . 'assets/uploads/driveway/' . $image;
        if (unlink($image)) {
            $data = array(
                $name => null
            );
            $this->db->where('drivewayID', $drivewayId);
            $this->db->update('tbl_driveway', $data);
        }
        $return = '';
        echo json_encode($return);
    }

}
