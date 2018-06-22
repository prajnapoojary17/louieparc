<script
src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_API_KEY; ?>&libraries=places"></script>
<link type="text/css" rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";</script>

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
                                <ul> <?php  if ($building == 0) { ?>
                                    <li><a href="#tab1" data-toggle="tab">1</a></li>
                                     <?php }?>
                                    <li><a href="#tab2" data-toggle="tab">2</a></li>                                    
                                    <li><a href="#tab3" data-toggle="tab">3</a></li>
                                    <li><a href="#tab4" data-toggle="tab">4</a></li>   
                                    <?php if ($role == 3) { ?>
                                        <li><a href="#tab5" data-toggle="tab">5</a></li> 
                                    <?php } ?>
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

                        <input type="hidden" name="status" id="status" value="1" /> 
                        <input type="hidden" name="flname" id="flname" value="" />                                            
                        <input type="hidden" name="verificationStatus" id="verificationStatus"    value="0" />               
                        <?php if ($building == 0) { ?>
                              
                        <div class="tab-pane" id="tab1">
                            <!-- SIGN UP 5 STARTS -->
                            <h1>Let's get to know you</h1>
                            <h2>We'd like to learn more about you before you can rent your
                                driveway. This should be quick!</h2>
                            <div class="row">
                                <div class="col-md-4 signin-graphics">
                                    <img src="<?php echo base_url(); ?>assets/images/info.png"
                                         alt="profilerinu" class="img-responsive" />
                                </div>
                                
                                <div class="col-md-8">
                                    <h5>Please Enter your Address    </h5>                                    
                                    <br>
                                  
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
                                   
                                </div>
                            </div>
                      
                            <!-- SIGN UP 5 ENDS -->

                        </div> 
                         <div class="tab-pane" id="tab2">
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
 <?php } else { ?>
                          <div class="tab-pane" id="tab2">
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
                                         <input type="hidden" name="additional" id="status" value="1" /> 
                                        <input type="text" id="slot" name="slot"                                         
                                               required> <label for="inputSlot">Enter Number of parking slots</label>

                                        <span class="bar"></span>
                                    </div>

                                </div>

                                <div class="col-md-8">
                                
                                   
                                    <div id="rental-container">
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
                        
                        <?php } ?>
                      
                        <div class="tab-pane" id="tab3">

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
                        <div class="tab-pane" id="tab4">
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
                                        <input type="text" id="currency1" maxlength="7" name="hourlyprice"
                                               required> <label>Set hourly price</label> <span class="bar"></span>
                                    </div>
                                    <p>On LouiePark, we give users two options: to rent hourly or rent based on a flat rate.</p>
                                    <p>A flat rate price is what you are willing to charge for someone to stay in your driveway for at least 24 hours. Someone who is traveling, going to a concert or sporting event might choose to rent this way.</p>
                                    <p>Hourly rates on LouiePark act just like a regular parking garage. Set the price you are willing to charge a renter for every hour they stay in your driveway. This might come in handy when someone is parking for work or going out on a Friday night . Remember, the hourly price should be lower than your flat rate price.</p>
                                </div>
                            </div>

                            <!-- SIGN UP 7 ENDS -->

                        </div>  
                        <div class="tab-pane" id="tab5">
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
                                    </label><br/><br>
                                    <h5>You understand that by having your driveway set to live will allow individuals to rent it out. You understand that you can turn your driveway off by going into driveway settings in your profile. You also understand that you are responsible for your driveway, not LouiePark.</h5>
                                    <label class="control control-checkbox"> <input type="checkbox"
                                                                                    name="chkbox2" id="chkbox2" required /> * by clicking you
                                        agree
                                        <div class="control_indicator"></div>
                                    </label><br/><br>                                   
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
<script src="<?php echo base_url(); ?>assets/js/adddriveway.js" type="text/javascript"></script>


