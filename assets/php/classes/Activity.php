<?php

class Activity
{
     public int $id;
     public ?Person $person;
     public string $name;
     public string $type;
     public string $start;
     public string $end;
     private Database $database;

     public function __construct($row,\Database $database){
         $this->id= $row['id_activity'];
         $this->person = $database->getPerson_ID($row['id_person']);
         $this->name = $row['name'];
         $this->type = $row['type'];
         $this->start = $row['start'];
         $this->database = $database;
     }

   

     public function getLinks(): array
     {
         $links = array();
         $sql = "SELECT * FROM links where id_connect='$this->id' and table_name='activity'";
         $result = $this->database->getResult($sql);
         while($row = mysqli_fetch_assoc($result)) {
             $links[] = new Link($row, $this->database);
         }
         return $links;
     }
}
