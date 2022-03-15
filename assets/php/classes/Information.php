<?php


namespace assets\php\classes;


class Information
{
    public int $id;
    public string $text;
    public mixed $datetime;
    public mixed $connections;
    public int $priority;
    public int $importance;

    private \Database $database;

    public function __construct($row, $database)
    {
        $this->database = $database;
        $this->id = $row['id'];
        $this->text = $row['text'];
        $this->datetime = $row['datetime'];
        $this->priority = $row['priority'];
        $this->importance = $row['importance'];
        $this->database = $database;
        $this->connections = $this->getConnect();

    }

    private function getConnect(): array
    {
        $connections = array();
        $sql = "select * from information_connect where id_information='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            switch ($row['table']) {
                case 'subject':
                    $connections[] = $this->database->getSubject_ID($row['id_connect']);
                    break;
                case 'school_event':
                    $connections[] = $this->database->getSchoolEvent_ID($row['id_connect']);
                    break;
                case 'project':
                    $connections[] = $this->database->getProject_ID($row['id_connect']);
                default:
            }

        }
        return $connections;
    }

}