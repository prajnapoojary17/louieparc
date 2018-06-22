<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<?php $_SESSION['drivewayphoto_id'] = $drivewayinfo->drivewayID; ?>
<div class="servererror" style="color:red;"></div>         
<div class="col-md-10">
    <input type="hidden" name="drivewayID" id="drivewayID" value="<?php echo $drivewayinfo->drivewayID; ?>">
    <input type="hidden" name="userID" value="<?php echo $userID; ?>">
    <div class="message"></br></br>
        <div class="collapse margin-top20" id="message">
            <div role="alert" class="alert alert-success"> Photo removed successfully. </div>
        </div>
    </div>
    <div class="row">
        <?php if ($drivewayinfo->photo1 == '' && $drivewayinfo->photo2 == '' && $drivewayinfo->photo3 == '' && $drivewayinfo->photo4 == '') { ?>
            <div class="col-md-6">
                <div class="content-box-large">
                    <div class="panel-heading">
                        <div class="panel-title">No Driveway Images</div>                        
                    </div>                
                </div>
            </div>
        <?php } else { ?>
            <?php if ($drivewayinfo->photo1 != '') { ?>             
                <div class="col-md-6 photo1">
                    <div class="content-box-large">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <button class="btn btn-danger btn-xs" onclick="deletephoto('<?php echo $drivewayinfo->photo1 ?>', 'photo1')">Remove</button>
                            </div>                    
                        </div>
                        <div class="panel-body">
                            <img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $drivewayinfo->photo1; ?>" alt="LouiePark" class="img-responsive">
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($drivewayinfo->photo2 != '') { ?>             
                <div class="col-md-6 photo2">
                    <div class="content-box-large">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <button class="btn btn-danger btn-xs" onclick="deletephoto('<?php echo $drivewayinfo->photo2 ?>', 'photo2')">Remove</button>
                            </div>                        
                        </div>
                        <div class="panel-body">
                            <img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $drivewayinfo->photo2; ?>" alt="LouiePark" class="img-responsive">
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($drivewayinfo->photo3 != '') { ?>             
                <div class="col-md-6 photo3">
                    <div class="content-box-large">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <button class="btn btn-danger btn-xs" onclick="deletephoto('<?php echo $drivewayinfo->photo3 ?>', 'photo3')">Remove</button>
                            </div>                    
                        </div>
                        <div class="panel-body">
                            <img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $drivewayinfo->photo3; ?>" alt="LouiePark" class="img-responsive">
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($drivewayinfo->photo4 != '') { ?>             
                <div class="col-md-6 photo4">
                    <div class="content-box-large">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <button class="btn btn-danger btn-xs" onclick="deletephoto('<?php echo $drivewayinfo->photo4 ?>', 'photo4')">Remove</button>                
                            </div>                        
                        </div>
                        <div class="panel-body">
                            <img src="<?php echo base_url(); ?>assets/uploads/driveway/<?php echo $drivewayinfo->photo4; ?>" alt="LouiePark" class="img-responsive">
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <div style="margin-left: 467px; margin-bottom: 20px;"><a href="#" onclick="photoclose('<?php echo $userID ?>')" class="btn btn-lg btn-block btn-primary" style="width:200px;">CLOSE</a></div>
</div>
<div id="drivewayphoto_form">
</div>
<script src="https://code.jquery.com/jquery.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
        deletephoto = function (imageName, key) {
            var agree = confirm("Are you sure that you want to delete this item?");
            if (agree) {
                var drivewayID = $('#drivewayID').val();
                $.ajax({
                    method: "POST",
                    url: baseUrl + "webadmin/deleteDrivewayphoto",
                    dataType: "json",
                    data: {imgName: imageName,
                        key: key,
                        drivewayId: drivewayID},
                    success: function (data) {
                        if (typeof data.status !== typeof undefined) {
                            if (data.status) {
                                $('.' + key + ' div').remove();
                                $("#message").show().delay(2000).fadeOut();
                            } else {
                                $('.servererror').html('Failed To Delete. Please try again');
                            }
                        }
                    }
                });
            }
            return false;
        };

        photoclose = function (userID) {
            $('#drivewayphoto_form').html('<form action="' + baseUrl + 'webadmin/updateDriveway" name="drivewayphoto" class="drivewayphoto" method="post" style="display:none;"><input type="text" name="userId" value="' + userID + '" /></form>');
            $(".drivewayphoto").submit();

        };
</script>
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