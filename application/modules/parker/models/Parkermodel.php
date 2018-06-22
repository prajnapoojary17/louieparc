<?php

/**
 * Model class to manage the Parker
 *
 * @author     Reshma N
 *
 */
Class Parkermodel extends CI_model
{

    function getUser($userId)
    {
        $this->db->select('*');
        $this->db->from(' tbl_users');
        $this->db->where("userID", $userId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return FALSE;
        }
    }

}
