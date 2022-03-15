<!-- Side Nav START -->
<div class="side-nav expand-lg">
    <div class="side-nav-inner">
        <ul class="side-nav-menu">
            <li class="side-nav-header">
                <span>Menu</span>
            </li>

            <?php
                if(!isset($_GET['page']))
                    $menu = 'user';
                else
                    $menu = getActiveMenu($_GET['page']);
            ?>
            <li id="user-menu" class="nav-item dropdown <?php if($menu == 'user') echo 'open' ?>">
                <a href="#" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-user"></i>
                  </span>
                    <span class="title">User</span>
                    <span class="arrow">
                    <i class="lni-chevron-right"></i>
                  </span>
                </a>
                <ul class="dropdown-menu sub-down">
                    <li class="active">
                        <a href="?page=dashboard">Dashboard</a>
                    </li>

                    <li class="active">
                        <a href="?page=blogs">Blogs</a>
                    </li>

                    <li class="active">
                        <a href="?page=projects">Projects</a>
                    </li>
                    <li class="active">
                        <a href="?page=tasks">Tasks</a>
                    </li>
                    <li class="active">
                        <a href="?page=challenges">Challenges</a>
                    </li>
                    <li class="active">
                        <a href="?page=activity">Activity</a>
                    </li>
                </ul>
            </li>
            <li id='app-menu' class="nav-item dropdown <?php if($menu == 'apps') echo 'open' ?>">
                <a href="#" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-cloud"></i>
                  </span>
                    <span class="title">Apps</span>
                    <span class="arrow">
                    <i class="lni-chevron-right"></i>
                  </span>
                </a>
                <ul class="dropdown-menu sub-down">
                    <li class="active">
                        <a href="?page=calendar">Calendar</a>
                    </li>
                    <li class="active">
                        <a href="?page=chat">Chat</a>
                    </li>

                </ul>
            </li>
            <li id='education-menu' class="nav-item dropdown <?php if($menu == 'education') echo 'open' ?>">
                <a href="#" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-graduation"></i>
                  </span>
                    <span class="title">Education</span>
                    <span class="arrow">
                    <i class="lni-chevron-right"></i>
                  </span>
                </a>
                <ul class="dropdown-menu sub-down">
                    <li class="active">
                        <a href="?page=schools">Schools</a>
                    </li>
                    <li class="active">
                        <a href="?page=information">Information</a>
                    </li>


                </ul>
            </li>
            <li id='sport-menu' class="nav-item dropdown">
                <a href="#" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="lni-basketball"></i>
                  </span>
                    <span class="title">Sport</span>
                    <span class="arrow">
                    <i class="lni-chevron-right"></i>
                  </span>
                </a>
                <ul class="dropdown-menu sub-down">
                    <li class="active">
                        <a href="?page=leagues">Leagues</a>
                    </li>
                    <li class="active">
                        <a href="?page=teams">Teams</a>
                    </li>
                    <li class="active">
                        <a href="?page=matches">Matches</a>
                    </li>
                    <li class="active">
                        <a href="?page=bets">Bets</a>
                    </li>
                    <li class="active">
                        <a href="?page=person_bets">My_Bets</a>
                    </li>
                    <li class="active">
                        <a href="?page=bet_analysis">Analysis</a>
                    </li>

                </ul>
            </li>
            <?php
            if (isAdmin()) {
                ?>
	            <li id='admin-menu' class="nav-item dropdown <?php if($menu == 'admin') echo 'open' ?>">
		            <a href="#" class="dropdown-toggle">
                  <span class="icon-holder">
                    <i class="mdi mdi-account-star"></i>
                  </span>
			            <span class="title">Admin</span>
			            <span class="arrow">
                    <i class="lni-chevron-right"></i>
                  </span>
			            
                    </a>
                    <ul class="dropdown-menu sub-down">
                        <li><a href="?page=admin">Admin</a></li>
                        <li><a href="?page=icons">Icons</a></li>
	                    <li><a href="?page=streams">Streams</a></li>
                    </ul>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>
<!-- Side Nav END -->

