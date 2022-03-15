<?php

include_once ('BetOperations.php');

use assets\php\classes\Bet;
use assets\php\classes\BetOperations;

class League implements BetOperations
{

    public $id;
    public $name;
    public $start;
    public $end;
    private $database;

    public function __construct($row, $database) {
        $this->id = $row['id_league'];
        $this->name = $row['name'];
        $this->start = $row['start_date'];
        $this->end = $row['end_date'];
        $this->database = $database;
    }


    public function getBets(): array
    {
        $bets = array();
        $result = $this->database->getResult("SELECT * FROM bet JOIN `match` USING(id_match) WHERE id_league='$this->id' order by date_time desc");
        while($row = mysqli_fetch_assoc($result)) {
            array_push($bets, new Bet($row, $this->database));
        }
        return $bets;
    }

    public function getMatches(): array {
        $matches = array();
        $sql= "select * from `match` join league using(id_league) where id_league='$this->id' order by date_time desc ";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($matches, new Matches($row, $this->database));
        }
        return $matches;
    }

    public function getMatchesPlayed(): array {
        $matches = array();
        $sql= "select * from `match` join league using(id_league) where id_league='$this->id' and date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($matches, new Matches($row, $this->database));
        }
        return $matches;
    }

    public function getMatchesUnplayed(): array {
        $matches = array();
        $sql= "select * from `match` join league using(id_league) where id_league='$this->id' and date_time > CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($matches, new Matches($row, $this->database));
        }
        return $matches;
    }

    public function getTeams(): array
    {
        $teams = array();
        $sql= "select * from team join league_team using(id_team) where id_league='$this->id' order by name";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($teams, new Team($row, $this->database));
        }
        return $teams;
    }

    public function getNextRound() {
        $sql = "select max(round) as round from `match` join league using(id_league) where id_league='$this->id'";
        $round =  mysqli_fetch_assoc($this->database->getResult($sql))['round'];
        $sql= "select count(*) as matches from `match` join league using(id_league) where id_league='$this->id' and round='$round'";
        $count = mysqli_fetch_assoc($this->database->getResult($sql))['matches'];
        $teams = $this->getTeams();
        if($count >= count($teams) / 2)
            return $round + 1;
        return $round;
    }


    public function getTeams_OrderBy_Points() {
        $teams = array();
        $sql = "select team.id_team as id_team, team.name as name, 
                sum(if(id_team = id_home_team and score_home > `match`.score_guest,3, 
                    if(id_team = id_guest_team and score_guest > `match`.score_home, 3, 
                    if(score_home = score_guest,1,0)))) as points 
                from team 
                join `match` on(id_team = id_home_team || `match`.id_guest_team = id_team) 
                join league using(id_league)
                where id_league='$this->id' and `match`.date_time < CURRENT_TIMESTAMP 
                group by id_team 
                order by points desc ";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($teams, new Team($row, $this->database));
        }
        return $teams;


    }
}