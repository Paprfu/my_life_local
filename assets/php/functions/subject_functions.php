<?php


function showAddModal($id_subject, $type) {
    $title = "";
    switch($type) {
        case 'exercise':
            $title = "cvičenia";

            break;
        case 'lecture':
            $title = "prednášky";
            break;
        case 'test':
            $title = "zápočtu";
            break;
        case 'work':
            $title = "semestrálnej práce";
            break;
        default:
    }
    ?>
    <div id="add-<?php echo $type ?>-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalAdd<?php echo $type ?>"
         style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalAdd<?php echo $type ?>">Pridanie <?php echo $title ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="form-group row">
                                <label for="name-<?php echo $type ?>-input" class="control-label">Názov</label>

                                <input id="name-<?php echo $type ?>-input" type="text" class="form-control" name="name"
                                       placeholder="Názov">

                            </div>
                            <div class="form-group row">
                                <label class="control-label" for="date-<?php echo $type ?>-input">Dátum</label>

                                <input id="date-<?php echo $type ?>-input" type="date" class="form-control"
                                       name="date" value="<?php try {
                                    $date = new DateTime(Globals::$today);
                                } catch (Exception $e) {
                                }
                                echo $date->format('Y-m-d') ?>">
                                <label for="time-<?php echo $type ?>-input"></label>
                                <input id="time-<?php echo $type ?>-input" type="time" class="form-control"
                                       name="time" value="<?php try {
                                    $date = new DateTime(Globals::$today);
                                } catch (Exception $e) {
                                }
                                echo $date->format('h:i') ?>">
                            </div>
                            <div class="form-group row">
                                <label class="control-label" for="points-<?php echo $type ?>-input">Body</label>
                                <input type="number" class="form-control" id="points-<?php echo $type ?>-input">
                            </div>
                            <div class="form-group row">
                                <label class="control-label" for="text-<?php echo $type ?>-input">Popis</label>
                                <textarea class="form-control" id="text-<?php echo $type ?>-input"></textarea>
                            </div>


                        </div>
                        <div id="error-msg">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-dark">
                    <button id="confirm-<?php echo $type ?>-button" type="button" class="btn btn-common waves-effect"
                            onclick="createSchoolEvent_Type(<?php echo $id_subject ?>, <?php echo "'$type'" ?>)">Pridať
                    </button>
                    <button type="button" class="btn btn-secondary waves-effect"
                            data-dismiss="modal">Zavrieť
                    </button>
                    <div id="addSchoolEventMsg">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}

function writeSubjectEventsTable($type, $subject)
{
    $title = "";
    switch ($type) {
        case 'exercise':
            $title = "Cvičenia";
            break;
        case 'lecture':
            $title = "Prednášky";
            break;
        case 'exam':
            $title = "Skúšky";
            break;
        case 'work':
            $title = "Semestrálne práce";
            break;
        case 'test':
            $title = "Zápočty";
            break;
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card bg-dark">
                    <div class="card-header border-bottom" data-toggle="collapse"
                         href="#collapse<?php echo $type ?>" role="button" aria-expanded="false"
                         aria-controls="collapse<?php echo $type ?>">
                        <h4 class="card-title text-white"><?php echo $title ?></h4>
                    </div>
                    <div id="collapse<?php echo $type ?>" class="card-body collapse">

                        <h4 class="mt-0 box-title"></h4>
                        <div class="table-responsive">
                            <table class="table table-sm text-center">
                                <caption><?php echo $title ?> z predmetu <?php echo $subject->name ?></caption>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Názov</th>
                                    <th>Dátum</th>
                                    <th>Čas</th>
                                    <th>Vypracované úlohy</th>

                                    <th>Status</th>
                                    <th>Úprava</th>
                                </tr>
                                </thead>
                                <tbody id="<?php echo $type ?>-tbody">
                                <?php
                                $events = $subject->getSchoolEvents($type);
                                $number = 1;
                                $sum_done_tasks = 0;
                                $sum_tasks = 0;
                                $sum_done_events = 0;
                                foreach ($events as $e) {
                                    ?>
                                    <tr id="exercises-table-tr-<?php echo $e->id ?>">
                                        <td><?php echo $number ?></td>
                                        <td>
                                            <a class="btn-link"
                                               href="schoolEvent.php?subject=<?php echo $subject->id ?>&event=<?php echo $e->id ?>"><?php echo $e->name ?></a>
                                        </td>
                                        <td><?php echo dateToWrite($e->date) ?></td>
                                        <td><?php echo timeToWrite($e->date) ?></td>
                                        <td>
                                            <?php echo count($e->getTasks_Done()) . '/' . count($e->getTasks()) ?>
                                        </td>
                                        <td><?php if (strtotime($e->date) > time()) {
                                                ?>
                                                <a href="#" class="badge badge-info">Pripravuje sa</a>
                                            <?php } else {
                                                $sum_done_events++;
                                                ?>
                                                <a href="#" class="badge badge-danger">Ukončený</a>
                                                <?php
                                            } ?></td>

                                        <td>
                                            <div class="btn-group dropdown">
                                                <a href="javascript: void(0);"
                                                   class="dropdown-toggle arrow-none"
                                                   data-toggle="dropdown" aria-expanded="false"><i
                                                            class="lni-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item"
                                                       onclick="editSchoolEvent(<?php echo $e->id ?>, 'exercise', <?php echo $number ?>)"><i
                                                                class="lni-pencil mr-2 text-gray"></i>Upraviť</a>
                                                    <a class="dropdown-item"
                                                       onclick="deleteSchoolEvent(<?php echo $e->id ?>, 'exercise',  <?php echo $number ?>   )"><i
                                                                class="lni-trash mr-2 text-gray"></i>Odstániť</a>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    $sum_done_tasks += count($e->getTasks_Done());
                                    $sum_tasks += count($e->getTasks());
                                    $number++;
                                }
                                ?>
                                <tr>
                                    <td colspan="4" class="border-0"></td>


                                    <td><?php echo $sum_done_tasks . '/' . $sum_tasks ?></td>
                                    <td><?php echo 'Ukončené ' . $sum_done_events . '/' . count($events) ?></td>

                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success" data-toggle="modal" data-target="#add-<?php echo $type ?>-modal"><i
                                    class="mdi mdi-plus mdi-18px"></i>Pridať
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Content Wrapper END -->
    <?php
}
