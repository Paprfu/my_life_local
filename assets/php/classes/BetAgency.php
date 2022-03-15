<?php


class BetAgency
{

    public int $id;
    /**
     * @var string
     */
    public string $name;
    private Database $database;

    public function __construct($row, \Database $database) {
       $this->id = $row['id_bet_agency'];
       $this->name = $row['name'];
       $this->database = $database;
    }


}