<?php include 'includes/partials/header.php' ?>
    <div class="col-lg-12">
        <?php 
            editComment();
        ?>
    </div>
    <div class="col-lg-12">
        <div class="card">
                <div class="header">
                    <h2 class="title">Edit Comment</h2>
                </div>
                <div class="content">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="comment_content">Content</label>
                            <textarea type="text" class="form-control" name="comment_content" id="" cols="30" rows="10"><?php echo $comment_content; ?></textarea>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-danger btn-lg" type="submit" name="update" value="Update Comment">
                        </div>
                    </form>
                </div>
            </div>
<?php include 'includes/partials/footer.php' ?>
