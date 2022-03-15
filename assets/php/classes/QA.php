<?php




class QA
{
       public int $id;
       public string $q;
       public int $a;
       public ?Category $cat;
       public ?Subject $subject;
       private Database $database;

       public function __construct($row, Database $database)
       {
           $this->id = $row['id_qa'];
           $this->a = $row['question'];
           $this->q = $row['answer'];
           $this->cat = $database->getCategory_ID($row['id_category']);
           $this->subject = $database->getSubject_ID($row['id_subject']);
           $this->database = $database;
       }
}