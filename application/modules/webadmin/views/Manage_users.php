<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script> 
<div class="col-md-10">
    <div class="content-box-large">
        <div class="panel-heading">
            <div class="panel-title">USERS LIST</div>
        </div>                
        <div class="collapse margin-top20" id="mailSent">
            <div role="alert" class="alert alert-success"> <strong>Well done!</strong> Data saved successfully. </div>
        </div>        
        <div class="panel-body">
            <div class="servererror" style="color:red;"></div>
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Role</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Address</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($users)) {
                        $i = 1;
                        foreach ($users as $user) {
                            ?>
                            <tr class="odd gradeX" id="<?php echo $user->userID ?>">
                                <td><?php echo $i; ?></td>
                                <td><?php if ($user->roleID == 2) { ?>
                                        <label class="label label-primary">Renter</label>
                                    <?php } else if ($user->roleID == 3) { ?>
                                        <label class="label label-primary">Parker</label>
                                    <?php } else if ($user->roleID == 4) { ?>
                                        <label class="label label-primary">Renter/Parker</label>
                                    <?php } ?>
                                </td>
                                <td class="rusername">
                                    <span class='span_rusername<?php echo $user->userID ?>'><?php echo $user->userName; ?></span>
                                    <input type='text' value='<?php echo $user->userName; ?>' data-original-value="<?php echo $user->userName; ?>" class='input_rusername<?php echo $user->userID ?> username' style="display:none; width:100px;" />
                                    <div class="rusernameerr<?php echo $user->userID ?>" style="color:red;"></div>
                                </td>
                                <td class="remail">
                                    <span class='span_remail<?php echo $user->userID ?>'><?php echo $user->emailID; ?></span>
                                    <input type='text' value='<?php echo $user->emailID; ?>' data-original-value="<?php echo $user->emailID; ?>" class='input_remail<?php echo $user->userID ?> emailID' style="display:none; width:100px;" />
                                    <div class="remailerr<?php echo $user->userID ?>" style="color:red;"></div>
                                </td>
                                <td class="rphone">
                                    <span class='span_rphone<?php echo $user->userID ?>'><?php echo $user->phone; ?></span>
                                    <input type='text' value='<?php echo $user->phone; ?>' data-original-value="<?php echo $user->phone; ?>" class='input_rphone<?php echo $user->userID ?>' style="display:none; width:100px;" />
                                    <div class="rphoneerr<?php echo $user->userID ?>" style="color:red;"></div>
                                </td>
                                <td class="rdob">
                                    <?php if ($user->birthDate == "") { ?>
                                        <span class='span_rdob<?php echo $user->userID ?>'>N/A</span>    
                                    <?php } else { ?>
                                        <span class='span_rdob<?php echo $user->userID ?>'><?php echo $user->birthDate; ?></span>                                       
                                        <div class="bfh-datepicker input_rdob<?php echo $user->userID ?>" data-format="y-m-d" data-date="<?php echo $user->birthDate; ?>" data-original-value="<?php echo $user->birthDate; ?>" style="display:none; width:140px;" ></div>
                                        <div class="rdoberr<?php echo $user->userID ?>" style="color:red;"></div>
                                    <?php } ?>
                                </td>
                                <td class="raddress">
                                    <?php if ($user->building == "" && $user->streetAddress == "") { ?>
                                        <span class='span_raddress<?php echo $user->userID ?>'>N/A</span>    
                                    <?php } else { ?>
                                        <span class='span_raddress<?php echo $user->userID ?>'> <?php echo $user->building; ?></br><?php echo $user->streetAddress; ?> ,<?php echo $user->route; ?> </br><?php echo $user->city; ?> , <?php echo $user->state; ?> - <?php echo $user->zip; ?></span> 
                                        <div class='input_raddress<?php echo $user->userID ?>' style="display:none;">
                                            Bldg: <input type='text' value='<?php echo $user->building; ?>' data-original-value="<?php echo $user->building; ?>" class='input_building<?php echo $user->userID ?>' style="width:80px;" title="Building" /><br/>
                                            Street: <input type='text' value='<?php echo $user->streetAddress; ?>'  data-original-value="<?php echo $user->streetAddress; ?>" class='input_streetAddress<?php echo $user->userID ?>' style="width:90px;" /><br/>
                                            Route: <input type='text' value='<?php echo $user->route; ?>'  data-original-value="<?php echo $user->route; ?>" class='input_route<?php echo $user->userID ?>' style="width:100px;" /><br/>
                                            City: <input type='text' value='<?php echo $user->city; ?>'  data-original-value="<?php echo $user->city; ?>" class='input_city<?php echo $user->userID ?>' style="width:100px;" /></br>
                                            State: <input type='text' value='<?php echo $user->state; ?>'  data-original-value="<?php echo $user->state; ?>" class='input_state<?php echo $user->userID ?>' style="width:100px;" /><br/>
                                            ZIP: <input type='text' value='<?php echo $user->zip; ?>'  data-original-value="<?php echo $user->zip; ?>" class='input_zip<?php echo $user->userID ?>' style="width:100px;" />
                                        </div>
                                        <div class="raddresserr<?php echo $user->userID ?>" style="color:red;"></div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <button class="btn btn-warning editbtn editbtn<?php echo $user->userID ?>">Edit</button>
                                </td>                                                                                
                                <td>
                                    <button class="btn btn-danger deletebtn deletebtn<?php echo $user->userID ?>" >Delete</button>
                                    <button class="btn btn-warning undobtn undobtn<?php echo $user->userID ?>" style="display:none;">Cancel</button>
                                </td>
                                <?php if ($user->roleID == 2 || $user->roleID == 4) { ?>
                                    <td>
                                        <button class="btn btn-warning updatebtn" onclick="updatedriveway('<?php echo $user->userID ?>')">Update Driveway <?php if (array_key_exists($user->userID, $feedbackcount)) { ?><span class="label label-success"><?php echo $feedbackcount[$user->userID]; ?></span> <?php } ?> </button> 
                                    </td> 
                                <?php } else { ?>
                                    <td> </td>
                                <?php } ?>
                                <td>
                                    <!-- <button class="btn btn-warning logintoaccount">Log in to account</button> -->
                                    <button class="btn btn-warning logintoaccount" onclick="logintoaccount(' <?php echo $user->userID ?>')">Log in to account</button>
                                </td> 
                            </tr>
                            <?php
                            $i = $i + 1;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="update_driveway">
    <!-- user for updatedriveway buttob click -->
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
<script src="<?php echo base_url(); ?>assets/js/webadmin/manage_users.js"></script>
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