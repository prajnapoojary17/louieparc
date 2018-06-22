<!-- Bootstrap Star Rating -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/star-rating.min.css">    <!-- Owl Carousel -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.css">
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";

    $(document).ready(function () {
        $('#input-3').rating({displayOnly: true, step: 0.1});
    });
</script>
<!-- START page-->
<div class="main-content">
    <div class="profile-settings">
        <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">View Review</h1>
        <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s"><?php print_r($driveway['building']); ?> </h2>
        <div class="star-rating text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">
            <input type="text" id="input-3" name="input-3" class="rating-loading" value="<?php echo $ratings; ?>">
        </div>
        <div class="testimonials wow fadeInUp" data-wow-duration="1s" data-wow-delay=".8s">            
            <div class="container">
                <h1>Reviews</h1>
                <div class="row">
                    <div class="owl-carousel testimonial-owl owl-nonav">
                        <?php
                        if (!empty($reviews)) {
                            foreach ($reviews as $review) {
                                ?>
                                <div class="item">
                                    <div class="col-md-3 col-sm-3">
                                        <figure class="figure-container"><img src="<?php
                                            if ($review->profileImage == '0') {
                                                echo base_url();
                                                ?>assets/images/avatar.png" <?php
                                                                              } else {
                                                                                  echo base_url();
                                                                                  ?>assets/uploads/profilephoto/<?php echo $review->profileImage; ?>" <?php }
                                                                              ?> alt="LouiePark" class="img-responsive img-circle" />
                                        </figure>
                                    </div>
                                    <div class="col-md-9 col-sm-9">
                                        <blockquote>
                                            <p>&ldquo;<?php echo $review->comments; ?>&rdquo;</p>
                                        </blockquote>
                                        <p class="blockquote-author"><span><?php echo $review->firstName . ' ' . $review->lastName; ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="item">                            
                                <div class="col-md-9 col-sm-9">
                                    <blockquote>
                                        <p><h3>No Reviews</h3></p>
                                    </blockquote>
                                    <p class="blockquote-author"></p>
                                </div>
                            </div>
                        <?php } ?>                            
                    </div>
                </div>
            </div>                
        </div>

        <div class="col-sm-8 col-sm-offset-5" style="margin-top:20px;">                                                            
            <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-cross2"></i>CLOSE</a>                                                
        </div> 
    </div>
</div>
<!-- END page-->
<script src="<?php echo base_url(); ?>assets/js/star-rating.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/owl1.js"></script>
