<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CASCO Market</title>

    <link rel="icon" href="assets/icons/casco__logo.svg">
    <link rel="stylesheet" href="assets/css/dir/login.css">
    <link rel="stylesheet" href="assets/css/dir/login.css?<?=filemtime("assets/css/dir/login.css")?>">
    <script src="includes/js__backend/jquery.js"></script>

</head>
<body>

    
    <div class="login">
        <div class="logo">
            <img src="assets/icons/casco__logo.svg" alt=""><br>
            <label class="login-desc">Sign in to CASCO Market</label>
        </div>
    
    
    <p id="validation-msg"></p>
    <div class="wrapper">

        <div class="row">
            <div class="column">
                <div>
                    <div class="login-label">
                        <label  id="label-email">Email</label>
                    </div>

                <div class="login-input">
                    <input class="login-textbox"  id="email" type="email">
                </div>
            </div>

            <div>
                <div class="align-pwd">
                    <div class="login-label">
                        <label  id="label-pwd">Password</label>
                    </div>
                        <a class="forgot-pwd" href="">Forgot Password?</a>
                    </div>

                    <div class="login-input">
                        <input class="login-textbox"  id="pwd" type="password">
                    </div>
                </div>

                <div class="login-button">
                    <button class="submit-button" id="submit" type="submit">Log In</button>
                    <div>
                        <label class="create-lbl">Don't have an account? <a href="registration.php">Create an account</a> </label>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script src="includes/js__backend/login.inc.js"></script>

