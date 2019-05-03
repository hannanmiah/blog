<?php require 'lib/header.php';
if (Session::check() and isset($_SESSION['login'])) {
  $db_info = new DB('blog', 'user_info');
  $data = $usr->fetch($db_info, 'id', Session::get('id'));
  if (is_bool($data)) {
    header('Location: update_profile.php');
  }
}
$post = new Post(new DB('blog', 'post'));
$date = new Date(new DateTimeZone('Asia/Dhaka'));
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
      $page = 1;
      if (isset($_GET['page'])) {
        $page = $_GET['page'];
        $limit = $post->paginate($page, 5);
        $page++;
      } else {
        $limit = $post->paginate($page, 5);
        $page++;
      }

      $data = $post->readAll($limit);
      $count = $post->count($limit);
      if ($count > 0) :
        foreach ($data as $posts) :
          ?>
          <div class="post-preview" id="post">
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
              on <?php echo $date->getDiff($posts['time']) . " ago"; ?></p>
          </div>
          <hr>
        <?php endforeach;
      $lim['upper'] = $limit['upper'] + 1;
      $lim['lower'] = $limit['lower'];
      $limDiff = $lim['upper'] - $lim['lower'];
      if ($post->count($lim) == $limDiff) :
        ?>
          <!-- Pager -->
          <div class="clearfix">
            <a class="btn btn-primary float-right" href="<?php echo $_SERVER['PHP_SELF'] . "?page=" . $page; ?>">Older Posts &rarr;</a>
          </div>
        <?php
      endif;
    else :
      ?>
        <div class="post-preview">
          <h3 class="post-subtitle">
            Nothing to display!
          </h3>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<hr>

<script>
  $(".post-preview").hover(
    function() {
      $(this).append($("<span class='d-flex justify-content-end'>Edit Delete</span>"));
    },
    function() {
      $(this).find("span:last").remove();
    }
  );

  $("li.fade").hover(function() {
    $(this).fadeOut(100);
    $(this).fadeIn(500);
  });
</script>
<?php include 'lib/footer.php'; ?>