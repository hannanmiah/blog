<?php require 'lib/header.php';

if (!empty($_SESSION) && Session::check()) {
  header('Location: index.php');
}

Session::destroy();

setcookie('username',null,time()-3600);
setcookie('password',null,time()-3600);

include 'lib/footer.php';

 ?>
