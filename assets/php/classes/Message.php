<?php




class Message
{
    public int $id;
    public ?Person $sender;
    public ?Person $receiver;
    public string $datetime;
    public string $text;
    public bool $showed;
    private ?Database $database;

    public function __construct($row,Database $database)
    {
        $this->id = $row['id_message'];
        $this->sender = $database->getPerson_ID($row['id_sender']);
        $this->receiver = $database->getPerson_ID($row['id_receiver']);
        $this->datetime = $row['datetime'];
        $this->text = $row['text'];
        $this->showed = $row['showed'];
        $this->database = $database;
    }
}