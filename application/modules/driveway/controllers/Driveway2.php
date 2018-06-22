<?php
/**
 * Driveway Controller
 *
 * Handles driveway page
 * 
 * 
 * @author Glowtouch Technologies
 * 
 */ 
if (! defined ( 'BASEPATH' )) {
    exit ( 'No direct script access allowed' );
}
class Driveway extends MY_Controller 
{
    var $fromDateDrv;    
    function __construct()
    {
        $this->module = "driveway";
        $this->load->model('drivewaymodel');
        parent::__construct();        
    }      
       
    public function index()
    {
        $data['locations'] = $this->drivewaymodel->getDriveways();        
        $this->_tpl('Home',$data);
    }
        
    /**
    * To get all driveways
    *
    */
    public function searchDriveway()
    {         
        
        $rangeprice = $this->input->post('rangeprice', TRUE);
        $type = $this->input->post('option', TRUE); // 1 - continuous / 2 - recurring
        
        if($rangeprice == 1){
            $minprice     = 0;
            $maxprice     = 10;              
        } else if($rangeprice == 2){
            $minprice   = 11;
            $maxprice   = 20;    
        } else if($rangeprice == 3){
            $minprice   = 21;
            $maxprice   = 150;    
        } else if($rangeprice == ''){
            $minprice   = 0;
            $maxprice   = 150;          
        }
        
        $centerlat = $this->input->post('centerlat', TRUE);
        $centerlong = $this->input->post('centerlong', TRUE);
        $search_zone = $this->get_nearest_timezone($centerlat, $centerlong) ;
        $this->session->set_userdata('search_zone',$search_zone);
        $userInfo = $this->session->userdata ( 'logged_in' );
        $userId = $userInfo ['user_id'];
        
        date_default_timezone_set($search_zone); //search location time
        
        $frmdate = $this->input->post('fromdate', TRUE);
        $tdate = $this->input->post('todate', TRUE);        
        $fromdate = date("Y-m-d", strtotime($frmdate));
        $todate   = date("Y-m-d", strtotime($tdate));        
        $datef = new DateTime($this->input->post('fromdate', TRUE));        
        $datet = new DateTime($this->input->post('todate', TRUE));
        $timef = new DateTime($this->input->post ( 'fromtime', TRUE )); 
        $timet = new DateTime($this->input->post ( 'totime', TRUE ));        
        $bookingFrom= new DateTime($fromdate .' ' .$timef->format(TIME_FORMAT));
        $bookingTo= new DateTime($todate .' ' .$timef->format(TIME_FORMAT));
        
        $reindexed_array    = array();
        $drivewaysdisplay   = array();
        $drivewaybooking    = array();
        $availableDriveways = array();
        $drivewayArray      = array();
        $slot                = array();
        
        $con=mysqli_connect("192.168.12.210","louiparkwebapp","j698hjgd85","louiparkwebapp");        
        $dPrice = "";
        $drivewayPrice="";        
        if($type==3){
            $dPrice= 'ddailyPrice';
            $drivewayPrice = 'dailyprice';
            
        }else{
            $dPrice = 'dPrice';
            $drivewayPrice = 'price';
        }        

        $sql="SELECT DISTINCT b.drivewayID,userID,slot ,b.building,b.route,b.streetAddress,b.city,b.state,b.zip,b.latitude,b.longitude,b.price,b.dailyprice,Max(".$dPrice.") AS dPrice,bb.fromDate AS froma ,

        (
        6371 *
        acos(
        cos( radians( ".$centerlat." ) ) *
        cos( radians( latitude ) ) *
        cos(
        radians( longitude ) - radians(  ".$centerlong." )
        ) +
        sin(radians(".$centerlat.")) *
        sin(radians(latitude))
        )
        ) distance
        FROM
        tbl_driveway b
        LEFT JOIN tbl_driveway_views_update AS bb 
             ON b.drivewayID =bb.drivewayID AND bb.fromdate=  '".$fromdate."'
        WHERE drivewayStatus = 1 
        GROUP BY b.drivewayid
        HAVING
        distance < ".DRIVEWAY_DISTANCE." and ((dPrice BETWEEN '".$minprice."' AND '".$maxprice."' ) OR ((b.".$drivewayPrice." BETWEEN '".$minprice."' AND '".$maxprice."' ) AND ISNULL(dPrice)=1))
        ORDER BY distance
        ";        
        $query = $this->db->query($sql);        

        if($query -> num_rows() > 0)
        {
            $results =  $query->result_array();
            foreach( $results as $result )
            {        
                $drivewayArray[$result['drivewayID']] = $result;
                $slot[$result['drivewayID']]=$result['slot'];
                $drvInfo = $this->drivewaymodel->getDrivewayZone($result['drivewayID']);               
                $drivewayTZ = new DateTimeZone($drvInfo->timeZone);
                $fromdateget = new DateTime($datef->format(DATE_FORMAT) .' ' .$timef->format(TIME_FORMAT));
                $fromdateget->setTimezone($drivewayTZ);
                $todateget = new DateTime($datet->format(DATE_FORMAT) .' ' .$timet->format(TIME_FORMAT));
                $todateget->setTimezone($drivewayTZ);
                
                $fromdatevalue= $fromdateget->format(DATE_TIME);
                $todatevalue= $todateget->format(DATE_TIME);
                $fromtimeonly=$fromdateget->format(TIME_FORMAT);
                $totimeonly=$todateget->format(TIME_FORMAT);

                $dateArrayrange = $this->createDateRangeArray($fromdatevalue, $todatevalue);        
                $driveways=array();    
            
                $sqldate="Select * from tbl_driveway_date_settings where status=1 and driveway_id=".$result['drivewayID'];
            
                $resultdate = $con->query($sqldate);
                if ($resultdate->num_rows> 0) 
                {             
                    $sqldate="Select * from tbl_driveway_date_settings where status=1 and driveway_id=".$result['drivewayID']." and start_date<='$fromdatevalue' and end_date>='$todatevalue'";                
                    $resultdate = $con->query($sqldate);                
                    if ($resultdate->num_rows == 0) 
                    { 
                        continue;
                    }
                }
            
                $sqldate="Select * from tbl_driveway_day_settings where status=1 and driveway_id=".$result['drivewayID'];    
                $resultdate = $con->query($sqldate);

                if ($resultdate->num_rows> 0) 
                {
                    for($i=0;$i<count($dateArrayrange);$i++)
                    {
                
                        $weekday=date("w",strtotime($dateArrayrange[$i]));
                        if($weekday>1 && $weekday<5)
                        {
                            $weekday=1;
                        }                
                        $sqltime="Select * from tbl_driveway_day_settings where driveway_id=".$result['drivewayID']." and status=1 and day_option=".$weekday;                
                        $resulttime = $con->query($sqltime);
                    
                        if ($resulttime->num_rows > 0) 
                        {                        
                        
                            while($rowtime = $resulttime->fetch_assoc()) 
                            {
                                $fromtime=$rowtime["from"];
                                $totime=$rowtime["to"];
                                if($fromtime=="00:00:00")
                                {
                                    $fromtime="";
                        
                                }
                                if($totime=="00:00:00")
                                {
                                    $totime="";
                        
                                }
                                if(count($dateArrayrange)=="1")//only one day in search
                                {                            
                        
                                    if((strtotime($dateArrayrange[$i]."".$fromtime)<=strtotime($fromdatevalue) || $fromtime=="") &&  (strtotime($dateArrayrange[$i]."".$totime)>=strtotime($todatevalue) || $totime==""))
                                    {                                
                                        $driveways[]=$result['drivewayID'];                                
                                    }
                                }
                                else //multi date range
                                {
                            
                                    //for continuous
                                    //start
                                
                                    if($type=="1")
                                    {
                                        $date1 = $fromdate;
                                        $date2 = $todate;
                                        $diff = strtotime($date2) - strtotime($date1);
                                        $diff_in_hrs = $diff/3600;
                                        $hourcharge[$result['drivewayID']]= number_format($diff_in_hrs,2);                                 
                                        if($i==0)
                                        {
                                            if(strtotime($dateArrayrange[$i]."".$fromtime)<=strtotime($fromdatevalue) || $fromtime=="")
                                            {                                    
                                                $driveways[]=$result['drivewayID'];                                    
                                            }
                                    
                                        }
                                        else if($i==count($dateArrayrange)-1)
                                        {
                                    
                                            if(strtotime($dateArrayrange[$i]."".$totime)>=strtotime($todatevalue) || $totime=="")
                                            {                                        
                                                $driveways[]=$result['drivewayID'];                                    
                                            }                                    
                                        }
                                        else
                                        {                                    
                                            if($fromtime=="" && $totime=="")
                                            {
                                        
                                                $driveways[]=$result['drivewayID'];
                                            }                                    
                                        }
                            
                                    }
                                //end else recurring
                                    else
                                    {
                                    
                                        if((strtotime($dateArrayrange[$i]."".$fromtime)<=strtotime($dateArrayrange[$i]."".$fromtimeonly) || $fromtime=="") && (strtotime($dateArrayrange[$i]."".$totime)>=strtotime($dateArrayrange[$i]."".$totimeonly) || $totime==""))
                                        {
                                            $driveways[]=$result['drivewayID'];
                                    
                                        }
                                
                                    }
                                
                                }
                            
                            }
                        
                        }
                    
                    }
                }
                else
                {
            
                    $drivewaysdisplay[]=$result['drivewayID'];
                }    
            
                if(count($driveways)>0 && (count($dateArrayrange)==count($driveways)))
                {
                    array_push($drivewaysdisplay,$result['drivewayID']);
                }
                    
            }
        }    

        //Convert Search From and To date to UTC    
        //Write code for changing the search from and to time to UTC
        //date_default_timezone_set($search_zone); //search location time
        $datef = new DateTime($this->input->post('fromdate', TRUE));
        $timef = new DateTime($this->input->post ( 'fromtime', TRUE ));        
        $datet = new DateTime($this->input->post('todate', TRUE));
        $timet = new DateTime($this->input->post ( 'totime', TRUE )); 

        $datefrom = new DateTime($datef->format(DATE_FORMAT) .' ' .$timef->format(TIME_FORMAT) , new DateTimeZone($search_zone));
        $datefrom->setTimezone(new DateTimeZone(UTC));
        $bookingFrom= $datefrom->format(DATE_TIME); 
        $bookingFromOnly=$datefrom->format(DATE_FORMAT);
        $bookingFromTimeOnly=$datefrom->format(TIME_FORMAT);

        $dateto = new DateTime($datet->format(DATE_FORMAT) .' ' .$timet->format(TIME_FORMAT) , new DateTimeZone($search_zone));
        $dateto->setTimezone(new DateTimeZone(UTC));
        $bookingTo= $dateto->format(DATE_TIME);
        $bookingToOnly=$dateto->format(DATE_FORMAT);
        $bookingToTimeOnly=$dateto->format(TIME_FORMAT);

        $currentTime =   new DateTime(date("Y-m-d H:i:s") );
        $currentTime->setTimezone(new DateTimeZone(UTC));
        $nowTime = $currentTime->format(DATE_TIME);
        
        $daterangesearch= $this->createDateRangeArray($bookingFromOnly,$bookingToOnly);    
        $bookingtype=array();
        $hourcharge=array();
		
        if(count($drivewaysdisplay)>0 )
        {      
            for($a=0;$a<count($drivewaysdisplay);$a++)
            {
                $sql="select * from tbl_booking where drivewayID=".$drivewaysdisplay[$a];
                $sql.=" and (('$bookingFrom'>=fromdate and '$bookingFrom'<=todate) ";
                $sql.="or ('$bookingFrom'<=fromdate and '$bookingTo'>=todate)";
                $sql.=" or ('$bookingTo'>=fromdate and '$bookingTo'<=todate)";
                $sql.=" or ('$bookingFrom'<=fromdate and '$bookingTo'<=todate and '$bookingTo'>=fromdate)) AND (bookingStatus=1 or ((UnlockTime > '".$nowTime." ' AND bookingStatus=2 AND userID NOT IN ('".$userId."')  ) ) )";    
                $resultfinal = $con->query($sql);    

                if ($resultfinal->num_rows > 0) 
                {
                    $drivewaycountforslot=array();
                    while($row = $resultfinal->fetch_assoc()) 
                    {
                    
                        $booking_id=$row["bookingID"];
                        $hour=0;    
                        if($type=="1")
                        {                            
                            $drivewaybooking[]=$drivewaysdisplay[$a];
                            $diff =strtotime($bookingTo) - strtotime($bookingFrom);
                            $diff_in_hrs = $diff/3600;
                            $hourcharge[$row["drivewayID"]]=number_format($diff_in_hrs,2);
                            $bookingtype[$row["drivewayID"]]="1";
                            $drivewaycountforslot[]=$drivewaysdisplay[$a];
                         
                        }
                        else if($type=="3")//for flat rate
                        {                            
                            $drivewaybooking[]=$drivewaysdisplay[$a];
                            $diff = round(abs(strtotime($bookingToOnly)-strtotime($bookingFromOnly))/86400)+1;//strtotime($bookingToOnly) - 
                            $bookingtype[$row["drivewayID"]]="3";
                            $hourcharge[$row["drivewayID"]]=$diff;//no of day for flat rate
                        }
                        else //for recurring
                        {
                            $bookingtype[$row["drivewayID"]]="2";
                            if($row["bookingType"]=="1" || $row["bookingType"]=="3")
                            {
                                $drivewaybooking[]= $row["drivewayID"];
                                $drivewaycountforslot[]= $row["drivewayID"];
                            }
                            else
                            {
                                if( strtotime($bookingFromTimeOnly)<strtotime($bookingToTimeOnly) ) //If search from time < to time Ex: 10:00 to 16:00
                                {
                                    $hour=0;
                                    $bookingexists=0;
                                    for($m=0;$m<count($daterangesearch);$m++)
                                    {
                                        $startdatetime=$daterangesearch[$m]." ".$bookingFromTimeOnly;
                                        $enddatetime=$daterangesearch[$m]." ".$bookingToTimeOnly;
                                        $diff =strtotime($enddatetime) - strtotime($startdatetime);                                
                                        $diff_in_hrs = $diff/3600;                                
                                        $hour=$hour+$diff_in_hrs;
                                        $hour = number_format($hour,2);
                                    
                                        $sqlbooking="Select * from tbl_booking_date where booking_id=".$booking_id." and (('$startdatetime'>=start_date and '$startdatetime'<=end_date) or ('$startdatetime'<=start_date and '$enddatetime'>=end_date) or ('$enddatetime'>=start_date and '$enddatetime'<=end_date) or ('$startdatetime'<=start_date and '$enddatetime'<=end_date and '$enddatetime'>=start_date))";                                       
                                        $resultbookingsearch = $con->query($sqlbooking);
                                        if ($resultbookingsearch->num_rows > 0) {
                                            while($rowbookingsearch = $resultbookingsearch->fetch_assoc()) {
                                                $bookingexists=1;
                                                $drivewaybooking[]= $row["drivewayID"];
                                            }                                        
                                        }
                                        
                                    }
                                    if($bookingexists)
                                    {
                                    
                                        $drivewaycountforslot[]= $row["drivewayID"];
                                    }
                                    $hourcharge[$row["drivewayID"]]=$hour;
                                }
                                else //If search from time > to time Ex: 16:00 PM to 10:00 AM //from
                                {
                                    $hour=0;
                                    $bookingexists=0;
                                    for($m=0;$m<count($daterangesearch);$m++)
                                    {
                                        $startdatetime=$daterangesearch[$m]." ".$bookingFromTimeOnly;
                                        $todate=date(DATE_FORMAT,strtotime($daterangesearch[$m]));
                                        $stop_date = date(DATE_FORMAT, strtotime($todate . ' +1 day'));
                                        $enddatetime=$stop_date." ".$bookingToTimeOnly;                            
                                        if($stop_date<=$bookingToOnly)
                                        {
                                            $diff = strtotime($enddatetime) - strtotime($startdatetime);
                                            $diff_in_hrs = $diff/3600;
                                            $hour=$hour+$diff_in_hrs;
                                            $hour = number_format($hour,2);
                                        
                                            $sqlbooking="Select * from tbl_booking_date where booking_id=".$booking_id." and (('$startdatetime'>=start_date and '$startdatetime'<=end_date) or ('$startdatetime'<=start_date and '$enddatetime'>=end_date) or ('$enddatetime'>=start_date and '$enddatetime'<=end_date) or ('$startdatetime'<=start_date and '$enddatetime'<=end_date and '$enddatetime'>=start_date))";                                    
                                        
                                            $resultbookingsearch = $con->query($sqlbooking);
                                            if ($resultbookingsearch->num_rows > 0) {
                                                while($rowbookingsearch = $resultbookingsearch->fetch_assoc()) {
                                                    $bookingexists=1;
                                                    $drivewaybooking[]=$row["drivewayID"];
                                                }                                    
                                            
                                            }
                                        
                                        }                                    
                                    
                                    }
                                    if($bookingexists)
                                    {
                                    
                                        $drivewaycountforslot[]= $row["drivewayID"];
                                    }
                                    $hourcharge[$row["drivewayID"]]=$hour;
                                                
                                }
                            }
                        }

                    
                    }                    
                    //based on slot slot calculation                
                    if(count($drivewaycountforslot)<$slot[$drivewaysdisplay[$a]])
                    {
                        if(($key = array_search($drivewaysdisplay[$a], $drivewaybooking)) !== false) 
                        {
                            unset($drivewaybooking[$key]);
                        }
                    
                    }    
                                        
                }                

                else
                {   
                    if($type=="1")
                    {
                        $diff =strtotime($bookingTo) - strtotime($bookingFrom);
                        $diff_in_hrs = $diff/3600;
                        $hourcharge[$drivewaysdisplay[$a]]=number_format($diff_in_hrs,2);
                        $bookingtype[$drivewaysdisplay[$a]]="1";                        
                    }
                    //for flat rate
                    else if($type=="3")
                    { 
               
                        $diff = abs(strtotime($bookingToOnly) - strtotime($bookingFromOnly));
                        $years = floor($diff / (365*60*60*24));
                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                        $diff = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)) + 1; 
                      //$diff = round(abs(strtotime($bookingToOnly)-strtotime($bookingFromOnly))/86400)+1;
                        $bookingtype[$drivewaysdisplay[$a]]="3";
                        //no of day for flat rate
                        $hourcharge[$drivewaysdisplay[$a]]=$diff;
                    }
                    else
                    {
                    
                        $bookingtype[$drivewaysdisplay[$a]]="2";
						//If search from time < to time Ex: 10:00 to 16:00
                        if( strtotime($fromtimeonly)<strtotime($totimeonly) )
                        {
                            $hour=0;                    
                            
                            for($m=0;$m<count($daterangesearch);$m++)
                            {
                             
                                $startdatetime=$daterangesearch[$m]." ".$bookingFromTimeOnly;
                                $enddatetime=$daterangesearch[$m]." ".$bookingToTimeOnly;
                                $diff =strtotime($enddatetime) - strtotime($startdatetime);
                                $diff_in_hrs = $diff/3600;
                               
                                $hour=$hour+$diff_in_hrs;
                                $hour = number_format($hour,2);
                                
                            }
                            $hourcharge[$drivewaysdisplay[$a]]=$hour;
                        }
                        //If search from time > to time Ex: 16:00 PM to 10:00 AM //from
                        else 
                        {
                            $hour=0;
                            for($m=0;$m<count($daterangesearch);$m++)
                            {
                                $startdatetime=$daterangesearch[$m]." ".$bookingFromTimeOnly;
                                $todate=date(DATE_FORMAT,strtotime($daterangesearch[$m]));
                                $stop_date = date(DATE_FORMAT, strtotime($todate . ' +1 day'));
                                $enddatetime=$stop_date." ".$bookingToTimeOnly;                                
                                if($stop_date<=$bookingToOnly)
                                {
                                    $diff = strtotime($enddatetime) - strtotime($startdatetime);
                                    $diff_in_hrs = $diff/3600;
                                    $hour=$hour+$diff_in_hrs;
                                    $hour = number_format($hour,2);
                                }
                            }
                            
                            $hourcharge[$drivewaysdisplay[$a]]=$hour;
                        }
                        
                    }
                    
                }                

            }
            
            $finaldriveways  = array_diff(    $drivewaysdisplay,$drivewaybooking);
            $reindexed_array = array_values(array_unique($finaldriveways));
        }
        foreach ($drivewayArray as $val) { 
            if (in_array($val['drivewayID'], $reindexed_array))
            {              
              array_push($availableDriveways,$val);
            }        
            
        }
       if($availableDriveways)
        {       
            echo json_encode(array('data' => $availableDriveways, 'hours'=>$hourcharge,'searchtype'=>$bookingtype, 'status' => 1));                   
        } 
        else 
        {
            echo json_encode(array('data' => $availableDriveways, 'hours'=>$hourcharge,'searchtype'=>$bookingtype, 'status' => 0));
        }
    
        
    }
    
    /**
     * To show driveway based on filter
     */
    
    public function showdriveway()
    {        
        $data                          = $this->input->post('id', TRUE);
        $fromDate                      = $this->input->post('fromDate', TRUE);
        $toDate                        = $this->input->post('toDate', TRUE);
        $fromTime                      = $this->input->post('fromTime', TRUE);
        $toTime                        = $this->input->post('toTime', TRUE);
        $searchtype                    = $this->input->post('searchtype', TRUE);
		$user_lat                    = $this->input->post('search_lat', TRUE);
	    $user_long                    = $this->input->post('search_long', TRUE);
		
        $drivewayInfo['drivewayID']    = $data;
        $drivewayInfo['fromDate']      = date("Y-m-d", strtotime($fromDate));
        $this->visitcount($drivewayInfo);
        $drivewayData                  = $this->drivewaymodel->getDriveway($drivewayInfo,$searchtype);
        $reviews                       = $this->drivewaymodel->getReviews($data);
        $starrating                    = $this->drivewaymodel->getRatings($data);
        $rating                        = floor($starrating->rating);
        if($starrating) {
            $response['ratings'] = $rating;
        } else {
            $response['ratings'] = 0;
        }
        if($reviews){
            $response['reviews'] = $reviews;        
        }
        else {
           $response['reviews'] = 0;        
        }
        if($drivewayData){                 
            $search_zone = $this->get_nearest_timezone($drivewayData['latitude'], $drivewayData['longitude']) ;
			$location_zone = $this->get_nearest_timezone($user_lat, $user_long) ;
            $newTZ = new DateTimeZone($search_zone);            
            $bookingFrom = new DateTime($fromDate .' ' .$fromTime , new DateTimeZone($location_zone));
            $bookingFrom->setTimezone($newTZ);
            $bookingTo = new DateTime($toDate .' ' .$toTime, new DateTimeZone($location_zone));
            $bookingTo->setTimezone($newTZ);
			
			$bookingfdatetime = $bookingFrom->format(DATE_TIME); 
			$dt = new DateTime($bookingfdatetime);
			$bookingFromdate = $dt->format('m/d/Y');
			$Fromtime = $dt->format('H:i:s');
			$bookingFromtime  = date("g:i A", strtotime($Fromtime));
			
			$bookingtdatetime = $bookingTo->format(DATE_TIME); 
			$dt = new DateTime($bookingtdatetime);
			$bookingTodate = $dt->format('m/d/Y');
			$Totime = $dt->format('H:i:s');
			$bookingTotime  = date("g:i A", strtotime($Totime));
			
            if(isset( $drivewayData['dPrice'])) {
                $price = $drivewayData['dPrice'];
            }
            else if($searchtype == 3){
                $price = $drivewayData['dailyprice'];            
            }else{
                $price = $drivewayData['price'];    
            }
            $response['driveway'] = array(
            "status" => false,
            "latitude"=> $drivewayData['latitude'],
            "longitude"=> $drivewayData['longitude'],
            "drivewayID" => $drivewayData['drivewayID'],
            "userID" => $drivewayData['userID'],
            "price" => $price,
            "description" => $drivewayData['description'],
            "instructions" => $drivewayData['instructions'],
            "photo1" => $drivewayData['photo1'],
            "photo2" => $drivewayData['photo2'],
            "photo3" => $drivewayData['photo3'],
            "photo4" => $drivewayData['photo4'],
            "userName" => $drivewayData['userName'],
            "emailID" => $drivewayData['emailID'],
            "phone" => $drivewayData['phone'],
            "building" => $drivewayData['building'],            
            "streetAddress" => $drivewayData['streetAddress'],            
            "city" => $drivewayData['city'],
            "state" => $drivewayData['state'],
            "zip" => $drivewayData['zip'],
            "dbuilding" => $drivewayData['dbuilding'],
            "droute" => $drivewayData['droute'],
            "dstreetAddress" => $drivewayData['dstreetAddress'],            
            "dcity" => $drivewayData['dcity'],
            "dstate" => $drivewayData['dstate'],
            "dzip" => $drivewayData['dzip'],
			"timeZone"=>$search_zone,
			"searchtype"=>$searchtype,
			"userzone"=>$location_zone
            );
			
            $response['bookingFromdate'] = $bookingFromdate;
			$response['bookingFromtime'] = $bookingFromtime;
            $response['bookingTodate']   = $bookingTodate;
			$response['bookingTotime']   = $bookingTotime;
			
            $this->apiResponse($response);
        }
    }
    
    
    /** 
    * To count driveway visitors     for driveway price increment algoritham
    */
    public  function visitcount($drivewayInfo)
    {
        if(!isset($_SESSION['visited']) || !in_array($drivewayInfo['drivewayID'], $_SESSION["visitedDriveway"])) {        
            $_SESSION['visited']             =  true;
            $_SESSION['visitedDriveway']     =  array();
            $drivewayId                      =  $drivewayInfo['drivewayID'];
            $drivVisit['drivewayID']         =  $drivewayId;
            $drivVisit['fromDate']           =  $drivewayInfo['fromDate'] ;
            array_push($_SESSION['visitedDriveway'], $drivewayInfo['drivewayID']);
            $_SESSION['userSessionID']         = rand(10000, 99999);
            $countResults                     = $this->drivewaymodel->visitCount($drivVisit);
            $countResult                     =  $countResults->totalViews;
            if($countResults) {
                if($countResult >=10 && $countResult <=100) {                
                    $addPrice = floor($countResult/10)* PRICE_INCREMENT;
                    $addPriceforDaily = floor($countResult/10)* PRICE_INCREMENT_DAILY;
                    $price = $this->drivewaymodel->getPrice($drivewayId);                    
                    $newPrice = $price['price']+$addPrice;
                    $newdailyprice = $price['dailyprice']+$addPriceforDaily;
                    $drivCount['drivewayID']    =  $drivewayId;
                    $drivCount['fromDate']      =  $drivewayInfo['fromDate'] ;
                    $drivCount['newPrice']      =  $newPrice;
                    $drivCount['ddailyPrice']   =  $newdailyprice;
                    $this->drivewaymodel->updatedPrice($drivCount);
                    $this->drivewaymodel->deleteCount($drivewayId);
                    return true;
                }
                else {
                return true;
                } 
            }
        }
    }
    
    /**
    * To get logged in user info
    * 
    */    
    public function getUser()
    {   
        $search_zone  = $_SESSION['search_zone'];    
        $datef = new DateTime($this->input->post('fromDate', TRUE));
        $timef = new DateTime($this->input->post ( 'fromTime', TRUE ));        
        $datet = new DateTime($this->input->post('toDate', TRUE));
        $timet = new DateTime($this->input->post ( 'toTime', TRUE ));
        $given_from = new DateTime($datef->format(DATE_FORMAT) .' ' .$timef->format(TIME_FORMAT) , new DateTimeZone($search_zone));
        $given_from->setTimezone(new DateTimeZone(UTC));
        $fromdate = $given_from->format("Y-m-d H:i:s");        
        $given_to = new DateTime($datet->format(DATE_FORMAT) .' ' .$timet->format(TIME_FORMAT) , new DateTimeZone($search_zone));
        $given_to->setTimezone(new DateTimeZone(UTC));
        $todate = $given_to->format("Y-m-d H:i:s");    
        
        $data = $this->session->userdata ( 'logged_in' );
        $userId = $data ['user_id'];
        $role = $data ['role'];        
        $response = array();
        if (! $this->checkLogin ( $this->module )) {                
            $response['login'][0] = array(
                    "status" => false                    
                    );
            echo json_encode($response);
            return true;
        }
        else {        
            $minutes_to_add = MINUTES_TO_ADD;       //add it from settings page //this is for locking the driveway
            $currentTime =   new DateTime(date("Y-m-d H:i:s") );
            $currentTime->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            $currentTime->setTimezone(new DateTimeZone(UTC));
            $unlockTime = $currentTime->format(DATE_TIME);        
            $booking['unlockTime'] = $unlockTime;
            $booking['fromDate'] = $fromdate;
            $booking['toDate'] = $todate;        
            $booking['userID'] = $userId;
            $booking ['drivewayID'] = $this->input->post('drivewayID', TRUE); 
			$booktempId = $this->drivewaymodel->bookProcess($booking);        
            $option  = $this->input->post('option', TRUE); 
            if($option == 2)
            {
                $fromDate                    = $this->input->post ( 'fromDate', TRUE );
                $toDate                      = $this->input->post ( 'toDate', TRUE );
                $fromTime                    = $this->input->post ( 'fromTime', TRUE );
                $toTime                      = $this->input->post ( 'toTime', TRUE );
                $fdate                       = new \DateTime($fromTime);
                $tdate                       = new \DateTime($toTime);
                $timeFrom                    = $fdate->format(TIME_FORMAT);
				$timeTo                      = $tdate->format(TIME_FORMAT);
                $frm_date                    = new \DateTime($fromDate);
                $to_date                     = new \DateTime($toDate);
                $dateFrom                    = $frm_date->format(DATE_TIME);
                $dateTo                      = $to_date->format(DATE_TIME);        
                $bookArray = $this->createDateRangeArray($dateFrom,$dateTo);            
                foreach ($bookArray as  $bookDate) 
                {        
                    $start_date_and_time = $bookDate . ' ' . $timeFrom;    
                    $end_date_and_time = $bookDate . ' ' . $timeTo;           
                    $bookingFrom = new DateTime($start_date_and_time);
                    $bookingFrom->setTimezone(new DateTimeZone(UTC));                
                    $bookingTo = new DateTime($end_date_and_time);
                    $bookingTo->setTimezone(new DateTimeZone(UTC));            
                    $book_d['start_date']        = $bookingFrom->format("Y-m-d H:i:s"); 
                    $book_d['end_date']          = $bookingTo->format("Y-m-d H:i:s"); 
                    $this->drivewaymodel->recbookProcess($book_d);
                }
            }
        
            $sess_array = array (                                                            
                                'temp_booking_id' => $booktempId,
                                'fromDate' => $fromdate
                               
                        );
            // set session values
            $this->session->set_userdata ( 'temp_search', $sess_array );    
             
            $response['login'][0] = array(
                    "status" => true                    
                    );
            $this->load->model ( 'usermanagement/Usermanagementmodel' );        
            $this->load->model ( 'DrivewayModel' );
            $vehicles =  $this->DrivewayModel->checkCarExist($userId);          
            $cards =  $this->DrivewayModel->checkCardExist($userId);        
                if(!$vehicles) {
                $response['vehicle'][0] = array(
                    "status" => true,
                    "vehicle" => false,
                    "userID" => $userId,
                    "role" => $role                    
                    );
               
                } 
                else 
                {                
                    foreach($vehicles as $i => $vehicle)
                    {
                        $response['vehicle'][$i]= array(
                        "status" => true,
                        "vehicle" => true,
                        'vehicleType' => $vehicle->vehicleNumber.' '.$vehicle->year.' '.$vehicle->color,
                        'vehicleID' =>  $vehicle->vehicleID
                        );
                        $i++;
                    }
                }
                
                if(!$cards) {
                    $response['cards'][0] = array(
                    "status" => true,
                    "cards" => false,
                    "userID" => $userId,
                    "role" => $role                    
                    );
               
                } else {                
                foreach($cards as $i => $card){
                 $response['cards'][$i]= array(
                 "status" => true,
                 "cards" => true,
                 'name_on_card' =>  $card->name_on_card.' - '.$card->expiration_month.'/'.$card->expiration_year,
                 'billID' =>  $card->billID
                 
                 );
                 $i++;
                }
                }
                 $this->apiResponse($response);
                        return true;
                
                    echo json_encode($response);
                    return true;
        }
    }
    
    /**
     * To get token for parker using stripe
     */
    public function getToken() {    
        require_once (APPPATH . STRIPE_PATH);
        require_once (APPPATH . STRIPE_LIB_PATH);
        Stripe\Stripe::setApiKey ( STRIPE_KEY );
        $expirationdate = $this->input->post ( 'expiration_date', TRUE );
        $expiration_month = substr ( $expirationdate, 0, 2 );
        $expiration_year = substr ( $expirationdate, 3 );
        try {
            $res = \Stripe\Token::create ( array (
                    "card" => array (
                            "name" => $this->input->post ( 'nameon_card' ),
                            "number" => $this->input->post ( 'card_number' ),
                            "exp_month" => $expiration_month,
                            "exp_year" => $expiration_year,
                            "cvc" => $this->input->post ( 'security_code' ) 
                    ) 
            ) );
            $result = array (
                    'message' => 'success',
                    'token' => $res ['id'] 
            );
            return ($result);
        } catch ( \Stripe\Error\Stripe_CardErro $e ) {
            $body = $e->getJsonBody ();
            $err = $body ['error'];
            $result = array (
                    'message' => $err ['message'],
                    'token' => '' 
            );
            return $result;
        }
    }
    
    
    public function checkBooking()
    {    
        $data['drivewayID']         = $this->input->post('drivewayid');
        $data['startdate']          = $this->input->post('startdate');
        $data['enddate']            = $this->input->post('enddate');        
        $this->load->model ( 'DrivewayModel' );        
        $checkBooking               = $this->DrivewayModel->checkBooking($data);        
        if ( $checkBooking ) {
           $response = array (
              "status" => true,
              "message" => 'Exists' 
            );
        } else {
            $response = array (
              "status" => false,
              "message" => 'Not Exists' 
           );
        }
        $this->apiResponse($response);
    }
  
    
    function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.
        // could test validity of dates here but I'm already doing that in the main script
        
        $aryRange=array();
        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date(DATE_FORMAT,$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date(DATE_FORMAT,$iDateFrom));
            }
        }
    
        return $aryRange;
    }

    public function get_nearest_timezone($cur_lat, $cur_long, $country_code = '') 
    {
        $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code)
                                    : DateTimeZone::listIdentifiers();
        if($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) 
        {
            $time_zone = '';
            $tz_distance = 0;
            //only one identifier?
            if (count($timezone_ids) == 1) {
                $time_zone = $timezone_ids[0];
            } else 
            {
                foreach($timezone_ids as $timezone_id) {
                    $timezone = new DateTimeZone($timezone_id);
                    $location = $timezone->getLocation();
                    $tz_lat   = $location['latitude'];
                    $tz_long  = $location['longitude'];
                    $theta    = $cur_long - $tz_long;
                    $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) 
                    + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                    $distance = acos($distance);
                    $distance = abs(rad2deg($distance));
                    if (!$time_zone || $tz_distance > $distance) {
                        $time_zone   = $timezone_id;
                        $tz_distance = $distance;
                    } 

                }
            }
            return  $time_zone;
        }
        return 'none?';
    }
    
    
}