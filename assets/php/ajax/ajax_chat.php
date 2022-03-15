<?php
include_once('../server.php');
include_once('../functions.php');


if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'showChat':
            $id = $_POST['id_person'];
            $person2 = $database->getPerson_ID($id);
            $messages = $database->getMessages($person, $person2);
            $sql = "UPDATE message SET showed=1 WHERE showed=0 and ((id_sender='$person->id' AND id_receiver='$person2->id') || (id_sender='$person2->id' AND id_receiver='$person->id'))";
            $database->getResult($sql);
            ?>
            <ul id="chat-messages"  class="chat-list p-3">

            <?php
            foreach ($messages as $m) {

                if ($m->sender->id == $person->id) {
                    ?>
                    <li>
                        <div class="chat-img"><img src="<?php echo $person->pi->photo ?>" alt="user"></div>
                        <div class="chat-content">
                            <h5><?php echo $person->name ?></h5>
                            <div class="box bg-light-info"><?php echo $m->text ?>
                            </div>
                            <div class="chat-time"><?php echo timeToWrite($m->datetime) ?></div>
                        </div>
                    </li>
                    <?php
                } else if ($m->receiver->id == $person->id) {
                    ?>
                    <li class="reverse">

                        <div class="chat-content">
                            <h5><?php echo $person2->name ?></h5>
                            <div class="box bg-light-info"><?php echo $m->text ?>
                            </div>
                            <div class="chat-time"><?php echo timeToWrite($m->datetime) ?></div>
                        </div>
                        <div class="chat-img"><img src="<?php echo $person2->pi->photo ?>" alt="user"></div>
                    </li>
                    <?php
                }
            }
            ?>
            </ul>
            <div class="scrollbar-x-rail">
                <div class="scrollbar-x"></div>
            </div>
            <div class="scrollbar-y-rail">
                <div class="scrollbar-y"></div>
            </div>
            <?php
            break;
        case 'sendMessage':
            $id = $_POST['id_person'];
            $person2 = $database->getPerson_ID($id);
            $id2 = $person->id;
            $message = $_POST['message'];
            $sql = "INSERT INTO message (id_sender, id_receiver, text, datetime, showed)
                    values ('$id2', '$id', '$message', '$today', 0)";
            $database->getResult($sql);
            ?>
            <li>
                <div class="chat-img"><img src="<?php echo $person->pi->photo ?>" alt="user"></div>
                <div class="chat-content">
                    <h5><?php echo $person->name ?></h5>
                    <div class="box bg-light-info"><?php echo $message ?>
                    </div>
                    <div class="chat-time"><?php echo timeToWrite($today) ?></div>
                </div>
            </li>
            <?php
            break;
    }
}