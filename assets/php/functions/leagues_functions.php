<?php


if(isset($_POST['add-league-button'])) {
    $name = $_POST['name-league-input'];
    $start = $_POST['start-date-input'];
    $end = $_POST['end-date-input'];

    $sql = "INSERT INTO league (name , start_date, end_date) values ('$name', '$start', '$end')";
    Globals::$database->getResult($sql);
    header('location: leagues.php');
    exit();
}


function showLeagueInTable(League $league, int $number)
{
    ?>
    <td>
        <?php echo $number ?>
    </td>
    <td>
        <a href="league.php?league=<?php echo $league->id ?>" class="lni-link"><?php echo $league->name ?></a>
    </td>
    <td>
        <?php echo $league->start ?>
    </td>
    <td>
        <?php echo $league->end ?>
    </td>
    <td>
        <div class="btn-group dropdown">
            <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
               data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item"
                   onclick="editLeague(<?php echo $league->id ?>)"><i
                            class="lni-pencil-alt mr-2 text-gray"></i>Upraviť</a>
                <a class="dropdown-item"
                   onclick="deleteLeague(<?php echo $league->id ?>)"><i
                            class="lni-trash mr-2 text-gray"></i>Vymazať</a>

            </div>
        </div>
    </td>

    <?php
}

function showLeagueInTableToEdit(League $league, int $number)
{
    ?>
    <td>
        <?php echo $number ?>
    </td>
    <td>
        <label for="name-league-input"></label>
        <input id="name-league-input" class="form-control" type="text" value="<?php echo $league->name ?>">
    </td>
    <td>
        <label for="start-date-league-input"></label>
        <input id="start-date-league-input" class="form-control"
               value="<?php $date = new DateTime($league->start);
               echo $date->format('Y-m-d') ?>" type="date">
    </td>
    <td>
        <label for="end-date-league-input"></label>
        <input id="end-date-league-input" class="form-control" value="<?php $date = new DateTime($league->end);
        echo $date->format('Y-m-d') ?>" type="date">
    </td>
    <td>
        <div class="btn-group dropdown">
            <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
               data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item"
                   onclick="saveLeague(<?php echo $league->id ?>)"><i
                            class="lni-save-alt mr-2 text-gray"></i>Uložiť</a>

            </div>
        </div>
    </td>

    <?php
}

