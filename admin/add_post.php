<?php include 'includes/partials/header.php' ?>
    <?php addPost(); ?>
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2 class="title">Add New Post</h2>
            </div>
            <div class="content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Post Title</label>
                        <input type="text" class="form-control" name="post_title">
                    </div>
                    <div class="form-group">
                        <label for="post_cat_id">Post Category</label>
                        <br>
                        <select name="post_cat_id">
                            <option value="0">Select category</option>
                            <?php 
                                $cat_select = "SELECT * FROM categories";
                                $cat_query = mysqli_query($con, $cat_select);

                                checkSuccess($cat_query);
                        
                                while ($cat = mysqli_fetch_assoc($cat_query)) {
                                    $cat_id = $cat['cat_id'];
                                    $cat_title = $cat['cat_title'];

                                    echo "
                                        <option value='$cat_id'>$cat_title</option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post_author">Post Author</label>
                        <input type="text" class="form-control" name="post_author">
                    </div>
                    <div class="form-group">
                        <label for="post_status">Post Status</label>
                        <br>
                        <select name="post_status">
                                <option value="0">Select post status</option>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post_image">Post Image</label>
                        <input type="file" name="post_image"/>
                    </div>
                    <div class="form-group">
                        <label for="post_tags">Post Tags</label>
                        <input type="text" class="form-control" name="post_tags">
                    </div>
                    <div class="form-group">
                        <label for="post_content">Post Content</label>
                        <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-danger btn-lg" type="submit" name="create_post" value="Publish Post">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include 'includes/partials/footer.php' ?>
