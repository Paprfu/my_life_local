<?php
$database = Globals::$database;
$project = null;
$errors = array();
if (isset($_GET['project'])) {
    $project = $database->getProject_ID($_GET['project']);
    if ($project == null) {
        $errors[] = "Project has not been found in database!";
        header('location: ?page=projects');
    }
} else {
    $errors[] = "Project has not been selected!";

    header('location: ?page=projects');
}
?>

<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Projects - <?php echo $project->name; ?></h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li class="text-white">User /</li>
                        <li><a href="?page=projects"> Projects /</a></li>
                        <li class="active"><?php echo $project->name ?></li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>

        <div id="projects-info" class="container-fluid">
            <div class="card-group">
                <?php
                cardGroupItem('Tasks', 'mdi mdi-clipboard-text', 'primary', count($project->getTasks_Done(0)), 0, count($project->getTasks()) - count($project->getTasks_Done(2)));
                cardGroupItem('Finished tasks', 'mdi mdi-check', 'success', count($project->getTasks_Done(1)), 0, count($project->getTasks()) - count($project->getTasks_Done(2)));
                cardGroupItemWithDate('Start of the project', 'mdi mdi-calendar', 'info', $project->start, Globals::$today, $project->start, $project->end);
                cardGroupItem("Working time", 'mdi mdi-timer', 'purple', timeFormat($project->getWorkingTime()), 0, getTimeDiff($project->start, $project->end));
                ?>

            </div>
        </div>

        <div id="tasks-div" class="container-fluid">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card bg-dark">
                        <div class="card-header">
                            <h4 class="card-title text-white">Finished tasks</h4>
                        </div>
                        <ul id="tasks-done" class="list-task list-group">
                            <?php
                            $tasks = $project->getTasks_Done(1);
                            showDoneTasks('no', $tasks);
                            ?>
                        </ul>
                    </div>
                </div>


                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="card bg-dark">
                        <div class="card-header">
                            <h4 class="card-title text-white">Tasks to be done</h4>
                            <div class="card-toolbar">
                                <div class="btn-group dropdown">
                                    <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                                       data-toggle="dropdown" aria-expanded="false"><i class="lni-more-alt"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                                         style="position: absolute; transform: translate3d(-166px, 20px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="tasks.php" target="_blank"><i
                                                    class="lni-add-files mr-2 text-gray"></i>Add task</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul id="tasks-to-do" class="list-task list-group">
                            <?php
                            $tasks = $project->getTasks_Done(0);

                            showDoneTasks('no', $tasks);
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="deleteTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalTasks"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalTasks">Delete task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        Delete task?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" onclick="deleteTask()"
                                data-dismiss="modal">Close
                        </button>
                        <div id="deleteTasks">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>