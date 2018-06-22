<?php

/**
 * File Name : Api Controller
 *
 * Description : This is used to Handle Renter 
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
        $this->module = "renter";
        parent::__construct();
        $this->load->model('Rentermodel');
    }

}
