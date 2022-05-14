<div class="sidebar" data-background-color="black" data-active-color="danger">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="../index.php" class="simple-text">
                <b>STUFF</b>
            </a>
        </div>
        <ul class="nav">
        <?php 
            $page = basename($_SERVER['PHP_SELF']);

            $active_dash     = '';
            $active_posts    = '';
            $active_cats     = '';
            $active_comments = '';
            $active_users    = '';
            $active_profile  = '';

            switch ($page) 
            {
                case 'index.php': 
                
                    $active_dash     = 'active';
                    break;

                case 'posts.php':
                case 'add_post.php':
                case 'featured.php':
                case 'edit_featured.php':
                case 'edit_post.php':

                    $active_posts    = 'active';
                    break;

                case 'categories.php':
                case 'edit_category.php':

                    $active_cats     = 'active';
                    break;

                case 'comments.php':
                case 'edit_comment.php':

                    $active_comments = 'active';
                    break;

                case 'users.php':
                case 'add_user.php':
                case 'edit_user.php':

                    $active_users    = 'active';
                    break;

                case 'profile.php':

                    $active_profile  = 'active';
                    break;

                default:

                    break;
                    
            }
        ?>
            <li class="<?php echo $active_dash; ?>">
                <a href="index.php">
                    <i class="ti-dashboard"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="<?php echo $active_posts; ?>">
                <a class="dropdown" data-toggle="collapse" href="#posts">
                <i class="nc-icon nc-layout-11"></i>
                <p>
                    <i class="ti-layout-media-left-alt"></i>
                        Posts
                    <b class="caret"></b>
                </p>
                </a>
                <div class="collapse dropdown-toggle" id="posts">
                    <ul class="nav">
                        <li>
                            <a href="posts.php">
                                <span class="sidebar-normal"> View All Posts</span>
                            </a>
                        </li>
                        <li>
                            <a href="featured.php">
                                <div class="sidebar-normal"> Featured Posts</div>
                            </a>
                        </li>
                        <li>
                            <a href="add_post.php">
                                <span class="sidebar-normal"> Add Post</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="<?php echo $active_cats; ?>">
                <a href="categories.php">
                    <i class="ti-direction"></i>
                    <p>Categories</p>
                </a>
            </li>
            <li class="<?php echo $active_comments; ?>"> 
                <a href="comments.php">
                    <i class="ti-comment-alt"></i>
                    <p>Comments</p>
                </a>
            </li>
            <li class="<?php echo $active_users; ?>">
                <a class="collapse-toggle" data-toggle="collapse" href="#users">
                <i class="nc-icon nc-layout-11"></i>
                <p>
                    <i class="ti-user"></i>
                        Users
                    <b class="caret"></b>
                </p>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav open">
                        <li>
                            <a href="users.php">
                                <span class="sidebar-normal"> View All Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="add_user.php">
                                <span class="sidebar-normal"> Add User</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="<?php echo $active_profile; ?>">
                <a href="profile.php">
                    <i class="ti-settings"></i>
                    <p>Profile</p>
                </a>
            </li>
        </ul>
    </div>
</div>