
<script type="text/javascript">
    var baseUrl = "<?php
echo base_url();
?>";
</script>
<div class="loader" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
<div class="full-screen">
    <div class="main-content single-page">
        <div class="triangles wow lightSpeedIn" data-wow-duration="1s"
             data-wow-delay="2s">
            <span class="triangle1"></span> <span class="triangle2"></span> <span
                class="triangle3"></span>
        </div>
        <div class="signin-page">
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".5s">Forgot Password?</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".7s">Recover your password at ease!</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 signin-graphics">
                        <img
                            src="<?php echo base_url(); ?>assets/images/sheild-question.png"
                            alt="LouiePark" class="img-responsive wow fadeInUp"
                            data-wow-duration="1s" data-wow-delay="1s" />
                    </div>
                    <div class="col-md-4 fancy-form signin-form wow fadeInRight"
                         data-wow-duration="1s" data-wow-delay="1.3s">
                        <div class="error_box"></div>
                        <form action="" method="post" class="forgot" name="forgot">
                            <div class="form-group">
                                <input type="email" name="email" id="email" required> <label
                                    for="inputUsername">Email</label> <span class="bar"></span>
                            </div>
                            <input type="submit" class="btn btn-brand btn-block" value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/validation.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/login.js"    type="text/javascript"></script>