<?php


class Task
{
    public int $id;
    public ?Person $person;
    public string $name;
    public string $date_created;
    public string|null $date;
    public string $type;
    public bool $done;
    public string|null $date_done;
    public mixed $connect;
    public bool $success;
    private ?Database $database;

    public function __construct($row, Database $database)
    {
        $this->id = $row['id_task'];
        $this->person = $database->getPerson_ID($row['id_person']);
        $this->name = $row['name'];
        $this->date_created = $row['date_created'];
	    
        $this->date = $row['date'] === '0000-00-00 00:00:00' ? null: $row['date'];
        $this->type = $row['type'];
        $this->date_done = $row['date_done'];
        $this->done = $row['done'];
        if($row['type'] === "project") {
            $this->connect = $database->getProject_ID($row['id_connect']);
        } else if($row['type'] === "subject") {
            $this->connect = $database->getSubject_ID($row['id_connect']);
        } else {
            $this->connect = null;
        }
        $this->success = $row['success'];
        $this->database = $database;
    }

    public function getWorkingTime() {
        $sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(end, start))) as time 
                FROM working_on_task where id_task='$this->id';";
        $result = $this->database->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return $row['time'];
        }
        return 0;
    }

    public function startTimer() {
        $sql = "INSERT into working_on_task (id_task,start, end) 
                values ('$this->id', CURRENT_TIMESTAMP, null)";
        $this->database->getResult($sql);

    }
    public function stopTimer() {
        $sql = "UPDATE working_on_task set end=CURRENT_TIMESTAMP 
                where id_task='$this->id' and end IS NULL";
        $this->database->getResult($sql);

    }

    public function isTimerUp(): bool
    {
        $sql = "SELECT * FROM working_on_task where id_task='$this->id' and end IS NULL";
        $result = $this->database->getResult($sql);
        if(mysqli_num_rows($result) > 0)
            return true;
        return false;
    }

    public function getProblems() : array {
        $problems = array();
        $sql = "SELECT * FROM problem WHERE id_task='$this->id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $problems[] = new Problem($row, $this->database);
        }
        return $problems;

    }
    public function getWorkingTime_From_To($from, $to)  {
        $sql = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(end, start))) as time 
                FROM working_on_task where id_task='$this->id' and start>= '$from' 
                                       and end <='$to'";
        $result = $this->database->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
            return $row['time'];
        }
        return 0;

    }

    public function setDone($done) : void {
        $sql = "UPDATE tasks SET done='$done' WHERE id_task='$this->id'";
        $result = $this->database->getResult($sql);
        $this->done = $done;
    }

    public function getWorkingOnTasks() :array {
        $wots = array();
        $sql = "SELECT *,SUM(TIME_TO_SEC(TIMEDIFF(end, start))) as time  From working_on_task WHERE id_task='$this->id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $wots[] = array('id' => $row['id'], 'start' => $row['start'], 'end' => $row['end'], 'time' => $row['time']);
        }
        return $wots;
    }
    
    public function getProblems_Solved($solved): array
    {
	    $problems = array();
	    $sql = "SELECT * FROM problem WHERE id_task='$this->id' AND solved='$solved'";
	    $result = $this->database->getResult($sql);
	    while($row = mysqli_fetch_assoc($result)) {
		    $problems[] = new Problem($row, $this->database);
	    }
	    return $problems;
    }

    public function getProblems_Order($by,$direction): array
    {
        $problems = array();
        $sql = "SELECT * FROM problem WHERE id_task='$this->id' ORDER BY $by $direction";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $problems[] = new Problem($row, $this->database);
        }
        return $problems;
    }


}
