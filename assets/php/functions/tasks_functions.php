<?php
function addTaskModal($object)
{
    ?>
    <div id="addTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalAddTask"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalAddTask">Add task</h5>
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
                            <div class="form-group row">
                                <label class="control-label" for="date-input">Deadline</label>
                                <input id="date-input" type="date" class="form-control"
                                       name="date" value="">
                                <label for="time-input"></label>
                                <input id="time-input" type="time" class="form-control"
                                       name="time" value="">
                            </div>
                            <div class="form-group row">
                                <label for="select-type" class="control-label">Type</label>
                                <select id="select-type" class="form-control" onchange="showConnect()">
                                    <option value="normal">Common</option>
                                    <option value="repeat">Repeatable</option>
                                    <option value="project">Project</option>
                                    <option value="subject">Subject</option>
                                </select>
                            </div>
                            <div id="pripojenie-div" class="form-group row hidden">
                                <label for="pripojenie-select" class="control-label">Connection</label>

                                <select id="pripojenie-select" class="form-control">
                                    <?php
                                    if (is_null($object)) {
                                        $projects = Globals::$database->getProjects();
                                        $subjects = Globals::$database->getSubjects();
                                        foreach ($subjects as $s) {
                                            echo "<option value='$s->id'>$s->name</option>";
                                        }
                                        foreach ($projects as $p) {
                                            echo "<option value='$p->id'>$p->name</option>";
                                        }

                                    } else {
                                        echo "<option value='$object->id'>$object->name</option>";
                                    }
                                    ?>

                                </select>

                            </div>
                        </div>
                        <div id="error-msg">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button id="confirmButton" type="button" class="btn btn-common waves-effect"
                            onclick="addTask(<?php echo Globals::$person->id ?>)">Add task
                    </button>
                    <button type="button" class="btn btn-secondary waves-effect"
                            data-dismiss="modal">Close
                    </button>
                    <div id="addTaskMsg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function deleteTaskModal()
{
    ?>
    <div id="deleteTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalDeleteTask"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="myModalDeleteTask">Delete task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    Do you really want to delete task?
                </div>
                <div class="modal-footer">
                    <button id="confirmDeleteTaskButton" type="button"
                            class="btn btn-primary waves-effect confirmButton"
                            data-dismiss="modal">Delete
                    </button>
                    <button type="button" class="btn btn-secondary waves-effect"
                            data-dismiss="modal">Close
                    </button>
                    <div id="deleteModalTaskMsg">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function archiveTaskModal()
{
    ?>
    <div id="archiveTaskModal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="myModalArchiveTask"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="myModalArchiveTask">Archive task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    Do you really want to archive task?
                </div>
                <div class="modal-footer">
                    <button id="confirmArchiveTaskButton" type="button"
                            class="btn btn-primary waves-effect confirmButton"
                            data-dismiss="modal">Archive
                    </button>
                    <button type="button" class="btn btn-secondary waves-effect"
                            data-dismiss="modal">Close
                    </button>
                    <div id="archiveTasks">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}

function showTasks()
{
    ?>
    <div id="tasks-div" class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-6">
                <div class="card bg-dark">
                    <div class="card-header">
                        <h4 class="card-title text-white">Tasks done</h4>
                        <div class="card-toolbar">
                            <ul>
                                <li>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                                           data-toggle="dropdown" aria-expanded="false"><i
                                                    class="lni-more-alt"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" onclick="showIcons('done', 'archives')"><i
                                                        class="lni-archive mr-2 text-gray"></i>Archive tasks</a>
                                            <a class="dropdown-item" onclick="showIcons('done', 'deletes')"><i
                                                        class="lni-trash mr-2 text-gray"></i>Delete tasks</a>

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul id="tasks-done" class="list-task list-group">
                            <?php
                            $tasks = Globals::$person->getTasks_Done(1);
                            $number = 1;
                            foreach ($tasks as $task) {
                                if ($number === 11) {
                                    echo "<div class='collapse' id='more-done-tasks'>";
                                }
                                showDoneTask($task, 'no');
                                if ($number >= count($tasks) && $number >= 11) {
                                    echo "</div>";
                                }
                                $number++;
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="p-2">
                            <?php
                            if ($number > 10) {
                                ?>
                                <button class="btn btn-common" type="button" data-toggle="collapse"
                                        data-target="#more-done-tasks" aria-expanded="false"
                                        aria-controls="more-done-tasks">
                                    <i class="mdi mdi-arrow-down-bold-circle mdi-18px"></i>
                                    Show all tasks
                                </button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-6 col-xs-6">
                <div class="card bg-dark">
                    <div class="card-header">
                        <h4 class="card-title text-white">Tasks to be done</h4>
                        <div class="card-toolbar">
                            <ul>
                                <li>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                                           data-toggle="dropdown" aria-expanded="false"><i
                                                    class="lni-more-alt"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" onclick="showIcons('undone', 'edits')"><i
                                                        class="lni-pencil mr-2 text-gray"></i>Edit</a>
                                            <a class="dropdown-item" onclick="showIcons('undone', 'timers')"><i
                                                        class="lni-timer mr-2 text-gray"></i>Task to do</a>
                                            <a class="dropdown-item" onclick="showIcons('undone', 'archives')"><i
                                                        class="lni-archive mr-2 text-gray"></i>Archive</a>
                                            <a class="dropdown-item" onclick="showIcons('undone', 'deletes')"><i
                                                        class="lni-trash mr-2 text-gray"></i>Delete</a>

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul id="tasks-to-do" class="list-task list-group">
                            <?php
                            $tasks = Globals::$person->getTasks_Done(0);
                            $number = 1;
                            foreach ($tasks as $task) {
                                if ($number === 11) {
                                    echo "<div class='collapse' id='more-tasks'>";
                                }
                                showUndoneTask($task, 'no');
                                if ($number >= count($tasks) && $number >= 11)
                                    echo "</div>";
                                $number++;
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="p-2">
                            <?php
                            if ($number > 10) {
                                ?>
                                <button class="btn btn-common" type="button" data-toggle="collapse"
                                        data-target="#more-tasks" aria-expanded="false"
                                        aria-controls="more-tasks">
                                    <i class="mdi mdi-arrow-down-bold-circle mdi-18px"></i>
                                    Show all tasks
                                </button>
                                <?php
                            }
                            ?>
                            <button class="btn btn-success" data-toggle="modal" data-target="#addTaskModal">
                                <i class="mdi mdi-plus mdi-18px"></i>Add task
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function showEditProblemModal($problem)
{
    ?>
    <div class="modal-header">
        <h5 class="modal-title" id="myModalEditProblem">Edit problem - <?php echo $problem->description ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="form-group row">
                    <label for="name-problem-input" class="control-label">Name</label>

                    <input id="name-problem-input" type="text" class="form-control" name="name"
                           placeholder="Name" value="<?php echo $problem->description ?>">

                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="form-group row">
                    <label for="note-problem-textarea" class="control-label">Name</label>

                    <textarea id="note-problem-textarea" type="text" class="form-control" name="note-problem"
                              placeholder="<?php echo $problem->note ?>"><?php echo $problem->note ?></textarea>

                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer bg-dark">
        <button type="button" class="btn btn-common waves-effect"
                onclick="editProblem(<?php echo $problem->id ?>)" data-dismiss="modal">Edit
        </button>
        <button type="button" class="btn btn-secondary waves-effect"
                data-dismiss="modal">Close
        </button>

    </div>
    <?php
}

function showProblemInTable(Problem $p, bool $tr)
{
    $id = $p->id;
    $number = $p->getNumberOfRowInTask_Order('solved', 'ASC');
    if ($tr)
        echo "<tr id='problems-task-tr-$id'>";

    ?>
    <td><?php echo $number++ ?></td>
    <td><a type="text"
           class="badge badge-outline-warning" data-toggle="tooltip" data-html="true" title=""
           data-original-title="<em><?php echo $p->note ?></em>">
            <?php echo $p->description ?></a></td>
    <td id="problem-task-td-<?php echo $p->id ?>"><?php if ($p->solved) {
            echo "<span><i class='lni lni-check-mark-circle'></i></span>";
        } else {
            echo "<span><i class='lni lni-close'></i></span>";

        }

        ?>
    </td>
    <td>
        <div class="btn-group dropdown">
            <a href="javascript: void(0);"
               class="dropdown-toggle arrow-none"
               data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
            <div id="problem-task-action-div-<?php echo $p->id ?>" class="dropdown-menu dropdown-menu-right">
                <?php
                if (!$p->solved) {
                    ?>
                    <a class="dropdown-item"
                       onclick="solveProblem(<?php echo $p->id ?>)"><i
                                class="lni-check-mark-circle mr-2 text-gray"></i>Solve</a>
                    <?php
                } else {
                    ?>
                    <a class="dropdown-item"
                       onclick="unsolveProblem(<?php echo $p->id ?>)"><i
                                class="lni-check-mark-circle mr-2 text-gray"></i>Unsolved problem</a>
                    <?php
                }
                ?>

                <a class="dropdown-item "
                   onclick="showEditModalProblem(<?php echo $p->id ?>)" data-toggle="modal"
                   data-target="#editProblemModal"><i
                            class="lni-pencil-alt mr-2 text-gray"></i>Edit</a>
                <a class="dropdown-item"
                   onclick="deleteProblem(<?php echo $p->id ?>)"><i
                            class="lni-trash mr-2 text-gray"></i>Delete</a>

            </div>
        </div>
    </td>
    <?php
    if ($tr) echo "</tr>";
}

