<?php
include_once('../server.php');
$database = Globals::$database;
if (isset($_POST['method'])) switch ($_POST['method']) {
    case 'addFile':
        $files = $_POST['files'];
        $uploads_dir = '/uploads';
        foreach ($files["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $files["tmp_name"][$key];
                // basename() may prevent filesystem traversal attacks;
                // further validation/sanitation of the filename may be appropriate
                $name = basename($files["name"][$key]);
                move_uploaded_file($tmp_name, "$uploads_dir/$name");
            }
        }
        break;
    case 'createSET':
        $id = $_POST['id'];
        $assigment = $_POST['assigment'];

        $sql = "INSERT INTO school_event_tasks(id_school_event, assigment, solution) values 
            ('$id','$assigment', NULL)";
        $database->getResult($sql);
        $number = mysqli_fetch_assoc($database->getResult("SELECT count(*) as number from school_event_tasks where id_school_event='$id'"))['number'];
        $id_set = mysqli_fetch_assoc($database->getResult("SELECT max(id_set) as id from school_event_tasks where id_school_event='$id'"))['id'];
        $set = $database->getSET_ID($id_set);
        ?>

        <div id="card-<?php echo $set->id ?>" class="card">
            <div class="card-header" role="tab" id="heading<?php echo $number ?>">
                <div class="float-left">
                    <h5>
                        <a class="link collapsed" data-toggle="collapse"
                           data-parent="#accordion<?php echo $number ?>"
                           href="#collapse<?php echo $number ?>" aria-expanded="false"
                           aria-controls="collapse<?php echo $number ?>">

                            <?php
                            echo "$number#. $set->assigment";
                            ?>
                        </a>
                    </h5>
                </div>
                <div class="icon-demo-content float-right"
                     onclick="file_explorer_table('school_event_task', <?php echo $set->id ?>)">
                    <i class="mdi mdi-upload-forever mdi-18px"></i>
                </div>
                <div class="icon-demo-content float-right"
                     onclick="deleteSET(<?php echo $set->id ?>)">
                    <i class="mdi mdi-delete-forever mdi-18px"></i>
                </div>
            </div>
            <div id="collapse<?php echo $number ?>" class="collapse" role="tabpanel"
                 aria-labelledby="heading<?php echo $number ?>" style="">
                <div class="card-body">
                    <div class="form-group">
                                                <textarea id="solution-textarea-<?php echo $set->id ?>"
                                                          class="form-control"
                                                          rows="50"><?php echo $set->solution ?></textarea>
                    </div>
                    <button class="btn btn-common"
                            onclick="saveSETSolution(<?php echo $set->id ?>)">Uložiť riešenie
                    </button>
                    <div id="set-msg-<?php echo $set->id ?>" class="form-group">
                    </div>
                </div>
                <div class="card-footer">
                    <?php
                    $files = $set->getFiles();

                    foreach ($files as $f) {
                        ?>

                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <a href="<?php echo $f['path'] ?>" target="_blank">

                                <?php
                                if ($f['ext'] == 'pdf') {
                                    ?>
                                    <i class="mdi mdi-file-pdf mdi-24px"></i> <?php echo $f['name'] ?>
                                    <?php
                                } else if ($f['ext'] == 'ppt') {
                                    ?>
                                    <i class="mdi mdi-file-powerpoint mdi-24px"></i> <?php echo $f['name'] ?>
                                    <?php

                                } else {
                                    ?>
                                    <i class="mdi mdi-file mdi-24px"></i> <?php echo $f['name'] ?>
                                    <?php
                                }
                                ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
        break;
    case
    'deleteSET':
        $id = $_POST['id'];
        $sql = "DELETE FROM school_event_tasks WHERE id_set='$id'";
        $database->getResult($sql);
        break;
    case
    'saveSETSolution':
        $id = $_POST['id'];
        $solution = $_POST['solution'];
        $new_value = str_replace("'", "''", "$solution");
        $sql = "UPDATE school_event_tasks SET solution='$new_value' WHERE id_set='$id'";

        $database->getResult($sql);
        break;
    case 'doneSET':
        $id = $_POST['id'];
        $done = mysqli_fetch_assoc($database->getResult("SELECT done FROM school_event_tasks WHERE id_set='$id'"))['done'];
        if ($done == 0) {
            $sql = "UPDATE school_event_tasks SET done = 1 WHERE id_set = '$id'";
            echo 1;
        } else {
            $sql = "UPDATE school_event_tasks SET done = 0 WHERE id_set = '$id'";
            echo 0;
        }
        $database->getResult($sql);
        break;
    case 'checkSET':
        $id = $_POST['id'];
        $check = mysqli_fetch_assoc($database->getResult("SELECT done FROM school_event_tasks WHERE id_set='$id'"))['check'];

        if ($check == 0) {
            $sql = "UPDATE school_event_tasks SET check = 1 WHERE id_set = '$id'";
            echo 1;
        } else {
            $sql = "UPDATE school_event_tasks SET check = 0 WHERE id_set = '$id'";
            echo 0;
        }
        $database->getResult($sql);
        break;
    default:

}
