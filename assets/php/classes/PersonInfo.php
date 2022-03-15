<?php

class PersonInfo
{
     public mixed $description;
     public string $photo;
     public string $title_photo;
     private Database $database;

     public function __construct(array $row, Database $database)
     {
         $this->description = $row['description'];
         $this->photo = $row['photo'] == null ? "assets/img/users/1.jpg" : "assets/php/ajax/uploads/".$row['id_person']."/".$row['photo'];
         $this->title_photo = $row['title_photo'] == null ? "assets/img/avatar/avatar.jpg" : "assets/php/ajax/uploads/".$row['id_person']."/".$row['title_photo'];
         $this->database = $database;
     }
}