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
Class Drivewaydbmodel extends CI_model
{

    /**
     * To count total visitors per hour
     *    
     * @param array $data Array
     *
     * @return query result
     */
    function visitCount($data)
    {
        $sql = "INSERT INTO tbl_driveway_views (drivewayID, views,fromDate) VALUES ( " . $data[DRIVEWAYID] . ", 1,'" . $data[FROM_DATE] . "')";
        $this->db->query($sql);
        $sql_history = "INSERT INTO  tbl_driveway_views_history (drivewayID, views) VALUES ( " . $data[DRIVEWAYID] . ", 1) ON DUPLICATE KEY UPDATE views=views+1";
        $this->db->query($sql_history);
        $sql2 = "SELECT DATE(viewTime) AS Day, HOUR(TIME(viewTime)) AS Hour, fromDate, COUNT(*) as totalViews
                FROM tbl_driveway_views 
                WHERE DATE_FORMAT(viewTime, '%Y-%m-%d') = CURDATE()
                AND fromDate >= CURDATE() AND fromDate = '" . $data[FROM_DATE] . "'
                AND drivewayID= " . $data[DRIVEWAYID] . " GROUP BY DATE(fromDate)";
        $query = $this->db->query($sql2);
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Function to get driveway price
     * 
     * @param integer $drivewayID Driveway ID
     * 
     * @return query result   
     */
    function getPrice($drivewayID)
    {
        $this->db->select('drv.price,drv.dailyprice');
        $this->db->from('tbl_driveway as drv');
        $this->db->where(DRIVEWAYID, $drivewayID);
        $this->db->where("drivewayStatus !=", 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * Function to save updated price
     * 
     * @param integer $drivCount Driveway count
     *
     */
    function updatedPrice($drivCount)
    {
        $this->db->insert('tbl_driveway_views_update', array(DRIVEWAYID => $drivCount[DRIVEWAYID],
            'dPrice' => $drivCount['newPrice'],
            'ddailyPrice' => $drivCount['ddailyPrice'],
            FROM_DATE => $drivCount[FROM_DATE]));
    }

    /**
     * Function to delete two hours old view records
     *
     */
    function deleteCount()
    {
        $sql = "DELETE FROM tbl_driveway_views
                WHERE viewTime < (NOW() - INTERVAL 2 HOUR)";
        $this->db->query($sql);
    }

}
