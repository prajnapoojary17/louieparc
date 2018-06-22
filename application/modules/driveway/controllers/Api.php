<?php

/**
 * File Name : Driveway api
 * 
 * Description : Api Controller for Driveway
 * Handles Driveway info
 * 
 * Created By : Reshma N
 * 
 * Created Date : 10/18/2016
 * 
 * Last Modified By : Reshma N
 * 
 * Last Modified Date : 11/29/2016
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Api extends MY_Controller
{

    function __construct()
    {
        $this->module = "driveway";
        parent::__construct();
        $this->load->model('DrivewayModel');
    }

    /**
     * To save driveway
     * It will generate latitude and longitude from given address
     * 
     * @returns response in json format
     */
    public function saveDriveway()
    {
        if (isset($_SESSION [LOGGED_IN])) {
        $userId = $this->getUserId();
        $drivewayID = $this->input->post('drivewayID', TRUE);
       // $userId = $this->input->post('id', TRUE);
        $streetAddress = $this->input->post('id', TRUE);
        $state = $this->input->post('state', TRUE);
        $city = $this->input->post('city', TRUE);
        $zip = $this->input->post('zip', TRUE);
        $invalidMsg = false;
        if (($state == "")) {
            $invalidMsg = "state is required";
        } else if ($city == "") {
            $invalidMsg = "city is required";
        }
        if ($invalidMsg) {
            $response = array(
                "status" => false,
                "message" => $invalidMsg
            );
            $this->apiResponse($response);
            return true;
        }
        $address = $streetAddress . $city . $state . $zip;
        $location = rawurlencode($address);
        $url = "http://maps.google.com/maps/api/geocode/json?address=$location&sensor=false&region=US";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        $lat = $response_a->results [0]->geometry->location->lat;
        $long = $response_a->results [0]->geometry->location->lng;
        $photo1 = $this->uploadImage($_FILES ['photo1'] ['name']);
        $photo2 = $this->uploadImage($_FILES ['photo2'] ['name']);
        $photo3 = $this->uploadImage($_FILES ['photo3'] ['name']);
        $photo4 = $this->uploadImage($_FILES ['photo4'] ['name']);
        $data ['drivewayID'] = $drivewayID;
        $data ['userID'] = $userId;
        $data ['streetAddress'] = $streetAddress;
        $data ['city'] = $city;
        $data ['state'] = $state;
        $data ['latitude'] = $lat;
        $data ['longitude'] = $long;
        $data ['photo1'] = $photo1;
        $data ['photo2'] = $photo2;
        $data ['photo3'] = $photo3;
        $data ['photo4'] = $photo4;
        $data ['drivewayStatus'] = 1;
        $this->DrivewayModel->saveDriveway($data);
        $response = array(
            "status" => true
        );
        $this->apiResponse($response);
        }        
    }

    /**
     * To get driveway information of individual Driveway
     * 
     * @param integer $drivewayId drivewayID
     * 
     * @returns response in json format
     */
    public function getDrivewayInfo($drivewayId)
    {     
        $drivewayData = $this->DrivewayModel->getDrivewayInfo($drivewayId);
        if ($drivewayData) {
            $this->apiResponse($drivewayData);
        }
        return true;
    }

    /**
     * To all active driveway information
     * 
     * @returns response in json format
     */
    public function getDriveways()
    {
        $drivewayData = $this->DrivewayModel->getDriveways();
        if ($drivewayData) {
            $this->apiResponse($drivewayData);
        }
        return true;
    }

    /**
     * To upload driveway photos to driveway folder and return filename to store
     * 
     * @param string $imgName Image name
     * 
     * @returns true or false
     */
    private function uploadImage($imgName)
    {
        $this->load->helper('form');
        $nameExplode = explode(".", $imgName);
        $path1 = $this->config->item('location_image_path');
        $path2 = "driveway";
        $config['upload_path'] = $path1 . $path2;
        $config['allowed_types'] = 'gif|png|jpeg|jpg';
        $config['max_size'] = $this->config->item('location_image_size');
        $config['file_name'] = time() . rand(0, 10) . '.' . end($nameExplode);
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (isset($imgName) && $this->upload->do_upload('profImage')) {
            $fileData = $this->upload->data();
            return $fileData['file_name'];
        }
        return false;
    }

}
