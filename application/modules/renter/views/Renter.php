<div class="loader" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
<div class="full-screen">
    <div class="main-content">
        <div class="signin-page signup-page renter-page">
            <div id="rootwizard" class="step-wizard">
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <ul>
                                <li><a href="#tab1" data-toggle="tab">1</a></li>
                                <li><a href="#tab2" data-toggle="tab">2</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="bar" class="progress">
                    <div
                        class="progress-bar progress-bar-success progress-bar-striped active"
                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                        aria-valuemax="100" style="width: 0%;">                            
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane rent-start" id="tab1">
                        <div class="container">
                            <!-- SIGN UP 1 STARTS -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h1 class="wow fadeInUp" data-wow-duration="1s"
                                        data-wow-delay=".2s">
                                        Thank <span>You!</span>
                                    </h1>
                                    <h2 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">You have selected to become a Renter.</h2>
                                    <h3 class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Are you ready?</h3>
                                    <p class="text-center wow bounceIn" data-wow-duration="1s" data-wow-delay="2s"><a href="#" class="btn btn-brand btn-press"><i class="icon-play"></i> START</a></p>
                                </div>
                                <div class="col-md-6">
                                    <h3 class="wow fadeInUp" data-wow-duration="1s"
                                        data-wow-delay=".6s">First we need to know a little about you
                                        and your driveway.</h3>
                                    <div class="rent-circles">
                                        <img
                                            src="<?php echo base_url() ?>assets/images/profile-graphics.png"
                                            class="rent1 wow zoomIn" data-wow-duration="1s"
                                            data-wow-delay=".8s" /> <img
                                            src="<?php echo base_url() ?>assets/images/info.png"
                                            class="rent2 wow fadeInUp" data-wow-duration="1s"
                                            data-wow-delay="1.2s" /> <img
                                            src="<?php echo base_url() ?>assets/images/driveway.png"
                                            class="rent3 wow fadeInRight" data-wow-duration="1s"
                                            data-wow-delay="1.4s" /> <img
                                            src="<?php echo base_url() ?>assets/images/amount.png"
                                            class="rent4 wow fadeInLeft" data-wow-duration="1s"
                                            data-wow-delay="1.4s" /> <img
                                            src="<?php echo base_url() ?>assets/images/check.png"
                                            class="rent5 wow fadeInDown" data-wow-duration="1s"
                                            data-wow-delay="1.2s" /> <img
                                            src="<?php echo base_url() ?>assets/images/listcheck.png"
                                            class="rent6 wow fadeInRight" data-wow-duration="1s"
                                            data-wow-delay="1.6s" /> <img
                                            src="<?php echo base_url() ?>assets/images/tuhmbs.png"
                                            class="rent7 wow fadeInLeft" data-wow-duration="1s"
                                            data-wow-delay="1.6s" />
                                    </div>
                                </div>
                            </div>
                            <!-- SIGN UP 1 ENDS -->
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="container">
                            <!-- SIGN UP 2 STARTS -->
                            <h1>Do you have a profile?</h1>
                            <h2>Everyone on LouiePark has a profile. If you already have one,
                                just sign in and we'll take you to the next step. If not, you'll
                                need to create one.</h2>
                            <div class="row">
                                <div class="col-md-6 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/parking-login.png" alt="parkrinu" class="img-responsive" />
                                </div>
                                <form action="<?php echo base_url(); ?>login/validate" class="login__form" method="post">
                                    <div class="col-md-4 signin-form">
                                        <div class="form-group">
                                            <script type="text/javascript">
                                                var baseUrl = "<?php echo base_url(); ?>";
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
                                                                        $('.loader').hide();
                                                                        parent.location = '<?php echo base_url('dashboard'); ?>';
                                                                    } else if (data.message == 'new') {
                                                                        $('.loader').hide();
                                                                        parent.location = '<?php echo base_url('renter/signup'); ?>';
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

                                                    }, {scope: 'email,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
                                                });
                                            </script>
                                            <a name="lnkViews" href="javascript:void(0);" class="btn btn-primary btn-social"><i class="icon-facebook"></i> Sign in with Facebook</a>
                                            <!--<a href="index.html" class="btn btn-primary btn-social"><i class="icon-facebook"></i> Sign in with Facebook</a>-->
                                        </div>
                                        <div class="form-group">
                                            <p class="help-block text-dash">
                                                <span>or use email</span>
                                            </p>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="inputUsername" class="login__input name" name="username" required> <label for="inputUsername">Username/Email</label> <span class="bar"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id="inputPassword" class="login__input pass" name="password" required> <label                for="inputPassword">Password</label> <span class="bar"></span>
                                        </div>
                                        <button type="submit" class="btn btn-brand">Sign In</button>
                                        <div>or</div>
                                        <a href="<?php echo base_url(); ?>renter/signup"    class="btn btn-brand">Create Account</a>
                                    </div>
                                </form>
                            </div>

                            <!-- SIGN UP 2 ENDS -->

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
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
