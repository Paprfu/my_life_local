<?php

use assets\php\classes\Activity;

include_once ('../server.php');
include_once ('../functions/activities_functions.php');
if(isset($_POST['method'])) {
    switch($_POST['method']) {
        case 'createActivity':
            $sql = "INSERT INTO activity(id_person, name, type, start)
                    VALUES ('$_POST[id_person]', '$_POST[name]', '$_POST[type]', NOW())";
            Globals::$database->getResult($sql);
            $activity = Globals::$person->getActivity_MaxID();
            showActivityDatatableRow($activity, count(Globals::$person->getActivities()), true);
            break;
	    case 'showEditModalActivity':
	    	$id_activity = $_POST['id_activity'];
	    	$activity = Globals::$database->getActivity_ID($id_activity);
	    	if($activity != null) {
			    showEditActivityModal($activity);
		    }
	    	else {
			    $errors[] = "Aktivita na  úpravu nebola nájdená";
	    	}
		    break;
	    case 'editActivity':
		    $id_activity = $_POST['id_activity'];
		    $name = $_POST['name'];
		    $type = $_POST['type'];
		    $start_date = $_POST['start_date'];
		    $start_time = $_POST['start_time'];
		    $sql = "update activity set name='$name', type='$type', start='$start_date $start_time' where id_activity='$id_activity'";
		    Globals::$database->getResult($sql);
		    $activity = Globals::$database->getActivity_ID($id_activity);
		    $number = count(Globals::$person->getActivities());
		    showActivityDatatableRow($activity, $number, false);
		    break;
	    case 'deleteActivity':
		    $id_activity = $_POST['id_activity'];
		    $sql = "delete from activity where id_activity='$id_activity'";
		    Globals::$database->getResult($sql);
	    	break;
    }
}
