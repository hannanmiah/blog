<?php require 'lib/header.php';

$db_info=new DB('blog', 'user_info');
$id=Session::get('id');
$info=$usr->showInfo($db_info, $id);
$exist=$usr->fetch($db_info, 'id', Session::get('id'));
$data=$usr->fetch($db, 'id', $id);

if (empty($exist['image']) or $exist['image']=="") {
    if ($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['upload'])) {
        $permitted=['jpg','jpeg','png'];
        $ext  =  pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $path =  "user/image/".md5(substr(time(), 0, 10)).".".$ext;
        $file = ['name' => $_FILES['image']['name'],
                'size' => $_FILES['image']['size'],
                'temp' => $_FILES['image']['tmp_name'],
                'error' => $_FILES['image']['error'],
                'permitted' => ['jpg','jpeg','png'],
                'ext' => $ext,
                'path' => $path

        ];

        $data=array('col' => 'image', 'val' => $file['path'], 'id' => Session::get('id'));

        $res=$usr->insertImage($db_info, $data, $file);
        if (is_bool($res)) {
            echo "<div class='alert alert-success'>Image successfully uploaded!</div>";
            header("Refresh:2");
        } else {
            echo "<div class='alert alert-danger'>".$res."</div>";
        }
    }
    ?>
    <div class="container">
      <div class="jumbotron jumbotron-fluid" style="padding-right: 10px; padding-left: 10px;">
        <h1 class="display-4">Upload Profile Image</h1>
        <p class="lead">You haven't uploaded a profile image yet. Please, complete your profile.</p>
        <hr class="my-4">
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="exampleFormControlFile1">Select Image</label>
            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
            <input type="submit" name="upload" value="Upload" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>


<?php } else { ?>
  <div class="container">
    <div class="card mb-3">
      <div class="row no-gutters">
        <div class="col-md-4">
          <img src="<?=$info['image']; ?>" class="card-img" alt="...">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h3 class="card-title"><?=$data['fullname'];  ?></h1>
            <p class="card-text">
              <h6>From :</h6> <?=$info['address'];  ?> <br>
              <h6>Skill :</h6> <?=$info['skill'];  ?> <br>
              <h6>Quote :</h6> <?=$info['quote'];  ?>
            </p>
            <a class="btn btn-secondary" href="update_profile.php">Update Profile</a>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php } ?>


    <?php include 'lib/footer.php'; ?>
