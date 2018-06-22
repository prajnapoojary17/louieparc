<?php

/**
 *
 * File Name : Booking Model
 *
 * Description : Used to send reminder to parker and renetr
 *
 * Created By : Reshma N
 *
 * Created Date : 10/18/2016
 *
 * Last Modified By : Reshma N
 *
 * Last Modified Date : 10/18/2016
 *
 */
class Cronmodel extends CI_model
{

    /**
     * To get the reminder info for particular date
     *
     * @return query result
     *
     */
    function reminderInfo()
    {
        $sql = "SELECT b.bookingID,b.userID, b.drivewayID, b.fromDate, b.fromTime, b.toDate, b.toTime, b.alertTime, d.userID as ownerID, d.streetAddress, d.city, d.state, d.zip, d.building,     latitude,longitude,0 as booking_date_id,bookingType FROM tbl_booking b 
                 INNER JOIN tbl_driveway d on d.drivewayID = b.drivewayID 
                 WHERE b.bookingStatus = 1 AND  b.emailStatus != 1 AND TIMESTAMPDIFF(MINUTE , UTC_Timestamp, fromDate )<30 AND TIMESTAMPDIFF(MINUTE , UTC_Timestamp, fromDate )>0 and bookingType!=2
					UNION	
				SELECT b.bookingID,b.userID, b.drivewayID, b.fromDate, b.fromTime, b.toDate, b.toTime, b.alertTime, d.userID as ownerID, d.streetAddress, d.city, d.state, d.zip, d.building,     latitude,longitude,booking_date_id,bookingType FROM tbl_booking b 
                 INNER JOIN tbl_driveway d on d.drivewayID = b.drivewayID 
				 INNER JOIN tbl_booking_date bd on bd.booking_id=b.bookingID
                 WHERE b.bookingStatus = 1 AND  bd.emailStatus != 1 AND TIMESTAMPDIFF(MINUTE , UTC_Timestamp, bd.start_date )<30 AND TIMESTAMPDIFF(MINUTE , UTC_Timestamp, bd.start_date )>0 and bookingType=2
";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To get the reminder info for particular date
     *
     * @return query result
     *
     */
    function reminderInfoEnd()
    {
        $sql = "SELECT b.bookingID,b.userID, b.drivewayID, b.fromDate, b.fromTime, b.toDate, b.toTime, b.alertTime, b.alertEndTime, d.userID as ownerID, d.streetAddress, d.city, d.state, d.zip, d.building,    latitude,longitude,0 as booking_date_id,bookingType  FROM tbl_booking b 
                 INNER JOIN tbl_driveway d on d.drivewayID = b.drivewayID 
                 WHERE   TIMESTAMPDIFF(MINUTE , UTC_Timestamp, toDate )<30 AND  TIMESTAMPDIFF(MINUTE , UTC_Timestamp, toDate )>0 and bookingType!=2
				 UNION
				 SELECT b.bookingID,b.userID, b.drivewayID, b.fromDate, b.fromTime, b.toDate, b.toTime, b.alertTime, b.alertEndTime, d.userID as ownerID, d.streetAddress, d.city, d.state, d.zip, d.building,    latitude,longitude,booking_date_id,bookingType  FROM tbl_booking b 
				INNER JOIN tbl_booking_date bd on bd.booking_id=b.bookingID
                 INNER JOIN tbl_driveway d on d.drivewayID = b.drivewayID 
				 WHERE  TIMESTAMPDIFF(MINUTE , UTC_Timestamp, bd.end_date )<30 AND  TIMESTAMPDIFF(MINUTE , UTC_Timestamp, bd.end_date )>0 and bookingType=2";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To set the emailed user status for booking remider
     *
     * @param integer $bookingID Booking ID
     *
     */
    function updateEmaiStatus($bookingID)
    {
        $this->db->where("bookingID", $bookingID);
        $this->db->update("tbl_booking", array(
            'emailStatus' => 1
                )
        );
    }

    /**
     * To set the emailed user status for booking remider
     *
     * @param integer $bookingID Booking ID
     *
     */
    function updateEmaiStatusForRecurring($bookingdateID)
    {
        $this->db->where("booking_date_id", $bookingdateID);
        $this->db->update("tbl_booking_date", array(
            'emailStatus' => 1
                )
        );
    }

    /**
     * To set the e-mailed user status for booking end time reminder
     *
     * @param integer $bookingID Booking ID
     *
     */
    function updateEndEmailStatus($bookingID)
    {
        $this->db->where("bookingID", $bookingID);
        $this->db->update("tbl_booking", array(
            'emailStatusEnd' => 1
                )
        );
    }

    /**
     * To set the e-mailed user status for booking end time reminder
     *
     * @param integer $bookingID Booking ID
     *
     */
    function updateEndEmailStatusForRecurring($bookingdateID)
    {
        $this->db->where("booking_date_id", $bookingdateID);
        $this->db->update("tbl_booking_date", array(
            'emailStatusEnd' => 1
                )
        );
    }

    /**
     * To set the e-mailed user status which was pending
     *
     * @param integer $emailID Email ID
     *
     */
    function pendingInfo()
    {
        $condition = "emailStatus = 0 ";
        $this->db->select('emailID, subject, emailStatus, toEmail, fromEmail, content');
        $this->db->from('tbl_email_status');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * To set the e-mailed user status which was pending
     *
     * @param integer $emailID Email ID
     *
     */
    function sentEmailStatus($emailID, $status)
    {
        $this->db->where("emailID", $emailID);
        $this->db->update("tbl_email_status", array(
            'emailStatus' => $status
                )
        );
    }

}
