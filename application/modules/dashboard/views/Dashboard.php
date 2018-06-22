
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css">
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="loader login" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        wait...
    </div>
</div>
<div class="main-content">
    <div class="profile-container wow bounceInDown" data-wow-duration="1s"
         data-wow-delay=".1s">
        <div class="container">
            <div class="row">                
                <?php
                echo validation_errors();
                if (isset($success)) {
                    echo '<div class="alert_error" style="display:block">You have successfully reset your password</div>';
                }
                ?>    
                <div class="alert_error cancelMessage" style="display:block"></div>
                <div class="col-md-2 col-md-offset-2 col-sm-4">
                    <div class="profile-left">
                        <ul>
                            <li class="wow fadeInRight" data-wow-duration="1s" data-wow-delay="1.8s"><a href="<?php echo base_url(); ?>profile"><i class="icon-head"></i>  <span class="profile-text">Profile Info</span></a></li>
                            <?php if (!empty($driveways)) { ?>
                                    <?php if ($account != 1) { ?>    <li class="wow fadeInRight" data-wow-duration="1s" data-wow-delay="2s"><a href="<?php echo base_url(); ?>dashboard/account"><i class="icon-cog"></i>  <span class="profile-text">Add Bank Account</span></a>
                                    </li>    <?php } else { ?>                
                                    <li class="wow fadeInRight" data-wow-duration="1s" data-wow-delay="2s"><a href="<?php echo base_url(); ?>dashboard/account_view"><i class="icon-cog"></i>  <span class="profile-text">Bank Account Settings</span></a>
                                    </li><?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="profile-middle">
                        <div class="profile-pic wow zoomIn" data-wow-duration="1s"
                             data-wow-delay="1s">
                            <img src="<?php
                            echo base_url();
                            if ($result->profileImage == '0') {
                                ?>assets/images/avatar.png <?php
                                 } else {
                                     ?>assets/uploads/profilephoto/<?php
                                     echo $result->profileImage;
                                 }
                                 ?>" class="avatar" />
                        </div>
                        <div class="profile-name wow fadeInDown" data-wow-duration="1s"
                             data-wow-delay="1.5s"><?php echo $result->firstName . ' ' . $result->lastName; ?> <br>                            
                        </div>
                        <div class="profile-email wow fadeInDown" data-wow-duration="1s"
                             data-wow-delay="1.5s"><?php echo $result->emailID; ?> <br>                            
                        </div>

                    </div>
                </div>
                <div class="col-md-2 col-sm-4">
                    <div class="profile-right">
                        <ul>
                            <li class="wow fadeInLeft" data-wow-duration="1s"
                                data-wow-delay="1.8s"><i class="icon-car"></i> <span
                                    class="profile-text"><?php
                                        $renter = '';
                                        $parker = '';
                                        if ($role == 2) {
                                            echo 'Renter';
                                            $renter = 'active';
                                        } else if ($role == 3) {
                                            echo 'Parker';
                                            $parker = 'active';
                                        } else {
                                            echo 'Parker/Renter';
                                            $parker = 'active';
                                        }
                                        ?></span></li>                  
                        </ul>
                    </div>
                </div>
            </div>
            <div class="profile-actions wow fadeInUp" data-wow-duration="1s" data-wow-delay="2.2s">
                <a href="<?php echo base_url(); ?>driveway"class="btn btn-transparent">Find a driveway</a>                
            </div>
            <div id="park-history"></div>
        </div>
    </div>


    <div class="profile-history">
        <div class="container">
            <div class="CCServerError"></div>
            <div class="fancy-tab" data-wow-duration="1s" data-wow-delay="2.8s">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="park_history <?php echo $parker ?>"><a href="#History" aria-controls="History" role="tab" data-toggle="tab">Parking History</a></li>
                    <li role="presentation" class="cust_history  <?php echo $renter ?>"><a href="#Customers" aria-controls="Customers" role="tab" data-toggle="tab">Parked Customers</a></li>
                    <li role="presentation" class="driveway_list"><a href="#driveways" aria-controls="driveways" role="tab" data-toggle="tab">Driveways</a></li>                
                    <li role="presentation" class="vihicle_info"><a href="#vehicle" aria-controls="vehicle" role="tab" data-toggle="tab">Vehicle Info</a></li>
                    <li role="presentation" class="card_info"><a href="#card" aria-controls="card" role="tab" data-toggle="tab">Card Info</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane  <?php echo $parker ?>" id="History">                
                        <?php
                        if (!empty($park_history)) {
                            $i = 1;
                            ?>  
                            <div class="table-responsive">
                                <table id="example" class="table table-striped " cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>                                                                               
                                            <th>From Date - Time</th>
                                            <th>To Date - Time</th>
                                            <th>Booking Type</th>
                                            <th>Price</th>
                                            <th>Process Fee</th>
                                            <th>Status</th>
                                            <th>Review</th>        
                                            <th>View</th>

                                        </tr>
                                    </thead>       
                                    <tbody>
                                        <?php
                                        foreach ($park_history as $history) {
                                            $UTC = new DateTimeZone(UTC);
                                            $centerlat = $history->latitude;
                                            $centerlong = $history->longitude;
                                            $search_zone = get_nearest_timezone($centerlat, $centerlong);
                                            $dateTime = new DateTime();
                                            $dateTime->setTimeZone(new DateTimeZone($search_zone));
                                            $zone = $dateTime->format('T');
                                            $newTZ = new DateTimeZone($search_zone);
                                            $fromDate = new DateTime($history->fromDate, $UTC);
                                            $toDate = new DateTime($history->toDate, $UTC);
                                            $fromDate->setTimezone($newTZ);
                                            $toDate->setTimezone($newTZ);
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>                                                                            
                                                <td><?php echo $fromDate->format(DATE_FORMAT_MMDDYY) . ' <h8>(' . $zone . ')</h8>'; ?> </td>
                                                <td><?php echo $toDate->format(DATE_FORMAT_MMDDYY) . ' <h8>(' . $zone . ') </h8>'; ?></td>
                                                <td>
                                                    <?php
                                                    if ($history->bookingType == 1) {
                                                        echo 'Hourly';
                                                    } else if ($history->bookingType == 2) {
                                                        echo 'Recurring';
                                                    } else if ($history->bookingType == 3) {
                                                        echo "Flat Rate";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $history->totalPrice; ?></td>
                                                <td><?php echo $history->processFee; ?></td> 

                                                <?php
                                                $currentDate = new DateTime(date(DATE_TIME));
                                                $currentDate->setTimezone(new DateTimeZone(UTC));
                                                $curdate = $currentDate->format(DATE_FORMAT);
                                                $currentTime = new DateTime(date("H:i"));
                                                $currentDate->setTimezone(new DateTimeZone(UTC));
                                                $currentTime = $currentDate->format('H:i');
                                                $fDate = new DateTime($history->fromDate, $UTC);
                                                $tDate = new DateTime($history->toDate, $UTC);
                                                $fromdate = $fDate->format(DATE_FORMAT);
                                                $todate = $tDate->format(DATE_FORMAT);
                                                $toTime = $tDate->format('H:i');
                                                $fromTime = $fDate->format('H:i');
                                                $bookingFrom = $fDate->format(DATE_TIME);
                                                $bookingTo = $tDate->format(DATE_TIME);
                                                $currentDateTime = $currentDate->format(DATE_TIME);
                                                $diffinminutes = 0;
                                                $diffinminutes = (strtotime($bookingFrom) - strtotime($currentDateTime)) / 60;

                                                $todaysBooking = '';
                                                $minutes = '';
                                                if ($fromdate == $curdate) {
                                                    $todaysBooking = strtotime($fromTime);
                                                   // $minutes = ($todaysBooking - $currentTime) / 60;
                                                    echo '<div class="today" style="display:none">' . $fromTime . END_DIV;
                                                    echo '<div class="currentTime" style="display:none">' . $currentTime . END_DIV;
                                                    echo '<div class="now" style="display:none">' . $history->bookingID . END_DIV;
                                                }
                                                if ($todate == $curdate) {
                                                    echo '<div class="endNow" style="display:none">' . $toTime . END_DIV;
                                                }
                                                //shree from
                                                if ($history->bookingStatus == 0) {
                                                    echo '<td><label class="label label-danger replacehere' . $toTime . '">Cancelled</label></td>
                                <td>&nbsp;</td>';
                                                } else if ($diffinminutes > 30) {

                                                    echo '<td><label class="label label-primary replaceme' . $history->bookingID . 'now  cancelled' . $history->bookingID . '">
                                <a href="#"  title="Click to cancel booking" onclick="cancelBooking(' . $history->bookingID . ',2)">Cancel Booking</a>
                                </label></td> <td>&nbsp;</td>';
                                                } else if (strtotime($bookingTo) <= strtotime($currentDateTime)) {
                                                    echo '<td><label class="label label-success">Completed</label></td>';

                                                    if (in_array($history->bookingID, $reviewsbid)) {
                                                        echo '<td></td>';
                                                        ?>  
                                                                                                                   <!-- <a class="btn btn-info" onclick="addReview('<?php echo $history->drivewayID . ',' . $history->userID ?>')" href="#">Write Review</a> --><?php
                                                    } else {
                                                        echo '<td>
                                                    <a title="" class="btn btn-warning tooltips"  onclick="addReview(' . $history->drivewayID . ',' . $history->userID . ',' . $history->bookingID . ')" href="#" data-original-title="Write Review"><i class="icon-pencil"></i></a></td>';
                                                    }
                                                }
                                                // when diffinminutes<=30  and diffinminutes>=0
                                                else {
                                                    echo '<td><label class="label label-primary replacehere' . $toTime . '">Progress</label></td><td>&nbsp;</td>';
                                                }
                                                ?>
                                                <td><a title="" class="btn btn-info tooltips" href="#" onclick="parkinghistoryview('<?php echo $history->bookingID; ?> ')"  data-original-title="View"><i class="icon-eye"></i></a>
                                                    <!-- <button class="btn btn-warning">View</button> -->
                                                </td>


                                            </tr>
                                            <?php
                                            $i = $i + 1;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo 'No Parking details';
                        }
                        ?>

                    </div> 


                    <div role="tabpanel" class="tab-pane <?php echo $renter ?>" id="Customers">        
                        <?php
//Parked Customer
                        if (!empty($parked_cust)) {
                            ?>  
                            <div class="table-responsive">
                                <table id="example2" class="table table-striped " cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Booking Type</th>                
                                            <th>From Date - Time</th>
                                            <th>To Date - Time</th>
                                            <th>Building Name </th>
                                            <th>Price</th>
                                            <th>Status</th>   
                                            <th>View</th>                
                                            <th style="display:none;"></th>
                                            <th style="display:none;"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($parked_cust as $parkinghistory) {
                                            //shree from 
                                            $UTC = new DateTimeZone(UTC);
                                            $currentDate = new DateTime(date(DATE_TIME));
                                            $currentDate->setTimezone(new DateTimeZone(UTC));
                                            $fDate = new DateTime($parkinghistory->fromDate, $UTC);
                                            $tDate = new DateTime($parkinghistory->toDate, $UTC);
                                            $bookingFrom = $fDate->format(DATE_TIME);
                                            $bookingTo = $tDate->format(DATE_TIME);
                                            $currentDateTime = $currentDate->format(DATE_TIME);
                                            $centerlat = $parkinghistory->latitude;
                                            $centerlong = $parkinghistory->longitude;
                                            $search_zone = get_nearest_timezone($centerlat, $centerlong);
                                            $newTZ = new DateTimeZone($search_zone);
                                            $bookingFromZone = $fDate->setTimezone($newTZ);
                                            $bookingToZone = $tDate->setTimezone($newTZ);
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td class="usname">
                                                    <?php
                                                    if ($parkinghistory->bookingType == 1) {
                                                        echo 'Hourly';
                                                    } else if ($parkinghistory->bookingType == 2) {
                                                        echo 'Recurring';
                                                    } else if ($parkinghistory->bookingType == 3) {
                                                        echo "Flat Rate";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    echo $bookingFromZone->format(DATE_FORMAT_MMDDYY);
                                                    ?></td> 
                                                <td><?php echo $bookingToZone->format(DATE_FORMAT_MMDDYY); ?></td>
                                                <td><?php echo $parkinghistory->building; ?></td>
                                                <td><?php echo $parkinghistory->totalPrice; ?></td>
                                                <?php
                                                $toTime = strtotime($parkinghistory->toTime);
                                                if ($parkinghistory->bookingStatus == 0) {
                                                    echo '<td><label class="label label-danger replacehere' . $toTime . '">Cancelled</label></td>';
                                                } else if (strtotime($bookingTo) > strtotime($currentDateTime)) {

                                                    echo '<td><label class="label label-primary cancelled' . $parkinghistory->bookingID . '">
                                <a href="#"  title="Click to cancel booking" onclick="cancelBooking(' . $parkinghistory->bookingID . ',1)">Cancel Booking</a></label></td> ';
                                                } else if (strtotime($bookingTo) <= strtotime($currentDateTime)) {
                                                    echo '<td><label class="label label-success">Completed</label></td>';
                                                } else {
                                                    echo '<td><label class="label label-primary replacehere' . $toTime . '">Progress</label></td>';
                                                }
                                                ?>
                                                <td> <a title="" class="btn btn-info viewbtn" href="#" data-toggle="modal" data-target="#viewModal"><i class="icon-eye tooltips" data-original-title="View Details"></i></a> <!--<button class="btn btn-warning viewbtn"> View</button>--></td>
                                                <td style="display:none;" class="userID"><?php
                                                // $this->load->library('encrypt');
                                               //  $userIDnew =  $this->encrypt->encode($parkinghistory->userID); 
                                                  $userIDnew = my_encrypt($parkinghistory->userID, ENCRYPTION_KEY_256BIT);
                                                 echo $userIDnew;
                                                ?></td>
                                                <td style="display:none;" class="bookingID"><?php 
                                                // $bookingIDnew =  $this->encrypt->encode($parkinghistory->bookingID); 
                                                $bookingIDnew = my_encrypt($parkinghistory->bookingID, ENCRYPTION_KEY_256BIT);
                                                 echo $bookingIDnew;
                                                ?></td>
                                            </tr>
                                            <?php
                                            $i = $i + 1;
                                        }
                                        ?>        
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        } else {
                            echo 'No Parked Customers';
                        }
                        ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="driveways">
                        <h1><a href="<?php echo base_url(); ?>profile/addDriveway" class="btn btn-success pull-right tooltips" title="Add Driveway"><i class="icon-plus22"></i></a></h1> 
                        <?php if (!empty($driveways)) { ?>
                            <div class="table-responsive">
                                <table class="table table-fancy">
                                    <tr>
                                        <th></th>
                                        <th>Driveway Address</th>
                                        <th>Hourly Price</th>
                                        <th>Flat Price</th>
                                        <th>Driveway Status</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    foreach ($driveways as $driveway) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $driveway->building ?><br/><?php echo $driveway->route; ?>, &nbsp<?php echo $driveway->streetAddress ?> <?php echo $driveway->city ?>, &nbsp<?php echo $driveway->state ?> &nbsp - &nbsp <?php echo $driveway->zip ?> </td>
                                            <td><?php echo $driveway->price; ?></td>
                                            <td><?php echo $driveway->dailyprice; ?></td>
                                            <td><?php
                                                if ($driveway->drivewayStatus == 1) {
                                                    echo 'ON';
                                                } else {
                                                    echo 'OFF';
                                                }
                                                ?></td>
                                            <td><?php if ($driveway->verificationCode == '') { ?><label class="label label-default">Waiting for admin approval</label> <?php } elseif ($driveway->verificationStatus == 1) { ?> <label class="label label-success">Verified</label> <?php } else { ?><label class="label label-primary"><a href="#"  title="Click to verify Driveway" onclick="verifydriveway('<?php echo $driveway->drivewayID ?>')">Verify</a></label><?php } ?></td>
                                            <td><a onclick="drivewaySetting('<?php echo $driveway->drivewayID ?>')" href="#" class="btn btn-warning tooltips" title="Driveway Settings"><i class="icon-cog"></i></td>
                                            <td><a title="" class="btn btn-warning tooltips" onclick="drivewayEdit('<?php echo $driveway->drivewayID ?>')" href="#" data-original-title="Edit"><i class="icon-edit2"></i></a></td>
                                            <td><a onclick="viewReview('<?php echo $driveway->drivewayID ?>')" href="#" class="btn btn-warning tooltips  " title="View Reviews" ><i class="icon-comment"></i></td>
                                        </tr>
                                        <?php
                                        $i = $i + 1;
                                    }
                                    ?>                            
                                </table>
                            </div>
                            <?php
                        } else {
                            echo 'No Driveways';
                        }
                        ?>

                    </div> 

                    <div role="tabpanel" class="tab-pane" id="vehicle">
                        <h1><a href="<?php echo base_url(); ?>profile/Addcar" class="btn btn-success pull-right tooltips" title="Add Car"><i class="icon-plus22"></i></a></h1>
                        <?php if (!empty($cars)) { ?>                                                   
                            <div class="table-responsive">
                                <table class="table table-fancy wow" data-wow-duration="1s" data-wow-delay="0.7s">
                                    <tr>                                    
                                        <th>Model</th>
                                        <th>Year</th>
                                        <th>Color</th>
                                        <th>Number</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <?php
                                    $i = 1;
                                    foreach ($cars as $car) {
                                        ?>
                                        <tr id="row<?php echo $i; ?>">
                                            <td style="display:none;" class="cid"><?php echo $car->vehicleID ?></td>
                                            <td class="cmodel"><span class='span_model<?php echo $car->vehicleID ?>' class='text'><?php echo $car->model ?></span><input type='text' value='<?php echo $car->model ?>' data-original-value="<?php echo $car->model ?>" class='input_model<?php echo $car->vehicleID ?>' style="display:none; width:100px;" /></td>
                                            <td class="cyear" ><span class='span_cyear<?php echo $car->vehicleID ?>' class='text'><?php echo $car->year ?></span><input type='text' value='<?php echo $car->year ?>' data-original-value="<?php echo $car->year ?>" class='input_cyear<?php echo $car->vehicleID ?>' style="display:none; width:60px;" /></td>
                                            <td class="ccolor"><span class='span_ccolor<?php echo $car->vehicleID ?>' class='text'><?php echo $car->color ?></span><input type='text' value='<?php echo $car->color ?>' data-original-value="<?php echo $car->color ?>" class='input_ccolor<?php echo $car->vehicleID ?>' style="display:none; width:90px;" /></td>
                                            <td class="cnumber"><span class='span_cnumber<?php echo $car->vehicleID ?>' class='text'><?php echo $car->vehicleNumber ?></span><input type='text' value='<?php echo $car->vehicleNumber ?>' data-original-value="<?php echo $car->vehicleNumber ?>" class='input_cnumber<?php echo $car->vehicleID ?>' style="display:none; width:95px;" /></td>
                                            <td><button class="btn btn-warning editbtn editbtn<?php echo $car->vehicleID ?>">Edit</button></td>                                                                                
                                            <td><button class="btn btn-danger deletebtn deletebtn<?php echo $car->vehicleID ?>" >Delete</button><button class="btn btn-warning undobtn<?php echo $car->vehicleID ?> undobtn" style="display:none;">Cancel</button></td>
                                        </tr>
                                        <?php
                                        $i = $i + 1;
                                    }
                                    ?>                                        
                                </table>
                            </div>
                            <?php
                        } else {
                            echo 'No saved Cars';
                        }
                        ?>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="card">
                        <h1><a href="<?php echo base_url(); ?>profile/addCard" class="btn btn-success pull-right tooltips" title="Add Card Info"><i class="icon-plus22"></i></a></h1>    
                        <?php if (!empty($cards)) { ?>  
                            <div class="card_list">
                                <div class="table-responsive">
                                    <table class="table table-fancy" data-wow-duration="1s" data-wow-delay="0.7s">
                                        <tr>                                    
                                            <th>Name on the Card</th>
                                            <th>Expiry Date</th>                                       
                                            <th></th>                                       
                                        </tr>
                                        <?php
                                        foreach ($cards as $card) {
                                            $status = 'btn-danger';
                                            ?>
                                            <tr>           
                                                <td style="display:none;" class="bid"><?php echo $card->billID ?></td>
                                                <td> <?php echo $card->name_on_card ?></td>
                                                <td ><?php echo $card->expiration_month . '/' . $card->expiration_year; ?> </td>
                                                <td> <button class="btn btn-danger deletecard" >Delete</button>
                                                </td>
                                            </tr>        <?php } ?>                              
                                    </table>
                                </div>
                            </div>
                            <?php
                        } else {
                            echo 'No saved Cards';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Details</h4>
            </div>
            <div class="modal-body">
                <label>Name:</label><p id="uName"></p>
                <label>Email ID:</label><p id="uEmailid"></p>
                <label>Phone:</label><p id="uPhone"></p>
                <label>Address:</label><p id="uAddress"></p>
                <label>Refunded to parker: </label><span id="uRefund"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--<div id="mymwindow" class="mwindow">
    <div class="mwindow-content">
        <div class="modal-header">
            <span class="close">×</span>
            <h2><p>Details</p></h2>
        </div>
        <div class="modal-body">    
            <label>Name:</label><p id="uName"></p>
            <label>Email ID:</label><p id="uEmailid"></p>
            <label>Phone:</label><p id="uPhone"></p>
            <label>Address:</label><p id="uAddress"></p>
            <label>Refunded to parker: </label><span id="uRefund"></span>
        </div>
        <div class="m-footer">
        </div>
    </div>

</div>-->
<div id="inset_form">
</div>
<div id="edit_form">
</div>
<input type="hidden" id="driveway_set">
<script src="<?php echo base_url(); ?>/assets/js/lib/jquery-1.12.3.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/lib/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/lib/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/park_process.js"></script>
<script src="<?php echo base_url(); ?>assets/js/renter_dashboard.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/profileinfo.js" type="text/javascript"></script>
<script>

                                        var modal = document.getElementById('mymwindow');
                                        var clBtn = document.getElementsByClassName("close")[0];
                                        var uName = document.getElementById("uName");
                                        var uEmailid = document.getElementById("uEmailid");
                                        var uAddress = document.getElementById("uAddress");
                                        $(".viewbtn").on('click', function () {
                                            var $this = $(this);
                                            var $tr = $this.closest("tr");
                                            var cid = $tr.find('.userID').text();
                                            var bid = $tr.find('.bookingID').text();
                                            
                                            $.ajax({
                                                type: "POST",
                                                url: baseUrl + "usermanagement/getRenterInfo",
                                                data: {id: cid, bid: bid},
                                                dataType: "json",
                                                success: function (response) {
                                                    uName.innerHTML = response['result'].firstName + '&nbsp' + response['result'].lastName;
                                                    uEmailid.innerHTML = response['result'].emailID;
                                                    var address = "";
                                                    if (response['result'].building != "")
                                                    {
                                                        address = address + response['result'].building + "<br>";
                                                    }
                                                    if (response['result'].streetAddress != "")
                                                    {
                                                        address = address + response['result'].streetAddress + "<br>";
                                                    }
                                                    if (response['result'].city != "")
                                                    {
                                                        address = address + response['result'].city + "<br>";
                                                    }
                                                    if (response['result'].state != "")
                                                    {
                                                        address = address + response['result'].state + "<br>";
                                                    }
                                                    if (response['result'].zip != "" && response['result'].zip != "0")
                                                    {
                                                        address = address + response['result'].zip;
                                                    }
                                                    if (address == "")
                                                    {
                                                        address = "N/A";
                                                    }
                                                    if (response['result'].phone != "")
                                                    {
                                                        uPhone.innerHTML = response['result'].phone;
                                                    } else {
                                                        uPhone.innerHTML = 'N/A';
                                                    }
                                                    if (response['result'].totalPrice > 0)
                                                    {
                                                        uRefund.innerHTML = ' $' + response['result'].totalPrice;
                                                    } else {
                                                        uRefund.innerHTML = 'N/A';
                                                    }

                                                    uAddress.innerHTML = address;

                                                    modal.style.display = "block";
                                                }
                                            });

                                        });

                                        clBtn.onclick = function () {
                                            modal.style.display = "none";
                                        }

                                        $(document).ready(function () {
                                            //on page load check for cookie value and add active class

                                            var referrer = document.referrer;
                                            var myFilename = getPageName(referrer);
                                            if (myFilename == 'driveway_edit' || myFilename == 'view_review' || myFilename == 'addDriveway' || myFilename == 'Addcar' || myFilename == 'drivewaySettings')
                                            {
                                                $(".park_history").removeClass("active");
                                                $(".cust_history").removeClass("active");
                                                $("#History").removeClass("active");
                                                $("#Customers").removeClass("active");
                                                $(".driveway_list").addClass("active");
                                                $("#driveways").addClass("active");
                                                $("#vihicle").removeClass("active");
                                                $(".vihicle_info").removeClass("active");
                                            }
                                            if (myFilename == 'addCard')
                                            {
                                                $(".park_history").removeClass("active");
                                                $(".cust_history").removeClass("active");
                                                $("#History").removeClass("active");
                                                $("#Customers").removeClass("active");
                                                $(".driveway_list").removeClass("active");
                                                $(".vihicle_info").removeClass("active");
                                                $("#driveways").removeClass("active");
                                                $("#vihicle").removeClass("active");
                                                $(".card_info").addClass("active");
                                                $("#card").addClass("active");
                                            }
                                            if (myFilename == 'Addcar')
                                            {
                                                $(".park_history").removeClass("active");
                                                $(".cust_history").removeClass("active");
                                                $("#driveways").removeClass("active");
                                                $("#History").removeClass("active");
                                                $("#Customers").removeClass("active");
                                                $(".driveway_list").removeClass("active")
                                                $(".vihicle_info").addClass("active");
                                                $("#vehicle").addClass("active");
                                            }

                                            $("#driveways").click(function () {
                                                $.cookie("isButtonActive", "1");
                                            });
                                            var today = $('.today').html();
                                            var now = $('.now').html();
                                            var endNow = $('.endNow').html();
                                            if (today) {
                                                $.ajax({
                                                    type: "POST",
                                                    url: "booking/api/bookingStatus",
                                                    data: {today: now, endNow: endNow},
                                                    async: true,
                                                    success: function (data) {
                                                        if (data.status)
                                                        {
                                                            $('.replacehere' + endNow).html('Completed');
                                                        } else if (data.minutes <= 30)
                                                        {
                                                            $('.replaceme' + now + 'now').html('Progress');
                                                        }

                                                    }
                                                });

                                            }

                                            $(function () {
                                                setInterval(oneSecondFunction, 1000 * 60 * 1);
                                            });

                                            function oneSecondFunction() {
                                                var today = $('.today').html();
                                                var now = $('.now').html();
                                                var endNow = $('.endNow').html();
                                                if (today) {
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "booking/api/bookingStatus",
                                                        data: {today: now, endNow: endNow},
                                                        async: true,
                                                        success: function (data) {
                                                            if (data.status)
                                                            {
                                                                $('.replacehere' + endNow).html('Completed');
                                                            } else if (data.minutes <= 30)
                                                            {
                                                                $('.replaceme' + now + 'now').html('Progress');
                                                            }

                                                        }
                                                    });
                                                }
                                                return false;
                                            }

                                            function getPageName(url) {
                                                var index = url.lastIndexOf("/") + 1;
                                                var filenameWithExtension = url.substr(index);
                                                var filename = filenameWithExtension.split(".")[0]; // <-- added this line
                                                return filename;                                    // <-- added this line
                                            }


                                        });
</script>
<?php

function get_nearest_timezone($cur_lat, $cur_long, $country_code = '')
{
    $timezone_ids = ($country_code) ? DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code) : DateTimeZone::listIdentifiers();

    if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

        $time_zone = '';
        $tz_distance = 0;

        //only one identifier?
        if (count($timezone_ids) == 1) {
            $time_zone = $timezone_ids[0];
        } else {

            foreach ($timezone_ids as $timezone_id) {
                $timezone = new DateTimeZone($timezone_id);
                $location = $timezone->getLocation();
                $tz_lat = $location['latitude'];
                $tz_long = $location['longitude'];
                $theta = $cur_long - $tz_long;
                $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat))) + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
                $distance = acos($distance);
                $distance = abs(rad2deg($distance));

                if (!$time_zone || $tz_distance > $distance) {
                    $time_zone = $timezone_id;
                    $tz_distance = $distance;
                }
            }
        }
        return $time_zone;
    }
    return 'none';
}

function my_encrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }

    function my_decrypt($data, $key) {
        // Remove the base64 encoding from our key
        $encryption_key = base64_decode($key);
        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }
?>