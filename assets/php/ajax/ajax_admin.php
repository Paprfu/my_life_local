<?php

include_once('../server.php');

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'changeAccepted':
            $id = $_POST['id'];
            $sql = "UPDATE user SET accepted = NOT accepted where id_user='$id'";
            Globals::$database->getResult($sql);
            $sql = "SELECT accepted FROM user WHERE id_user='$id'";
            $result = Globals::$database->getResult($sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $accepted = $row['accepted'];
            }
            echo $accepted . "<i onclick='changeAccepted($id)' class='mdi mdi-redo-variant float-right mdi-24px'></i>";

            break;
        case 'deleteUser':
            $id = $_POST['id'];
            $sql = "DELETE FROM user WHERE id_user='$id'";
            Globals::$database->getResult($sql);
            break;
        case 'showUsers':
            $finding = $_POST['finding'];
            $persons = array();
            $id_person =  Globals::$person->id;
            $sql = "SELECT * FROM person WHERE id_person != '$id_person' AND name LIKE '$finding%'";
            $result = Globals::$database->getResult($sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $persons[] = Globals::$database->createPerson($row);
            }
            foreach ($persons as $p) {
                ?>
                <li class="dropdown-item">
                    <div onclick="location.href = 'profile.php?person=<?php echo $p->id ?>'">
                        <img style="width: 50px; height: 50px" src="<?php echo $p->pi->photo ?>" alt="user-img"
                             class="img-circle img-fluid">
                        <span class="ti"><?php echo $p->name ?></span>
                    </div>
                </li>
                <?php
            }
            break;
        case 'addIcon':
            $type = $_POST['type'];
            $icon = $_POST['icon'];
            $sql = "SELECT * FROM icons WHERE icon='$icon' AND type='$type'";
            $result = Globals::$database->getResult($sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<div class='alert alert-danger' role='alert'>
                            <strong>Smola!</strong> Ikona sa už v databáze nachádza
                               <i class='$type $icon'></i></div>";
                return;
            }

            $sql = "INSERT INTO icons (type, icon) values ('$type', '$icon')";
            Globals::$database->getResult($sql);
            echo "<div class='alert alert-success' role='alert'>
                            <strong>Výborne!</strong> Ikona bola pridaná do databázy
                               <i class='$type $icon'></i></div>";

            break;

    }
}
