<?php include 'lib/header.php'; ?>
<div class="container">
    <form action="" method="post" style="margin-top: 30px;">
        
        <input type="hidden" class="form-control" id="author" name="author">
        <input type="hidden" class="form-control" id="time" name="time">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" rows="3" name="content"></textarea>
        </div>
        <input type="submit" name="post" value="Post" class="btn btn-primary" style="margin-top: 15px;">
    </form>
</div>
<?php include 'lib/footer.php';