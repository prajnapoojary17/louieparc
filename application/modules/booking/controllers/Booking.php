<?php

/**
 *
 * File Name : Booking Controller
 *
 * Description : This is used to keep track of Driveway Booking details
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

class Booking extends MY_Controller
{

    function __construct()
    {
        $this->module = "booking";
        parent::__construct();
        if (!$this->checkLogin($this->module)) {
            redirect(base_url() . "login");
        }
        $this->load->model('Bookingmodel');
    }

    /**
     * To show Booking page
     */
    public function index()
    {
        $this->_tpl('Booking');
    }

    /**
     * To Cancel driveway booking
     *
     * Processes the input data and cancels the booking
     *
     * E mail is sent to renter regarding cancellation
     * 
     * @returns response in json format 
     */
    public function cancelBooking()
    {
        if (isset($_SESSION [LOGGED_IN])) {                
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        $bookingId = $this->input->post('bookingId', TRUE);
        $canceltype = $this->input->post('cancelType', TRUE);
        /* 1 for canceling the booking as Renter. 2 for canceling the booking as Rentee. For Rentee the booking can be cancelled 30 minutes before the from date and time */
        $chargeInfo = $this->Bookingmodel->getchargeId($bookingId);
        //get booking info based on booking id
        $bookingInfo = $this->Bookingmodel->getBookingInfo($bookingId);
        $drivewayId = $bookingInfo[0]->drivewayID;
        $bookingFrom = $bookingInfo[0]->fromDate;
        $bookingFromdateonly = date('Y-m-d', strtotime($bookingFrom));
        $bookingTo = $bookingInfo[0]->toDate;
        $bookingTodateonly = date('Y-m-d', strtotime($bookingTo));
        $bookingFromtime = $bookingInfo[0]->fromTime;
        $bookingTotime = $bookingInfo[0]->toTime;
        $bookingPrice = $bookingInfo[0]->totalPrice;
        $bookedUser = $bookingInfo[0]->userID;
        $chargefee = (($constants->stripeFee / 100) * $bookingPrice) + $constants->stripeProcessfee + $constants->applicationFeesdolars;
        $totalCharge = number_format($chargefee, 2);
        $driveway = $this->Bookingmodel->getdrivewayInfo($drivewayId);
        $accountInfo = $this->Bookingmodel->getOwnerInfo($driveway->userID);
        $currentDate = new DateTime(date(DATE_TIME));
        $currentDate->setTimezone(new DateTimeZone(UTC));
        $curdate = $currentDate->format(DATE_TIME);
        $refundamount = 0;
        $dorefund = 0;
        $logo = '<img src="' . 'http://' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . str_replace('index.php', '', $_SERVER ['SCRIPT_NAME']) . '/assets/images/logo.png" border="0">';
        
         $user_info = $_SESSION[LOGGED_IN];
         $user_Id = $user_info[USER_ID];         
        if ($canceltype == 1 && $driveway->userID = $user_Id) {
            
             $drivewayUser = $this->Bookingmodel->getdrivewayInfo($drivewayId);
            
           // $diffinminutes = round((strtotime($bookingTo) - strtotime($curdate)) / 60, 1);
           // if ($diffinminutes > 0) {
                //refund full amount
                $refundamount = $bookingPrice;// - $totalCharge;
                $dorefund = 1;
            //}
          
            $message = '<html>
                            <head>
                                <title>Cancelled  Booked driveway</title>
                            </head>
                            <body>
                            ' . $logo . '<br>
                        <h4>Your booking has been canceled by the owner of the driveway.</h4>
                        <p>We are sorry to inform you, but your driveway booking has been canceled. You were scheduled to stay at:</p>
                        <b>*Driveway Information:</b><br/>
                                ' . $driveway->building . '
                                <br>
                                ' . $driveway->route . ' ' . $driveway->streetAddress . '    
                                <br>
                                ' . $driveway->city . '    ' . $driveway->state . '-' . $driveway->zip . '
                                <br><br>
                                <b>Dates & time:</b><br/>
                                From Date/Time:  ' . $bookingFromdateonly . ' / ' . $bookingFromtime . '<br>
                                To Date/Time:  ' . $bookingTodateonly . ' / ' . $bookingTotime . '<br><br>
                                <b>Price of booking:</b><br/> ' . $bookingPrice . '<br><br>
                                <p>Your money will be fully refunded. If you believe action needs to be taken against this renter, please report them and write your reasons why. We will look into it.</p><br>
                                <p>Thank you for scheduling with us. We apologize again, please look for another driveway in the meantime. </p> <br/>    <br/>
                                 Thanks<br>LouiePark
                            </body>
                        </html>';

            $message1 = '<html>
                            <head>
                                <title>cancelled booked driveway</title>
                            </head>
                            <body>
                            ' . $logo . '<br>
                        <h4>Your have cancelled booking of following driveway.</h4>                        
                        <b>*Driveway Information:</b><br/>
                                ' . $driveway->building . '
                                <br>
                                ' . $driveway->route . ' ' . $driveway->streetAddress . '    
                                <br>
                                ' . $driveway->city . '    ' . $driveway->state . '-' . $driveway->zip . '
                                <br><br>
                                <b>Dates & time:</b><br/>
                                From Date/Time:  ' . $bookingFromdateonly . ' / ' . $bookingFromtime . '<br>
                                To Date/Time:  ' . $bookingTodateonly . ' / ' . $bookingTotime . '<br><br>
                                <b>Price of booking:</b><br/> ' . $bookingPrice . '<br><br>    
                                     Thanks<br>LouiePark
                            </body>
                        </html>';
        }
        //allow only if booking from >30 mins
        else if($bookedUser == $user_Id) {
            $userDetail = $this->session->userdata('logged_in');
            $userId = $userDetail [USER_ID];
            $user = $this->Bookingmodel->getUserEmail($userId);
            $diffinminutes = (strtotime($bookingFrom) - strtotime($curdate)) / 60;
            if ($diffinminutes > 30) {
                $dorefund = 1;
                $refundamount = $bookingPrice;// - $totalCharge;
                //refund full amount 
            }
              else{
                 $this->apiResponse(array(
                    "status" => false,
                     MESSAGE => 'Booking Cancellation Failed'
                ));
            return true;
            }
            $message = '<html>
                            <head>
                                <title>Cancelled  Booked driveway</title>
                            </head>
                            <body>
                            ' . $logo . '<br>
                        <h4>The booking of your driveway has been canceled by: &nbsp;' . $user->firstName . '&nbsp;' . $user->lastName . '</h4>
                        <p>We are sorry to inform you, but your driveway booking has been canceled. The times that were originally scheduled were:</p>
                From Date/Time:  ' . $bookingFromdateonly . ' / ' . $bookingFromtime . '<br>
                To Date/Time:  ' . $bookingTodateonly . ' / ' . $bookingTotime . '<br><br>                              
                        <br><br>
                        <b>*Driveway Information:</b><br/>
                                ' . $driveway->building . '
                                <br>
                                ' . $driveway->route . ' ' . $driveway->streetAddress . '    
                                <br>
                                ' . $driveway->city . '    ' . $driveway->state . '-' . $driveway->zip . '
                                <br><br>
                                <p>Thank you for being a renter on LouiePark, you make this project work!</p>
                            </body>
                        </html>';

            $message1 = '<html>
                            <head>
                                <title>cancelled booked driveway</title>
                            </head>
                            <body>
                            ' . $logo . '<br>
                        <h4>Your have cancelled booking of following driveway.</h4>                        
                        <b>*Information of driveway:</b><br/>
                                ' . $driveway->building . '
                                <br>
                                ' . $driveway->route . ' ' . $driveway->streetAddress . '    
                                <br>
                                ' . $driveway->city . '    ' . $driveway->state . '-' . $driveway->zip . '
                                <br><br>
                                <b>Dates & time:</b><br/>
                                From Date/Time:  ' . $bookingFromdateonly . ' / ' . $bookingFromtime . '<br>
                                To Date/Time:  ' . $bookingTodateonly . ' / ' . $bookingTotime . '<br><br>
                                <b>Price of booking:</b><br/> ' . $bookingPrice . '<br><br>           
                                     Thanks<br>LouiePark
                            </body>
                        </html>';
        }
        if ($dorefund == 1) {
            require_once (APPPATH . STRIPE_PATH);
            require_once (APPPATH . STRIPE_LIB_PATH);
            Stripe\Stripe::setApiKey($accountInfo->secretKey);
            try {
                $ch = \Stripe\Charge::retrieve($chargeInfo->chargeId);
                $ch->refunds->create(array('amount' => $refundamount * 100));
            } catch (\Stripe\Error\InvalidRequest $e) {
                $body = $e->getJsonBody();
                $err = $body ['error'];
                $result = array(
                    MESSAGE => $err [MESSAGE],
                    'status' => false
                );
                $this->apiResponse($result);
                return true;
            } catch (\Stripe\Error\ApiConnection $e) {
                return array(
                    MESSAGE => 'Network communication with Payment Gateway failed',
                    TOKEN => ''
                );
            }
           
            if ($canceltype == 1) {             
            $this->Bookingmodel->renterCancelBooking($drivewayId, $bookingId, $user_Id);
            }
            else{
                $this->Bookingmodel->cancelBooking($drivewayId, $bookingId, $user_Id);
            }
           // $this->load->library('encrypt');
           //$drivewayId = $this->encrypt->encode($drivewayId);
            
            $drivewayId = $this->my_encrypt($drivewayId, ENCRYPTION_KEY_256BIT);
            
            $this->sendEmail($drivewayId, $message, $canceltype, $bookedUser);
            $this->sendEmailtouser($message1);
            $this->apiResponse(array(
                "status" => true,
                MESSAGE => 'success'
            ));
            return true;
        }
        }
    }

    /**
     * To send email to parker and renter
     * 
     * @param integer $drivewayId drivewayID
     * @message text content for email message to parker/renter
     * 
     * On booking cancel sends email to parker and renter
     *     
     */
    function sendEmail($drivewayId, $message, $canceltype, $bookedUser)
    {
       // $this->load->library('encrypt');
        //$drivewayId = $this->encrypt->decode($drivewayId);
        
         $drivewayId = $this->my_decrypt($drivewayId, ENCRYPTION_KEY_256BIT);
         
        $driveway = $this->Bookingmodel->getdrivewayInfo($drivewayId);
        $user = $this->Bookingmodel->getUserEmail($bookedUser);
        $owner = $this->Bookingmodel->getUserEmail($driveway->userID);
        $constants = $this->Bookingmodel->getConstants();
        $useremail = $user->emailID;
        $owneremail = $owner->emailID;
        $this->load->library('email');
        $this->email->from($constants->fromEmail);
        if ($canceltype == 1) {
            $to = $this->email->to($useremail);
        } else {
            $to = $this->email->to($owneremail);
        }
        $this->email->subject('Driveway Booking cancel');
        $this->email->message($message);
        if (!$this->email->send()) {
            $emailInfo['emailStatus'] = 0;
            $emailInfo['toEmail'] = $to;
            $emailInfo['fromEmail'] = $constants->fromEmail;
            $emailInfo['content'] = $message;
            $emailInfo['subject'] = 'Driveway Booking cancel';
            $this->load->model('profile/Profilemodel');
            $this->Profilemodel->saveEmailStatus($emailInfo);
        }
    }

    /**
     * To send email to parker and renter
     * 
     * @param integer $drivewayId drivewayID
     * @message text content for email message to parker/renter
     * 
     * On booking cancel sends email to parker and renter
     *     
     */
    function sendEmailtouser($message1)
    {
        $userDetail = $this->session->userdata('logged_in');
        $userId = $userDetail [USER_ID];
        $user = $this->Bookingmodel->getUserEmail($userId);
        $constants = $this->Bookingmodel->getConstants();
        $this->load->library('email');
        $this->email->from($constants->fromEmail);
        $to = $this->email->to($user->emailID);
        $this->email->subject('Driveway Booking cancel');
        $this->email->message($message1);
        if (!$this->email->send()) {
            $emailInfo['emailStatus'] = 0;
            $emailInfo['toEmail'] = $to;
            $emailInfo['fromEmail'] = $constants->fromEmail;
            $emailInfo['content'] = $message1;
            $emailInfo['subject'] = 'Driveway Booking cancel';
            $this->load->model('profile/Profilemodel');
            $this->Profilemodel->saveEmailStatus($emailInfo);
        }
    }

    /**
     *
     * To get the nearest timezone of a location     
     * 
     * @param integer $cur_lat latitude of location
     * @param integer $cur_long longitude of location
     * @param integer $country_code optional country code  
     *
     * @returns $time_zone timezone
     *
     */
    function get_nearest_timezone($cur_lat, $cur_long, $country_code = '')
    {
        $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code) : DateTimeZone::listIdentifiers();
        if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {
            $time_zone = '';
            $tz_distance = 0;
            //only one identifier?
            if (count($timezone_ids) == 1) {
                $time_zone = $timezone_ids[0];
            } else {
                foreach ($timezone_ids as $timezone_id) {
                    $timezone = new DateTimeZone($timezone_id);
                    $location = $timezone->getLocation();
                    $tz_lat = $location['latitude'];
                    $tz_long = $location['longitude'];
                    $theta = $cur_long - $tz_long;
                    $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                    $distance = acos($distance);
                    $distance = abs(rad2deg($distance));
                    if (!$time_zone || $tz_distance > $distance) {
                        $time_zone = $timezone_id;
                        $tz_distance = $distance;
                    }
                }
            }
            return $time_zone;
        }
        return 'none?';
    }

}
