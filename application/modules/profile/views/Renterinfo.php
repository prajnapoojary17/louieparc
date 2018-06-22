<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="main-content">    
    <div class="profile-container wow bounceInDown" data-wow-duration="1s" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-md-offset-2 col-sm-4">
                    <div class="profile-left">
                        <ul>
                            <li class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1.8s"><i class="icon-car"></i> <span class="profile-text">Renter</span></li>
                        </ul>
                    </div>
                </div>                
                <div class="col-md-4 col-sm-4">
                    <div class="profile-middle">
                        <div class="profile-pic wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><img src="<?php
                            echo base_url();
                            if ($result->profileImage != 0) {
                                ?>assets/uploads/profilephoto/<?php
                                                                                                                echo $result->profileImage;
                                                                                                            } else {
                                                                                                                ?>assets/images/avatar.png <?php }
                                                                                                            ?>" style="width: 197px; height: 197px;" class="avatar" />
                        </div>
                        <div class="profile-name wow fadeInDown" data-wow-duration="1s" data-wow-delay="1.5s"><?php echo $result->firstName . ' ' . $result->lastName; ?></div>

                    </div>
                </div>
                <div class="col-md-2 col-sm-4">
                    <div class="profile-right">
                        <ul>

                        </ul>
                    </div>
                </div>
            </div>                    
        </div>
    </div>
    <div class="profile-history">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s"
                 data-wow-delay="2.8s">
                <div class="col-md-6">
                    <h1 class="wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay="2.4s">Contact Address</h1>
                    <h4 class="wow fadeInUp" data-wow-duration="1s"    data-wow-delay="2.6s"><?php echo $result->streetAddress; ?></h4>
                    <h4 class="wow fadeInUp" data-wow-duration="1s"    data-wow-delay="2.6s"><?php echo $result->building . ' , ' . $result->city; ?></h4>
                    <h4 class="wow fadeInUp" data-wow-duration="1s"    data-wow-delay="2.6s"><?php echo $result->state . ' - ' . $result->zip; ?></h4>
                </div>
                <div class="col-md-6">
                    <h1 class="wow fadeInUp" data-wow-duration="1s"
                        data-wow-delay="2.4s">DrivewayAddress</h1>                        
                        <?php
                        if (!empty($driveways)) {
                            foreach ($driveways as $driveway) {
                                ?>
                            <h4 class="wow fadeInUp" data-wow-duration="1s"    data-wow-delay="2.6s"><?php echo $driveway->streetAddress; ?></h4>
                            <h4 class="wow fadeInUp" data-wow-duration="1s"    data-wow-delay="2.6s"><?php echo $driveway->building . ' , ' . $driveway->city; ?></h4>
                            <h4 class="wow fadeInUp" data-wow-duration="1s"    data-wow-delay="2.6s"><?php echo $driveway->state . ' - ' . $driveway->zip; ?></h4>
                            <br><br>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="btn-set profile-actions wow fadeInUp" data-wow-duration="1s" data-wow-delay=".9s">
                <a href="#" class="btn btn-success btn-brand" onclick="window.history.back();"><i class="icon-cross2"></i>CLOSE</a>
            </div>


        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>/assets/js/lib/jquery-1.12.3.js"></script>