<?php

/**
 *
 */
class Post
{

    private $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($data)
    {
        $sql="INSERT INTO {$this->db->table} (author,time,title,content) VALUES (:author,:time,:title,:content);";
        $stmt=$this->db->prepare($sql);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':time', $data['time']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            return true;
        } else {
            return false;
        }
    }

    public function readAll()
    {
        $sql="SELECT * FROM {$this->db->table};";
        $stmt=$this->db->prepare($sql);
        $stmt->execute();

        $data=$stmt->fetchAll();

        return $data;
    }
}
