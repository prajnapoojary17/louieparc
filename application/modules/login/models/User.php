<?php

/**
 *    Model class to manage the user
 *
 *    @author Glowtouch Technologies
 *
 */
class User extends CI_model
{

    /**
     *
     * To check whether username and email Id exists
     *
     * Accepts username and password as parameter
     *
     * @returns query result
     *
     */
    function login($username, $password)
    {
        $pass = md5($password);
        $sql = "SELECT u.userID,u.userName,u.userCode,u.emailID,u.status ,u.profileImage, ur.roleID
                FROM tbl_users u     
            INNER JOIN tbl_user_roles ur
            ON u.userID=ur.userID                
                WHERE (u.userName = ? OR u.emailID = ?)
                AND u.userCode= ?
                ";

        $query = $this->db->query($sql, array($username, $username, $pass));
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     *
     * To get the status of user
     *
     * Accepts userId as parameter
     *
     * @returns query result
     *
     */
    function get_status($userId)
    {
        $query_str = "SELECT roleID FROM tbl_user_roles 
                      WHERE tbl_user_roles.userID='" . $userId . "'";
        $query = $this->db->query($query_str);
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0];
        } else if ($query->num_rows() == 2) {
            $result->roleID = 4;
            return $result;
        }
    }

    /**
     *
     * To get the user info when email is known
     *
     * Accepts email as parameter
     *
     * @returns query result
     *
     */
    public function get_user_by_email_password($email)
    {
        $this->db->select('userID,emailID');
        $this->db->from(TBL_USERS);
        $this->db->where('emailID', $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     *
     * To get the user info when email is known
     *
     * Accepts email as parameter
     *
     * @returns query result
     *
     */
    public function get_user_by_email($email)
    {
        $this->db->select('userID,emailID');
        $this->db->from(TBL_USERS);
        $this->db->where('emailID', $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    /**
     *
     * To get the user info of individual user
     *
     * Accepts userId as parameter
     *
     * @returns query result
     *
     */
    public function userchck($userid)
    {
        $this->db->select('userID,emailID');
        $this->db->from(TBL_USERS);
        $this->db->where('userID', $userid);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    /**
     *
     * To reset the password
     *
     * Accepts userId and password as parameter
     *
     */
    public function reset_password($userid, $password)
    {
        $data = array(
            'userCode' => md5($password)
                )
        ;
        $this->db->where('userID', $userid);
        $this->db->update(TBL_USERS, $data);
    }

    /**
     *
     * Email configuration for sending email
     *
     */
    public function send_mail($from, $to, $subject, $message)
    {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.glowtouch.com',
            'smtp_port' => 25,
            'smtp_user' => FROM_EMAIL,
            'smtp_pass' => 'glowtouch',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

}
