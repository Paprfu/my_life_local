
<!-- Page Container START -->
    <div class="page-container">
        <!-- Content Wrapper START -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- Breadcrumb Start -->
                <div class="breadcrumb-wrapper row">
                    <div class="col-12 col-lg-3 col-md-6">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="col-12 col-lg-9 col-md-6">
                        <ol class="breadcrumb float-right">
                            <li><a href="?page=profile">User</a></li>
                            <li class="active">/ Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- Breadcrumb End -->
            </div>

            <div class="container-fluid">
                <!-- Title Count Start -->
                <div class="card-group">
	                <?php
		                cardGroupItem('Tasks to do', 'lni-check-box', 'primary', count(Globals::$person->getTasks_Done(0)), 0, count(Globals::$person->getTasks()));
		                cardGroupItem('Projects', 'lni-clipboard', 'success', count(Globals::$person->getProjects_Done(0)), 0, count(Globals::$person->getProjects()));
		                cardGroupItem('Subjects', 'lni-graduation', 'info', count(Globals::$person->getSubjects_Actual(0)), 0, count(Globals::$person->getSubjects()));
		                cardGroupItem('Events', 'lni-calendar', 'purple', count(Globals::$person->getCalendarEvents_From_Order_Direction_Limit(date('Y-m-d'))), 0, count(Globals::$person->getCalendarEvents()));

	                ?>

                </div>
                <!-- Title Count End -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card bg-dark">
                            <div class="card-header">
                                <h5 class="text-white card-title">Time overview</h5>
                                <div class="float-right">
                                    <ul class="list-inline d-none d-sm-block">
                                        <li>
                                            <span class="status bg-primary"></span>
                                            <span class="text-white text-semibold">Return</span>
                                        </li>
                                        <li>
                                            <span class="status bg-success"></span>
                                            <span class="text-white text-semibold">Revenue</span>
                                        </li>
                                        <li>
                                            <span class="status bg-purple"></span>
                                            <span class="text-white text-semibold">Cost</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="morris-bar-example" style="height: 372px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-12 stretch-card">
                                <div class="card bg-dark">
                                    <div class="card-body">
                                        <div class="sales-info">
                                            <h3 class="text-white"><?php echo Globals::$person->getWorkingTime() ?></h3>
                                            <span class="text-white">Overall working time</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="35"
                                                 style="width: 75%"></div>
                                        </div>
                                        <p class="text-white">42% higher than last month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 stretch-card">
                                <div class="card bg-dark">
                                    <div class="card-body">
                                        <div class="sales-info">
                                            <h3 class="text-white">34,000</h3>
                                            <span class="text-white">Active Installations</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="35"
                                                 style="width: 55%"></div>
                                        </div>
                                        <p class="text-white">19% less than last month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 stretch-card">
                                <div class="card bg-dark">
                                    <div class="card-body">
                                        <div class="sales-info">
                                            <h3 class="text-white">11,279</h3>
                                            <span class="text-white">Total downloads</span>
                                        </div>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="35"
                                                 style="width: 35%"></div>
                                        </div>
                                        <p class="text-white">73% higher than last month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-xs-12">
                        <div class="card bg-dark text-color-white">
                            <div class="card-header">
                                <h4 class="card-title text-white">Práca na projektoch</h4>
                                <div class="selected float-right">
                                    <select id="projects-time-select" class="custom-select text-dark"
                                            onchange="project('showWorkingTime')">
                                        <option selected="selected" value="0">Mesačne</option>
                                        <option value="1">Denne</option>
                                        <option value="2">Týždenne</option>
                                        <option value="3">Ročne</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-overflow">
                                <table class="table table-lg">
                                    <thead>
                                    <tr>
                                        <td class="text-white text-semibold">Projekt</td>
                                        <td class="text-white text-semibold"></td>
                                        <td class="text-white text-semibold">Stav</td>
                                        <td class="text-white text-semibold">Čas</td>

                                    </tr>
                                    </thead>
                                    <tbody id="projects-tbody">
                                    <?php
                                    $month_start = strtotime('first day of this month', time());
                                    $month_end = strtotime('last day of this month', time());

                                    $from = date('Y-m-d H:i:s', $month_start);
                                    $to = date('Y-m-d H:i:s', $month_end);
                                    $projects = Globals::$person->getProjects();
                                    foreach ($projects as $p) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="list-media">
                                                    <div class="list-item">
                                                        <div class="media-img">
                                                            <a class="btn btn-circle btn-info"><?php echo getProjectIcon($p->name) ?></a>
                                                        </div>
                                                        <div class="info">
                                                            <span class="title text-semibold"><?php echo $p->name ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo getStatus(Globals::$today, $p->end, $p->done) ?></td>
                                            <td id="project-time-td-"<?php echo $p->id ?>><?php echo timeFormat($p->getWorkingTime_From_To($from, $to)) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-xs-12">
                        <div class="card bg-dark">
                            <div class="card-body text-center">
                                <h4 class="header-title text-white">Earning Sources</h4>
                                <ul class="list-inline widget-chart m-t-20 text-center">
                                    <li>
                                        <h4 class="text-white"><b>3654</b></h4>
                                        <p class="text-white m-b-0">Marketplace</p>
                                    </li>
                                    <li>
                                        <h4 class="text-white"><b>954</b></h4>
                                        <p class="text-white m-b-0">On Site</p>
                                    </li>
                                    <li>
                                        <h4 class="text-white"><b>262</b></h4>
                                        <p class="text-white m-b-0">Others</p>
                                    </li>
                                </ul>
                                <div id="morris-donut-example" style="height: 240px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="card bg-dark">
                            <div class="card-header">
                                <h4 class="card-title text-white">Úlohy</h4>
                                <div class="card-toolbar">
                                    <ul>
                                        <li>
                                            <a class="text-white" href="#">
                                                <i class="lni-more-alt"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="list-task list-group">
                                <?php
                                $tasks = Globals::$person->getTasks();
                                showUndoneTasks('no', $tasks);
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <div class="follow">
                            <div class="card bg-dark">
                                <div class="card-header">
                                    <h4 class="card-title text-white">Noví použivatelia</h4>
                                    <div class="card-toolbar">
                                        <ul>
                                            <li>
                                                <a class="text-white" href="#">
                                                    <i class="lni-more-alt"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="list-media">
                                    <?php
                                    $sql = "SELECT * FROM person ORDER BY id_person DESC LIMIT 5";
                                    $result = Globals::$database->getResult($sql);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $p = new Person($row, Globals::$database);
                                        if($p->id === Globals::$person->id) continue;
                                        ?>
                                        <li class="list-item">
                                            <div class="client-item">
                                                <div class="media-img">
                                                    <img src="<?php echo $p->pi->photo ?>" alt="">
                                                </div>
                                                <div class="info">
                                                    <span class="title text-white text-semibold"><?php echo $p->name ?></span>
                                                    <?php
                                                    /*
                                                    $follow = $person->getFollow($p);
                                                    if ($follow == null) {
                                                        ?>
                                                        <div class="float-item">
                                                            <button class="btn btn-common btn-rounded"
                                                                    onclick="follow(<?php echo $p->id ?>)">Sledovať
                                                            </button>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        switch ($follow->accepted) {
                                                            case 0:
                                                                ?>
                                                                <div class="float-item">
                                                                    <button class="btn btn-common btn-rounded"
                                                                            onclick="follow(<?php echo $p->id ?>)">
                                                                        Žiadosť odoslaná
                                                                    </button>
                                                                </div>
                                                                <?php
                                                                break;
                                                            case 1:
                                                                ?>
                                                                <div class="float-item">
                                                                    <button class="btn btn-success btn-rounded">
                                                                        Sledovaný
                                                                    </button>
                                                                </div>
                                                                <?php
                                                                break;
                                                            case 2:
                                                                ?>
                                                                <div class="float-item" title>
                                                                    <button class="btn btn-danger btn-rounded">Znova
                                                                        požiadať o sledovanie
                                                                    </button>
                                                                </div>
                                                                <?php
                                                                break;
                                                            default:
                                                                ?>
                                                                <div class="float-item" title>
                                                                    <button class="btn btn-danger btn-rounded">Znova
                                                                        požiadať o sledovanie
                                                                    </button>
                                                                </div>
                                                            <?php
                                                        }
                                                    } */
                                                    ?>

                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="coming-event">
                            <div class="card bg-dark">
                                <div class="card-header">
                                    <h4 class="card-title text-white">Events</h4>
                                    <div class="card-toolbar">
                                        <ul>
                                            <li>
                                                <a class="text-white" href="#">
                                                    <i class="lni-more-alt"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="event-item">
                                    <?php
                                    $date = date("Y-m-d");
                                    $events = Globals::$person->getCalendarEvents_From_Order_Direction_Limit($date, 'start', 'ASC', 2);
                                    foreach ($events as $event) {
                                        ?>
                                        <li>
                                            <a href="calendar.php">
                                                <div class="media">
                                                    <div class="img-thumb">
                                                        <img class="img-fluid" src="assets/img/event/img-1.jpg" alt="">
                                                    </div>
                                                    <div class="text">
                                                        <h5 class="text-white"><?php echo $event->name ?></h5>
                                                        <p class="day text-white"><?php echo dateToWrite($event->start) ?></p>
                                                        <p class="text-white"><?php echo timeToWrite($event->start) ?> </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content Wrapper END -->