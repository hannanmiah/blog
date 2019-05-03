<?php include 'lib/header.php';
$post = new Post(new DB('blog', 'post'));
$date = new Date(new DateTimeZone('Asia/Dhaka'));
?>
<div class="container">
    <form action="" method="post" style="margin-top: 30px;">

        <input type="hidden" class="form-control" id="author" name="author" value="<?= Session::get('username'); ?>">
        <input type="hidden" class="form-control" id="time" name="time" value="<?= $date->now; ?>">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="This is the title">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" rows="3" name="content">This is the post.....</textarea>
        </div>
        <input type="submit" name="post" value="Post" class="btn btn-primary" style="margin-top: 15px;">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['post'])) {
        $data['author'] = $_POST['author'];
        $data['time'] = $_POST['time'];
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];

        $result = $post->create($data);

        if ($result) {
            echo "<div class='alert alert-success'>Successfully posted...</div>";
        } else {
            echo "<div class='alert alert-danger'>Error occured! </div>";
        }
    }

    ?>
</div>
<?php include 'lib/footer.php';
