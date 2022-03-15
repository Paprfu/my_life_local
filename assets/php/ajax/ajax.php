<?php
include_once('../server.php');

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'addQA':
            $subject = $_POST['subject'];
            $question = $_POST['question'];
            $answer = $_POST['answer'];
            $cat = $_POST['category'];
            $answer = nl2br($answer);
            $sql = "INSERT INTO qa (question, answer, id_category, id_subject) values ('$question','$answer','$cat','$subject')";
            $result = Globals::$database->getResult($sql);

            ?>

            <div id="accordion">
                <?php
                $subject = Globals::$database->getSubject_ID($_POST['subject']);
                $qas = $subject->getQAs();
                foreach ($qas as $qa) {
                    ?>
                    <div class="card">
                        <div class="card-header" id="heading<?php echo $qa->id ?>">
                            <h5 class="m-0">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $qa->id ?>"
                                   aria-expanded="false" aria-controls="collapse<?php echo $qa->id ?>"
                                   class="text-white collapsed">
                                    <?php echo $qa->q ?>
                                </a>
                            </h5>
                        </div>
                        <div id="collapse<?php echo $qa->id ?>" class="collapse"
                             aria-labelledby="heading<?php echo $qa->id ?>"
                             data-parent="#accordion" style="">
                            <div class="card-body">
                                <?php echo $qa->a ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
            break;
        case 'addCategory':
            $category = $_POST['category'];
            $subject = $_POST['subject'];
            $sql = "INSERT INTO category (name, id_subject) values ('$category','$subject')";
            $result = Globals::$database->getResult($sql);
            $subject = Globals::$database->getSubject_ID($subject);
            ?>
            <?php
            $catg = $subject->getCategories();
            foreach ($catg as $cat) {
                echo "<option value='$cat->id'>$cat->name</option>";
            }
            ?>
            <?php
            break;
        case 'addEventToCalendar':
            $name = $_POST['name'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            $sql = "INSERT INTO calendar_events (name, start, end) VALUES ('$name', '$start','$end')";
            Globals::$database->getResult($sql);
            break;
        case 'addFile':
            $id = $_POST['id'];
            $table = $_POST['table'];
            foreach ($_FILES['file']['name'] as $key => $val) {

                $file_name = $_FILES['file']['name'][$key];

                // get file extension
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // get filename without extension
                $filenamewithoutextension = pathinfo($file_name, PATHINFO_FILENAME);
                $filename_to_store = $filenamewithoutextension . '_' . uniqid() . '.' . $ext;
                $sql = "SELECT max(id) as id from files";
                $result = Globals::$database->getResult($sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $id_event = $row['id'] + 1;
                }
                $path = 'assets/php/ajax/files/' . $id_event . '/' . $filename_to_store;

                $sql = "INSERT INTO files (id, name, path, id_connect, table_name,ext) VALUES ('$id_event', '$file_name','$path','$id', '$table', '$ext')";
                Globals::$database->getResult($sql);
                if (!file_exists(getcwd() . '/files/' . $id_event)) {
                    mkdir(getcwd() . '/files/' . $id_event, 0777);
                }


                move_uploaded_file($_FILES['file']['tmp_name'][$key], getcwd() . '/files/' . $id_event . '/' . $filename_to_store);
                ?>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <a href="<?php echo $path ?>" target="_blank">

                        <?php
                        if ($ext == 'pdf') {
                            ?>
                            <i class="mdi mdi-file-pdf mdi-24px"></i> <?php echo $file_name ?>
                            <?php
                        } else if ($ext == 'ppt') {
                            ?>
                            <i class="mdi mdi-file-powerpoint mdi-24px"></i> <?php echo $file_name ?>
                            <?php

                        } else {
                            ?>
                            <i class="mdi mdi-file mdi-24px"></i> <?php echo $file_name ?>
                            <?php
                        }
                        ?>
                    </a>
                </div>
                <?php

            }

            break;
        case 'createLink':
            $id = $_POST['id'];
            $table = $_POST['table'];
            $name = $_POST['name'];
            $link = $_POST['link'];
            $type = $_POST['type'];
            $sql = "INSERT INTO links (id_connect, table_name, name, link, type) values 
                    ('$id','$table', '$name', '$link', '$type')";
            Globals::$database->getResult($sql);
            $event = null;
            if($table == 'school_event')
                $event = Globals::$database->getSchoolEvent_ID($id);
            if($table == 'activity')
                showActivityLink($name, $link);
            if($event != null) {
                showEventLinks();
            }
            break;
        case 'deleteLink':
            $id = $_POST['id'];
            $sql = "DELETE FROM links WHERE id_link='$id'";

            Globals::$database->getResult($sql);
            $event = null;
            if($table == 'school_event')
                $event = Globals::$database->getSchoolEvent_ID($id);
            if($event != null) {
                showEventLinks();

            }
            break;

    }
}

function showEventLinks($event) {
    $links = $event->getLinks();
    $type = '';
    foreach ($links as $l) {
        if ($type != $l->type) {
            echo "<h5 class='m-t-15 text-white'>$l->type</h5>";
            echo "<div class='list-group text-white'>";

        }

        echo "<a href='$l->link' class='list-group-item list-group-item-action'>
                                                        <i class='mdi mdi-check m-r-10 text-success'></i>$l->name
                                                    </a>";

        if ($type != $l->type) {
            echo "</div>";
            $type = $l->type;
        }
    }
}

function showActivityLink($name, $link) {
    ?>
    <a href="<?php echo $link ?>"
       class="list-group-item list-group-item-action">
        <i class="mdi mdi-link m-r-10 text-success"></i><?php echo $name ?>
    </a>
<?php
}


