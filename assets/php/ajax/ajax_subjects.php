<?php
include_once('../server.php');
include_once('../functions.php');
$database = Globals::$database;
$person = Globals::$person;
if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'createSubject':
            $id_person = $person->id;
            $name = $_POST['name'];
            $start = $_POST['from'];
            $end = $_POST['to'];
            $max_points = $_POST['max_points'] !== '' ? $_POST['max_points']: 'NULL';
            $max_exam_points = $_POST['max_exam_points'] !== '' ? $_POST['max_exam_points']: 'NULL';
            $sql = "INSERT INTO subject (name, `from`, `to`, `points`, `exam_points`) VALUES ('" . $name . "', '" . $start . "', '" . $end . "', " . $max_points . ", " . $max_exam_points . ")";
            $database->getResult($sql);
            $id = mysqli_fetch_assoc($database->getResult("SELECT MAX(id_subject) as id FROM subject"))['id'];
            $sql = "INSERT INTO subject_person (id_person, id_subject, mark, points, exam_points) 
                    VALUES ('$id_person', (SELECT MAX(id_subject) FROM subject), 0, 0, 0)";
            $database->getResult($sql);

            $s = $database->getSubject_ID($id);
            $number = count($person->getSubjects());
            ?>
            <tr id="subjects-tr-<?php echo $id ?>">
                <td><?php echo $number ?></td>
                <td><?php echo $s->name ?></td>
                <td><?php
                    $state = $s->getState();
                    if($state == 0)
                        echo "<a href='#' class='badge badge-info'>Pripravovaný</a>";
                    else if($state == 1)
                        echo "<a href='#' class='badge badge-success'>Prebiehajúci</a>";
                    else
                        echo "<a href='#' class='badge badge-danger'>Ukončený</a>";

                    ?></td>
                <td>
                    <?php

                    if($s->points == null)
                        echo "Nepriradené";
                    else
                        echo $person->getPoints_Subject($s->id) . '/' . $s->points  ?>
                </td>

                <td>
                    <?php

                    if($s->exam_points == null)
                        echo "Nepriradené";
                    else
                        echo $person->getExamPoints_Subject($s->id) . '/' . $s->exam_points  ?></td>
                <td><?php
                    $mark = $person->getMarkForSubject($s->id);
                    if($mark == null)
                        echo "Známka nepriradená";
                    else
                        echo $mark;
                    ?></td>
                <td>
                    <div class="btn-group dropdown">
                        <a href="javascript: void(0);"
                           class="dropdown-toggle arrow-none"
                           data-toggle="dropdown" aria-expanded="false"><i
                                    class="lni-more-alt"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" onclick="editSubjectModal(<?php echo $s->id ?>)" data-toggle="modal" data-target="#editSubjectModal"><i
                                        class="lni-pencil mr-2 text-gray">Upraviť predmet</i></a>
                            <a class="dropdown-item"
                               onclick="deleteSubject(<?php echo $s->id ?>)"><i
                                        class="lni-trash mr-2 text-gray"></i>Odstrániť
                                predmet</a>

                        </div>
                    </div>
                </td>
            </tr>


            <?php


            break;

        case 'saveSubject':
            $id = $_POST['id'];
            $subject = $database->getSubject_ID($id);
            $name = $_POST['name'];
            $sql = "UPDATE subject SET name='$name' WHERE id_subject='$id'";
            $database->getResult($sql);
            ?>
            <td><?php echo $id; ?></td>
            <td><a class="btn-link" href="subject.php?subject=<?php echo $id ?>"><?php echo $name ?></a></td>

            <td>
                <div class="btn-group dropdown">
                    <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                       data-toggle="dropdown" aria-expanded="false"><i
                                class="lni-more-alt"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" onclick="editSubject(<?php echo $subject->id ?>)"><i
                                    class="lni-pencil mr-2 text-gray"></i>Upraviť</a>
                        <a class="dropdown-item" onclick="deleteSubject(<?php echo $subject->id ?>)"><i
                                    class="lni-trash mr-2 text-gray"></i>Odstániť</a>

                    </div>
                </div>
            </td>
            <?php
            break;
        case 'editSubject':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $from = $_POST['from'];
            $to = $_POST['to'];
            $points = $_POST['points'] != '' ? $_POST['points'] : 'NULL';
            $exam_points = $_POST['exam_points'] != '' ? $_POST['exam_points'] : 'NULL';
            $max_points = $_POST['max_points'] != '' ? $_POST['max_points'] : 'NULL';
            $max_exam_points = $_POST['max_exam_points'] != '' ? $_POST['max_exam_points'] : 'NULL';
            $mark = $_POST['mark'];

            $sql = "UPDATE subject SET 
                   subject.name='$name',
                   subject.from='$from',
                   subject.to='$to',
                   subject.points=$max_points, 
                   subject.exam_points=$max_exam_points 
                    where subject.id_subject='$id'";
            $result = $database->getResult($sql);

            $sql = "UPDATE subject_person SET mark='$mark', 
                          points=$points, 
                          exam_points=$exam_points where id_subject='$id' and id_person='$person->id'";

            $result = $database->getResult($sql);

            $s = $database->getSubject_ID($id);
            $sql = "SELECT ROW_NUMBER() over (ORDER BY id_subject ASC) as number FROM subject_person 
                    where id_person='$person->id'";
            $result = $database->getResult($sql);
            while($row = mysqli_fetch_assoc($result)) {
                $number = $row['number'];
            }
            ?>
            <td><?php echo $number ?></td>
            <td><?php echo $s->name ?></td>
            <td><?php
                $state = $s->getState();
                if($state == 0)
                    echo "<a href='#' class='badge badge-info'>Pripravovaný</a>";
                else if($state == 1)
                    echo "<a href='#' class='badge badge-success'>Prebiehajúci</a>";
                else
                    echo "<a href='#' class='badge badge-danger'>Ukončený</a>";

                ?></td>
            <td>
                <?php

                if($s->points == null)
                    echo "Nepriradené";
                else
                    echo $person->getPoints_Subject($s->id) . '/' . $s->points  ?>
            </td>

            <td>
                <?php

                if($s->exam_points == null)
                    echo "Nepriradené";
                else
                    echo $person->getExamPoints_Subject($s->id) . '/' . $s->exam_points  ?></td>
            <td><?php
                $mark = $person->getMarkForSubject($s->id);
                if($mark == null)
                    echo "Známka nepriradená";
                else
                    echo $mark;
                ?></td>
            <td>
                <div class="btn-group dropdown">
                    <a href="javascript: void(0);"
                       class="dropdown-toggle arrow-none"
                       data-toggle="dropdown" aria-expanded="false"><i
                                class="lni-more-alt"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" onclick="editSubjectModal(<?php echo $s->id ?>)"
                           data-toggle="modal" data-target="#editSubjectModal">
                            <i class="lni-pencil mr-2 text-gray">Upraviť predmet</i></a>
                        <a class="dropdown-item"
                           onclick="deleteSubject(<?php echo $s->id ?>)"><i
                                    class="lni-trash mr-2 text-gray"></i>Odstániť
                            predmet
                        </a>
                    </div>
                </div>
            </td>
            <?php
            break;
        case 'deleteSubject':
            $id = $_POST['id'];
            $sql = "Delete from subject where id_subject='$id'";
            $database->getResult($sql);
            $sql = "Delete from subject_person where id_subject='$id'";
            $database->getResult($sql);
            break;
        case 'createSchoolEvent';
            $name = $_POST['name'];
            $type = $_POST['type'];
            $text = $_POST['text'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $date = $publishDate = DateTime::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time . ':00');

            $id = $_POST['id'];
            $points = $_POST['points'];
            switch ($type) {
                case 'activity':
                case 'test':
                case 'work':
                    $sql = "INSERT INTO school_event (id_subject, name, date, type, text, max_points) 
                            VALUES ('$id','$name','$date','$type','$text','$points')";

                    break;
                default:
                    $sql = "INSERT INTO school_event (id_subject, name, date, type, text) 
                            VALUES ('$id','$name','$date','$type','$text')";

            }

            $result = $database->getResult($sql);
            $subject = $database->getSubject_ID($id);
            $exercises = $subject->getSchoolEvents($type);
            $number = 1;
            foreach ($exercises

                     as $e) {
                ?>
                <tr>
                    <th scope="row"><?php echo $number ?></th>
                    <td><?php echo $e->name ?></td>
                    <td><?php echo dateToWrite($e->date) ?></td>
                    <td><?php echo timeToWrite($e->date) ?></td>
                    <td><?php if ($e->date > $today) {
                            ?>
                            <a href="#" class="badge badge-info">Pripravuje sa</a>
                        <?php }
                        else
                            {
                            ?>
                            <a href="#" class="badge badge-danger">Ukončený</a>
                            <?php
                        } ?></td>
                </tr>
                <?php
                $number++;
            }
            break;
        case 'editSchoolEvent':
            $number = $_POST['number'];
            $id = $_POST['id'];
            $e = $database->getSchoolEvent_ID($id);
            $type = $_POST['type'];
            ?>
            <td scope="row"><?php echo $number; ?></td>
            <td><input type='text' class="form-control" id='edit-name-input' name="edit-name"
                       value="<?php echo $e->name ?>"></td>

            <td colspan="2"><input id="edit-date-input" type="datetime-local"
                                   value="<?php echo date('Y-m-d\TH:i:s', strtotime($e->date)); ?>"></td>
            <td><?php if ($e->date >= $today) {
                    ?>
                    <a href="#" class="badge badge-info">Pripravuje sa</a>
                <?php } else {
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
                           onclick="saveSchoolEvent(<?php echo $e->id; ?>, '<?php echo $type ?>', <?php echo $number ?>)"><i
                                    class="lni-save mr-2 text-gray"></i>Uložiť</a>
                    </div>
                </div>
            </td>
            <?php
            break;
        case 'saveSchoolEvent':
            $number = $_POST['number'];
            $id = $_POST['id'];
            $type = $_POST['type'];
            $name = $_POST['name'];
            $date = $_POST['date'];
            $sql = "UPDATE school_event SET name='$name', date='$date' WHERE id='$id'";
            $result = $database->getResult($sql);
            $e = $database->getSchoolEvent_ID($id);
            ?>
            <td><?php echo $number ?></td>
            <td><?php echo $e->name ?></td>
            <td><?php echo dateToWrite($e->date) ?></td>
            <td><?php echo timeToWrite($e->date) ?></td>
            <td><?php if ($e->date > Globals::$today) {
                    ?>
                    <a href="#" class="badge badge-info">Pripravuje sa</a>
                <?php } else {
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
                           onclick="editSchoolEvent(<?php echo $e->id ?>, '<?php echo $type ?>', <?php echo $number ?>)"><i
                                    class="lni-pencil mr-2 text-gray"></i>Upraviť</a>
                        <a class="dropdown-item"
                           onclick="deleteSchoolEvent(<?php echo $e->id ?>, '<?php echo $type ?>',  <?php echo $number ?>   )"><i
                                    class="lni-trash mr-2 text-gray"></i>Odstániť</a>

                    </div>
                </div>
            </td>a
            <?php
            break;

        case 'deleteSchoolEvent':
            $id = $_POST['id'];
            $sql = "DELETE FROM school_event WHERE id='$id'";
            $database->getResult($sql);

            break;
        case 'editSubjectModal':
            $id = $_POST['id'];
            $s = $database->getSubject_ID($id);
            ?>
            <div class="modal-header">
                <h5 class="modal-title" id="editSubjectModal">Upravenie predmetu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-white">
                <div class="form-group row">
                    <label class="control-label" for="name-input">Názov</label>

                    <input id="subject-name-input" type="text" class="form-control" name="name"
                           placeholder="Názov" value="<?php echo $s->name ?>">

                </div>
                <div class="form-group row">
                    <label class="control-label" for="from-input">Začiatok</label>

                    <input id="from-input" type="date" class="form-control"
                           name="from" value="<?php try {
                        $date = new DateTime($s->from);
                    } catch (Exception $e) {
                    }
                    echo $date->format('Y-m-d') ?>">
                </div>

                <div class="form-group row">
                    <label class="control-label" for="to-input">Koniec</label>

                    <input id="to-input" type="date" class="form-control"
                           name="to" value="<?php try {
                        $date = new DateTime($s->to);
                    } catch (Exception $e) {
                    }
                    echo $date->format('Y-m-d') ?>">
                </div>
                <div class="form-group row">


                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <?php
                            $points = $person->getPoints_Subject($s->id);
                            ?>
                            <label class="control-label">Body semester /</label>
                            <input class="form-control" id="points-input" type="number" name="points"
                                   value="<?php echo $points ?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label class="control-label">Maximálne body</label>
                            <input class="form-control" id="max-points-input" type="number" name="max-points"
                                   value="<?php echo $s->points ?>">
                        </div>


                </div>
                <div class="form-group row">


                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <?php
                            $points = $person->getPoints_Subject($s->id);
                            ?>
                            <label class="control-label">Body skúška /</label>
                            <input class="form-control" id="exam-points-input" type="number" name="points"
                                   value="<?php echo $points ?>">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <label class="control-label">Maximálne body</label>
                            <input class="form-control" id="max-exam-points-input" type="number" name="max-points"
                                   value="<?php echo $s->points ?>">
                        </div>


                </div>
                <div class="form-group row">


                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <?php
                        $points = $person->getPoints_Subject($s->id);
                        ?>
                        <label class="control-label">Známka</label>
                        <input class="form-control" id="mark-input" type="number" name="mark"
                               value="<?php echo $points ?>">
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button onclick="editSubject(<?php echo $s->id ?>)" type="button" class="btn btn-common waves-effect" data-dismiss="modal">
                    Upraviť
                </button>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Zavrieť</button>

            </div>
            <?php
            break;
        default:
            throw new \Exception('Unexpected value');
    }
}
