<?php
if (isset($_SESSION [LOGGED_IN]) && $_SESSION [LOGGED_IN] != NULL) {
    $data = $_SESSION [LOGGED_IN];
    $userId = $data ['user_id'];
}
?>
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
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
                data-wow-delay=".5s">Want to reset your Password?</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".7s">Change your password at ease!</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 signin-graphics">
                        <img
                            src="<?php echo base_url(); ?>assets/images/sheild-question.png"
                            alt="LouiePark" class="img-responsive wow fadeInUp"
                            data-wow-duration="1s" data-wow-delay="1s" />
                    </div>
                    <div class="error_box"></div>
                    <div class="col-md-4 fancy-form signin-form wow fadeInRight"
                         data-wow-duration="1s" data-wow-delay="1.3s">
                        <form action="<?php echo base_url() ?>dashboard/reset"
                              class="change_pass" method="post">
                                  <?php
                                  echo validation_errors();
                                  if (isset($msg)) {
                                      echo '<div class="alert_error" style="display:block">' . "$msg" . '</div>';
                                  }
                                  ?>
                            <div class="form-group">
                                <input type="hidden" name="userID" id="userID"
                                       value="<?php echo $userId; ?>" /> <input type="password"
                                       name="old_password" id="old_password" required> <label>Current
                                    Password</label> <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" required> <label>New
                                    Password</label> <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password_conf" id="password_conf"
                                       required> <label>Confirm Password</label> <span class="bar"></span>
                            </div>
                            <input type="submit" class="btn btn-brand btn-block"
                                   value="Reset" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/validation.js" type="text/javascript"></script>
