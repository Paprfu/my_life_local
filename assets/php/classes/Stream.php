<?php


class Stream
{
    public int $id;
    public string $name;
    public string $datetime;
    private ?Database $database;

    public function __construct(array $row, \Database $database)
    {
        $this->id = $row['id_stream'];
        $this->name = $row['name'];
        $this->datetime = $row['datetime'];
        $this->database = $database;
    }

    public function getStreamItems() : array
    {
        $items = array();
        $sql = "select * from stream_items where id_stream='$this->id'";
        $result = $this->database->getResult($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = array('id' => $row['id_stream_item'], 'name' => $row['name'], 'link' => $row['link'], 'plan_time' =>
                $row['plan_time'], 'real_time' => $row['real_time']);
        }
        return $items;
    }
}
