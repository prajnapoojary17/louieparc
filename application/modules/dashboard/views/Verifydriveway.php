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
                data-wow-delay=".5s">Verify your Driveway</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s"
                data-wow-delay=".6s">Please enter the 5 digit code emailed you below</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 signin-graphics">
                        <img src="<?php echo base_url(); ?>assets/images/verify.png"
                             alt="LouiePark" class="img-responsive wow fadeInUp"
                             data-wow-duration="1s" data-wow-delay="1s" />
                    </div>
                    <div class="col-md-4 fancy-form signin-form wow flipInX"
                         data-wow-duration="1s" data-wow-delay="1.3s">
                        <div class="error_box"></div>
                        <form class="wow fadeInUp verify" name="verify"
                              data-wow-duration="1s" data-wow-delay=".9s">
                                  <?php
                                  echo validation_errors();
                                  if (isset($msg)) {
                                      $error = 1;
                                      echo '<div class="error_box" style="display:block">' . "$msg" . '</div>';
                                  } else {
                                      $error = 0;
                                  }
                                  ?>
                            <div class="form-group">
                                <input type="hidden" name="userID" id="userID" value="<?php echo $userId; ?>" /> 
                                <input type="hidden" name="drivewayID" id="drivewayID" value="<?php echo $drivewayID; ?>" /> 
                                <input type="text"  name="vcode" <?php
                                if ($error == 1) {
                                    echo "disabled";
                                }
                                ?>> <label>Verification Code</label> 
                                <span class="bar"></span>
                            </div>
                            <input type="submit" class="btn btn-brand btn-block"
                                   value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/verifydriveway.js"
type="text/javascript"></script>
