<?php

/**
 * File Name : Api Controller
 *
 * Description : This is used to Handle Parker 
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

class Api extends MY_Controller
{

    function __construct()
    {
        $this->module = "profile";
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
        $this->load->model('booking/Bookingmodel');
        $this->load->library('image_lib');
    }

    /**
     * To Upload the driveway Image
     *
     * Images will be saved in assets/uploads/driveway folder
     * 
     * @param integer $drivewayId Driveway ID
     * 
     * @returns response in json format(filename)
     */
    public function updatedriveway($drivewayId)
    {
        $this->load->model('dashboard/Dashdrivmodel');
        $user = $_SESSION [LOGGED_IN];
        $userId = $user [USER_ID];        
        $drivewayUser = $this->Dashdrivmodel->checkDrivewayUser($drivewayId, $userId);
        if($drivewayUser == 1){
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
            $path1 = $this->config->item('location_image_path');
            $path2 = "driveway";
            $config ['upload_path'] = $path1 . $path2;
            $config ['allowed_types'] = 'gif|png|jpeg|jpg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $this->upload->do_upload(USER_FILE);
            $fileData = $this->upload->data();
            $this->resizeImage($fileData ['file_name'], $config ['upload_path']);
            $names [$i] = "thumb_" . $fileData ['file_name'];
        }
        $fp = '';
        $path1 = $this->config->item('location_image_path');
        $path2 = "driveway/";
        $filename = $path1 . $path2 . time() . rand(0, 10) . '.json';
        $fp = fopen($filename, "w");
        fwrite($fp, json_encode($names));
        fclose($fp);
        $json_file = file_get_contents($filename);
        $jfo = json_decode($json_file);
        foreach ($jfo as $fl) {
            $photo [] = $fl;
        }
        foreach ($photo as $p) {
            $this->load->model('usermanagement/Usermanagementmodel');
            $drivewayData = $this->Usermanagementmodel->getDrivewayinfo($drivewayId);
            if ($drivewayData->photo1 === NULL) {
                $data['photo1'] = $p;
            } else if ($drivewayData->photo2 === NULL) {
                $data['photo2'] = $p;
            } else if ($drivewayData->photo3 === NULL) {
                $data['photo3'] = $p;
            } else if ($drivewayData->photo4 === NULL) {
                $data['photo4'] = $p;
            }
            $this->load->model('Profilemodel');
            $this->Profilemodel->updateDriveway($data, $drivewayId,$userId);
        }
        echo json_encode($filename);
        }
        else {
            redirect(base_url() . "dashboard");
        }
    
    }

    /**
     * To send email to LouiePark
     * 
     * @returns response in json format
     */
    public function reportUsermail()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $constant = $this->Bookingmodel->getConstants();
            $receivermailId = $constant->fromEmail;
            $subject = $this->input->post('subject');
            $messageText = $this->input->post(MESSAGE);
            $user = $_SESSION [LOGGED_IN];
            $senderID = $user [USER_ID];
            $result = $this->Profilemodel->getEmailid($senderID);
            $senderEmailID = $result->emailID;
            $message = '
                        <html>
                            <head>
                                <title></title>
                            </head>
                            <body>                                    
                                ' . $messageText . '                                
                            </body>
                        </html>
                        ';
            // Send email
            $this->load->library(EMAIL);
            $this->email->from($senderEmailID);
            $this->email->to($receivermailId);
            $this->email->subject($subject);
            $this->email->message($message);
            if (!$this->email->send()) {
                $emailInfo['emailStatus'] = 0;
                $emailInfo['toEmail'] = $receivermailId;
                $emailInfo['fromEmail'] = $senderEmailID;
                $emailInfo['content'] = $message;
                $emailInfo['subject'] = $subject;
                $this->load->model('profile/Profilemodel');
                $this->Profilemodel->saveEmailStatus($emailInfo);
            }

            if ($result) {
                $response = array(
                    STATUS => true,
                    MESSAGE => SUCCESS
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
     * To send email to renter
     * 
     * @returns response in json format
     */
    public function savemessage()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $receivermailId = $this->input->post(EMAILID);
            $subject = $this->input->post('subject');
            $messageText = $this->input->post(MESSAGE);
            $user = $_SESSION [LOGGED_IN];
            $senderID = $user [USER_ID];
            $result = $this->Profilemodel->getEmailid($senderID);
            $senderEmailID = $result->emailID;
            $message = '
                        <html>
                            <head>
                                <title></title>
                            </head>
                            <body>
                            <img src="' . base_url('assets/images/logo.png') . '" border="0"><br><br/>
                                ' . $messageText . '                                
                            </body>
                        </html>
                        ';
            // Send email
            $this->load->library(EMAIL);
            $this->email->from($senderEmailID);
            $this->email->to($receivermailId);
            $this->email->subject('LouiePark - ' . $subject);
            $this->email->message($message);
            if (!$this->email->send()) {
                $emailInfo['emailStatus'] = 0;
                $emailInfo['toEmail'] = $receivermailId;
                $emailInfo['fromEmail'] = $senderEmailID;
                $emailInfo['content'] = $message;
                $emailInfo['subject'] = 'LouiePark - ' . $subject;
                $this->load->model('profile/Profilemodel');
                $this->Profilemodel->saveEmailStatus($emailInfo);
            }

            if ($result) {
                $response = array(
                    STATUS => true,
                    MESSAGE => SUCCESS
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
     * To build session
     * 
     * @returns response in json format
     */
    public function messageOwner()
    {
        $emailId = $this->input->post('emailId');
        if (isset($emailId)) {
            $userData['constants'] = $this->Bookingmodel->getConstants();
            $userData[EMAILID] = $emailId;
            $this->_tpl('Message', $userData);
        } else {
            redirect(base_url() . "dashboard");
        }
    }

    /**
     * To remove the Profile image of logged in user
     *
     * @returns response in json format
     */
    public function removeProfilleimg()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $user = $_SESSION [LOGGED_IN];
            $userID = $user [USER_ID];
            $this->load->model('usermanagement/Usermanagementmodel');
            $result = $this->Usermanagementmodel->removeProfileimg($userID);
            $_SESSION[LOGGED_IN]['profile'] = 0;
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
     * To Delete the car info
     * 
     * @returns response in json format
     */
    public function delete_carinfo()
    {
        if (isset($_SESSION [LOGGED_IN])) {
            $user = $_SESSION[LOGGED_IN];
            $userId = $user[USER_ID];            
            $vehicleID = $this->input->post('id', TRUE);
            $data[STATUS] = 0;
            $result = $this->Profilemodel->deleteCar($vehicleID, $userId,$data);
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
