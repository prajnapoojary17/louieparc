<script type="text/javascript">
    var baseUrl = "<?php
echo base_url();
?>";
</script>
<div class="full-screen">
    <div class="main-content single-page">
        <div class="triangles wow lightSpeedIn" data-wow-duration="1s"
             data-wow-delay="2s">
            <span class="triangle1"></span> <span class="triangle2"></span> <span
                class="triangle3"></span>
        </div>
        <div class="signin-page">
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".5s">Reset Password</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".7s">Choose your new password for signing in.</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 signin-graphics">
                        <img src="<?php echo base_url(); ?>assets/images/lock-reset.png"
                             alt="LouiePark" class="img-responsive wow fadeInUp"
                             data-wow-duration="1s" data-wow-delay="1s" />
                    </div>
                    <div class="col-md-4 fancy-form signin-form wow flipInX"
                         data-wow-duration="1s" data-wow-delay="1.3s">
                        <form action="" class="login__form" method="post">
                            <?php
                            echo validation_errors();
                            if (isset($msg)) {
                                echo '<div class="error_box" style="display:block">' . "$msg" . '</div>';
                            }
                            ?>
                            <div class="form-group">
                                <input type="password" name="password" id="password" required> <label>New Password</label> <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_conf" id="password_conf" required> <label>Confirm Password</label> <span class="bar"></span>
                            </div>
                            <input type="submit" class="btn btn-brand btn-block" value="Reset" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>