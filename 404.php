<?php
    include_once ('assets/php/server.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inspire - Admin and Dashboard Template</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

</head>

<body class="bg-dark">
<div class="layout">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center h-100vh w-100vw align-items-center">
                    <div class="error-container text-center">
                        <h1 class="error-number text-dark">404</h1>
                        <h2 class="semi-bold">Táto stránka nebola nájdená.</h2>
                        <p class="p-b-10"><?php include_once ('assets/php/error.php')?></p>
                        <div><a href="index.php?page=dashboard" class="btn btn-common btn-rounded btn-lg">Naspäť na hlavnú stránku</a></div>
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
