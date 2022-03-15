<?php

$task = null;
if (isset($_GET['task'])) {
    $task = Globals::$database->getTask_ID($_GET['task']);
} else {
    header('location: 404.php');
}

?>

<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Task - <?php echo $task->name; ?></h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li class="text-white">User /</li>
                        <li><a href="tasks.php"> Tasks /</a></li>
                        <?php

                        if ($task->connect != null) {
                            $connection_id = $task->connect->id;
                            $connection_name = $task->connect->name;
                            if ($task->type == 'project') {
                                echo "<li><a href='project.php?project=$connection_id'> Project $connection_name /</a></li>";
                            }
                            if ($task->type == 'subject') {
                                echo "<li><a href='project.php?project=$connection_id'> Subject $connection_name /</a></li>";
                            } else
                                echo '';
                        }
                        ?>
                        <li class="active">Task</li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>

        <div class="container-fluid">
            <?php
            include_once('assets/php/error.php');
            ?>
        </div>

        <div class="container-fluid">
            <div class="card-group">
                <?php
                cardGroupItemNumber('Solved problems', 'lni-agenda', 'success', count($task->getProblems_Solved(1)), 0, count($task->getProblems()), 1);
                cardGroupItem('Worked time', 'lni-timer', 'primary', timeFormat($task->getWorkingTime()), 0, 1000);


                $origin = new DateTime($task->date_created);
                $target = new DateTime($task->date);
                $target2 = new DateTime(date('Y-m-d'));


                $interval = $origin->diff($target);
                $interval2 = $origin->diff($target2);
                $date_diff = $interval->format('%a');
                $date_diff2 = $interval2->format('%a');
                cardGroupItemWithDate('Start of the task', 'lni-calendar', 'info', $task->date_created, $date_diff2, 0, $date_diff);
                cardGroupItemWithDate('End of the task', 'lni-calendar', 'danger', $task->date, $date_diff - $date_diff2, 0, $date_diff);
                ?>
            </div>
        </div>


        <div class="row">
            <div class="container-fluid">
                <div class="col-12">
                    <div class="card bg-dark">
                        <div class="card-header border-bottom">
                            <h4 class="card-title text-white">Problems</h4>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive-sm">
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Problem</th>
                                        <th>Solved?</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="task-problems-tbody">
                                    <?php
                                    $problems = $task->getProblems_Order('solved', 'ASC');
                                    $number = 1;
                                    foreach ($problems as $p) {
                                        showProblemInTable($p, true);
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>


                        </div>


                        <div class="card-footer">
                            <button class="btn btn-common" data-toggle="modal" data-target="#addProblemModal">
                                <i class="mdi mdi-plus mdi-18px"></i>Create new problem
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-dark">
                        <div class="card-header border-bottom">
                            <h4 class="card-title text-white">Working time</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons"
                                       class="table table-bordered table-sm table-responsive-sm text-center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Time</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody id="archived-tasks">
                                    <?php
                                    $wots = $task->getWorkingOnTasks();
                                    $number = 1;
                                    foreach ($wots as $wot) {

                                        ?>
                                        <tr id="archived-tasks-table-tr-<?php echo $task->id ?>">
                                            <td><?php echo $number ?></td>
                                            <td><?php echo dateToWrite($wot['start']) . ' ' . timeToWrite($wot['start']) ?></td>
                                            <td><?php echo dateToWrite($wot['end']) . ' ' . timeToWrite($wot['end']) ?></td>
                                            <td><?php echo timeFormat($wot['time'])

                                                ?></td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);"
                                                       class="dropdown-toggle arrow-none"
                                                       data-toggle="dropdown" aria-expanded="false"><i
                                                                data-toggle="dropdown" aria-expanded="false"><i
                                                                    class="lni-more-alt"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                           onclick="returnTask(<?php echo $task->id ?>, <?php echo $task->done ?>)"><i
                                                                    class="lni-reload mr-2"></i>Edit
                                                        </a>
                                                        <a class="dropdown-item"
                                                           onclick="changeConfirmButton(<?php echo $task->id ?>, 'delete')"><i
                                                                    class="lni-trash mr-2"></i>Remove</a>

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


        <div id="addProblemModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalAddProblem"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalAddProblem">Create problem</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="name-input" class="control-label">Name</label>

                                    <input id="name-input" type="text" class="form-control" name="name"
                                           placeholder="Name">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="form-group row">
                                    <label for="note-textarea" class="control-label">Description</label>

                                    <textarea id="note-textarea" type="text" class="form-control" name="note"
                                              placeholder="Description"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-dark">
                        <button type="button" class="btn btn-common waves-effect"
                                onclick="addProblem(<?php echo $task->id ?>)" data-dismiss="modal">Create problem
                        </button>
                        <button type="button" class="btn btn-secondary waves-effect"
                                data-dismiss="modal">Close
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <div id="editProblemModal" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="myModalEditProblem"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div id="problem-modal-content-div" class="modal-content bg-dark text-white">

                </div>
            </div>
        </div>


    </div>



