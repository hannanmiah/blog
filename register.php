<?php include 'lib/header.php';
include 'inc/Validator.php';

if (!empty($_SESSION) && Session::check()) {
  header('Location: index.php');
}

$db_info=new DB('blog','user_info');
?>
  <header class="masthead" style="background-image: url('img/register-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <?php if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])) {
      $fullName     =$_POST['fullname'];
      $userName     =$_POST['username'];
      $email        =$_POST['email'];
      $password     =$_POST['password'];
      $passwordAgain=$_POST['passwordAgain'];
      $err='';

      $err=Validator::validWord($fullName);
      $err.=Validator::validUser($userName);
      $err.=Validator::validEmail($email);
      $err.=Validator::validPass($password);
      $err.=Validator::validPassMatch($password,$passwordAgain);
      if ($err!=null) {
        Validator::$err="<div class='alert alert-danger'>".$err."</div>";
      }else {
        $password=md5($password);
        $user=['fullname'=>$fullName,'username'=>$userName,'email'=>$email,'password'=>$password];
        $db=new DB('blog','user');
        $usr=new User();
        $msg=$usr->register($db,$user);
      }
    }?>

    </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <?php if (!empty($msg)) {
            echo $msg;
          }
          if (!empty(Validator::$err)) {
            echo Validator::$err;
          }
          ?>
            <form action="" method="post">
              <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" style="background: transparent; border: 1px solid #0159A3" placeholder="Enter Your FullName">
              </div>
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" style="background: transparent; border: 1px solid #0159A3" placeholder="Enter Your Username">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" style="background: transparent; border: 1px solid #0159A3" placeholder="Enter Your Email">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" style="background: transparent; border: 1px solid #0159A3" placeholder="Enter Your Password">
              </div>
              <div class="form-group">
                <label for="passwordAgain">Password Again</label>
                <input type="password" class="form-control" id="passwordAgain" name="passwordAgain" style="background: transparent; border: 1px solid #0159A3" placeholder="Re Enter Your Password">
              </div>
              <button type="submit" name="submit" value="Register" class="btn btn-primary">Submit</button>
            </form>
        </div>
      </div>
    </div>
    </div>
  </header>


  <?php include 'lib/footer.php'; ?>
