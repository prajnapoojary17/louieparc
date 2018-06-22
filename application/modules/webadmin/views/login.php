<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<!DOCTYPE html>
<html>
    <style>
        /* Full-width input fields */
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Set a style for all buttons */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        /* Extra styles for the cancel button */
        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        /* Center the image and position the close button */
        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
            position: relative;
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        .row {

            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        .form-error {
            color:red;
            margin-top:10px;
        }

        /* Content/Box */
        .content {
            background-color: #fefefe;
            margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 35%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button (x) */
        .close {
            position: absolute;
            right: 25px;
            top: 0;
            color: #000;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }



        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }
            .cancelbtn {
                width: 100%;
            }
        }
    </style>
    <body>
        <div class="row">  
            <form class="content animate" action="<?php echo base_url(); ?>webadmin/login/validate" method="POST">
                <div class="imgcontainer">     
                    LOGIN <!--<img src="img_avatar2.png" alt="Avatar" class="avatar"> -->
                    <div class="form-error">
                        <?php echo validation_errors(); ?>    
                    </div>
                </div>
                <?php
                echo validation_errors();
                if (isset($success)) {
                    echo '<div class="alert_error" style="display:block">You have successfully reset your password</div>';
                }
                ?> 
                <div class="container">
                    <label><b>User Name</b></label>
                    <input type="text" placeholder="Enter Username" name="username" required>
                    <label><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" required>        
                    <button type="submit">Login</button>
                    <span class="psw">Forgot Password? <a href="<?php echo base_url(); ?>webadmin/login/forgot">Click Here</a></span> 
                </div>
                <div class="container" style="background-color:#f1f1f1"></div>
            </form>
        </div>
    </body>
</html>