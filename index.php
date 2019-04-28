<?php require 'lib/header.php';
$db_info=new DB('blog', 'user_info');
$data = $usr->fetch($db_info, 'id', Session::get('id'));
$post= new Post(new DB('blog', 'post'));
$date=new Date(new DateTimeZone('Asia/Dhaka'));
if (is_bool($data)) {
    header('Location: update_profile.php');
}
?>
<!-- Page Header -->
<header class="masthead" style="background-image: url('img/home-bg.jpg')">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="site-heading">
          <h1>Clean Blog</h1>
          <span class="subheading">A Blog Theme by Hridoy</span>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <?php

        $data=$post->readAll();

        foreach ($data as $posts) :
            ?>
        <div class="post-preview">
          <a href="post.html">
            <h2 class="post-title">
              <?php echo $posts['title']; ?>
            </h2>
            <h3 class="post-subtitle">
              <?php echo $posts['content']; ?>
            </h3>
          </a>
          <p class="post-meta">Posted by
            <a href="#"><?php echo $posts['author']; ?></a>
            on <?php echo $date->getDiff($posts['time'])." ago"; ?></p>
        </div>
        <hr>

        <?php endforeach; ?>
        <!-- Pager -->
        <div class="clearfix">
          <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
        </div>
      </div>
    </div>
  </div>

  <hr>

<?php include 'lib/footer.php'; ?>
