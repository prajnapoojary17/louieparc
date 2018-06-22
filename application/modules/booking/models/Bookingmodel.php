<?php

/**
 *
 * File Name : Booking Model
 *
 * Description : Used to update booking details to DB
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
class Bookingmodel extends CI_model
{

    /**
     * To retrieve individual bookings
     *
     * @param integer $bookingID booking ID
     *
     * @return query result
     */
    function getBookingInfo($bookingID)
    {
        $condition = "bookingID =" . "'" . $bookingID . "' or " . "parentID =" . "'" . $bookingID . "'";
        $this->db->select('userID, drivewayID, fromDate, toDate, fromTime, toTime, vehicleID, bookingType, bookingUse, totalDays, totalPrice, parentID, bookingStatus');
        $this->db->from(TBL_BOOKING);
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * To cancel booking
     *
     * @param integer $drivewayID driveway ID
     * @param integer $bookingID booking ID
     *
     */
    function cancelBooking($drivewayID, $bookingID, $userId)
    {
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->where(BOOKINGID, $bookingID);
        $this->db->where('userID', $userId);
        $this->db->update(TBL_BOOKING, array(
            BOOKING_STATUS => 0
        ));
    }
    
    /**
     * To cancel booking by renter
     *
     * @param integer $drivewayID driveway ID
     * @param integer $bookingID booking ID
     *
     */
    function renterCancelBooking($drivewayID, $bookingID, $userId)
    {
        $sql = "UPDATE tbl_booking b JOIN tbl_driveway d ON d.userID = ".$userId."
                SET  b.bookingStatus = 0
                WHERE b.drivewayID = ".$drivewayID."
                AND b.bookingID = ".$bookingID;
        $query = $this->db->query($sql);       
    }

    /**
     * To retrieve parked customer list
     *
     * @param integer $userID User ID
     *
     * @return query result
     */
    function parkedCustomer($userID)
    {
        $sql = "SELECT b.*,TIME_FORMAT(b.fromTime, '%H:%i') as fromtime , TIME_FORMAT(b.toTime, '%H:%i') as totime , b.bookingType,b.bookingID,
                u.userID, u.userName, u.firstName, u.lastName, d.timeZone, d.latitude, d.longitude, d.building FROM tbl_booking b 
                LEFT JOIN tbl_driveway d on d.drivewayID = b.drivewayID 
                LEFT JOIN tbl_users u on u.userID = b.userID where d.userID = '" . $userID . "' AND  b.bookingStatus !=2  ORDER BY b.bookingID DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * To retrieve Parking History of logged in Parker
     *
     * @param integer $userID User ID
     *
     * @return query result
     */
    function parkingHistory($userID)
    {
        $sql = "SELECT b.bookingID, b.totalPrice,b.processFee, b.fromDate, b.toDate, TIME_FORMAT(b.fromTime, '%H:%i') as fromTime , TIME_FORMAT(b.toTime, '%H:%i') as toTime ,
                b.bookingStatus, b.chargeId, b.bookingType, d.drivewayID, d.userID, d.city, d.timeZone, d.latitude, d.longitude, u.userName 
                FROM tbl_booking b 
        LEFT JOIN tbl_driveway d on d.drivewayID = b.drivewayID 
        LEFT JOIN tbl_users u on u.userID = d.userID where b.userID = '" . $userID . "' AND b.bookingStatus !=2 ORDER BY b.bookingID DESC ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * To save parker billing info with token
     *
     * @param array $data array containing values
     *
     */
    function saveBillingToken($data)
    {
        $this->db->insert("tbl_billing_detail", $data);
    }

    /**
     * To save reccuring bookings
     *
     * @param array $data array containing values
     *
     */
    function bookDrivewayDates($data)
    {

        $this->db->insert("tbl_booking_date", $data);
    }

    /**
     * To get driveway owner info for amount transfer
     *
     * @param integer $userId User ID
     *
     * @return query result
     */
    function getOwnerInfo($userId)
    {
	//print $userId;
        $condition = "userID =" . "'" . $userId . "' AND  " . "status = 1";
        $this->db->select('userID,secretKey, accID, accHolderName');
        $this->db->from('tbl_account_detail');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

    /**
     * To get driveway owner info for amount transfer
     *
     * @param integer $billId Billing ID
     *
     * @return query result
     */
    function getUserToken($billId)
    {
        $this->db->select('customer_id, billID, expiration_month, expiration_year, name_on_card, phone, streetAddress, city, state, zip, userID');
        $this->db->from('tbl_billing_detail');
        $this->db->where("billID", $billId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        }
    }

    /**
     * To retrieve booking history
     *
     * @param integer $bookingID Booking ID
     *
     * @return query result
     */
    function getParkinghistory($bookingID)
    {
        $sql = "SELECT b.bookingID, b.totalDays, b.totalPrice,b.processFee, b.bookingDate,b.bookingType, b.bookingStatus, u.userID, u.userName, u.emailID, u.firstName, u.lastName, u.phone, u.building, u.streetAddress, u.city, u.route,
                u.state, u.zip, d.drivewayID, d.photo1, d.photo2, d.photo3, d.photo4, d.timeZone,
                d.building as dbuilding, d.route as droute, d.streetAddress as dstreetAddress, d.city as dcity, d.state as dstate, d.zip as dzip, d.description, d.instructions
                FROM tbl_booking b
                LEFT JOIN tbl_driveway d ON d.drivewayID = b.drivewayID
                LEFT JOIN tbl_users u ON u.userID = d.userID
                WHERE b.bookingID = '" . $bookingID . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

    /**
     * To get save parker vehicle info during booking
     *
     * @param array $data Array containing values
     *
     * @return integer vehicleId Vehicle ID
     *
     */
    function saveVehicleInfo($data)
    {
        $this->db->insert("tbl_vehicle_type", $data);
        return $this->db->insert_id();
    }

    /**
     * To get user email id
     *
     * @param integer $userId User ID
     *
     * @return query result
     */
    function getUserEmail($userId)
    {
        $this->db->select('userID, emailID,userName,firstName,lastName,phone,building,streetAddress,city,state,zip');
        $this->db->from('tbl_users');
        $this->db->where(USERID, $userId);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To get driveway information of individual driveway
     *
     * @param integer $drivewayId Driveway ID
     *
     * @return query result
     */
    function getdrivewayInfo($drivewayId)
    {
        $this->db->select('userID, building, route, streetAddress, city, state ,zip, latitude,longitude,timeZone');
        $this->db->from('tbl_driveway');
        $this->db->where(DRIVEWAYID, $drivewayId);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To get count of cities parked by parker
     *
     * @param integer $userId User ID
     *
     * @return query result
     */
    function citiesParked($userID)
    {
        $sql = "SELECT count(b.bookingID) AS cities FROM tbl_booking b LEFT JOIN tbl_driveway d on d.drivewayID = b.drivewayID where b.userID = '" . $userID . "' AND b.bookingStatus = 1 AND b.toDate < UTC_Timestamp ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

    /**
     * To get Charge ID for particular booking
     *
     * @param integer $bookingID Booking ID
     *
     * @return query result
     */
    function getchargeId($bookingID)
    {
        $this->db->select(CHARGEID);
        $this->db->from(TBL_BOOKING);
        $this->db->where(BOOKINGID, $bookingID);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To check whether any parker has booked driveway 
     *
     * of particulr renter
     *
     * @param integer $userId User ID
     *
     * @return query result
     *
     */
    function checkBooking($userId)
    {
        $this->db->select(USERID);
        $this->db->from(TBL_BOOKING);
        $this->db->where(USERID, $userId);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * To set the emailed user status for booking end time remider
     *
     * @param integer $bookingID Booking ID
     *
     */
    function updateEndEmailStatus($bookingID)
    {
        $this->db->where(BOOKINGID, $bookingID);
        $this->db->update(TBL_BOOKING, array(
            'emailStatusEnd' => 1
                )
        );
    }

    /**
     * To update booking date
     *
     * @param array $data Array containing values
     *
     */
    function bookDrivewayUpdate($data)
    {
        $booking = array(USERID => $data[USERID], 'drivewayID' => $data['drivewayID'], 'vehicleID' => $data['vehicleID'],
            'fromDate' => $data['fromDate'], 'fromTime' => $data['fromTime'], 'toDate' => $data['toDate'], 'toTime' => $data['toTime'],
            'price' => $data['price'], 'totalPrice' => $data['totalPrice'], 'processFee' => $data['processFee'], BOOKING_STATUS => $data[BOOKING_STATUS], 'bookingType' => $data['bookingType'], CHARGEID => $data[CHARGEID], 'user_IP' => $data['user_IP']);
        $this->db->where(BOOKINGID, $data['bookingID']);
        $this->db->update(TBL_BOOKING, $booking);
    }

    /**
     * To get admin seetings info
     *
     * @return query result
     */
    function getConstants()
    {
        $this->db->select('*');
        $this->db->from('tbl_constants');
        $this->db->where('constant_id', 1);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To get Charge ID for particular booking
     *
     * @param integer $bookingID Booking ID
     *
     * @return query result
     */
    function getadmin()
    {
        $this->db->select('emailID');
        $this->db->from(' tbl_users');
        $this->db->where('userID', 1);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To update the old locked booking details
     *
     * @param integer $bookingID Booking ID
     *
     * @return query result
     */
    function updatedLockedBooking($bookingID)
    {
        $this->db->where('booking_id', $bookingID);
        $this->db->update('tbl_booking_date', array('status' => 0));
    }

    /**
     * To get booking id of reviews entered by logged in user
     *
     * @param integer $userId user ID
     *
     * @return query result
     */
    function getReviews($userId)
    {
        $this->db->select('bookingId');
        $this->db->from('tbl_review');
        $this->db->where('userID', $userId);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    /**
     * To get user email id
     *
     * @param integer $userId User ID
     *
     * @return query result
     */
    function getDrivewaydetail($bookingId)
    {
        $sql = "SELECT * from `tbl_driveway` left join `tbl_booking` on tbl_booking.drivewayID = tbl_driveway.drivewayID where tbl_booking.bookingID = '" . $bookingId . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

    /**
     * To get user email id
     *
     * @param integer $userId User ID
     *
     * @return query result
     */
    function getownerEmail($drivewayID)
    {
        $sql = "SELECT emailID from `tbl_users` left join `tbl_driveway` on tbl_users.userID = tbl_driveway.userID where tbl_driveway.drivewayID = '" . $drivewayID . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

}
