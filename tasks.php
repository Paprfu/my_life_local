<?php
require_once('assets/php/functions/tasks_functions.php');

$database = Globals::$database;
$person = Globals::$person;
//SET REPEAT TASKS
$repeats = $person->getTasks_Type('repeat');
foreach ($repeats as $r) {
    $sql = "SELECT * FROM tasks WHERE id_task='$r->id'";
    $result = $database->getResult($sql);
    if (mysqli_num_rows($result) < 1) {
        $r->setDone(0);
    }
}

?>


<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Tasks</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="?page=user">User</a></li>
                        <li class="active">/ Tasks</li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>
        <?php
        showTasks();
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-dark">
                        <div class="card-header border-bottom">
                            <h4 class="card-title text-white">Archive tasks</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable"
                                       class="table table-bordered table-sm table-responsive-sm text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Start</th>
                                        <th>Date </th>
                                        <th>Deadline</th>
                                        <th>Working Time</th>
                                        <th>End in time</th>
                                        <th>Successful</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="archived-tasks">
                                    <?php
                                    $number = 1;
                                    $tasks = $person->getTasks_Done(2);
                                    foreach ($tasks as $task) {
                                        if ($task->done != 2)
                                            continue;
                                        ?>
                                        <tr id="archived-tasks-table-tr-<?php echo $task->id ?>">
                                            <td><?php echo $number ?></td>
                                            <td><?php echo "<a href='task.php?task=$task->id'>$task->name </a>"?></td>
                                            <td><?php echo dateToWrite($task->date_created) ?></td>
                                            <td><?php echo dateToWrite($task->date) ?></td>
                                            <td><?php echo dateToWrite($task->date_done) ?></td>
                                            <td><?php echo timeFormat($task->getWorkingTime()) ?></td>
                                            <td>
                                                <?php
                                                if ($task->date_done >= $task->date || $task->date == '') {
                                                    echo "<span class='mdi mdi-check-circle mdi-18px text-success'></span>";
                                                }
                                                else {
                                                    echo "<span class='mdi mdi-close-circle mdi-18px text-danger'></span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($task->done) {
                                                    echo "<span class='mdi mdi-check-circle mdi-18px'></span>";
                                                }
                                                else {
                                                    echo "<span class='mdi mdi-close-circle mdi-18px'></span>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);"
                                                       class="dropdown-toggle arrow-none"
                                                       data-toggle="dropdown" aria-expanded="false"><i
                                                            class="lni-more-alt"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           onclick="returnTask(<?php echo $task->id ?>)"><i
                                                                class="lni-pencil mr-2 text-gray"></i>Return</a>
                                                        <a class="dropdown-item"
                                                           onclick="editArchivedTask(<?php echo $task->id ?>)"><i
                                                                class="lni-pencil mr-2 text-gray"></i>Edit</a>
                                                        <a class="dropdown-item"
                                                           onclick="deleteArchivedTask(<?php echo $task->id ?>)"><i
                                                                class="lni-trash mr-2 text-gray"></i>Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $number++;
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>

        <!-- MODALS -->


        <?php
        addTaskModal(null);
        deleteTaskModal();
        archiveTaskModal();
        ?>
    </div>
