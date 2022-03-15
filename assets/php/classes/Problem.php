<?php



class Problem
{
    public mixed $id;
    public ?Task $task;
    public mixed $description;
    public mixed $start;
    public mixed $solved;
    public mixed $end;
    public mixed $note;
    private ?\Database $database;

    public function __construct($row,\Database $database)
    {
        $this->id = $row['id_problem'];
        $this->task = $database->getTask_ID($row['id_task']);
        $this->description = $row['description'];
        $this->solved = $row['solved'];
        $this->end = $row['end'];
        $this->start = $row['start'];
        $this->note = $row['note'];
        $this->database = $database;
    }

    function getNumberOfRowInTask_Order(string $by, string $direction) : int {
        $id_task = $this->task->id;
        $sql = "Select count(id_problem) as number from problem 
                where id_task = $id_task and id_problem <= '$this->id' order by $by $direction ";
        return mysqli_fetch_assoc($this->database->getResult($sql))['number'];

    }
    
   
    
}
