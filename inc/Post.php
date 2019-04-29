<?php

/**
 *
 */
class Post
{

    private $db;
    
    public function __construct(DB $db)
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

    public function readAll($limit = ['lower'=>0,'upper'=>5])
    {
        $sql="SELECT * FROM {$this->db->table} ORDER BY id DESC LIMIT {$limit['lower']},{$limit['upper']};";
        $stmt=$this->db->prepare($sql);
        $stmt->execute();

        $data=$stmt->fetchAll();

        return $data;
    }

    public function paginate($page, $lim)
    {
        $sql="SELECT * FROM {$this->db->table};";
        $stmt=$this->db->prepare($sql);
        $stmt->execute();

        $res=$stmt->rowCount();

        if ($res>0) {
            $limit['lower']=($page*$lim)-$lim;
            $limit['upper']=$page*$lim;

            return $limit;
        } else {
            $limit['lower']=0;
            $limit['upper']=0;

            return $limit;
        }
    }
}
