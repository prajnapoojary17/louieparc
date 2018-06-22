<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>

<div class="main-content">
    <div class="profile-settings">
        <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Write Review</h1>
        <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Please add your review below</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">    
                    <div class="error_box"></div>                
                    <div class="review-page">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="<?php
                                    if (isset($result->photo1)) {
                                        echo base_url() . 'assets/uploads/driveway/' . $result->photo1;
                                    } else {
                                        echo base_url() . 'assets/images/house.jpg';
                                    }
                                    ?>" alt="review">
                                </a>
                                </a>
                            </div>                    
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $result->firstName; ?>&nbsp;<?php echo $result->lastName; ?> </h4>
                                <p><?php echo $result->route . ' ' . $result->streetAddress . ' ' . $result->city . ', ' . $result->state . ' ' . $result->zip; ?></p>
                            </div>
                        </div>
                        <h3>Your experiences would really help other parker. Thanks!</h3>
                        <h4>Your overall rating of this place</h4>
                        <form method="post" name="reviews" class="reviews">
                            <div class="rate-review">
                                <label>Click to rate</label>
                                <input type="text" id="rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1">
                                <!--<input type="text" id="rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="1" data-size="xs">-->
                                <label class="starerror" for="rating" ></label>
                            </div>

                            <input type="hidden" id="starrating" name="starrating">
                            <input type="hidden" name="drivewayid" id="drivewayid" value="<?php echo $drivewayID; ?>">
                            <input type="hidden" name="bookingid" id="bookingid" value="<?php echo $bookingID; ?>">

                            <div class="form-group">
                                <input type="text" name="reviewtitle" id="reviewtitle">
                                <label>Title of your review</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <textarea rows="8" name="review" id="review"></textarea>
                                <label>Your review <small>(100 character minimum)</small></label>
                                <span class="bar"></span>
                            </div>
                            <button type="submit" class="btn btn-brand"><i class="icon-check22"></i>Submit </button>
                            <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-cross2"></i>Cancel </a>
                        </form>
                    </div>                        
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Bootstrap Star Rating -->
<script src="<?php echo base_url(); ?>assets/js/star-rating.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reviews.js"></script>