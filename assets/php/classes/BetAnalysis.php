<?php

class BetAnalysis
{
    public int $id;
    public ?Person $author;
    public float $reliance;
    public float $rate;
    public string $type;
    public string $sport;
    public string $datetime;
    public bool $winnable;
    public ?Matches $match;
    private ?Database $database;

    public function __construct(array $row, $database) {
        $this->id = $row['id_bet_analysis'];
        $this->database = $database;
        $this->author = $this->getAuthor($row['id_author']);
        $this->reliance = $row['reliance'];
        $this->rate = $row['rate'];
        $this->type = $row['type'];
        $this->sport = $row['sport'];
        $this->datetime = $row['datetime'];
        $this->winnable = $row['winnable'];
        $this->match = $row['match'];

    }

    private function getAuthor($id) {
        $sql = "select * from analysis_author where id_author='$id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result))
            return new AnalysisAuthor($row);
        return null;

    }

}
