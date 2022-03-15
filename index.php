<?php
include_once('assets/php/init.php');
Globals::$path = basename($_SERVER['PHP_SELF'], ".php");

include_once('assets/php/server.php');
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="assets/img/favicon.ico"/>
    <title>True Fake | Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/line-icons.css">
    <link href="assets/plugins/fullcalendar/css/fullcalendar.min.css" rel="stylesheet"/>
    <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <!-- Responsive datatable examples -->
    <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/icons.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

</head>
<body>

<div class="app header-default side-nav-dark">
    <div class="layout">
        <!-- Header START -->
        <div class="header navbar">
            <div class="header-container">
                <div class="nav-logo">
                    <a href="index.php">
                        <b><img src="assets/img/favicon.ico" alt="" class="animate__backInLeft"></b>
                        <span class="logo">
                             <img src="assets/img/logo-text.png" alt="">
                         </span>

                    </a>
                </div>
                <ul class="nav-left">
                    <li>
                        <a class="sidenav-fold-toggler" href="javascript:void(0);">
                            <i class="lni-menu"></i>
                        </a>
                        <a class="sidenav-expand-toggler" href="javascript:void(0);">
                            <i class="lni-menu"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav-right">
                    <li class="search-box">
                        <label for="finding"></label>
                        <input id="finding" class="text-white form-control" type="text" oninput="showUsers()">
                        <i class="text-white lni-search"></i>
                        <ul id="users-popup">

                        </ul>
                    </li>
                    <li class="massages dropdown dropdown-animated scale-left">
                        <span class="counter"><?php echo count(Globals::$person->getMessages_Unshown()) ?></span>
                        <a onclick="" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="lni-envelope"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-lg">
                            <li>
                                <div class="dropdown-item align-self-center">
                                    <h5>
                                        <span class="badge badge-primary float-right"><?php echo count(Globals::$person->getMessages_Unshown()) ?></span>Nové
                                        správy</h5>
                                </div>
                            </li>
                            <li>
                                <ul class="list-media">
                                    <?php
                                    $messages = Globals::$person->getMessages_Unshown();
                                    foreach ($messages as $message) {
                                        ?>
                                        <li class="list-item">
                                            <a href="?page=profile&person=<?php echo $message->sender->id ?>"
                                               class="media-hover">
                                                <div class="media-img">
                                                    <img src="<?php echo $message->sender->pi->photo ?>" alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title">
                                                        <?php echo $message->sender->name ?>
                                                    </span>
                                                    <span class="sub-title"><?php echo $message->text ?></span>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="check-all text-center">
                    <span>
                      <a href="?page=chat" class="text-white">Zobraziť všetko</a>
                    </span>
                            </li>
                        </ul>
                    </li>
                    <li class="notifications dropdown dropdown-animated scale-left">
                        <span class="counter">2</span>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="lni-alarm"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-lg">
                            <li>
                                <h5 class="n-title text-center">
                                    <i class="lni-alarm"></i>
                                    <span>Notifications</span>
                                </h5>
                            </li>
                            <li>
                                <ul class="list-media">
                                    <li class="list-item">
                                        <a href="#" class="media-hover">
                                            <div class="media-img">
                                                <div class="icon-avatar bg-primary">
                                                    <i class="lni-envelope"></i>
                                                </div>
                                            </div>
                                            <div class="info">
                            <span class="title">
                              5 new messages
                            </span>
                                                <span class="sub-title">4 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-item">
                                        <a href="#" class="media-hover">
                                            <div class="media-img">
                                                <div class="icon-avatar bg-success">
                                                    <i class="lni-comments-alt"></i>
                                                </div>
                                            </div>
                                            <div class="info">
                            <span class="title">
                                4 new comments
                            </span>
                                                <span class="sub-title">12 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-item">
                                        <a href="#" class="media-hover">
                                            <div class="media-img">
                                                <div class="icon-avatar bg-info">
                                                    <i class="lni-users"></i>
                                                </div>
                                            </div>
                                            <div class="info">
                            <span class="title">
                              3 Friend Requests
                            </span>
                                                <span class="sub-title">a day ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="list-item">
                                        <a href="#" class="media-hover">
                                            <div class="media-img">
                                                <div class="icon-avatar bg-purple">
                                                    <i class="lni-comments-alt"></i>
                                                </div>
                                            </div>
                                            <div class="info">
                            <span class="title">
                              2 new messages
                            </span>
                                                <span class="sub-title">12 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="check-all text-center">
                    <span>
                      <a href="#" class="text-white">Check all notifications</a>
                    </span>
                            </li>
                        </ul>
                    </li>
                    <li class="user-profile dropdown dropdown-animated scale-left">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img class="profile-img" src="<?php echo Globals::$person->pi->photo ?>" alt="">
                        </a>
                        <ul class="dropdown-menu dropdown-md">
                            <li>
                                <ul class="list-media">
                                    <li class="list-item avatar-info">
                                        <div class="media-img">
                                            <img src="<?php echo Globals::$person->pi->photo ?>" alt="">
                                        </div>
                                        <div class="info">
                                            <span class="title text-semibold"><?php echo Globals::$person->name ?></span>
                                            <span class="sub-title"><?php echo Globals::$person->pi->description ?></span>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li role="separator" class="divider"></li>

                            <li>
                                <a href="?page=profil">
                                    <i class="lni-user"></i>
                                    <span>Profil</span>
                                </a>
                            </li>
                            <li>
                                <a href="?page=settings">
                                    <i class="lni-cog"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="lni-envelope"></i>
                                    <span>Inbox</span>
                                    <span class="badge badge-pill badge-primary pull-right">2</span>
                                </a>
                            </li>
                            <li>
                                <a href="?logout">
                                    <i class="lni-lock"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header END -->

        <?php
        include_once('menu.php');
        include_once('assets/php/page.php');
        ?>
        <!-- Footer START -->
        <footer class="content-footer bg-dark">
            <div class="footer">
                <div class="copyright">
                        <span class="text-white">Copyright © 2018 <b
                                    class="text-white">UIdeck</b>. All Right Reserved</span>
                    <span class="go-right">
                  <a href="" class="text-white">Term &amp; Conditions</a>
                  <a href="" class="text-white">Privacy &amp; Policy</a>
                </span>
                </div>
            </div>
        </footer>
        <!-- Footer END -->
        <!-- Page Container END -->
    </div>
    <!-- Layout END -->
</div>
<!-- App END -->

<!-- Preloader -->
<div id="preloader">
    <div class="loader" id="loader-1"></div>
</div>
<!-- End Preloader -->
<?php
$time = time();
?>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assets/js/jquery-min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.app.js"></script>
<script src="assets/js/jquery.validation.min.js"></script>
<script src="assets/js/main.js?<?php echo $time ?>"></script>

<!--Morris Chart-->
<?php
if (!isset($_GET['page'])) {
    ?>

    <?php
} else {
    switch ($_GET['page']) {
    case 'dashboard':
        ?>
        <script src="assets/js/scripts/index.js"></script>
        <script src="assets/js/scripts/tasks.js?<?php echo $time ?>"></script>
        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>
        <script src="assets/js/dashborad1.js"></script>
        <script src="assets/js/scripts/tasks.js?<?php echo $time ?>"></script>
        <script src="assets/js/scripts/dashboard.js"></script>
    <?php
    break;
    case 'streams':
    case 'stream':
    case 'icons':
    case 'admin':
    ?>
        <script src="assets/js/scripts/admin.js?<?php echo $time ?>"></script>
    <?php
    break;
    case 'profile':
    ?>
        <script src="assets/js/scripts/profile.js?<?php echo $time ?>"></script>
    <?php
    break;
    case 'project':
    case 'projects':
    ?>
        <script src="assets/js/scripts/projects.js?<?php echo $time ?>"></script>
    <?php
    break;
    case 'users':

    include_once('assets/php/includes/datables_scripts.php');
    ?>
        <script src="assets/js/scripts/admin.js?<?php echo $time ?>"></script>
    <?php
    break;
    case 'tasks':
    require_once('assets/php/includes/datables_scripts.php');
    ?>
        <script src="assets/js/scripts/tasks.js?<?php echo $time ?>"></script>
    <?php
    break;
    case 'task':
    ?>
        <script src="assets/js/scripts/tasks.js?<?php echo $time ?>"></script>
        <script src="assets/js/scripts/task.js?<?php echo $time ?>"></script>

    <?php
    include_once('assets/php/includes/datables_scripts.php');

    break;
    case 'activities':
    include_once('assets/php/includes/datables_scripts.php');
    ?>
        <script src="assets/js/scripts/activities.js?<?php echo $time ?>"></script>

    <?php
    break;
    case 'calendar':
    ?>
        <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="assets/plugins/moment/moment.js"></script>
        <script src='assets/plugins/fullcalendar/js/fullcalendar.min.js'></script>
        <script src="assets/js/calendar-init.js"></script>
        <script src="assets/js/scripts/calendar.js?<?php echo $time ?>"></script>

    <?php
    include_once('assets/php/includes/datables_scripts.php');

    break;
    case 'challenges':
    ?>
        <script src="assets/js/scripts/challenge.js?<?php echo $time ?>"></script>
    <?php
    include_once('assets/php/includes/datables_scripts.php');
    break;
    case 'subject':
    case 'subjects':
    case 'schoolEvent':
    ?>
        <script src="assets/js/scripts/subjects.js?<?php echo $time ?>"></script>

    <?php
    include_once('assets/php/includes/datables_scripts.php');
    break;
    case 'index':
    ?>


    <?php
    break;
    case 'blogs':
    ?>
        <script src="assets/js/scripts/blogs.js?<?php echo $time ?>"></script>
    <?php
    break;
    case 'bets':
    case 'person_bets':
    ?>
        <script src="assets/js/scripts/bets.js?<?php echo $time ?>"></script>
    <?php
    include_once('assets/php/includes/datables_scripts.php');

    break;
    case 'matches';
    ?>
        <script src="assets/js/scripts/matches.js?<?php echo $time ?>"></script>
    <?php
    include_once('assets/php/includes/datables_scripts.php');

    break;
    case 'teams';
    ?>
        <script src="assets/js/scripts/teams.js?<?php echo $time ?>"></script>
    <?php
    include_once('assets/php/includes/datables_scripts.php');

    break;
    case 'match':
    ?>
        <script src="assets/js/scripts/leagues.js?<?php echo $time ?>"></script>
        <script src="assets/js/scripts/matches.js?<?php echo $time ?>"></script>
    <?php
    include_once('assets/php/includes/datables_scripts.php');
    break;
    case 'information':
        include_once('assets/php/includes/datables_scripts.php');
        break;
    default:
    ?>

    <?php

    }
}
?>

</body>
</html>




