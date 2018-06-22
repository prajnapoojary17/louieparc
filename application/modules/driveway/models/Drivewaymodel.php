<?php

/**
 *
 * File Name : Driveway Model
 *
 * Description : Used to update driveway details to DB
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
Class Drivewaymodel extends CI_model
{

    /**
     * To save driveway
     *
     * @param array $data Array
     *
     */
    function saveDriveway($data)
    {
        if (isset($data[DRIVEWAYID])) {
            $this->db->where(DRIVEWAYID, $data[DRIVEWAYID]);
            $this->db->update(TBL_DRIVEWAY, $data);
        } else {
            $this->db->insert(TBL_DRIVEWAY, $data);
        }
    }

    /**
     * To retrieve all driveways
     *
     * @return query result
     */
    function getDriveways()
    {
        $sql = "SELECT drv.drivewayID, drv.userID, drv.building, drv.route, drv.streetAddress, drv.city, drv.zip, drv.state, 
                drv.drivewayStatus, drv.price, drv.latitude, drv.longitude                    
                FROM tbl_driveway as drv            
                WHERE drv.drivewayStatus !=0 ORDER BY drv.drivewayID DESC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To retrieve individual driveway information
     *
     * @param integer $drivewayId driveway ID
     *
     * @return query result
     */
    function getDrivewayInfo($drivewayId)
    {
        $this->db->select('drv.drivewayID, drv.userID, drv.streetAddress, drv.state, drv.drivewayStatus,drv.latitude, drv.longitude, drv.price, user.userName ');
        $this->db->from(TBL_DRIVEWAY_AS_DRV);
        $this->db->join(TBL_USERS_AS_USER, 'user.userID = drv.userID', 'left');
        $this->db->where(DRIVEWAYID, $drivewayId);
        $this->db->where("drivewayStatus !=", 0);
        $this->db->order_by(DRIVEWAYID, "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To retrieve individual driveway
     *
     * @param integer $searchtype search type
     * @param array $data Array
     *
     * @return query result
     */
    function getDriveway($data, $searchtype)
    {
        if ($searchtype == 3) {
            $dPrice = 'ddailyPrice';
        } else {
            $dPrice = 'dPrice';
        }
        $sql = "SELECT drv.drivewayID, drv.userID, drv.latitude, drv.longitude, drv.timeZone, drv.price, drv.dailyprice, drv.description, drv.instructions,
               drv.photo1, drv.photo2, drv.photo3, drv.photo4, drv.building as dbuilding, drv.route as droute, drv.streetAddress as dstreetAddress, drv.city as dcity,
               drv.state as dstate, drv.zip as dzip, user.userName, user.firstName, user.lastName, user.emailID, user.phone,user.building,user.streetAddress,user.city,user.state,user.zip, 
        (
        SELECT " . $dPrice . "
        FROM tbl_driveway_views_update
        WHERE drv.drivewayID = tbl_driveway_views_update.drivewayID  AND fromDate = '" . $data[FROM_DATE] . "'
        ORDER BY dPrice DESC
        LIMIT 1
        ) AS dPrice
        FROM tbl_driveway as drv
        LEFT JOIN tbl_users as user ON user.userID = drv.userID
        WHERE (
        drv.drivewayID = " . $data[DRIVEWAYID] . "
        )
        ORDER BY drv.drivewayID ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * To retrieve reviews of individual driveway
     *
     * @param integer $drivewayId driveway ID
     *
     * @return query result
     */
    function getReviews($drivewayId)
    {
        $this->db->select('rv.comments, rv.title, user.userName, user.firstName, user.lastName, user.city, user.profileImage');
        $this->db->from('tbl_review as rv');
        $this->db->join(TBL_USERS_AS_USER, 'user.userID = rv.userID', 'left');
        $this->db->where("rv.drivewayID", $drivewayId);
        $this->db->where("rv.approvedStatus", 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To retrieve ratings of individual driveway
     *
     * @param integer $drivewayId driveway ID
     *
     * @return query result
     */
    function getRatings($drivewayId)
    {
        $sql = "SELECT AVG( rating ) as rating
                FROM tbl_rating
                WHERE drivewayID ='" . $drivewayId . "' AND approvedStatus = 1 ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

    /**
     * To check whether car information exists for particular user
     *
     * @param integer $userId User ID
     *
     * @return query result
     */
    function checkCarExist($userId)
    {
        $this->db->select('vehicleID,userID,model,year,color,vehicleNumber');
        $this->db->from('tbl_vehicle_type');
        $this->db->where(USERID, $userId);
        $this->db->where(STATUS, '1');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To check whether card information exists for particular user
     *
     * @param integer $userId User ID
     *
     * @return query result
     */
    function checkCardExist($userId)
    {
        $this->db->select('name_on_card, userID, billID, expiration_month, expiration_year, customer_id');
        $this->db->from('tbl_billing_detail');
        $this->db->where(USERID, $userId);
        $this->db->where(STATUS, '1');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To lock booking for next 6 minutes
     *
     * @param array $booking Array containg booking details
     *
     * @return id
     */
    function bookProcess($booking)
    {
        $this->db->insert('tbl_booking', array(DRIVEWAYID => $booking[DRIVEWAYID],
            'unlockTime' => $booking['unlockTime'],
            USERID => $booking['userID'],
            FROM_DATE => $booking[FROM_DATE],
            'toDate' => $booking['toDate'],
            'bookingType' => $booking['bookingType'],
            'bookingStatus' => '2',
            'vehicleID' => 1));
        return $this->db->insert_id();
    }

    /**
     * To retrieve date settings for driveway
     *
     * @param integer $drivewayId driveway ID
     *
     * @return query result
     */
    function getDatesetting($drivewayID)
    {
        $sql = "SELECT *
               FROM tbl_driveway_date_settings
               WHERE driveway_id = '" . $drivewayID . "'
               AND status = 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() >= 1) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * To update driveway status
     *
     * @param integer $drivewayId driveway ID
     * @param array $userdata Array containing driveway deatils
     *   
     */
    function updateStatus($userdata, $drivewayID, $userId)
    {
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->where('userID', $userId);
        $this->db->update(TBL_DRIVEWAY, $userdata);      
    }

    /**
     * To save date settings
     *
     * @param integer $drivewayId driveway ID
     * @param array $data Array containing driveway details
     *
     * @return id last insert id
     */
    function saveDatesetting($data, $drivewayID, $userId)
    {
        /*$datestatus = array(STATUS => 0);
        $this->db->where(DRV_ID, $drivewayID);
        $this->db->update(TBL_DRIVEWAY_DATE_SETTINGS, $datestatus);*/
        $sql = "UPDATE tbl_driveway_date_settings ds INNER JOIN tbl_driveway d on d.userID =".$userId." SET ds.status = 0
                WHERE ds.driveway_id = ".$drivewayID;
        $query = $this->db->query($sql);
       
        $this->db->insert(TBL_DRIVEWAY_DATE_SETTINGS, $data);
        return $this->db->insert_id();
    }

    /**
     * To update driveway date setting
     *
     * @param integer $drivewayId driveway ID
     *   
     */
    function updateDatesetting($drivewayID, $userId)
    {
         $sql = "UPDATE tbl_driveway_date_settings  ds INNER JOIN tbl_driveway d on d.userID = ".$userId." SET ds.status = 0 
                 WHERE ds.driveway_id = ".$drivewayID;
        $query = $this->db->query($sql);        
        /*$datestatus = array(STATUS => 0);
        $this->db->where(DRV_ID, $drivewayID);
        $this->db->update(TBL_DRIVEWAY_DATE_SETTINGS, $datestatus);*/      
    }

    /**
     * To save day settings
     *
     * @param integer $drivewayId driveway ID
     * @param array $data Array containing driveway deatils
     *
     */
    function saveDaysetting($dayset, $drivewayID, $userId)
    {
        $sql = "UPDATE tbl_driveway_day_settings  ds INNER JOIN tbl_driveway d on d.userID = ".$userId." SET ds.status = 0 
                 WHERE ds.driveway_id = ".$drivewayID;
        $query = $this->db->query($sql);       
        /*$daystatus = array(STATUS => 0);
        $this->db->where(DRV_ID, $drivewayID);
        $this->db->update(TBL_DRIVEWAY_DAY_SETTINGS, $daystatus);*/      
        foreach ($dayset as $day) {
            $this->db->insert(TBL_DRIVEWAY_DAY_SETTINGS, $day);
        }
    }

    /**
     * To update driveway day setting
     *
     * @param integer $drivewayId driveway ID
     *   
     */
    function updateDaysetting($drivewayID, $userId)
    {
      $sql = "UPDATE tbl_driveway_day_settings  ds INNER JOIN tbl_driveway d on d.userID = ".$userId." SET ds.status = 0 
                 WHERE ds.driveway_id = ".$drivewayID;
        $query = $this->db->query($sql); 
        /* $daystatus = array(STATUS => 0);
        $this->db->where(DRV_ID, $drivewayID);
        $this->db->update(TBL_DRIVEWAY_DAY_SETTINGS, $daystatus);*/
       
    }

    /**
     * To retrieve driveway info
     *
     * @param integer $drivewayId driveway ID
     * 
     * @returns response in json format  
     *   
     */
    function getOwnerDriveway($drivewayId)
    {
        $this->db->select('drv.drivewayID, drv.userID, drv.building, drv.streetAddress, drv.state, drv.city,drv.zip,drv.route ');
        $this->db->from(TBL_DRIVEWAY_AS_DRV);
        $this->db->where(DRIVEWAYID, $drivewayId);
        $this->db->order_by(DRIVEWAYID, "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * To retrieve driveway info
     *
     * @param integer $drivewayId driveway ID
     * 
     * @returns response in json format  
     *   
     */
    function getmyDriveway($drivewayId)
    {
        $this->db->select('drv.drivewayID, drv.userID, drv.building, drv.description, drv.instructions,drv.photo1, drv.photo1, drv.photo2, drv.photo3, drv.photo4, drv.price, drv.dailyprice, drv.slot, user.userName ');
        $this->db->from(TBL_DRIVEWAY_AS_DRV);
        $this->db->join(TBL_USERS_AS_USER, 'user.userID = drv.userID', 'left');
        $this->db->where(DRIVEWAYID, $drivewayId);
        $this->db->order_by(DRIVEWAYID, "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * To retrieve driveway zone
     *
     * @param integer $drivewayId driveway ID
     * 
     * @returns response in json format  
     *   
     */
    function getDrivewayZone($drivewayId)
    {
        $this->db->select('drv.drivewayID, drv.userID, drv.streetAddress, drv.state, drv.drivewayStatus,drv.latitude, drv.longitude, drv.price, drv.timeZone');
        $this->db->from(TBL_DRIVEWAY_AS_DRV);
        $this->db->where(DRIVEWAYID, $drivewayId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * To update booking
     *
     * @param array $data Array containing Booking details
     * 
     * @returns insert id
     *   
     */
    function recbookProcess($data)
    {
        $this->db->insert("tbl_booking_date", $data);
        return $this->db->insert_id();
    }

}
