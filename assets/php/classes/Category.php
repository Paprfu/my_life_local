<?php
class Category
{
    public int $id;
    public string $name;
    private ?Database $database;

    public function __construct($row, Database $database)
    {
        $this->id = $row['id_category'];
        $this->name = $row['name'];
        $this->database = $database;
    }
}