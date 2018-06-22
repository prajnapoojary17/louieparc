<?php

/**
 * File Name : Usermanagement Controller
 *
 * Description : This is used to Handle User management page for both Parker and Renter 
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

class Usermanagement extends MY_Controller
{

    function __construct()
    {
        $this->module = "usermanagement";
        parent::__construct();
        $this->load->model('Usermanagementmodel');
    }

    public function index()
    {
        
    }

    /**
     * Api function to get details for individual User
     *
     * @returns response in json format 
     */
   /* public function get()
    {
        $userId = $this->input->post('id', TRUE);
        $userData = $this->Usermanagementmodel->getUser($userId);
        $response['result'] = $userData;
        $this->apiResponse($response);
    }*/

    /**
     * Api function to get details for individual User and refund if any
     *
     * @returns response in json format 
     */
    public function getRenterInfo()
    {
         
		 $userId = $this->my_decrypt($this->input->post('id', TRUE), ENCRYPTION_KEY_256BIT);
		 $bookingId = $this->my_decrypt($this->input->post('id', TRUE), ENCRYPTION_KEY_256BIT);
		 
		 /*echo $drivewayId; exit;
		 $this->load->library('encrypt');
         $userId =  $this->encrypt->decode($this->input->post('id', TRUE));
       $bookingId =  $this->encrypt->decode($this->input->post('bid', TRUE));*/
        //$bookingId = $this->input->post('bid', TRUE);
        $userData = $this->Usermanagementmodel->getRenterInfo($userId, $bookingId);		
        $response['result'] = $userData;
        $this->apiResponse($response);
    }

    /**
     * Api function for validating Address
     *
     * Checks for existing Address
     * 
     * @returns true or false
     */
    public function drivewayExistCheck()
    {
        $address = array(
            STREET => $this->input->post(STREET, TRUE),
            ROUTE => $this->input->post(ROUTE, TRUE),
            'city' => $this->input->post('city', TRUE),
            STATE => $this->input->post(STATE, TRUE),
            'zip' => $this->input->post('zip', TRUE)
        );
        $driveway = $this->Usermanagementmodel->driveway_exist($address);
        if ($driveway) {
            echo "false";
        } else {
            echo "true";
        }
    }

    /**
     * Api function for validating Address
     *
     * Checks for existing Address
     * 
     * @returns true or false
     */
    public function drivewayExist()
    {
        $address = array(
            STREET => $this->input->post(STREET, TRUE),
            ROUTE => $this->input->post(ROUTE, TRUE),
            'city' => $this->input->post('city', TRUE),
            STATE => $this->input->post(STATE, TRUE),
            'zip' => $this->input->post('zip', TRUE)
        );
        $driveway = $this->Usermanagementmodel->driveway_exist($address);
        if ($driveway) {
            echo "false";
        } else {
            echo "true";
        }
    }
	
		
	    function my_decrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

}
