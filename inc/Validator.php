<?php

/**
 *
 */
class Validator
{
  public static $err;

  public static function validScript($data)
  {
    if (!empty($data)) {
      $data=trim($data);
      $data=htmlspecialchars($data);
      $data=stripslashes($data);

      return $data;
    }
    else {
      return "*Field must not be empty!";
    }
  }

   public static function validWord($data)
   {
     if (!preg_match('/^[a-zA-Z0-9\s]+$/', $data)) {
       return "Invalid name!";
     }
   }

   public static function validUser($data)
   {
     if (!preg_match('/^[a-z0-9_-]+/i', $data)) {
       return "Invalid username! a-z, 0-9,dashes and underscore are allowed here!";
     }
   }

   public static function validEmail($data)
   {
     if (!empty($data)) {
       if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
         return "Invalid Email!";
       }
     }
     else {
       return "*field must not be empty!";
     }
   }

   public static function validPass($data)
   {
     if (strlen($data)<6) {
       return "Password must be at least 6 characters long!";
     }
   }

   public static function validPassMatch($pass1,$pass2)
   {
     if ($pass2!=$pass1) {
       return "Password must be same!";
     }
   }

   public static function validUrl($data)
   {
     if (!empty($data)) {
       if (!filter_var($data, FILTER_VALIDATE_URL)) {
         return "Invalid url";
       }
     }
     else {
       return "Empty field!";
     }
   }

}

 ?>
