<?php include '../functions.php'; ?>
    <?php

        // TABLE COUNT

        function tableCount($table) 
        {

            global $con;

            $table_select = "SELECT * FROM " . $table;

            $table_query  = mysqli_query($con, $table_select);

            checkSuccess($table_query);

            return mysqli_num_rows($table_query);

        }

        // ADD POST

        function addPost() 
        {

            global $con;

            if (checkUserRole()) 
            {

                if (isset($_POST['create_post'])) 
                {

                    $post_title      = mysqli_real_escape_string($con, ($_POST['post_title']));
                    $post_cat_id     = mysqli_real_escape_string($con, ($_POST['post_cat_id']));
                    $post_author     = mysqli_real_escape_string($con, ($_POST['post_author']));
                    $post_status     = mysqli_real_escape_string($con, ($_POST['post_status']));
                    $post_image      = $_FILES['post_image']['name'];
                    $post_image_temp = $_FILES['post_image']['tmp_name'];
                    $post_tags       = mysqli_real_escape_string($con, ($_POST['post_tags']));
                    $post_content    = mysqli_real_escape_string($con, ($_POST['post_content']));
                    $post_date       = date('d/m/Y');
        
                    if  ((empty($post_title))  || ($post_cat_id === "0") || 
                         (empty($post_author)) || ($post_status === "0") || 
                         (empty($post_tags))   || (empty($post_content)  )) 
                        {

                        echo "
                            <p class='alert-danger'>Fields cannot be empty...</p>
                        ";

                    } 
                    else 
                    {

                        move_uploaded_file($post_image_temp, "../img/$post_image");
                
                        $post_insert = "INSERT INTO posts(post_title,    post_cat_id,   post_author,    post_status,    
                                                          post_img,      post_tags,     post_content,   post_date) 
                                               VALUES   ('$post_title',  $post_cat_id, '$post_author', '$post_status', 
                                                         '$post_image', '$post_tags',  '$post_content', now()) ";
                
                        $post_query = mysqli_query($con, $post_insert);
                
                        checkSuccess($post_query);
                
                        header("Location: posts.php?post_id=$post_id");

                    }
                }
            }
        } 

        // CHECK POST STATUS

        function checkPostStatus($post_status) 
        {
            if (checkUserRole()) 
            {
                if ($post_status === "published") 
                {
                    return "
                        <i class='fa fa-check text-success'></i>
                    ";

                } 
                else if ($post_status === "draft") 
                {
                    return "
                            <i class='fa fa-times text-danger'></i>
                        ";

                }

            }

        }

        // TOGGLE POST STATUS

        function togglePostStatus($post_id, $post_status) 
        {
            if (checkUserRole()) 
            {
                if ($post_status === "published") 
                {
                    return "            
                        <a href='posts.php?draft=$post_id'><i class='ti-close text-danger'></i></a>
                    ";

                } 
                else if ($post_status === "draft") 
                {
                    return "
                        <a href='posts.php?publish=$post_id'><i class='ti-check text-success'></i></a>
                    ";

                }

            }

        }

        // DISPLAY FEATURED POSTS

        function displayFeaturedPosts()
        {
            global $con;

            $feat_select = "SELECT * FROM featured";
            $feat_query = mysqli_query($con, $feat_select);

            checkSuccess($feat_query);

            while ($row = mysqli_fetch_assoc($feat_query))
            {
                $feat_id      = $row['feat_id'];
                $feat_post_id = $row['feat_post_id'];
                $feat_img     = $row['feat_img'];

                $post_select = "SELECT * FROM posts WHERE post_id = $feat_post_id";
                $post_query  = mysqli_query($con, $post_select);

                checkSuccess($post_query);

                while ($row = mysqli_fetch_assoc($post_query)) 
                {
                    $post_id    = $row['post_id'];
                    $post_title = $row['post_title'];

                    echo "
                        <div class='col-md-4'>
                            <h3>Featured Post $feat_id:</h3>
                            <div class='typo-line'>$post_title</div>
                            <br>
                            <img src='../img/$feat_img' width='250'>
                            <br>
                            <br>
                            <a href='edit_featured.php?feat_id=$feat_id'><i class='ti-pencil text-warning fs-lg'></i></a></a>
                        </div>
                    ";
                }

            }
        }

        // DISPLAY POSTS

        function displayPosts() 
        {
            global $con;

            $post_select = "SELECT * FROM posts";

            $post_query  = mysqli_query($con, $post_select);

            checkSuccess($post_query);

            while ($row = mysqli_fetch_assoc($post_query)) 
            {
                $post_id     = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title  = $row['post_title'];
                $post_cat_id = $row['post_cat_id'];
                $post_status = $row['post_status'];
                $post_image  = $row['post_img'];
                $post_tags   = $row['post_tags'];
                $post_date   = $row['post_date'];

                $comment_count_select = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                
                $comment_count_query  = mysqli_query($con, $comment_count_select);

                checkSuccess($comment_count_query);

                $comment_count = mysqli_num_rows($comment_count_query);

                $cat_select = "SELECT * FROM categories WHERE cat_id = $post_cat_id";

                $cat_query  = mysqli_query($con, $cat_select);

                checkSuccess($cat_query);
                
                while ($row = mysqli_fetch_assoc($cat_query)) 
                {
                    $cat_id    = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    postMarkup($post_id,   $post_author, $post_title,    $cat_id,    $cat_title, 
                               $post_tags, $post_image,  $comment_count, $post_date, $post_status);

                }
            }
        }

        // POST MARKUP

        function postMarkup($post_id,   $post_author, $post_title,    $cat_id,    $cat_title, 
                            $post_tags, $post_image,  $comment_count, $post_date, $post_status) 

            {
                echo "
                    <tr>
                        <td>$post_id</td>
                        <td><a href='" . ROOT_URL . "author.php?post_author=$post_author&post_id=$post_id' 
                                target='_blank'>$post_author</a></td>
                        <td><a href='" . ROOT_URL . "single.php?post_id=$post_id' 
                                target='_blank'>" . substr($post_title, 0, 15) . "...</a></td>
                        <td><a href='" . ROOT_URL . "category.php?cat_id=$cat_id' 
                                target='_blank'>$cat_title</a></td>
                        <td>" . checkPostStatus($post_status) . "</td>
                        <td><a href='" . ROOT_URL . "single.php?post_id=$post_id' target='_blank'>
                                <img src='../img/$post_image' width='50'></a></td>
                        <td>" . substr($post_tags, 0, 25) . " ...</td>
                        <td>$comment_count</td>
                        <td>
                            " . date('d/m/y', strtotime($post_date)). "
                            <span class='pull-right'>
                                " . togglePostStatus($post_id, $post_status) . "

                                <a href='edit_post.php?edit=$post_id'>
                                    <i class='ti-pencil text-warning'></i></a>

                                <a onclick=\"javascript: return confirm('Are you sure you want to delete this post?');\" 
                                    href='posts.php?delete=$post_id'><i class='ti-trash text-danger'></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                ";

            }

        // EDIT POST
        function editPost() 
        {
            global $con,         $post_id,     $post_title,  $post_cat_id,  $post_author, 
                   $post_status, $post_image,  $post_tags,   $post_content;

            if (checkUserRole()) 
            {
                if (isset($_GET['edit'])) 
                {
                    $post_id     = $_GET['edit'];

                    $post_select = "SELECT * FROM posts WHERE post_id = $post_id";

                    $post_query  = mysqli_query($con, $post_select);
        
                    checkSuccess($post_query);
        
                    while($row = mysqli_fetch_assoc($post_query)) 
                    {
                        $post_id      = $row['post_id'];
                        $post_title   = $row['post_title'];
                        $post_cat_id  = $row['post_cat_id'];
                        $post_author  = $row['post_author'];
                        $post_status  = $row['post_status'];
                        $post_image   = $row['post_img'];
                        $post_tags    = $row['post_tags'];
                        $post_content = $row['post_content'];

                        updatePost($con, $post_id);

                    }

                }

            }

        }

        // UPDATE POST
        function updatePost($con, $post_id) 
        {
            if (isset($_POST['update'])) 
            {
                $post_title      = $_POST['post_title'];
                $post_cat_id     = $_POST['post_category'];
                $post_author     = $_POST['post_author'];
                $post_status     = $_POST['post_status'];
                $post_image      = $_FILES['post_image']['name'];
                $post_image_temp = $_FILES['post_image']['tmp_name'];
                $post_tags       = $_POST['post_tags'];
                $post_content    = $_POST['post_content'];
    
                move_uploaded_file($post_image_temp, "../img/$post_image");

                if (empty($post_image)) 
                {
                    $image_select = "SELECT * FROM posts WHERE post_id = $post_id";

                    $image_query  = mysqli_query($con, $image_select); 
        
                    checkSuccess($image_query);
        
                    $post_image = mysqli_fetch_array($image_query);
                    $post_image = $post_image['post_img'];

                }

                validatePost($con,         $post_id,     $post_title,  $post_cat_id,   $post_author, 
                             $post_status, $post_image,  $post_tags,   $post_content);

            }

        }

        // CHECK POST

        function validatePost($con,         $post_id,     $post_title,  $post_cat_id,  $post_author, 
                              $post_status, $post_image,  $post_tags,   $post_content) 
        {   
            if ((empty($post_title))  || ($post_cat_id == "0") || 
                (empty($post_author)) || ($post_status == "0") || 
                (empty($post_tags))   || (empty($post_content) )) 
                {

                echo "
                    <p class='alert-danger'>Fields cannot be empty...</p>
                ";

            } 
            else 
            {
                $post_update  = "UPDATE posts SET post_title   = '$post_title',  post_cat_id   = '$post_cat_id', 
                                                  post_author  = '$post_author', post_status   = '$post_status', 
                                                  post_img     = '$post_image',  post_tags     = '$post_tags', 
                                                  post_content = '$post_content' WHERE post_id =  $post_id";
    
                $update_query = mysqli_query($con, $post_update);
    
                checkSuccess($update_query);
    
                header("Location: posts.php");

            }

        }

        // UPDATE POST STATUS

        function updatePostStatus() 
        {
            global $con;

            if (checkUserRole()) 
            {
                if (isset($_GET['publish'])) 
                {
                    $post_id     = mysqli_real_escape_string($con, ($_GET['publish']));

                    $post_update = "UPDATE posts SET   post_status = 'published' 
                                                 WHERE post_id     = $post_id";

                    $post_query  = mysqli_query($con, $post_update);

                    checkSuccess($post_query);

                    header("Location: posts.php");

                } 
                else if (isset($_GET['draft'])) 
                {
                    $post_id     = mysqli_real_escape_string($con, ($_GET['draft']));
                    $post_update = "UPDATE posts SET   post_status = 'draft' 
                                                 WHERE post_id     = $post_id";
                    $post_query  = mysqli_query($con, $post_update);

                    checkSuccess($post_query);

                    header("Location: posts.php");

                }

            }

        }

        // DELETE POST

        function deletePost() 
        {

            global $con;

            if (checkUserRole()) 
            {
                if (isset($_GET['delete'])) 
                {
                    $post_id      = mysqli_real_escape_string($con, ($_GET['delete']));
                    $post_delete  = "DELETE FROM posts WHERE post_id = $post_id";
                    $delete_query = mysqli_query($con, $post_delete);
        
                    checkSuccess($delete_query);
        
                    header("Location: posts.php");

                }

            }

        }

        // COMMENT STATUS ICON

        function commentStatusIcon($comment_status) 
        {
            if ($comment_status === "approved") 
            {
                return "
                    <i class='fa fa-check text-success'></i>
                ";
            } 
            else if ($comment_status === "unapproved")
            {

                return "
                    <i class='fa fa-times text-danger'></i>
                    ";
            }

        }
        
        // DISPLAY COMMENTS 

        function displayComments() 
        {
            global $con;

            $comment_select = "SELECT * FROM comments ORDER BY comment_date DESC";
            $comment_query  = mysqli_query($con, $comment_select);

            checkSuccess($comment_query);

            insertCommentMarkup($comment_query);
        }

        // INSERT COMMENT MARKUP

        function insertCommentMarkup($comment_query) 
        {
            global $con;
            
            while ($row = mysqli_fetch_assoc($comment_query)) 
            {
                $comment_id         = $row['comment_id'];
                $comment_first_name = $row['comment_first_name'];
                $comment_last_name  = $row['comment_last_name'];
                $comment_content    = $row['comment_content'];
                $comment_email      = $row['comment_email'];
                $comment_status     = $row['comment_status'];
                $comment_post_id    = $row['comment_post_id'];
                $comment_date       = $row['comment_date'];

                $post_select = "SELECT * FROM posts WHERE post_id = $comment_post_id";

                $post_query  = mysqli_query($con, $post_select);

                checkSuccess($post_query);
            
                while ($row = mysqli_fetch_assoc($post_query)) 
                {
                    $post_id    = $row['post_id'];
                    $post_title = $row['post_title'];

                    echo "
                        <tr>
                            <td>$comment_id</td>
                            <td>$comment_first_name $comment_last_name</td>
                            <td>
                                <a href='" . ROOT_URL . "single.php?post_id=$post_id' target='_blank'> 
                                    " . substr($comment_content, 0, 10) ."
                                </a> 
                                [<a href='" . ROOT_URL . "single.php?post_id=$post_id' 
                                    target='_blank'>...</a>]
                            </td>
                            <td>$comment_email</td>
                            <td>
                                " . commentStatusIcon($comment_status) . "
                            </td>
                            <td><a href='" . ROOT_URL . "single.php?post_id=$post_id' 
                                    target='_blank'>$post_title</a></td>
                            <td>
                                " . date('d/m/Y', strtotime($comment_date)). "
                                <span class='pull-right'>
                                    " . toggleCommentStatus($comment_id, $comment_status) . "
                                    <a href='edit_comment.php?edit=$comment_id'><i class='ti-pencil text-warning'></i></a>
                                    <a onclick=\"javascript: return confirm('Are you sure you want to delete this comment?');\"
                                        href='comments.php?delete=$comment_id'><i class='ti-trash text-danger'></i></a>
                                </span>
                            </td>
                        </tr>
                    ";

                }

            }

        }

        //TOGGLE COMMENT STATUS

        function toggleCommentStatus($comment_id, $comment_status) 
        {
            if ($comment_status === "approved") 
            {
                return "
                    <a href='comments.php?unapprove=$comment_id'><i class='ti-close text-danger'></i></a>
                ";

            } 
            else if ($comment_status === "unapproved") 
            {
                return "
                    <a href='comments.php?approve=$comment_id'><i class='ti-check text-success'></i></a>
                ";

            }

        }

        // EDIT COMMENT

        function editComment() 
        {
            global $con, $comment_content;

            if (checkUserRole()) 
            {
                if (isset($_GET['edit'])) 
                {
                    $comment_id      = mysqli_real_escape_string($con, ($_GET['edit']));
                    $comment_select  = "SELECT * FROM comments WHERE comment_id = $comment_id";
                    $comment_query   = mysqli_query($con, $comment_select);
            
                    while($row = mysqli_fetch_assoc($comment_query)) 
                    {

                        $comment_id      = $row['comment_id'];
                        $comment_content = $row['comment_content'];
        
                        updateComment($con, $comment_id);

                    }

                }

            }

        }

        // UPDATE COMMENT
        function updateComment($con, $comment_id) 
        {
            if (isset($_POST['update'])) 
            {
                $comment_content = mysqli_real_escape_string($con, ($_POST['comment_content']));
                checkComment($con, $comment_id, $comment_content);

            }

        }

        // CHECK COMMENT

        function checkComment($con, $comment_id, $comment_content) 
        {
            if (empty($comment_content)) 
            {
                echo "
                    <p class='alert-danger'>Field cannot be empty...</p>
                ";

            } 
            else 
            {
                $comment_update = "UPDATE comments SET   comment_content = '$comment_content' 
                                                   WHERE comment_id      =  $comment_id";

                $update_query   = mysqli_query($con, $comment_update);
    
                checkSuccess($update_query);

                header("Location: comments.php");

            }

        }

        // UPDATE COMMENT STATUS 

        function updateCommentStatus() 
        {
            global $con;

            if (checkUserRole()) 
            {

                if (isset($_GET['unapprove'])) 
                {
                    $comment_id     = mysqli_real_escape_string($con, ($_GET['unapprove']));

                    $comment_update = "UPDATE comments SET   comment_status = 'unapproved' 
                                                       WHERE comment_id     =  $comment_id";

                    $comment_query  = mysqli_query($con, $comment_update);
    
                    checkSuccess($comment_query);
    
                    header("Location: comments.php");

                }
                if (isset($_GET['approve'])) 
                {
                    $comment_id = mysqli_real_escape_string($con, ($_GET['approve']));

                    $comment_update = "UPDATE comments SET   comment_status = 'approved' 
                                                       WHERE comment_id     =  $comment_id";

                    $comment_query = mysqli_query($con, $comment_update);
    
                    checkSuccess($comment_query);
    
                    header("Location: comments.php");

                }

            }

        }

        // DELETE COMMENT

        function deleteComment() 
        {
            global $con;

            if (checkUserRole()) 
            {
                if (isset($_GET['delete'])) 
                {

                    $comment_id     = mysqli_real_escape_string($con, ($_GET['delete']));

                    $comment_delete = "DELETE FROM comments WHERE comment_id = $comment_id";

                    $delete_query   = mysqli_query($con, $comment_delete);
    
                    checkSuccess($delete_query);
    
                    header("Location: comments.php");
                
                }
                
            }

        }

        // ADD USER

        function addUser() 
        {
            global $con;

            if (isset($_POST['add_user'])) 
            {

                if (checkUserRole()) 
                {

                    $username         = mysqli_real_escape_string($con, ($_POST['username']));
                    $password         = mysqli_real_escape_string($con, ($_POST['password']));
                    $confirm_password = mysqli_real_escape_string($con, ($_POST['confirm_password']));
                    $first_name       = mysqli_real_escape_string($con, ($_POST['first_name']));
                    $last_name        = mysqli_real_escape_string($con, ($_POST['last_name']));
                    $email            = mysqli_real_escape_string($con, ($_POST['email']));
                    $role             = mysqli_real_escape_string($con, ($_POST['role']));
                    $date             = date('d/m/Y');

                    validateUser($con,       $username, $password,  $confirm_password, $first_name,     
                                 $last_name, $email,    $role,      $date);

                }

            }

        }

        // VALIDATE USER

        function validateUser($con,       $username, $password,  $confirm_password,  $first_name,    
                              $last_name, $email,    $role,      $date) 
        {
            if ((empty($username))   || (empty($password))  || 
                (empty($first_name)) || (empty($last_name)) || 
                (empty($email))      || ($role === "0")) 
            {
                echo "
                    <p class='alert-danger'>Fields cannot be empty...</p>
                ";
            } 
            else if (checkDuplicateUsername($username)) 
            {
                echo "
                    <p class='alert-danger'>User already exists...</p>
                ";
            } 
            else  if (checkDuplicateEmail($email)) 
            {
                echo "
                    <p class='alert-danger'>Another account is using this email address...
                ";
            } 
            else if ($password !== $confirm_password) 
            {
                echo "
                    <p class='alert-danger'>Password's don't match...</p>
                ";
            } 
            else 
            {
                $randSalt_select = "SELECT randSalt FROM users";
                $randSalt_query  = mysqli_query($con, $randSalt_select);
        
                checkSuccess($randSalt_query);
        
                $randSalt        = mysqli_fetch_array($randSalt_query);
                $randSalt        = $randSalt['randSalt'];
                $hashed_password = crypt($password, $randSalt);

                $user_insert     = "INSERT INTO users (user_username,  user_password,      user_first_name, user_last_name, 
                                                       user_email,     user_role,          user_date)      
                                           VALUES    ('$username',    '$hashed_password', '$first_name',   '$last_name', 
                                                      '$email',       '$role',             now())";
    
                $user_query = mysqli_query($con, $user_insert);
        
                checkSuccess($user_query);
        
                header("Location: users.php");
            }

        }

        // DISPLAY USERS

        function displayUsers() 
        {
            global $con;

            $user_select = "SELECT * FROM users ORDER BY user_id DESC";
            $user_query = mysqli_query($con, $user_select);

            checkSuccess($user_query);

            while ($row = mysqli_fetch_assoc($user_query)) 
            {
                $user_id         = $row['user_id'];
                $user_username   = $row['user_username'];
                $user_first_name = $row['user_first_name'];
                $user_last_name  = $row['user_last_name'];
                $user_email      = $row['user_email'];
                $user_role       = $row['user_role'];
                $user_date       = $row['user_date'];        

                usersMarkup($user_id,        $user_username, $user_first_name, 
                            $user_last_name, $user_email,    $user_role,               
                            $user_date);
            }
        }

        // USER MARKUP

        function usersMarkup($user_id,        $user_username, $user_first_name, 
                             $user_last_name, $user_email,    $user_role, 
                             $user_date) 
        {
            echo "
                <tr>
                    <td>$user_id</td>
                    <td>$user_username</td>
                    <td>$user_first_name $user_last_name</td>
                    <td>$user_email</td>
                    <td>$user_role</td>
                    <td>
                        " . date('d/m/Y', strtotime($user_date)). "
                        <span class='pull-right'>
                            <a href='edit_user.php?edit=$user_id'><i class='ti-pencil text-warning'></i></a>
                            <a onclick=\"javascript: return confirm('Are you sure you want to delete this user?');\"
                                href='users.php?delete=$user_id'><i class='ti-trash text-danger'></i></a>
                        </span>
                    </td>
                </tr>
            ";
        }

        //EDIT USER

        function editUser() 
        {
            global $con,        $username,  $password, 
                   $first_name, $last_name, $email,    
                   $role;

            if (checkUserRole()) 
            {
                if (isset($_GET['edit'])) 
                {
                    $user_id     = $_GET['edit'];
                    $user_select = "SELECT * FROM users WHERE user_id = $user_id";
                    $user_query  = mysqli_query($con, $user_select);
    
                    while($row = mysqli_fetch_assoc($user_query)) 
                    {
                        $id         = $row['user_id'];
                        $username   = $row['user_username'];
                        $password   = $row['user_password'];
                        $first_name = $row['user_first_name'];
                        $last_name  = $row['user_last_name'];
                        $email      = $row['user_email'];
                        $role       = $row['user_role'];

                        updateUser($con, $id);
                    }  

                }

            }

        }

        //UPDATE USER

        function updateUser($con, $id) 
        {
            if (isset($_POST['update'])) 
            {
                $username   = $_POST['username'];
                $password   = $_POST['password'];
                $first_name = $_POST['first_name'];
                $last_name  = $_POST['last_name'];
                $email      = $_POST['email'];
                $role       = $_POST['role'];

                checkUser($con,        $id,        $username, $password, 
                          $first_name, $last_name, $email,    $role);
            }

        }

        // CHECK USER

        function checkUser($con,        $id,        $username, $password, 
                           $first_name, $last_name, $email,    $role) 
        {

            if ((empty($username))   || (empty($password))  || 
                (empty($first_name)) || (empty($last_name)) || 
                (empty($email))      || ($role === "0")) 
                {

                echo "<p class='alert-danger'>Fields cannot be empty...</p>";

            } 
            else 
            {
                $randSalt_select = "SELECT randSalt FROM users";
                $randSalt_query  = mysqli_query($con, $randSalt_select);
    
                checkSuccess($randSalt_query);
    
                $randSalt = mysqli_fetch_array($randSalt_query);
                $randSalt = $randSalt['randSalt'];
    
                $hashed_password = crypt($password, $randSalt);
    
                $user_update = "UPDATE users SET user_username   = '$username',     user_password   = '$hashed_password', 
                                                 user_first_name = '$first_name',   user_last_name  = '$last_name', 
                                                 user_email      = '$email',        user_role       = '$role'
                                                 WHERE user_id = $id";
    
                $update_query = mysqli_query($con, $user_update);
    
                checkSuccess($update_query);
                
                header("Location: users.php");

            }

        }

        //DELETE USER

        function deleteUser() 
        {
            global $con;

            if (checkUserRole()) 
            {
                if (isset($_GET['delete'])) 
                {
                    $user_id      = mysqli_real_escape_string($con, ($_GET['delete']));
                    $user_delete  = "DELETE FROM users WHERE user_id = $user_id";
                    $delete_query = mysqli_query($con, $user_delete);
        
                    checkSuccess($delete_query);
        
                    header("Location: users.php");
                }

            }
            
        }

        //EDIT PROFILE

        function editProfile() 
        {
            global $con, $username, $password, $first_name, 
                   $last_name, $email, $role, $date;

            if (isset($_SESSION['username'])) 
            {
                $username    = $_SESSION['username'];
                $user_select = "SELECT * FROM users WHERE user_username = '$username'";
                $user_query  = mysqli_query($con, $user_select);

                checkSuccess($user_query);

                while ($row = mysqli_fetch_array($user_query)) 
                {
                    $id         = $row['user_id'];
                    $username   = $row['user_username'];
                    $password   = $row['user_password'];
                    $first_name = $row['user_first_name'];
                    $last_name  = $row['user_last_name'];
                    $email      = $row['user_email'];
                    $role       = $row['user_role'];
                
                    updateProfile($con,        $id,         $username,  
                                  $password,   $first_name, $last_name, 
                                  $email,      $role);
                }
            }
        }

        //UPDATE PROFILE

        function updateProfile($con,        $id,         $username, 
                               $password,   $first_name, $last_name, 
                               $email,      $role) 
        {

            if (isset($_POST['update'])) 
            {

                if ((empty($username))   || (empty($password))  || 
                    (empty($first_name)) || (empty($last_name)) || 
                    (empty($email))      || ($role === "0")) 
                    {

                    echo "
                        <p class='alert-danger'>Fields cannot be empty...</p>
                    ";

                } else {

                    $username   = $_POST['username'];
                    $password   = $_POST['password'];
                    $first_name = $_POST['first_name'];
                    $last_name  = $_POST['last_name'];
                    $email      = $_POST['email'];
                    $role       = $_POST['role'];
    
                    $randSalt_select = "SELECT randSalt FROM users";
                    $randSalt_query  = mysqli_query($con, $randSalt_select);
        
                    checkSuccess($randSalt_query);
        
                    $randSalt = mysqli_fetch_array($randSalt_query);
                    $randSalt = $randSalt['randSalt'];
        
                    $hashed_password = crypt($password, $randSalt);
        
                    $user_update = "UPDATE users SET user_username   = '$username',   user_password  = '$hashed_password', 
                                                     user_first_name = '$first_name', user_last_name = '$last_name', 
                                                     user_email      = '$email',      user_role      = '$role' 
                                                     
                                                     WHERE user_username = '$username'";
        
                    $update_query = mysqli_query($con, $user_update);
        
                    checkSuccess($update_query);
    
                    header("Location: users.php");
                }
            }
        }

        //ADD CATEGORY

        function addCategory() 
        {
            global $con;

            if (checkUserRole()) 
            {
                if (isset($_POST['submit'])) 
                {
                    $cat_title = mysqli_real_escape_string($con, ($_POST['cat_title']));

                    if (empty($cat_title)) 
                    {
                        echo "
                            <p class='alert-danger'>This field should not be empty</p>
                        ";
                    } 
                    else 
                    {
                        $cat_insert = "INSERT INTO categories(cat_title) VALUE('$cat_title')";
                        $cat_query  = mysqli_query($con, $cat_insert);
        
                        checkSuccess($cat_query);
                    }
                }
            }
        }

        //DISPLAY CATEGORIES

        function displayCategories() 
        {
            global $con;

            $cat_select = "SELECT * FROM categories";
            $cat_query  = mysqli_query($con, $cat_select);

            checkSuccess($cat_query);

            while ($row = mysqli_fetch_assoc($cat_query)) 
            {
                   $cat_id    = $row['cat_id'];
                   $cat_title = $row['cat_title'];

                   categoriesMarkup($cat_id, $cat_title);
            }
        }

        //CATEGORIES MARKUP

        function categoriesMarkup($cat_id, $cat_title) 
        {
            echo "
                <tr>
                    <td>$cat_id</td>
                    <td>
                        <a href='" . ROOT_URL . "category.php?cat_id=$cat_id' target='_blank'>$cat_title</a>
                        <span class='pull-right'>
                            <a href='edit_categories.php?edit=$cat_id'><i class='ti-pencil text-warning'></i></a>
                            <a onclick=\"javascript: return confirm('Are you sure you want to delete this category?');\"
                                href='categories.php?delete=$cat_id'><i class='ti-trash text-danger'></i></a>
                        </span>
                    </td> 
                </tr>
            ";
        }

        //EDIT CATEGORIES

        function editCategory() 
        {
            global $con, $cat_title;
            
            if (checkUserRole()) 
            {
                if (isset($_GET['edit'])) 
                {
                    $cat_id     = mysqli_real_escape_string($con, ($_GET['edit']));
                    $cat_select = "SELECT * FROM categories WHERE cat_id = $cat_id";
                    $cat_query  = mysqli_query($con, $cat_select);
        
                    checkSuccess($cat_query);
        
                    while ($row = mysqli_fetch_assoc($cat_query)) 
                    {
                        $cat_id    = $row['cat_id'];
                        $cat_title = $row['cat_title'];

                        updateCategory($con, $cat_id);
                    }
                }
            }
        }

        // UPDATE CATEGORY

        function updateCategory($con, $cat_id) 
        {
            if (isset($_POST['update'])) 
            {
                $cat_title = mysqli_real_escape_string($con, ($_POST['cat_title']));

                checkCategory($con, $cat_id, $cat_title);
            }
        }

        // CHECK CATEGORY

        function checkCategory($con, $cat_id, $cat_title) 
        {
            if (empty($cat_title)) 
            {
                echo "
                    <p class='alert-danger'>Fields cannot be empty...</p>
                ";

            } 
            else 
            {
                $cat_update   = "UPDATE categories SET cat_title = '$cat_title' WHERE cat_id = $cat_id";
                $update_query = mysqli_query($con, $cat_update);

                checkSuccess($update_query);
            }
        }

        //DELETE CATEGORY

        function deleteCategory() 
        {
            global $con;

            if (checkUserRole()) 
            {
                if (isset($_GET['delete'])) 
                {
                    $cat_id       = mysqli_real_escape_string($con, ($_GET['delete']));
                    $cat_delete   = "DELETE FROM categories WHERE cat_id = $cat_id";
                    $delete_query = mysqli_query($con, $cat_delete);
        
                    checkSuccess($delete_query);
        
                    header("Location: categories.php");
                }
            }
        }
?>