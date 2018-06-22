<!DOCTYPE html>
<html>
    <head>
        <title>LOUIE PARK</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon/favicon.ico">
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- styles -->
        <link href="<?php echo base_url(); ?>assets/vendors/form-helpers/css/bootstrap-formhelpers.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/webadmin/styles.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php
        if (isset($_SESSION[LOGGED_IN_ADMIN]) && $_SESSION[LOGGED_IN_ADMIN] != NULL) {
            $data = $_SESSION[LOGGED_IN_ADMIN];
            $userId = $data['user_id'];
        }
        ?>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <!-- Logo -->
                        <div class="logo">
                            <h1><a href="<?php echo base_url(); ?>webadmin">LOUIE PARK ADMIN</a></h1>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-lg-12">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="navbar navbar-inverse" role="banner">
                            <a href="<?php echo base_url(); ?>webadmin/logout">                
                                <h4> LOGOUT </h4>
                            </a>
                            <!-- <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                               <ul class="nav navbar-nav">
                                 <li class="dropdown">
                                   <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                                   <ul class="dropdown-menu animated fadeInUp">                            
                                     <li><?php if (isset($userId)) { ?>
                                                   <a href="<?php echo base_url(); ?>webadmin/logout">
                                                   
                                                       Log out
                                                   </a>
                            <?php } ?></li>
                                   </ul>
                                 </li>
                               </ul>
                             </nav> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-md-2">
                    <div class="sidebar content-box" style="display: block;">
                        <ul class="nav">
                            <!-- Main menu -->                   
                            <li><a href="<?php echo base_url(); ?>webadmin/Manage_users"><i class="glyphicon glyphicon-calendar"></i> Manage Users</a></li>
                            <li><a href="<?php echo base_url(); ?>webadmin/Verify_driveway"><i class="glyphicon glyphicon-calendar"></i> Verify Driveway<span class="label label-success verifycount"></span></a></li>
                            <li><a href="<?php echo base_url(); ?>webadmin/Settings"><i class="glyphicon glyphicon-stats"></i> Settings</a></li>
                           <!-- <li><a href="tables.html"><i class="glyphicon glyphicon-list"></i> Tables</a></li>
                            <li><a href="buttons.html"><i class="glyphicon glyphicon-record"></i> Buttons</a></li>
                            <li><a href="editors.html"><i class="glyphicon glyphicon-pencil"></i> Editors</a></li>
                            <li><a href="forms.html"><i class="glyphicon glyphicon-tasks"></i> Forms</a></li>
                            <li class="submenu">
                                 <a href="#">
                                    <i class="glyphicon glyphicon-list"></i> Pages
                                    <span class="caret pull-right"></span>
                                 </a> -->
                            <!-- Sub menu -->
                            <!--   <ul>
                                  <li><a href="login.html">Login</a></li>
                                  <li><a href="signup.html">Signup</a></li>
                              </ul>
                          </li> -->
                        </ul>
                    </div>
                </div>             