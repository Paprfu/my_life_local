<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Breadcrumb Start -->
            <div class="breadcrumb-wrapper row">
                <div class="col-12 col-lg-3 col-md-6">
                    <h4 class="page-title">Blog</h4>
                </div>
                <div class="col-12 col-lg-9 col-md-6">
                    <ol class="breadcrumb float-right">
                        <li><a href="?page=user">User</a></li>
                        <li class="active">/ Blogs</li>
                    </ol>
                </div>
            </div>
            <!-- Breadcrumb End -->
        </div>

        <div class="container-fluid">
            <div id="blogs" class="row">
                <?php
                $blogs = Globals::$person->getBlogs();
                $number = 0;
                foreach ($blogs as $b) {

                    if ($b->type == 'blog') {
                        ?>
                        <div id="blog-<?php echo $b->id ?>" class="col-lg-4 col-md-6 col-xl-4">
                            <div class="card bg-dark">
                                <?php
                                if ($number % 2 == 0) {
                                    ?>
                                    <img class="img-fluid"
                                         src="assets/php/ajax/blogs/<?php echo Globals::$user->id . '/' . $b->photo ?>"
                                         alt="">
                                    <?php
                                }
                                ?>
                                <div class="card-body">
                                    <div class="card-toolbar">
                                        <ul>
                                            <li>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false"><i class="lni-more-alt"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-166px, -50px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a class="dropdown-item" onclick="deleteBlog(<?php echo $b->id ?>)"><i class="lni-trash mr-2 text-gray"></i>Delete</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <h5 class="card-title text-white"><?php echo $b->name ?></h5>

                                    <p class="text-white"><?php echo $b->text ?></p>
                                    <a href="index.php?blog=<?php echo $b->id ?>" class="btn btn-common float-left">Read
                                        more</a>

                                </div>
                                <?php
                                if ($number % 2 == 1) {
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
                    } else if ($b->type == 'quote') {
                        ?>

                        <div id="blog-<?php echo $b->id ?>" class="col-lg-4 col-md-6 col-xl-4">
                            <div class="card bg-dark">
                                <div class="card-header text-white">
                                    Quote - <?php echo $b->name ?>
                                    <div class="card-toolbar">
                                        <ul>
                                            <li>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);" class="dropdown-toggle arrow-none" data-toggle="dropdown" aria-expanded="false"><i class="lni-more-alt"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-166px, -50px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                        <a class="dropdown-item" onclick="deleteBlog(<?php echo $b->id ?>)"><i class="lni-trash mr-2 text-gray"></i>Vymazať</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <blockquote class="blockquote mb-0">
                                        <p class="text-white"><?php echo $b->text ?></p>
                                        <footer class="blockquote-footer text-white"><cite
                                                title="Source Title"><?php echo Globals::$person->name ?></cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>

            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-dark">
                        <div class="card-header border-bottom">
                            <h4 class="card-title text-white">Add blog</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="text-white" for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Name">
                            </div>

                            <div class="form-group">
                                <label class="text-white" for="type">Type</label>
                                <select class="form-control" id="type">
                                    <option value="blog">Blog</option>
                                    <option value="quote">Quote</option>
                                    <option value="thought">Idea</option>
                                    <option value="href">Link</option>

                                </select>
                            </div>                                                 p
                            <div class="form-group">
                                <label class="text-white">iMAGE</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file">
                                    <label class="custom-file-label form-control" for="file">Select file</label>
                                </div>
                            </div>
                            <div class="form-group m-b-20">
                                <label class="text-white" for="text">Text</label>
                                <textarea class="form-control" id="text" rows="4"></textarea>
                            </div>
                            <button onclick="createBlog(<?php echo Globals::$user->id ?>)" class="btn btn-common mr-3">Add
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>