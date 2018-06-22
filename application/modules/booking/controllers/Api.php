<?php

/**
 *
 * File Name : Booking Api
 *
 * Description : This is used to keep track of Driveway Booking details
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
        $this->module = "booking";
        parent::__construct();
        $this->load->helper('date');
        $this->load->model('Bookingmodel');
    }

    /**
     * To process the booking of driveway
     *
     * On success sends email to parker and renter
     *
     * @return response in json format
     */
    public function bookDriveway()
    {
        if (!$this->checkLogin($this->module)) {
            $response = array(
                STATUS => false,
                MESSAGE => 'session timeout'
            );
            $this->apiResponse($response);
            return true;
        }
        //$this->load->library('encrypt');
        $fromTime = $this->input->post(FROM_TIME, TRUE);
        $toTime = $this->input->post(TO_TIME, TRUE);
        $fromDate = $this->input->post(FROM_DATE, TRUE);
        $toDate = $this->input->post(TO_DATE, TRUE);
        $userDetail = $this->session->userdata('logged_in');
        $userID = $userDetail [USER_ID];
        $customerId = '';
        $vehicleID = $this->input->post('vehicleID', TRUE);
        $billID = $this->input->post('billID', TRUE);
        $saveBill = $this->input->post('saveBill', TRUE);
        $totalPrice = $this->input->post('totalPrice', TRUE);
        $fee = $this->input->post('fee', TRUE);
        $user = $this->Bookingmodel->getUserEmail($userID);
        $useremail = $user->emailID;
        $centerlat = $this->input->post('c_lat', TRUE);
        $centerlong = $this->input->post('c_long', TRUE);
        $search_zone = $this->get_nearest_timezone($centerlat, $centerlong);
        if (!$vehicleID) {
            $data_v ['model'] = $this->input->post('model', TRUE);
            $data_v ['year'] = $this->input->post('year', TRUE);
            $data_v ['color'] = $this->input->post('color', TRUE);
            $data_v ['vehicleNumber'] = $this->input->post('vehiclenumber', TRUE);
            $data_v [USERID] = $userID;
            $data_v [STATUS] = 1;
            $vehicleID = $this->Bookingmodel->saveVehicleInfo($data_v);
        }
        if (!$billID) {
            
          // $useremailnew =  $this->encrypt->encode($useremail);
             $useremailnew = $this->my_encrypt($useremail, ENCRYPTION_KEY_256BIT);
            $tokenInfo = $this->getToken($useremailnew);
            if ($tokenInfo [MESSAGE] != SUCCESS) {
                $invalidMsg = $tokenInfo [MESSAGE];
                $response = array(
                    STATUS => false,
                    MESSAGE => $invalidMsg
                );
                $this->apiResponse($response);
                return true;
            } else {
                $customerId = $tokenInfo [CUSTOMERID];
                $expirationdate = $this->input->post(EXPIRATION_DATE, TRUE);
                $expiration_month = substr($expirationdate, 0, 2);
                $expiration_year = substr($expirationdate, 3);
                $name_on_card = $this->input->post(NAMEON_CARD, TRUE);
                $billing_phone = $this->input->post('billing_phone', TRUE);
                $billing_street = $this->input->post(BILLING_STREET, TRUE);
                $billing_city = $this->input->post(BILLING_CITY, TRUE);
                $billing_state = $this->input->post(BILLING_STATE, TRUE);
                $billing_zip = $this->input->post(BILLING_ZIP, TRUE);
                if ($saveBill == 1) {
                    
                   // $data_b['customer_id'] = $this->encrypt->encode($customerId);
                    $data_b['customer_id'] = $this->my_encrypt($customerId, ENCRYPTION_KEY_256BIT);
                }
                $data_b['expiration_month'] = $expiration_month;
                $data_b['expiration_year'] = $expiration_year;
                $data_b['name_on_card'] = $name_on_card;
                $data_b[USERID] = $userID;
                $data_b['phone'] = $billing_phone;
                $data_b['streetAddress'] = $billing_street;
                $data_b['city'] = $billing_city;
                $data_b['state'] = $billing_state;
                $data_b['zip'] = $billing_zip;
                $data_b[STATUS] = 1;
                $this->Bookingmodel->saveBillingToken($data_b);
            }
        } else {
            $customer = $this->Bookingmodel->getUserToken($billID);
           // $customerId = $this->encrypt->decode($customer->customer_id);
             $customerId = $this->my_decrypt($customer->customer_id, ENCRYPTION_KEY_256BIT);
        }
        $ownerId = $this->input->post('ownerId', TRUE);
        $drivewayOwnerInfo = $this->Bookingmodel->getOwnerInfo($ownerId);
		
        $key = $drivewayOwnerInfo->secretKey;
        $stripeAcc = $drivewayOwnerInfo->accID;
        
        //$this->load->library('encrypt');
       // $key =  $this->encrypt->encode($key); 
           $key = $this->my_encrypt($key, ENCRYPTION_KEY_256BIT);
        
        $chargeInfo = $this->chargeStripe($customerId, $key, $stripeAcc, $totalPrice);
        if ($chargeInfo [MESSAGE] == 'succeeded') {
            $fdate = new DateTime($fromTime, new DateTimeZone($search_zone));
            $fdate->setTimezone(new DateTimeZone(UTC));
            $tdate = new DateTime($toTime, new DateTimeZone($search_zone));
            $tdate->setTimezone(new DateTimeZone(UTC));
            $timeFrom = $fdate->format(TIME_FORMAT);
            $timeTo = $tdate->format(TIME_FORMAT);
            $drivewayID = $this->input->post('drivewayID', TRUE);
            $bookingType = $this->input->post('option', TRUE);
            $price = $this->input->post('price', TRUE);
            $data[USERID] = $userID;
            $data['drivewayID'] = $drivewayID;
            $data['vehicleID'] = $vehicleID;
            $datef = new DateTime($fromDate);
            $timef = new DateTime($fromTime);
            $bookingFrom = new DateTime($datef->format(DATE_FORMAT) . ' ' . $timef->format(TIME_FORMAT), new DateTimeZone($search_zone));
            $bookingFrom->setTimezone(new DateTimeZone(UTC));
            $datet = new DateTime($toDate);
            $timet = new DateTime($toTime);
            $bookingTo = new DateTime($datet->format(DATE_FORMAT) . ' ' . $timet->format(TIME_FORMAT), new DateTimeZone($search_zone));
            $bookingTo->setTimezone(new DateTimeZone(UTC));
            $currentDate = new DateTime(date(DATE_TIME));
            $currentDate->setTimezone(new DateTimeZone(UTC));
            $data['bookingDate'] = $currentDate->format(DATE_FORMAT);
            $data[FROM_DATE] = $bookingFrom->format(DATE_TIME);
            $data[TO_DATE] = $bookingTo->format(DATE_TIME);
            $data[FROM_TIME] = $timeFrom;
            $data[TO_TIME] = $timeTo;
            $data['bookingType'] = $bookingType;
            $data['price'] = $price;
            $data['totalPrice'] = ($totalPrice / 100) - $fee;
            $data['processFee'] = $fee;
            $data['bookingStatus'] = 1;
            $data['user_IP'] = $this->get_ip_address();
            $data[CHARGEID] = $chargeInfo[CHARGEID];
            $tmpbook = $_SESSION['temp_search'];
            $data['bookingID'] = $tmpbook['temp_booking_id'];
            $this->Bookingmodel->bookDrivewayUpdate($data);
            if ($bookingType == 2) {
                $datef = new DateTime($this->input->post(FROM_DATE, TRUE));
                $timef = new DateTime($this->input->post(FROM_TIME, TRUE));
                $datet = new DateTime($this->input->post(TO_DATE, TRUE));
                $timet = new DateTime($this->input->post(TO_TIME, TRUE));
                $datefrom = new DateTime($datef->format(DATE_FORMAT) . ' ' . $timef->format(TIME_FORMAT), new DateTimeZone($search_zone));
                $datefrom->setTimezone(new DateTimeZone(UTC));
                $bookingFromOnly = $datefrom->format(DATE_FORMAT);
                $bookingFromTimeOnly = $datefrom->format(TIME_FORMAT);
                $dateto = new DateTime($datet->format(DATE_FORMAT) . ' ' . $timet->format(TIME_FORMAT), new DateTimeZone($search_zone));
                $dateto->setTimezone(new DateTimeZone(UTC));
                $bookingToOnly = $dateto->format(DATE_FORMAT);
                $bookingToTimeOnly = $dateto->format(TIME_FORMAT);
                $this->Bookingmodel->updatedLockedBooking($tmpbook['temp_booking_id']);
                $bookArray = $this->createDateRangeArray($bookingFromOnly, $bookingToOnly);
                foreach ($bookArray as $bookDate) {
                    if (strtotime($bookingFromTimeOnly) < strtotime($bookingToTimeOnly)) {
                        $start_date_and_time = $bookDate . ' ' . $bookingFromTimeOnly;
                        $end_date_and_time = $bookDate . " " . $bookingToTimeOnly;
                        $book_d['start_date'] = $start_date_and_time;
                        $book_d['end_date'] = $end_date_and_time;
                        $book_d['booking_id'] = $tmpbook['temp_booking_id'];
                        $this->Bookingmodel->bookDrivewayDates($book_d);
                    }
                    //If search from time > to time Ex: 16:00 PM to 10:00 AM //from
                    else {
                        $start_date_and_time = $bookDate . ' ' . $bookingFromTimeOnly;
                        $todate = date(DATE_FORMAT, strtotime($bookDate));
                        $stop_date = date(DATE_FORMAT, strtotime($todate . ' +1 day'));
                        $end_date_and_time = $stop_date . " " . $bookingToTimeOnly;
                        if ($stop_date <= $bookingToOnly) {
                            $book_d['start_date'] = $start_date_and_time;
                            $book_d['end_date'] = $end_date_and_time;
                            $book_d['booking_id'] = $tmpbook['temp_booking_id'];
                            $this->Bookingmodel->bookDrivewayDates($book_d);
                        }
                    }
                }
            }
            if ($userDetail['role'] == 2) {
                $userData['roleID'] = 4;
                $this->load->model('Profile/Profilemodel');
                $this->Profilemodel->updateUserrole($userData, $userDetail [USER_ID]);
            }
            $this->senEmail($drivewayID, $totalPrice, $userID);
            $response = array(
                STATUS => true
            );
            $this->apiResponse($response);
            return true;
        } else {
            $invalidMsg = $chargeInfo [MESSAGE];
            $response = array(
                STATUS => false,
                MESSAGE => $invalidMsg
            );
            $this->apiResponse($response);
            return true;
        }
    }

    /**
     * function to get ip address 
     *
     * @returns ip
     */
    public static function get_ip_address()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    /**
     * To send email to parker and renter
     * 
     * @param integer $drivewayID drivewayID
     * @param integer $totalPrice total price
     * @param integer $userID user ID of parker
     * 
     * On success sends email to parker and renter
     *     
     */
    function senEmail($drivewayID, $totalPrice, $userID)
    {
        $fromDate = $this->input->post(FROM_DATE, TRUE);
        $toDate = $this->input->post(TO_DATE, TRUE);
        $fromTime = $this->input->post(FROM_TIME, TRUE);
        $toTime = $this->input->post(TO_TIME, TRUE);
        $fdate = new DateTime($fromTime);
        $tdate = new DateTime($toTime);
        $timeFrom = $fdate->format(TIME_FORMAT);
        $timeTo = $tdate->format(TIME_FORMAT);
        $user = $this->Bookingmodel->getUserEmail($userID);
        $driveway = $this->Bookingmodel->getdrivewayInfo($drivewayID);
        $owner = $this->Bookingmodel->getUserEmail($driveway->userID);
        $useremail = $user->emailID;
        $message = '
                        <html>
                            <head>
                                <title>Booked driveway</title>
                            </head>
                            <body>
                            <img src="' . base_url('assets/images/logo.png') . '" border="0"><br>
                            <h2>Thanks for booking a driveway!</h2>
                            <h4>Driveway Address:</h4>
                                ' . $driveway->building . '
                                <br>
                                ' . $driveway->route . '
                                <br>
                                ' . $driveway->streetAddress . ' ,  ' . $driveway->city . '
                                <br>
                                ' . $driveway->state . '   -  ' . $driveway->zip . '
                                   
                                <br><br>
                            <h4>You can proceed to your driveway at ' . $fromTime . ' <br>
                            <h4>Here is more information on your transaction:</h4>
                            <h4>Renter Name:</h4>
                                ' . $owner->firstName . ' &nbsp; ' . $owner->lastName . '
                                <br>
                                <h4>Address:</h4>
                                ' . $owner->building . '
                                <br>
                                ' . $owner->streetAddress . ' ,  ' . $owner->city . '
                                <br>
                                ' . $owner->state . '   -  ' . $owner->zip . '
                                <h4>Contact info:</h4>
                                ' . $owner->phone . '
                                <br><br>
                                <h3>Dates & time:</h3>
                                From Date/Time:  ' . $fromDate . ' / ' . $timeFrom . '<br>
                                To Date/Time:  ' . $toDate . ' / ' . $timeTo . '<br>
                                <h4>Price of booking:</h4>
                                ' . $totalPrice / 100 . '<br><br/>
                                <p>If something looks wrong, please contact us. You will receive an email 10 minutes before your booking time. Please let us know when you have arrived. <p>
                                <p>We hope you have a great experience with LouiePark!</p><br/>
                                Thanks<br>LouiePark
                            </body>
                        </html>';

        $message1 = '<html>
                            <head>
                                <title>Booked driveway</title>
                            </head>
                            <body>
                            <img src="' . base_url('assets/images/logo.png') . '" border="0"><br>
                            <h2>Your driveway has been booked!</h2>
                            <h4>Driveway Address:</h4>                            
                                ' . $driveway->building . '
                                <br>
                                ' . $driveway->route . '
                                <br>
                                ' . $driveway->streetAddress . ' ,  ' . $driveway->city . '
                                <br>
                                ' . $driveway->state . '   -  ' . $driveway->zip . '
                                   
                                <br><br>
                            <h4>' . $user->firstName . ' &nbsp;' . $user->lastName . '  has booked your spot. They will be arriving at ' . $timeFrom . ' and leaving at ' . $timeTo . '.  If you would like to cancel their booking, please press below: <br>
                           
                            <h3><a href="' . base_url('dashboard') . '">Cancel Booking</a></h3>
                            <h4>Here is more information on your transaction:</h4>
                            <h3>Name:</h3>    
                                ' . $user->firstName . ' &nbsp;' . $user->lastName . '
                                <br>
                                <h4>Dates & time of stay:</h4>
                                From Date/Time:  ' . $fromDate . ' / ' . $timeFrom . '<br>
                                To Date/Time:  ' . $toDate . ' / ' . $timeTo . '<br>
                                <br>
                                <h4>Price they paid:</h4>
                                ' . $totalPrice / 100 . '<br>
                                
                                <h4>Contact info:</h4>
                                ' . $user->phone . '
                                <br><br>
                                
                                <p>If you have any problems with this user, please let us know. We hope your renting is easy and painless!<p><br/>
                                Thanks<br>LouiePark
                            </body>
                        </html>';
        // Send welcome email            
        $owneremail = $owner->emailID;
        $constants = $this->Bookingmodel->getConstants();
        $this->load->library(EMAIL);
        $this->email->from($constants->fromEmail);
        $this->email->to($useremail);
        $this->email->subject('Driveway Booked');
        $this->email->message($message);
        if (!$this->email->send()) {
            $emailInfo['emailStatus'] = 0;
            $emailInfo['toEmail'] = $useremail;
            $emailInfo['fromEmail'] = $constants->fromEmail;
            $emailInfo['content'] = $message;
            $emailInfo['subject'] = 'Driveway Booked';
            $this->load->model('profile/Profilemodel');
            $this->Profilemodel->saveEmailStatus($emailInfo);
        }

        $this->load->library(EMAIL);
        $this->email->from($constants->fromEmail);
        $this->email->to($owneremail);
        $this->email->subject('Driveway Booked');
        $this->email->message($message1);
        if (!$this->email->send()) {
            $emailInfo['emailStatus'] = 0;
            $emailInfo['toEmail'] = $owneremail;
            $emailInfo['fromEmail'] = $constants->fromEmail;
            $emailInfo['content'] = $message1;
            $emailInfo['subject'] = 'Driveway Booked';
            $this->load->model('profile/Profilemodel');
            $this->Profilemodel->saveEmailStatus($emailInfo);
        }
    }

    /**
     * To sabe card info for future in profile
     *
     * @returns response in json format
     */
    public function saveCardInfo()
    {
        
        if (!$this->checkLogin($this->module)) {
            $response = array(
                STATUS => false,
                MESSAGE => 'session'
            );
            $this->apiResponse($response);
            return true;
        }
       // $this->load->library('encrypt');
        $userDetail = $this->session->userdata('logged_in');
        $userID = $userDetail [USER_ID];
        $user = $this->Bookingmodel->getUserEmail($userID);
        $useremail = $user->emailID;
        
       // $useremailnew =  $this->encrypt->encode($useremail);
           $useremailnew = $this->my_encrypt($useremail, ENCRYPTION_KEY_256BIT);
        $tokenInfo = $this->getToken($useremailnew);
        if ($tokenInfo [MESSAGE] != SUCCESS) {
            $invalidMsg = $tokenInfo [MESSAGE];
            $response = array(
                STATUS => false,
                MESSAGE => $invalidMsg
            );
            $this->apiResponse($response);
            return true;
        } else {
            $customerId = $tokenInfo [CUSTOMERID];
            $expirationdate = $this->input->post(EXPIRATION_DATE, TRUE);
            $expiration_month = substr($expirationdate, 0, 2);
            $expiration_year = substr($expirationdate, 3);
            $name_on_card = $this->input->post(NAMEON_CARD, TRUE);
            $billing_phone = $this->input->post('billing_phone', TRUE);
            $billing_street = $this->input->post(BILLING_STREET, TRUE);
            $billing_city = $this->input->post(BILLING_CITY, TRUE);
            $billing_state = $this->input->post(BILLING_STATE, TRUE);
            $billing_zip = $this->input->post(BILLING_ZIP, TRUE);
            $data_b['expiration_month'] = $expiration_month;
            $data_b['expiration_year'] = $expiration_year;
            $data_b['name_on_card'] = $name_on_card;
            $data_b[USERID] = $userID;
            $data_b['phone'] = $billing_phone;
            $data_b['streetAddress'] = $billing_street;
            $data_b['city'] = $billing_city;
            $data_b['state'] = $billing_state;
            $data_b['zip'] = $billing_zip;
            //$data_b['customer_id'] = $this->encrypt->encode($customerId);
              $data_b['customer_id']  = $this->my_encrypt($customerId, ENCRYPTION_KEY_256BIT);
            $data_b[STATUS] = 1;
            $this->Bookingmodel->saveBillingToken($data_b);
            $response = array(
                STATUS => true,
                MESSAGE => SUCCESS
            );
            $this->apiResponse($response);
            return true;
        }
    }

    /**
     *
     * To get the token generated from Stripe
     *
     * Retrieves the billing information and validates
     * 
     * @param string  $useremail email ID of parker
     * 
     * @returns response in json format
     *
     */
    public function getToken($useremail)
    {
        //$this->load->library('encrypt');
        
       // $useremail = $this->encrypt->decode($useremail);    
         $useremail = $this->my_decrypt($useremail, ENCRYPTION_KEY_256BIT);
        require_once (APPPATH . STRIPE_PATH);
        require_once (APPPATH . STRIPE_LIB_PATH);
        Stripe\Stripe::setApiKey(STRIPE_KEY);
        $expirationdate = $this->input->post(EXPIRATION_DATE, TRUE);
        $expiration_month = substr($expirationdate, 0, 2);
        $expiration_year = substr($expirationdate, 3);
        try {
            $res = \Stripe\Token::create(array(
                        "card" => array(
                            "name" => $this->input->post(NAMEON_CARD),
                            "number" => $this->input->post('card_number'),
                            "exp_month" => $expiration_month,
                            "exp_year" => $expiration_year,
                            "cvc" => $this->input->post('security_code'),
                            "address_line1" => $this->input->post('billing_address'),
                            "address_line2" => $this->input->post(BILLING_STREET),
                            "address_city" => $this->input->post(BILLING_CITY),
                            "address_state" => $this->input->post(BILLING_STATE),
                            "address_zip" => $this->input->post(BILLING_ZIP)
                        )
            ));
            $customer = \Stripe\Customer::create(array(
                        'card' => $res['id'],
                        'description' => 'Driveway Booking',
                        EMAIL => $useremail
                            )
            );
            return array(
                MESSAGE => SUCCESS,
                CUSTOMERID => $customer['id']
            );
        } catch (\Stripe\Error\Stripe_InvalidRequestError $e) {
            $body = $e->getJsonBody();
            $err = $body [ERROR];
            return array(
                MESSAGE => $err [MESSAGE],
                TOKEN => ''
            );
        } catch (Stripe\Error\Card $e) {
            $body = $e->getJsonBody();
            $err = $body [ERROR];
            return array(
                MESSAGE => $err [MESSAGE],
                TOKEN => ''
            );
        } catch (\Stripe\Error\ApiConnection $e) {
            return array(
                MESSAGE => 'Network communication with Payment Gateway failed',
                TOKEN => ''
            );
        }
    }

    /**
     *
     * To process the billing information
     *
     * Retrieves the billing information and validates
     * 
     * @param integer $customerId customer ID in decrypted format
     * @param integer $key key generated while creating stripe account
     * @param integer $stripeAcc stripe account number
     * @param integer $amount amount to be transfered
     *
     * @returns response in json format
     *
     */
    public function chargeStripe($customerId, $key, $stripeAcc, $amount)
    {
       // $this->load->library('encrypt');
       // $key = $this->encrypt->decode($key);
        $key = $this->my_decrypt($key, ENCRYPTION_KEY_256BIT);
        
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        require_once (APPPATH . STRIPE_PATH);
        require_once (APPPATH . STRIPE_LIB_PATH);
        Stripe\Stripe::setApiKey($key);
        $token = \Stripe\Token::create(
                        array("customer" => $customerId), array("stripe_account" => $stripeAcc)
                        // id of the connected account
        );
        try {
            $charge = \Stripe\Charge::create(array(
                        "amount" => $amount,
                        "currency" => "usd",
                        "source" => $token['id'],
                        "description" => "Driveway charge",
                        "application_fee" => $constants->applicationFees
                            )
                            , array(
                        "stripe_account" => $stripeAcc
            ));
            $chargeId = $charge['id'];
            return array(
                MESSAGE => $charge[STATUS],
                CHARGEID => $chargeId,
                TOKEN => ''
            );
        } catch (\Stripe\Error\Stripe_InvalidRequestError $e) {
            $body = $e->getJsonBody();
            $err = $body [ERROR];
            return array(
                MESSAGE => $err [MESSAGE],
                TOKEN => ''
            );
        } catch (\Stripe\Error\Stripe_Erro $e) {
            $body = $e->getJsonBody();
            $err = $body [ERROR];
            return array(
                MESSAGE => $err [MESSAGE],
                TOKEN => ''
            );
        } catch (\Stripe\Error\ApiConnection $e) {
            return array(
                MESSAGE => 'Network communication with Payment Gateway failed',
                TOKEN => ''
            );
        }
    }

    /**
     *
     * takes two dates formatted as YYYY-MM-DD and creates an
     *
     * inclusive array of the dates between the from and to dates.
     * 
     * @param datetme $strDateFrom booking start date
     * @param datetime $strDateTo booking end date     
     *
     * @returns $aryRange array containing dates
     *
     */
    function createDateRangeArray($strDateFrom, $strDateTo)
    {
        $aryRange = array();
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date(DATE_FORMAT, $iDateFrom));
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400;
                array_push($aryRange, date(DATE_FORMAT, $iDateFrom));
            }
        }
        return $aryRange;
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
    public function get_nearest_timezone($cur_lat, $cur_long, $country_code = '')
    {
        $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code) : DateTimeZone::listIdentifiers();
        if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {
            $time_zone = '';
            $tz_distance = 0;
            //only one identifier
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
        return 'none';
    }

    /**
     * To get the booking status
     *
     * @returns response in json format 
     *    
     */
    public function bookingStatus()
    {
        $bookingFromTime = $this->input->post('today');
        $bookingEndTime = $this->input->post('endNow');
        $currentTime = strtotime(date('H:i'));
        $minutes = ($bookingFromTime - $currentTime) / 60;
        if (isset($bookingEndTime)) {
            $minutes_end = ( $currentTime - $bookingEndTime) / 60;
            if ($minutes < 0) {
                $this->apiResponse(array(
                    STATUS => true,
                    "minutes" => $minutes_end
                        )
                );
                return true;
            }
        } else {
            $this->apiResponse(array(
                STATUS => false,
                "minutes" => $minutes
                    )
            );
            return true;
        }
    }

}
