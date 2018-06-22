<?php

/**
 * File Name : Driveway controller
 * 
 * Description : Controller for Driveway
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

class Driveway extends MY_Controller
{

    var $fromDateDrv;

    function __construct()
    {
        $this->module = "driveway";
        $this->load->model('drivewaymodel');
        parent::__construct();
    }

    /**
     * To show Home page to find driveway
     */
    public function index()
    {
        if (isset($_POST[DRIVEWAYID])) {
            $drivewayId = $_POST[DRIVEWAYID];
            $sess_array = array(
                DRIVEWAYID => $drivewayId
            );
            $this->session->set_userdata('rentagain', $sess_array);
            $data['searchlocation'] = $this->drivewaymodel->getOwnerDriveway($drivewayId);
            $data['locations'] = $this->drivewaymodel->getDriveways();
            $this->_tpl('Home', $data);
        } else {
            $data['locations'] = $this->drivewaymodel->getDriveways();
            $this->_tpl('Home', $data);
        }
    }

    /**
     * To get all driveways
     *
     */
    public function searchDriveway()
    {
        $rangeprice = $this->input->post('rangeprice', TRUE);
        // 1 - continuous / 2 - recurring
        $type = $this->input->post('option', TRUE);
        if ($rangeprice == 1) {
            $minprice = 0;
            $maxprice = 10;
        } else if ($rangeprice == 2) {
            $minprice = 11;
            $maxprice = 20;
        } else if ($rangeprice == 3) {
            $minprice = 21;
            $maxprice = 150;
        } else if ($rangeprice == '') {
            $minprice = 0;
            $maxprice = 150;
        }
        $centerlat = $this->input->post('centerlat', TRUE);
        $centerlong = $this->input->post('centerlong', TRUE);
        $search_zone = $this->get_nearest_timezone($centerlat, $centerlong);
        $this->session->set_userdata('search_zone', $search_zone);
        $userInfo = $this->session->userdata('logged_in');
        $userId = $userInfo ['user_id'];
        //search location time
        date_default_timezone_set($search_zone);
        $frmdate = $this->input->post('fromdate', TRUE);
        $fromdate = date("Y-m-d", strtotime($frmdate));
        $datef = new DateTime($this->input->post('fromdate', TRUE));
        $datet = new DateTime($this->input->post('todate', TRUE));
        $timef = new DateTime($this->input->post('fromtime', TRUE));
        $timet = new DateTime($this->input->post('totime', TRUE));
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        $drivewaysdisplay = array();
        $drivewayArray = array();
        $slot = array();
        $dPrice = "";
        $drivewayPrice = "";
        if ($type == 3) {
            $dPrice = 'ddailyPrice';
            $drivewayPrice = 'dailyprice';
        } else {
            $dPrice = 'dPrice';
            $drivewayPrice = 'price';
        }
        $sql = "SELECT DISTINCT b.drivewayID,userID,slot ,b.building,b.route,b.streetAddress,b.city,b.state,b.zip,b.latitude,b.longitude,b.price,b.dailyprice,Max(" . $dPrice . ") AS dPrice,bb.fromDate AS froma ,
        (
        6371 *
        acos(
        cos( radians( " . $centerlat . " ) ) *
        cos( radians( latitude ) ) *
        cos(
        radians( longitude ) - radians(  " . $centerlong . " )
        ) +
        sin(radians(" . $centerlat . ")) *
        sin(radians(latitude))
        )
        ) distance
        FROM
        tbl_driveway b
        LEFT JOIN tbl_driveway_views_update AS bb 
             ON b.drivewayID =bb.drivewayID AND bb.fromdate=  '" . $fromdate . "'
        WHERE drivewayStatus = 1 
        GROUP BY b.drivewayid
        HAVING
        distance < " . $constants->drivewayDistance . " and ((dPrice BETWEEN '" . $minprice . "' AND '" . $maxprice . "' ) OR ((b." . $drivewayPrice . " BETWEEN '" . $minprice . "' AND '" . $maxprice . "' ) AND ISNULL(dPrice)=1))
        ORDER BY distance
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach ($results as $result) {
                $drivewayArray[$result['drivewayID']] = $result;
                $slot[$result['drivewayID']] = $result['slot'];
                $drvInfo = $this->drivewaymodel->getDrivewayZone($result['drivewayID']);
                $drivewayTZ = new DateTimeZone($drvInfo->timeZone);
                $fromdateget = new DateTime($datef->format(DATE_FORMAT) . ' ' . $timef->format(TIME_FORMAT));
                $fromdateget->setTimezone($drivewayTZ);
                $todateget = new DateTime($datet->format(DATE_FORMAT) . ' ' . $timet->format(TIME_FORMAT));
                $todateget->setTimezone($drivewayTZ);
                $fromdatevalue = $fromdateget->format(DATE_TIME);
                $todatevalue = $todateget->format(DATE_TIME);
                $dateArrayrange = $this->createDateRangeArray($fromdatevalue, $todatevalue);
                $driveways = array();
                $sqldate = "Select * from tbl_driveway_date_settings where status=1 and driveway_id=" . $result['drivewayID'];
                $sqldate_query = $this->db->query($sqldate);
                if ($sqldate_query->num_rows() > 0) {
                    $sqldatebn = "Select * from tbl_driveway_date_settings where status=1 and driveway_id=" . $result['drivewayID'] . " and start_date<='$fromdatevalue' and end_date>='$todatevalue'";
                    $sqldatebn_query = $this->db->query($sqldatebn);
                    if ($sqldatebn_query->num_rows() == 0) {
                        continue;
                    }
                }
                $sqlday = "Select * from tbl_driveway_day_settings where status=1 and driveway_id=" . $result['drivewayID'];
                $sqlday_query = $this->db->query($sqlday);
                if ($sqlday_query->num_rows() > 0) {
                    for ($i = 0; $i < count($dateArrayrange); $i++) {
                        $drivewayid = $this->searchDrivewayDaySettings($result['drivewayID'], $dateArrayrange[$i], $fromdateget, $todateget, $type);
                        if ($drivewayid > 0) {
                            $driveways[] = $drivewayid;
                        }
                    }
                } else {
                    $drivewaysdisplay[] = $result['drivewayID'];
                }

                if (count($driveways) > 0 && (count($dateArrayrange) == count($driveways))) {
                    array_push($drivewaysdisplay, $result['drivewayID']);
                }
            }
        }
        $this->drivewayBookingFilter($search_zone, $drivewaysdisplay, $type, $userId, $slot, $drivewayArray);
    }

    /**
     * Convert Search From and To date to UTC
     *
     */
    public function drivewayBookingFilter($search_zone, $drivewaysdisplay, $type, $userId, $slot, $drivewayArray)
    {
        $drivewaybooking = array();
        $reindexed_array = array();
        $datef = new DateTime($this->input->post('fromdate', TRUE));
        $timef = new DateTime($this->input->post('fromtime', TRUE));
        $datet = new DateTime($this->input->post('todate', TRUE));
        $timet = new DateTime($this->input->post('totime', TRUE));
        $datefrom = new DateTime($datef->format(DATE_FORMAT) . ' ' . $timef->format(TIME_FORMAT), new DateTimeZone($search_zone));
        $datefrom->setTimezone(new DateTimeZone(UTC));
        $bookingFrom = $datefrom->format(DATE_TIME);
        $bookingFromOnly = $datefrom->format(DATE_FORMAT);
        $bookingFromTimeOnly = $datefrom->format(TIME_FORMAT);
        $dateto = new DateTime($datet->format(DATE_FORMAT) . ' ' . $timet->format(TIME_FORMAT), new DateTimeZone($search_zone));
        $dateto->setTimezone(new DateTimeZone(UTC));
        $bookingTo = $dateto->format(DATE_TIME);
        $bookingToOnly = $dateto->format(DATE_FORMAT);
        $bookingToTimeOnly = $dateto->format(TIME_FORMAT);
        $currentTime = new DateTime(date("Y-m-d H:i:s"));
        $currentTime->setTimezone(new DateTimeZone(UTC));
        $nowTime = $currentTime->format(DATE_TIME);
        $daterangesearch = $this->createDateRangeArray($bookingFromOnly, $bookingToOnly);
        $bookingtype = array();
        $hourcharge = array();
        //calculate hourly charge
        $charge = $this->calculateCharge($type, $bookingTo, $bookingFrom, $bookingToOnly, $bookingFromOnly, $bookingFromTimeOnly, $bookingToTimeOnly);
        if (count($drivewaysdisplay) > 0) {
            for ($a = 0; $a < count($drivewaysdisplay); $a++) {
                $bookingtype[$drivewaysdisplay[$a]] = $type;
                $hourcharge[$drivewaysdisplay[$a]] = $charge;
                $sql = "select * from tbl_booking where drivewayID=" . $drivewaysdisplay[$a];
                $sql .= " and (('$bookingFrom'>=fromdate and '$bookingFrom'<=todate) ";
                $sql .= "or ('$bookingFrom'<=fromdate and '$bookingTo'>=todate)";
                $sql .= " or ('$bookingTo'>=fromdate and '$bookingTo'<=todate)";
                $sql .= " or ('$bookingFrom'<=fromdate and '$bookingTo'<=todate and '$bookingTo'>=fromdate)) AND (bookingStatus=1 or ((UnlockTime > '" . $nowTime . " ' AND bookingStatus=2 ";
                if ($userId > 0) {
                    $sql .= " AND userID NOT IN ('" . $userId . "')";
                }
                $sql .= "  ) ) )";
                $sql_query = $this->db->query($sql);
                if ($sql_query->num_rows() > 0) {
                    $drivewaycountforslot = array();
                    $resultfinal = $sql_query->result_array();
                    foreach ($resultfinal as $row) {
                        $booking_id = $row["bookingID"];
                        if ($type == "1" || $type == "3") {
                            $drivewaybooking[] = $drivewaysdisplay[$a];
                            $drivewaycountforslot[] = $drivewaysdisplay[$a];
                        }
                        //for recurring
                        else {
                            if ($row["bookingType"] == "1" || $row["bookingType"] == "3") {
                                $drivewaybooking[] = $row["drivewayID"];
                                $drivewaycountforslot[] = $row["drivewayID"];
                            } else {
                                //If search from time < to time Ex: 10:00 to 16:00
                                if (strtotime($bookingFromTimeOnly) < strtotime($bookingToTimeOnly)) {
                                    $bookingexists = 0;
                                    for ($m = 0; $m < count($daterangesearch); $m++) {
                                        $startdatetime = $daterangesearch[$m] . " " . $bookingFromTimeOnly;
                                        $enddatetime = $daterangesearch[$m] . " " . $bookingToTimeOnly;
                                        $bookingexists = $this->isBookingDateExists($booking_id, $startdatetime, $enddatetime);
                                    }
                                    if ($bookingexists) {
                                        $drivewaycountforslot[] = $row["drivewayID"];
                                        $drivewaybooking[] = $row["drivewayID"];
                                    }
                                }
                                //If search from time > to time Ex: 16:00 PM to 10:00 AM //from
                                else {
                                    $bookingexists = 0;
                                    for ($m = 0; $m < count($daterangesearch); $m++) {
                                        $startdatetime = $daterangesearch[$m] . " " . $bookingFromTimeOnly;
                                        $todate = date(DATE_FORMAT, strtotime($daterangesearch[$m]));
                                        $stop_date = date(DATE_FORMAT, strtotime($todate . ' +1 day'));
                                        $enddatetime = $stop_date . " " . $bookingToTimeOnly;
                                        if ($stop_date <= $bookingToOnly) {
                                            $bookingexists = $this->isBookingDateExists($booking_id, $startdatetime, $enddatetime);
                                        }
                                    }
                                    if ($bookingexists) {
                                        $drivewaycountforslot[] = $row["drivewayID"];
                                        $drivewaybooking[] = $row["drivewayID"];
                                    }
                                }
                            }
                        }
                    }
                    //based on slot slot calculation
                    $drivewaybooking = array_unique($drivewaybooking);
                    if (count($drivewaycountforslot) < $slot[$drivewaysdisplay[$a]] && ($key = array_search($drivewaysdisplay[$a], $drivewaybooking)) !== false) {
                        unset($drivewaybooking[$key]);
                    }
                }
            }
            $finaldriveways = array_diff($drivewaysdisplay, $drivewaybooking);
            $reindexed_array = array_values(array_unique($finaldriveways));
        }
        $this->finalSearchResult($drivewayArray, $reindexed_array, $hourcharge, $bookingtype);
    }

    /**
     * to get the final list of driveways available for booking
     *
     */
    public function finalSearchResult($drivewayArray, $reindexed_array, $hourcharge, $bookingtype)
    {
        $availableDriveways = array();
        foreach ($drivewayArray as $val) {
            if (in_array($val['drivewayID'], $reindexed_array)) {
                array_push($availableDriveways, $val);
            }
        }
        if ($availableDriveways) {
            echo json_encode(array('data' => $availableDriveways, 'hours' => $hourcharge, 'searchtype' => $bookingtype, 'status' => 1));
        } else {
            echo json_encode(array('data' => $availableDriveways, 'hours' => $hourcharge, 'searchtype' => $bookingtype, 'status' => 0));
        }
    }

    /**
     * To show driveway based on filter
     * 
     * @returns response in json format
     */
    public function showdriveway()
    {
        $data = $this->input->post('id', TRUE);
        $fromDate = $this->input->post(FROM_DATE, TRUE);
        $toDate = $this->input->post(TO_DATE, TRUE);
        $fromTime = $this->input->post(FROM_TIME, TRUE);
        $toTime = $this->input->post(TO_TIME, TRUE);
        $searchtype = $this->input->post(SEARCH_TYPE, TRUE);
        $user_lat = $this->input->post('search_lat', TRUE);
        $user_long = $this->input->post('search_long', TRUE);
        $drivewayInfo[DRIVEWAYID] = $data;
        $drivewayInfo[FROM_DATE] = date(DATE_FORMAT, strtotime($fromDate));
        $this->visitcount($drivewayInfo);
        $drivewayData = $this->drivewaymodel->getDriveway($drivewayInfo, $searchtype);
        $reviews = $this->drivewaymodel->getReviews($data);
        $starrating = $this->drivewaymodel->getRatings($data);
        $rating = floor($starrating->rating);
        if ($starrating) {
            $response['ratings'] = $rating;
        } else {
            $response['ratings'] = 0;
        }
        if ($reviews) {
            $response['reviews'] = $reviews;
        } else {
            $response['reviews'] = 0;
        }
        if ($drivewayData) {
            $search_zone = $this->get_nearest_timezone($drivewayData[LATITUDE], $drivewayData[LONGITUDE]);
            $location_zone = $this->get_nearest_timezone($user_lat, $user_long);
            $newTZ = new DateTimeZone($search_zone);
            $bookingFrom = new DateTime($fromDate . ' ' . $fromTime, new DateTimeZone($location_zone));
            $bookingFrom->setTimezone($newTZ);
            $bookingTo = new DateTime($toDate . ' ' . $toTime, new DateTimeZone($location_zone));
            $bookingTo->setTimezone($newTZ);
            $bookingfdatetime = $bookingFrom->format(DATE_TIME);
            $df = new DateTime($bookingfdatetime);
            $bookingFromdate = $df->format(DATE_FORMAT_MDY);
            $Fromtime = $df->format(TIME_FORMAT);
            $bookingFromtime = date("g:i A", strtotime($Fromtime));
            $bookingtdatetime = $bookingTo->format(DATE_TIME);
            $dt = new DateTime($bookingtdatetime);
            $bookingTodate = $dt->format(DATE_FORMAT_MDY);
            $Totime = $dt->format(TIME_FORMAT);
            $bookingTotime = date("g:i A", strtotime($Totime));
            if (isset($drivewayData[DPRICE])) {
                $price = $drivewayData[DPRICE];
            } else if ($searchtype == 3) {
                $price = $drivewayData[DAILYPRICE];
            } else {
                $price = $drivewayData[PRICE];
            }
            $response['driveway'] = array(
                "status" => false,
                "latitude" => $drivewayData[LATITUDE],
                "longitude" => $drivewayData[LONGITUDE],
                "drivewayID" => $drivewayData[DRIVEWAYID],
                "userID" => $drivewayData[USERID],
                PRICE => $price,
                "description" => $drivewayData['description'],
                "instructions" => $drivewayData['instructions'],
                "photo1" => $drivewayData['photo1'],
                "photo2" => $drivewayData['photo2'],
                "photo3" => $drivewayData['photo3'],
                "photo4" => $drivewayData['photo4'],
                "userName" => $drivewayData['userName'],
                "firstname" => $drivewayData['firstName'],
                "lastname" => $drivewayData['lastName'],
                "emailID" => $drivewayData['emailID'],
                "phone" => $drivewayData['phone'],
                "building" => $drivewayData['building'],
                "streetAddress" => $drivewayData['streetAddress'],
                "city" => $drivewayData['city'],
                "state" => $drivewayData['state'],
                "zip" => $drivewayData['zip'],
                "dbuilding" => $drivewayData['dbuilding'],
                "droute" => $drivewayData['droute'],
                "dstreetAddress" => $drivewayData['dstreetAddress'],
                "dcity" => $drivewayData['dcity'],
                "dstate" => $drivewayData['dstate'],
                "dzip" => $drivewayData['dzip'],
                "timeZone" => $search_zone,
                "searchtype" => $searchtype,
                "userzone" => $location_zone
            );
            $response['bookingFromdate'] = $bookingFromdate;
            $response['bookingFromtime'] = $bookingFromtime;
            $response['bookingTodate'] = $bookingTodate;
            $response['bookingTotime'] = $bookingTotime;
            $this->apiResponse($response);
        }
    }

    /**
     * To count driveway visitors for driveway price increment algoritham
     * 
     * @param array $drivewayInfo Array containing driveway info
     * 
     * @returns response in json format
     */
    public function visitcount($drivewayInfo)
    {
        $this->load->model('Drivewaydbmodel');
        if (!isset($_SESSION['visited']) || !in_array($drivewayInfo[DRIVEWAYID], $_SESSION[VISITED_DRIVEWAY])) {
            $_SESSION['visited'] = true;
            $_SESSION[VISITED_DRIVEWAY] = array();
            $drivewayId = $drivewayInfo[DRIVEWAYID];
            $drivVisit[DRIVEWAYID] = $drivewayId;
            $drivVisit[FROM_DATE] = $drivewayInfo[FROM_DATE];
            array_push($_SESSION[VISITED_DRIVEWAY], $drivewayInfo[DRIVEWAYID]);
            $_SESSION['userSessionID'] = rand(10000, 99999);
            $countResults = $this->Drivewaydbmodel->visitCount($drivVisit);
            $countResult = $countResults->totalViews;
            if ($countResults) {
                if ($countResult >= 10 && $countResult <= 100) {
                    $this->load->model('booking/Bookingmodel');
                    $constants = $this->Bookingmodel->getConstants();
                    $addPrice = floor($countResult / 10) * $constants->hourlypriceIncrement;
                    $addPriceforDaily = floor($countResult / 10) * $constants->dailypriceIncrement;
                    $price = $this->Drivewaydbmodel->getPrice($drivewayId);
                    $newPrice = $price[PRICE] + $addPrice;
                    $newdailyprice = $price[DAILYPRICE] + $addPriceforDaily;
                    $drivCount[DRIVEWAYID] = $drivewayId;
                    $drivCount[FROM_DATE] = $drivewayInfo[FROM_DATE];
                    $drivCount['newPrice'] = $newPrice;
                    $drivCount['ddailyPrice'] = $newdailyprice;
                    $this->Drivewaydbmodel->updatedPrice($drivCount);
                    $this->Drivewaydbmodel->deleteCount($drivewayId);
                    return true;
                } else {
                    return true;
                }
            }
        }
    }

    /**
     * To get logged in user info
     * 
     * @returns response in json format  
     * 
     */
    public function getUser()
    {
        if (!$this->checkLogin($this->module)) {
            $response['login'][0] = array(
                STATUS => false
            );
            echo json_encode($response);
            return true;
        } else {
            $search_zone = $_SESSION['search_zone'];
            $datef = new DateTime($this->input->post(FROM_DATE, TRUE));
            $timef = new DateTime($this->input->post(FROM_TIME, TRUE));
            $datet = new DateTime($this->input->post(TO_DATE, TRUE));
            $timet = new DateTime($this->input->post(TO_TIME, TRUE));
            $given_from = new DateTime($datef->format(DATE_FORMAT) . ' ' . $timef->format(TIME_FORMAT), new DateTimeZone($search_zone));
            $given_from->setTimezone(new DateTimeZone(UTC));
            $fromdate = $given_from->format(DATE_TIME);
            $given_to = new DateTime($datet->format(DATE_FORMAT) . ' ' . $timet->format(TIME_FORMAT), new DateTimeZone($search_zone));
            $given_to->setTimezone(new DateTimeZone(UTC));
            $todate = $given_to->format(DATE_TIME);
            $data = $this->session->userdata('logged_in');
            $userId = $data ['user_id'];
            $role = $data ['role'];
            $response = array();
            $this->load->model('booking/Bookingmodel');
            $constants = $this->Bookingmodel->getConstants();
            //add it from settings page //this is for locking the driveway
            $minutes_to_add = $constants->minutesLock;
            $currentTime = new DateTime(date(DATE_TIME));
            $currentTime->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            $currentTime->setTimezone(new DateTimeZone(UTC));
            $unlockTime = $currentTime->format(DATE_TIME);
            $booking['unlockTime'] = $unlockTime;
            $booking[FROM_DATE] = $fromdate;
            $booking['toDate'] = $todate;
            $booking[USERID] = $userId;
            $booking [DRIVEWAYID] = $this->input->post(DRIVEWAYID, TRUE);
            $option = $this->input->post('option', TRUE);
            $booking["bookingType"] = $option;
            $booktempId = $this->drivewaymodel->bookProcess($booking);
            if ($option == 2) {
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
                $bookArray = $this->createDateRangeArray($bookingFromOnly, $bookingToOnly);
                foreach ($bookArray as $bookDate) {
                    if (strtotime($bookingFromTimeOnly) < strtotime($bookingToTimeOnly)) {
                        $start_date_and_time = $bookDate . ' ' . $bookingFromTimeOnly;
                        $end_date_and_time = $bookDate . " " . $bookingToTimeOnly;
                        $book_d['start_date'] = $start_date_and_time;
                        $book_d['end_date'] = $end_date_and_time;
                        $book_d['booking_id'] = $booktempId;
                        $this->drivewaymodel->recbookProcess($book_d);
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
                            $book_d['booking_id'] = $booktempId;
                            $this->drivewaymodel->recbookProcess($book_d);
                        }
                    }
                }
            }
            $sess_array = array(
                'temp_booking_id' => $booktempId,
                FROM_DATE => $fromdate
            );
            // set session values
            $this->session->set_userdata('temp_search', $sess_array);
            $response['login'][0] = array(
                STATUS => true
            );
            $this->load->model('usermanagement/Usermanagementmodel');
            $this->load->model('DrivewayModel');
            $vehicles = $this->DrivewayModel->checkCarExist($userId);
            $cards = $this->DrivewayModel->checkCardExist($userId);
            if (!$vehicles) {
                $response[VEHICLE][0] = array(
                    STATUS => true,
                    VEHICLE => false,
                    USERID => $userId,
                    "role" => $role);
            } else {
                foreach ($vehicles as $i => $vehicle) {
                    $response['vehicle'][$i] = array(
                        STATUS => true,
                        VEHICLE => true,
                        'vehicleType' => $vehicle->vehicleNumber . ' ' . $vehicle->year . ' ' . $vehicle->color,
                        'vehicleID' => $vehicle->vehicleID
                    );
                    $i++;
                }
            }

            if (!$cards) {
                $response[CARDS][0] = array(
                    STATUS => true,
                    CARDS => false,
                    USERID => $userId,
                    "role" => $role
                );
            } else {
                foreach ($cards as $i => $card) {
                    $response[CARDS][$i] = array(
                        STATUS => true,
                        CARDS => true,
                        'name_on_card' => $card->name_on_card . ' - ' . $card->expiration_month . '/' . $card->expiration_year,
                        'billID' => $card->billID
                    );
                    $i++;
                }
            }
            $this->apiResponse($response);
            return true;
        }
    }

    /**
     * To get token for parker using stripe
     * 
     * @returns result query result
     */
    public function getToken()
    {
        require_once (APPPATH . STRIPE_PATH);
        require_once (APPPATH . STRIPE_LIB_PATH);
        Stripe\Stripe::setApiKey(STRIPE_KEY);
        $expirationdate = $this->input->post('expiration_date', TRUE);
        $expiration_month = substr($expirationdate, 0, 2);
        $expiration_year = substr($expirationdate, 3);
        try {
            $res = \Stripe\Token::create(array(
                        "card" => array(
                            "name" => $this->input->post('nameon_card'),
                            "number" => $this->input->post('card_number'),
                            "exp_month" => $expiration_month,
                            "exp_year" => $expiration_year,
                            "cvc" => $this->input->post('security_code')
                        )
            ));
            $result = array(
                MESSAGE => 'success',
                'token' => $res ['id']
            );
            return ($result);
        } catch (\Stripe\Error\Stripe_InvalidRequestError $e) {
            $body = $e->getJsonBody();
            $err = $body [ERROR];
            return array(
                MESSAGE => $err [MESSAGE],
                TOKEN => ''
            );
        } catch (\Stripe\Error\Stripe_CardErro $e) {
            $body = $e->getJsonBody();
            $err = $body ['error'];
            return array(
                MESSAGE => $err ['message'],
                'token' => ''
            );
        } catch (\Stripe\Error\ApiConnection $e) {
            return array(
                MESSAGE => 'Network communication with Payment Gateway failed',
                TOKEN => ''
            );
        }
    }

    /**
     * To check booking status
     * 
     * @returns result query result
     */
    public function checkBooking()
    {
        $data[DRIVEWAYID] = $this->input->post('drivewayid');
        $data['startdate'] = $this->input->post('startdate');
        $data['enddate'] = $this->input->post('enddate');
        $this->load->model('DrivewayModel');
        $checkBooking = $this->DrivewayModel->checkBooking($data);
        if ($checkBooking) {
            $response = array(
                STATUS => true,
                MESSAGE => 'Exists'
            );
        } else {
            $response = array(
                STATUS => false,
                MESSAGE => 'Not Exists'
            );
        }
        $this->apiResponse($response);
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
            //only one identifier?
            if (count($timezone_ids) == 1) {
                $time_zone = $timezone_ids[0];
            } else {
                foreach ($timezone_ids as $timezone_id) {
                    $timezone = new DateTimeZone($timezone_id);
                    $location = $timezone->getLocation();
                    $tz_lat = $location[LATITUDE];
                    $tz_long = $location[LONGITUDE];
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

    /**
     *
     * To search whether day setting exists for particular driveway
     * 
     * @param integer $drivewayidpass driveway id
     * @param array $dateArrayrangevalue range values
     * @param datetime $fromdateget booking from date and time
     * @param date $todateget booking to date only
     * @param integer $type booking type
     *
     * @returns $drivewayid driveway id
     *
     */
    public function searchDrivewayDaySettings($drivewayidpass, $dateArrayrangevalue, $fromdateget, $todateget, $type)
    {
        $drivewayid = 0;
        $fromdatevalue = $fromdateget->format(DATE_TIME);
        $todatevalue = $todateget->format(DATE_TIME);
        $fromtimeonly = $fromdateget->format(TIME_FORMAT);
        $totimeonly = $todateget->format(TIME_FORMAT);
        $weekday = date("w", strtotime($dateArrayrangevalue));
        if ($weekday > 1 && $weekday < 5) {
            $weekday = 1;
        }
        $sqltime = "Select * from tbl_driveway_day_settings where driveway_id=" . $drivewayidpass . " and status=1 and day_option=" . $weekday;
        $sqltime_query = $this->db->query($sqltime);
        if ($sqltime_query->num_rows() > 0) {
            //while($rowtime = $resulttime->fetch_assoc()) 
            $resulttime = $sqltime_query->result_array();
            foreach ($resulttime as $rowtime) {
                $fromtime = $rowtime["from"];
                $totime = $rowtime["to"];
                if ($fromtime == "00:00:00") {
                    $fromtime = "";
                }
                if ($totime == "00:00:00") {
                    $totime = "";
                }
                //only one day in search
                if (count($dateArrayrangevalue) == "1") {
                    if ((strtotime($dateArrayrangevalue . "" . $fromtime) <= strtotime($fromdatevalue) || $fromtime == "") && (strtotime($dateArrayrangevalue . "" . $totime) >= strtotime($todatevalue) || $totime == "")) {
                        $drivewayid = $drivewayidpass;
                    }
                }
                //multi date range
                else {
                    //for continuous
                    //start
                    if ($type == "1" || $type == "3") {
                        if ($i == 0) {
                            if (strtotime($dateArrayrangevalue . "" . $fromtime) <= strtotime($fromdatevalue) || $fromtime == "") {
                                $drivewayid = $drivewayidpass;
                            }
                        } else if ($i == count($dateArrayrange) - 1) {
                            if (strtotime($dateArrayrangevalue . "" . $totime) >= strtotime($todatevalue) || $totime == "") {
                                $drivewayid = $drivewayidpass;
                            }
                        } else {
                            if ($fromtime == "" && $totime == "") {
                                $drivewayid = $drivewayidpass;
                            }
                        }
                    }
                    //end else recurring
                    else {
                        if ((strtotime($dateArrayrangevalue . "" . $fromtime) <= strtotime($dateArrayrangevalue . "" . $fromtimeonly) || $fromtime == "") && (strtotime($dateArrayrangevalue . "" . $totime) >= strtotime($dateArrayrangevalue . "" . $totimeonly) || $totime == "")) {
                            $drivewayid = $drivewayidpass;
                        }
                    }
                }
            }
        }
        return $drivewayid;
    }

    function convertToHoursMins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    /**
     *
     * To calculate the hourly charge for booking
     * 
     * @param integer $type booking type
     * @param datetime $bookingTo booking to date and time
     * @param datetime $bookingFrom booking from date and time
     * @param date $bookingToOnly booking to date only
     * @param date $bookingFromOnly booking from date only
     * @param integer $bookingFromTimeOnly booking from time only
     * @param integer $bookingToTimeOnly booking to time only
     *
     * @returns $hourcharge hourly charge
     *
     */
    public function calculateCharge($type, $bookingTo, $bookingFrom, $bookingToOnly, $bookingFromOnly, $bookingFromTimeOnly, $bookingToTimeOnly)
    {
        $daterangesearch = $this->createDateRangeArray($bookingFromOnly, $bookingToOnly);
        //shree chaged from here
        $hourcharge = 0;
        if ($type == "1") {
            $diff = abs(strtotime($bookingTo) - strtotime($bookingFrom));
            $diff_in_hrs = round($diff / 60);
            $hourcharge = $this->convertToHoursMins($diff_in_hrs);
        }
        //for flat rate
        else if ($type == "3") {
            $timestampfrom = strtotime($bookingFrom);
            $timestampto = strtotime($bookingTo);
            $hour = abs($timestampto - $timestampfrom) / (60 * 60);
            $diff = ceil($hour / 24);
            //no of day for flat rate
            $hourcharge = $diff;
        } else {
            //If search from time < to time Ex: 10:00 to 16:00
            if (strtotime($bookingFromTimeOnly) < strtotime($bookingToTimeOnly)) {
                $hour = 0;
                for ($m = 0; $m < count($daterangesearch); $m++) {
                    $startdatetime = $daterangesearch[$m] . " " . $bookingFromTimeOnly;
                    $enddatetime = $daterangesearch[$m] . " " . $bookingToTimeOnly;
                    $diff = abs(strtotime($enddatetime) - strtotime($startdatetime));
                    $diff_in_hrs = round($diff / 60);
                    $hour = $hour + $diff_in_hrs;
                }
                $hourcharge = $this->convertToHoursMins($hour);
            }
            //If search from time > to time Ex: 16:00 PM to 10:00 AM //from
            else {
                $hour = 0;
                for ($m = 0; $m < count($daterangesearch); $m++) {
                    $startdatetime = $daterangesearch[$m] . " " . $bookingFromTimeOnly;
                    $todate = date(DATE_FORMAT, strtotime($daterangesearch[$m]));
                    $stop_date = date(DATE_FORMAT, strtotime($todate . ' +1 day'));
                    $enddatetime = $stop_date . " " . $bookingToTimeOnly;
                    if ($stop_date <= $bookingToOnly) {
                        $diff = abs(strtotime($enddatetime) - strtotime($startdatetime));
                        $diff_in_hrs = round($diff / 60);
                        $hour = $hour + $diff_in_hrs;
                    }
                }
                $hourcharge = $this->convertToHoursMins($hour);
            }
        }
        return $hourcharge;
    }

    /**
     *
     * To check whether booking dates exists     
     * 
     * @param integer $booking_id booking ID
     * @param datetime $startdatetime start date and time of booking
     * @param datetime $enddatetime end date and time of booking
     *
     * @returns $bookingexists status
     *
     */
    public function isBookingDateExists($booking_id, $startdatetime, $enddatetime)
    {
        $bookingexists = 0;
        $sqlbooking = "Select * from tbl_booking_date where booking_id=" . $booking_id . " and status=1 and (('$startdatetime'>=start_date and '$startdatetime'<=end_date) or ('$startdatetime'<=start_date and '$enddatetime'>=end_date) or ('$enddatetime'>=start_date and '$enddatetime'<=end_date) or ('$startdatetime'<=start_date and '$enddatetime'<=end_date and '$enddatetime'>=start_date))";
        $sqlbooking_query = $this->db->query($sqlbooking);
        if ($sqlbooking_query->num_rows() > 0) {
            $bookingexists = 1;
        }
        return $bookingexists;
    }

    /**
     * To get stripe fee and LouiePark application fee
     *   
     * @returns response in json format 
     *     
     */
    function processCharge()
    {
        $this->load->model('booking/Bookingmodel');
        $constants = $this->Bookingmodel->getConstants();
        $this->apiResponse(array(
            "stripefee" => $constants->stripeFee,
            "stripefee2" => $constants->stripeProcessfee,
            "applicationfee" => $constants->applicationFeesdolars,
            "totaldays" => $constants->totalBookingdays,
            "applicationfee2" => $constants->applicationFees
        ));
        return true;
    }

}
