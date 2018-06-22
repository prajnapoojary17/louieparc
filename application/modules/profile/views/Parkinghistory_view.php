<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="main-content single-page">
    <div class="profile-message">
        <!-- <div class="fancy-ball"></div> -->
        <div class="container">
            <input type="hidden" name="ownerID" id="ownerID" value="<?php echo $result->userID; ?>">
            <input type="hidden" name="ownerEmailid" id="ownerEmailid" value="<?php echo $result->emailID; ?>">          
            <div class="row">
                <div class="col-md-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".7s">
                    <div class="owl-carousel house-owl owl-image">
                        <?php if ($result->photo1 == '' && $result->photo2 == '' && $result->photo3 == '' && $result->photo4 == '') { ?>
                            <div class="item">
                                <figure class="figure-container"><img src="<?php echo base_url(); ?>assets/images/house.jpg" alt="LouiePark" class="img-responsive">
                                </figure>
                            </div>
                        <?php } else { ?>
                            <?php if ($result->photo1 != '') { ?>
                                <div class="item">
                                    <figure class="figure-container"><img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $result->photo1; ?>" alt="LouiePark" class="img-responsive">
                                    </figure>
                                </div>
                            <?php } ?>
                            <?php if ($result->photo2 != '') { ?>
                                <div class="item">
                                    <figure class="figure-container"><img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $result->photo2; ?>" alt="LouiePark" class="img-responsive">
                                    </figure>
                                </div>
                            <?php } ?>

                            <?php if ($result->photo3 != '') { ?>
                                <div class="item">
                                    <figure class="figure-container"><img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $result->photo3; ?>" alt="LouiePark" class="img-responsive">
                                    </figure>
                                </div>
                            <?php } ?>

                            <?php if ($result->photo4 != '') { ?>
                                <div class="item">
                                    <figure class="figure-container"><img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $result->photo4; ?>" alt="LouiePark" class="img-responsive">
                                    </figure>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div> 
                    <br/>
                    <div class="driveway-contact">
                        <h4>Driveway Address:</h4>
                        <address>
                            <?php echo $result->dbuilding; ?><br>
                            <?php echo $result->dstreetAddress; ?>,&nbsp <?php echo $result->droute; ?><br>
                            <?php echo $result->dcity; ?>,&nbsp <?php echo $result->dzip; ?><br>
                            <?php echo $result->dstate; ?><br>
                        </address>
                    </div>
                </div>                
                <div class="col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".7s">
                    <div class="driveway-contact">
                        <h4>Contact Owner</h4>
                        <p><?php echo $result->phone; ?><br/>
                            <?php echo $result->firstName; ?>&nbsp;<?php echo $result->lastName ?></p>
                        <address>
                            <?php echo $result->building; ?><br>
                            <?php echo $result->streetAddress; ?>,&nbsp <?php echo $result->route; ?><br>
                            <?php echo $result->city; ?>,&nbsp <?php echo $result->zip; ?><br>
                            <?php echo $result->state; ?><br>
                        </address>

                        <div class="alert-brand">
                            <h4>Transaction information</h4>
                            <p>Total Rental Price<span>$<?php echo $result->totalPrice; ?></span></p><p>
                                <?php
                                if ($result->bookingStatus == 0) {
                                    echo 'Refund Amount: $' . $result->totalPrice . '<br/>';
                                }
                                $dt = new DateTime($result->bookingDate);
                                $bookingDate = $dt->format('m/d/Y');
                                echo 'Booked on: ' . $bookingDate;
                                if ($result->bookingType == 1) {
                                    $bookingType = 'Hourly';
                                } else if ($result->bookingType == 2) {
                                    $bookingType = 'Recurring';
                                } else {
                                    $bookingType = "Flat Rate";
                                }
                                echo '<br/>Booking Type: ' . $bookingType;
                                ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-set profile-actions wow fadeInUp" data-wow-duration="1s" data-wow-delay=".9s">
                <a href="#" class="btn btn-danger btn-brand messageOwner" onclick="messageOwner()"><i class="icon-mail2"></i> Message owner</a>
                <a href="#" onclick="rentAgain('<?php echo $result->drivewayID ?>')" class="btn btn-warning btn-brand"><i class="icon-repeat"></i> Rent again</a>
                <a href="<?php echo base_url(); ?>profile/reportUser" class="btn btn-success btn-brand"><i class="icon-check-square-o"></i> Report user</a>
                <a href="<?php echo base_url(); ?>dashboard" class="btn btn-success btn-brand"><i class="icon-cross2"></i>Close</a> 
            </div>

        </div><div class="testimonials wow fadeInUp" data-wow-duration="1s" data-wow-delay=".8s" style="padding:2px;">            
            <div class="container"> <div class="row">
                    <div class="item">                            
                        <div class="col-md-6 col-sm-6" style="float:left">

                            <p><h3>Description</h3> <?php echo $result->description; ?></p>

                        </div>
                        <div class="col-md-6 col-sm-6">

                            <p><h3>Instruction</h3><?php echo $result->instructions; ?> </p>

                        </div>
                    </div></div></div></div>
    </div>
</div>
<div id="inset_form">
</div>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-slider.min.js"></script>
<script>
                    $(document).ready(function () {
                        renterinfo = function (userID) {
                            $('#inset_form').html('<form action="' + baseUrl + 'profile/renterInfo" name="renterinfo" class="renterinfo" method="post" style="display:none;"><input type="text" name="userID" value="' + userID + '" /></form>');
                            $(".renterinfo").submit();

                        };

                        messageOwner = function () {
                            var emailId = $('#ownerEmailid').val();
                            $('#inset_form').html('<form action="' + baseUrl + 'profile/api/messageOwner" name="messageOwner" class="messageOwner" method="post" style="                    display:none;"><input type="text" name="emailId" value="' + emailId + '" /></form>');
                            $(".messageOwner").submit();
                        };

                        rentAgain = function (dID) {
                            $('#inset_form').html('<form action="' + baseUrl + 'driveway" name="rentagain" class="rentagain" method="post" style="display:none;" ><input type="text" name="drivewayID" value="' + dID + '" /></form>');
                            $(".rentagain").submit();

                        };

                        $(".owl-carousel").owlCarousel({
                            items: 1,
                            margin: 0,
                            responsiveClass: true,
                            loop: true,
                            nav: true,
                            dots: true,
                            autoPlay: true,
                            smartSpeed: 500,
                            responsive: {
                                0: {
                                    nav: false
                                },
                                480: {
                                    nav: false
                                },
                                768: {
                                    nav: false
                                },
                                1000: {
                                    nav: true,
                                }
                            },
                            navigation: true,
                            navigationText: [
                                "<i class='icon-arrow-left owl-direction'></i>",
                                "<i class='icon-arrow-right owl-direction'></i>"
                            ]
                        });

                    });

                    $('.messageOwner').on('click', function () {
                        var emailId = $('#ownerEmailid').val();
                        url = baseUrl + "profile/api/messageOwner";
                        $.ajax({
                            method: "POST",
                            url: baseUrl + "profile/api/messageOwner",
                            dataType: "json",
                            data: {emailId: emailId},
                            success: function (response) {
                                if (response.message == 'success') {
                                    window.location.href = url;
                                }
                            }
                        });


                    });

</script>