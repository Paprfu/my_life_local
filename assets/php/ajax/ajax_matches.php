<?php
include_once('../server.php');
include_once('../functions/matches_functions.php');


if(isset($_POST['method'])) {
    switch($_POST['method']) {
        case 'deleteMatch':
            $id = $_POST['id_match'];
            $sql = "DELETE FROM `match` where id_match='$id'";
            Globals::$database->getResult($sql);
            header('location: matches.php');
            exit();
        case 'editMatch':
            $id = $_POST['id_match'];
            $match = Globals::$database->getMatch_ID($id);
            showMatchInTableToEdit($match, $match->id_match);
            break;
        case 'saveMatch':
            $id = $_POST['id_match'];
            $score_home = $_POST['score_home'];
            $score_guest = $_POST['score_guest'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $sql = "UPDATE `match` SET score_home = '$score_home', score_guest='$score_guest', date_time='$date $time'
                    where id_match='$id'";
            Globals::$database->getResult($sql);
            $match = Globals::$database->getMatch_ID($id);
            showMatchInTable($match, $match->id_match);
            break;
    }
}
