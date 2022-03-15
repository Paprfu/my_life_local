<?php

$activities = Globals::$person->getActivities();

?>

<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Activities</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="?page=profile">User /</a></li>
                        <li class="active">Activity</li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>

        <?php
        $activities = Globals::$person->getActivities();
        //showActivities($activities);
        showActivitiesDataTable($activities);
        showCreateActivityModal();
        ?>
        <div id="editActivityModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalEditActivity"
             style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div id="activity-modal-content" class="modal-content bg-dark text-white">

                </div>
            </div>
        </div>
    </div>

