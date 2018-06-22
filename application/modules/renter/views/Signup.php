<script
src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places"></script>
<link type="text/css" rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<script type="text/javascript">
    var baseUrl = "<?php
echo base_url();
?>";</script>
<?php
if (isset($_SESSION [LOGGED_FB]) && $_SESSION [LOGGED_FB] != NULL) {
    $data = $_SESSION [LOGGED_FB];
    $fbId = $data ['fbId'];
    $fname = $data ['fname'];
    $lname = $data ['lname'];
    $fb_email = $data ['fb_email'];
    $role = $data ['role'];
    $profile = $data ['profile'];
}
?>
<div class="loader" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
<div class="main-content">
    <div class="signin-page signup-page renter-page">
        <div class="container">
            <form class="form-horizontal userForm" name="userForm" id="userForm">
                <span class="payment-errors"></span>
                <div id="rootwizard" class="step-wizard">

                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="container">
                                <ul>
                                    <li><a href="#tab1" data-toggle="tab">1</a></li>
                                    <li><a href="#tab2" data-toggle="tab">2</a></li>
                                    <li><a href="#tab3" data-toggle="tab">3</a></li>
                                    <li><a href="#tab4" data-toggle="tab">4</a></li>
                                    <li><a href="#tab5" data-toggle="tab">5</a></li>
                                    <li><a href="#tab6" data-toggle="tab">6</a></li>
                                    <li><a href="#tab7" data-toggle="tab">7</a></li>
                                    <li><a href="#tab8" data-toggle="tab">8</a></li>
                                    <li><a href="#tab9" data-toggle="tab">9</a></li>
                                    <li><a href="#tab10" data-toggle="tab">10</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="bar" class="progress">
                        <div
                            class="progress-bar progress-bar-success progress-bar-striped active"
                            role="progressbar" aria-valuenow="0" aria-valuemin="0"
                            aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                    <div class="tab-content">
                        <div class="CCServerError"></div>
                        <input type="hidden" value="" id="accessToken" name="accessToken">
                        <input type="hidden" name="role" id="role" value="2" /> <input
                            type="hidden" name="signupType" id="signupType"
                            value="Registered" /> <input type="hidden" name="userId"
                            id="userId" value="<?php
                            if (isset($userID)) {
                                echo $userID;
                            }
                            ?>" />
                        <input type="hidden" name="status" id="status" value="1" /> <input
                            type="hidden" name="flname" id="flname" value="" /> <input
                            type="hidden" name="verificationStatus" id="verificationStatus"
                            value="0" />
                        <div class="tab-pane" id="tab1">
                            <!-- SIGN UP 3 STARTS -->
                            <h1>Profile Info</h1>
                            <h2>Let's get started</h2>
                            <div class="row">
                                <div class="col-md-4 signin-graphics">
                                    <img
                                        src="<?php echo base_url(); ?>assets/images/profile-graphics.png"
                                        alt="profilerinu" class="img-responsive" />
                                </div>
                                <div class="col-md-4 signin-form">

                                    <?php if (!isset($fbId)) { ?>
                                        <script type="text/javascript">
                                            var baseUrl = "<?php
                                    echo base_url();
                                    ?>";
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
                                                            url: baseUrl + "login/facebook",
                                                            data: "accessToken=" + accessToken,
                                                            dataType: "json",
                                                            success: function (data) {
                                                                if (data.message == 'exist') {
                                                                    $('.loader').hide();
                                                                    parent.location = '<?php echo base_url('dashboard'); ?>';
                                                                } else if (data.message == 'new') {
                                                                    $('.loader').hide();
                                                                    parent.location = '<?php echo base_url(RENTER_SIGNUP); ?>';
                                                                } else {
                                                                    $('.loader').hide();
                                                                    parent.location = '<?php echo base_url(RENTER_SIGNUP); ?>';
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                        $('.loader').hide();
                                                        parent.location = '<?php echo base_url(RENTER_SIGNUP); ?>';
                                                        //if permission Not Allowed
                                                    }

                                                }, {scope: 'email,user_birthday,user_location,user_work_history,user_hometown,user_photos'}); //permissions for facebook
                                            });
                                        </script>
                                        <div class="form-group">
                                            <a name="lnkViews" href="javascript:void(0);"
                                               class="btn btn-primary btn-social"><i class="icon-facebook"></i>
                                                Sign Up with Facebook</a>
                                            <!--
                                            <button type="button" class="btn btn-primary btn-social center-block" id="fb-signup"><i class="icon-facebook"></i> Sign up with Facebook</button>
                                            -->
                                        </div>
                                        <div class="form-group">
                                            <p class="help-block text-dash text-small">
                                                <span>OR</span>
                                            </p>
                                        </div>
                                    <?php } ?>                                                          
                                    <div class="form-group">
                                        <input type="email" id="email" name="email"
                                               value="<?php
                                               if (isset($fb_email)) {
                                                   echo $fb_email;
                                               }
                                               ?>"
                                               tabindex="1" required> <label for="inputEmail">Email</label>

                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" id="password" name="password"
                                               tabindex="2" required> <label for="inputPassword">Password</label>

                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" id="rpassword" name="rpassword"
                                               tabindex="3" required> <label for="inputConfirmPassword">Confirm
                                            Password</label> <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="username" name="username"
                                               value="<?php
                                               if (isset($userName)) {
                                                   echo $userName;
                                               }
                                               ?>"
                                               tabindex="4" required> <label for="inputUsername">Username</label>

                                        <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="contactnum" name="contactnum" value=""
                                               tabindex="5" required>
                                           <!--    <input data-inputmask="'mask': '(99) 9999-9999'" id="contactnum" name="contactnum" required /> -->
                                        <label for="inputMobile">Mobile Phone</label> <span
                                            class="bar"></span>
                                    </div>


                                </div>
                                <div class="col-md-4 signin-form">

                                    <div class="form-group">
                                        <div class="profile-pic">
                                            <div class="pic">
                                                <img src="<?php
                                                if (isset($profile)) {
                                                    echo $profile;
                                                } else {
                                                    echo base_url() . 'assets/images/avatar.png';
                                                }
                                                ?>" alt="Profile" required />
                                            </div>
                                            <input type="hidden" class="fbProfile" name="fbProfile"
                                                   value="<?php
                                                   if (isset($profile)) {
                                                       echo $profile;
                                                   }
                                                   ?>"> <input
                                                   type="file" class="profImage" name="profImage" value=""
                                                   tabindex="0"> <a href="#" class="upload-button">Change Image</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="firstName" name="firstName"
                                               value="<?php
                                               if (isset($fname)) {
                                                   echo $fname;
                                               }
                                               ?>" tabindex="6" required> 
                                        <label for="inputfname">First Name</label> <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="lastName" name="lastName"
                                               value="<?php
                                               if (isset($lname)) {
                                                   echo $lname;
                                               }
                                               ?>" tabindex="7" required> 
                                        <label for="inputlname">Last Name</label> <span class="bar"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- SIGN UP 3 ENDS -->

                        </div>
                        <div class="tab-pane" id="tab2">

                            <!-- SIGN UP 4 STARTS -->

                            <h1>Let's get to know you</h1>
                            <h2>We'd like to learn more about you before you can rent your
                                driveway. This should be quick!</h2>
                            <div class="row">
                                <div class="col-md-4 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/info.png"
                                         alt="profilerinu" class="img-responsive" />
                                </div>
                                <div class="col-md-6 col-md-offset-2">
                                    <div class="row form-wrapper">
                                        <label>Date of Birth</label>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-select">
                                                    <select name="bmonth" id="bmonth">
                                                        <option value="0">Month</option>
                                                        <option value="1">January</option>
                                                        <option value="2">February</option>
                                                        <option value="3">March</option>
                                                        <option value="4">April</option>
                                                        <option value="5">May</option>
                                                        <option value="6">June</option>
                                                        <option value="7">Jully</option>
                                                        <option value="8">August</option>
                                                        <option value="9">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="custom-select">
                                                    <select name="bday" id="bday">
                                                        <option value="0">Day</option>
                                                        <?php
                                                        for ($i = 1; $i <= 31; ++$i) :

                                                            if ($i < 10) {
                                                                $day = "0" . $i;
                                                            }
                                                            ?>
                                                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                            <?php
                                                            ++$day;
                                                        endfor;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="custom-select">
                                                    <select name="byear" id="byear">
                                                        <option value="0">Year</option>
                                                        <?php
                                                        $year = date("Y") - 60;

                                                        for ($i = 0; $i <= 42; ++$i) :
                                                            ?>
                                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>

                                                            <?php
                                                            ++$year;
                                                        endfor
                                                        ;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-wrapper" id="address">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input class="field has-value" id="h_name" name="h_name"
                                                       required> <label for="inputlname">Building/House Name</label>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <label>Enter street number,route name,city and select</label>
                                        <label style="font-size: 12px;">(Sample : 350 5th Avenue, New
                                            York, NY 10118, United States)</label>
                                        <div id="locationField">
                                            <input id="autocomplete" class="form-control field has-value "
                                                   name="autocomplete" placeholder="Enter your street address" type="text" required>
                                        </div>
                                        <br />
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="has-value" id="street_number"
                                                       name="streetaddres" readonly> <label for="inputlname">Street
                                                    Address / Street Number</label> <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input name="route" class="has-value" id="route" readonly> <label
                                                    for="inputlname">Route</label> <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input name="city" class="has-value" id="locality" readonly>
                                                <label for="inputlname">City</label> <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input class="field has-value"
                                                       id="administrative_area_level_1" name="state"
                                                       disabled="true" readonly> <label for="inputlname">State</label>
                                                <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input class="field has-value" name="zip" id="postal_code"
                                                       readonly> <label for="inputlname">Zip Code</label> <span
                                                       class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input class="field has-value" id="country" disabled="true"
                                                       readonly> <label for="inputlname">Country</label> <span
                                                       class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h5>How did you hear about LouiePark?</h5>
                                    <div class="radio-group">
                                        <label class="control control-radio"> <input type="radio"
                                                                                     id="hearfrom" name="hearfrom" value="Mail"> Mail Order
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                    <div class="radio-group">
                                        <label class="control control-radio"> <input type="radio"
                                                                                     id="hearfrom" name="hearfrom" value="Social Media"> Social
                                            Media
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                    <div class="radio-group">
                                        <label class="control control-radio"> <input type="radio"
                                                                                     id="hearfrom" name="hearfrom"
                                                                                     value="Advertisement on the street"> Advertisement on the
                                            street
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                    <div class="radio-group">
                                        <label class="control control-radio"> <input type="radio"
                                                                                     id="hearfrom" name="hearfrom" value="Word of mouth"> Word of
                                            mouth
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                    <div class="radio-group">
                                        <label class="control control-radio"> <input type="radio"
                                                                                     id="hearfrom" name="hearfrom" value="Other"> Other
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- SIGN UP 4 ENDS -->
                        </div>
                        <div class="tab-pane" id="tab3">
                            <!-- SIGN UP 5 STARTS -->
                            <h1>About your driveway</h1>
                            <h2>
                                We need to know about your driveway now. Be aware, you can only
                                rent a driveway YOU own. <br />Sorry, you can't rent your
                                neighbors..
                            </h2>
                            <div class="row">
                                <div class="col-md-4 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/driveway.png"
                                         alt="profilerinu" class="img-responsive" />
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" id="slot" name="slot"                                         
                                               required> <label for="inputSlot">Enter Number of parking slots</label>

                                        <span class="bar"></span>
                                    </div>

                                </div>

                                <div class="col-md-8">
                                    <h5>Are you renting the same driveway you listed previously for
                                        your Address?</h5>
                                    <div class="radio-group">
                                        <label class="control control-radio"> <input type="radio"
                                                                                     name="about" value="yes" /> Yes
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                    <div class="radio-group">
                                        <label class="control control-radio"> <input type="radio"
                                                                                     name="about" value="no" id="no-rental" /> No, its a rental
                                            property I have
                                            <div class="control_indicator"></div>
                                        </label>
                                    </div>
                                    <br>
                                    <div id="rental-container" style="display: none;">
                                        <div class="row form-wrapper">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input class="field has-value" id="d_name" name="d_name"
                                                           required> <label for="inputlname">Building/House Name</label>
                                                    <span class="bar"></span>
                                                </div>
                                            </div>
                                            <label>Enter street number,route name,city and select</label>
                                            <label style="font-size: 12px;">(Sample : 350 5th Avenue, New
                                                York, NY 10118, United States)</label>
                                            <div id="locationField">
                                                <input id="autocomplete2" class="form-control"
                                                       name="autocomplete2"
                                                       placeholder="Enter your street address"    type="text">
                                            </div>
                                            <br />
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input class="field has-value" id="street_number2"
                                                           name="rent_streetaddres" readonly> <label for="inputlname">Street
                                                        Address / Street Number</label> <span class="bar"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input name="route2" class="field has-value" id="route2"
                                                           readonly> <label for="inputlname">Route</label> <span
                                                           class="bar"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input name="rent_city" class="field has-value"
                                                           id="locality2" readonly> <label for="inputlname">City</label>
                                                    <span class="bar"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input class="field has-value"
                                                           id="administrative_area_level_12" name="rent_state"
                                                           disabled="true" readonly> <label for="inputlname">State</label>
                                                    <span class="bar"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input class="field has-value" name="rent_zip"
                                                           id="postal_code2" readonly> <label for="inputlname">Zip
                                                        Code</label> <span class="bar"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <input class="field has-value" name="country2"
                                                           id="country2" disabled="true" readonly> <label
                                                           for="inputlname">Country</label> <span class="bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SIGN UP 5 ENDS -->

                        </div>
                        <div class="tab-pane" id="tab4">

                            <!-- SIGN UP 6 STARTS -->

                            <h1>About your driveway</h1>
                            <h4>Great! Now you need to entice renters. Please provide some
                                photos, a brief description and instructions on where to park
                                their car once they arrive. Don't worry, you can always go back
                                and edit these later.</h4>
                            <h5>Photos</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="drivewayphotos" class="file"    name="drivewayphotos[]" type="file" multiple>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Instruction for Image Upload</h5>
                                    <br />
                                    <p>
                                        You can add upto four photos of your driveway.<br /> Browse
                                        and select single/multiple photos or Drag and drop photos.<br />
                                        Click on Upload button after you have selected all photos. <br />
                                        You can skip this step for now, but if you provide parking
                                        area pictures it will be helpful for parkers.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group form-placeholder">
                                        <label>Description of your driveway</label>
                                        <textarea class="max-text" maxlength="240" id="description"
                                                  name="description"
                                                  placeholder="This can include things like why you are renting, location of your driveway, if you live in safe area, etc.."
                                                  required></textarea>
                                        <span class="bar"></span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-placeholder">
                                        <label>Instructions for the driver</label>
                                        <textarea class="max-text" maxlength="240" id="instructions"
                                                  name="instructions"
                                                  placeholder="Ex. Please park on the right side of the driveway; Park in front of the mailbox; Pull you car to the back of my driveway and park to the left."
                                                  required></textarea>
                                        <span class="bar"></span>
                                    </div>
                                </div>
                            </div>
                            <h5>Do you need the driver keys? Dont worry we will come back to this.</h5>
                            <!-- SIGN UP 6 ENDS -->

                        </div>
                        <div class="tab-pane" id="tab5">
                            <!-- SIGN UP 7 STARTS -->
                            <h1>How much?</h1>
                            <h2>How much money does your driveway cost?</h2>
                            <div class="row">
                                <div class="col-md-4 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/amount.png"
                                         alt="profilerinu" class="img-responsive" />
                                </div>
                                <div class="col-md-4 col-md-offset-4">
                                    <div class="form-group">
                                        <input type="text" id="currency" maxlength="7" name="flatprice"
                                               required> <label>Set flat price</label> <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="currency1" maxlength="7" name="hourlyprice" style="text-align: right;" required> <label>Set hourly price</label> <span class="bar"></span>
                                    </div>
                                    <p>On LouiePark, we give users two options: to rent hourly or rent based on a flat rate.</p>
                                    <p>A flat rate price is what you are willing to charge for someone to stay in your driveway for at least 24 hours. Someone who is traveling, going to a concert or sporting event might choose to rent this way.</p>
                                    <p>Hourly rates on LouiePark act just like a regular parking garage. Set the price you are willing to charge a renter for every hour they stay in your driveway. This might come in handy when someone is parking for work or going out on a Friday night . Remember, the hourly price should be lower than your flat rate price.</p>
                                </div>
                            </div>

                            <!-- SIGN UP 7 ENDS -->

                        </div>
                        <div class="tab-pane" id="tab6">
                            <!-- SIGN UP 8 STARTS -->
                            <h1>We're almost done!</h1>
                            <h2>Hang in there! Just a few more things.</h2>
                            <h3>You are almost done! We just need to go over some important
                                rules and regulations with you. Are you ready?</h3>
                            <!-- SIGN UP 8 ENDS -->

                        </div>
                        <div class="tab-pane" id="tab7">
                            <h1>Payment Method</h1>
                            <h2>Set up a Your Bank account Details!</h2>
                            <h4><a href="#" class="gonext2">Skip for now..</a></h4>
                            <div class="row">
                                <div class="col-md-3 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/payment.png" alt="profilerinu" class="img-responsive" />
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6 signin-form">
                                            <div class="form-group">
                                                <input type="hidden" id="cardResult"> 
                                                <input type="hidden" id="card_type" name="card_type">
                                                <input type="text" id="card_number" name="card_number" data-stripe="number"    required> <label>Account Number</label> <span class="bar"></span>
                                            </div>
                                            <div class="form-group">                                                
                                                <input type="text" id="ssn_last_4" name="ssn_last_4" required>
                                                <label>Last 4 digits ssn Number</label> <span class="bar"></span>
                                            </div>                                           
                                            <div class="form-group">
                                                <input type="text" id="routing_number" name="routing_number" required>
                                                <label>Routing Number</label>
                                                <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="acc_fname" name="acc_fname" required>
                                                <label>First Name</label> <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="acc_lname" name="acc_lname" value="" required>
                                                <!--<input data-inputmask="'mask': '(99) 9999-9999'" id="billing_phone" name="billing_phone" required/>-->
                                                <label>Last Name</label> <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-select">
                                                    <select name="accHolderType" id="accHolderType">
                                                        <option value="0">Account Holder Type</option>
                                                        <option value="individual">Individual</option>
                                                        <option value="company">Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="business" style="display:none">
                                                <div class="form-group" >
                                                    <input type="text" id="business_name" name="business_name" required>
                                                    <label>Business Name</label>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group" >
                                                    <input type="text" id="business_tax_id" name="business_tax_id" required>
                                                    <label>Business Tax ID</label>
                                                    <span class="bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 signin-form">
                                            <!-- <div class="form-group">
                                                 <input type="text" id="card_type" name="card_type" required>
                                                 <label>Card Type</label>
                                                 <span class="bar"></span>
                                               </div>-->                                              
                                            <div class="form-group">
                                                <input type="text" id="acc_address1" name="acc_address1" required> <label for="inputfname">Line 1</label>
                                                <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="acc_address2" name="acc_address2" required> <label for="inputfname">Line 2</label>
                                                <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="acc_city" name="acc_city" required> <label for="inputfname">City</label>
                                                <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="acc_state" name="acc_state" required> <label for="inputlname">State</label> 
                                                <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="acc_zip" name="acc_zip" required> <label for="inputlname">Postal Code</label> 
                                                <span class="bar"></span>
                                            </div>Date Of Birth
                                            <div class="form-group cc-group">
                                                <div class="row form-wrapper">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="custom-select">
                                                                <select name="amonth" id="amonth">
                                                                    <option value="0">Month</option>
                                                                    <option value="1">January</option>
                                                                    <option value="2">February</option>
                                                                    <option value="3">March</option>
                                                                    <option value="4">April</option>
                                                                    <option value="5">May</option>
                                                                    <option value="6">June</option>
                                                                    <option value="7">Jully</option>
                                                                    <option value="8">August</option>
                                                                    <option value="9">September</option>
                                                                    <option value="10">October</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">December</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="custom-select">
                                                                <select name="aday" id="aday">
                                                                    <option value="0">Day</option>
                                                                    <?php
                                                                    for ($i = 1; $i <= 31; ++$i) :

                                                                        if ($i < 10) {
                                                                            $day = "0" . $i;
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                                        <?php
                                                                        ++$day;
                                                                    endfor;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <div class="custom-select">
                                                                <select name="ayear" id="ayear">
                                                                    <option value="0">Year</option>
                                                                    <?php
                                                                    $year = date("Y") - 60;

                                                                    for ($i = 0; $i <= 42; ++$i) :
                                                                        ?>
                                                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>

                                                                        <?php
                                                                        ++$year;
                                                                    endfor
                                                                    ;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                            </form>
                                        </div>
                                    </div>    
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="tab8">

                            <!-- SIGN UP 10 STARTS -->
                            <h1>Things to know</h1>
                            <h2>We have some details we want you to be aware of.</h2>
                            <div class="row">
                                <div class="col-md-4 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/listcheck.png"
                                         alt="profilerinu" class="img-responsive" />
                                </div>
                                <div class="col-md-8">
                                    <h5>You understand that LouiePark takes 15% off of each transaction that occurs along with a small processing charge. The remaining balance goes to you.</h5>
                                    <label class="control control-checkbox"> <input type="checkbox"
                                                                                    name="chkbox1" id="chkbox1" required /> * by clicking you
                                        agree
                                        <div class="control_indicator"></div>
                                    </label><br/><br/>
                                    <h5>You understand that by having your driveway set to live will allow individuals to rent it out. You understand that you can turn your driveway off by going into driveway settings in your profile. You also understand that you are responsible for your driveway, not LouiePark.</h5>
                                    <label class="control control-checkbox"> <input type="checkbox"
                                                                                    name="chkbox2" id="chkbox2" required /> * by clicking you
                                        agree
                                        <div class="control_indicator"></div>
                                    </label><br/><br/>                                    
                                    <h5><a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Agreement</a></h5>
                                    <label class="control control-checkbox"> <input type="checkbox"
                                                                                    name="chkbox4" id="chkbox4" required /> * by clicking you
                                        agree
                                        <div class="control_indicator"></div>
                                    </label>
                                </div>
                            </div>
                            <!-- SIGN UP 10 ENDS -->

                        </div>
                        <div class="tab-pane" id="tab9">

                            <!-- SIGN UP 11 STARTS -->
                            <h1>User Terms & Agreements</h1>
                            <h2>Please read over these and check that you agree.</h2>
                            <div class="terms-condition"> <p>This
                                    License Agreement details the Terms and Conditions which you, the
                                    User, hereby accept prior to the use of the LouiePark mobile device
                                    application (&ldquo;app&rdquo; or &ldquo;application&rdquo;), any
                                    LouiePark services, or the LouiePark website.</p>
                                <p>PLEASE
                                    READ THIS AGREEMENT CAREFULLY. BY USING THE APPLICATION, USING THE
                                    SERVICES, OR ACCESSING THE CONTENT YOU:</p>
                                <ul>
                                    <li/>
                                    <p>ACKNOWLEDGE
                                        THAT YOU HAVE READ AND UNDERSTAND THIS AGREEMENT;</p>
                                    <li/>
                                    <p>REPRESENT
                                        THAT YOU ARE 18 YEARS OF AGE OR OLDER;</p>
                                    <li/>
                                    <p>ACCEPT
                                        THIS AGREEMENT.</p>
                                </ul>
                                <p>IF
                                    YOU HAVE QUESTIONS AS TO THE MEANING OF THIS AGREEMENT OR IF YOU DO
                                    NOT AGREE TO THESE TERMS, YOU ARE NOT PERMITTED TO AND YOU SHALL NOT
                                    USE THE APPLICATION, USE THE SERVICES, OR ACCESS THE CONTENT AND YOU
                                    MUST IMMEDIATELY DELETE THE APPLICATION AND THE CONTENT FROM YOUR
                                    MOBILE DEVICE.</p>
                                <p>CAUTION:
                                    USING YOUR MOBILE DEVICE WHILE DRIVING IS DANGEROUS AND UNLAWFUL.
                                    NEVER USE LOUIEPARK OR ANY APP WHILE DRIVING.&nbsp; DISTRACTED
                                    DRIVING IS DANGEROUS, UNLAWFUL, AND A MAJOR CAUSE OF TRAFFIC
                                    ACCIDENTS.</p>
                                <p>1.&nbsp;&nbsp;
                                    About LouiePark</p>
                                <p>LouiePark
                                    is a Kentucky LLC with its registered and executive offices at 13100
                                    Magisterial Drive, Suite 104, Louisville, Kentucky 40223.&nbsp;
                                    LouiePark provides a service that allows users to advertise/publish
                                    the availability of &ldquo;Spots&rdquo;.&nbsp; As used herein the
                                    term &ldquo;Spot&rdquo; is defined as any physical location
                                    including, but not limited, to parking spots, driveway spots, curb
                                    cut spots, garage spots, or any other physical location of any type.</p>
                                <p>YOU
                                    ACKNOWLEDGE AND AGREE THAT LOUIEPARK IS NOT SELLING, PROVIDING,
                                    FURNISHING, RESELLING, RENTING, ACTING AS A BROKER FOR, OR OTHERWISE
                                    PROVIDING YOU PARKING OR ACCESS TO PARKING. LOUIEPARK DOES NOT MANAGE
                                    OR PROVIDE YOU WITH ANY PARKING, ANY ACCESS TO PARKING, OR ANY
                                    INFORMATION ABOUT PARKING ITSELF. YOU ACKNOWLEDGE AND AGREE THAT
                                    LOUIEPARK ONLY PROVIDES A PLATFORM FOR SHARING INFORMATION ABOUT
                                    PARKING AVAILABILITY FROM OTHER USERS OF THE SERVICE AND HAS NO MEANS
                                    OF VERIFYING THE ACCURACY OF SUCH INFORMATION OR CONTROLLING THE
                                    ACTIONS OF ITS USERS. YOU ACKNOWLEDGE AND AGREE THAT LOUIEPARK IS NOT
                                    A PARTY TO ANY TRANSACTIONS BETWEEN ANY USERS, INCLUDING ANY THAT
                                    INVOLVE YOU.</p>
                                <p>YOU
                                    ACKNOWLEDGE AND AGREE THAT YOU AND EACH USER IS RESPONSIBLE FOR HIS
                                    OR HER OWN ACTIONS AND OMISSIONS WHILE USING THE APPLICATION AND/OR
                                    THE SERVICES.</p>
                                <p>2.&nbsp;&nbsp;
                                    License</p>
                                <p>You
                                    agree that use of the app is via a license. You are granted a
                                    limited, non-exclusive right to use the app without any charge.
                                    LouiePark shall have the sole right to terminate your right to use
                                    the app without cause and you agree to remove the app from your
                                    mobile device immediately upon notification from LouiePark that your
                                    license has been terminated. LouiePark shall have the right to
                                    exercise this right of termination at any time without prior notice.</p>
                                <p>Your
                                    use of the app under the license shall be in compliance with all
                                    legal requirements pertaining to the location where you are using the
                                    app.&nbsp; By using the app you recognize that LouiePark is not
                                    providing any advice or representation as to legalities of
                                    transaction or advertising and you are hereby specifically holding
                                    LouiePark harmless and indemnifying LouiePark from any liability with
                                    respect to any transaction using the LouiePark app, the platform, or
                                    the website.</p>
                                <p>The
                                    LouiePark platform allows for different services in different
                                    communities based on local statutes.&nbsp; In the event any
                                    municipality determines that use of the LouiePark platform is
                                    contrary to any statute or regulation then LouiePark will take
                                    whatever action it deems necessary to modify its service in order to
                                    comply with applicable regulations.&nbsp; In the event LouiePark
                                    makes any modification in its platform, for any reason whatsoever,
                                    user agrees that it will have no claim against LouiePark for any
                                    change in service or cancellation of any service.</p>
                                <p>3.&nbsp;&nbsp;
                                    Downloading the Application via the Apple App Store or iTunes or via
                                    the Google Play Store</p>
                                <p>You
                                    agree that downloading, installing, and using the app shall be in
                                    full compliance with the Terms and Conditions and the Privacy Policy
                                    of the applicable platform.&nbsp; You hereby agree that you have
                                    carefully reviewed the Terms and Conditions on the applicable Apple
                                    App Store website, the iTunes website, or the Google Play website.&nbsp;
                                    The various Terms and Conditions and Privacy Policies are hereby
                                    incorporated into this agreement and can be viewed using these links:</p>
                                <p>Google
                                    Play Terms of
                                    Service:&nbsp;&nbsp;<a href="https://play.google.com/intl/en_us/about/play-terms.html" target="_blank"><u>https://play.google.com/intl/en_us/about/play-terms.html</u></a></p>
                                <p>Google
                                    Play Privacy
                                    Policy:&nbsp;&nbsp;<a href="http://www.google.com/intl/en_us/policies/privacy/" target="_blank"><u>http://www.google.com/intl/en_us/policies/privacy/</u></a></p>
                                <p>Apple
                                    Terms of
                                    Service:&nbsp;&nbsp;&nbsp;<a href="http://www.apple.com/legal/internet-services/terms/site.html" target="_blank"><u>http://www.apple.com/legal/internet-services/terms/site.html</u></a></p>
                                <p>Apple
                                    Privacy Policy:&nbsp;&nbsp;&nbsp;<a href="http://www.apple.com/legal/privacy/en-ww/" target="_blank"><u>http://www.apple.com/legal/privacy/en-ww/</u></a></p>
                                <p>4.&nbsp;&nbsp;
                                    Collection and Use of Your Information</p>
                                <p>You
                                    acknowledge that when you download, install, or use the application,
                                    LouiePark may use automatic means like cookies and web beacons to
                                    collect information about your mobile devices and about your use of
                                    the application. You also may be required to provide certain
                                    information about yourself as a condition to downloading, installing
                                    or using the application or certain of its features or functionality,
                                    including, without limitation, payment information in order to
                                    purchase parking information, and the application may provide you
                                    with opportunities to share information about yourself with others.
                                    All information LouiePark collects through or in connection with this
                                    application is subject to LouiePark&rsquo;s privacy policy. By
                                    downloading, installing, using, providing information to or through
                                    this application, using the services, viewing the content, or any
                                    combination of the foregoing, you consent to all actions taken by us
                                    with respect to your information in compliance with the privacy
                                    policy.</p>
                                <p>5.&nbsp;&nbsp;
                                    Updates</p>
                                <p>From
                                    time-to-time, LouiePark, in its sole and absolute discretion, may
                                    develop and provide application updates to its app. These updates may
                                    add, modify, or delete features and functionality. Updates may be
                                    designed to install automatically on your mobile device.</p>
                                <p>You
                                    agree that LouiePark has no obligation to provide any updates or to
                                    continue to provide or enable any particular features or
                                    functionality.&nbsp; You also agree that updates will be deemed part
                                    of the application and be subject to all terms and conditions of this
                                    agreement.</p>
                                <p>6.&nbsp;&nbsp;
                                    Third Party Content and Information</p>
                                <p>The
                                    LouiePark application makes available third-party content.&nbsp; You
                                    acknowledge and agree that LouiePark is not responsible for
                                    third-party materials, including, without limitation, their accuracy,
                                    completeness, timeliness, validity, copyright compliance, legality,
                                    decency, quality, or any other aspect thereof. LouiePark does not
                                    assume and will not have any liability or responsibility to you or
                                    any other person or entity for any third-party materials. LouiePark
                                    provides third-party materials solely as a convenience to you and you
                                    access and use them entirely at your own risk and subject to such
                                    third parties&rsquo; own terms and conditions.</p>
                                <p>7.&nbsp;&nbsp;
                                    User Generated Content</p>
                                <p>LouiePark
                                    does not endorse any users or any information provided by said users.
                                    LouiePark does not attempt to confirm and does not confirm the
                                    identity of any user or accuracy of any information posted, or
                                    anything else about the user or the information the user is providing
                                    through the Services or the Application.</p>
                                <p>LouiePark&rsquo;s
                                    app allows you to post, submit, publish, display, or transmit to
                                    other users of the app information or content. You acknowledge and
                                    agree that you are responsible for any and all of the information you
                                    provide via the app.</p>
                                <p>Any
                                    user generated information you post on or through the app will be
                                    considered non-confidential and non-proprietary. By posting any
                                    information you grant LouiePark and LouiePark&rsquo;s affiliates the
                                    right to use, reproduce, modify, perform, display, distribute, and
                                    otherwise disclose to third parties any such material for any
                                    purpose.</p>
                                <p>You
                                    agree that any information you post is accurate and you agree that
                                    any responsibility for the accuracy and appropriateness of the
                                    information posted is completely yours.&nbsp; You agree to indemnify
                                    LouiePark from any claims for damages resulting from information
                                    posted by you via the app or the website.</p>
                                <p>You
                                    hereby agree that:</p>
                                <ul>
                                    <li/>
                                    <p>You
                                        own or control all rights in and to the user contributions and have
                                        the right to grant the license granted above to LouiePark and
                                        LouiePark&rsquo;s affiliates and service providers and each of their
                                        respective licensees, successors, and assigns.</p>
                                    <li/>
                                    <p>You
                                        understand and acknowledge that you are responsible for any
                                        information you submit or contribute, and you, not LouiePark, have
                                        full responsibility for such content, including, without limitation,
                                        its legality, reliability, accuracy, and appropriateness.</p>
                                    <li/>
                                    <p>LouiePark
                                        is not responsible, or liable to any third party, for the content or
                                        accuracy of any information posted by you or any other user of the
                                        application or the services.</p>
                                </ul>
                                <p>LouiePark
                                    has the right to:</p>
                                <ul>
                                    <li/>
                                    <p>remove
                                        or refuse to post any user contributions for any or no reason in
                                        LouiePark&rsquo;s sole and absolute discretion</p>
                                    <li/>
                                    <p>take
                                        any action with respect to any user contribution that LouiePark
                                        deems necessary or appropriate in LouiePark&rsquo;s sole and
                                        absolute discretion</p>
                                    <li/>
                                    <p>disclose
                                        your identity or other information about you to any third party who
                                        claims that material posted by you violates their rights, including,
                                        without limitation, their intellectual property rights or their
                                        right to privacy</p>
                                    <li/>
                                    <p>take
                                        appropriate legal action, including, without limitation, referral to
                                        law enforcement, for any illegal or unauthorized use of the
                                        application, the services, or the content</p>
                                    <li/>
                                    <p>at
                                        LouiePark&rsquo;s sole discretion terminate or suspend your access
                                        to all or part of the app service for any or no reason</p>
                                </ul>
                                <p>Without
                                    limiting the foregoing, posted information must not:</p>
                                <ul>
                                    <li/>
                                    <p>contain
                                        any material that is defamatory, obscene, indecent, abusive,
                                        offensive, harassing, violent, hateful, inflammatory, or otherwise
                                        objectionable</p>
                                    <li/>
                                    <p>promote
                                        sexually explicit or pornographic material, violence, or
                                        discrimination based on race, sex, religion, nationality,
                                        disability, sexual orientation, or age</p>
                                    <li/>
                                    <p>infringe
                                        any patent, trademark, trade secret, copyright, or other
                                        intellectual property, or other rights of any other person</p>
                                    <li/>
                                    <p>violate
                                        the legal rights (including, without limitation, the rights of
                                        publicity and privacy) of others or contain any material that could
                                        give rise to any civil or criminal liability under Applicable Laws
                                        or that otherwise may be in conflict with this Agreement or the
                                        Privacy Policy</p>
                                    <li/>
                                    <p>be
                                        likely to deceive any person</p>
                                    <li/>
                                    <p>promote
                                        any illegal activity, or advocate, promote, or assist any unlawful
                                        act</p>
                                    <li/>
                                    <p>cause
                                        annoyance, inconvenience, or needless anxiety or be likely to upset,
                                        embarrass, alarm, or annoy any other person</p>
                                    <li/>
                                    <p>impersonate
                                        any person, or misrepresent your identity or affiliation with any
                                        person or organization</p>
                                    <li/>
                                    <p>involve
                                        commercial activities or sales, such as contests, sweepstakes and
                                        other sales promotions, barter, or advertising not directly related
                                        to the application or the services and expressly authorized by
                                        LouiePark</p>
                                    <li/>
                                    <p>give
                                        the impression that your contribution emanates from or is endorsed
                                        by LouiePark or any other person or entity, if this is not the case</p>
                                </ul>
                                <p><span style="background: #ffff00">8.&nbsp;&nbsp;
                                        Financial Terms</span></p>
                                <p><span style="background: #ffff00">When
                                        you use the LouiePark app you will have the option to </span><span style="background: #ffff00">move</span><span style="background: #ffff00">
                                        funds </span><span style="background: #ffff00">from</span><span style="background: #ffff00">
                                        your LouiePark account managed by </span><span style="background: #ffff00">Stripe,
                                        Inc.</span><span style="background: #ffff00">
                                        to your perso</span><span style="background: #ffff00">nal
                                        bank account</span><span style="background: #ffff00">
                                        for use in acquiring information intended to allow you to obtain a
                                        priva</span><span style="background: #ffff00">tely
                                        owned</span><span style="background: #ffff00">
                                    </span><span style="background: #ffff00">s</span><span style="background: #ffff00">pot
                                        from another user.</span></p>
                                <p><span style="background: #ffff00">LouiePark
                                        does not sell </span><span style="background: #ffff00">s</span><span style="background: #ffff00">pots.
                                        LouiePark is selling information that will allow you to obtain a
                                        privately owned </span><span style="background: #ffff00">s</span><span style="background: #ffff00">pot
                                        from another user. Any payments made are for </span><span style="background: #ffff00">s</span><span style="background: #ffff00">pot
                                        information, not for the purchase of any Spots. The charge for the
                                        information is set by, and agreed to, by the users, not LouiePark.</span></p>
                                <p><span style="background: #ffff00">Upon
                                        the completion of any transaction between LouiePark users, </span><span style="background: #ffff00">Stripe,
                                        Inc</span><span style="background: #ffff00">
                                        will facilitate the transfer of funds between the users. As
                                        consideration for facilitating the listing and the transfer LouiePark
                                        will retain </span><span style="background: #ffff00">15</span><span style="background: #ffff00">%
                                        of the proceeds as an advertising/listing/posting fee, while Stripe</span><span style="background: #ffff00">,
                                        Inc takes their processing fee of the payment.</span><span style="background: #ffff00">
                                    </span><span style="background: #ffff00">T</span><span style="background: #ffff00">he
                                        rem</span><span style="background: #ffff00">aining</span><span style="background: #ffff00">
                                        balance will be paid to the appropriate user&rsquo;s account.</span></p>
                                <p><span style="background: #ffff00">In
                                        the event any governmental agency determines that taxes of any sort
                                        are payable then, if required by said agencies, LouiePark will
                                        withhold said tax or fee and transfer the proceeds in compliance with
                                        applicable laws.</span></p>
                                <p><span style="background: #ffff00">It
                                        is agreed that payments into your LouiePark account from your credit
                                        card, debit card, or electronic bank transfer are for advertising
                                        services and/or for the purchase of posted information.</span></p>
                                <p><span style="background: #ffff00">By
                                        using the app to transfer funds to LouiePark you are authorizing
                                        LouiePark to use the information you provide to initiate and process
                                        a charge or debit to your account.</span></p>
                                <p><span style="background: #ffff00">Refunds:&nbsp;LouiePark
                                        users can transfer funds from their LouiePark account to their bank
                                        account by visiting the LouiePark website and providing their bank
                                        account information.&nbsp; Transfers will be initiated within 3 days.
                                        Transfers can only be made to bank accounts with the same named title
                                        as the LouiePark user.&nbsp;At the sole discretion of LouiePark,
                                        LouiePark shall have the option, but not the responsibility, to
                                        credit funds back to the credit/debit card used to pay for the
                                        LouiePark services.</span></p>
                                <p><span style="background: #ffff00">Notwithstanding
                                        any other provisions of this agreement, LouiePark&rsquo;s maximum
                                        liability to any user shall be limited to the fee charged to the
                                        user.</span></p>
                                <p><span style="background: #ffff00">9.&nbsp;&nbsp;
                                    </span><span style="background: #ffff00">Private
                                        Listings Only</span></p>
                                <p><span style="background: #ffff00">There
                                        are certain locations in which it is illegal to buy and sell public
                                        street parking spaces or information related to the availability of
                                        spaces.&nbsp;</span><span style="background: #ffff00">T</span><span style="background: #ffff00">he
                                        LouiePark app has been customized to only allow for the exchange o</span><span style="background: #ffff00">f
                                        information </span><span style="background: #ffff00">o</span><span style="background: #ffff00">n</span><span style="background: #ffff00">
                                        pr</span><span style="background: #ffff00">ivately
                                        owned driveways or spots</span><span style="background: #ffff00">.</span></p>
                                <p><span style="background: #ffff00">Pogs
                                        are awarded free to every new user irrespective of where the user is
                                        located.&nbsp; Currently, every new user is awarded 1 Pog&nbsp;upon
                                        registration.&nbsp; These Pogs can only be used in markets which have
                                        been specifically designated as free street parking locales.&nbsp;
                                        Currently these markets include New York City, Boston, Chicago, and
                                        San Francisco.&nbsp; LouiePark reserves the right to modify this list
                                        via additions and deletions without notice.</span></p>
                                <p><span style="background: #ffff00">
                                        In
                                        matters related to abuse of the LouiePark platform the option to
                                        terminate the user&rsquo;s account shall be at the sole discretion of
                                        LouiePark and LouiePark shall not be required to provide any reason
                                        for, or advance notice of, so doing.</span></p>
                                <p><span style="background: #ffff00">LouiePark
                                        shall, at all times, have the right to award </span><span style="background: #ffff00">promotional
                                        codes</span><span style="background: #ffff00">
                                        to users for marketing purposes.</span></p>
                                <p>11.&nbsp;&nbsp;
                                    General Compliance and Safety</p>
                                <p>While
                                    using or accessing the application you agree at all times:</p>
                                <ul>
                                    <li/>
                                    <p>to
                                        comply with all applicable laws</p>
                                    <li/>
                                    <p>not
                                        to operate the application while you are driving or when it is
                                        otherwise unsafe for you to do so</p>
                                    <li/>
                                    <p>to
                                        consult and comply with all regulations relating to parking,
                                        traffic, or the use or misuse of parking spaces</p>
                                    <li/>
                                    <p>not
                                        to obstruct traffic or impede anyone from parking in a valid space</p>
                                    <li/>
                                    <p>not
                                        to reserve or attempt to reserve a parking space, or prevent any
                                        vehicle from parking on a public street through your presence in the
                                        roadway, the use of hand-signals, or by placing any box, can,
                                        create, handcart, dolly, or any other device, including, without
                                        limitation, unauthorized pavement curb or street markings or signs
                                        in the roadway</p>
                                    <li/>
                                    <p>not
                                        to threaten, deter, or intimidate any other person in order to
                                        prevent them from access or using a parking space</p>
                                    <li/>
                                    <p>to
                                        act in a safe and responsible manner</p>
                                    <li/>
                                    <p>to
                                        keep your login credentials for accessing your account confidential
                                        and not share them with any other person</p>
                                    <li/>
                                    <p>not
                                        to submit any information with any fraudulent, deceptive, false,
                                        misleading, or illegal information</p>
                                    <li/>
                                    <p>recruit
                                        or otherwise solicit any users of the Services or the application to
                                        use any third-party service, competing or otherwise</p>
                                    <li/>
                                    <p>not
                                        to harm or misuse or attempt to harm or misuse the application or
                                        the Services</p>
                                    <li/>
                                    <p>not
                                        to display or mirror any of the Content or any other proprietary
                                        information without LouiePark&rsquo;s express written consent</p>
                                    <li/>
                                    <p>not
                                        to use or display LouiePark&rsquo;s trademarks without LouiePark&rsquo;s
                                        express written consent</p>
                                    <li/>
                                    <p>not
                                        to use the application or the content for any commercial purposes
                                        other than those permitted by this agreement</p>
                                </ul>
                                <p>12.&nbsp;&nbsp;
                                    Disclaimer of Warranties</p>
                                <p>THE
                                    APPLICATION, THE SERVICES, AND THE CONTENT ARE PROVIDED TO LICENSEE
                                    &ldquo;AS IS&rdquo; AND WITH ALL FAULTS AND DEFECTS WITHOUT WARRANTY
                                    OF ANY KIND. TO THE MAXIMUM EXTENT PERMITTED UNDER APPLICABLE LAW.
                                    LOUIEPARK, ON ITS OWN BEHALF AND ON BEHALF OF ITS AFFILIATES AND ITS
                                    AND THEIR RESPECTIVE LICENSORS AND SERVICE PROVIDERS, EXPRESSLY
                                    DISCLAIMS ALL WARRANTIES, WHETHER EXPRESS, IMPLIED, STATUTORY, OR
                                    OTHERWISE, WITH RESPECT TO THE APPLICATION, THE SERVICES, OR THE
                                    CONTENT, INCLUDING, WITHOUT LIMITATION, ALL IMPLIED WARRANTIES OF
                                    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE AND
                                    NON-INFRINGEMENT, AND WARRANTIES THAT MAY ARISE OUT OF COURSE OF
                                    DEALING, COURSE OF PERFORMANCE, USAGE, OR TRADE PRACTICE. WITHOUT
                                    LIMITATION TO THE FOREGOING, LOUIEPARK PROVIDES NO WARRANTY OR
                                    UNDERTAKING, AND MAKES NO REPRESENTATION OF ANY KIND THAT THE
                                    APPLICATION WILL MEET YOUR REQUIREMENTS, ACHIEVE ANY INTENDED
                                    RESULTS, BE COMPATIBLE OR WORK WITH ANY OTHER SOFTWARE, APPLICATIONS,
                                    SYSTEMS, OR SERVICES, OPERATE WITHOUT INTERRUPTION, MEET ANY
                                    PERFORMANCE OR RELIABILITY STANDARDS, BE ERROR FREE, THAT ANY ERRORS
                                    OR DEFECTS CAN OR WILL BE CORRECTED, OR COMPLY WITH THE LAW OF YOUR
                                    JURISDICTION.</p>
                                <p>SOME
                                    JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF OR LIMITATIONS ON IMPLIED
                                    WARRANTIES OR THE LIMITATIONS ON THE APPLICABLE STATUTORY RIGHTS OF A
                                    CONSUMER, SO SOME OR ALL OF THE ABOVE EXCLUSIONS AND LIMITATIONS MAY
                                    NOT APPLY TO YOU.</p>
                                <p>WITHOUT
                                    LIMITATION TO THE FOREGOING, LOUIEPARK EXPLICITLY DISCLAIMS ANY AND
                                    ALL WARRANTIES OR ANY RESPONSIBILITIES ABOUT CONTENT OR OTHER
                                    INFORMATION, INCLUDING, WITHOUT LIMITATION, THAT SUCH INFORMATION IS
                                    ACCURATE OR UP-TO-DATE.</p>
                                <p>13.
                                    &nbsp; Limitation of Liability</p>
                                <p>TO
                                    THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT WILL
                                    LOUIEPARK OR ITS OFFICERS, MANAGERS, MEMBERS, EMPLOYEES, AGENTS,
                                    REPRESENTATIVES, AFFILIATES, SUBSIDIARIES, PARENTS, SUCCESSORS, AND
                                    ASSIGNS, OR ANY OF ITS OR THEIR RESPECTIVE LICENSORS OR SERVICE
                                    PROVIDERS, HAVE ANY LIABILITY ARISING FROM OR RELATED TO YOUR MISUSE
                                    OF, USE OF, DOWNLOAD OF, INSTALLATION OF, OR INABILITY TO USE THE
                                    APPLICATION OR THE CONTENT AND SERVICES.</p>
                                <p>14.
                                    &nbsp; Indemnification</p>
                                <p>You
                                    agree to indemnify, defend, and hold harmless LouiePark and its
                                    officers, managers, members, employees, agents, representatives,
                                    affiliates, subsidiaries, parents, successors, and assigns from and
                                    against any and all losses, damages, liabilities, deficiencies,
                                    claims, actions, judgments, settlements, interest, awards, penalties,
                                    fines, costs, or expenses of whatever kind, including, without
                                    limitation, reasonable attorneys&rsquo; fees, arising from or
                                    relating to your use or misuse of the Application</p>
                                <p>15.
                                    &nbsp; Severability</p>
                                <p>If
                                    any provision of this agreement is illegal or unenforceable under
                                    applicable law, the remainder of the provision will be amended to
                                    achieve as closely as possible the effect of the original term and
                                    all other provisions of this Agreement will continue in full force
                                    and effect.</p>
                                <p>16.
                                    &nbsp; Governing Law</p>
                                <p>LouiePark
                                    LLC is organized under the laws of the State of Delaware.&nbsp; It is
                                    agreed that this Agreement is governed by and construed in accordance
                                    with the laws of the State of Delaware.&nbsp; Any legal action or
                                    proceeding arising out of or related to this agreement shall be
                                    instituted exclusively in the federal courts of the United States or
                                    the courts of the State of Delaware, County of New Castle</p>
                                <p>17.
                                    &nbsp; Entire Agreement</p>
                                <p>This
                                    Agreement and the Privacy Policy constitute the entire agreement
                                    between you and LouiePark with respect to the application, the
                                    Services, and the Content and your use thereof.</p>
                                <p>This
                                    Agreement and the Privacy Policy supersede all prior or
                                    contemporaneous understandings and agreements, whether written or
                                    oral, with respect to the Application, the Services, the Content, or
                                    your use thereof.&nbsp; From time to time the terms of this agreement
                                    may change.&nbsp; Please be sure to consult this agreement before
                                    making any LouiePark transaction.</p>
                                <p>Any
                                    questions, complaints, or claims with respect to the application can
                                    be made to the following:</p>
                                <p>LouiePark
                                    LLC</p>
                                <p>Attention:
                                    Chief Executive Officer</p>
                                <p>13100
                                    Magisterial Drive Suite 104</p>
                                <p>Louisville,
                                    Kentucky 40223</p>
                                <p>Phone
                                    -</p>
                                <p>Email
                                    -</p>
                                <p>Revised:
                                    11.30.16</p></div>
                            <label class="control control-checkbox"> <input type="checkbox"
                                                                            name="agreement" id="agreement" required /> * by clicking you
                                agree
                                <div class="control_indicator"></div>
                               
                            </label>

                            <!-- SIGN UP 11 ENDS -->

                        </div>
                        <div class="tab-pane" id="tab10">

                            <!-- SIGN UP 12 STARTS -->

                            <h1>You're almost done!</h1>
                            <h2>Click on 'Finish' button to become a renter on LouiePark.</h2>                            
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/tuhmbs.png"
                                         alt="profilerinu" class="img-responsive" />
                                </div>
                            </div>
                            <!-- SIGN UP 12 ENDS -->
  <div class="g-recaptcha" data-sitekey="6LdyExUUAAAAAD9qrBz1iWBAcYW5r_4A9T192cPW"></div>
                        </div>
                        
                        <input type="hidden" name="stripeError" id="stripeError" value="0" />
                        <input type="hidden" name="stripeToken" id="stripeToken" value="" />
                        <ul class="pager wizard wow fadeInUp" data-wow-duration="1s"
                            data-wow-delay="1s">
                            <li class="previous"><a href="javascript:;" class="btn"><i
                                        class="icon-arrow-left22"></i>Previous</a></li>

                            <li class="next CCUserNext"><a href="#" class="btn" id="linkNext">Next
                                    <i class="icon-arrow-right22"></i>
                                </a></li>
                            <li class="finish CCUserSave"><a href="#" class="btn"
                                                             id="linkSubmit">Finish</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.      
    //   var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    var placeSearch, autocomplete, autocomplete2;

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                        (document.getElementById('autocomplete')), {
                    types: ['geocode']
                });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', function () {
            $("label[for='autocomplete']").html('');
            // $(".CCServerError").html('');            
            fillInAddress(autocomplete, "");
        });

        autocomplete2 = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */
                        (document.getElementById('autocomplete2')), {
                    types: ['geocode']
                });
        autocomplete2.addListener('place_changed', function () {
            $("label[for='autocomplete2']").html('');
            $(".CCServerError").html('');
            fillInAddress(autocomplete2, "2");
        });
    }

    function fillInAddress(autocomplete, unique) {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            if (!!document.getElementById(component + unique)) {
                document.getElementById(component + unique).value = '';
                document.getElementById(component + unique).disabled = false;
            }
        }

        // Get each component of the address from the place details and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType] && document.getElementById(addressType + unique)) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType + unique).value = val;
            }
        }
    }
    google.maps.event.addDomListener(window, "load", initAutocomplete);

</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo base_url(); ?>assets/js/renter.js" type="text/javascript"></script>
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


