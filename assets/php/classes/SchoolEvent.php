<?php

class SchoolEvent
{

    public int $id;
    public string $name;
    public string $date;
    public string $type;
    public string $text;
    public int $points;
    public int $max_points;
    private ?Database $database;

    public function __construct($row, Database $database)
    {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->date = $row['date'];
        $this->type = $row['type'];
        $this->text = $row['text'];
        $this->points = $row['points'];
        $this->max_points = $row['max_points'];
        $this->database = $database;
    }

    public function getFiles(): array
    {
        $files = array();
        $sql = "SELECT * FROM files WHERE id_connect='$this->id' 
                      AND table_name='school_event'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $files[] = array(
                'path' => $row['path'],
                'name' => $row['name'],
                'ext' => $row['ext'],
                'type' => $row['type']);
        }
        return $files;
    }

    public function getLinks(): array
    {
        $links = array();
        $sql = "SELECT * FROM links WHERE id_connect='$this->id' AND table_name='school_event'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $links[] = new Link($row, $this->database);
        }
        return $links;
    }

    public function getTasks() {
        $tasks = array();
        $sql = "SELECT * FROM school_event_tasks JOIN school_event se on school_event_tasks.id_school_event = se.id WHERE id_school_event='$this->id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($tasks, new SET($row, $this->database));
        }
        return $tasks;
    }

    public function getTasks_Done() {
        $tasks = array();
        $sql = "SELECT * FROM school_event_tasks JOIN school_event se on school_event_tasks.id_school_event = se.id WHERE id_school_event='$this->id' AND school_event_tasks.done = 1";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($tasks, new SET($row, $this->database));
        }
        return $tasks;
    }


}