<!DOCTYPE html>
<html>
    <head>
        <title>Bootstrap Admin Theme v3</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- styles -->
        <link href="<?php echo base_url(); ?>assets/css/webadmin/styles.css" rel="stylesheet">

    </head>
    <body class="login-bg">
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
                                <form action="" class="login__form" method="post">
                                    <?php
                                    echo validation_errors();
                                    if (isset($msg)) {
                                        echo '<div class="error_box" style="display:block">' . "$msg" . '</div>';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control" required> <label>New
                                            Password</label> <span class="bar"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password_conf" id="password_conf" class="form-control"
                                               required> <label>Confirm Password</label> <span class="bar"></span>
                                    </div>
                                    <input type="submit" class="btn btn-brand btn-block"
                                           value="Reset" />
                                </form>              
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