<?php
// class Database extends PDO
// {
//     public $table;
//     private $dsn;
//     private $user;
//     private $pass;
//     private $options;
//     function __construct($db, $table)
//     {
//         $this->table=$table;
//         $this->user='root';
//         $this->pass='';
//         $this->dsn='mysql:dbname='.$db.';host=localhost';
//         $this->options=[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
//         try {
//             parent::__construct($this->dsn, $this->user, $this->pass, $this->options);
//         } catch (PDOException $e) {
//             die('Failed to connecting database! '.$e->getMessage());
//         }
//     }
// }

// $db=new Database('blog', 'post');
// // $sql="SELECT * from $db->table;";
// // $sth = $db->prepare($sql);
// // $sth->execute();
// // $res=$sth->rowCount();

// // print_r($res);
// // echo "<br> ".$res[0]['total'];

//  function rcount($db)
//     {
//         $sql="SELECT count(id) as total FROM {$db->table} LIMIT 0,5;";
//         $stmt=$db->prepare($sql);
//         $stmt->execute();
//         $res=$stmt->fetchAll();

//         foreach ($res as $value) {
//             $result=$value;
//         }

//         return $result;
//     }

//     $res=rcount($db);
//     echo $res['total'];


class MyClass {
    public function __call($name, $args) {

        switch ($name) {
            case 'funcOne':
                switch (count($args)) {
                    case 0:
                        return call_user_func_array(array($this, 'funcWithNoArgs'), $args);
                        break;
                    case 1:
                        return call_user_func_array(array($this, 'funcOneWithOneArg'), $args);
                        break;
                    case 3:
                        return call_user_func_array(array($this, 'funcOneWithThreeArgs'), $args);
                        break;
                    case 5:
                        return call_user_func_array(array($this, 'funcWithFiveArgs'), $args);
                        break;
                    default:
                        return call_user_func_array(array($this, 'funcWithMoreArgs'), $args);
                 }
        }
    }

    protected function funcOneWithOneArg($a) {
        echo "Function with one args";
    }

    protected function funcOneWithThreeArgs($a, $b, $c) {
        echo "Function with three args";
    }

    protected function funcWithNoArgs() {
        echo "Function with no args";
    }

    protected function funcWithFiveArgs($a, $b, $c, $d, $e) {
        echo "Function with five args";
    }

    protected function funcWithMoreArgs() {
        echo "Function with more args";
    }

}

$obj=new MyClass();

$obj->funcOne(1,2,3,4,5,6);