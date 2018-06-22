<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script> 
<div class="col-md-10">
    <div class="content-box-large">
        <div class="panel-heading">
            <center><h3>CONSTANTS</h3></center>            
        </div>                
        <div class="collapse margin-top20" id="mailSent">
            <div role="alert" class="alert alert-success"> Data saved successfully. </div>
        </div>
        <div class="panel-body">
            <div class="servererror" style="color:red;"></div>
            <form class="form-horizontal" role="form" class="settings" id="settings" name="settings" method="POST" onsubmit="return false;">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">From Email</label>
                    <div class="col-sm-10">                    
                        <input type="text" class="form-control" id="fromEmail" name="fromEmail" value="<?php echo $settings->fromEmail ?>" >
                        <span id="fromEmailerr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Hourly Increment price</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="hourlypriceIncrement" name="hourlypriceIncrement" value="<?php echo $settings->hourlypriceIncrement; ?>" >
                        <span id="hourlypriceIncrementerr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Daily Increment price</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dailypriceIncrement" name="dailypriceIncrement" value="<?php echo $settings->dailypriceIncrement; ?>" >
                        <span id="dailypriceIncrementerr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Application Fees(cents)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="applicationFees" name="applicationFees" value="<?php echo $settings->applicationFees; ?>" >
                        <span id="applicationFeeserr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Application Fees(dollar)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="applicationFeesdolars" name="applicationFeesdolars" value="<?php echo $settings->applicationFeesdolars; ?>" >
                        <span id="applicationFeesdolarserr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Start reminder</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="startReminder" name="startReminder" value="<?php echo $settings->startReminder; ?>" >
                        <span id="startRemindererr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">End reminder</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="endReminder" name="endReminder" value="<?php echo $settings->endReminder; ?>" >
                        <span id="endRemindererr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Total booking days</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="totalBookingdays" name="totalBookingdays" value="<?php echo $settings->totalBookingdays; ?>" >
                        <span id="totalBookingdayserr" style="color:red;"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Driveway Distance</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="drivewayDistance" name="drivewayDistance" value="<?php echo $settings->drivewayDistance; ?>" >
                        <span id="drivewayDistanceerr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Driveway Lock time in minutes</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="minutesLock" name="minutesLock" value="<?php echo $settings->minutesLock; ?>" >
                        <span id="minutesLockerr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Stripe fees</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stripeFee" name="stripeFee" value="<?php echo $settings->stripeFee; ?>" >
                        <span id="stripeFeeerr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Stripe processing fees</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stripeProcessfee" name="stripeProcessfee" value="<?php echo $settings->stripeProcessfee; ?>" >
                        <span id="stripeProcessfeeerr" style="color:red;"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary savebtn">Save</button>
                        <a href="<?php echo base_url(); ?>webadmin/Manage_users" type="submit" class="btn btn-primary">Close</a>
                    </div>

                </div>
            </form>
        </div> 
    </div>  
</div>
<div id="view_photos">
    <!-- user for view photos button click -->
</div>

<script src="https://code.jquery.com/jquery.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="<?php echo base_url(); ?>assets/vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/webadmin/settings.js"></script>
<script>
                $('document').ready(function () {
                    $.ajax({
                        method: "POST",
                        url: baseUrl + "webadmin/getverifyCount",
                        dataType: "json",
                        success: function (data) {
                            $(".verifycount").text(data.count);
                        }
                    });



//$(".verifycount").text("3");

                });
</script>


