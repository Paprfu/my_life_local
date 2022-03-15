<?php


class Team
{
    public int $id;
    public string $name;
    private ?Database $database;

    /**
     * Team constructor.
     * @param string[]|null $row
     * @param Database $param
     */
    public function __construct(array $row, \Database $param)
    {
        $this->id = $row['id_team'];
        $this->name = $row['name'];
        $this->database = $param;
    }


    public function getNumberOfGoals()
    {
        $sql = "SELECT sum(if(id_team = id_guest_team,score_guest,score_home)) as goals FROM `match` JOIN team on(id_guest_team= id_team || `match`.id_home_team = id_team) WHERE id_team = '$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['goals'];
        }
        return -1;
    }

    public function getNumberOfConcededGoals()
    {
        $sql = "SELECT sum(if(id_team = id_guest_team,score_home,score_guest)) as goals FROM `match` JOIN team on(id_guest_team= id_team || `match`.id_home_team = id_team) WHERE id_team = '$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['goals'];
        }
        return -1;
    }

    public function getNumberOfLosses()
    {
        $sql = "SELECT sum(if((id_team = id_home_team and score_home < score_guest),1,if(id_team = id_guest_team and score_home > score_guest,1,0))) as losses FROM `match` JOIN team on(id_guest_team= id_team || `match`.id_home_team = id_team) WHERE id_team = '$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['losses'];
        }
        return -1;
    }

    public function getNumberOfPoints()
    {
        return $this->getNumberOfWins() * 3 + $this->getNumberOfDraws();
    }

    public function getNumberOfWins()
    {
        $sql = "SELECT sum(if(id_team = id_home_team & score_home > score_guest,1,if(id_team = id_guest_team & score_home < score_guest,1,0))) as wins FROM `match` JOIN team on(id_guest_team= id_team || `match`.id_home_team = id_team) WHERE id_team = '$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['wins'];
        }
        return -1;
    }

    public function getNumberOfDraws()
    {
        $sql = "SELECT sum(if((id_team = id_home_team && score_home = score_guest) || 
                (id_team = id_guest_team && score_home = score_guest),1,0)) as draws 
                FROM `match` JOIN team on(id_guest_team= id_team || `match`.id_home_team = id_team) 
                WHERE id_team = '$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['draws'];
        }
        return -1;
    }

    public function getPPG()
    {
        $sql = "SELECT *, round((sum(if(id_home_team = id_team and score_home > `match`.score_guest,3, if(score_home = score_guest,1,if(id_team = id_guest_team and score_home < `match`.score_guest,3,0))))) / count(*), 2) as ppg FROM `match` JOIN team ON(id_guest_team = id_team || `match`.id_home_team=id_team)
            where id_team = '$this->id' and `match`.date_time > date('2020-09-01') and `match`.date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['ppg'];
        }
        return -1;
    }

    public function getHomePPG()
    {
        $sql = "SELECT *, round(sum(if(`match`.score_home > `match`.score_guest,3, if(score_home = score_guest,1,0))) / count(*),2) as ppg FROM `match` JOIN team ON(id_home_team = id_team)
        where id_home_team = '$this->id' and `match`.date_time > date('2020-09-01') and `match`.date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['ppg'];
        }
        return -1;
    }

    public function getAwayPPG()
    {
        $sql = "SELECT *, round(sum(if(`match`.score_guest > `match`.score_home,3, if(score_home = score_guest,1,0))) / count(*),2) as ppg FROM `match` JOIN team ON(id_guest_team = id_team)
                where id_guest_team = '$this->id' and `match`.date_time > date('2020-09-01') and `match`.date_time < CURRENT_TIMESTAMP;";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['ppg'];
        }
        return -1;
    }

    public function getMatchesWins_League(int $id_league): array
    {
        $matches = array();
        $sql = "select * from `match` join team on(id_team = id_home_team || team.id_team = id_guest_team) 
                   where id_team='$this->id' and ((id_team = id_home_team and score_home > `match`.score_guest) 
                                                  || (id_team = id_guest_team 
                    and `match`.score_home < `match`.score_guest)) and id_league='$id_league'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($matches, new Matches($row, $this->database));
        }
        return $matches;
    }

    public function getMatchesDraws_League(int $id_league): array
    {
        $matches = array();
        $sql = "select * from `match` join team 
                on(id_team = id_home_team || team.id_team = id_guest_team) 
                where id_team='$this->id'
                and score_home = score_guest 
                and id_league='$id_league'
                and date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($matches, new Matches($row, $this->database));
        }
        return $matches;
    }

    public function getMatchesLosses_League(int $id_league): array
    {
        $matches = array();
        $sql = "select * from `match` join team on(id_team = id_home_team || team.id_team = id_guest_team) 
                   where id_team='$this->id' 
                     and ((id_team = id_home_team 
                    and score_home < `match`.score_guest) 
                    || (id_team = id_guest_team 
                    and `match`.score_home > `match`.score_guest)) 
                     and id_league='$id_league' 
                     and id_team='$this->id' and date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($matches, new Matches($row, $this->database));
        }
        return $matches;
    }

    public function getScore_League($id_league)
    {
        $sql = "select sum(if(id_team = id_home_team, score_home, if(id_team = id_guest_team, score_guest,0))) as goals, 
                sum(if(id_team != `match`.id_home_team, score_home, if(id_team !=`match`.id_guest_team, score_guest,0) )) as goals_conceded
                from `match` join team on(id_team = id_home_team || id_team = id_guest_team) 
                where id_team='$this->id' and id_league='$id_league' and date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['goals'] . ':' . $row['goals_conceded'];
        }
        return -1;
    }

    public function getPoints_League($id_league)
    {
        $sql = "select sum(if(id_team = id_home_team and score_home > `match`.score_guest, 3, if(score_home = score_guest,1, if(id_team = id_guest_team and score_home < `match`.score_guest, 3, 0)))) as goals 
                from `match` join team on(id_team = id_home_team || id_team = id_guest_team) 
                where id_team='$this->id' and id_league='$id_league' and date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['goals'];
        }
        return -1;
    }


    public function getMatches_League(int $id_league): array
    {
        $matches = array();
        $sql = "select * from `match` join team on(id_team = id_home_team || team.id_team = id_guest_team) 
                   where id_team='$this->id' 
                    and id_league='$id_league' and id_team='$this->id' and date_time < CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($matches, new Matches($row, $this->database));
        }
        return $matches;
    }


}