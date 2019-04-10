<?php
spl_autoload_register(function ($class) {
    include 'inc/'.$class.'.php';
});

Session::init();
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $usr=new User();
    $db=new DB('blog', 'user');
    $user=['username'=>$_COOKIE['username'],'password'=>$_COOKIE['password']];
    $usr->autoLogin($db, $user);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blog by Hridoy</title>
    <link rel="stylesheet" type="text/css" href="lib/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="lib/clean-blog.min.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="lib/all.min.css"/> -->
    <link rel="stylesheet" type="text/css" href="lib/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="lib/all.css"/>
    <script src="lib/bootstrap.min.js"></script>
    <script src="lib/clean-blog.min.js"></script>
    <script src="lib/jquery.min.js"></script>
    <script src="lib/bootstrap.bundle.js"></script>
  </head>
  <body>
    <style>body a{color: blue;}</style>
    <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="index.php">Hridoy's Blog</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
            <?php if (isset($_SESSION['login']) && $_SESSION['login']==true) {
                ?>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
            <?php } else {?>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Registration</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
            <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
