<?php include 'includes/partials/header.php' ?>
    <?php 
        editPost();
    ?>
    <div class="card">
        <div class="header">
            <h2 class="title">Edit Post</h2>
        </div>
        <div class="content">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="post_title">Post Title</label>
                    <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
                </div>
                <div class="form-group">
                    <label for="post_cat_id">Post Category Id</label>
                    <br>
                    <select name="post_category">
                        <option value="0">Select category</option>
                        <?php 
                            $cat_select = "SELECT * FROM categories";
                            $cat_query = mysqli_query($con, $cat_select);

                            checkSuccess($cat_query);
                    
                            while ($row = mysqli_fetch_assoc($cat_query)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];

                                echo "
                                    <option value='$cat_id'>$cat_title</option>
                                ";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post_author">Post Author</label>
                    <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
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
                    <br>
                    <img src="../img/<?php echo $post_image; ?>" width="200">
                    <br>
                    <input type="file" name="post_image"/>
                </div>
                <div class="form-group">
                    <label for="post_tags">Post Tags</label>
                    <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
                </div>
                <div class="form-group">
                    <label for="post_content">Post Content</label>
                    <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
                </div>
                <div class="form-group">
                    <input class="btn btn-danger btn-lg" type="submit" name="update" value="Update Post">
                </div>
            </form>
        </div>
    </div>
<?php include 'includes/partials/footer.php' ?>
