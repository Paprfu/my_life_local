<?php


class User
{
    public int $id;
    public string $name;
    public string $email;
    public int $accepted;
    private Database $database;


    public function __construct($row,Database $database)
    {
        $this->id = $row['id_user'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->accepted = $row['accepted'];
        $this->database = $database;
    }

    public function getPerson(): ?Person
    {
        $sql = "SELECT * FROM person WHERE id_user='$this->id'";
        $result = $this->database->getResult($sql);
        if($row = mysqli_fetch_assoc($result)) {
                  return $this->database->createPerson($row);
        }
        return null;

    }
    public function getTasks(): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $this->database->createTask($row);
        }
        return $tasks;
    }

    public function getProjects(): array
    {
        $projects = array();
        $sql = "SELECT * FROM projects JOIN project_person ON(id = id_project) WHERE id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $projects[] = $this->database->createProject($row);
        }
        return $projects;
    }

       public function getTasks_Undone(): array
       {
        $tasks = array();
        $sql = "SELECT * FROM tasks WHERE done=0";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $tasks[] = new Task($row, $this);
        }
        return $tasks;
    }

    public function getTasks_Done(): array
    {
        $tasks = array();
        $sql = "SELECT * FROM tasks WHERE done=1";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $tasks[] = new Task($row, $this);
        }
        return $tasks;
    }

    public function getSubjects(): array
    {
        $subject = array();
        $sql = "SELECT * FROM subject JOIN subject_person USING(id_subject) where id_person='$this->id'";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $subject[] = new Subject($row, $this->database);
        }
        return $subject;
    }

    public function getSubjects_Undone(): array
    {
        $subject = array();
        $sql = "SELECT * FROM subject JOIN subject_person USING(id_subject) where id_person='$this->id' AND subject.from <= CURRENT_TIMESTAMP AND subject.to >= CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $subject[] = new Subject($row, $this->database);
        }
        return $subject;
    }



    public function getProjects_Undone(): array
    {
        $subject = array();
        $sql = "SELECT * FROM projects JOIN project_person ON(projects.id = project_person.id_project) where id_person='$this->id' AND projects.start <= CURRENT_TIMESTAMP AND projects.end >= CURRENT_TIMESTAMP";
        $result = $this->database->getResult($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $subject[] = new Project($row, $this->database);
        }
        return $subject;
    }
}