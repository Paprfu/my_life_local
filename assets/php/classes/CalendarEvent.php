<?php


class CalendarEvent
{

    public int $id;
    public string $name;
    public string $start;
    public string $end;

    private ?Database $database;

    public function __construct($row, $database)
    {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->start = $row['start'];
        $this->end = $row['end'];
        $this->database = $database;
    }

}