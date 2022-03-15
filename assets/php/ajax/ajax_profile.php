<?php
include_once('../server.php');

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'addPhoto':
            $id = $_POST['id'];
            foreach ($_FILES['file']['name'] as $key => $val) {
                $file_name = $_FILES['file']['name'][$key];

                // get file extension
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // get filename without extension
                $filenamewithoutextension = pathinfo($file_name, PATHINFO_FILENAME);

                if (!file_exists(getcwd() . '/uploads/' . $id)) {
                    mkdir(getcwd() . '/uploads/' . $id, 0777);
                }

                $filename_to_store = $filenamewithoutextension . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['file']['tmp_name'][$key], getcwd() . '/uploads/' . $id . '/' . $filename_to_store);
                $sql = "UPDATE profile_info SET photo='$filename_to_store' where id_person='$id'";
                $result = Globals::$database->getResult($sql);
            }
            echo "<img src='assets/php/ajax/uploads/$id/$filename_to_store' alt=''>";
            break;
        case 'addTitlePhoto':
            $id = $_POST['id'];
            foreach ($_FILES['file']['name'] as $key => $val) {
                $file_name = $_FILES['file']['name'][$key];

                // get file extension
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // get filename without extension
                $filenamewithoutextension = pathinfo($file_name, PATHINFO_FILENAME);

                if (!file_exists(getcwd() . '/uploads/' . $id)) {
                    mkdir(getcwd() . '/uploads/' . $id, 0777);
                }

                $filename_to_store = $filenamewithoutextension . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['file']['tmp_name'][$key], getcwd() . '/uploads/' . $id . '/' . $filename_to_store);
                $sql = "UPDATE profile_info SET title_photo='$filename_to_store' where id_person='$id'";
                $result = Globals::$database->getResult($sql);
            }
            echo "<img src='assets/php/ajax/uploads/$id/$filename_to_store' alt=''>";
            break;
        case 'edit':
            $id = $_POST['id'];
            $person = Globals::$database->getPerson_ID($id);
            ?>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <input id="name-input" class="form-control" name="name" value="<?php
                    $substr = substr(Globals::$person->name, 0, (strpos(Globals::$person->name, ' ')));
                    echo $substr ?>">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <input id="second-name-input" name="second-name" class="form-control" value="<?php
                    $substr = substr(Globals::$person->name, (strpos(Globals::$person->name, ' ')));
                    echo $substr ?>">
                </div>
            </div>
            <div id="profile-description-div" class="profile-user-description">
                <textarea id="description-textarea" class="form-control"
                          name="description"><?php echo Globals::$person->pi->description ?></textarea>
            </div>
            <?php if (Globals::$person->id == Globals::$user->id) { ?>
            <div id="edit-button-profile-div" class="m-t-5">
                <button onclick="saveProfile(<?php echo Globals::$person->id ?>)"
                        class="btn btn-common">Uložiť
                </button>
            </div>
        <?php }
            break;
        case 'save':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $second_name = $_POST['second_name'];
            $description = $_POST['description'];
            $sql = "UPDATE person SET name='$name', second_name='$second_name' WHERE id_person='$id'";
            Globals::$database->getResult($sql);
            $sql = "UPDATE profile_info SET description='$description' WHERE id_person='$id'";
            Globals::$database->getResult($sql);
            $person = Globals::$database->getPerson_ID($id);
            ?>
            <h3 class="profile-user-name text-white"><?php echo Globals::$person->name; ?></h3>
            <div id="profile-description-div" class="profile-user-description">
                <p class="text-white"><?php echo Globals::$person->pi->description ?></p>
            </div>
            <?php
            if ($person->id == Globals::$user->id) { ?>
                <div id="edit-button-profile-div" class="m-t-5">
                    <button onclick="editProfile(<?php echo Globals::$person->id ?>)"
                            class="btn btn-common">Upraviť
                    </button>
                </div>
                <?php
            }
            break;
        case 'createTimeline':
            $text = $_POST['text'];
            $id_person = Globals::$person->id;
            $sql = "INSERT INTO timeline (id_person, text, date) VALUES ('$id_person','$text',CURRENT_TIMESTAMP)";
            $result = Globals::$database->getResult($sql);
            ?>
            <li class="timeline-inverted">
                <div class="timeline-circle rounded-circle text-primary text-center">
                    <i
                            class="lni-pencil"></i></div>
                <div class="timeline-entry">
                    <div class="card">
                        <div class="card-body timeline-entry-content">
                            <p class="mb-0"><?php echo $text ?></p>
                            <p class="mb-0">
                                                                    <span>
                                                                        <?php echo dateToWrite(Globals::$today) ?>
                                                                    </span>
                            </p>
                        </div>
                    </div>
                </div>
            </li>
            <?php
            break;
        case "selectPhotosOnTimeline":
            $id = Globals::$person->id;
            foreach ($_FILES['file']['name'] as $key => $val) {
                $file_name = $_FILES['file']['name'][$key];

                // get file extension
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // get filename without extension
                $filenamewithoutextension = pathinfo($file_name, PATHINFO_FILENAME);


                if (!is_dir(getcwd() . '/timeline_photos/' . $id)) {
                    mkdir(getcwd() .'/timeline_photos/' . $id, 0700);
                        echo "directory created";
                } else {
                    echo "directory has not been created";
                }
                $filename_to_store = $filenamewithoutextension . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['file']['tmp_name'][$key], getcwd() . '/timeline_photos/' . $id . '/' . $filename_to_store);
                echo "<img class='figure-img' src='assets/php/ajax/timeline_photos/$id/$filename_to_store'>";
            }
            break;
    }


}