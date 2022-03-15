<?php



class File
{
   public int $id;
   public int $id_connect;
   public string $table_name;
   public string $name;
   public string $path;
   public string $ext;
   public string $type;
   private Database $database;

   public function __construct($row, Database $database)
   {
       $this->id = $row['id'];
       $this->id_connect = $row['id_connect'];
       $this->table_name = $row['table_name'];
       $this->name = $row['name'];
       $this->path = $row['path'];
       $this->ext = $row['ext'];
       $this->type = $row['type'];
       $this->database = $database;
   }
}