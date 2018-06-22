<?php

/**
 *
 * File Name : Login Model
 *
 * Description : Used to handle login process of admin
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
class Loginmodel extends CI_model
{

    /**
     * To check user name and password during login
     * 
     * Accepts username password as parameter
     * 
     * @return query result
     */
    function login($username, $password)
    {
        $pass = md5($password);
        $sql = "SELECT u.userID,u.userName,u.userCode,u.emailID,u.status, ur.roleID
                FROM tbl_users u
                INNER JOIN tbl_user_roles ur
                ON u.userID=ur.userID
                WHERE (u.userName = ? OR u.emailID = ?)
                AND u.userCode= ?
                AND ur.roleID = 1
                GROUP BY u.emailID";

        $query = $this->db->query($sql, array($username, $username, $pass));
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * To get user details when email is given
     * 
     * Accepts emailID as parameter
     * 
     * @return query result
     */
    public function get_user_by_email($email)
    {
        $sql = "SELECT u.userID,u.emailID
                FROM tbl_users u     
                INNER JOIN tbl_user_roles ur
                ON u.userID=ur.userID
                WHERE u.emailID = ?
                AND ur.roleID = 1
                GROUP BY u.emailID";
        $query = $this->db->query($sql, array($email));
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * To check whether user exists
     * 
     * Accepts userID as parameter
     * 
     * @return query result if user exists
     */
    public function userchck($userid)
    {
        $this->db->select('userID,emailID');
        $this->db->from('tbl_users');
        $this->db->where('userID', $userid);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     * To reset password of admin user
     * 
     * Accepts userID and password as parameter
     *  
     */
    public function reset_password($userid, $password)
    {
        $data = array(
            'userCode' => md5($password)
        );
        $this->db->where('userID', $userid);
        $this->db->update('tbl_users', $data);
    }

}
