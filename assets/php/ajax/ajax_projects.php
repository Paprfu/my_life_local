<?php
	include_once('../server.php');
	include_once('../classes/Database.php');
	include_once('../functions.php');
	$errors = array();
	$projects = Globals::$user->getProjects();
	
	if (isset($_POST['method'])) {
		switch ($_POST['method']) {
			case 'createProject':
				$id_user = $_POST['id_user'];
				$name = $_POST['name'];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$sql = "INSERT INTO projects (name ,start, end)
                    VALUES ('$name', '$start', '$end')";
				Globals::$database->getResult($sql);
				$sql = "SELECT MAX(id) as id FROM projects";
				$result = Globals::$database->getResult($sql);
				if ($row = mysqli_fetch_assoc($result)) {
					$id = $row['id'];
				} else {
					$errors[] = 'Nenašlo sa id';
					return;
				}
				$sql = "INSERT INTO project_person (id_project, id_person, work_time)
                    VALUES ('$id', '$id_user', 0)";
				Globals::$database->getResult($sql);
				$project = Globals::$database->getProject_ID($id);
				$number = Globals::$database->getNumber('projects');
				showProject($project, $number, false);
				break;
			case 'delete':
				$id = $_POST['id'];
				$sql = "DELETE FROM project_person WHERE id_project='$id'";
				Globals::$database->getResult($sql);
				$sql = "DELETE FROM projects WHERE id='$id'";
				Globals::$database->getResult($sql);
				break;
			case 'save':
				$id = $_POST['id'];
				$name = $_POST['name'];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$sql = "UPDATE projects SET name='$name', start='$start', end='$end' WHERE id='$id'";
				Globals::$database->getResult($sql);
				$project = Globals::$database->getProject_ID($id);
				$number = Globals::$database->getNumber('projects');
				showProject($project, $number, true);
				break;
			case 'edit':
				$id = $_POST['id'];
				$project = Globals::$database->getProject_ID($id);
				showProjectsEdit(Globals::$today, $project);
				break;
			case 'end':
				$id = $_POST['id'];
				$project = Globals::$database->getProject_ID($id);
				$done = $project->done == 1 ? 0 : 1;
				try {
					$project = $project->setDone($done);
				} catch (Exception $e) {
					$errors[] = "Projekt sa nepodarilo ukončiť";
					return;
				}
				$number = Globals::$database->getNumber('projects');
				$project = Globals::$database->getProject_ID($id);
				showProject($project, $number, true);
				break;
			case 'numberProjectsUndone':
				$id_person = Globals::$person->id;
				$sql = "SELECT count(*) as number FROM projects JOIN project_person pp on projects.id = pp.id_project WHERE done=0 AND id_person='$id_person'";
				$result = Globals::$database->getResult($sql);
				
				echo $result->fetch_assoc()['number'];
				break;
			case 'numberProjectsDone':
				$id_person = Globals::$person->id;
				$sql = "SELECT count(*) as number FROM projects JOIN project_person pp on projects.id = pp.id_project WHERE done=1 AND id_person='$id_person'";
				$result = Globals::$database->getResult($sql);
				echo $result->fetch_assoc()['number'];
				break;
			
			case 'showWorkingTime':
				$type = $_POST['type'];
				$date = date('Y-m-d');
				$week_start = strtotime('monday this week', strtotime($date));
				$week_end = strtotime('sunday this week', strtotime($date));
				
				$month_start = strtotime('first day of this month', time());
				$month_end = strtotime('last day of this month', time());
				
				$year_start = strtotime('first day of January', time());
				$year_end = strtotime('last day of December', time());
				switch ($type) {
					case '0':
						$from = date('Y-m-d H:i:s', $month_start);
						$to = date('Y-m-d H:i:s', $month_end);
						break;
					case '1':
						$from = date("Y-m-d 00:00:00");
						$to = date("Y-m-d 23:59:59");
						break;
					case '2':
						$from = date('Y-m-d H:i:s', $week_start);
						$to = date('Y-m-d H:i:s', $week_end);
						break;
					case '3':
						$from = date('Y-m-d H:i:s', $year_start);
						$to = date('Y-m-d H:i:s', $year_end);
						break;
				}
				$projects = Globals::$person->getProjects();
				
				foreach ($projects as $p) {
					?>
					<tr>
						<td>
							<div class="list-media">
								<div class="list-item">
									<div class="media-img">
										<a class="btn btn-circle btn-info"><?php echo getProjectIcon($p->name) ?></a>
									</div>
									<div class="info">
										<span class="title text-semibold"><?php echo $p->name ?></span>
									</div>
								</div>
							</div>
						</td>
						<td><?php echo getStatus(Globals::$today, $p->end, $p->done) ?></td>
						<td id="project-time-td-"<?php echo $p->id ?>><?php echo timeFormat($p->getWorkingTime_From_To($from, $to)) ?></td>
					</tr>
					<?php
				}
				
				break;
			default:
				$errors[] = "Metóda pre akciu s projektami sa nenašla";
		}
	}
	
	function showProjectsEdit($today, $project)
	{
		?>
		<td><?php echo $project->id ?></td>
		<td><label for="name-edit-input"></label><input id="name-edit-input" type="text" class="form-control"
		                                                value="<?php echo $project->name ?>"></td>
		<td>
			<?php $date = new DateTime($project->start); ?>
			<label for="start-edit-input"></label><input
					id="start-edit-input" type="date" class="form-control"
					value="<?php echo $date->format('Y-m-d') ?>"></td>
		<td><?php try {
				$date = new DateTime($project->end);
			} catch (Exception $e) {
				$date = null;
			} ?><label for="end-edit-input"></label><input id="end-edit-input" type="date" class="form-control"
		                                                   value="<?php if ($date != null) echo $date->format('Y-m-d') ?>">
		</td>
		<?php
		$t1 = strtotime($today);
		$t2 = strtotime($project->end);
		$diff = $t2 - $t1;
		if ($project->done == 0 && ($project->end == null || $diff > 0)) {
			?>
			<td><a href="#" class="badge badge-info">Pracuje sa</a></td>
			<?php
		} else if ($project->done == 1) {
			?>
			<td><a href="#" class="badge badge-success">Úspešne ukončený</a></td>
			<?php
		} else if ($project->end != '-' && $today <= $project->end && $project->done == 0) {
			?>
			<td><a href="#" class="badge badge-danger">Premeškaný</a></td>
			<?php
		}
		?>
		<td>
			<button class="btn btn-common" onclick="saveProject(<?php echo $project->id ?>)"><span
						class="mdi mdi-content-save"></span>Uložiť
			</button>
		</td>
		
		<?php
	}


?>
