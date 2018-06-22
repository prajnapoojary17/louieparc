<?php

/**
 *
 * File Name : Dashboard Model
 *
 * Description : Used to update details of Logged in user
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
Class Dashboardmodel extends CI_model
{

    /**
     *
     * To Verify the Email
     *
     * Accepts verificationcode and UserID as parameter
     *
     * @returns query result
     *
     */
    public function verifyEmailAddress($verificationcode, $userID)
    {
        $data = array(
            VERIFICATION_STATUS => 1
        );
        $this->db->where(USERID, $userID);
        $this->db->where('verificationCode like binary "' . $verificationcode . '"');
        $this->db->update('tbl_users', $data);
        return $this->db->affected_rows();
    }

    /**
     *
     * To Verify the Email
     *
     * Accepts verificationcode and UserID as parameter
     *
     * @returns query result
     *
     */
    public function verifyDriveway($verificationText, $drivewayID, $userID)
    {
        $data = array(
            VERIFICATION_STATUS => 1
        );
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->where(USERID, $userID);
        $this->db->where('verificationCode like binary "' . $verificationText . '"');
        $this->db->update(TBL_DRIVEWAY, $data);
        return $this->db->affected_rows();
    }

    /**
     *
     * To retrieve the user Bank info
     *
     * Accepts UserID as parameter
     *
     * @returns query result
     *
     */
    public function getUserBankInfo($userId)
    {
        $this->db->select('u.userID,u.accID,u.bankAccID,u.acFirstName,u.acLastName,u.accHolderType,u.status,u.accountID');
        $this->db->from('tbl_account_detail as u');
        $this->db->where(USERID, $userId);
        $this->db->order_by(STATUS, "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    /**
     *
     * To retrieve the user Bank info
     *
     * Accepts UserID as parameter
     *
     * @returns query result
     *
     */
    public function getUserCardInfo($userId)
    {
        $this->db->select('u.userID,u.billID,u.expiration_month,u.expiration_year,u.name_on_card');
        $this->db->from('tbl_billing_detail as u');
        $this->db->where(USERID, $userId);
        $this->db->where(STATUS, 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    /**
     *
     * To update the users Bank info
     *
     * Accepts accountID and UserID as parameter
     *
     * @returns query result
     *
     */
    public function updateAccount($accountID, $userID)
    {
        $sql = "UPDATE  tbl_account_detail SET status= '1' WHERE accountID=" . $accountID;
        $this->db->query($sql);
        $sql2 = "UPDATE  tbl_account_detail SET status= '0' WHERE userID=" . $userID . " AND accountID!=" . $accountID;
        $this->db->query($sql2);
    }

    /**
     *
     * To delete the users card info
     *
     * Accepts billID and UserID as parameter
     *
     * @returns query result
     *
     */
    public function deleteCard($billID, $userID)
    {
        $sql = "UPDATE tbl_billing_detail SET status= '0' WHERE billID = " . $billID .' AND userID = '.$userID ;       
        $this->db->query($sql);
        return true;
    }

    /**
     *
     * To check whether Account details exists for particular 
     *
     * Accepts accountID and UserID as parameter
     *
     * @returns query result
     *
     */
    function checkAccountExist($userId)
    {
        $this->db->select(USERID);
        $this->db->from('tbl_account_detail');
        $this->db->where(USERID, $userId);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * To check whether Account is verified for particular user
     *
     * Accepts  UserID as parameter
     *
     * @returns query result
     *
     */
    function checkAccountVerify($userId)
    {
        $this->db->select(USERID);
        $this->db->from('tbl_users');
        $this->db->where(USERID, $userId);
        $this->db->where(VERIFICATION_STATUS, '1');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     *
     * To check whether card details exists for particular user
     *
     * Accepts accountID and UserID as parameter
     *
     * @returns query result
     *
     */
    function checkCardExist($userId)
    {
        $this->db->select(USERID);
        $this->db->from('tbl_billing_detail');
        $this->db->where(USERID, $userId);
        $this->db->where(STATUS, 1);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * To check whether driveway is verified by admin
     *
     * Accepts drivewayID as parameter
     *
     * @returns query result
     *
     */
    function checkadminVerification($drivewayID)
    {
        $this->db->select('verificationCode');
        $this->db->from(TBL_DRIVEWAY);
        $this->db->where(DRIVEWAYID, $drivewayID);
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     *
     * To check whether driveway is verified by admin
     *
     * Accepts drivewayID as parameter
     *
     * @returns query result
     *
     */
    function checkdrivewayVerification($drivewayID)
    {
        $this->db->select(VERIFICATION_STATUS);
        $this->db->from(TBL_DRIVEWAY);
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->where(VERIFICATION_STATUS, '1');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return 1;
        } else {
            return 0;
        }
    }

}
