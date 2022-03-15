<?php

use assets\php\classes\Follow;

require_once('Timeline.php');

class Person
{
    public int $id;
    public ?User $user;
    public string $name;
    public ?PersonInfo $pi;
    private Database $database;


    public function __construct($row, Database $database)
    {
        $this->id = $row['id_person'];
        $this->database = $database;
        $this->name = $row['name'] . " " . $row['second_name'];
        $this->pi = $this->getPI();
        $this->user = $this->database->getUser_ID($row['id_user']);

    }

    public function getProjects(): array
    {
        $projects = array();
        $sql = "SELECT * FROM projects JOIN project_person ON(projects.id = project_person.id_project) WHERE id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $projects[] = new Project($row, $this->database);
        }
        return $projects;
    }

    private function getPI(): ?PersonInfo
    {
        $sql = "SELECT * FROM profile_info WHERE id_person='$this->id'";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new PersonInfo($row, $this->database);
        }
        $sql = "INSERT into profile_info(id_person, description, photo, title_photo) values ($this->id,null,null,null)";
        $result = $this->database->getResult($sql);
        if ($result)
            $this->getPI();
        return null;
    }

    public function getTimeline(): array
    {
        $timeline = array();
        $sql = "SELECT * FROM timeline WHERE id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $timeline[] = new Timeline($row, $this->database);
        }
        return $timeline;
    }

    public function getMessages_Sent(): array
    {
        $messages = array();
        $sql = "SELECT * FROM message where id_sender='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = new Message($row, $this->database);
        }
        return $messages;
    }

    public function getMessages_Received(): array
    {
        $messages = array();
        $sql = "SELECT * FROM message where id_receiver='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = new Message($row, $this->database);
        }
        return $messages;
    }

    public function getMessages_Unshown(): array
    {
        $messages = array();
        $sql = "SELECT * FROM message where id_receiver='$this->id' and showed=0";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = new Message($row, $this->database);
        }
        return $messages;
    }

    public function getContacts(): array
    {
        $contacts = array();
        $sql = "SELECT * FROM person JOIN contact c on (person.id_person = c.id_first_person)  WHERE id_first_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $contacts[] = new Contact($row, $this->database);
        }
        return $contacts;
    }

    public function getTasks(): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks where id_person='$this->id' order by date_created desc";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = new Task($row, $this->database);
        }
        return $tasks;
    }

    public function getTasks_Done($done): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks where id_person='$this->id' AND done='$done' ORDER BY date_created DESC";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = new Task($row, $this->database);
        }
        return $tasks;
    }

    public function getBlogs(): array
    {
        $blogs = array();
        $sql = "SELECT * FROM blog where id_person='$this->id' ORDER BY date DESC ";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $blogs[] = new Blog($row, $this->database);
        }
        return $blogs;
    }

    public function getChallenges(): array
    {
        $challenges = array();
        $sql = "select * from challenges where id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $challenges[] = new Challenge($row, $this->database);
        }
        return $challenges;
    }

    public function getWork_On_Projects_Limit($LIMIT): array
    {
        $array = array();
        $sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(end, start))) as time FROM working_on_task join tasks t using(id_task) WHERE t.id_person='$this->id' ORDER BY time LIMIT $LIMIT";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result))
            $array[] = new Task($row, $this->database);
        return $array;

    }

    public function getProjects_Done($done): array
    {
        $projects = array();
        $sql = "SELECT * FROM projects JOIN project_person pp on projects.id = pp.id_project WHERE done='$done' AND id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $projects[] = new Project($row, $this->database);
        }
        return $projects;
    }

    public function getSubjects_Actual(): array
    {
        $subjects = array();
        $sql = "SELECT *,subject.points as subject_points, subject.exam_points as subject_exam_points  FROM subject JOIN subject_person sp on subject.id_subject = sp.id_subject WHERE 
                subject.from <=CURRENT_TIMESTAMP AND subject.to >=CURRENT_TIMESTAMP AND id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $subjects[] = new Subject($row, $this->database);
        }
        return $subjects;

    }

    public function getProjects_From_To($from, $to): array
    {
        $projects = array();
        $sql = "SELECT * FROM subject JOIN subject_person sp on subject.id_subject = sp.id_subject WHERE subject.from<='$from' AND subject.to>='$to' AND id_person='$this->id'";

        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $projects[] = new Project($row, $this->database);
        }
        return $projects;
    }

    public function getCalendarEvents_From_Order_Direction_Limit($from = '0000-00-00', $order = '', $direction = 'ASC', $limit = 5): array
    {
        $events = array();
        $sql = "SELECT * FROM calendar_events WHERE id_person='$this->id' AND start >= '$from' ORDER BY '$order' $direction LIMIT $limit";

        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = new CalendarEvent($row, $this->database);
        }
        return $events;
    }

    public function getCalendarEvents(): array
    {
        $events = array();
        $sql = "SELECT * FROM calendar_events WHERE id_person='$this->id'";

        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = new CalendarEvent($row, $this->database);
        }
        return $events;
    }


    public function getFollow($id): ?Follow
    {
        $sql = "SELECT * FROM follows where id_followed='$this->id' and id_follower='$id'";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Follow($row, $this->database);
        }
        return null;
    }

    public function getSubjects_From_To($from = '0000-00-00', $to = '9999-99-99'): array
    {
        $subjects = array();

        $sql = "SELECT *,s.points as subject_points, s.exam_points as subject_exam_points  FROM subject s JOIN subject_person sp on s.id_subject = sp.id_subject WHERE s.from >= '$from' AND s.to<= '$to' AND id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $subjects[] = new Subject($row, $this->database);
        }
        return $subjects;

    }

    public function getSubjects(): array
    {
        $subjects = array();
        $sql = "SELECT *, s.points as subject_points, s.exam_points as subject_exam_points FROM subject s JOIN subject_person sp on s.id_subject = sp.id_subject where id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $subjects[] = new Subject($row, $this->database);
        }
        return $subjects;
    }

    public function getTasks_Type($type): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks WHERE id_person='$this->id' AND type='$type'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = new Task($row, $this->database);
        }
        return $tasks;
    }

    public function getMarkForSubject($id_subject)
    {
        $sql = "SELECT * FROM subject_person where id_person='$this->id' and id_subject='$id_subject'";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['mark'];
        }
        return null;
    }

    public function getPoints_Subject($id)
    {
        $sql = "SELECT * FROM subject_person WHERE id_subject='$id' and id_person='$this->id'";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['points'];
        }
        return null;
    }

    public function getExamPoints_Subject($id)
    {
        $sql = "SELECT * FROM subject_person WHERE id_subject='$id' and id_person='$this->id'";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['exam_points'];
        }
        return null;
    }

    public function getActivities(): array
    {
        $activities = array();
        $sql = "SELECT * FROM activity WHERE id_person='$this->id' ORDER BY id_activity DESC";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $activities[] = new Activity($row, $this->database);
        }
        return $activities;
    }

    public function getBets(): array
    {
        $bets = array();
        $sql = "SELECT * FROM bet JOIN bet_person bp on bet.id_bet = bp.id_bet join `match` using(id_match) where id_person='$this->id' order by date_time desc ";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $bets[] = new MyBet($row, $this->database);
        }
        return $bets;
    }

    public function getBets_Ended(): array
    {
        $bets = array();
        $sql = "SELECT * FROM bet JOIN bet_person bp on bet.id_bet = bp.id_bet JOIN `match` using(id_match) where id_person='$this->id' and `match`.date_time < CURRENT_TIMESTAMP order by bp.id_bet desc ";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $bets[] = new MyBet($row, $this->database);
        }
        return $bets;
    }

    public function getBets_Wins(): array
    {
        $bets_wins = array();
        foreach ($this->getBets_Ended() as $b) {
            if ($b->isWin() == 1)
                $bets_wins[] = $b;
        }
        return $bets_wins;
    }

    public function getBets_Losses(): array
    {
        $bets_losses = array();
        foreach ($this->getBets_Ended() as $b) {
            if ($b->isWin() == 0)
                $bets_losses[] = $b;
        }
        return $bets_losses;
    }

    public function getBets_Revenue()
    {
        $revenue = 0;
        foreach ($this->getBets_Ended() as $b) {
            if ($b->isWin() == 1) {
                $revenue += ($b->value * $b->rate) - $b->value;
            } else
                $revenue -= $b->value;

        }
        return $revenue;
    }

    public function getBets_Not_Played_No_Bet(): array
    {
        $bets = array();
        $sql = "SELECT * FROM bet join `match` using(id_match) where date_time >= CURRENT_TIMESTAMP 
                and id_bet NOT IN (SELECT bet_person.id_bet FROM bet_person where id_person='$this->id') ORDER BY id_bet ASC ";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $bets[] = new MyBet($row, $this->database);
        }
        return $bets;
    }

    public function getBets_No_Bet(): array
    {
        $bets = array();
        $sql = "SELECT * FROM bet join `match` using(id_match) where 
                id_bet NOT IN (SELECT bet_person.id_bet FROM bet_person where id_person='$this->id') ORDER BY id_bet DESC ";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $bets[] = new MyBet($row, $this->database);
        }
        return $bets;
    }

    public function getProblems_Solved($solved): array
    {
        $problems = array();
        $sql = "SELECT * FROM problem WHERE id_problem='$this->id' AND solved='$solved'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $problems[] = new Problem($row, $this->database);
        }
        return $problems;
    }

    public function getActivity_MaxID(): ?Activity
    {
        $sql = "SELECT * FROM activity ORDER BY id_activity DESC LIMIT 1";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return new Activity($row, $this->database);
        }
        return null;
    }

    function getWorkingTime()
    {
        $sql = "select round(sum(timediff( end, start)) / 60 / 60,2) as time from working_on_task JOIN tasks USING (id_task) where id_person='$this->id'";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['time'];
        }
        return 0;
    }


    function getWorkingTime_Monthly()
    {
        $sql = "select round(sum(timediff( end, start)) / 60 / 60,2) as time from working_on_task JOIN tasks USING (id_task) where id_person='$this->id'
				and start >= now() - interval (day(now())-1) day and start <= LAST_DAY(start)";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['time'];
        }
        return 0;
    }

    function getStreams(): array
    {
        $streams = array();
        $sql = "select * from streams where id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $streams[] = new Stream($row, $this->database);
        }
        return $streams;
    }

    function getSchools(): array
    {
        $schools = array();
        $sql = "select * from schools JOIN school_person using(id_school) where id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $schools[] = new School($row, $this->database);
        }
        return $schools;
    }

    function getSchools_Done($done): array
    {
        $schools = array();
        if ($done == 0)
            $sql = "select * from schools JOIN school_person using(id_school) where id_person='$this->id' AND (school_person.end_date IS NULL OR school_person.end_date <= CURRENT_TIMESTAMP)";
        else
            $sql = "select * from schools JOIN school_person using(id_school) where id_person='$this->id' AND (school_person.end_date >= CURRENT_TIMESTAMP AND school_person.end_date IS NOT NULL)";

        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $schools[] = new School($row, $this->database);
        }
        return $schools;
    }


}
