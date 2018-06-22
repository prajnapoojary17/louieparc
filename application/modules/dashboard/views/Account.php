<!-- START page-->
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
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Add Account Info</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Please add account information for transfer!</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 signin-graphics">
                        <img src="<?php echo base_url(); ?>assets/images/add-card.png" alt="LouiePark" class="img-responsive wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s" />
                    </div> 
                    <form class="wow fadeInUp account" method="post" data-wow-duration="1s" data-wow-delay=".8s" name="account">    
                        <div class="error_box" ></div>
                        <div class="col-md-4" data-wow-duration="1s" data-wow-delay="1.3s">

                            <div class="form-group">
                                <input type="text" id="account_number" name="account_number" required>
                                <label>Account Number</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="routing_number" name="routing_number" required>
                                <label>Routing Number</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="ssn_last_4" name="ssn_last_4" required>
                                <label>Last 4 digits ssn Number</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="accHolderfName" name="accHolderfName" required>
                                <label>Account Holder First Name</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="accHolderlName" name="accHolderlName" required>
                                <label>Account Holder Last Name</label>
                                <span class="bar"></span>
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
                            <div class="form-group">         
                                <button type="submit" class="btn btn-brand " ><i class="icon-check22"></i>Save</button> 
                                <a href="<?php echo base_url(); ?>dashboard" class="btn btn-brand"><i class="icon-cross2"></i>Close</a>
                            </div> 
                        </div>
                        <div class="col-md-4" data-wow-duration="1s" data-wow-delay="1.3s">                             
                            <div class="form-group">
                                <input type="text" id="acc_address1" name="acc_address1" required> <label for="inputfname">Address Line 1</label>
                                <span class="bar"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" id="acc_address2" name="acc_address2" required> <label for="inputfname">Address Line 2</label>
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
                            </div>                            
                            <div class="form-group">
                                Date Of Birth
                                <div class="row form-wrapper">
                                    <div class="col-sm-4">
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
                                    <div class="col-sm-4">
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
                                    <div class="col-sm-4">
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
                                                    endfor;
                                                    ?>
                                                </select>
                                            </div>
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
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="<?php echo base_url(); ?>assets/js/account.js" type="text/javascript"></script>