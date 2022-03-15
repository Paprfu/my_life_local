<?php
$projects = Globals::$person->getSchools();

?>


<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Schools</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="?page=schools">Schools</a></li>
                        <li class="active"> / Schools</li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>

        <div class="container-fluid">
            <?php
            include_once('assets/php/error.php');
            ?>
        </div>

        <div class="container-fluid">
            <div class="card-group">
                <?php
                cardGroupItem('Number of schools', 'lni-pencil-alt', 'purple', count(Globals::$person->getSchools()), 0, 1000);
                cardGroupItem('Finished schools', 'lni-check-box', 'danger', count(Globals::$person->getSchools_Done(1)), 0, count(Globals::$person->getSchools()));
                cardGroupItem('Current schools', 'lni-close', 'info', count(Globals::$person->getSchools_Done(0)), 0, count(Globals::$person->getSchools()));

                ?>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="card bg-dark">
                        <div class="card-header">
                            <h4 class="card-title text-white">Projects in progress</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table class="table table table-sm table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <td class="text-white text-semibold">#</td>
                                        <td class="text-white text-semibold">Name</td>
                                        <td class="text-white text-semibold">Start</td>
                                        <td class="text-white text-semibold">End</td>
                                        <td class="text-white text-semibold">Status</td>
                                        <td class="text-white text-semibold">Time</td>
                                        <td class="text-white text-semibold">Edit</td>
                                    </tr>
                                    </thead>
                                    <tbody id="projects-list-tbody">
                                    <?php
                                    $number = 1;
                                    foreach ($projects_undone as $project) {
                                        showProject($project, $number, false);
                                        $number++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-dark">
                        <div class="card-header border-bottom">
                            <h4 class="card-title text-white">Projects completed</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive-sm">
                                <table id="datatable-buttons" class="table table-sm table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Status</th>
                                        <th>Čas</th>
                                        <th>Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $number = 1;
                                    foreach ($projects_done as $p) {
                                        showProject($p, $number, false);
                                        $number++;
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>

        <!-- Content Wrapper END -->
        <div class="container-fluid">
            <div class="card bg-dark">
                <div class="card-header border-bottom">
                    <h4 class="card-title text-white">Create new project</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10 col-md-12 col-xs-12">
                            <div class='form-group row'>
                                <label for="name-input"
                                       class='col-sm-2 col-form-label control-label text-white'>
                                    Name</label>
                                <div class='col-sm-10'>
                                    <input id="name-input" type='text' name='name' placeholder='name'
                                           class='form-control'>
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label for="name-input"
                                       class='col-sm-2 col-form-label control-label text-white'>
                                    Start of the project</label>
                                <div class='col-sm-10'>
                                    <label for="start-input"></label><input id="start-input" type='date'
                                                                            name='start-date'
                                                                            class='form-control' value="<?php try {
                                        $date = new DateTime(Globals::$today);
                                    } catch (Exception $e) {
                                    }
                                    echo $date->format('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class='form-group row'>
                                <label for="name-input"
                                       class='col-sm-2 col-form-label control-label text-white'>
                                    End of the project</label>
                                <div class='col-sm-10'>
                                    <label for="end-input"></label>
                                    <input id="end-input" type='date' name='end-date'
                                           class='form-control' value="<?php $date = new DateTime(Globals::$today);
                                    echo $date->format('Y-m-d') ?>">
                                </div>
                            </div>
                            <button class='btn btn-common'
                                    onclick="createProject(<?php echo Globals::$user->id ?>)">
                                Create new project
                            </button>
                            <div id="msg-submit">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


