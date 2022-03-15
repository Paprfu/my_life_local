<?php


class Bet
{
    public int $id;
    public ?Matches $match;
    public float $home_win_rate;
    public float $home_win_draw_rate;
    public float $guest_win_rate;
    public float $guest_win_draw_rate;
    public float $draw_rate;
    public ?BetAgency $betAgency;
    public float $home_ppg;
    public float $away_ppg;
    private Database $database;

    public function __construct(array $row, \Database $database)
    {
        $this->database = $database;
        $this->id = $row['id_bet'];
        $this->match = $this->database->getMatch_ID($row['id_match']);
        $this->home_win_rate = $row['home_win_rate'];
        $this->home_win_draw_rate = $row['home_win_draw_rate'];

        $this->guest_win_rate = $row['guest_win_rate'];
        $this->guest_win_draw_rate = $row['guest_win_draw_rate'];

        $this->draw_rate = $row['draw_rate'];
        $this->betAgency = $this->database->getBetAgency_ID($row['id_bet_agency']);
        $this->home_ppg = $row['home_ppg'];
        $this->away_ppg = $row['away_ppg'];
    }

    public function getHomeWinSurpriseLevel(): float
    {
        $awayppg = $this->away_ppg == null ? $this->match->getAwayPPG() : $this->away_ppg;
        $homeppg = $this->home_ppg == null ? $this->match->getHomePPG() : $this->home_ppg;
        $totalppg = $awayppg + $homeppg;
        if($awayppg == null || $awayppg == -1)
            return -1;
        if($homeppg == null || $homeppg == -1)
            return -1;
        return round(($awayppg / $totalppg) * 100, 2);
    }

    public function getAwayWinSurpriseLevel(): float
    {
        $awayppg = $this->away_ppg == null ? $this->match->getAwayPPG() : $this->away_ppg;
        $homeppg = $this->home_ppg == null ? $this->match->getHomePPG() : $this->home_ppg;
        $totalppg = $awayppg + $homeppg;
        return round(($homeppg / $totalppg) * 100, 2);
    }

    public function getDrawSurpriseLevel(): float
    {
        $awayppg = $this->away_ppg == null ? $this->match->getAwayPPG() : $this->away_ppg;
        $homeppg = $this->home_ppg == null ? $this->match->getHomePPG() : $this->home_ppg;
        $totalppg = $awayppg + $homeppg;
        $difference = abs($awayppg - $homeppg);
        return round(($difference / $totalppg) * 100, 2);
    }


}