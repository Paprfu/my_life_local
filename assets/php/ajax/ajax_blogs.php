<?php

include_once('../server.php');

if(isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'createBlog':
            $id_person = $_POST['id_person'];
            $name = $_POST['name'];
            $text = $_POST['text'];
            $type = $_POST['type'];
            $date = Globals::$today;
            $filename_to_store = "";
            if($type == 'blog')
            foreach ($_FILES['file']['name'] as $key => $val) {
                $file_name = $_FILES['file']['name'][$key];

                // get file extension
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // get filename without extension
                $filenamewithoutextension = pathinfo($file_name, PATHINFO_FILENAME);

                if (!file_exists(getcwd() . '/blogs/' . $id_person)) {
                    mkdir(getcwd() . '/blogs/' . $id_person, 0777);
                }

                $filename_to_store = $filenamewithoutextension . '_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['file']['tmp_name'][$key], getcwd() . '/blogs/' . $id_person . '/' . $filename_to_store);

            }
            $sql = "INSERT INTO blog(name , text, date,type,photo, id_person) values ('$name', '$text', '$date', '$type', '$filename_to_store', '$id_person')";
            $result = Globals::$database->getResult($sql);
            //BLOGS REPLACMENT
            $blogs = Globals::$person->getBlogs();
            $number = 0;
            foreach ($blogs as $b) {

                if ($b->type == 'blog') {
                    ?>
                    <div class="col-lg-4 col-md-6 col-xl-4">
                        <div class="card bg-dark">
                            <?php
                            if($number % 2 == 0) {
                                ?>
                                <img class="img-fluid"
                                     src="assets/php/ajax/blogs/<?php echo Globals::$user->id . '/' . $b->photo ?>"
                                     alt="">
                                <?php
                            }
                            ?>
                            <div class="card-body">
                                <h5 class="card-title text-white"><?php echo $b->name ?></h5>
                                <p class="text-white"><?php echo $b->text ?></p>
                                <a href="blog.php?blog=<?php echo $b->id ?>" class="btn btn-common float-left">Čítaj viac</a>

                            </div>
                            <?php
                            if($number % 2 == 1) {
                                ?>
                                <img class="img-fluid"
                                     src="assets/php/ajax/blogs/<?php echo Globals::$user->id . '/' . $b->photo ?>"
                                     alt="">
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                } else if($b->type == 'citate') {
                    ?>
                    <div class="col-lg-4 col-md-6 col-xl-4">
                        <div class="card bg-dark">
                            <div class="card-header text-white">
                                Citát - <?php echo $b->name ?>
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                    <p class="text-white"><?php echo $b->text ?></p>
                                    <footer class="blockquote-footer text-white"><cite title="Source Title"><?php echo $person->name ?></cite></footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <?php
                } else if($b->type == 'thought') {
                    ?>
                    <div class="col-lg-4 col-md-6 col-xl-4">
                        <div class="card bg-dark">
                            <div class="card-header text-white">
                                Citát - <?php echo $b->name ?>
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                    <p class="text-white"><?php echo $b->text ?></p>
                                    <footer class="blockquote-footer text-white"><cite title="Source Title"><?php echo $person->name ?></cite></footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <?php
                } else if($b->type == 'href') {
                    ?>
                    <div class="col-lg-4 col-md-6 col-xl-4">
                        <div class="card bg-dark">
                            <div class="card-header text-white">
                                Citát - <?php echo $b->name ?>
                            </div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                    <p class="text-white"><?php echo $b->text ?></p>
                                    <footer class="blockquote-footer text-white"><cite title="Source Title"><?php echo $person->name ?></cite></footer>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            break;
        case 'deleteBlog':
            $id = $_POST['id'];
            $sql = "DELETE FROM blog where id='$id'";
            Globals::$database->getResult($sql);
            break;


    }


}
