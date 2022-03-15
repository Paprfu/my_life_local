<?php


class School
{
    public int $id;
    public string $name;
    public ?Database $database;

    public function __construct($row, Database $database) {
        $this->id = $row['id_school'];
        $this->name = $row['name'];
        $this->database = $database;
    }
}