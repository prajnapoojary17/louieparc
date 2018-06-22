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
    <div class="main-content signin-landing settings-page">
        <div class="signin-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 signin-graphics">
                        <img
                            src="<?php echo base_url(); ?>assets/images/signing-login.png"
                            alt="LouiePark" class="img-responsive wow zoomIn"
                            data-wow-duration="1s" data-wow-delay="1s" />
                    </div>
                    <div class="col-md-6 signin-form wow fadeInRight"
                         data-wow-duration="1s" data-wow-delay="1.3s">
                        <h1>
                            Sign in <span>to Create your Louie Park Account</span>
                        </h1>
                        <h2>We connect the renters with the rentees</h2>
                        <div class="row">
                            <div class="col-md-9">
                                <form action="<?php echo base_url(); ?>login/validate"
                                      class="login__form" method="post">
                                    <div class="form-group">
                                        <script type="text/javascript">
                                            //Onclick for fb login
                                            $(document).on('click', 'a[name=lnkViews]', function (e) {

                                                FB.login(function (response) {
                                                    if (response.authResponse) {
                                                        $('.loader').show();
                                                        //if permission Allowed
                                                        var accessToken = response.authResponse.accessToken;
                                                        var thesession = response.session;
                                                        var thesession = eval('(' + thesession + ')'); //decode json
                                                        //POSTing to local file login/facebook, to fetch user info
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "login/facebook",
                                                            data: "accessToken=" + accessToken,
                                                            dataType: "json",
                                                            success: function (data) {
                                                                if (data.message == 'exist') {
                                                                    parent.location = '<?php echo base_url('dashboard'); ?>';
                                                                } else if (data.message == 'new') {

                                                                    parent.location = '<?php echo base_url('parker'); ?>';
                                                                } else {
                                                                    $('.loader').hide();
                                                                    parent.location = '<?php echo base_url('login'); ?>';
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                        $('.loader').hide();
                                                        parent.location = '<?php echo base_url('login'); ?>';
                                                        //if permission Not Allowed
                                                    }

                                                }, {scope: 'email,user_birthday,user_location,user_work_history,user_hometown,user_photos'}, {perms: 'user_address, user_mobile_phone'}); //permissions for facebook
                                            });
                                        </script>
                                        <a name="lnkViews" href="javascript:void(0);"
                                           class="btn btn-primary btn-social"><i class="icon-facebook"></i>
                                            Sign in with Facebook</a></div>
                                    <div class="form-group">
                                        <p class="help-block text-dash"><span>or use email</span></p> 
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        echo validation_errors();
                                        if (isset($success)) {
                                            echo '<div class="alert_error" style="display:block">You have successfully reset your password</div>';
                                        }
                                        ?>    
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="inputUsername"
                                               class="login__input name" name="username" required> <label
                                               for="inputUsername">Username/Email</label> <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" value="" id="accessToken"
                                               name="accessToken"> <input type="password" id="inputPassword"
                                               class="login__input pass" name="password" required> <label
                                               for="inputPassword">Password</label> <span class="bar"></span>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-brand btn-block login__submit "><i class="icon-login"></i>Sign In</button>
                                    <div class="form-group">
                                        <p class="help-block">
                                            Forgot password? <a
                                                href="<?php echo base_url(); ?>login/forgot" class="forgot_click">click here</a>
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <p class="help-block">
                                            No Profile? <a href="<?php echo base_url(); ?>parker">Sign Up</a>
                                        </p>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>

</div>
</div>
<script src="<?php echo base_url() ?>assets/js/validation.js" type="text/javascript"></script>
<script>
                                            $(document).ready(function () {
                                                window.fbAsyncInit = function () {
                                                    //Initiallize the facebook using the facebook javascript sdk
                                                    FB.init({
                                                        appId: '<?php
                                        $this->config->load('facebook');
                                        echo $this->config->item('facebook_app_id');
                                        ?>',
                                                        cookie: true, // enable cookies to allow the server to access the session
                                                        status: true, // check login status
                                                        xfbml: true, // parse XFBML
                                                        oauth: true //enable Oauth
                                                    });
                                                };
                                                //Read the baseurl from the config.php file
                                                (function (d) {
                                                    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                                                    if (d.getElementById(id)) {
                                                        return;
                                                    }
                                                    js = d.createElement('script');
                                                    js.id = id;
                                                    js.async = true;
                                                    js.src = "//connect.facebook.net/en_US/all.js";
                                                    ref.parentNode.insertBefore(js, ref);
                                                }(document));
                                            });
</script>
