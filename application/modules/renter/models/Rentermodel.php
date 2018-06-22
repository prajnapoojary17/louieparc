<?php

/**
 * Model class to manage the Renter
 *
 * @author     Reshma N
 *
 */
Class Rentermodel extends CI_model
{

    /**
     * To get information of individual Renter
     * 
     * @param $userId 'Integer' User ID
     */
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
