<?php include 'includes/partials/header.php' ?>
    <?php 
        updatePostStatus();
        deletePost();
    ?>
    <div class="col-lg-12">
        <div class="form-group">
            <a href="add_post.php" class="btn btn-danger">Add new post</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Published</th>
                                <th>Image</th>
                                <th>Tags</th>
                                <th>Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php displayPosts(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/partials/footer.php' ?>
