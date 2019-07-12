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

    protected function createPost($data)
    {
        $sql = "INSERT INTO {$this->db->table} (author,time,title,content) VALUES (:author,:time,:title,:content);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':time', $data['time']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function createComment(int $id, array $data): bool
    {
        $sql = "INSERT INTO comments (post_id,author,content,time) VALUES (:post_id,:author,:content,:time); WHERE post_id=$id;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':post_id', $id);
        $stmt->bindParam(':author', $data['author']);
        $stmt->bindParam(':time', $data['time']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            return false;
        }
        return true;
    }

    public function readAll($limit = ['lower' => 0, 'upper' => 5])
    {
        $sql = "SELECT * FROM {$this->db->table} ORDER BY id DESC LIMIT {$limit['lower']},{$limit['upper']};";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetchAll();

        return $data;
    }

    public function paginate($page, $lim)
    {
        $sql = "SELECT * FROM {$this->db->table};";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $res = $stmt->rowCount();

        if ($res > 0) {
            $limit['lower'] = ($page * $lim) - $lim;
            $limit['upper'] = $page * $lim;

            return $limit;
        } else {
            $limit['lower'] = 0;
            $limit['upper'] = 0;

            return $limit;
        }
    }

    protected function countAll()
    {
        $sql = "SELECT count(*) as total FROM {$this->db->table};";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

        foreach ($res as $value) {
            $result = $value;
        }

        return $result;
    }

    protected function countLimit($limit)
    {
        $sql = "SELECT * FROM {$this->db->table} ORDER BY id DESC LIMIT {$limit['lower']},{$limit['upper']};";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }

    protected function countInvalid()
    {
        echo "<div class='alert alert-danger'>Invalid types or number of arguments passed!</div>";
    }

    protected function readSingle($id)
    {
        $sql = "SELECT * FROM {$this->db->table} WHERE id=$id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $data = $stmt->fetch();

        return $data;
    }

    protected function readMultipleComments($id, $order_by)
    {
        $sql = "SELECT comments.author, comments.content, comments.time FROM comments INNER JOIN post
                ON comments.post_id = post.id WHERE post.id = $id ORDER BY comments.id $order_by;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll();
        }

        return false;
    }

    public function __call($func, $args)
    {

        switch ($func) {
            case 'count':
                switch (count($args)) {
                    case 0:
                        return call_user_func_array(array($this, 'countAll'), $args);
                        break;
                    case 1:
                        return call_user_func_array(array($this, 'countLimit'), $args);
                        break;
                    default:
                        return call_user_func_array(array($this, 'countInvalid'), $args);
                }
            case 'read':
                switch (count($args)) {
                    case 1:
                        return call_user_func_array(array($this, 'readSingle'), $args);
                        break;
                    case 2:
                        return call_user_func_array(array($this, 'readMultipleComments'), $args);
                        break;
                    default:
                        # code...
                        break;
                }
            case 'create':
                switch (count($args)) {
                    case 1:
                        return call_user_func_array(array($this, 'createPost'), $args);
                        break;
                    case 2:
                        return call_user_func_array(array($this, 'createComment'), $args);
                        break;
                    default:
                        # code...
                        break;
                }
        }
    }
}
