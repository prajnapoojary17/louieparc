<!DOCTYPE html>
<html>
    <head>
        <title>LouiePark Super Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- styles -->
        <link href="<?php echo base_url(); ?>assets/css/webadmin/styles.css" rel="stylesheet">
    </head>
    <body class="login-bg">
        <div class="loader" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Logo -->
                        <div class="logo">
                            <h1></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-wrapper">
                        <div class="box">                    
                            <div class="error_box"></div>
                            <div class="content-wrap">
                                <h6>FORGOT PASSWORD</h6> 
                                Enter Registered email address
                                <input type="text" name="email" id="email" placeholder="E-mail address" class="form-control" required>
                                <label class="emailerror" style="color:red;"></label>
                                <div class="action">                             
                                    <input type="submit" class="btn btn-primary forgot" id="submit" value="Submit" />
                                </div>                
                            </div>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/webadmin/custom.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/webadmin/forgotpassword.js"></script>
    </body>
</html>