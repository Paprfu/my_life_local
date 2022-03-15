<?php
include_once('../server.php');
include_once ('../functions.php');

if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'addChallenge';
            $id_person = $_POST['id'];
            $name = $_POST['name'];
            $start = $_POST['start'];
            $end = $_POST['end'];
            $icon = $_POST['icon'];
            $color = $_POST['color'];

            $sql = "INSERT INTO challenges (id_person, name, start, end, id_color, id_icon) values ('$id_person','$name','$start','$end', '$color', '$icon')";
            $result = Globals::$database->getResult($sql);
            $sql = "SELECT max(id_challenge) as id from challenges";
            $result = Globals::$database->getResult($sql);
            $id = $result->fetch_assoc()['id'];
            $ch = Globals::$database->getChallenge_ID($id);
            $challenges = Globals::$person->getChallenges();
            ?>
	        <div id="challenge-div-<?php echo $ch->id ?>" class="col-lg-3 col-md-6 col-xs-12">
		        <div class="info-box bg-<?php echo $ch->color['color'] ?>">
			        <a onclick="addChallengeSuccess(<?php echo $ch->id ?>)">
				        <div class="icon-box icon-hover-blue">
                                            <span class="icon">
                                                <i style="font-size: 50px !important;"
                                                   class="<?php echo $ch->icon['type'] . ' ' . $ch->icon['icon'] ?> "></i>
                                            </span>
				        </div>
			        </a>
			        <div class="info-box-content">
				        <h4 id="challenge-counter-<?php echo $ch->id ?>"
				            class="number"><?php echo $ch->getSuccessDays() ?></h4>
				        <p class="info-text"><?php echo $ch->name ?></p>
			        </div>
		        </div>
	        </div>
	        <div id="add-challenge-div" class="col-lg-3 col-md-6 col-xs-12">
		        <div class="info-box text-dark">
			        <a data-toggle="modal" data-target="#addChallengeModal">
				        <div class="icon-box icon-hover-blue text-dark">
                                            <span class="icon">
                                                <i style="font-size: 50px !important;"
                                                   class="mdi mdi-plus"></i>
                                            </span>
				        </div>
			        </a>
			        <div class="info-box-content text-dark">
				        <h4 id='challenges-count-h4' style="color: #000000 !important;" class="number"><?php echo count($challenges) ?></h4>
				        <p style="color: #000000 !important;" class="info-text">Pridať výzvu</p>
			        </div>
		        </div>
	        </div>
            <?php
            break;
        case 'addChallengeToTable':
            $id_person = $_POST['id'];
            $sql = "SELECT * from challenges where id_person='$id_person'";
            $result = Globals::$database->getResult($sql);
            $number = mysqli_num_rows($result);
            $sql = "SELECT max(id_challenge) as id from challenges";
            $result = Globals::$database->getResult($sql);
            $id = $result->fetch_assoc()['id'];
            $ch = Globals::$database->getChallenge_ID($id);
            ?>
	        <tr id="challenge-tr-<?php echo $id ?>">
		        <td>
			        <?php echo $number ?>
		        </td>
		        <td>
			        <i class="<?php echo $ch->icon['type'] . ' ' . $ch->icon['icon'] ?> "></i>
		        </td>
		        <td>
			        <?php echo $ch->name ?>
		        </td>
		        <td>
			        <?php
				        $id = $ch->id;
				        for ($i = 1; $i < 30; $i++) {
					        $date = date('Y-m-d H:i:s', mktime(0, 0, 0, date("m"), date("d") - $i, date("Y")));
					        if ($ch->start <= $date) {
						        if ($ch->getSuccessDay($date)) {
							        ?>
							        <i id="<?php echo $ch->name ?>-success-day-<?php echo $i ?>" onclick="changeSuccessDay(<?php echo $id?>, '<?php echo $date ?>', <?php echo $i ?>)"
							           class='mdi mdi-check'></i>
							        <?php
						        } else {
							        ?>
							        <i id="<?php echo $ch->name ?>-success-day-<?php echo $i ?>" onclick="changeSuccessDay(<?php echo $id?>, '<?php echo $date ?>', <?php echo $i ?>)"
							           class='mdi mdi-window-close'></i>
							        <?php
						        }
					        } else {
						        break;
					        }
				        }
			        ?>
		        </td>
		        <td>
			        <?php
				        $date = date('Y-m-d');
				        if ($ch->start <= $date && $ch->getSuccessDay($date)) {
					        echo "<i class='mdi mdi-check'></i>";
				        } else {
					        echo "<i class='mdi mdi-window-close'></i>";
				        } ?>
		
		        </td>
		        <td>
			        <?php
				        $count = 0;
				        $date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - ($count + 1), date("Y")));
				        while ($ch->getSuccessDay($date)) {
					        $count++;
					        $date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d") - ($count + 1), date("Y")));
					
				        }
				        echo $count;
			
			        ?>
		        </td>
		        <td>
			        <?php
				        echo dateToWrite($ch->start);
			        ?>
		        </td>
		        <td>
			        <?php
				        echo dateToWrite($ch->end);
			        ?>
		        </td>
		        <td>
			        <div class="btn-group dropdown">
				        <a href="javascript: void(0);"
				           class="dropdown-toggle arrow-none"
				           data-toggle="dropdown" aria-expanded="false"><i
							        class="lni-more-alt"></i></a>
				        <div class="dropdown-menu dropdown-menu-right">
					        <a class="dropdown-item"
					           onclick="deleteChallenge(<?php echo $ch->id ?>)"><i
								        class="lni-trash mr-2 text-gray"></i>Odstrániť výzvu</a>
				        </div>
			        </div>
		
		        </td>
	
	        </tr>
            <?php
            break;
        case 'deleteChallenge':
            $id = $_POST['id'];
            $sql = "DELETE FROM challenges WHERE id_challenge='$id'";
            Globals::$database->getResult($sql);
            echo count(Globals::$person->getChallenges());
            break;
        case 'addSuccess':
            $id = $_POST['id'];
            $sql = "insert into challenge_success (id_challenge, date, success) values ('$id',CURRENT_TIMESTAMP,1)";
            Globals::$database->getResult($sql);
            $ch = Globals::$database->getChallenge_ID($id);
            echo $ch->getSuccessDays();
            break;
	    case 'changeSuccessDay':
		    $id = $_POST['id'];
		    $date = $_POST['date'];
		    $sql = "select * from challenge_success where id_challenge='$id' and date='$date'";
		    $result = Globals::$database->getResult($sql);
		    if($row = mysqli_fetch_row($result)) {
		    	$sql = "delete from challenge_success where id_challenge='$id' and date='$date'";
		    } else {
			    $sql = "insert into challenge_success (id_challenge, date, success) values ('$id','$date',1)";
		    }
		    Globals::$database->getResult($sql);
	    	break;


    }
}
