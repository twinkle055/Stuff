<?php include 'includes/partials/header.php' ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <div class="card">
                    <?php 
                        if (isset($_POST['feat_post_1'])) 
                        {
                            $feat_post_id   = $_POST['feat_post_id'];
                            $feat_img       = $_FILES['feat_img']['name'];
                            $feat_img_temp  = $_FILES['feat_img']['tmp_name'];
                            
                            if (($feat_post_id === 0) || (empty($feat_img))) 
                            {
                                echo "
                                    <p class='alert-danger'>Fields can't be empty!
                                ";
                            } 
                            else 
                            {
                                move_uploaded_file($feat_img_temp, "../img/$feat_img");
                        
                                $feat_update  = "UPDATE featured SET   feat_img     = '$feat_img', 
                                                                       feat_post_id = $feat_post_id 
                                                                 WHERE feat_post_id = $feat_post_id";
                                                                     
                                $update_query = mysqli_query($con, $feat_update);
                        
                                checkSuccess($update_query);
                        
                                header("Location: featured.php");
                            }
                        }
                    ?>
                    <div class="header">
                        <?php
                            $feat_id = $_GET['feat_id'];
                            $feat_select = "SELECT * FROM featured WHERE feat_id = $feat_id";
                            $feat_query = mysqli_query($con, $feat_select);
                            checkSuccess($feat_query);
                            while ($row = mysqli_fetch_assoc($feat_query))
                            {
                                $feat_post_id = $row['feat_post_id'];
                                $feat_img = $row['feat_img'];

                                $post_select = "SELECT * FROM posts WHERE post_id = $feat_post_id";
                                $post_query = mysqli_query($con, $post_select);
                                checkSuccess($post_query);

                                while ($row = mysqli_fetch_assoc($post_query)) {
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];
                                }
                            }
                        ?>
                        <h2 class="title">Featured Post <?php echo $feat_id; ?>: <small><?php echo $post_title; ?></small></h2>
                    </div>
                    <div class="content">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="feat_post_id">Select post:</label>
                                <br>
                                <select name="feat_post_id" id="">
                                    <option value="0">Select post</option>
                                    <?php 
                                        $post_select = "SELECT * FROM posts WHERE post_status = 'published'";
                                        $post_query = mysqli_query($con, $post_select);
                        
                                        checkSuccess($post_query);
                        
                                        while ($row = mysqli_fetch_assoc($post_query)) 
                                        {
                                            $post_id     = $row['post_id'];
                                            $post_title  = $row['post_title'];
                                            $post_image  = $row['post_img'];

                                            echo "
                                                <option value='$post_id'>$post_title</option>
                                            ";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <img src="../img/<?php echo $feat_img; ?>" width="200">
                                <br>
                                <label for="feat_img">Featured image:</label>
                                <input type="file" name="feat_img">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-danger" type="submit" name="feat_post_1" value="Add featured post">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/partials/footer.php' ?>
