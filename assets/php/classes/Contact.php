<?php


class Contact
{

    public ?Person $person;
    private ?Database $database;

    public function __construct(array $row, Database $database)
    {
            $this->person = $database->getPerson_ID($row['id_second_person']);
            $this->database = $database;
    }
}