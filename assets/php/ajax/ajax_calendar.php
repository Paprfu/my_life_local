<?php
include_once('../server.php');

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'deleteCalendarEvent':
            $id = $_POST['id'];
            $sql = "DELETE FROM calendar_events WHERE id='$id'";
            $result = Globals::$database->getResult($sql);
            break;
        case 'createCalendarEvent':
            $id_person = $_POST['id_person'];
            $name = $_POST['name'];
            $start = $_POST['start_date'].' '.$_POST['start_time'] ;
            $end = $_POST['end_date'].' '.$_POST['end_time'];
            $sql = "insert into calendar_events (id_person, start, end, name) 
                    values ('$id_person','$start','$end','$name')";
            $result = Globals::$database->getResult($sql);
            header('location: calendar.php');
            break;

    }
}