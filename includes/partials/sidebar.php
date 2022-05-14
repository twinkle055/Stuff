<div class="sidebar">
    <div class="side">
        <h2 class="sidebar-heading">Search Blog</h2>
        <form action="search.php" method="POST">
            <div class="form-group">
                <input name="search" type="text" class="form-control" placeholder="Search...">
                <button name="submit" type="submit" class="btn btn-primary"><i class="icon-search3"></i></button>
            </div>
        </form>
    </div>
    <div class="side">
        <h2 class="sidebar-heading">Categories</h2>
        <p>
            <ul class="category">
                <?php 
                    $cat_select = "SELECT * FROM categories";
                    $cat_query = mysqli_query($con, $cat_select);

                    checkSuccess($cat_query);

                    while ($cat = mysqli_fetch_assoc($cat_query)) {
                        $cat_id = $cat['cat_id'];
                        $cat_title = $cat['cat_title'];
                        echo "<li><a href='category.php?cat_id=$cat_id'><i class='icon-check'></i>$cat_title</a></li>";
                    }
                ?>
            </ul>
        </p>
    </div>
    <div class="side">
        <h2 class="sidebar-heading">Recent Posts</h2>
        <?php 
            $post_select = "SELECT * FROM posts ORDER BY post_date DESC LIMIT 4";
            $post_query = mysqli_query($con, $post_select);

            while ($post = mysqli_fetch_assoc($post_query)) {
                $post_id = $post['post_id'];
                $post_img = $post['post_img'];
                $post_date = $post['post_date'];
                $post_title = $post['post_title'];

                echo "
                    <div class='f-blog'>
                        <a href='single.php?post_id=$post_id' class='blog-img' style='background-image: url(img/$post_img);'>
                        </a>
                        <div class='desc'>
                            <h3><a href='single.php?post_id=$post_id'>$post_title</a></h3>
                            <p class='admin'><span>" . date('d F Y', strtotime($post_date)) . "</span></p>
                        </div>
                    </div>
                ";
            }
        ?>
    </div>
    <!-- <div class="side">
        <h2 class="sidebar-heading">Subscribe</h2>
        <div class="form-group">
            <input type="text" class="form-control form-email text-center" id="email" placeholder="Enter your email">
            <button type="submit" class="btn btn-primary btn-subscribe">Subscribe</button>
        </div>
    </div> -->
</div>
