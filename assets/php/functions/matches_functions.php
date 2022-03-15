<?php

include_once('../server.php');
include_once('../functions.php');

if (isset($_POST['add-match-button'])) {
    $home_team = $_POST['home-team-select'];

    $guest_team = $_POST['guest-team-select'];

    $date = $_POST['date-input'];


    $time = $_POST['time-input'];


    $score_home = $_POST['score-home-input'];


    $score_guest = $_POST['score-guest-input'];

    $round = $_POST['round-input'];

    if(isset($_POST['league-input'])) {
           $id_league = $_POST['league-input'];
    }  else
        $id_league = 0;

    $sql = "INSERT INTO `match` (id_home_team, id_guest_team, score_home, score_guest, date_time, round, id_league) 
            VALUES ('$home_team', '$guest_team', '$score_home', '$score_guest', '$date $time', '$round', '$id_league')";
    Globals::$database->getResult($sql);
    if(isset($_POST['league-input'])) {
        header('location: league.php?league='.$id_league);
        exit();
    }

    header('location: matches.php');
    exit();
}

if (isset($_POST['add-team-button'])) {
    $team = $_POST['name-input'];

    $sql = "INSERT INTO `team` (name) 
            VALUES ('$team')";
    Globals::$database->getResult($sql);

}

if (isset($_POST['delete-match-button'])) {
    $id_match = $_POST['match-input'];

    $sql = "DELETE FROM `match` where id_match='$id_match'";
    Globals::$database->getResult($sql);

}


function showMatchInTable(Matches $match, int $number)
{
    ?>
    <td>
        <?php echo $number ?>
    </td>
    <td>
        <?php echo $match->home_team->name . ' - ' . $match->guest_team->name ?>
    </td>
    <td>
        <?php echo $match->score_home . ' - ' . $match->score_guest ?>
    </td>
    <td>
        <?php echo $match->date_time ?>
    </td>
    <td>
        <?php echo $match->round ?>
    </td>
    <td>
        <div class="btn-group dropdown">
            <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
               data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item"
                   onclick="editMatch(<?php echo $match->id_match ?>)"><i
                            class="lni-pencil-alt mr-2 text-gray"></i>Upraviť</a>
                <a class="dropdown-item"
                   onclick="deleteMatch(<?php echo $match->id_match ?>)"><i
                            class="lni-trash mr-2 text-gray"></i>Vymazať</a>

            </div>
        </div>
    </td>

    <?php
}


function showMatchInTableToEdit(Matches $match, int $number)
{
    ?>

    <td>
        <?php echo $number ?>
    </td>
    <td>
        <?php echo $match->home_team->name . ' - ' . $match->guest_team->name ?>
    </td>
    <td>

        <input id="score-home-input" class="form-control" value="<?php echo $match->score_home ?>" type="number">
        <input id="score-guest-input" class="form-control" value="<?php echo $match->score_guest ?>" type="number">


    </td>
    <td>

        <input id="date-input" class="form-control" value="<?php $date = new DateTime($match->date_time);
        echo $date->format('Y-m-d') ?>" type="date">
        <input id="time-input" class="form-control" value="<?php $date = new DateTime($match->date_time);
        echo $date->format('H:i') ?>" type="time">

    </td>
    <td>
        <div class="btn-group dropdown">
            <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
               data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item"
                   onclick="saveMatch(<?php echo $match->id_match ?>)"><i
                            class="lni-save-alt mr-2 text-gray"></i>Ulozit</a>

            </div>
        </div>
    </td>

    <?php
}