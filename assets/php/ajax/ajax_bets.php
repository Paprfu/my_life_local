<?php

include_once('../server.php');
include_once('../functions/bets_functions.php');
if (isset($_POST['method'])) {
    switch ($_POST['method']) {
        case 'changeBetRates':
            $id_bet = $_POST['id_bet'];
            $bet = Globals::$database->getBet_ID($id_bet);
            if ($bet == null) {
                echo "<div class='alert-danger'>Stávka nebola nájdená</div>";
                return;
            }
            ?>
            <div class='form-group row'>
                <div class="form-group">
                    <label for="home-win-rate-input"
                           class='col-sm-1 text-white'>
                        1</label>
                    m
                    <div id="home-win-rate-input" class="badge badge-outline-success">
                        <?php echo $bet->home_win_rate ?>
                    </div>
                </div>
                <div class="form-group">

                    <label for="home-win-draw-rate-badge"
                           class='col-sm-1 col-form-label control-label text-white'>
                        X1</label>

                    <div id="home-win-rate-badge" class="badge badge-outline-info">
                        <?php echo $bet->home_win_draw_rate ?>
                    </div>
                </div>
                <div class="form-group">

                    <label for="draw-rate-input"
                           class='col-sm-1 text-white'>
                        X</label>

                    <div class="badge badge-outline-warning" id="draw-rate-input">
                        <?php echo $bet->draw_rate ?>
                    </div>

                </div>
                <div class="form-group">

                    <label for="guest-win-draw-rate-badge"
                           class='col-sm-1 text-white'>
                        X2</label>

                    <div id="guest-win-draw-rate-badge" class="badge badge-outline-info">
                        <?php echo $bet->guest_win_draw_rate ?>
                    </div>
                </div>
                <div class="form-group">

                    <label for="guest-win-rate-input"
                           class='col-sm-1 text-white'>
                        2</label>

                    <div class="badge badge-outline-success" id="guest-win-rate-badge">
                        <?php echo $bet->guest_win_rate ?>
                    </div>
                </div>
            </div>
            <?php
            break;
        case 'calculateSurpriseLevels':
            if (!isset($_POST['home_ppg']))
                return;
            $home_ppg = $_POST['home_ppg'];
            if (!isset($_POST['guest_ppg']))
                return;
            $guest_ppg = $_POST['guest_ppg'];
            $total_ppg = $home_ppg + $guest_ppg;
            $diff = abs($home_ppg - $guest_ppg);
            ?>
            <div class="text-info">
                <p>Víťazstvo domáceho
                    tímu: <?php echo '(' . $guest_ppg . '/' . $total_ppg . ')*100=' . getHomeWinSurpriseLevel($guest_ppg, $home_ppg) ?></p>
                <p>Víťazstvo hosťujúceho
                    tímu: <?php echo '(' . $home_ppg . '/' . $total_ppg . ')*100=' . getAwayWinSurpriseLevel($guest_ppg, $home_ppg) ?></p>
                <p>Remíza: <?php echo '(' . $diff . ')*100=' . getDrawSurpriseLevel($guest_ppg, $home_ppg) ?></p>
            </div>
            <?php
            break;
        case 'changePredictionResult':
            $bp = $_POST['bp'];
            $revenue = 0;
            switch ($bp) {
                case 1:
                    foreach (Globals::$database->getBets_Played() as $b) {
                        if ($b->match->isHomeTeamWin()) {
                            $revenue += ($b->home_win_rate) - 1;
                        } else {
                            $revenue += -1;
                        }
                    }
                    break;
                case 2:
                    foreach (Globals::$database->getBets_Played() as $b) {
                        if ($b->match->isDraw()) {
                            $revenue += ($b->draw_rate) - 1;
                        } else {
                            $revenue += -1;
                        }
                    }
                    break;
                case 3:
                    foreach (Globals::$database->getBets_Played() as $b) {
                        if ($b->match->isGuestTeamWin()) {
                            $revenue += ($b->guest_win_rate) - 1;
                        } else {
                            $revenue += -1;
                        }
                    }
                    break;
                case 4:
                    foreach (Globals::$database->getBets_Played() as $b) {
                        $surprise_level = $b->getDrawSurpriseLevel();
                        if ($surprise_level <= 30 && $surprise_level >= 0) {
                            if ($b->match->isDraw()) {
                                $revenue += ($b->draw_rate) - 1;
                            } else {
                                $revenue += -1;
                            }
                        }
                    }

                    break;
                case 5:
                    foreach (Globals::$database->getBets_Played() as $b) {
                        if ($b->getHomeWinSurpriseLevel() <= 70) {
                            $revenue += ($b->home_win_rate) - 1;
                        } else {
                            $revenue += -1;
                        }
                    }
                    break;
                case 6:
                    foreach (Globals::$database->getBets_Played() as $b) {
                        if ($b->getAwayWinSurpriseLevel() <= 70) {
                            $revenue += ($b->guest_win_rate) - 1;
                        } else {
                            $revenue += -1;
                        }
                    }
                    break;
            }
            showBetPredictionResult($revenue);
            break;
        case
        'showBetsWithPrediction':
            $bp = $_POST['bp'];
            $revenue = 0;
            $number = 1;
            ?>
            <div class="container-fluid">
                <div class="card bg-dark">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-white">Stávky pre predikciu</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm text-white">


                            <?php
                            switch ($bp) {

                                case 1:
                                    $predictions = array('win');
                                    foreach (Globals::$database->getBets_Played() as $b) {
                                        if ($b->match->isHomeTeamWin()) {
                                            showPredictionBetInTable($b, $number++, $predictions);
                                        }
                                    }
                                    break;
                                case 2:
                                    $predictions = array('draw');
                                    foreach (Globals::$database->getBets_Played() as $b) {
                                        if ($b->match->isDraw()) {
                                            showPredictionBetInTable($b, $number++, $predictions);
                                        }
                                    }
                                    break;
                                case 3:
                                    $predictions = array('lose');

                                    foreach (Globals::$database->getBets_Played() as $b) {
                                        if ($b->match->isGuestTeamWin()) {
                                            showPredictionBetInTable($b, $number++, $predictions);
                                        }
                                    }
                                    break;
                                case 4:
                                    $predictions = array('draw');

                                    foreach (Globals::$database->getBets_Played() as $b) {
                                        $suprise_level = $b->getDrawSurpriseLevel();
                                        if ($suprise_level <= 30 && $suprise_level >= 0) {
                                            showPredictionBetInTable($b, $number++, $predictions);
                                        }
                                    }
                                    break;
                                case 5:
                                    $predictions = array('win');

                                    foreach (Globals::$database->getBets_Played() as $b) {
                                        if ($b->getHomeWinSurpriseLevel() <= 70) {
                                            showPredictionBetInTable($b, $number++, $predictions);
                                        }
                                    }
                                    break;
                                case 6:
                                    $predictions = array('lose');

                                    foreach (Globals::$database->getBets_Played() as $b) {
                                        if ($b->getAwayWinSurpriseLevel() <= 70) {
                                            showPredictionBetInTable($b, $number++, $predictions);
                                        }
                                    }
                                    break;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php
            break;
        case 'showPPGInputs':
            $id_match = $_POST['id_match'];

            $match = Globals::$database->getMatch_ID($id_match);
            $league = $match->getLeague();
            if ($league->id == 0)
                echo 1;
            else
                echo 0;

            break;
        case 'createAuthor':
            $name = $_POST['name'];
            $sql = "insert into analysis_author(name) values ('$name')";
            $result = Globals::$database->getResult($sql);

            break;
        case 'createBetAnalysis':
            $author = $_POST['author'];
            $reliance = $_POST['reliance'];
            $rate = $_POST['rate'];
            $type = $_POST['type'];
            $sport = $_POST['sport'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $match = $_POST['match'];
            $sql = "INSERT INTO bet_analysis (id_author, reliance, rate, type, sport, datetime,`match`)
            values ('$author', '$reliance', '$rate', '$type', '$sport' ,'$date $time','$match')";
            Globals::$database->getResult($sql);
            break;
    }
}
