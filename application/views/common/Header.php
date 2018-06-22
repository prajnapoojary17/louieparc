<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<!-- 
Template Name: LOUIE PARK
Version: 1.0.0
Author: Glowtouch
-->
<html class="no-js">
    <!--<![endif]-->
    <head prefix='og: http://ogp.me/ns# fb: http://graph.facebook.com/schema/og/ article: http://graph.facebook.com/schema/og/article'>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>LOUIE PARK</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Quick and easy parking solutions" />
        <meta name="keywords" content="Louiepark" />
        <meta content='10209557712913428' property='fb:app_id'/>
        <meta property="og:title" content="LouiePark"/>
        <meta property="og:url" content="https://www.louiepark.com"/>
        <meta property="og:image" content="https://davidwalsh.name/wp-content/themes/klass/img/facebooklogo.png"/>
        <meta property="og:site_name" content="LouiePark"/>
        <meta property="og:description" content="Quick and easy parking solutions"/>	
        <meta property="og:type" content="parking"/>       
        <!-- Place favicon.ico and apple-touch-icon.png in the images favicon directory -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.ico">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url(); ?>assets/images/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url(); ?>assets/images/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>assets/images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/images/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon/favicon-16x16.png">
        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:100,400,300,700' rel='stylesheet' type='text/css'>
        <!-- Animate.css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/animate.css">
        <!-- Icomoon Icon Fonts-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/icomoon.css">
        <!-- bootstrap slider-->
        <!-- Bootstrap  -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-slider.min.css">
        <!-- Bootstrap Star Rating -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/star-rating.min.css">    
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.carousel.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/owl.theme.css">
        <!-- Bootstrap datepicker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css">
        <!-- Bootstrap timepicker -->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-timepicker.min.css" rel="stylesheet">
        <!-- Full Page -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.fullPage.css">

        <!-- Custom Style  -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fileinput.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">

        <!-- Modernizr JS -->
        <script src="<?php echo base_url(); ?>assets/js/modernizr-2.6.2.min.js"></script>


        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

        <!-- FOR IE9 below -->
        <!--[if lt IE 9]>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>  
    <body class="brand-page">
        <!-- Go to www.addthis.com/dashboard to customize your tools --> 

        <?php
        if (isset($_SESSION[LOGGED_IN]) && $_SESSION[LOGGED_IN] != NULL) {
            $data = $_SESSION[LOGGED_IN];
            $userId = $data['user_id'];
            $role = $data['role'];
            $profile = $data['profile'];
            $fb_token = $data['fb_token'];
        }
        ?>
        <nav class="fh5co-nav-style-1 wow fadeInDown" data-wow-duration="1s" data-wow-delay=".1s" role="navigation" data-offcanvass-position="fh5co-offcanvass-left" id="menu">
            <div class="container">
                <div class="col-md-2 fh5co-logo">
                    <a href="#" class="js-fh5co-mobile-toggle fh5co-nav-toggle"><i></i></a>
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="Louie Parc Logo" /></a>
                </div>
                <?php if (isset($userId)) { ?>
                    <div class="col-md-push-6 col-sm-4 col-sm-push-5 text-right fh5co-link-wrap">
                        <ul class="fh5co-special" data-offcanvass="yes">
                            <li class="dropdown log-link">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php
                                    echo base_url();
                                    if ($profile == '0') {
                                        ?>assets/images/avatar.png <?php
                                                                                                                                                         } else {
                                                                                                                                                             ?>assets/uploads/profilephoto/<?php
                                                                                                                                                             echo $profile;
                                                                                                                                                         }
                                                                                                                                                         ?>" class="login-avatar" /><span class="caret"></span><!--<span class="badge">4</span>--></a>
                                <ul class="dropdown-menu">                        
                                    <li><a href="<?php echo base_url(); ?>dashboard/reset">Change Password</a></li> 
                                    <script type="text/javascript">
                                        //Onclick for fb login
                                        $(document).on('click', 'a[name=lnkViews]', function (e) {

                                            window.fbAsyncInit = function () {
                                                //Initiallize the facebook using the facebook javascript sdk
                                                FB.init({
                                                    appId: '<?php
                                                                                                                                                     $this->config->load('facebook');
                                                                                                                                                     echo $this->config->item('appID');
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

                                            FB.getLoginStatus(function (response) {
                                                if (response && response.status === 'connected') {

                                                    FB.logout(function (response) {
                                                        document.location.reload();
                                                    });
                                                } else if (response.status === 'not_authorized')
                                                {
                                                    FB.logout(function (response) {
                                                        document.location.reload();
                                                    });
                                                }
                                            }); //permissions for facebook
                                        });
                                    </script>
                                    <li><a name="lnkViews" href="<?php echo base_url();
                                                                                                                                                     if ($fb_token) {
                                                                                                                                                             ?>dashboard/fbLogout/<?php } else {
                                                                                                                                                             ?>dashboard/logout/ <?php }
                                   ?>">Sign Out</a></li>
                                    <!-- <li><a href="profile-message.html">Message</a></li> -->
                                </ul>
                            </li>
                            <li class="nav-btn"><a href="<?php echo base_url(); ?>profile/addDriveway">Rent your Driveway</a></li>
                        </ul>
                    </div>

<?php } else { ?>
                    <div class="col-md-push-6 col-sm-4 col-sm-push-5 text-right fh5co-link-wrap">
                        <ul class="fh5co-special" data-offcanvass="yes">
                            <li class="log-link"><a href="<?php echo base_url(); ?>login" class="call-to-action">Sign in</a></li>
                            <li class="nav-btn"><a href="<?php echo base_url(); ?>renter">Rent your Driveway</a></li>
                        </ul>
                    </div>
<?php } ?>
                <div class="col-md-6 col-md-pull-4 col-sm-5 col-sm-pull-4 text-center fh5co-link-wrap">
                    <ul data-offcanvass="yes">
                        <li><a href="<?php echo base_url(); ?>driveway">Find a Driveway</a></li>
                        <li><a href="<?php echo base_url(); ?>dashboard">Profile</a></li>
                        <li><a href="<?php echo base_url(); ?>#page02">About</a></li>
                        <li><a href="<?php echo base_url(); ?>#page03">City Offerings</a></li>
                        <li><a href="<?php echo base_url(); ?>#page04">Safety</a></li>
                    </ul>
                </div> 
            </div>
        </nav>
