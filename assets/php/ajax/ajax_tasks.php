<?php
	
	include_once('../server.php');
	include_once('../functions.php');
	include_once('../functions/tasks_functions.php');
	if (isset($_POST['method'])) {
		switch ($_POST['method']) {
			case 'showConnect':
				$id = $_POST['id'];
				$type = $_POST['type'];
				$array = array();
				switch ($type) {
					case 'project':
						$array = Globals::$database->getProjects();
						foreach ($array as $a) {
							echo "<option value='$a->id'>$a->name</option>";
						}
						break;
					case 'subject':
						$array = Globals::$database->getSubjects();
						foreach ($array as $a) {
							echo "<option value='$a->id'>$a->name</option>";
						}
						break;
					case 'repeat':
						$array = array('denne', 'týždenne', 'mesačne');
						foreach ($array as $a) {
							echo "<option value='$a'>$a</option>";
						}
						break;
				}
				
				break;
			case 'addTask':
				$id_person = $_POST['id_person'];
				$name = $_POST['name'];
				$date = $_POST['date'];
				$time = $_POST['time'];
				$type = $_POST['type'];
				
				$id_connect = $_POST['connect'];
				
				
				$sql = "insert into tasks (id_person, name, date_created, date, type, date_done, id_connect) VALUES
                   ('$id_person','$name', NOW() , '$date $time' , '$type', null, '$id_connect')";
				Globals::$database->getResult($sql);
				
				
				$sql = "SELECT max(id_task) as id from tasks";
				$result = Globals::$database->getResult($sql);
				$id = $result->fetch_assoc()['id'];
				$task = Globals::$database->getTask_ID($id);
				$icons = 'no';
				showUndoneTask($task, $icons);
				break;
			case 'changeTask':
				$id_task = $_POST['id_task'];
				$checked = $_POST['checked'];
				$date_done = date("Y-m-d h:i:sa");
				if ($checked === 'true') {
					$sql = "UPDATE tasks SET done=$checked, date_done='$date_done' where id_task='$id_task'";
				} else {
					$sql = "UPDATE tasks SET done=$checked, date_done=NULL where id_task='$id_task'";
					
				}
				Globals::$database->getResult($sql);
				$task = Globals::$database->getTask_ID($id_task);
				
				if ($task->type === 'repeat') {
					if ($checked === 'true') {
						$sql = "INSERT into repeat_tasks(id_task, date_done) values ('$task->id',CURRENT_TIMESTAMP)";
						} else {
						$sql = "DELETE FROM repeat_tasks WHERE id_task='$task->id'";
						}Globals::$database->getResult($sql);
					
				}
				
				if ($task->isTimerUP()) {
					$task->stopTimer();
				}
				if ($checked === 'true') {
					showDoneTask($task, Globals::$person);
				} else {
					showUndoneTask($task, Globals::$person);
				}
				break;
			case 'deleteTask':
				$id_task = $_POST['id_task'];
				
				$sql = "Delete from tasks where id_task='$id_task' ";
				Globals::$database->getResult($sql);
				
				
				break;
			case 'archiveTask':
				$id = $_POST['id'];
				$sql = "UPDATE tasks SET done=2 where id_task='$id'";
				$result = Globals::$database->getResult($sql);
				$number = 1;
				$task = Globals::$database->getTask_ID($id);
				?>
				<tr id="archived-tasks-table-tr-<?php echo $task->id ?>">
					<td>Aktuálne archivovaný</td>
					<td><?php echo $task->name ?></td>
					<td><?php echo dateToWrite($task->date_created) ?></td>
					<td><?php echo dateToWrite($task->date) ?></td>
					<td><?php echo dateToWrite($task->date_done) ?></td>
					<td><?php echo timeFormat($task->getWorkingTime()) ?></td>
					<td>
						<?php
							if ($task->date_done != null)
								{ echo "<span class='mdi mdi-check-circle mdi-18px'></span>"; }
							else
								{ echo "<span class='mdi mdi-close-circle mdi-18px'></span>"; }
						?>
					</td>
					<td>
						<div class="btn-group dropdown">
							<a href="javascript: void(0);" class="dropdown-toggle arrow-none"
							   data-toggle="dropdown" aria-expanded="false"><i
										class="lni-more-alt"></i></a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item"
								   onclick="returnTask(<?php echo $task->id ?>, <?php echo $task->done ?>)"><i
											class="lni-archive mr-2 text-gray"></i>Vrátiť úlohu</a>
								<a class="dropdown-item"
								   onclick="changeConfirmButton(<?php echo $task->id ?>, 'delete')"><i
											class="lni-trash mr-2 text-gray"></i>Odsrániť úlohu</a>
							
							</div>
						</div>
					</td>
				</tr>
				<?php
				break;
			case 'returnTask':
				$id = $_POST['id'];
				$task = Globals::$database->getTask_ID($id);
				if ($task->done) {
					$sql = "UPDATE tasks SET done=1 where id_task='$id'";
					showDoneTask($task, 'archives');
				} else {
					$sql = "UPDATE tasks SET done=0 where id_task='$id'";
					showUndoneTask($task, 'archives');
				}
				$result = Globals::$database->getResult($sql);
				
				break;
			case 'changeTimerTask':
				$id = $_POST['id'];
				$task = Globals::$database->getTask_ID($id);
				if ($task->isTimerUP()) {
					$task->stopTimer();
					echo "<i class=\"mdi mdi-timer\"></i>";
				} else {
					$task->startTimer();
					echo "<i style='color: #e22a6f;' class=\"mdi mdi-timer\"></i>";
				}

				break;
			case 'addProblem':
				$id = $_POST['id_task'];
				$task = Globals::$database->getTask_ID($id);
				$number = count($task->getProblems()) + 1;
				$name = $_POST['name'];
				$note = $_POST['note'];
				$sql = "INSERT into problem (id_task, description, note) values('$id', '$name', '$note')";
				Globals::$database->getResult($sql);
				$sql = "SELECT MAX(id_problem) as id from problem";
				$result = Globals::$database->getResult($sql);
				$id = $result->fetch_assoc()['id'];
				$p = Globals::$database->getProblem_ID($id);
				showProblemInTable($p, true);
				break;



			case 'deleteProblem':
				$id = $_POST['id'];
				$sql = "DELETE FROM problem WHERE id_problem='$id'";
				Globals::$database->getResult($sql);
				break;
			
			case 'showIcons':
				$icons = $_POST['icons'];
				$type = $_POST['type'];

				if ($type === 'undone') {
                    $tasks = Globals::$person->getTasks_Done(0);
					showUndoneTasks($icons, $tasks);
				} else if ($type === 'done') {
                     $tasks = Globals::$person->getTasks_Done(1);
					showDoneTasks($icons, $tasks);
				}
				break;
			case 'showModal':
				$id = $_POST['id'];
				$type = $_POST['type'];
				$task = Globals::$database->getTask_ID($id);
				echo "<script>alert('som tu')</script>";
				echo "som tu";
				if ($type === 'edit') {
					echo "<script>alert('som v edit')</script>";
					echo "som v edit";
					?>
					<div id="editTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalEditTask"
					style="" aria-hidden="false">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title text-dark" id="myModalEditTask">Pridanie úlohy</h5>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="false">×</button>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-xs-12">
										<div class="form-group row">
											<label for="name-input" class="control-label">Názov</label>
											<input id="name-input" type="text" class="form-control" name="name"
											       value="<?php echo $task->name ?>">
										</div>
										<div class="form-group row">
											<label class="control-label" for="date-input">Dátum
												na
												dokončenie</label>
											
											<input id="date-input" type="date" class="form-control"
											       name="date" value="<?php echo date('Y-m-d', $task->date) ?>">
											<label for="time-input"></label><input id="time-input" type="time"
											                                       class="form-control"
											                                       name="time"
											                                       value="<?php echo date('H:i:s', $task->date) ?>">
										</div>
										
										
										<div class="form-group row">
											<label for="select-type" class="control-label">Typ</label>
											
											<select id="select-type" class="form-control" onchange="showConnect()">
												<option value="normal" <?php if ($type === 'normal') echo 'selected' ?>>
													Normálna
												</option>
												<option value="repeat" <?php if ($type === 'repeat') echo 'selected' ?>>
													Opakovateľná
												</option>
												<option value="project" <?php if ($type === 'project') echo 'selected' ?>>
													Projekt
												</option>
												<option value="subject" <?php if ($type === 'subject') echo 'selected' ?>>
													Predmet
												</option>
											
											</select>
										
										</div>
										<?php
											if ($type === 'normal') {
											?>
											<div id="pripojenie-div" class="form-group row hidden">
												<label for="pripojenie-select" class="control-label">Pripojenie</label>
												
												<select id="pripojenie-select" class="form-control">
													<?php
														$projects = Globals::$database->getProjects();
														$subjects = Globals::$database->getSubjects();
														foreach ($subjects as $s) {
															echo "<option value='$s->id'>$s->name</option>";
														}
														foreach ($projects as $p) {
															echo "<option value='$p->id'>$p->name</option>";
														}
													?>
												
												</select>
											
											</div>
											<?php
										} else {
										?>
										<div id="pripojenie-div" class="form-group row">
											<label for="pripojenie-select" class="control-label">Pripojenie</label>
											
											<select id="pripojenie-select" class="form-control">
												<?php
													$projects = Globals::$database->getProjects();
													$subjects = Globals::$database->getSubjects();
													foreach ($subjects as $s) {
														if ($s->connect->id === $s->id)
															echo "<option value='$s->id' selected>$s->name</option>";
														else
															echo "<option value='$s->id'>$s->name</option>";
														
													}
													foreach ($projects as $p) {
														if ($s->connect->id === $p->id) {
															echo "<option value='$p->id' selected>$s->name</option>";
														} else {
															echo "<option value='$p->id'>$s->name</option>";
														}
													}
												?>
											</select>
											<?php
												}
											?>
										</div>
										<div id="error-msg">
										</div>
									</div>
								</div>
								
								<div class="modal-footer">
									<button type="button" class="btn btn-common waves-effect"
									        onclick="editTask(<?php echo $task->id ?>)">Pridať
									</button>
									<button type="button" class="btn btn-secondary waves-effect"
									        data-dismiss="modal">Zavrieť
									</button>
								</div>
							</div>
						</div>
					</div>
					
					<?php
				}
				break;
			case 'solveProblem':
				$id = $_POST['id'];
				$sql = "UPDATE problem set solved = 1 where id_problem='$id'";
				Globals::$database->getResult($sql);
				$task = Globals::$database->getTask_ProblemID($id);
			  ?>
			<a class="dropdown-item"
			   onclick="unsolveProblem(<?php echo $id ?>, <?php echo count($task->getProblems_Solved(1)) ?>)"><i
						class="lni-close mr-2 text-gray"></i>Zrušiť vyriešenie</a>
			<a class="dropdown-item"
		   onclick="editProblem(<?php echo $id ?>)"><i
					class="lni-pencil mr-2 text-gray"></i>Upraviť</a>
				<a class="dropdown-item"
		    onclick="deleteProblem(<?php echo $id ?>)"><i
					class="lni-trash mr-2 text-gray"></i>Odstrániť</a>
		<?php
		break;
		case 'unsolveProblem':
				$id = $_POST['id'];
				$sql = "UPDATE problem set solved = 0 where id_problem='$id'";
				Globals::$database->getResult($sql);
				$task = Globals::$database->getTask_ProblemID($id);
				?>
				<a class="dropdown-item"
			   onclick="solveProblem(<?php echo $id ?>, <?php echo count($task->getProblems_Solved(1)) ?>)"><i
						class="lni-check-mark-circle mr-2 text-gray"></i>Vyriešiť</a>
			<a class="dropdown-item"
		   onclick="editProblem(<?php echo $id ?>)"><i
					class="lni-pencil mr-2 text-gray"></i>Upraviť</a>
				<a class="dropdown-item"
		    onclick="deleteProblem(<?php echo $id ?>)"><i
					class="lni-trash mr-2 text-gray"></i>Odstrániť</a>
						<?php
				break;
		case 'showEditModalProblem':
			 $id = $_POST['id'];
			 $problem = Globals::$database->getProblem_ID($id);
			 if($problem == null) {
			     $errors[] = "Problem to edit has not been found in database!";
			     return;
			 }
			 showEditProblemModal($problem);
		break;
		case 'editProblem':
			$id = $_POST['id'];
			$name = $_POST['name'];
			$note = $_POST['note'];
			$sql = "update problem set description='$name',
		            note = '$note'
			where id_problem='$id'";
			Globals::$database->getResult($sql);
			$task = Globals::$database->getTask_ProblemID($id);
			$number = count($task->getProblems());
			$p = Globals::$database->getProblem_ID($id);
			showProblemInTable($p, false);
			break;
		}
	}

