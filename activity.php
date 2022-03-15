<?php

if (!isset($_GET['activity'])) {
    header('location: 404.php');
}

$activity = Globals::$database->getActivity_ID($_GET['activity']);
if ($activity == null)
    header('location: 404.php');


?>

    <div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Activity - <?php echo $activity->name ?></h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="?page=profile">User /</a></li>
                        <li><a href="activities.php">Activity /</a></li>
                        <li class="active">Activity</li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card bg-dark">
                        <div class="card-header border-bottom">
                            <h4 class="card-title text-white">Links</h4>
                            <div class="card-toolbar">
                                <ul>
                                    <li>
                                        <div class="btn-group dropdown">
                                            <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                                               data-toggle="dropdown" aria-expanded="false"><i
                                                        class="lni-more-alt"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" onclick="showActivityLinksIcons('delete')"><i
                                                            class="lni-archive mr-2 text-gray"></i>Delete Link</a>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div id="links" class="list-group text-white">
                                    <?php
                                    $links = $activity->getLinks();
                                    foreach ($links as $link) {
                                        if ($link->type === 'video') {
                                            $youtube = get_youtube($link->link);
                                            ?>
                                            <a href="<?php echo $link->link ?>"
                                               class="list-group-item list-group-item-action" target="_blank">
                                                <i class="mdi mdi-link m-r-10 text-success"></i><?php echo $youtube['title'] ?>
                                            </a>
                                            <?php
                                            echo $youtube['html'];
                                        } else {
                                            ?>
                                            <a href="<?php echo $link->link ?>"
                                               class="list-group-item list-group-item-action" target="_blank">
                                                <i class="mdi mdi-link m-r-10 text-success"></i><?php echo $link->name ?>
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addLinkModal">Pridať
                                odkaz
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="addLinkModal" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="addLinkModal" style="display: none;" aria-hidden="true">
            <div class="modal-dialog text-white">
                <div class="modal-content bg-dark">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title">
                            Add a link
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-content bg-dark">
                        <div class="form-group">
                            <label for="name-link-input" class="form-check-label">Name of the link</label>
                            <input id="name-link-input" class="form-control" type="text"
                                   value="<?php echo $activity->name ?>">
                        </div>
                        <div class="form-group">
                            <label for="link-input" class="form-check-label">Link</label>
                            <input id="link-input" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="type-link-input" class="form-check-label">Typ</label>
                            <input id="type-link-input" class="form-control" type="text">
                        </div>

                    </div>
                    <div class="modal-footer bg-dark">
                        <button onclick="createHref(<?php echo $activity->id ?>, 'activity')"
                                class="btn btn-common">
                            Create
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
