<?php

use JetBrains\PhpStorm\Pure;

function getActiveMenu($page): string
{
    return match ($page) {
        'schools', 'information' => 'education',
        'calendar', 'chat' => 'apps',
        'leagues', 'teams', 'matches', 'bets', 'my_bets', 'analysis' => 'sports',
        'users', 'icons', 'streams' => 'admin',

        default => 'user',
    };
}

function isLogged(): bool
{
    return isset($_SESSION['user']);
}

function generateForm($table, $database)
{
    $result = $database->getResult('describe ' . $table);
    $form = "";
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["Field"] !== "id") {
                $form .= "<div class='form-group row'>";
                $form .= "<label for='" . $row["Field"] . "' class='col-sm-2 col-form-label control-label text-white'>" . $row["Field"] . "</label>";
                $form .= " <div class='col-sm-10'>";
                $form .= "<input type='text' name='" . $row["Field"] . "' placeholder='Required *' class='form-control'>";
                $form .= "</div></div>";

            }
        }
    }
    echo (string)$form;

}

function weeks_between($startDate, $endDate): float
{


    $startDateWeekCnt = round(floor(date('d', strtotime($startDate)) / 7));
// echo $startDateWeekCnt ."\n";
    $endDateWeekCnt = round(ceil(date('d', strtotime($endDate)) / 7));
//echo $endDateWeekCnt. "\n";

    $datediff = strtotime(date('Y-m', strtotime($endDate)) . "-01") - strtotime(date('Y-m', strtotime($startDate)) . "-01");
    $totalnoOfWeek = round(floor($datediff / (60 * 60 * 24)) / 7) + $endDateWeekCnt - $startDateWeekCnt;
    return $totalnoOfWeek;

}

function days_between($startDate, $endDate): float
{


    $startDateWeekCnt = round(floor(date('d', strtotime($startDate))));
// echo $startDateWeekCnt ."\n";
    $endDateWeekCnt = round(ceil(date('d', strtotime($endDate))));
//echo $endDateWeekCnt. "\n";

    $datediff = strtotime(date('Y-m', strtotime($endDate)) . "-01") - strtotime(date('Y-m', strtotime($startDate)) . "-01");
    $totalnoOfWeek = round(floor($datediff / (60 * 60 * 24))) + $endDateWeekCnt - $startDateWeekCnt;
    return $totalnoOfWeek;

}

function hours_between($startDate, $endDate): float
{


    $startDateWeekCnt = round(floor(date('d', strtotime($startDate))));
// echo $startDateWeekCnt ."\n";
    $endDateWeekCnt = round(ceil(date('d', strtotime($endDate))));
//echo $endDateWeekCnt. "\n";

    $datediff = strtotime(date('Y-m', strtotime($endDate)) . "-01") - strtotime(date('Y-m', strtotime($startDate)) . "-01");
    $totalnoOfWeek = round(floor($datediff / (60 * 60))) + $endDateWeekCnt - $startDateWeekCnt;
    return $totalnoOfWeek;

}

function dateToWrite($date): string
{
    $year = substr($date, 0, 4);
    $month = substr($date, 5, 2);
    $day = substr($date, 8, 2);
    return $day . '.' . $month . '.' . $year;
}

function timeToWrite($time): string
{
    $hours = substr($time, 11, 2);
    $minutes = substr($time, 14, 2);
    return $hours . ':' . $minutes;
}


#[Pure] function isAdmin(): bool
{
    return isLogged() && $_SESSION['user'] == 8;
}

function timeFormat($seconds): string
{
    $hours = floor($seconds / 3600);
    $mins = floor($seconds / 60 % 60);
    $secs = floor($seconds % 60);

    return sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
}

/**
 * @param $today
 * @param $date_end
 * @param $done
 */
function getStatus($today, $date_end, $done): string
{
    $t1 = strtotime($today);
    $t2 = strtotime($date_end);
    $diff = $t2 - $t1;


    if ($done == 0 && $date_end === null) {

        return "<td><a href='#' class='badge badge-success'>In progress</a></td>";

    }
    if ($done === 1) {

        return "<td><a href='#' class='badge badge-success'>Successfully finished</a></td>";

    }
    if ($date_end < $today && $done == 0) {

        return "<td><a href='#' class='badge badge-danger'>Failed</a></td>";

    }

    return "<td><a href='#' class='badge badge-warning'>Missed</a></td>";


}

function getProjectIcon($name): string
{
    $parts = explode(' ', $name);
    $icon = "";
    foreach ($parts as $p) {
        $icon .= strtoupper($p[0]);
    }
    return $icon;

}

function getTimeDiff($start, $end): float|int
{
    return is_null($end) ? 0 : (strtotime($start) - strtotime($end)) / 60;
}


function showUndoneTasks($icons, $tasks)
{
    foreach ($tasks as $task) {
        if ($task->done == 0)
            showUndoneTask($task, $icons);
    }
}

function showDoneTasks($icons, $tasks)
{

    foreach ($tasks as $task) {
        if ($task->done == 1)
            showDoneTask($task, $icons);
    }


}


function showUndoneTask($task, $icons)
{
    ?>
    <li id="task-<?php echo $task->id ?>" class="list-group-item border-0"
        data-role="task">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="custom-control custom-checkbox material-checkbox col-lg-6 col-md-6 col-sm-6">
                <input id="task-input-<?php echo $task->id ?>" type="checkbox"
                       onclick="changeTask(<?php echo $task->id ?>)"
                       class="custom-control-input" <?php if ($task->done) echo "checked" ?>>
                <label class="custom-control-label text-white"
                       for="task-input-<?php echo $task->id ?>"> <a
                            href="?page=task=<?php echo $task->id ?>"><?php echo $task->name ?></a></label>
            </div>


            <div class="d-flex w-100 justify-content-between align-items-center">
                <?php
                switch ($task->type) {
                    case 'normal':
                        ?>
                        <a href="" class="badge badge-outline-info" data-toggle="tooltip" data-html="true"
                           title=""
                           data-original-title="<em>Common task</em>">
                            Common task
                        </a>
                        <?php
                        break;
                    case 'subject':
                        ?>
                        <a type="button" href="?page=subject&subject=<?php echo $task->connect->id ?>"
                           class="badge badge-outline-warning" data-toggle="tooltip" data-html="true" title=""
                           data-original-title="<em>Subject</em> <u><?php echo $task->connect->name ?></u>">
                            Subject
                        </a>
                        <?php
                        break;
                    case 'project':
                        ?>
                        <a type="button" href="?page=project&project=<?php echo $task->connect->id ?>"
                           class="badge badge-outline-success" data-toggle="tooltip" data-html="true" title=""
                           data-original-title="<em>Project</em> <u><?php echo $task->connect->name ?></u>">
                            Project
                        </a>
                        <?php
                        break;
                    default:
                }
                ?>
            </div>
            <div class="col-lg-1 <?php if (count($task->getProblems_Solved(0)) === 0) echo "d-none" ?>">
                <span class='badge badge-warning'><?php echo count($task->getProblems_Solved(0)) ?></span>
            </div>
            <div class="col-lg-1">
                <?php
                if ($task->date == null) {
                    echo "";
                } else if ($task->date <= Globals::$today) {
                    echo "<span class='badge badge-danger'><i class='mdi mdi-close-circle mdi-8px'></i></span>";
                } else {
                    $t1 = strtotime(Globals::$today);
                    $t2 = strtotime($task->date);
                    $diff = $t2 - $t1;
                    $hours = floor($diff / (60 * 60));
                    $days = floor($diff / (60 * 60 * 24));
                    $weeks = floor($diff / (60 * 60 * 24 * 7));
                    if ($hours <= 24) {
                        $echo = $hours . ' h';
                    } else if ($days <= 7) {
                        $echo = $days . ' d';
                    } else {
                        $echo = $weeks . ' t';
                    }
                    echo "<span class='badge badge-success'>$echo</span>";
                }
                ?>
            </div>
            <div id="icons-task-<?php echo $task->id ?>">
                <div id="icon-timer-<?php echo $task->id ?>"
                     class="icon-demo-content col-lg-1  <?php if (!$task->isTimerUp() && $icons !== 'timers') {
                         echo "d-none";
                     } ?>"
                     onclick="changeTimerTask(<?php echo $task->id ?>)"
                     title="<?php echo timeFormat($task->getWorkingTime()) ?>">
                                                     <span class="icon">
                                                        <?php if ($task->isTimerUp()) { ?>
                                                            <i style="color: #e83e8c" class="mdi mdi-timer"
                                                               title=""></i>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <i class="mdi mdi-timer"></i>
                                                            <?php
                                                        }
                                                        ?>
                                                        </span>
                </div>

                <div id="icon-archive-<?php echo $task->id ?>"
                     class="icon-demo-content col-lg-1 <?php if ($icons !== 'archives') echo "d-none" ?>"
                     onclick="changeConfirmButton(<?php echo $task->id ?>, 'archive')"
                     data-toggle="modal" data-target="#archiveTaskModal">
                                                    <span class="icon">
                                                        <i class="mdi mdi-archive"></i>
                                                    </span>
                </div>
                <div id="icon-delete-<?php echo $task->id ?>"
                     class="icon-demo-content col-lg-1 <?php if ($icons !== 'deletes') echo "d-none" ?>"
                     onclick="changeConfirmButton(<?php echo $task->id ?>, 'delete')"
                     data-toggle="modal" data-target="#deleteTaskModal">
                                                     <span class="icon">
                                                         <i class="mdi mdi-delete-forever"></i>
                                                     </span>
                </div>
            </div>
        </div>
    </li>
    <?php
}

function showDoneTask($task, $icons)
{
    ?>
    <li id="task-<?php echo $task->id ?>" class="list-group-item border-0"
        data-role="task">
        <div class="d-flex w-100 justify-content-between align-items-center">
            <div class="custom-control custom-checkbox material-checkbox col-lg-8">
                <input id="task-input-<?php echo $task->id ?>" type="checkbox"
                       onclick="changeTask(<?php echo $task->id ?>)"
                       class="custom-control-input" <?php if ($task->done) echo "checked" ?>>
                <label class="custom-control-label text-white"
                       for="task-input-<?php echo $task->id ?>">
                    <a href="?page=task&task=<?php echo $task->id ?>"><?php echo $task->name ?></a></label>

            </div>
            <div class="icon-demo-content col-lg-1 <?php if ($icons !== 'deletes') echo 'd-none' ?>"
                 onclick="changeConfirmButton(<?php echo $task->id ?>, 'delete')"
                 data-toggle="modal" data-target="#deleteTaskModal">
                                        <span class="icon">
                                            <i class="mdi mdi-delete-forever"></i>
                                        </span>
            </div>
            <div class="icon-demo-content col-lg-1 <?php if ($icons !== 'archives') echo 'd-none' ?>"
                 onclick="archiveTask(<?php echo $task->id ?>)">
                                        <span class="icon">
                                            <i class="mdi mdi-archive"></i>
                                        </span>
            </div>
        </div>

    </li>
    <?php
}

function showProject($project, $number, $edit = false)
{
    if (!$edit)
        echo " <tr id='project-tr-$project->id'>";
    ?>

    <td><?php echo $number; ?></td>
    <td><a class="btn-link"
           href="?page=project&project=<?php echo $project->id ?>"><?php echo $project->name ?></a>
    </td>
    <td><?php echo dateToWrite($project->start) ?></td>
    <td><?php $echo = $project->end == null ? $project->end : dateToWrite($project->end);
        echo $echo ?></td>
    <?php

    if ($project->done == 1) {
        ?>
        <td><a href="#" class="badge badge-success">Successful</a></td>
        <?php
    } else if ($project->done == 0 && ($project->end <= new DateTime('now'))) {
        ?>
        <td><a href="#" class="badge badge-info">In progress</a></td>
        <?php
    } else if ($project->end != '-' && $project->start <= $project->end && $project->done == 0) {
        ?>
        <td><a href="#" class="badge badge-danger">Missed</a></td>
        <?php
    }
    ?>
    <td><?php echo timeFormat($project->getWorkingTime()) ?></td>
    <td>
        <div class="btn-group dropdown">
            <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
               data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <?php
                if ($project->done == 1) {
                    ?>
                    <a class="dropdown-item" onclick="endProject(<?php echo $project->id ?>)"><i
                                class="lni-close mr-2 text-gray"></i>Cancel ending</a>
                <?php } else if ($project->done == 0) { ?>
                    <a class="dropdown-item" onclick="endProject(<?php echo $project->id ?>)"><i
                                class="lni-check-box mr-2 text-gray"></i>End</a>
                <?php } ?>
                <a class="dropdown-item" onclick="editProject(<?php echo $project->id ?>, <?php echo 1 ?>)"><i
                            class="lni-pencil mr-2 text-gray"></i>Edit</a>
                <a class="dropdown-item" onclick="deleteProject(<?php echo $project->id ?>)"><i
                            class="lni-trash mr-2 text-gray"></i>Delete</a>

            </div>
        </div>
    </td>
    <?php
    if (!$edit) {
        echo "</tr>";
    }
}

function cardGroupItem($name, $icon, $color, $current_value, $min_value, $max_value)
{
    ?>
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <div class="icon"><i class="<?php echo $icon ?>"></i></div>
                            <p class="text-white"><?php echo $name ?></p>
                        </div>
                        <div class="ml-auto">
                            <h2 id="counter-projects-done"
                                class="counter text-<?php echo $color ?>"><?php echo $current_value ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-<?php echo $color ?>" role="progressbar"
                             style="width: <?php if ($max_value == 0) {
                                 echo 0;
                             } else {
                                 echo (100 / $max_value) * $current_value;
                             } ?>%; height: 6px;"
                             aria-valuenow="<?php echo $current_value ?>"
                             aria-valuemin="<?php echo $min_value ?>"
                             aria-valuemax="<?php echo $max_value ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}

function cardGroupItemNumber($name, $icon, $color, $current_value, $min_value, $max_value, $number)
{
    ?>
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <div class="icon"><i class="<?php echo $icon ?>"></i></div>
                            <p class="text-white"><?php echo $name ?></p>
                        </div>
                        <div class="ml-auto">
                            <h2 id="counter-<?php echo $number ?>"
                                class="counter text-<?php echo $color ?>"><?php echo $current_value ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-<?php echo $color ?>" role="progressbar"
                             style="width: <?php if ($max_value == 0) echo 0; else echo (100 / $max_value) * $current_value; ?>%; height: 6px;"
                             aria-valuenow="<?php echo $current_value ?>"
                             aria-valuemin="<?php echo $min_value ?>"
                             aria-valuemax="<?php echo $max_value ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}

function cardGroupItemWithDate($name, $icon, $color, $date, $current_value, $min_value, $max_value)
{
    ?>
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <div class="icon"><i class="<?php echo $icon ?>"></i></div>
                            <p class="text-white"><?php echo $name ?></p>
                        </div>
                        <div class="ml-auto">
                            <h2 id="counter-projects-done"
                                class="counter text-<?php echo $color ?>"><?php if ($date === null) {
                                    echo 'Neurčený';
                                } else {
                                    echo dateToWrite($date) . ' ' . timeToWrite($date);
                                } ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-<?php echo $color ?>" role="progressbar"
                             style="width: <?php if ($date == null || $max_value == 0) echo 0; else echo (100 / $max_value) * $current_value ?>%; height: 6px;"
                             aria-valuenow="<?php if ($date == null) echo 0; else echo $current_value ?>"
                             aria-valuemin="<?php if ($date == null) echo 0; else echo $min_value ?>"
                             aria-valuemax="<?php if ($date == null) echo 0; else echo $max_value ?>"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}
