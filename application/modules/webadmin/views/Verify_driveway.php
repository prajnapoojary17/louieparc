<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script> 
<div class="loader login" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        wait...
    </div>
</div>
<div class="col-md-10">
    <div class="content-box-large">
        <div class="panel-heading">
            <center><h3>DRIVEWAY LIST</h3></center>
            <div class="panel-title"></div>
        </div>                
        <div class="collapse margin-top20" id="mailSent">
            <div role="alert" class="alert alert-success"> Verification Code sent successfully. </div>
        </div>        
        <div class="panel-body">
            <div class="servererror" style="color:red;"></div>
            <?php
            if (!empty($driveways)) {
                $i = 1;
                ?>                     
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>User Name</th>
                            <th>Driveway Address</th>
                            <th>Description</th>
                            <th>Instruction</th>
                            <th>Hourly Price</th>
                            <th>Flat Price</th>
                            <th>Slots</th>                   
                            <th></th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($driveways as $driveway) { ?>
                            <tr class="odd gradeX" id="<?php echo $driveway->drivewayID ?>">
                                <td><?php echo $i; ?></td>
                                <td class="duserid">
                                    <span class='span_dusername<?php echo $driveway->userName ?>'> <?php echo $driveway->userName; ?></span>
                                    <input type="hidden" class="userid<?php echo $driveway->drivewayID ?>" value="<?php echo $driveway->userID ?>">
                                </td>
                                <td class="daddress">
                                    <span class='span_daddress<?php echo $driveway->drivewayID ?>'> <?php echo $driveway->building; ?></br><?php echo $driveway->streetAddress; ?> ,<?php echo $driveway->route; ?> </br><?php echo $driveway->city; ?> , <?php echo $driveway->state; ?> - <?php echo $driveway->zip; ?></span>                          
                                </td>
                                <td class="ddescription">
                                    <span class='span_ddescription<?php echo $driveway->drivewayID ?>'><?php echo $driveway->description; ?></span>
                                </td>
                                <td class="dinstructions">
                                    <span class='span_dinstructions<?php echo $driveway->drivewayID ?>'><?php echo $driveway->instructions; ?></span>
                                </td>
                                <td class="dhprice">
                                    <span class='span_dhprice<?php echo $driveway->drivewayID ?>'><?php echo $driveway->price; ?></span>
                                </td>    
                                <td class="ddprice">
                                    <span class='span_ddprice<?php echo $driveway->drivewayID ?>'><?php echo $driveway->dailyprice; ?></span>
                                </td>
                                <td class="dslot">
                                    <span class='span_dslot<?php echo $driveway->drivewayID ?>'><?php echo $driveway->slot; ?></span>
                                </td>                        
                                <td>
                                    <button class="btn btn-warning verify">Verify</button>
                                </td>                                                                         

                            </tr>
                            <?php
                            $i = $i + 1;
                        }
                        ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <center><h3>No driveways</h3></center>
            <?php } ?>
        </div>    
    </div>
    <div style="margin-left: 467px; margin-bottom: 20px;"><a href="<?php echo base_url(); ?>webadmin/Manage_users" class="btn btn-lg btn-block btn-primary" style="width:200px;">CLOSE</a></div>
</div>
<div id="view_photos">
    <!-- user for view photos button click -->
</div>
<script src="https://code.jquery.com/jquery.js"></script>
<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/form-helpers/js/bootstrap-formhelpers.min.js"></script>
<link href="<?php echo base_url(); ?>assets/vendors/datatables/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>assets/vendors/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/datatables/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/js/webadmin/tables.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/webadmin/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/webadmin/verify_driveway.js"></script>
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