<?php

class Session
{

  public static function init()
  {
    if (!(self::check())) {
      session_start();
    }
  }

  public static function check()
  {
    if(session_status()==PHP_SESSION_ACTIVE && session_id()!=null){
      return true;
    }
    else {
      return false;
    }
  }

  public static function set($key, $value)
  {
    $_SESSION[$key]=$value;
  }

  public static function get($key)
  {
    return $_SESSION[$key];
  }

  public static function destroy()
  {
    if (self::check()) {
      session_unset();
      session_destroy();
      header("Location: login.php");
    }
    else {
      header('Location: index.php');
    }
  }
}


 ?>
