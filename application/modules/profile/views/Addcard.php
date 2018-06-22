<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="loader" style="display:none"><div class="loader-container"><div class="spinner"></div>Please wait...</div></div>
<div class="full-screen">
    <div class="main-content single-page">
        <div class="triangles wow lightSpeedIn" data-wow-duration="1s" data-wow-delay="2s">
            <span class="triangle1"></span>
            <span class="triangle2"></span>
            <span class="triangle3"></span>
        </div>
        <div class="signin-page">
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Add Card</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Please add your card information for future use</h2>
            <h4 class="info-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".7s">Card information</h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 signin-graphics">
                        <img src="<?php echo base_url(); ?>assets/images/add-card.png" alt="LouiePark" class="img-responsive wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s" />
                    </div> 
                    <div class="col-md-8 fancy-form signin-form wow flipInX" data-wow-duration="1s" data-wow-delay="1.3s">
                        <span style="color:red;" id="error_msg"></span>
                        <div class="error_box" ></div>
                        <h3>Billing Details</h3>


                        <form name="addcard" id="addcard" class="addcard" method="post" data-wow-duration="1s" data-wow-delay=".8s" >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" id="cardResult"> <input type="text"
                                                                                 id="card_number" name="card_number" data-inputmask="'mask': '9999 9999 9999 9999'" requires> 
                                    <label>Card Number</label> <span class="bar"></span>
                                </div>                                                
                                <div class="form-group">
                                    <input  id="security_code"
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
                                <div class="form-group">
                                    <button type="submit" class="btn btn-brand " ><i class="icon-check22"></i>Save</button>
                                    <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-cross2"></i>Close </a>
                                </div> 
                            </div>    

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo base_url(); ?>assets/js/addcard.js" type="text/javascript"></script>