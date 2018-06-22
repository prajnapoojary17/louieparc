<?php

/**
 *
 * File Name : Login api Controller
 *
 * Description : This is used to handle login process of user
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
        $this->module = "user";
        parent::__construct();
    }

    /**
     *
     * To get logged in user detail 
     * 
     * @param integer $userId User ID
     *
     * @returns response in json format
     *
     */
    public function get($userId)
    {
        if (!$this->checkLogin($this->module)) {
            $this->apiResponse('', 401);
            return true;
        }
        $userData = $this->Usermanagementmodel->getUser($userId);
        if ($userData) {
            $this->apiResponse($userData);
        }
        return true;
    }

}
