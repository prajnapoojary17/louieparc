<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script> 
<?php $_SESSION['update_userid'] = $userID; ?>
<div class="col-md-10">
    <div class="content-box-large">
        <div class="panel-heading">
            <center><h3>DRIVEWAY LIST</h3></center>
            <div class="panel-title">User Name : &nbsp;<?php echo $userName; ?></div>
        </div>                
        <div class="collapse margin-top20" id="mailSent">
            <div role="alert" class="alert alert-success"> <strong>Well done!</strong> Data saved successfully. </div>
        </div>
        <input type="hidden" name="userID" value="<?php echo $userID; ?>">
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
                            <th>Driveway Address</th>
                            <th>Description</th>
                            <th>Instruction</th>
                            <th>Hourly Price</th>
                            <th>Flat Price</th>
                            <th>Slots</th>                                
                            <th>Status</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($driveways as $driveway) { ?>
                            <tr class="odd gradeX" id="<?php echo $driveway->drivewayID ?>">
                                <td><?php echo $i; ?></td>
                                <td class="daddress">
                                    <span class='span_daddress<?php echo $driveway->drivewayID ?>'> <?php echo $driveway->building; ?></br><?php echo $driveway->streetAddress; ?> ,<?php echo $driveway->route; ?> </br><?php echo $driveway->city; ?> , <?php echo $driveway->state; ?> - <?php echo $driveway->zip; ?></span> 
                                    <div class='input_daddress<?php echo $driveway->drivewayID ?>' style="display:none;">
                                        Bldg: <input type='text' value='<?php echo $driveway->building; ?>' data-original-value="<?php echo $driveway->building; ?>" class='input_building<?php echo $driveway->drivewayID ?>' style="width:80px;" title="Building" /><br/>
                                        Street: <input type='text' value='<?php echo $driveway->streetAddress; ?>'  data-original-value="<?php echo $driveway->streetAddress; ?>" class='input_streetAddress<?php echo $driveway->drivewayID ?>' style="width:90px;" /><br/>
                                        Route: <input type='text' value='<?php echo $driveway->route; ?>'  data-original-value="<?php echo $driveway->route; ?>" class='input_route<?php echo $driveway->drivewayID ?>' style="width:100px;" /><br/>
                                        City: <input type='text' value='<?php echo $driveway->city; ?>'  data-original-value="<?php echo $driveway->city; ?>" class='input_city<?php echo $driveway->drivewayID ?>' style="width:100px;" /></br>
                                        State: <input type='text' value='<?php echo $driveway->state; ?>'  data-original-value="<?php echo $driveway->state; ?>" class='input_state<?php echo $driveway->drivewayID ?>' style="width:100px;" /><br/>
                                        ZIP: <input type='text' value='<?php echo $driveway->zip; ?>'  data-original-value="<?php echo $driveway->zip; ?>" class='input_zip<?php echo $driveway->drivewayID ?>' style="width:100px;" />
                                    </div>
                                    <div class="daddresserr<?php echo $driveway->drivewayID ?>" style="color:red;"></div>
                                </td>
                                <td class="ddescription">
                                    <span class='span_ddescription<?php echo $driveway->drivewayID ?>'><?php echo $driveway->description; ?></span>
                                    <input type='text' value='<?php echo $driveway->description; ?>' data-original-value="<?php echo $driveway->description; ?>" class='input_ddescription<?php echo $driveway->drivewayID ?>' style="display:none; width:100px;" />
                                    <div class="ddescriptionerr<?php echo $driveway->drivewayID ?>" style="color:red;"></div>
                                </td>
                                <td class="dinstructions">
                                    <span class='span_dinstructions<?php echo $driveway->drivewayID ?>'><?php echo $driveway->instructions; ?></span>
                                    <input type='text' value='<?php echo $driveway->instructions; ?>' data-original-value="<?php echo $driveway->instructions; ?>" class='input_dinstructions<?php echo $driveway->drivewayID ?>' style="display:none; width:100px;" />
                                    <div class="dinstructionserr<?php echo $driveway->drivewayID ?>" style="color:red;"></div>
                                </td>
                                <td class="dhprice">
                                    <span class='span_dhprice<?php echo $driveway->drivewayID ?>'><?php echo $driveway->price; ?></span>
                                    <input type='text' value='<?php echo $driveway->price; ?>' data-original-value="<?php echo $driveway->price; ?>" class='input_dhprice<?php echo $driveway->drivewayID ?> price' style="display:none; width:100px;" />
                                    <div class="hpriceerr<?php echo $driveway->drivewayID ?>" style="color:red;"></div>
                                </td>    
                                <td class="ddprice">
                                    <span class='span_ddprice<?php echo $driveway->drivewayID ?>'><?php echo $driveway->dailyprice; ?></span>
                                    <input type='text' value='<?php echo $driveway->dailyprice; ?>' data-original-value="<?php echo $driveway->dailyprice; ?>" class='input_ddprice<?php echo $driveway->drivewayID ?> price' style="display:none; width:100px;" />
                                    <div class="dpriceerr<?php echo $driveway->drivewayID ?>" style="color:red;"></div>
                                </td>
                                <td class="dslot">
                                    <span class='span_dslot<?php echo $driveway->drivewayID ?>'><?php echo $driveway->slot; ?></span>
                                    <input type='text' value='<?php echo $driveway->slot; ?>' data-original-value="<?php echo $driveway->slot; ?>" class='input_dslot<?php echo $driveway->drivewayID ?>' style="display:none; width:100px;" />
                                    <div class="sloterr<?php echo $driveway->drivewayID ?>" style="color:red;"></div>
                                </td>
                                <td class="dstatus">
                                    <span class='span_dstatus<?php echo $driveway->drivewayID ?>'><?php echo $driveway->drivewayStatus == 1 ? "Active" : "Inactive"; ?></span>
                                    <div class='input_dstatus<?php echo $driveway->drivewayID ?>' style="display:none;">
                                        <input type="radio" id="active<?php echo $driveway->drivewayID ?>" name="status<?php echo $driveway->drivewayID ?>" value="1" data-original-value="<?php echo ($driveway->drivewayStatus == 1) ? '1' : '0' ?> " <?php
                                        if ($driveway->drivewayStatus == '1') {
                                            echo "checked";
                                        }
                                        ?> /> Active<br> 
                                        <input type="radio" id="inactive<?php echo $driveway->drivewayID ?>" name="status<?php echo $driveway->drivewayID ?>" value="0" data-original-value="<?php echo ($driveway->drivewayStatus == 0) ? '1' : '0' ?> " <?php
                                        if ($driveway->drivewayStatus == '0') {
                                            echo "checked";
                                        }
                                        ?> /> Inactive
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-warning editbtn editbtn<?php echo $driveway->drivewayID ?>">Edit</button>
                                </td>                                                                                
                                <td>
                                    <button class="btn btn-danger deletebtn deletebtn<?php echo $driveway->drivewayID ?>" >Delete</button>
                                    <button class="btn btn-warning undobtn undobtn<?php echo $driveway->drivewayID ?>" style="display:none;">Cancel</button>
                                </td>
                                <td>
                                    <button class="btn btn-warning viewbtn" onclick="viewphotos('<?php echo $driveway->drivewayID ?>', '<?php echo $userID; ?>')">View Photos</button>
                                </td> 
                                <td>
                                    <button class="btn btn-warning feedbackbtn" onclick="viewfeedback('<?php echo $driveway->drivewayID ?>', '<?php echo $userID; ?>')">Manage Feedback<?php if (array_key_exists($driveway->drivewayID, $feedbackcnt)) { ?><span class="label label-success"><?php echo $feedbackcnt[$driveway->drivewayID]; ?></span> <?php } ?></button>
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
<script src="<?php echo base_url(); ?>assets/js/webadmin/update_driveway.js"></script>
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