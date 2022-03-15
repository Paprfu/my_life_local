<?php


class SET
{
    public int $id;
    public bool $done;
    public bool $checked;
    public string $assigment;
    public string $solution;
    private ?Database $database;

    public function __construct($row, $database) {
        $this->id = $row['id_set'];
        $this->done = $row['done'];
        $this->checked = $row['checked'];
        $this->assigment = $row['assigment'];
        $this->solution = $row['solution'];
        $this->database = $database;
    }

    public function getFiles() {
        $files = array();
        $sql = "SELECT * FROM files WHERE id_connect='$this->id' AND table_name='school_event_tasks'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            array_push($files , array(
                'path' => $row['path'],
                'name' => $row['name'],
                'ext' => $row['ext'],
                'type' => $row['type'],));
        }
        return $files;
    }


}