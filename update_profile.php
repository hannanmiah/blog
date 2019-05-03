<?php require 'lib/header.php';
$db_info = new DB('blog', 'user_info');
?>
<div class="container">
  <?php
  $data = $usr->fetch($db_info, 'id', Session::get('id'));
  if (!is_bool($data)) {
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
      $id = Session::get('id');
      $address = trim($_POST['address']);
      $skill = trim($_POST['skill']);
      $quote = trim(($_POST['quote']));
      if (empty($address) || empty($skill)) {
        echo "<div class='alert alert-danger'>*Field must not be empty!</div>";
      } elseif ($data['skill'] == $skill && $data['quote'] == $quote && $data['address'] == $address) {
        echo "<div class='alert alert-warning'>Profile not updated!</div>";
        header("Refresh:2 url=profile.php");
      } else {
        $info = ['id' => $id, 'address' => $address, 'skill' => $skill, 'quote' => $quote];
        $result = $usr->updateProfile($db_info, $info);
        if ($result) { ?>
          <div class='alert alert-success'>Profile Updated....</div>
          <?php header('Refresh:1 url=profile.php');
        } else {
          echo "<div class='alert alert-danger'>Ooops! There was an error!!</div>";
        }
      }
    }   ?>


    <form action="" method="post" id="basic-info">
      <div class="form-group" style="margin-top: 60px;">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Address</span>
          </div>
          <input type="text" class="form-control" name="address" id="address" value="<?php echo $data['address']; ?>">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">Skill</span>
          </div>
          <textarea id="skill" name="skill" class="form-control"><?php echo $data['skill']; ?></textarea>
        </div>
        <div class="input-group" style="margin-top: 15px;">
          <div class="input-group-prepend">
            <span class="input-group-text">Quote</span>
          </div>
          <textarea id="quote" name="quote" class="form-control"><?php echo $data['quote']; ?></textarea>
        </div>
        <input type="submit" name="update" value="Update Profile" class="btn btn-primary" style="margin-top: 15px;">
      </div>
    </form>
  <?php
} else {
  if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $id = Session::get('id');
    $address = $_POST['address'];
    $skill = $_POST['skill'];
    $quote = $_POST['quote'];
    if (empty($address) || empty($skill)) {
      echo "<div class='alert alert-danger'>*Field must not be empty!</div>";
    } else {
      $info = ['id' => $id, 'address' => $address, 'skill' => $skill, 'quote' => $quote];
      $result = $usr->insertProfile($db_info, $info);
      if ($result) { ?>
          <div class='alert alert-success'>Profile Updated....</div>
          <?php header('Location: profile.php');
        } else {
          echo "<div class='alert alert-danger'>Ooops! There was an error!!</div>";
        }
      }
    } ?>



    <form action="" method="post" id="basic-info">
      <div class="form-group" style="margin-top: 60px;">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Address</span>
          </div>
          <input type="text" class="form-control" name="address" id="address" placeholder="Enter Your Full Address">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">Skill</span>
          </div>
          <textarea id="skill" name="skill" class="form-control" placeholder="Enter your skills...." aria-label="Skill"></textarea>
        </div>
        <div class="input-group" style="margin-top: 15px;">
          <div class="input-group-prepend">
            <span class="input-group-text">Quote</span>
          </div>
          <textarea id="quote" name="quote" class="form-control" placeholder="Enter your favourite quote...." aria-label="quote"></textarea>
        </div>
        <input type="submit" name="update" value="Update Profile" class="btn btn-primary" style="margin-top: 15px;">
      </div>
    </form>
  <?php
} ?>
</div>
<?php include 'lib/footer.php'; ?>