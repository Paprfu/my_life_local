<?php
if (!isAdmin()) {
    header('location: 404.php');
    return;
}
$msg = "";
if(isset($_POST['add-school'])) {
    $name = $_POST['school-name'];
    $sql = "INSERT into schools (name) values ('$name')";
    $result = Globals::$database->getResult($sql);
    if($result) {
        $msg = "<div class='alert alert-success'>School has been successfully added into database</div>";
    } else {
        $msg = "<div class='alert alert-danger'>School has not been added into database</div>";

    }
}

$users = Globals::$database->getUsers();
?>

    <!-- Page Container START -->
    <div class="page-container">
        <!-- Content Wrapper START -->
        <div class="main-content">
            <div class="container-fluid">
                <!-- Breadcrumb Start -->
                <div class="breadcrumb-wrapper row">
                    <div class="col-12 col-lg-3 col-md-6">
                        <h4 class="page-title">Admin</h4>
                    </div>
                    <div class="col-12 col-lg-9 col-md-6">
                        <ol class="breadcrumb float-right">
                            <li><a href="#">Admin</a></li>
                            <li class="active"> / View</li>
                        </ol>
                    </div>
                </div>
                <!-- Breadcrumb End -->
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-dark">
                            <div class="card-header border-bottom">
                                <h4 class="card-title text-white">Users</h4>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Meno</th>
                                                <th>Email</th>
                                                <th>Accepted?</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($users as $u) {
                                            ?>
                                            <tr id="users-table-tr-'<?php echo $u->id ?>">
                                                <td><?php echo $u->id ?></td>
                                                <td><?php echo $u->name ?></td>
                                                <td><?php echo $u->email ?></td>
                                                <td id="accepted-td-<?php echo $u->id ?>"><?php echo $u->accepted ?><i onclick="changeAccepted(<?php echo $u->id ?>)" class="mdi mdi-redo-variant float-right mdi-24px"></i></td>
                                                <td class="text-center"><i onclick="deleteUser(<?php echo $u->id ?>)" class="mdi mdi-delete-forever mdi-24px"></i></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="card bg-dark">
                            <div class="card-header border-bottom">
                                <h4 class="card-title text-white">Schools</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-description text-white">
                                    Insert school into the database.
                                </p>
                                <form class="forms-sample" method="post" action="index.php?page=admin">
                                    <div class="form-group row">
                                        <label for="school-name-input" class="col-sm-3 col-form-label text-white">Name of the school</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="school-name-input" name="school-name" placeholder="Name">
                                        </div>
                                    </div>
                                    <?php echo $msg ?>
                                    <button type="submit" class="btn btn-common mr-3" name="add-school">Add school</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


