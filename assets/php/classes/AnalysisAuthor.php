<?php


class AnalysisAuthor
{
    public int $id;
    public string $name;

    public function __construct(array $row) {
        $this->id = $row['id_author'];
        $this->name = $row['name'];
    }



}
