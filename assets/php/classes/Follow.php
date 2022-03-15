<?php


namespace assets\php\classes;


class Follow
{
    public $id;
    public $follower;
    public $followed;
    public $start;
    public $accepted;
    private $database;

    public function __construct($row, $database)
    {
        $this->database = $database;
        $this->id = $row['id_follow'];
        $this->follower = $database->getPerson_ID($row['id_follower']);
        $this->followed = $database->getPerson_ID($row['id_followed']);
        $this->start = $row['start'];
        $this->accepted = $row['accepted'];

    }

}