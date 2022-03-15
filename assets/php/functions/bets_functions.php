<?php
include_once('../server.php');

use assets\php\classes\Bet;
use assets\php\classes\BetAnalysis;
use assets\php\classes\MyBet;


function showMyBetInTable(MyBet $bet, int $number)
{
    ?>

    <td>
        <?php echo $number ?>
    </td>
    <td>
        <?php echo $bet->match->home_team->name . ' - ' . $bet->match->guest_team->name ?>
    </td>
    <td>
        <?php echo $bet->match->getScore() ?>
    </td>

    <?php
    $class = "";
    if ($bet->match->score_home > $bet->match->score_guest)
        $class = 'alert-success text-dark ';
    else
        $class = 'alert-danger text-dark';
    if ($bet->type == -2 && $bet->match->date_time > Globals::$today)
        $class .= ' border border-primary';
    ?>
    <td class="<?php echo $class ?>">
        <?php echo $bet->home_win_rate ?>
    </td>

    <?php
    $class = "";
    if ($bet->match->score_home >= $bet->match->score_guest)
        $class = 'alert-success text-dark';
    else
        $class = 'alert-danger text-dark';
    if ($bet->type == -1 && $bet->match->date_time > Globals::$today)
        $class .= ' border border-primary';
    ?>
    <td class="<?php echo $class ?>">
        <?php echo $bet->home_win_draw_rate ?>
    </td>
    <?php
    $class = "";
    if ($bet->match->score_home == $bet->match->score_guest)
        $class = 'alert-success text-dark';
    else
        $class = 'alert-danger text-dark';
    if ($bet->type == 0 && $bet->match->date_time > Globals::$today)
        $class .= ' border border-primary';
    ?>

    <td class="<?php echo $class ?>">
        <?php echo $bet->draw_rate ?>

    </td>
    <?php
    $class = "";
    if ($bet->match->score_home <= $bet->match->score_guest)
        $class = 'alert-success text-dark';
    else
        $class = 'alert-danger text-dark';
    if ($bet->type == 1 && $bet->match->date_time > Globals::$today)
        $class .= ' border border-primary';
    ?>
    <td class="<?php echo $class ?>">
        <?php echo $bet->guest_win_draw_rate ?>

    </td>
    <?php
    $class = "";
    if ($bet->match->score_home < $bet->match->score_guest)
        $class = 'alert-success text-dark';
    else
        $class = 'alert-danger text-dark';
    if ($bet->type == 2 && $bet->match->date_time > Globals::$today)
        $class .= ' border border-primary';
    ?>
    <td class="<?php echo $class ?>">
        <?php echo $bet->guest_win_rate ?>

    </td>
    <td>
        <?php
        if ($bet->match->date_time > Globals::$today)
            echo 0;
        else if ($bet->match->score_home > $bet->match->score_guest && $bet->type == -2)
            echo $bet->value * $bet->home_win_rate;
        else if ($bet->match->score_home >= $bet->match->score_guest && $bet->type == -1)
            echo $bet->value * $bet->home_win_draw_rate;
        else if ($bet->match->score_home == $bet->match->score_guest && $bet->type == 0)
            echo $bet->value * $bet->draw_rate;
        else if ($bet->match->score_home <= $bet->match->score_guest && $bet->type == 1)
            echo $bet->value * $bet->guest_win_draw_rate;
        else if ($bet->match->score_home < $bet->match->score_guest && $bet->type == 2)
            echo $bet->value * $bet->guest_win_rate;
        else
            echo -1 * $bet->value;
        echo "€";

        ?>
    </td>
    <td>
        <?php echo $bet->match->date_time ?>
    </td>
    <td>
        <div class="btn-group dropdown">
            <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
               data-toggle="dropdown" aria-expanded="false"><i
                        class="lni-more-alt"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item"
                   onclick="editMyBet(<?php echo $bet->id ?>)"><i
                            class="lni-pencil-alt mr-2 text-gray"></i>Upraviť</a>
                <a class="dropdown-item"
                   onclick="deleteMyBet(<?php echo $bet->id ?>)"><i
                            class="lni-trash mr-2 text-gray"></i>Vymazať</a>

            </div>
        </div>
    </td>
    <?php
}

function showBetInTable(Bet $bet, int $number)
{
    ?>
    <tr>
        <td>
            <?php echo $number ?>
        </td>
        <td>
            <?php echo $bet->match->home_team->name . ' - ' . $bet->match->guest_team->name ?>
        </td>
        <td>
            <?php echo $bet->match->getScore() ?>
        </td>

        <?php
        $class = "";
        if ($bet->match->date_time >= Globals::$today)
            $class = "";
        else if ($bet->match->score_home > $bet->match->score_guest)
            $class = 'alert-success text-dark';
        ?>
        <td class="<?php echo $class ?>">
            <?php echo $bet->home_win_rate ?>
        </td>

        <?php
        $class = "";
        if ($bet->match->date_time >= Globals::$today)
            $class = "";
        else if ($bet->match->score_home >= $bet->match->score_guest)
            $class = 'alert-success text-dark';
        ?>
        <td class="<?php echo $class ?>">
            <?php echo $bet->home_win_draw_rate ?>
        </td>
        <?php
        $class = "";
        if ($bet->match->date_time >= Globals::$today)
            $class = "";
        else if ($bet->match->score_home == $bet->match->score_guest)
            $class = 'alert-success text-dark';
        ?>
        <td class="<?php echo $class ?>">
            <?php echo $bet->draw_rate ?>

        </td>
        <?php
        $class = "";
        if ($bet->match->date_time >= Globals::$today)
            $class = "";
        else if ($bet->match->score_home <= $bet->match->score_guest)
            $class = 'alert-success text-dark';
        ?>
        <td class="<?php echo $class ?>">
            <?php echo $bet->guest_win_draw_rate ?>

        </td>
        <?php
        $class = "";
        if ($bet->match->date_time >= Globals::$today)
            $class = "";
        else if ($bet->match->score_home < $bet->match->score_guest)
            $class = 'alert-success text-dark';
        ?>
        <td class="<?php echo $class ?>">
            <?php echo $bet->guest_win_rate ?>

        </td>
        <td>
            <?php echo $bet->match->date_time;
            ?>
        </td>
        <td>
            <?php echo $bet->match->home_team->getHomePPG();
            ?>
        </td>
        <td>
            <?php echo $bet->match->guest_team->getAwayPPG();
            ?>
        </td>
        <td>
            <?php echo $bet->getAwayWinSurpriseLevel();
            ?>
        </td>
        <td>
            <?php echo $bet->getDrawSurpriseLevel();
            ?>
        </td>
        <td>
            <?php echo $bet->match->round ?>
        </td>
    </tr>

    <?php
}

function showBetAnalysisInTable(BetAnalysis $bet, int $number)
{
    ?>
    <tr>
        <td>
            <?php echo $number ?>
        </td>
        <td>
            <?php echo $bet->author->name ?>
        </td>
        <td>
            <?php echo $bet->reliance ?>
        </td>

        <td>
            <?php echo $bet->rate;
            ?>
        </td>
        <td>
            <?php echo $bet->match;
            ?>
        </td>
        <td>
            <?php echo $bet->type;
            ?>
        </td>
        <td>
            <?php echo $bet->sport;
            ?>
        </td>
        <td>
            <?php echo $bet->datetime;
            ?>
        </td>
        <td>
            <?php echo $bet->winnable ?>
        </td>
        <td>
            <div class="btn-group dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle arrow-none"
                   data-toggle="dropdown" aria-expanded="false"><i
                            class="lni-more-alt"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"
                       onclick="setBetAnalysisWinnable(true)"><i
                                class="lni-pencil-alt mr-2 text-gray"></i>Výherný</a>
                    <a class="dropdown-item"
                       onclick="setBetAnalysisWinnable(false)"><i
                                class="lni-trash mr-2 text-gray"></i>Nevýherný</a>

                </div>
            </div>
        </td>
    </tr>

    <?php
}

if (isset($_POST['add-bet-button'])) {
    $id_match = $_POST['match-select'];
    $home_win_rate = $_POST['home-win-rate-input'];
    $home_win_draw_rate = $_POST['home-win-draw-rate-input'];
    $draw_rate = $_POST['draw-rate-input'];
    $guest_win_draw_rate = $_POST['guest-win-draw-rate-input'];
    $guest_win_rate = $_POST['guest-win-rate-input'];
    $id_bet_agency = $_POST['bet-agency-select'];
    $home_ppg = null;
    if (isset($_POST['home-ppg-input']))
        $home_ppg = $_POST['home-ppg-input'];
    $away_ppg = null;
    if (isset($_POST['away-ppg-input']))
        $away_ppg = $_POST['away-ppg-input'];
    $sql = "INSERT INTO bet (id_match, home_win_rate, home_win_draw_rate, draw_rate, guest_win_draw_rate, guest_win_rate, id_bet_agency)
            values ('$id_match', '$home_win_rate', '$home_win_draw_rate', '$draw_rate', '$guest_win_draw_rate' ,'$guest_win_rate', '$id_bet_agency')";
    $result = Globals::$database->getResult($sql);
    header('location: bets.php');
    exit();

}

if (isset($_POST['add-my-bet-button'])) {
    $id_bet = $_POST['bet-select'];
    $value = $_POST['value-input'];
    $type = $_POST['type-select'];
    $id_person = Globals::$person->id;
    $sql = "INSERT INTO bet_person (id_bet, id_person, value, type)
            values ('$id_bet', '$id_person', '$value', '$type')";
    $result = Globals::$database->getResult($sql);
    header('location: person_bets.php');
    exit();

}


function getHomeWinSurpriseLevel($awayppg, $homeppg)
{
    $totalppg = $awayppg + $homeppg;
    return round(($awayppg / $totalppg) * 100, 2);
}

function getAwayWinSurpriseLevel($awayppg, $homeppg)
{
    $totalppg = $awayppg + $homeppg;
    return round(($homeppg / $totalppg) * 100, 2);
}

function getDrawSurpriseLevel($awayppg, $homeppg)
{
    $totalppg = $awayppg + $homeppg;
    $difference = abs($awayppg - $homeppg);
    return round(($difference / $totalppg) * 100, 2);
}

function showBetPredictionResult($revenue)
{
    if ($revenue > 0)
        echo "<span class='badge badge-success'>$revenue</span>";
    else if ($revenue == 0)
        echo "<span class='badge badge-warning'>$revenue</span>";
    else if ($revenue < 0)
        echo "<span class='badge badge-danger'>$revenue</span>";


}

function showPredictionBetInTable(Bet $bet, int $number, array $predicitons)
{
    if ($number == 1) {
        ?>
        <thead>
        <tr>
            <th>#</th>
            <th>Zápas</th>
            <th>Skóre</th>
            <?php
            if (in_array('win', $predicitons))
                echo "<th>1</th>";

            if (in_array('win', $predicitons) || in_array('draw', $predicitons))
                echo " <th>X1</th>";

            if (in_array('draw', $predicitons))
                echo " <th>0</th>";

            if (in_array('lose', $predicitons) || in_array('draw', $predicitons))
                echo " <th>X2</th>";

            if (in_array('lose', $predicitons))
                echo " <th>2</th>";
            ?>
            <th>PPG doma</th>
            <th>PPG von</th>
            <th>Domaci prehrajú Surprise-level</th>
            <th>Remíza Surprise-level</th>
        </tr>
        </thead>
        <tbody>
        <?php
    }

    ?>
    <tr>
        <td>
            <?php echo $number ?>
        </td>
        <td>
            <?php echo $bet->match->home_team->name . ' - ' . $bet->match->guest_team->name ?>
        </td>
        <td>
            <?php echo $bet->match->getScore() ?>
        </td>

        <?php
        $class = "";
        if (in_array('win', $predicitons)) {
            $type = -2;
            if ($bet->match->date_time >= Globals::$today)
                $class = "";
            else if ($bet->match->score_home > $bet->match->score_guest)
                $class = 'alert-success text-dark';
            ?>
            <td class="<?php echo $class ?>">
                <?php echo $bet->home_win_rate ?>
            </td>

            <?php
        }
        if (in_array('win', $predicitons) || in_array('draw', $predicitons)) {
            $type = -1;
            $class = "";
            if ($bet->match->date_time >= Globals::$today)
                $class = "";
            else if ($bet->match->score_home >= $bet->match->score_guest)
                $class = 'alert-success text-dark';
            ?>
            <td class="<?php echo $class ?>">
                <?php echo $bet->home_win_draw_rate ?>
            </td>
            <?php
        }
        if (in_array('draw', $predicitons)) {
            $type = 0;
            $class = "";
            if ($bet->match->date_time >= Globals::$today)
                $class = "";
            else if ($bet->match->score_home == $bet->match->score_guest)
                $class = 'alert-success text-dark';
            ?>
            <td class="<?php echo $class ?>">
                <?php echo $bet->draw_rate ?>

            </td>
            <?php
        }
        if (in_array('draw', $predicitons) || in_array('lose', $predicitons)) {
            $class = "";
            $type = 1;
            if ($bet->match->date_time >= Globals::$today)
                $class = "";
            else if ($bet->match->score_home <= $bet->match->score_guest)
                $class = 'alert-success text-dark';
            ?>
            <td class="<?php echo $class ?>">
                <?php echo $bet->guest_win_draw_rate ?>

            </td>
            <?php
        }
        if (in_array('lose', $predicitons)) {
            $type = 2;
            $class = "";
            if ($bet->match->date_time >= Globals::$today)
                $class = "";
            else if ($bet->match->score_home < $bet->match->score_guest)
                $class = 'alert-success text-dark';
            ?>
            <td class="<?php echo $class ?>">
                <?php echo $bet->guest_win_rate ?>

            </td>
            <?php
        }
        ?>


        <td>
            <?php echo $bet->match->home_team->getHomePPG();
            ?>
        </td>
        <td>
            <?php echo $bet->match->guest_team->getAwayPPG();
            ?>
        </td>
        <td>
            <?php echo $bet->getAwayWinSurpriseLevel();
            ?>
        </td>
        <td>
            <?php echo $bet->getDrawSurpriseLevel();
            ?>
        </td>
        <td>
            <?php


            if ($bet->match->date_time > Globals::$today)
                echo 0;
            else if ($bet->match->score_home > $bet->match->score_guest && $type == -2)
                echo $bet->home_win_rate;
            else if ($bet->match->score_home >= $bet->match->score_guest && $type == -1)
                echo $bet->home_win_draw_rate;
            else if ($bet->match->score_home == $bet->match->score_guest && $type == 0)
                echo $bet->draw_rate;
            else if ($bet->match->score_home <= $bet->match->score_guest && $type == 1)
                echo $bet->guest_win_draw_rate;
            else if ($bet->match->score_home < $bet->match->score_guest && $type == 2)
                echo $bet->guest_win_rate;
            else
                echo -1;
            echo "€";

            ?>
        </td>

    </tr>

    <?php
}

?>
