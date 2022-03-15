<?php
	include_once('../functions.php');
	
	use assets\php\classes\Activity;
	
	function showActivity($a)
	{
		?>
		<div id="challenge-div-<?php echo $a->id ?>" class="col-lg-3 col-md-6 col-xs-12">
			<div class="info-box <?php echo $a->color ?>">
				
				<div class="icon-box icon-hover-blue">
                                            <span class="icon">
                                                <i style="font-size: 50px !important;"
                                                   class="<?php echo $a->icon['type'] . ' ' . $a->icon['icon'] ?> "></i>
                                            </span>
				</div>
				
				<div class="info-box-content">
					<h4 id="challenge-counter-<?php echo $a->id ?>"
					    class="number"><?php ?></h4>
					<p class="info-text"><?php echo $a->name ?></p>
				</div>
			</div>
		</div>
		<?php
	}
	
	
	function showActivities(array $activities)
	{
		?>
		<div class="container-fluid">
			<div id="challenges" class="row">
				<?php
					$number = 1;
					foreach ($activities as $a) {
						showActivity($a);
						$number++;
					}
				?>
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
							<h4 style="color: #000000 !important;" class="number"><?php echo count($activities) ?></h4>
							<p style="color: #000000 !important;" class="info-text">Pridať výzvu</p>
						</div>
					</div>
				</div>
			</div>
		
		</div>
		<?php
	}
	
	function showActivitiesDataTable($activities)
	{
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="card bg-dark">
					<div class="card-header border-bottom">
						<h4 class="card-title text-white">Zoznam Aktivít</h4>
					</div>
					<div class="card-body">
						
						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-sm">
								<thead>
								<tr>
									<th>#</th>
									<th>Názov</th>
									<th>Typ</th>
									<th>Začiatok</th>
									<th>Úprava</th>
								</tr>
								</thead>
								<tbody id="activities-datatable-tbody">
								<?php
									$number = 1;
									foreach ($activities as $a) {
										showActivityDatatableRow($a, $number++, true);
									}
								?>
								
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer">
						<button class="btn btn-success" data-toggle="modal" data-target="#createActivityModal"><i
									class="mdi mdi-plus mdi-18px"></i>Vytvoriť aktivitu
						</button>
					</div>
				</div>
			</div> <!-- end row -->
		</div>
		<?php
	}
	
	function showCreateActivityModal()
	{
		?>
		<div id="createActivityModal" class="modal fade" tabindex="-1" role="dialog"
		     aria-labelledby="myModalCreateActivity"
		     style="display: none;" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content bg-dark text-white">
					<div class="modal-header">
						<h5 class="modal-title" id="myModalCreateActivity">Pridanie aktivity</h5>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-xs-12">
								<div class='form-group row'>
									<label for="activity-name-input"
									       class='col-sm-2 col-form-label control-label'>
										Názov</label>
									<div class='col-sm-10'>
										<input id="activity-name-input" type='text' name='name' placeholder='Názov'
										       class='form-control'>
									</div>
									<label for="activity-type-input"
									       class='col-sm-2 col-form-label control-label'>
										Typ</label>
									<div class='col-sm-10'>
										<input id="activity-type-input" type='text' name='type' placeholder='typ'
										       class='form-control'>
									</div>
								</div>
							
							
							</div>
							<div id="create-activity-modal-msg">
							</div>
						</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-common waves-effect" data-dismiss="modal"
						        onclick="createActivity(<?php echo Globals::$person->id ?>)">
							Pridať
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
	
	function showActivityDatatableRow(Activity $a, int $number, $tr)
	{
		if ($tr) {
			?>
			<tr id="activity-tr-<?php echo $a->id ?>">
			<?php
		}
		?>
		<td><?php echo $number ?></td>
		<td><a href="activity.php?activity=<?php echo $a->id ?>"><?php echo $a->name ?></a></td>
		<td><?php echo $a->type ?></td>
		<td><?php echo dateToWrite($a->start) . ' ' . timeToWrite($a->start) ?></td>
		<td>
			<div class="btn-group dropdown">
				<a href="javascript: void(0);" class="dropdown-toggle arrow-none"
				   data-toggle="dropdown" aria-expanded="false"><i
							class="lni-more-alt"></i></a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" data-toggle="modal"
					   data-target="#editActivityModal" onclick="showEditActivityModal(<?php echo $a->id ?>)"><i
								class="lni-pencil-alt mr-2 text-gray"></i>Upraviť</a>
					<a class="dropdown-item" onclick="deleteActivity(<?php echo $a->id ?>)"><i
								class="lni-trash mr-2 text-gray"></i>Odstrániť</a>
				
				</div>
			</div>
		</td>
		<?php
		if ($tr) {
			?>
			</tr>
			<?php
		}
	}
	
	function showEditActivityModal($activity)
	{
		?>
		<div class="modal-header">
			<h5 class="modal-title" id="myModalEditActivity">Upravenie aktivity</h5>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
					<div class="form-group row">
						<label for="activity-edit-name-input" class="control-label">Názov</label>
						
						<input id="activity-edit-name-input" type="text" class="form-control" name="activity-name"
						       placeholder="Názov aktivity" value="<?php echo $activity->name ?>">
					</div>
					<div class="form-group row">
						<label for="activity-edit-type-input" class="control-label">Typ</label>
						
						<input id="activity-edit-type-input" type="text" class="form-control" name="activity-type"
						       placeholder="Názov aktivity" value="<?php echo $activity->type ?>">
					</div>
					<div class="form-group row">
						<label class="control-label" for="activity-start-input">Čas</label>
						<input id="activity-start-date-input" type="date" class="form-control"
						       name="activity-start-date" value="<?php $date = new DateTime($activity->start);
							echo $date->format('Y-m-d') ?>">
						<label for="activity-start-time-input"></label>
						<input id="activity-start-time-input" type="time" class="form-control"
						       name="activity-start-time"
						       value="<?php $date = new DateTime($activity->start);
							       echo $date->format('H:i') ?>">
					</div>
				</div>
				<div id="error-msg">
				</div>
			</div>
		</div>
		<div class="modal-footer bg-dark">
			<button id="confirmButton" type="button" class="btn btn-common waves-effect"
			        onclick="editActivity(<?php echo $activity->id ?>)">Upraviť
			</button>
			<button type="button" class="btn btn-secondary waves-effect"
			        data-dismiss="modal">Zavrieť
			</button>
			<div id="activity-edit-msg-div">
			</div>
		</div>
		
		<?php
	}
	
	function get_youtube($url)
	{
		
		$youtube = "https://www.youtube.com/oembed?url=" . $url . "&format=json";
		
		$curl = curl_init($youtube);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		return json_decode($return, true);
		
	}
