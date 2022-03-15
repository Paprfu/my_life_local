<?php

require_once('assets/php/init.php');
Globals::$path = basename($_SERVER['PHP_SELF'], ".php");
include_once('assets/php/server.php');



?>

<!DOCTYPE html>
<html lang="sk">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>True Fake</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

</head>
<body class="bg-black">

<div class="wrapper-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-12 col-xs-12">
                <div class="card bg-dark">
                    <div class="card-header border-bottom text-center">
                        <h4 class="card-title text-white">Sign In</h4>
                    </div>
                    <div class="card-body">
                        <?php include_once('assets/php/error.php'); ?>
                        <form class="form-horizontal m-t-20" method="post">
                            <div class="form-group">
	                            <label>
		                            <input class="form-control" name='name' type="text" required=""
		                                   placeholder="Insert name or email">
	                            </label>
                            </div>
                            <div class="form-group">
	                            <label>
		                            <input class="form-control" name="password" type="password" required=""
		                                   placeholder="Password">
	                            </label>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label text-white" for="customCheck1">Remember me
                                        </label>
                                </div>
                            </div>
                            <div class="form-group text-center m-t-20">
                                <button class="btn btn-common btn-block" name="log_user" type="submit">Sign In
                                </button>
                            </div>
                            <div class="form-group">
                                <div class="float-right">
                                    <a href="forgot-password.php" class="text-white"><i class="lni-lock"></i>
                                        Did you forget your password?</a>
                                </div>
                                <div class="float-left">
                                    <a href='register.php' class="text-white"><i class="lni-user"></i>Create account</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preloader -->
<div id="preloader">
    <div class="loader" id="loader-1"></div>
</div>
<!-- End Preloader -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/jquery-min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.app.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
