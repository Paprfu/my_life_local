<?php

include_once ('../server.php');
include_once ('../functions/leagues_functions.php');
if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'editLeague':
            $id = $_POST['id'];
            echo "som tu";
            $league = Globals::$database->getLeague_ID($id);
            showLeagueInTableToEdit($league, $league->id);
            break;

        case 'saveLeague':
            $id = $_POST['id'];
            $name =  $_POST['name'];
            $start = $_POST['start_date'];
            $end = $_POST['end_date'];
            $sql = "update league set name='$name',start_date='$start',end_date='$end' where id_league='$id'";
            Globals::$database->getResult($sql);
            $league = Globals::$database->getLeague_ID($id);
            showLeagueInTable($league, $league->id);
            break;

        case 'deleteLeague':
            $id = $_POST['id'];
            $sql = "delete from league where id_league='$id'";
            Globals::$database->getResult($sql);
            break;
        case 'addMatch':
            $id_league = $_POST['id_league'];
            $id_home_team = $_POST['id_home_team'];
            $id_guest_team = $_POST['id_guest_team'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            $sql = "insert into `match` (id_home_team, id_guest_team, score_home, score_guest, date_time) values 
                    ('$id_home_team', '$id_guest_team', 0 , 0 , '$date $time')";
            Globals::$database->getResult($sql);

            break;
    }
}
