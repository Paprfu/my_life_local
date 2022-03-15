<?php

require_once ('User.php');
require_once ('Person.php');
require_once ('Project.php');
require_once ('PersonInfo.php');
require_once ('Task.php');
require_once ('Subject.php');
require_once ('CalendarEvent.php');
require_once ('Problem.php');
require_once ('Category.php');
require_once ('SchoolEvent.php');
require_once ('Link.php');
require_once ('Message.php');
require_once ('SET.php');
require_once ('Activity.php');
require_once ('Bet.php');
require_once ('BetAgency.php');
require_once ('BetAnalysis.php');
require_once ('Blog.php');


class Database
{
    public mysqli|null|false $db;


    public function __construct()
    {
        //$this->db = mysqli_connect('localhost', 'root', '', 'my_life', 3306);
        $this->db = mysqli_connect('mariadb101.websupport.sk', 'my_life', 'Je02wx{M*R', 'my_life', 3313);

        $this->checkError();
    }

    public function checkError()
    {
        if ($this->db->error)
            die("Database error: " . $this->db->error);
    }




    public function getUser_ID($id_user): ?User
    {
        $sql = "SELECT * FROM user WHERE id_user='$id_user'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result))
            return new User($row, $this);
        return null;
    }

    public function getResult($sql): mysqli_result|bool
    {
        $result = mysqli_query($this->db, $sql);
        $this->checkError();
        return $result;
    }


    public function getSubjects(): array
    {
        $subjects = array();
        $sql = "SELECT *, points as subject_points, exam_points as subject_exam_points FROM subject";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $subjects[] = new Subject($row, $this);
        }
        return $subjects;
    }

    public function getProjects(): array
    {
        $projects = array();
        $sql = "SELECT * FROM projects";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $projects[] = new Project($row, $this);
        }
        return $projects;
    }

    public function getPerson_ID($id): ?Person
    {
        $sql = "SELECT * FROM person WHERE id_person='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Person($row, $this);
        }
        return null;
    }

    public function getSubject_ID($id): ?Subject
    {
        $sql = "SELECT *,points as subject_points, exam_points as subject_exam_points  FROM subject WHERE id_subject='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Subject($row, $this);
        }
        return null;
    }

    public function getCategory_ID($id): ?Category
    {
        $sql = "SELECT * FROM category WHERE id_category='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Category($row, $this);
        }
        return null;
    }

    public function getAllFromTable($table): array
    {
        $rows = array();
        $sql = "SELECT * FROM $table";
        while ($row = mysqli_fetch_assoc($this->getResult($sql))) {
            $rows[] = new Project($row, $this);
        }
        return $rows;
    }

    public function getProjects_Done(): array
    {
        $projects = array();
        $sql = "SELECT * FROM projects WHERE done=true";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $projects[] = new Project($row, $this);
        }
        return $projects;
    }

    public function getProject_ID($id): ?Project
    {
        $sql = "SELECT * FROM projects WHERE id='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Project($row, $this);
        }
        return null;
    }

    public function getUsers(): array
    {
        $users = array();
        $sql = "SELECT * FROM user";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
           $users[] = new User($row, $this);
        }
        return $users;
    }


    public function getSchoolEvents($type): array
    {
        $exercises = array();
        $sql = "SELECT * FROM school_event WHERE type='$type' ORDER BY date";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $exercises[] = new SchoolEvent($row, $this);
        }
        return $exercises;
    }

    public function getSchoolEvent_ID($id): ?SchoolEvent
    {
        $sql = "SELECT * FROM school_event WHERE id='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new SchoolEvent($row, $this);
        }
        return null;
    }

    public function getCalendarEvents(): array
    {
        $ce = array();
        $sql = "SELECT * FROM calendar_events";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $ce[] = new CalendarEvent($row, $this);
        }
        return $ce;
    }

    public function getBlogs(): array
    {
        $blogs = array();
        $sql = "SELECT * FROM blog ORDER BY date";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $blogs[] = new Blog($row, $this);
        }
        return $blogs;
    }

    public function getBlog_ID($id): ?Blog
    {
        $sql = "SELECT * FROM blog WHERE id='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Blog($row, $this);
        }
        return null;
    }

    public function getTask_ID($id): ?Task
    {
        $sql = "SELECT * FROM tasks WHERE id_task='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Task($row, $this);
        }
        return null;
    }

    public function getMessages($person, $person2): array
    {
        $messages = array();
        $sql = "SELECT * FROM message WHERE ((id_sender = '$person->id'  AND id_receiver='$person2->id') || (id_receiver ='$person->id'  AND id_sender='$person2->id')) ORDER BY datetime";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = new
            Message($row, $this);
        }
        return $messages;
    }

    public function getProblem_ID($id): ?Problem
    {
        $sql = "SELECT * FROM problem WHERE id_problem='$id'";
        $result = $this->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Problem($row, $this);
        }
        return null;
    }

    public function getIcons(): array
    {
        $icons = array();
        $sql = "SELECT * FROM icons";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $icons[] = array(
	            'id' => $row['id_icon'],
	            'icon' => $row['icon'],
	            'type' => $row['type'],
            );
        }
        return $icons;
    }

    function getIcon_ID($id): ?array
    {
        $sql = "SELECT * FROM icons WHERE id_icon='$id'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)){
            return array( 'id' => $row['id_icon'], 'type' => $row['type'], 'icon' => $row['icon']);
        }
        return null;
    }

    function getChallenge_ID($id): ?Challenge
    {
        $sql = "SELECT * FROM challenges WHERE id_challenge='$id'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)){
            return new Challenge($row, $this);
        }
        return null;
    }

    public function getNumber($table){
        $sql = "SELECT COUNT(*) + 1 AS number FROM $table";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return $row['number'];
        }
        return null;
    }

    public function getFollows(): array
    {
        $follows = array();
        $sql = "SELECT * FROM blog ORDER BY date";
        $result = $this->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $follows[] = new Follow($row, $this);
        }
        return $follows;
    }

    public function getSET_ID($id): ?SET
    {
        $sql = "SELECT * FROM school_event_tasks WHERE id_set = '$id'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return new SET($row, $this);
        }
        return null;
    }


    /**
     * @param $id_activity
     * @return Activity|null
     */
    public function getActivity_ID($id_activity): ?Activity
    {
        $sql = "SELECT * FROM activity WHERE id_activity='$id_activity'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return new Activity($row, $this);
        }
        return null;
    }

    public function getMatch_ID($id_match): ?Matches
    {
        $sql = "SELECT * FROM `match` WHERE id_match='$id_match'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return new Matches($row, $this);
        }
        return null;
    }

    public function getTeam_ID(string $id_team): ?Team
    {
        $sql = "SELECT * FROM team WHERE id_team='$id_team'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return new Team($row, $this);
        }
        return null;
    }

    public function getBets(): array
    {
        $bets = array();
        $sql = "SELECT * FROM bet JOIN `match` using(id_match) ORDER BY date_time DESC ";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $bets[] = new Bet($row, $this);
        }
        return $bets;
    }


    public function getMatches(): array
    {
        $matches = array();
        $sql = "SELECT * FROM `match` ORDER BY id_match DESC";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $matches[] = new Matches($row, $this);
        }
        return $matches;
    }

    public function getMatches_No_Bet(): array
    {
        $matches = array();
        $sql = "SELECT * FROM `match` Where id_match NOT IN (SELECT id_match FROM bet ) ORDER BY id_match DESC";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $matches[] = new Matches($row, $this);
        }
        return $matches;
    }

    public function getTeams(): array
    {
        $teams = array();
        $sql = "SELECT * FROM team ORDER BY name ";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $teams[] = new Team($row, $this);
        }
        return $teams;
    }

    public function getBetAgency_ID($id_bet_agency): ?BetAgency
    {
        $sql = "SELECT * FROM bet_agency WHERE id_bet_agency='$id_bet_agency'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return new BetAgency($row, $this);
        }
        return null;
    }

    public function getBetAgencies(): array
    {
        $bas = array();
        $sql = "SELECT * FROM bet_agency ";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $bas[] = new BetAgency($row, $this);
        }
        return $bas;
    }

    public function getBet_ID($id_bet): ?Bet
    {
        $sql = "SELECT * FROM bet where id_bet='$id_bet'";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return new Bet($row, $this);
        }
        return null;
    }

    public function getBets_Played(): array
    {
        $bets = array();
        $sql = "SELECT * FROM bet JOIN `match` using(id_match) where date_time < CURRENT_TIMESTAMP ORDER BY date_time DESC";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $bets[] = new Bet($row, $this);
        }
        return $bets;
    }

    public function getBets_Not_Played(): array
    {
        $bets = array();
        $sql = "SELECT * FROM bet JOIN `match` using(id_match) where date_time >= CURRENT_TIMESTAMP ORDER BY date_time DESC";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $bets[] = new Bet($row, $this);
        }
        return $bets;
    }

    public function getBetsDraws(): array
    {
        $draws = array();
        $sql = "SELECT * FROM bet JOIN `match` using(id_match) WHERE score_home = score_guest and `match`.date_time > CURRENT_TIMESTAMP";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $row[] = new Bet($row, $this);
        }
        return $draws;
    }

    public function getLeagues(): array
    {
        $leagues = array();
        $sql = "select * from league";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $leagues[] = new League($row, $this);
        }
        return $leagues;
    }

    public function getLeague_ID($id): ?League
    {
       $sql = "select * from league where id_league='$id'";
       $result = $this->getResult($sql);
       if($row = mysqli_fetch_assoc($result)) {
           return new League($row, $this);
       }
       return null;
    }

    public function getInformation(): array {
        $infos = array();
        $sql = "select * from `information` ";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $infos[] = new Information($row, $this);
        }
        return $infos;
    }


    public function getBetAnalysis() : array {
        $analysis = array();
        $sql = "select * from bet_analysis";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $analysis[] = new BetAnalysis($row, $this);
        }
        return $analysis;
    }

    public function getBetAnalysis_Winnable($boolean) : array {
        $analysis = array();
        $sql = "select * from bet_analysis where winnable='$boolean' and datetime<=CURRENT_TIMESTAMP";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $analysis[] = new BetAnalysis($row, $this);
        }
        return $analysis;
    }

    public function getBetAnalysis_Winnable_Rate($boolean) : float
    {
        $sql = "select sum(rate) as rate from bet_analysis where winnable='$boolean' and datetime<=CURRENT_TIMESTAMP";
        $result = $this->getResult($sql);
        if($row = mysqli_fetch_assoc($result))
            return $row['rate'] !== null ? $row['rate']: 0;
        return 0;
    }

    public function getAnalysisAuthors() : array {
        $authors = array();
        $sql = "select * from analysis_author";
        $result = $this->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $authors[] = new AnalysisAuthor($row);
        }
        return $authors;
    }
	
	public function getColors() : array {
		$authors = array();
		$sql = "select * from color";
		$result = $this->getResult($sql);
		while($row = mysqli_fetch_assoc($result)) {
			$authors[] = array('id' => $row['id_color'], 'color' => $row['color'], 'name' => $row['name']);
		}
		return $authors;
	}
	
	public function getColor_ID($id) : ?array{
		$sql = "select * from color where id_color='$id'";
		$result = $this->getResult($sql);
		if($row = mysqli_fetch_assoc($result)) {
			return array('id' => $row['id_color'], 'color' => $row['color'], 'name' => $row['name']);
		}
		return null;
	}
	
	public function getTask_ProblemID($id): ?Task
    {
		$sql = "select * from tasks where id_task IN (SELECT id_task from problem where id_problem='$id')";
		$result = $this->getResult($sql);
		if($row = mysqli_fetch_assoc($result)) {
			return new Task($row, $this);
		}
		return null;
	}
}
