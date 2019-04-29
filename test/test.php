<?php
class Database extends PDO
{
    public $table;
    private $dsn;
    private $user;
    private $pass;
    private $options;
    function __construct($db, $table)
    {
        $this->table=$table;
        $this->user='root';
        $this->pass='';
        $this->dsn='mysql:dbname='.$db.';host=localhost';
        $this->options=[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        try {
            parent::__construct($this->dsn, $this->user, $this->pass, $this->options);
        } catch (PDOException $e) {
            die('Failed to connecting database! '.$e->getMessage());
        }
    }
}

$db=new Database('blog', 'post');
$sql="SELECT * from $db->table;";
$sth = $db->prepare($sql);
$sth->execute();
$res=$sth->rowCount();

print_r($res);
// echo "<br> ".$res[0]['total'];
