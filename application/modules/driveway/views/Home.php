<style>
    .driveway-contact1 {
        background: #0f4683 none repeat scroll 0 0;
        color: #ffffff;
        margin: 0 30px;
        padding: 20px;
    }
    .driveway-contact1 .alert-brand {
        background: rgba(255, 255, 255, 0.1) none repeat scroll 0 0;
    }
    .driveway-contact1 .alert-brand h4 {
        color: #ffffff;
    }
    .driveway-contact1 > h4 {
        background: #333333 none repeat scroll 0 0;
        color: #ffffff;
        font-weight: 800;
        margin: 0 -30px 20px;
        padding: 10px 20px;
        position: relative;
        text-shadow: 1px 1px 0 #000000;
        text-transform: uppercase;
    }
    .driveway-contact1 > h4::after {
        border-color: rgba(0, 0, 0, 0) #000000 rgba(0, 0, 0, 0) rgba(0, 0, 0, 0);
        border-style: solid;
        border-width: 0 10px 10px 0;
        content: "";
        display: inline-block;
        height: 0;
        left: 0;
        position: absolute;
        top: 100%;
        width: 0;
    }
    .driveway-contact1 > h4::before {
        border-color: #000000 transparent transparent transparent;
        border-style: solid;
        border-width: 10px 10px 0 0;
        content: "";
        display: inline-block;
        height: 0;
        right: 0;
        position: absolute;
        top: 100%;
        width: 0;
    }
    .driveway-contact1 .alert-brand span {
        background: rgba(255, 255, 255, 0.2) none repeat scroll 0 0;
        border-radius: 50%;
        color: #ffffff;
        display: inline-block;
        line-height: 70px;
        min-height: 75px;
        min-width: 75px;
        text-align: center;
    }
    .driveway-contact1 > h3 {
        color: #ffffff;
    }
    .driveway-contact1 > h5 {
        background: rgba(255, 255, 255, 0.1) none repeat scroll 0 0;
        color: #ffffff;
        padding: 5px 10px;
    }

</style>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=geometry,places&ext=.js"></script>
<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/markerwithlabel/src/markerwithlabel.js"></script>
<script type="text/javascript">
    var locations = <?php echo json_encode($locations); ?>;
    var baseUrl = "<?php echo base_url(); ?>";
    var totalDays = <?php echo TOTAL_BOOKING_DAYS ?>;
</script>
<?php
$driveway_id = '';
$fromDate = '';
$fromTime = '';
$toDate = '';
$toTime = '';
$price = '';
$totalPrice = '';
$ownerId = '';
$totalHours = '';
$option = '';
$grandTotal = '';
if (isset($_SESSION[DRIVEWAY_SEARCH]) && $_SESSION[DRIVEWAY_SEARCH] != NULL) {
    $data = $_SESSION[DRIVEWAY_SEARCH];
    $driveway_id = $data['driveway_id'];
    $fromDate = $data['fromDate'];
    $fromTime = $data['fromTime'];
    $toDate = $data['toDate'];
    $toTime = $data['toTime'];
    $price = $data['price'];
    $totalPrice = $data['totalPrice'];
    $ownerId = $data['ownerId'];
    $filterPrice = $data['filterPrice'];
    $location = $data['location'];
    $totalHours = $data['totalHours'];
    $latitude = $data['latitude'];
    $longitude = $data['longitude'];
    $option = $data['option'];
    $stripefees = $data['stripefees'];
    $stripeprocessingfees = $data['stripeprocessingfees'];
    $applicationfees = $data['applicationfees'];
    $proc_fee_before = (($stripefees / 100) * $totalPrice) + $stripeprocessingfees + $applicationfees;
    $grandTotalBefore = $proc_fee_before + $totalPrice;
    $proc_fee = (($stripefees / 100) * $grandTotalBefore) + $stripeprocessingfees + $applicationfees;
    $grandTotal = $proc_fee + $totalPrice;
}
if (isset($_SESSION[LOGGED_IN]) && $_SESSION[LOGGED_IN] != NULL) {
    $data = $_SESSION[LOGGED_IN];
    $userId = $data['user_id'];
    ?>
    <input type="hidden" id="loggedUser" name="loggedUser" value="<?php echo $userId ?>"><?php
}
?>

<div class="loader wait" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
<div class="loader login" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please login...
    </div>
</div>
<div class="main-content driveway-page">
    <div class="signin-page signup-page">
        <div id="rootwizard" class="step-wizard">
            <div class="container">
                <div class="navbar">
                    <div class="navbar-inner">
                        <ul>
                            <li><a href="#tab1" data-toggle="tab">1</a></li>
                            <li><a href="#tab2" data-toggle="tab">2</a></li>
                            <li><a href="#tab3" data-toggle="tab">3</a></li>
                            <li><a href="#tab4" data-toggle="tab">Go!</a></li>
                            <span></span>
                        </ul>
                    </div>
                </div>
                <div id="bar" class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane" id="tab1">
                    <input type="hidden" id="date_valid">
                    <input type="hidden" id="prangeset">
                    <input type="hidden" id="hchargeset">
                    <input type="hidden" id="totalPrice">
                    <input type="hidden" id="proc_fee">
                    <input type="hidden" id="latitude">
                    <input type="hidden" id="longitude">
                    <input type="hidden" id="searchType">
                    <input type="hidden" id="timecheck">
                    <input type="hidden" id="location">
                    <input type="hidden" id="rentagain">
                    <div class="driveway-banner"></div>
                    <div class="container-fluid">
                        <!-- SIGN UP 1 STARTS -->
                        <div class="row">
                            <div class="col-lg-4 col-md-5" id="driveway-search">
                                <h2 class="sub-title">Find a driveway near you!</h2>
                                <h2>Click on driveway for more information</h2>
                                <div class="price-range">
                                    <h3>Set your search criteria</h3>
                                    <div class="price-container">
                                        <input type="text" id="pricerange" name="pricerange" data-provide="slider" data-slider-ticks="[1, 2, 3]" data-slider-ticks-labels='["$0 - 10", "$11 - 20", "$21+"]' data-slider-min="1" data-slider-max="3" data-slider-step="1" data-slider-value="3" data-slider-tooltip="hide" />
                                        <div class="input-location">
                                            <span style="color:red;" id="error"></span>
                                            <input id="pac-input" class="form-control controls controls" type="text" placeholder="Enter a location">
                                        </div>
                                        <h4>Set your booking date & time</h4>
                                        <span style="color:red;" id="errMessage" ></span>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-group input-daterange">
                                                    <input type="text"  data-date-format='yy-mm-dd' id="date1" name="date1" class="form-control startdate"  value="08/05/2015" placeholder="Start Date" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input type="text" id="time1" name="time1" class="form-control timepicker timepicker-no-seconds" readonly="true"
                                                           >
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button"><i class="icon-clock-o"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="input-group input-daterange">
                                                    <input type="text" id="date2" name="date2" <?php echo $toDate ?> class="form-control"  placeholder="End Date" readonly="true">                                      
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group">
                                                    <input type="text" id="time2" name="time2" class="form-control timepicker timepicker-no-seconds" readonly="true">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button"><i class="icon-clock-o"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="radio-group radio-inline">
                                            <label class="tooltips" data-html="true" title="Are you trying to decide which rate to use? <br> <b>Hourly </b>- Select hourly if you know exactly what time you are going to arrive and leave. Most people will use this if they are only staying for a few hours. Just make sure you leave during the selected time! <br><br> <b>Recurring</b>- With recurring parking, you are charged by the hour, however, you may come and go as you please. This is great when parking for a meeting or going to take a lunch break during work. Remember, you must leave at your selected time. <br><br> <b>Flat Rate</b> - Flat rate pricing charges you for 24 hours of parking. This is great for travel, concerts, sporting events, or conventions where you don’t want to feel rushed. You still need to select and arrival time and a return time, but give yourself some breathing room when doing this; you can always leave before your return time because you’re charged for a full day. Flat rate prices make parking way easier and less stressful." style="font-size: 20px; margin-top: 10px;">
                                                <i class="icon-question-circle"></i>
                                            </label>
                                        </div>
                                        <div class="radio-group radio-inline">
                                            <label class="control control-radio">
                                                <input type="radio" id="hour" class="hour" name="bookingoption" value="1"> Hourly
                                                <div class="control_indicator"></div>
                                            </label>
                                        </div>
                                        <div class="radio-group radio-inline">
                                            <label class="control control-radio">
                                                <input type="radio" id="recurr" class="recurr" name="bookingoption" value="2"> Recurring
                                                <div class="control_indicator"></div>
                                            </label>
                                        </div>
                                        <div class="radio-group radio-inline">
                                            <label class="control control-radio">
                                                <input type="radio" id="flat" class="flat" name="bookingoption" value="3"> Flat rate
                                                <div class="control_indicator"></div>
                                            </label>
                                        </div>
                                        <div><span style="color:red;" id="errMessage1" ></span></div> 
                                        <p> <a  id="driveway-go" class="btn btn-brand btn-danger gobtn" title="Search Driveway" onclick="filterval()" href="#"><i class="icon-thumbs-o-up"></i>Go! </a>  </p>
                                        <!-- <button class="btn btn-brand" type="button" onclick="filterval()"  name="Go!" >
                                             &nbsp;<i class="icon-thumbs-o-up">&nbsp;&nbsp;GO!</i>
                                         </button>-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-7" id="driveway-map">
                                <div class="driveway-map">
                                    <p id="driveway-back"><a href="#" class="btn btn-brand btn-danger"><i class="icon-search"></i>Search Again</a></p>
                                    <ul class="pager wizard" style="position: absolute; right: 20px; display:none">
                                        <li class="next"><a href="#" class="btn">Next</a></li>
                                    </ul>
                                    <div>     
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SIGN UP 1 ENDS -->
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="container">
                        <div class="CCServerError"></div>
                        <!-- SIGN UP 2 STARTS -->
                        <div class="row">
                            <div class="col-md-3">
                                <h2>About the driveway</h2>
                                <h1 class="price-circle"><label for="myvalue">$14</label></h1>
                                <h3><label for="myname"></label><a data-toggle="modal" data-target="#viewModal"><i class="icon-info-with-circle"></i></a></h3>
                            </div>
                            <div class="col-md-8">
                                <div class="desc-block">
                                    <ul>
                                        <li>Driveway Address: <span><label for="address"></label></span></li>
                                        <li class="searchlocation">Search Location: <span><label for="searchlocation"></label></span></li>
                                    </ul>
                                    <ul>
                                        <li>Search From/To: <span><label for="fromdate"></label>&nbsp;<label for="fromtime"></label></span> /   <span><label for="todate"></label>&nbsp;<label for="totime"></label></span> Search Timezone: <span><label for="userzone"></label></span></li>
                                        <!--<li>Searched To: <span><label for="todate"></label>&nbsp;<label for="totime"></label></span></li>-->
                                    </ul>
                                    <ul>
                                        <li>Check-In/Check-Out Date: <span><label for="checkindate"></label></span> / <span><label for="checkoutdate"></label></span> Driveway Timezone: <span><label for="timezone"></label></span></li>
                                    <!--    <li>Checkout Date: <span><label for="checkoutdate"></label></span></li> -->
                                    </ul>
                                    <ul>
                                        <li><span><label for="message"></label></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="slider">
                                    <div class="owl-carousel testimonial-owl owl-image">
                                        <div class="item1">
                                            <figure class="figure-container"><img src="" alt="LouiePark1" id="slide1" class="img-responsive"> </figure>
                                        </div>
                                        <div class="item2">
                                            <figure class="figure-container"><img src="" alt="LouiePark2" id="slide2" class="img-responsive"></figure>
                                        </div>
                                        <div class="item3">
                                            <figure class="figure-container"><img src="" alt="LouiePark3" id="slide3" class="img-responsive"> </figure>
                                        </div>
                                        <div class="item4">
                                            <figure class="figure-container"><img src="" alt="LouiePark4" id="slide4" class="img-responsive"></figure>
                                        </div>
                                    </div>
                                </div>
                                <div class="star-rating">
                                    <label>Rating</label>
                                    <input type="text" id="input-3" name="input-3" class="rating-loading" value="">
                                    <!--<input type="text" id="rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="1" data-size="xs">-->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Description</h5>
                                <p for="description"></p>
                                <h5>Instruction</h5>
                                <p for="instruction"></p>
                                <a href="#" id="keeplooking" class="btn btn-brand goprevious"><i class="icon-eye22"></i>Keep looking</a>
                                <a href="#" class="btn btn-brand gonext rentDriveway"><i class="icon-home2"></i>Rent Driveway!</a>
                            </div>
                        </div>
                    </div>
                    <div class="testimonials">
                        <div class="container">
                            <h1>Reviews</h1>
                            <div class="row">
                                <div id="review"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab3">
                    <div class="container">
                        <h3><label for="myname"></label><a data-toggle="modal" id="myBtn1" data-target="#viewModal"><i class="icon-info-with-circle"></i></a></h3>
                        <!-- SIGN UP 3 STARTS -->
                        <div class="row">
                            <div class="col-md-6">
                                <div id="slider2">
                                    <div class="owl-carousel testimonial-owl owl-image">
                                        <div class="item1">
                                            <figure class="figure-container"><img src="" alt="LouiePark1" id="slide21" class="img-responsive"> </figure>
                                        </div>
                                        <div class="item2">
                                            <figure class="figure-container"><img src="" alt="LouiePark2" id="slide22" class="img-responsive"></figure>
                                        </div>
                                        <div class="item3">
                                            <figure class="figure-container"><img src="" alt="LouiePark3" id="slide23" class="img-responsive"> </figure>
                                        </div>
                                        <div class="item4">
                                            <figure class="figure-container"><img src="" alt="LouiePark4" id="slide24" class="img-responsive"></figure>
                                        </div>
                                    </div>
                                </div>
                                <div class="star-rating">
                                    <label>Rating</label>
                                    <input type="text" id="input-4" name="input-4" class="rating-loading" value="">
                                    <!--<input type="text" id="rating" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="1" data-size="xs">-->
                                </div>
                                <div class="alert-brand">
                                    <h4>Overview</h4>
                                    <div class="driveway-price"></div>
                                    <p></p>
                                    <p><small>Contact information and address of home owner provided after Check-Out</small>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="driveway-payment">
                                    <!--  <div class="form-group">
                                          <div class="row">
                                              <div class="col-sm-4">
                                                  <div class="custom-select">
                                                      <select>
                                                          <option value="">Duration</option>
                                                          <option value="">1 Day</option>
                                                          <option value="">2 Days</option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="col-sm-8">
                                                  <div class="radio-group radio-inline">
                                                      <label class="control control-radio">
                                                          <input type="radio" name="use" checked /> Immediate use
                                                          <div class="control_indicator"></div>
                                                      </label>
                                                  </div>
                                                  <div class="radio-group radio-inline">
                                                      <label class="control control-radio">
                                                          <input type="radio" name="use" id="future-radio" /> Future use
                                                          <div class="control_indicator"></div>
                                                      </label>
                                                  </div>
                                              </div>
                                          </div>
                                          <div id="future-container" style="display:none;">
                                              <div class="date" data-date="08/06/2016"></div>
                                          </div>
                                      </div>-->
                                    <div class="CCServerError"></div>
                                    <span style="color:red;" id="error_msg_v"></span>
                                    <h3>Vehicle Details</h3>
                                    <div class="form-group vehicle" style="display:none">
                                        <input type="hidden"    id="veicleList" name="veicleList" >
                                        <div class="custom-select">
                                            <input type="hidden"    id="vehicleID" name="vehicleID" >
                                            <select name="carType" id ="carType">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="addVehicle"  style="display:none">
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <input type="text" id="model" name="model" required> <label>Model</label>
                                                <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="year" name="year" required> <label>Year</label> <span class="bar"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 ">
                                            <div class="form-group">
                                                <input type="text" id="color" name="color" required> <label>Color</label>
                                                <span class="bar"></span>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" id="vehiclenumber" name="vehiclenumber"
                                                       required> <label>License Plate Number</label> <span class="bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span style="color:red;" id="error_msg"></span>
                                    <h3>Billing Details</h3>
                                    <div class="payment row" style="display:none">
                                        <div class="revertBill btn btn-warning tooltips"  style="display:none" title="Saved Card Details"><i class="icon-reload"></i></div>
                                        <form name="myform" id="myform" >
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="hidden" id="cardResult"> <input type="hidden"
                                                                                                 id="card_type" name="card_type"> <input type="text"
                                                                                                 id="card_number" name="card_number"
                                                                                                 data-inputmask="'mask': '9999 9999 9999 9999'"> <label>Card
                                                        Number</label> <span class="bar"></span>
                                                </div>                                                
                                                <div class="form-group">
                                                    <input type="password" id="security_code"
                                                           name="security_code" required> <label>CVV Code</label>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="expiration_date"
                                                           name="expiration_date" data-inputmask="'mask': 'm/y'"
                                                           required /> <label>Expiration Date</label> <span
                                                           class="bar"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="nameon_card" name="nameon_card"
                                                           required> <label>Name on Card</label> <span class="bar"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input id="billing_phone" name="billing_phone" required />
                                                    <label>Phone</label> <span class="bar"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" id="billing_address"
                                                           name="billing_address" required> <label>Address</label>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="billing_street"
                                                           name="billing_street" required> <label>Street Address</label>
                                                    <span class="bar"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="billing_city" name="billing_city"
                                                           required> <label>City</label> <span class="bar"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="billing_state" name="billing_state"
                                                           required> <label>State</label> <span class="bar"></span>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="billing_zip" name="billing_zip"
                                                           required> <label>Zip Code</label> <span class="bar"></span>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-md-6">
                                            <label class="control control-checkbox">
                                                <input type="checkbox" class="optionsave" id="billSave" name="billSave" value=""/> Save billing details for future use
                                                <div class="control_indicator"></div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="paymentExist" style="display:none">
                                        <div class="addBill btn btn-success tooltips" title="Add New Card Details"><i class="icon-plus22"></i></div>
                                        <div class="form-group">
                                            <input type="hidden"    id="cardList" name="cardList" > 
                                            <div class="custom-select">
                                                <select name="cardType" id ="cardType">                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" id="keeplooking" class="btn btn-brand goprevious">Previous</a>
                                    <a href="#" id="paymentProcess" class="btn btn-brand " onclick="paymentProcess()" >Process Payment</a>
                                    <!--<a href="#" class="btn btn-brand gonext">Next</a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SIGN UP 3 ENDS -->
                </div>
                <div class="tab-pane" id="tab4">
                    <div class="container">
                        <!-- SIGN UP 4 STARTS -->
                        <h1>Thank You!</h1>
                        <h2>Your transaction is complete. You can now proceed to your rented driveway.</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="slider3">
                                    <div class="owl-carousel testimonial-owl owl-image">
                                        <div class="item1">
                                            <figure class="figure-container"><img src="" alt="LouiePark1" id="slide31" class="img-responsive"> </figure>
                                        </div>
                                        <div class="item2">
                                            <figure class="figure-container"><img src="" alt="LouiePark2" id="slide32" class="img-responsive"></figure>
                                        </div>
                                        <div class="item3">
                                            <figure class="figure-container"><img src="" alt="LouiePark3" id="slide33" class="img-responsive"> </figure>
                                        </div>
                                        <div class="item4">
                                            <figure class="figure-container"><img src="" alt="LouiePark4" id="slide34" class="img-responsive"></figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="driveway-contact">
                                    <h3><label for="ownername"></label>
                                        <a data-toggle="modal" id="myBtn2" data-target="#viewModal"><i class="icon-info-with-circle"></i></a>
                                    </h3>    
                                    <div class="driveway-contact1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="driveway-map_final" style="height:500px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Details</h4>
            </div>
            <div class="modal-body">
                <label>Email ID:</label><p for="emailID"></p>
                <label>Address:</label><p for="address"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  
<div id="myModal" class="modal">

   Modal content
  <div class="modal-content">
      <div class="modal-header">
          <span class="close">×</span>
          <h2><p for="username"></p></h2>
      </div>
      <div class="modal-body">
          <label>Email ID:</label><p for="emailID"></p>
          <label>Address:</label><p for="address"></p>
      </div>
      <div class="m-footer">      
      </div>
  </div>

</div> -->
<div id="inset_form"></div>
<script>
    var modal = document.getElementById('myModal');
    var clBtn = document.getElementsByClassName("close")[0];

    myBtn1.onclick = function () {
        modal.style.display = "block";
    }
    myBtn2.onclick = function () {
        modal.style.display = "block";
    }
    clBtn.onclick = function () {
        modal.style.display = "none";
    }
</script>
<script src="<?php echo base_url(); ?>assets/js/star-rating.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/driveway.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-slider.min.js"></script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lib/moment.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        /*$("#driveway-go").click(function(){
         $("#driveway-search").addClass('hide');
         $("#driveway-map").removeClass('col-lg-9');
         $("#driveway-map").removeClass('col-md-8');
         $("#driveway-map").addClass('col-lg-12');
         }); 
         */
        $("#driveway-back").click(function () {
            $("#driveway-search").removeClass('hide');
            $("#driveway-map").addClass('col-lg-9');
            $("#driveway-map").addClass('col-md-8');
            $("#driveway-map").removeClass('col-lg-12');
        });


<?php if (isset($_SESSION['rentagain']) && $_SESSION['rentagain'] != NULL) { ?>

            $('#pac-input').val('<?php echo $searchlocation->streetAddress . " " . $searchlocation->route . " " . $searchlocation->city . " " . $searchlocation->state; ?>');
            $('#rentagain').val('1');
    <?php
    $this->session->unset_userdata('rentagain');
}
?>

        $(function () {
<?php if (isset($_SESSION[DRIVEWAY_SEARCH]) && $_SESSION[DRIVEWAY_SEARCH] != NULL) { ?>
                $("#date1").datepicker("option", "dateFormat", "yy-mm-dd");
                $("#date2").datepicker("option", "dateFormat", "yy-mm-dd");
                $('#date1').datepicker('setDate', '<?php echo $fromDate; ?>');
                $('#date2').datepicker('setDate', '<?php echo $toDate; ?>');
                $('#time1').timepicker('setTime', '<?php echo $fromTime; ?>');
                $('#time2').timepicker('setTime', '<?php echo $toTime; ?>');
                $('#prangeset').val('<?php echo $filterPrice; ?>');
                $('#hchargeset').val('<?php echo $totalHours; ?>');
                $('#pac-input').val('<?php echo $location; ?>');
                /*setTimeout(function(){ $('#pac-input').focus(); }, 100);
                 var e = jQuery.Event("keydown");
                 e.which = 13; // Enter
                 $("#pac-input").trigger(e);*/
                $('#totalPrice').val('<?php echo $totalPrice; ?>');
                $('#proc_fee').val('<?php echo $proc_fee; ?>');
                $('#latitude').val('<?php echo $latitude; ?>');
                $('#longitude').val('<?php echo $longitude; ?>');
                $('#searchType').val('<?php echo $option; ?>');
                $('#location').val('1');
                $('#timecheck').val('1');
                var option = <?php echo $option; ?>;
                if (option == 1) {
                    $("#hour").prop("checked", true);
                } else if (option == 2) {
                    $("#recurr").prop("checked", true);
                } else {
                    $("#flat").prop("checked", true);
                }
                if (option == 3) {
                    $('.driveway-price').html('<p> <div>Total <?php echo $totalHours; ?>  Days1 rental fee: $<?php echo $totalPrice; ?> </div> <div>+ Pricessing Fee: $10</div><div>Total Charge : <?php $grandTotal ?></div> </p>');
                } else {
                    $('.driveway-price').html('<p> <div>Total <?php echo $totalHours; ?>  Hours rental fee: <span> $<?php echo $totalPrice; ?> </div> <div>+ Pricessing Fee: $10</div><div>Total Charge : <?php $grandTotal ?></div> </p>');
                }
                destroy_slider();
                filterval();
                myFunction(<?php echo $driveway_id; ?>);
                $('#latitude').val('');
                $('#longitude').val('');
                $('#timecheck').val('');
                //  $('#location').val('');
    <?php
    unset($_SESSION[DRIVEWAY_SEARCH]);
}
?>
        });

        function destroy_slider() {
            $('.owl-image').remove();
            $('.owl-nonav').remove();
            var content = '<div class="owl-carousel testimonial-owl owl-image">' +
                    '<div class="item1">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark1" id="slide1" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item2">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark2" id="slide2" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item3">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark3" id="slide3" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item4">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark4" id="slide4" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '</div>';
            $('#slider').append(content);
            var content2 = '<div class="owl-carousel testimonial-owl owl-image">' +
                    '<div class="item1">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark1" id="slide21" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item2">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark2" id="slide22" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item3">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark3" id="slide23" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item4">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark4" id="slide24" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '</div>';
            $('#slider2').append(content2);
            var content3 = '<div class="owl-carousel testimonial-owl owl-image">' +
                    '<div class="item1">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark1" id="slide31" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item2">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark2" id="slide32" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item3">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark3" id="slide33" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '<div class="item4">' +
                    '<figure class="figure-container"><img src="" alt="LouiePark4" id="slide34" class="img-responsive">' +
                    '</figure>' +
                    '</div>' +
                    '</div>';
            $('#slider3').append(content3);
        }
    });
    $(window).load(function () {
        if ($('#rentagain').val() != '') {
            var input = document.getElementById('pac-input');
            google.maps.event.trigger(input, 'focus');
            google.maps.event.trigger(input, 'keydown', {
                keyCode: 13
            });
            $('#rentagain').val('');
        }
    });
</script>
