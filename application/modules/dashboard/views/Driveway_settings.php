<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<?php $_SESSION['setDrivewayId'] = $drivewayID; ?>
<div class="loader" style="display:none"><div class="loader-container"><div class="spinner"></div>Please wait...</div></div>
<div class="main-content">
    <div class="profile-settings">
        <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Settings</h1>
        <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Please add your driveway settings below</h2>
        <div class="container">
            <form class="drivewaySetting" name="drivewaySetting" id="drivewaySetting">
                <input type="hidden" name="drivewayID" id="drivewayID" value="<?php echo $drivewayID; ?>">
                <input type="hidden" name="checkValidation" id="checkValidation" value="1">    
                <div class="row">
                    <div class="col-md-8">
                        <div class="CCServerError"></div>                        
                        <div class="profile-actions padding0 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.7s">

                            <div class="radio-group radio-inline">
                                <label class="control control-radio">
                                    <input type="radio" name="status" value="1" data-original-value="<?php echo ($status == 1) ? '1' : '0' ?> " id="on" <?php echo ($status == 1) ? 'checked' : '' ?> /> Go Live
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                            <div class="radio-group radio-inline">
                                <label class="control control-radio">
                                    <input type="radio" name="status" id="off" value="0" data-original-value="<?php echo ($status == 0) ? '1' : '0' ?> " <?php echo ($status == 0) ? 'checked' : '' ?> /> Driveway off
                                    <div class="control_indicator"></div>
                                </label>
                            </div>
                            <div id="driveway-container">
                                <p class="small">Select the Date you want your driveway to go live.</p>
                                <div class="row date-time">
                                    <div class="col-sm-6">
                                        <div class="input-group input-daterange">
                                            <input type="text" id="fdate1" class="form-control startDate" name="startDate" placeholder="Start Date">                                       
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group input-daterange">
                                            <input type="text" id="fdate2" class="form-control endDate" name="endDate" placeholder="End Date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="block-checkbox wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.7s"> 
                            <div class="row">                                
                                <div class="col-md-4">
                                    <label class="control control-checkbox">
                                        <input type="checkbox" id="one" class="optionone" name="day_option[]" value="1" /> Monday - Thursday
                                        <div class="control_indicator"></div>
                                    </label>
                                    <span class="error optiononeerror" style="display: none;">Selected day option does not exist in between the selected date range settings.</span>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="fromdate1" name="fromdate1" class="form-control dtimepicker dtimepicker-no-seconds ftimeone">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <label class="error errorone err" for="fromdate1" style="display: none;"></label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="todate1"  name="todate1" class="form-control dtimepicker dtimepicker-no-seconds ttimeone">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <label class="error errorone err" for="todate1" style="display: none;"></label>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success reset" value="one">Reset</button>
                                </div>
                            </div>                                    
                        </div>     
                        <div class="block-checkbox wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.9s">  
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control control-checkbox">
                                        <input type="checkbox" class="optionfive" id="five" name="day_option[]" value="5" /> Friday
                                        <div class="control_indicator"></div>
                                    </label>
                                    <span class="error optionfiveerror" style="display: none;">Selected day option does not exist in between the selected date range settings.</span>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="fromdate5"  name="fromdate5" class="form-control dtimepicker dtimepicker-no-seconds ftimefive">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <label class="error errorfive err" for="fromdate5" style="display: none;"></label>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="todate5" name="todate5" class="form-control dtimepicker dtimepicker-no-seconds ttimefive">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <label class="error errorfive err" for="todate5" style="display: none;"></label>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success reset" value="five">Reset</button>
                                </div>
                            </div>
                        </div>    
                        <div class="block-checkbox wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.1s">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control control-checkbox">
                                        <input type="checkbox" class="optionsix" id="six" name="day_option[]" value="6"/> Saturday
                                        <div class="control_indicator"></div>
                                    </label>
                                    <span class="error optionsixerror" style="display: none;">Selected day option does not exist in between the selected date range settings.</span>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="fromdate6" name="fromdate6" class="form-control dtimepicker dtimepicker-no-seconds ftimesix">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>

                                    </div>
                                    <label class="error errorsix err" for="fromdate6" style="display: none;"></label>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="todate6" name="todate6" class="form-control dtimepicker dtimepicker-no-seconds ttimesix">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <label class="error errorsix err" for="todate6" style="display: none;"></label>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success reset" value="six">Reset</button>
                                </div>
                            </div>    
                        </div>     
                        <div class="block-checkbox wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.3s">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control control-checkbox">
                                        <input type="checkbox" class="optionseven" id="seven" name="day_option[]" value="0"/> Sunday
                                        <div class="control_indicator"></div>
                                    </label>
                                    <span class="error optionsevenerror" style="display: none;">Selected day option does not exist in between the selected date range settings.</span>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="fromdate0" name="fromdate0" class="form-control dtimepicker dtimepicker-no-seconds ftimeseven">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <label class="error errorseven err" for="fromdate0" style="display: none;"></label>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input type="text" id="todate0" name="todate0" class="form-control dtimepicker dtimepicker-no-seconds ttimeseven">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                    <label class="error errorseven err" for="todate0" style="display: none;"></label>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success reset" value="seven">Reset</button>
                                </div>
                            </div>    
                        </div>  
                    </div>
                    <div class="col-md-4">
                        <div class="driveway-contact wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.7s" style="margin-top:100px;">
                            <h4>Driveway Address</h4>
                            <address>                      
                                <?php echo $building; ?><br />
                                <?php echo $streetAddress; ?> <br /><?php echo $route; ?><br />
                                <?php echo $city; ?> <br /> <?php echo $state; ?> - <?php echo $zip; ?> <br />                            
                            </address>
                        </div>
                        <p class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.5s" style="padding-left:30px; margin-top: 12px;"><a href="#" class="btn btn-brand submitBtn"><i class="icon-check22"></i>Save</a>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>dashboard" class="btn btn-success btn-brand"><i class="icon-cross2"></i>CLOSE</a></p> 
                    </div>
                    <div class="col-md-12 collapse margin-top20" id="mailSent">
                        <div role="alert" class="alert alert-success"> <strong>Well done!</strong> Your setting is saved successfully. </div>
                    </div>

                    <div class="col-md-12">
                        <div class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.9s">
                            <ul class="fancy-list">
                                <li>Our driveway settings make it very simple to control the flow of people parking in your space.</li>
                                <li>If you would like to leave your driveway on at all times, select “Go Live” and press submit. Your driveway is now live. </li>
                                <li>If you would like to set a start and end date of your driveway going live, select the “Start Date” and “End Date” and your driveway will go live on that date once you press submit.</li>
                                <li>If you are looking to control the times of when your spot is live, check the boxes in which you want it to be live, then select the times. If a box is not selected, we assume you want your driveway turned off on those days.</li>
                                <li>We hope this helped! Feel free to contact us if you need more help.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>            
        </div>
    </div>
</div>
<div id="setting_form"></div>
<script src="<?php echo base_url(); ?>assets/js/drivewaysetting.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>
<script>
    $(window).load(function () {
<?php
if (isset($dateSetting)) {
    $startdate = date("m/d/Y", strtotime($dateSetting->start_date));
    $enddate = date("m/d/Y", strtotime($dateSetting->end_date));
    ?>
            $("#fdate1").datepicker("option", "dateFormat", "mm/dd/yyyy");
            $("#fdate1").datepicker("setDate", '<?php echo $startdate; ?>');
            $('#fdate1').attr('data-original-value', '<?php echo $startdate; ?>');
            $("#fdate2").datepicker("option", "dateFormat", "mm/dd/yyyy");
            $("#fdate2").datepicker("setDate", '<?php echo $enddate; ?>');
            $('#fdate2').attr('data-original-value', '<?php echo $enddate; ?>');
<?php } ?>

<?php
if (isset($timeSetting)) {
    foreach ($timeSetting as $timeset) {
        if ($timeset->day_option == 1) {
            if ($timeset->from != NO_TIME) {
                ?>
                        var f1 = "<?php echo $timeset->from; ?>";
                        var from1 = convertTime24to12(f1);
                        $('#fromdate1').timepicker("setTime", from1);
                        $('#fromdate1').attr('data-original-value', from1);
            <?php } ?>
            <?php if ($timeset->to != NO_TIME) { ?>
                        var t1 = "<?php echo $timeset->to; ?>";
                        var to1 = convertTime24to12(t1);
                        $('#todate1').timepicker("setTime", to1);
                        $('#todate1').attr('data-original-value', to1);
            <?php } ?>
                    $('#one').prop('checked', true);
                    $('#one').attr('data-original-value', 'checked');
            <?php
        } else if ($timeset->day_option == 5) {
            if ($timeset->from != NO_TIME) {
                ?>
                        var f5 = "<?php echo $timeset->from; ?>";
                        var from5 = convertTime24to12(f5);
                        $('#fromdate5').timepicker("setTime", from5);
                        $('#fromdate5').attr('data-original-value', from5);
            <?php } ?>
            <?php if ($timeset->to != NO_TIME) { ?>
                        var t5 = "<?php echo $timeset->to; ?>";
                        var to5 = convertTime24to12(t5);
                        $('#todate5').timepicker("setTime", to5);
                        $('#todate5').attr('data-original-value', to5);
            <?php } ?>
                    $('#five').prop('checked', true);
                    $('#five').attr('data-original-value', 'checked');
            <?php
        } else if ($timeset->day_option == 6) {
            if ($timeset->from != NO_TIME) {
                ?>
                        var f6 = "<?php echo $timeset->from; ?>";
                        var from6 = convertTime24to12(f6);
                        $('#fromdate6').timepicker("setTime", from6);
                        $('#fromdate6').attr('data-original-value', from6);
            <?php } ?>
            <?php if ($timeset->to != NO_TIME) { ?>
                        var t6 = "<?php echo $timeset->to; ?>";
                        var to6 = convertTime24to12(t6);
                        $('#todate6').timepicker("setTime", to6);
                        $('#todate6').attr('data-original-value', to6);
            <?php } ?>
                    $('#six').prop('checked', true);
                    $('#six').attr('data-original-value', 'checked');
            <?php
        } else if ($timeset->day_option == 0) {
            if ($timeset->from != NO_TIME) {
                ?>
                        var f7 = "<?php echo $timeset->from; ?>";
                        var from7 = convertTime24to12(f7);
                        $('#fromdate0').timepicker("setTime", from7);
                        $('#fromdate0').attr('data-original-value', from7);
            <?php } ?>
            <?php if ($timeset->to != NO_TIME) { ?>
                        var t7 = "<?php echo $timeset->to; ?>";
                        var to7 = convertTime24to12(t7);
                        $('#todate0').timepicker("setTime", to7);
                        $('#todate0').attr('data-original-value', to7);
            <?php } ?>
                    $('#seven').prop('checked', true);
                    $('#seven').attr('data-original-value', 'checked');
            <?php
        }
    }
}
?>


        function convertTime24to12(time24) {
            var tmpArr = time24.split(':'), time12;
            if (+tmpArr[0] == 12) {
                time12 = tmpArr[0] + ':' + tmpArr[1] + ' pm';
            } else {
                if (+tmpArr[0] == 00) {
                    time12 = '12:' + tmpArr[1] + ' am';
                } else {
                    if (+tmpArr[0] > 12) {
                        time12 = (+tmpArr[0] - 12) + ':' + tmpArr[1] + ' pm';
                    } else {
                        time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' am';
                    }
                }
            }
            return time12;
        }
    });

</script>
