<?php require "lib/header.php";
$post = new Post(new DB('blog', 'post'));
$date = new Date(new DateTimeZone('Asia/Dhaka'));
?>

<div class="container" style="margin-top: 40px;">
    <div class="row">
        <?php
        if (isset($_GET['id'])) :
            $id = $_GET['id'];
            $msg = "";
            if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['submit'])) {
                $content = $_POST['content'];
                $author = $_POST['author'];
                $time = $_POST['time'];
                $comment_data = ['content' => $content, 'author' => $author, 'time' => $time];

                if ($post->create($id, $comment_data)) {
                    $msg = "<div class='alert alert-success'>commented successfully!!!</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Something went wrong!!! Try again....</div>";
                }
            }
            $data = $post->read($id);
            $comments = $post->read($id, 'DESC');
            ?>
            <div class="post-preview" id="post">
                <h2 class="post-title">
                    <?php echo $data['title']; ?>
                </h2>
                <h6 class="post-subtitle">
                    <?php echo $data['content']; ?>
                    </h3>
                    <p class="post-meta"><br>--
                        <a href="#"><?php echo $data['author']; ?></a>
                        ( <?php echo $date->getDiff($data['time']) . " ago )"; ?></p>
            </div>
            <hr>
        </div>

        <nav class="navbar navbar-dark bg-info"> Comments</nav>
        <?php

        if (is_bool($comments)) :
            ?>
            <h3 class="post-subtitle">
                No comments available....
            </h3>
        <?php else :
            if ($msg != null) {
                echo $msg;
            }
            foreach ($comments as $comment) :
                ?>
                <div class="post-preview" id="comments">
                    <p class="post-meta">
                        <a href="#"><?= $comment['author']; ?></a>
                    </p>
                    <h3 class="post-subtitle">
                        <?= $comment['content']; ?>
                    </h3>
                </div>
            <?php
            endforeach;
        endif;
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="comment">Write a comment</label>
                <textarea class="form-control" id="comment" name="content" rows="3"></textarea>
                <input type="hidden" name="author" value="<?= Session::get('username'); ?>">
                <input type="hidden" name="time" value="<?= $date->now; ?>">
                <input type="submit" name="submit" value="Comment" class="btn btn-info">
            </div>
        </form>
        <div class="row"></div>

    </div>

<?php
endif;
require "lib/footer.php"; ?>