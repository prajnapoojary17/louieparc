<div class="loader" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
<div class="full-screen">
    <div class="main-content">
        <div class="signin-page">
            <h1 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Reset
                Password</h1>
            <h2 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">Choose
                your new password for signing in.</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 signin-form wow fadeInRight"
                         data-wow-duration="1s" data-wow-delay="1.3s">
                             <?php
                             echo validation_errors();
                             if (isset($msg)) {
                                 echo '<div class="alert_error" style="display:block">' . "$msg" . '</div>';
                             }
                             ?>
                        <form action="" class="verify__form" method="post">
                            <div class="form-group">
                                <input type="text" name="verifyCode" id="verifyCode"> <label>Enter
                                    Your Verfy Code</label> <span class="bar"></span>
                            </div>
                            <input type="submit" class="btn btn-brand" value="reset" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>