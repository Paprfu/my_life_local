<?php
include_once ('../classes/Database.php');
$return_arr = array();
$database = new Database();
$sql = "SELECT * FROM calendar_events";
$result = $database->getResult($sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $name = $row['name'];
    $date = $row['start'];
    $end = $row['end'];

    $return_arr[] = array("id" => $id,
        "name" => $name,
        "start" => $date,
        "end" => $end);
}

$sql = "SELECT * FROM tasks where done = 0";
$result = $database->getResult($sql);

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_task'];
    $name = $row['name'];
    $date = $row['date'];



    $return_arr[] = array("id" => $id,
        "name" => $name,
        "start" => $date);
}

echo json_encode($return_arr);