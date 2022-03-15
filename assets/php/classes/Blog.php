<?php

class Blog
{

    public int $id;
    public string $name;
    public string $text;
    public string $date;
    public string $type;
    public string $photo;
    public int $id_person;
    private ?Database $database;

    public function __construct($row, $database)
    {
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->text = $row['text'];
        $this->date = $row['date'];
        $this->type = $row['type'];
        $this->photo = $row['photo'];
        $this->id_person = $row['id_person'];
        $this->database = $database;

    }


}