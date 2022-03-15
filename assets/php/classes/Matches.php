<?php


class Matches
{

    public int $id_match;
    public ?Team $home_team;
    public ?Team $guest_team;
    public int $score_home;
    public int $score_guest;
    public string $date_time;
    public int $round;
    private Database $database;

    /**
     * Matches constructor.
     * @param string[]|null $row
     * @param Database $database
     */
    public function __construct(array $row, Database $database)
    {
        $this->database = $database;
        $this->id_match = $row['id_match'];
        $this->round = $row['round'];
        $this->home_team = $this->database->getTeam_ID($row['id_home_team']);
        $this->guest_team = $this->database->getTeam_ID($row['id_guest_team']);
        $this->score_home = $row['score_home'];
        $this->score_guest = $row['score_guest'];
        $this->date_time = $row['date_time'];

    }

    public function getScore() {
        return $this->score_home . ':' . $this->score_guest;
    }

    public function isDraw () {
        return $this->score_guest == $this->score_home;
    }

    public function isHomeTeamWin() {
        return $this->score_home > $this->score_guest;
    }
    public function isGuestTeamWin() {
        return $this->score_home < $this->score_guest;
    }

    public function getTotalPPG() {
        return $this->getHomePPG() + $this->getAwayPPG();
    }

    public function getHomePPG():float {
        $id_home_team = $this->home_team->id;
        $sql= "SELECT *, round(sum(if(`match`.score_home > `match`.score_guest,3, if(score_home = score_guest,1,0))) / count(*),2) as ppg FROM `match` JOIN team ON(id_home_team = id_team)
        where id_home_team = '$id_home_team' and `match`.date_time > date('2020-09-01') and `match`.date_time < '$this->date_time'";
        $result = $this->database->getResult($sql);

        while($row = mysqli_fetch_assoc($result)) {
            return $row['ppg'] == null ? 0 : $row['ppg'];
        }

        return 0;
    }

    public function getAwayPPG():float {
        $id_guest_team = $this->guest_team->id;
        $sql= "SELECT *, round(sum(if(`match`.score_guest > `match`.score_home,3, if(score_home = score_guest,1,0))) / count(*),2) as ppg FROM `match` JOIN team ON(id_guest_team = id_team)
                where id_guest_team = '$id_guest_team' and `match`.date_time > date('2020-09-01') and `match`.date_time < '$this->date_time'";
        $result = $this->database->getResult($sql);

        while($row = mysqli_fetch_assoc($result)) {
            return $row['ppg'] == null ? 0 : $row['ppg'];
        }
        return 0;
    }

}