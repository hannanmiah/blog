<?php

class DB extends PDO
{
  public $table;
  private $dsn;
  private $user;
  private $pass;
  private $options;
  function __construct($db,$table)
  {
    $this->table=$table;
    $this->user='root';
    $this->pass='';
    $this->dsn='mysql:dbname='.$db.';host=localhost';
    $this->options=[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
    try {
      parent::__construct($this->dsn,$this->user,$this->pass,$this->options);
    } catch (PDOException $e) {
      die('Failed to connecting database! '.$e->getMessage());
    }

  }
}


 ?>
