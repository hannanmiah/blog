<?php require 'lib/header.php';
 $db=new DB('blog','user');
 $usr=new User();

 if (!empty($_SESSION) && Session::check()) {
   header('Location: index.php');
 }

 if ($_SERVER['REQUEST_METHOD']=='POST' && !empty($_POST['submit'])) {
   $user=['username'=>$_POST['username'],'password'=>$_POST['password'],'auto'=>$_POST['auto']];
   $msg=$usr->login($db,$user);
 }
?>

  <header class="masthead" style="background-image: url('img/login-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <?php if (!empty($msg)) {
              echo $msg;
            } ?>
            <form action="" method="post">
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" id="username" name="username" style="background: transparent; border: 1px solid #0159A3" placeholder="Enter Your Username">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="password" name="password" style="background: transparent; border: 1px solid #0159A3" placeholder="Enter Your Password">
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="auto" name="auto" value="checked" style="background: transparent; border: 1px solid #0159A3">
                <label class="form-check-label" for="auto">Check me out</label>
              </div>
              <input type="submit" name="submit" class="btn btn-primary" value="Login">
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>


  <?php include 'lib/footer.php'; ?>
