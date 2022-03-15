<?php
include_once('assets/php/functions/calendar_functions.php');
$file = pathinfo(__FILE__, PATHINFO_FILENAME);

?>

    <div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Kalendár</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="#">Použivateľ</a></li>
                        <li class="active"> / Kalendár</li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-2 col-lg-3 col-md-4">
                                    <h4 class="m-t-5 m-b-15 text-white">Vytvoriť udalosť</h4>
                                    <button class="btn btn-common" data-toggle="modal" data-target="#add-calendar-event-modal">Pridať udalosť</button>
                                    <?php /*
                                        <form method="post" id="add_event_form" class="m-t-5 m-b-20">
                                            <input id="name-event" type="text" class="form-control new-event-form"
                                                   placeholder="Add new event..."/>
                                            <input id="start-date" type="datetime-local"
                                                   class="form-control new-event-form" placeholder="Add new event..."/>
                                            <input id="end-date" type="datetime-local"
                                                   class="form-control new-event-form" placeholder="Add new event..."/>

                                        </form>
                                        */

                                    ?>

                                </div>
                                <div id='calendar' class="col-xl-10 col-lg-9 col-md-8"></div>
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
                            <h4 class="card-title text-white">Udalosti</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-sm table-responsive-sm">
                                    <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Názov</th>
                                        <th>Začiatok</th>
                                        <th>Koniec</th>
                                        <th>Akcia</th>

                                    </tr>
                                    </thead>
                                    <tbody id="archived-tasks">
                                    <?php
                                    $number = 1;
                                    $events = Globals::$database->getCalendarEvents();
                                    foreach ($events as $e) {

                                        ?>
                                        <tr id="calendar-table-tr-<?php echo $e->id ?>">
                                            <td><?php echo $number ?></td>

                                            <td><?php echo $e->name ?></td>
                                            <td><?php echo dateToWrite($e->start) . ' ' . timeToWrite($e->start) ?></td>
                                            <td><?php echo dateToWrite($e->end) . ' ' . timeToWrite($e->end) ?></td>
                                            <td><span onclick="deleteCalendarEvent(<?php echo $e->id ?>)"
                                                      class="mdi mdi-delete-forever"></span>
                                            </td>
                                        </tr>
                                        <?php
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
    </div>

<?php
showAddCalendarEventModal();
?>

