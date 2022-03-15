<?php


class Timeline
{
    public ?Person $person;
    public string $text;
    public string $date;
    private Database $database;

    public function __construct($row, $database)
    {
        $this->person = $database->getPerson_ID($row['id_person']);
        $this->text = $row['text'];
        $this->date = $row['date'];
        $this->database = $database;
    }

}