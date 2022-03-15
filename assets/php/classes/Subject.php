<?php




class Subject
{
    public int $id;
    public string $name;
    public string $from;
    public string $to;
    public int $points;
    public int $exam_points;
    private ?Database $database;

    public function __construct($row, ?Database $database)
    {
        $this->id = $row['id_subject'];
        $this->name = $row['name'];
        $this->from = $row['from'];
        $this->to = $row['to'];
        $this->points = $row['subject_points'];
        $this->exam_points = $row['subject_exam_points'];
        $this->database = $database;
    }

    public function getQAs(): array
    {
        $qa = array();
        $sql = "SELECT * FROM qa WHERE id_subject='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $qa[] = $this->database->createQA($row);
        }
        return $qa;
    }

    public function getCategories(): array
    {
        $catg = array();
        $sql = "SELECT * FROM category WHERE id_subject='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $catg[] = $this->database->createCategory($row);
        }
        return $catg;
    }

    public function getSchoolEvents($type): array
    {
        $exercises = array();
        $sql = "SELECT * FROM school_event WHERE id_subject='$this->id' AND type='$type' ORDER BY date";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $exercises[] = new SchoolEvent($row, $this->database);
        }
        return $exercises;

    }

    public function getState(): int
    {
        if ($this->from >= date('Y-m-d H:i:s'))
            return 0;
        if ($this->from <= date('Y-m-d H:i:s') && $this->to >= date('Y-m-d H:i:s'))
            return 1;

        return 2;
    }

    public function getPointsFromEvents($type): string
    {
        $sql = "Select sum(points) as sum_points FROM school_event WHERE id_subject='$this->id' and type='$type'";
        return mysqli_fetch_assoc($this->database->getResult($sql))['sum_points'];
    }

    public function getMaxPointsFromEvents($type): int
    {
        $sql = "Select sum(max_points) as sum_max_points FROM school_event WHERE id_subject='$this->id' AND type='$type'";
        return mysqli_fetch_assoc($this->database->getResult($sql))['sum_max_points'];
    }

    public function getTasks_Done($done): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks WHERE type='subject' AND id_connect='$this->id' AND done='$done'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $this->database->createTask($row);
        }
        return $tasks;
    }
    public function getWorkingTime(): int
    {
        $time = 0;
        $tasks = $this->getTasks();
        foreach ($tasks as $t) {
            $time += $t->getWorkingTime();
        }
        return $time;
    }

    public function getTasks(): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks WHERE type='subject' AND id_connect='$this->id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $this->database->createTask($row);
        }
        return $tasks;
    }


}