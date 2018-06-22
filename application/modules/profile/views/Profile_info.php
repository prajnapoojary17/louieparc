<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>   
<div class="loader" style="display:none"><div class="loader-container"><div class="spinner"></div>Please wait...</div></div>
<div class="full-screen">
    <div class="main-content">
        <div class="top-slide"><img src="<?php echo base_url(); ?>assets/images/man-top.png" class="img-responsive" /></div>
        <div class="bottom-slide"><img src="<?php echo base_url(); ?>assets/images/car-bottom.png" class="img-responsive" /></div>
        <div class="profile-message">
            <div class="container">
                <div class="info-container">
                    <div class="row">
                        <input type="hidden" name="userid" value="<?php echo $result->userID; ?>">    
                        <div class="col-md-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".2s">
                            <h1 class="text-center">Profile Info</h1>
                            <div class="error_box"></div>
                            <form class="form-horizontal profileinfo" method="post" name="profileinfo" enctype="multipart/form-data">
                                <input type="hidden" name="userid" value="<?php echo $result->userID; ?>">    
                                <div class="form-group">
                                    <div class="profile-pic">
                                        <div class="pic">
                                            <img src="<?php
                                            echo base_url();
                                            if ($result->profileImage == '0') {
                                                ?>assets/images/avatar.png <?php
                                                 } else {
                                                     ?>assets/uploads/profilephoto/<?php
                                                     echo $result->profileImage;
                                                 }
                                                 ?>" alt="Profile" required/>                                
                                        </div>                                                                
                                        <input type="file" class="profImage" name="profImage" value="" tabindex="0">
                                        <a href="#" class="upload-button">Change Image</a>                                        
                                    </div> 
                                    <?php if ($result->profileImage == '0') { ?>
                                        <a class="remove-image btn-danger remove-button" href="#">Remove Image</a>
                                    <?php } ?>                                   
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="firstname" class="form-control" value="<?php echo $result->firstName; ?>">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="lastname" class="form-control" value="<?php echo $result->lastName; ?>">
                                    </div>
                                </div>                                    
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Mobile</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="mobileno" class="form-control" value="<?php echo $result->phone; ?>">
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Date of Birth</label>
                                    <?php
                                    $dob = strtotime($result->birthDate);
                                    $bm = date("F", $dob);
                                    $by = date("Y", $dob);
                                    $bd = date("d", $dob);
                                    ?>            
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="custom-select">                                            
                                                <select name="bmonth" id="bmonth">
                                                    <option value="0">Month</option>
                                                    <option value="1"<?php
                                                    if ($bm == "January") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>January</option>
                                                    <option value="2"<?php
                                                    if ($bm == "February") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>February</option>
                                                    <option value="3"<?php
                                                    if ($bm == "March") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>March</option>
                                                    <option value="4"<?php
                                                    if ($bm == "April") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>April</option>
                                                    <option value="5"<?php
                                                    if ($bm == "May") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>May</option>
                                                    <option value="6"<?php
                                                    if ($bm == "June") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>June</option>
                                                    <option value="7"<?php
                                                    if ($bm == "July") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>July</option>
                                                    <option value="8"<?php
                                                    if ($bm == "August") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>August</option>
                                                    <option value="9"<?php
                                                    if ($bm == "September") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>September</option>
                                                    <option value="10"<?php
                                                    if ($bm == "October") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>October</option>
                                                    <option value="11"<?php
                                                    if ($bm == "November") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>November</option>
                                                    <option value="12"<?php
                                                    if ($bm == "December") {
                                                        echo SELECTED;
                                                    }
                                                    ?>>December</option>                                
                                                </select>
                                            </div>                    
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="custom-select">
                                                <select name="bday" id="bday">
                                                    <option value="0">Day</option>

                                                    <?php
                                                    $day = 1;
                                                    for ($i = 1; $i <= 31; ++$i):
                                                        if ($i < 10) {
                                                            $day = "0" . $day;
                                                        }
                                                        ?>
                                                        <option value="<?php echo $day; ?>" <?php
                                                        if ($bd == $day) {
                                                            echo SELECTED;
                                                        }
                                                        ?>><?php echo $day; ?></option>
                                                                <?php
                                                                ++$day;
                                                            endfor;
                                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <div class="custom-select">
                                                <select name="byear" id="byear">
                                                    <option value="0">Year</option>
                                                    <?php
                                                    $year = date("Y") - 60;

                                                    for ($i = 0; $i <= 42; ++$i):
                                                        ?>
                                                        <option value="<?php echo $year; ?>" <?php
                                                        if ($by == $year) {
                                                            echo SELECTED;
                                                        }
                                                        ?>><?php echo $year; ?></option>

                                                        <?php
                                                        ++$year;
                                                    endfor;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn btn-brand"><i class="icon-check22"></i>Save </button>                                
                                    <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-cross2"></i>Cancel </a>                                                
                                </div>                                
                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/profileinfo.js" type="text/javascript"></script>