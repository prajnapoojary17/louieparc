<?php

/**
 * Model class to manage the User management
 *
 * @author     Reshma N
 *
 */
class Usermanagementmodel extends CI_model
{

    /**
     * Save Sign Up data
     *
     * If existing User, then we should update the tbl_users table.
     *
     * If new User, then we should insert to tbl_users table and get last inserted ID.
     *
     * @param array $data_u
     *            values to be inserted to tbl_users table
     *            
     * @param array $data_v
     *            values to be inserted to tbl_vehicle_type table
     *            
     * @param array $data_r
     *            values to be inserted to tbl_user_roles table
     *            
     * @param array $data_d
     *            values to be inserted to tbl_driveway table
     */
    function saveRenter($data)
    {
        $this->db->insert(TBL_USERS, $data ['data_u']);
        $last_id = $this->db->insert_id();
        foreach ($data ['data_r'] as $key => $value) {
            $roles [$key] = $value;
        }
        $roles [USERID] = $last_id;
        $this->db->insert("tbl_user_roles", $roles);
        foreach ($data ['data_d'] as $key => $value) {
            $driveway [$key] = $value;
        }
        $driveway [USERID] = $last_id;
        $driveway ['drivewayStatus'] = 0;
        $this->db->insert("tbl_driveway", $driveway);
        if (isset($data [DATA_B])) {
            foreach ($data [DATA_B] as $key => $value) {
                $billing [$key] = $value;
            }
            $billing [USERID] = $last_id;
            $this->db->insert("tbl_account_detail", $billing);
        }
        return $last_id;
    }

    /**
     * Save Sign Up data
     *
     * If existing User, then we should update the tbl_users table.
     *
     * If new User, then we should insert to tbl_users table and get last inserted ID.
     *
     * @param array $data_u
     *            values to be inserted to tbl_users table
     *            
     * @param array $data_v
     *            values to be inserted to tbl_vehicle_type table
     *            
     * @param array $data_r
     *            values to be inserted to tbl_user_roles table
     *            
     * @param array $data_d
     *            values to be inserted to tbl_driveway table
     */
    function saveParker($data)
    {
        $this->db->insert(TBL_USERS, $data ['data_u']);
        $last_id = $this->db->insert_id();
        foreach ($data ['data_r'] as $key => $value) {
            $roles [$key] = $value;
        }
        $roles [USERID] = $last_id;
        $this->db->insert("tbl_user_roles", $roles);
        if (isset($data ['data_v'])) {
            foreach ($data ['data_v'] as $key => $value) {
                $vehicle [$key] = $value;
            }
            $vehicle [USERID] = $last_id;
            $this->db->insert("tbl_vehicle_type", $vehicle);
        }
        if (isset($data [DATA_B])) {
            foreach ($data [DATA_B] as $key => $value) {
                $billing [$key] = $value;
            }
            $billing [USERID] = $last_id;
            $this->db->insert("tbl_billing_detail", $billing);
        }
        return $last_id;
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
    function username_exist($username)
    {
        $this->db->select('userID,userName,userCode,emailID,phone,status');
        $this->db->from(TBL_USERS);
        $this->db->where('userName', $username);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Checks whether Email Id exists
     *
     * @param sting $username
     *            Username of User
     *            
     *            Return false if username doesnot exits
     *            
     *            Returns entire row if username exits
     */
    function email_exist($email)
    {
        $this->db->select(EMAIL_ID);
        $this->db->from(TBL_USERS);
        $this->db->where(EMAIL_ID, $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Checks whether Email Id exists for facebook login
     *
     * @param sting $username
     *            Username of User
     *            
     *            Return false if username doesnot exits
     *            
     *            Returns entire row if username exits
     */
    function fb_email_exist($email)
    {
        $this->db->select('userID,emailID');
        $this->db->from(TBL_USERS);
        $this->db->where(EMAIL_ID, $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    function getUserInfo($userId)
    {
        $query = "SELECT u.userID,u.userName,u.emailID,u.status ,u.profileImage,u.verificationCode, ur.roleID
                FROM tbl_users u     
            LEFT JOIN tbl_user_roles ur
            ON u.userID=ur.userID                
                WHERE (u.userID='" . $userId . "')";
        $query = $this->db->query($query);
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function getUser($userId)
    {
        $this->db->select('*');
        $this->db->from(TBL_USERS);
        $this->db->where(USERID, $userId);
        $this->db->order_by(USERID, "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

    function getRenterInfo($userId, $bookingId)
    {
        $query = "SELECT u.userID,u.userName,u.firstName, u.lastName, u.emailID,u.phone , u.building,u.streetAddress, u.route,u.city,u.state,u.zip,ur.totalPrice
                FROM tbl_users u     
                LEFT JOIN tbl_booking ur
                ON ur.bookingID = '" . $bookingId . "' AND ur.bookingStatus = 0 WHERE (u.userID='" . $userId . "')";
        $query = $this->db->query($query);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

    function deleteUser($userId)
    {
        $this->db->where(USERID, $userId);
        $this->db->update(TBL_USERS, array(
            'status' => 0
        ));
    }

    public function reset_password($userid, $password)
    {
        $data = array(
            'userCode' => md5($password)
        );
        $this->db->where(USERID, $userid);
        $this->db->update(TBL_USERS, $data);
    }

    function checkPass($password, $userId)
    {
        $pass = md5($password);
        $this->db->select('userID,emailID');
        $this->db->from(TBL_USERS);
        $this->db->where('userCode', $pass);
        $this->db->where(USERID, $userId);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Checks whether Driveway address exists
     *
     * @param sting $address
     *            Username of User
     *            
     *            Return false if address doesnot exits
     *            
     *            Returns entire row if address exits
     */
    function driveway_exist($address)
    {
        $this->db->select('drivewayID,userID');
        $this->db->from('tbl_driveway');
        $this->db->where('streetAddress', $address ['street']);
        $this->db->where('route', $address ['route']);
        $this->db->where('city', $address ['city']);
        $this->db->where('state', $address ['state']);
        $this->db->where('zip', $address ['zip']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * To retrieve driveways
     *
     * @param integer $userID User ID
     *
     * @return query result
     */
    function getDriveway($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_driveway as drv');
        $this->db->where(USERID, $userId);
        $this->db->order_by("drivewayID", "desc");
        $query = $this->db->get();
        $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To save stripe bank token deatils
     *
     * @param array $billing array containing values
     *
     */
    function saveBankToken($billing)
    {
        $this->db->insert("tbl_account_detail", $billing);
    }

    /**
     * To remove the profile Image
     *
     * @param integer $userId User ID
     *
     * @return true or false
     */
    function removeProfileimg($userId)
    {
        $this->db->select(PROFILE_IMAGE);
        $this->db->from(TBL_USERS);
        $this->db->where(USERID, $userId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            unlink(FCPATH . "assets/uploads/profilephoto/" . $result[0][PROFILE_IMAGE]);
            $data = array(
                PROFILE_IMAGE => 0
            );
            $this->db->where(USERID, $userId);
            $this->db->update(TBL_USERS, $data);
            return true;
        } else {
            return false;
        }
    }

    /**
     * To retrieve driveways
     *
     * @param integer $drivewayId Driveway ID
     *
     * @return query result
     */
    function getDrivewayinfo($drivewayId)
    {
        $this->db->select('*');
        $this->db->from('tbl_driveway as drv');
        $this->db->where("drivewayID ", $drivewayId);
        $query = $this->db->get();
        $this->db->last_query();
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
     * @param integer $userId User ID
     *
     * @return query result
     */
    function getDrivewayAddress($userId)
    {
        $this->db->select('*');
        $this->db->from('tbl_driveway as drv');
        $this->db->where("userID ", $userId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

}
