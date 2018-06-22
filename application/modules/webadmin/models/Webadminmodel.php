<?php

/**
 *
 * File Name : Webadmin Model
 *
 * Description : Used to update user details
 *
 * Created By : Reshma N
 *
 * Created Date : 11/05/2016
 *
 * Last Modified By : Prajna P
 *
 * Last Modified Date : 12/07/2016
 *
 */
class Webadminmodel extends CI_model
{

    /**
     * To retrieve all users whose status is 1
     *
     * Returns response as object     
     */
    function getallUsers()
    {
        $this->db->select('u.*, ur.roleID ');
        $this->db->from('tbl_users as u');
        $this->db->join('tbl_user_roles as ur', 'u.userID = ur.userID', 'inner');
        $this->db->where('ur.roleID !=', '1');
        $this->db->where('u.status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    /**
     * To Update the users personal
     *     
     * information
     */
    function updateUser($data, $userID)
    {
        $this->db->where('userID', $userID);
        $this->db->update(TBL_USERS, $data);
        return true;
    }

    /**
     * To retrieve driveway information of spaecific user
     * 
     * Accepts userID an parameter
     *
     * Returns response as object 
     */
    function getallDriveway($userID)
    {
        $this->db->select('*');
        $this->db->from('tbl_driveway as d');
        $this->db->where('d.userID', $userID);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    /**
     *
     * To get user deatail
     *
     * Accepts userID as parameter
     *
     * @returns query result
     *
     */
    public function getUserdetail($userID)
    {
        $this->db->select('u.userID,u.userName,u.emailID,u.status , ur.roleID');
        $this->db->from('tbl_users as u');
        $this->db->join('tbl_user_roles as ur', 'u.userID = ur.userID', 'left');
        $this->db->where('u.userID', $userID);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return array();
        }
    }

    /**
     * To Update the driveway info
     *
     */
    function updateDrivewayinfo($data, $drivewayID)
    {
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->update(TBL_DRIVEWAY, $data);
        return true;
    }

    /**
     * To delete the driveway
     *
     * Accepts drivewayID  and data as parameter
     *
     */
    function deleteDriveway($data, $drivewayID)
    {
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->update(TBL_DRIVEWAY, $data);
        return true;
    }

    /**
     * To delete the user
     *
     * Accepts userID and data as parameter
     */
    function deleteUser($data, $userID)
    {
        $this->db->where('userID', $userID);
        $this->db->update(TBL_USERS, $data);
        return true;
    }

    /**
     * Checks whether Username exists
     *
     * @param sting $username
     * Username of User
     *            
     * Return false if username doesnot exits
     *            
     * Returns entire row if username exits
     */
    function checkUsername($username, $id)
    {
        $this->db->select('userID,userName,emailID');
        $this->db->from(TBL_USERS);
        $this->db->where('userName', $username);
        $this->db->where('userID != ', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * Checks whether EmailID exists
     *
     * @param sting $email
     * Email ID of User
     *            
     * Return false if email doesnot exits
     *            
     * Returns entire row if email exits
     */
    function checkEmail($email, $id)
    {
        $this->db->select('emailID');
        $this->db->from(TBL_USERS);
        $this->db->where('emailID', $email);
        $this->db->where('userID != ', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     *
     * To retrieve driveway info of specific driveway
     *
     * Accepts drivewayID as parameter
     *
     * @returns query result
     *
     */
    public function getDrivewayinfo($drivewayID)
    {
        $this->db->select('d.drivewayID, d.userID, d.photo1, d.photo2, d.photo3, d.photo4, d.building, d.route, d.streetAddress, d.city, d.state, d.zip');
        $this->db->from('tbl_driveway as d');
        $this->db->where('d.drivewayID', $drivewayID);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return array();
        }
    }

    /**
     *
     * To retrieve user deatil 
     *
     * Accepts userID as parameter
     *
     * @returns query result
     *
     */
    function getUser($userID)
    {
        $sql = "SELECT u.userID,u.userName,u.userCode,u.emailID,u.status, u.profileImage, ur.roleID
                FROM tbl_users u
                INNER JOIN tbl_user_roles ur
                ON u.userID=ur.userID
                WHERE u.userID = ?";
        $query = $this->db->query($sql, array($userID));
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     *
     * To retrieve driveways which are not verified 
     *
     * @returns query result
     *
     */
    function getDriveways()
    {
        $sql = "SELECT d.drivewayID, d.building, d.route, d.streetAddress, d.city, d.state, d.zip, d.photo1, d.photo2, d.photo3,
                d.photo4, d.description, d.instructions, d.price, d.slot, d.dailyprice, u.userID,u.userName
                FROM tbl_driveway d
                LEFT JOIN tbl_users u
                ON d.userID=u.userID
                WHERE d.verificationCode = ''";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To delete the driveway
     *
     * Accepts drivewayID  and data as parameter
     *
     */
    function saveVerification($drivewayID, $data)
    {
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->update(TBL_DRIVEWAY, $data);
        return true;
    }

    /**
     * to get all feedback of specific driveway
     *
     * @param sting $drivewayID
     * ID of particular driveway
     *            
     * Return false doesnot exits
     *            
     * Returns entire row if exits
     */
    function getFeedback($drivewayID)
    {
        $this->db->select('r.reviewID,r.comments,r.userID,r.title,r.approvedStatus,u.userName,u.firstName,u.lastName,rt.ratingsID,rt.rating');
        $this->db->from('tbl_review r');
        $this->db->join('tbl_users u', 'u.userID = r.userID', 'left');
        $this->db->join('tbl_rating rt', 'rt.reviewID = r.reviewID', 'left');
        $this->db->where('r.drivewayID = ', $drivewayID);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To get count feedbacks to be reviewd
     *
     * Accepts drivewayID as parameter
     *
     * @return query result
     */
    function getfeedbackCount()
    {
        $sql = "SELECT count(r.reviewID) AS feedbackcount,d.userID FROM tbl_review r left join tbl_driveway d on d.drivewayID = r.drivewayID  WHERE  r.approvedStatus != 1 group by r.drivewayID";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    /**
     * To get count feedbacks to be reviewd
     *
     * Accepts drivewayID as parameter
     *
     * @return query result
     */
    function getreviewCount($userID)
    {
        $sql = "SELECT count(r.reviewID) AS feedbackcount,d.drivewayID FROM tbl_review r left join tbl_driveway d on d.drivewayID = r.drivewayID WHERE  r.approvedStatus != 1 AND d.userID = '" . $userID . "' group by r.drivewayID";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    /**
     * To delete the driveway
     *
     * Accepts drivewayID  and data as parameter
     *
     */
    function approveFeedback($data, $reviewID)
    {
        $this->db->where('reviewID', $reviewID);
        $this->db->update('tbl_review', $data);

        $this->db->where('reviewID', $reviewID);
        $this->db->update('tbl_rating', $data);
        return true;
    }

    /**
     * Checks whether EmailID exists
     *
     * @param sting $email
     * Email ID of User
     *            
     * Return false if email doesnot exits
     *            
     * Returns entire row if email exits
     */
    function getSettings()
    {
        $this->db->select('*');
        $this->db->from('tbl_constants');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * To delete the driveway
     *
     * Accepts drivewayID  and data as parameter
     *
     */
    function updateSettings($data)
    {
        $this->db->where('constant_id', 1);
        $this->db->update('tbl_constants', $data);
        return true;
    }

    /**
     * To get count of driveways to be verified
     *
     * @return query result
     */
    function getverifyCount()
    {
        $sql = "SELECT count(d.drivewayID) as verifycount
                FROM tbl_driveway d
                LEFT JOIN tbl_users u
                ON d.userID=u.userID
                WHERE d.verificationCode = ''";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

}
