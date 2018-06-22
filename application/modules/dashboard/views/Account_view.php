<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<!-- START page-->
<div class="full-screen">
    <div class="main-content single-page">
        <div class="triangles wow lightSpeedIn" data-wow-duration="1s" data-wow-delay="2s">
            <span class="triangle1"></span>
            <span class="triangle2"></span>
            <span class="triangle3"></span>
        </div>
        <div class="signin-page">
            <h1 class="main-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".5s">Account Info</h1>
            <h2 class="sub-title wow fadeInUp" data-wow-duration="1s" data-wow-delay=".6s">Your account information for transfer!</h2>
            <div class="container">
                <div class="row">
                    <?php
                    if (isset($success_acc)) {
                        echo '<div class="alert_error" style="display:block">You have successfully created bank account</div>';
                    }
                    ?>
                    <div class="col-md-6 signin-graphics">
                        <img src="<?php echo base_url(); ?>assets/images/acc_info.png" alt="LouiePark" class="img-responsive wow fadeInUp" data-wow-duration="1s" data-wow-delay="1s" />                       
                    </div> 
                    <div class="col-md-4">
                        <?php if (!isset($result->accountID)) { ?>
                            <p class="text-right"><a href="<?php echo base_url(); ?>dashboard/account" class="btn btn-success tooltips" title="Add Account"><i class="icon-plus22"></i></a></p>
                        <?php } ?>
                        <?php
                        foreach ($results as $result) {
                            if ($result->status == '1') {
                                $status = 'btn-success';
                                $action = "Deactive";
                            } else {
                                $status = 'btn-danger';
                                $action = "Active";
                            }
                            ?>
                            <div class="fancy-form signin-form wow flipInX" data-wow-duration="1s" data-wow-delay="1.3s">                            
                                <a href="<?php echo base_url(); ?>dashboard/account_active/<?php echo $result->accountID; ?>" class="btn btn-activate <?php echo $status; ?> tooltips" title="<?php echo $action; ?>"><i class="icon-ban"></i></a>
                                <form class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".8s">
                                    <input type="hidden" id="accounID" name="accounID" value ="<?php echo $result->accountID; ?> ">
                                    <div class="form-group">
                                        <input type="text" id="accHolderName" name="accHolderName" value ="<?php echo $result->acFirstName . ' ' . $result->acLastName; ?> " readonly>                                                             <label>Account Holder Name</label>
                                        <span class="bar"></span>
                                    </div>     

                                    <div class="form-group">
                                        <?php
                                        if ($result->accHolderType == 'individual') {
                                            $type = 'Individual';
                                        } else {
                                            $type = 'Company';
                                        }
                                        ?> 
                                        <div class="form-group ">
                                            <input type="text" id="accHolderName" name="accHolderName" value ="<?php echo $type; ?> " readonly>    
                                            <label>Account Type</label>
                                            <span class="bar"></span>
                                        </div>                                        
                                    </div>                                    
                                </form>
                            </div>
                            <p class="pull-right margin-top10 wow fadeInUp" data-wow-duration="1s" data-wow-delay="1.5s"><a href="<?php echo base_url(); ?>dashboard" class="btn btn-success btn-brand"><i class="icon-cross2"></i>CLOSE</a></p>
                        <?php } ?>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




