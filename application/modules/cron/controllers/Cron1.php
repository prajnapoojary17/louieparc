<?php

/**
 *
 * File Name : Cron Controller
 *
 * Description : Used to handle sending of reminders to users
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

class Cron extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
        $this->load->model('Cronmodel');
        $this->load->model('booking/Bookingmodel');
    }

    /**
     *
     * To send reminder to parker before 30 minutes of parking
     *
     * sends email to parker
     *     
     */
    public function reminder()
    {
        $bookings = $this->Cronmodel->reminderInfo();
        $bookingsEnds = $this->Cronmodel->reminderInfoEnd();
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        $logo = '<img src="' . 'http://' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . str_replace('index.php', '', $_SERVER ['SCRIPT_NAME']) . '/assets/images/logo.png" border="0">';
        if (!empty($bookings)) {
            foreach ($bookings as $booking) {
                $user = $this->Bookingmodel->getUserEmail($booking->userID);
                $owner = $this->Bookingmodel->getUserEmail($booking->ownerID);
                $search_zone = $this->get_nearest_timezone($booking->latitude, $booking->longitude);
                $fromdateget = new DateTime($booking->fromDate, new DateTimeZone(UTC));
                $todateget = new DateTime($booking->toDate, new DateTimeZone(UTC));
                $newTZ = new DateTimeZone($search_zone);
                $fromdateget->setTimezone($newTZ);
                $bookingFrom = $fromdateget->format(TIME_FORMAT_AM_PM);
                $todateget->setTimezone($newTZ);
                $bookingTo = $todateget->format(TIME_FORMAT_AM_PM);
                $slug = md5($user->userID . $user->emailID);
                $message = '<html>
                        <head><title>Reminder driveway</title></head>
                        <body>' . $logo . '<br>
                            <p><b>It’s about time for your rental to begin!</b></p>
                            <p>Parking starts at: ' . $fromdateget->format(H_I_S_A) . '</p>
                             <b>To confirm your booking please click the link below:</b><br><br>
                            **<a href="' . 'http://' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . str_replace('index.php', '', $_SERVER ['SCRIPT_NAME']) . 'confirm/' . $user->userID . '/'. $booking->bookingID . '/' . $slug . '">' . 'http://' . $_SERVER ['SERVER_NAME'] . ':' . $_SERVER ['SERVER_PORT'] . str_replace('index.php', '', $_SERVER ['SCRIPT_NAME']) . 'confirm/' . $user->userID .'/'. $booking->bookingID . '/' . $slug . '</a>
                             <h4>Dates & time of parking:</h4>
                            From Date/Time:  ' . $bookingFrom . '<br>
                            To Date/Time:  ' . $bookingTo . '<br><br>
                            <p>If there are any problems during your stay, please let us know. Also, we encourage you to review the user after your stay. Thank you for using Louiepark!</p>
                            Thanks<br>Louiepark
                        </body>
                    </html>';
                $message1 = '<html>
                        <head><title>Reminder driveway</title></head>
                        <body>' . $logo . '<br>
                            <p><b>It’s about time for your driveway to be used!</b></p>
                            <h4>' . $user->userName . '  has booked your spot. They will be arriving at ' . $fromdateget->format(H_I_S_A) . ' and leaving at ' . $todateget->format(H_I_S_A) . '. <br>
                            <h4>Here is more information on your transaction:</h4>
                            <h3>Username:</h3>
                            ' . $user->userName . '<br>
                            <h4>Dates & time of stay:</h4>
                            From Date/Time:  ' . $bookingFrom . '<br>
                            To Date/Time:  ' . $bookingTo . '<br><br>
                            <h4>Contact info:</h4>
                            ' . $user->phone . '<br><br> 
                            <p>If you have any problems with this user, please let us know. We hope your renting is easy and painless! Thank you.<p>
                            Thanks<br>Louiepark
                        </body>
                    </html>';
                $useremail = $user->emailID;
                $owneremail = $owner->emailID;
                $this->email->from($constants->fromEmail);
                $this->email->to($useremail);
                $this->email->subject(BEGIN_REMINDER_SUBJECT);
                $this->email->message($message);
                if (!$this->email->send()) {
                $emailInfo['emailStatus'] = 0;
                $emailInfo['toEmail'] = $useremail;
                $emailInfo['fromEmail'] = $constants->fromEmail;
                $emailInfo['content'] = $message;
                $emailInfo['subject'] = BEGIN_REMINDER_SUBJECT;
                $this->load->model('profile/Profilemodel');
                $this->Profilemodel->saveEmailStatus($emailInfo);
                }
                $this->email->from($constants->fromEmail);
                $this->email->to($owneremail);
                $this->email->subject(BEGIN_REMINDER_SUBJECT);
                $this->email->message($message1);
                if (!$this->email->send()) {
                $emailInfo['emailStatus'] = 0;
                $emailInfo['toEmail'] = $owneremail;
                $emailInfo['fromEmail'] = $constants->fromEmail;
                $emailInfo['content'] = $message1;
                $emailInfo['subject'] = BEGIN_REMINDER_SUBJECT;
                $this->load->model('profile/Profilemodel');
                $this->Profilemodel->saveEmailStatus($emailInfo);
                }
                if($booking->bookingType==2)
				{				
					$this->Cronmodel->updateEmaiStatusForRecurring($booking->booking_date_id);
				}
				else
				{
					$this->Cronmodel->updateEmaiStatus($booking->bookingID);
				}
                $response = array(
                    "status" => true,
                    "parker" => $useremail,
                    "renter" => $owneremail
                );
                $this->apiResponse($response);
            }
        }
        if (!empty($bookingsEnds)) {
            print_r($bookingsEnds); exit;
            foreach ($bookingsEnds as $bookingsEnd) {
                $user = $this->Bookingmodel->getUserEmail($bookingsEnd->userID);
                $owner = $this->Bookingmodel->getUserEmail($bookingsEnd->ownerID);
                echo 'End Time - 30 min' . $bookingsEnd->alertEndTime;
                $search_zone = $this->get_nearest_timezone($bookingsEnd->latitude, $bookingsEnd->longitude);
                $fromdateget = new DateTime($bookingsEnd->fromDate, new DateTimeZone(UTC));
                $todateget = new DateTime($bookingsEnd->toDate, new DateTimeZone(UTC));
                $newTZ = new DateTimeZone($search_zone);
                $fromdateget->setTimezone($newTZ);
                $bookingFrom = $fromdateget->format(TIME_FORMAT_AM_PM);
                $todateget->setTimezone($newTZ);
                $bookingTo = $todateget->format(TIME_FORMAT_AM_PM);
                $slug = md5($user->userID . $user->emailID . date('dmY'));
                $message = '<html><head><title>Reminder driveway</title></head>
                            <body>' . $logo . '<br>
                                <p><b>Your time is almost up!</b></p>
                                    <p><b>You have one hour left before your booking time ends. If you believe you may be late, we encourage you to contact the owner of the spot.</b></p>
                                <p><b>Contact information: </b><br/>
                            ' . $owner->building . '<br>
                            ' . $owner->streetAddress . ' ,  ' . $owner->city . '<br>
                            ' . $owner->state . '   -  ' . $owner->zip . ' <br>
                            <h4>Phone Number:</h4>
                            ' . $owner->phone . '
                            <br><br> </p>
                                <p>Make your way back to your car soon. After your stay, please write an honest review on your experience in the spot! This helps our other users who are looking for parking.</p>
                               <p>We hope you enjoyed using LouiePark!</p><br/><br>
                                Thanks<br>LouiePark
                            </body>
                        </html>';

                $useremail = $user->emailID;
                $owneremail = $owner->emailID;
                $this->email->from($constants->fromEmail);
                $this->email->to($useremail);
                $this->email->subject(RELEASE_REMINDER_SUBJECT);
                $this->email->message($message);
                if (!$this->email->send()) {
                $emailInfo['emailStatus'] = 0;
                $emailInfo['toEmail'] = $useremail;
                $emailInfo['fromEmail'] = $constants->fromEmail;
                $emailInfo['content'] = $message;
                $emailInfo['subject'] = RELEASE_REMINDER_SUBJECT;
                $this->load->model('profile/Profilemodel');
                $this->Profilemodel->saveEmailStatus($emailInfo);
                } else {
                echo 'Email Sent to : ' . $useremail . ',' . $owneremail;            
                }
                if($bookingsEnd->bookingType==2)
				{				
					$this->Cronmodel->updateEndEmailStatusForRecurring($bookingsEnd->booking_date_id);
				}
				else
				{
					$this->Cronmodel->updateEndEmailStatus($bookingsEnd->bookingID);
				}
                $response = array(
                    "status" => true,
                    "parker" => $useremail,
                    "renter" => $owneremail
                );
                $this->apiResponse($response);
            }
        }
    }

    /**
     *
     * To send reminder to parker before 30 minutes of parking
     *
     * sends email to parker
     *     
     */
    public function pending()
    {
        $emails = $this->Cronmodel->pendingInfo();
        if (!empty($emails)) {
            foreach ($emails as $email) {
                $this->email->from($email->fromEmail);
                $this->email->to($email->toEmail);
                $this->email->subject($email->subject);
                $this->email->message($email->content);
                if ($this->email->send()) {
                    $status = 1;
                    $this->Cronmodel->sentEmailStatus($email->emailID, $status);
                } else {
                    $status = 0;
                    $this->Cronmodel->sentEmailStatus($email->emailID, $status);
                }
            }
        }
    }

    /**
     *
     * To get the nearest time zone of a location     
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
        return 'none';
    }

}
