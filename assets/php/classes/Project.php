<?php

class Project
{

    public int $id;
    public string $name;
    public mixed $start;
    public mixed $end;
    public bool $done;
    private ?Database $database;

    public function __construct($row, Database $param)
    {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->start = $row['start'];
        $this->end = $row['end'] === '0000-00-00 00:00:00' ? null: $row['end'];
        $this->done = $row['done'];
        $this->database = $param;

    }

    public function getTasks(): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks WHERE type='project' AND id_connect='$this->id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $tasks[] = new Task($row, $this->database);
        }
        return $tasks;
    }

    public function getTasks_Done($done): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks WHERE type='project' AND id_connect='$this->id' AND done='$done'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $tasks[] = new Task($row, $this->database);
        }
        return $tasks;
    }

    public function getWorkingTime(): float
    {
        $time = 0;
        foreach ($this->getTasks() as $t) {
            $time += $t->getWorkingTime();
        }
        return $time;
    }

    public function getWorkingTime_From_To($from, $to): float
    {
        $time = 0;
        foreach ($this->getTasks() as $t) {
            $time += $t->getWorkingTime_From_To($from, $to);
        }
        return $time;
    }

    public function setDone($done): static
    {
        $sql = "UPDATE projects SET done='$done' WHERE id='$this->id'";
        $this->database->getResult($sql);
        $this->done = $done;
        return $this;
    }
}