<?php


class Link
{
    public int $id;
    public int $id_connect;
    public string $table_name;
    public string $name;
    public string $link;
    public string $type;
    private Database $database;

    public function __construct(array $row, Database $database)
    {
        $this->id = $row['id_link'];
        $this->id_connect = $row['id_connect'];
        $this->table_name = $row['table_name'];
        $this->name = $row['name'];
        $this->link = $row['link'];
        $this->type = $row['type'];
        $this->database = $database;
    }
}