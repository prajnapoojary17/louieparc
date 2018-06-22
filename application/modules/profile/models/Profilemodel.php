<?php

/**
 * Model class to manage the Profile
 *
 * @author     Reshma N
 *
 */
Class Profilemodel extends CI_model
{

    /**
     * To Update the Profile info
     *
     * @param array $data profile info and integer $userID User ID
     *
     * @return query result
     */
    function updateProfile($data, $userID)
    {
        $this->db->where(USERID, $userID);
        $this->db->update(TBL_USERS, $data);
        return $this->db->affected_rows();
    }

    /**
     * To get the car info of User
     *
     * @param integer $userID User ID
     *
     * @return query result
     */
    function getCar($userID)
    {
        $this->db->select('*');
        $this->db->from(TBL_VEHICLE_TYPE);
        $this->db->where(USERID, $userID);
        $this->db->where("status", 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * To Update the Car info
     * 
     * @param array $data car info and integer $vehicleID Vehicle ID
     */
    function updateCar($data, $vehicleID, $userId)
    {
        $this->db->where('vehicleID', $vehicleID);
        $this->db->where('userID', $userId);
        $this->db->update(TBL_VEHICLE_TYPE, $data);
        return true;
    }

    /**
     * To Delete the Profile info
     *
     * @param array $data car status and integer $vehicleID Vehicle ID
     */
    function deleteCar($vehicleID, $userId, $data)
    {
        $this->db->where('vehicleID', $vehicleID);
         $this->db->where('userID', $userId);
        $this->db->update(TBL_VEHICLE_TYPE, $data);
        return true;
    }

    /**
     * To insert Car info
     *
     * @param array $data car status and integer $vehicleID Vehicle ID
     * 
     * @return insert ID
     */
    function savecarInfo($data)
    {
        $this->db->insert(TBL_VEHICLE_TYPE, $data);
        $last_id = $this->db->insert_id();
        return($last_id);
    }

    /**
     * To insert driveway reviews
     *
     */
    function saveReviews($data)
    {
        $this->db->insert("tbl_review", $data['reviews']);
        $last_id = $this->db->insert_id();
        if (isset($data ['ratings'])) {
            $ratings = array();
            foreach ($data ['ratings'] as $key => $value) {
                $ratings [$key] = $value;
            }
            $ratings ['reviewID'] = $last_id;
            $this->db->insert("tbl_rating", $ratings);
        }
    }

    /**
     * To insert Message sent by parker
     *
     * @return insert ID
     */
    function saveMessage($data)
    {
        $this->db->insert("tbl_message", $data);
        return $this->db->insert_id();
    }

    /**
     * To Update the Profile info
     *
     * @param array $data of profile info and integer $userID User ID
     * 
     * @return number of rows effected
     */
    function updateRenterprofile($data, $userID)
    {
        $this->db->where(USERID, $userID);
        $this->db->update(TBL_USERS, $data);
        return $this->db->affected_rows();
    }
    
    
/**
     * To Update the Profile info
     *
     * @param array $data of profile info and integer $userID User ID
     * 
     * @return number of rows effected
     */
    function updateUserAddress($data, $userID)
    {
        $this->db->where(USERID, $userID);
        $this->db->update('tbl_users', $data);
        return $this->db->affected_rows();
    }
    /**
     * To Update the driveway info
     *
     * @param array $data of driveway info and integer $drivewayId Driveway ID
     * 
     * @return number of rows effected
     */
    function updateDriveway($data, $drivewayId, $userId)
    {
        $this->db->where('drivewayID', $drivewayId);
        $this->db->where('userID', $userId);
        $this->db->update(TBL_DRIVEWAY, $data);
        return $this->db->affected_rows();
    }

    /**
     * To get email id of User
     *
     * @param integer $senderID User ID
     *
     * @return query result
     */
    function getEmailid($senderID)
    {
        $this->db->select('emailID');
        $this->db->from(TBL_USERS);
        $this->db->where(USERID, $senderID);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To get the renter info of User
     *
     * @param integer $userID User ID
     *
     * @return query result
     */
    function renterInfo($userId, $drivewayId)
    {
        $this->db->select('tbl_driveway.building, tbl_driveway.route, tbl_driveway.streetAddress, tbl_driveway.city, tbl_driveway.state, tbl_driveway.zip, tbl_driveway.photo1,tbl_users.userName,tbl_users.firstName,tbl_users.lastName');
        $this->db->from(TBL_DRIVEWAY);
        $this->db->join('tbl_users', 'tbl_users.userID = tbl_driveway.userID', 'left');
        $this->db->where("tbl_driveway.userID", $userId);
        $this->db->where("tbl_driveway.drivewayID", $drivewayId);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To insert driveway info
     *
     * @return insert ID
     */
    function saveDriveway($data)
    {
        $this->db->insert(TBL_DRIVEWAY, $data);
        return $this->db->insert_id();
    }

    /**
     * To get the driveway info of User
     *
     * @param integer $drivewayId driveway ID
     *
     * @return query result
     */
    function getDriveway($drivewayId)
    {
        $this->db->select('*');
        $this->db->from(TBL_DRIVEWAY);
        $this->db->where("drivewayID ", $drivewayId);
        $query = $this->db->get();
        $result = $query->result();
        return $result[0];
    }

    /**
     * To Update the User Role
     *
     * @param array $userData of role and integer $userID User ID
     * 
     * @return number of rows effected
     */
    function updateUserrole($userData, $userid)
    {
        $this->db->where(USERID, $userid);
        $this->db->update('tbl_user_roles', $userData);
        return $this->db->affected_rows();
    }

    /**
     * To save email content which are not sent
     *
     * @param array $userData of role and integer $userID User ID
     * 
     * @return number of rows effected
     */
    function saveEmailStatus($data)
    {
        $this->db->insert('tbl_email_status', $data);
    }
    
    function bookedUser($userId, $bookingId){
        
        $this->db->select('bookingID');
        $this->db->from('tbl_booking');
        $this->db->where('bookingID', $bookingId);
        $this->db->where('userID', $userId);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return 1;
        } else {
            return 0;
        }
        
    }
     /**
     * Checks whether Username exists
     *
     * @param sting $username
     *            Username of User
     *            
     *            Return false if username does not exits
     *            
     *            Returns entire row if username exits
     */
    function address_exist($userId)
    {
        $sql = "select userID from tbl_users  WHERE (building  IS NULL OR building = '') AND userID =".$userId;
        $query = $this->db->query($sql);      
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

}
