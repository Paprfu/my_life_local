<?php


class Challenge
{

    public int $id;
    public string $name;
    public string $start;
    public string $end;
    public string $icon;
    public string $color;
    private Database $database;

    public function __construct($row,Database $database)
    {
        $this->id = $row['id_challenge'];
        $this->name = $row['name'];
        $this->start = $row['start'];
        $this->end = $row['end'];
        $this->color = $database->getColor_ID($row['id_color']);
        $this->icon = $database->getIcon_ID($row['id_icon']);
        $this->database = $database;

    }

    public function getSuccessDays()
    {
        $sql = "SELECT count(*) as number FROM challenge_success WHERE id_challenge='$this->id' AND date >= '$this->start' AND success=1 ";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result))
            return $row['number'];
        return 0;
    }


    public function getSuccessDay($date): bool
    {
        $sql = "SELECT * FROM challenge_success where date='$date' and id_challenge='$this->id'";
        $result = $this->database->getResult($sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return true;
        }
        return false;
    }

}
