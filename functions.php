<?php 
    //CHECK QUERY SUCCESS   

    function checkSuccess($param) 
    {
        global $con;

        if (!$param) 
        {
            die("<p>Query failed</p>" . mysqli_error($con));

        }

    }

    // CHECK USER ROLE

    function checkUserRole() 
    {
        if ((isset($_SESSION['role'])) && ($_SESSION['role'] === "admin")) 
        {
            return true;

        } 
        else 
        {
            return false;

        }

    }

    // CHECK USER STATUS

    function checkUserStatus() 
    {
        if (isset($_SESSION['username'])) 
        {
            return true;

        } 
        else 
        {
            return false;

        }
        
    }

    // POST PREVIEW MARKUP

    function postPreviewMarkup($post_query)
    {
        while ($row = mysqli_fetch_assoc($post_query)) 
        {
            $post_id      = $row['post_id'];
            $post_img     = $row['post_img'];
            $post_date    = $row['post_date'];
            $post_author  = $row['post_author'];
            $post_title   = $row['post_title'];
            $post_content = $row['post_content'];

            echo "
                <div class='col-md-4'>
                    <div class='blog-entry'>
                        <div class='blog-img'>
                            <a href='single.php?post_id=$post_id'><img src='img/$post_img' class='img-responsive' alt='blog-image'></a>
                        </div>
                        <div class='desc'>
                            <p class='meta'>
                                <span class='cat'><a href='single.php?post_id=$post_id'>Read</a></span>
                                <span class='date'>" . date('d F Y', strtotime($post_date)) . "</span>
                                <span class='pos'>By <a href='author.php?post_author=$post_author&post_id=$post_id'>$post_author</a></span>
                            </p>
                            <h2><a href='single.php?post_id=$post_id'>$post_title</a></h2>
                            <p>" . substr($post_content, 0, 75) . " [<a href='single.php?post_id=$post_id'>...</a>]</p>
                        </div>
                    </div>
                </div>
            ";

        }
        
    }

    // POST COUNT

    function postCount()
    {
        global $con, $post_count;

        $post_count_select = "SELECT * FROM posts";
        $post_count_query  = mysqli_query($con, $post_count_select);

        checkSuccess($post_count_query);

        $post_count  = mysqli_num_rows($post_count_query);
    }

    // POST PREVIEW

    function displayPostPreview() 
    {
        global $con, $post_count, $max_posts, $page;

        postCount();

        $max_posts   = 6;
        $post_count  = ceil($post_count / $max_posts);

        if (isset($_GET['page'])) 
        {
            $page = $_GET['page'];
        } 
        else 
        {
            $page = '';
        }

        if ($page == "" || $page === 1)
        {
            $page_1 = 0;
        }
        else 
        {
            $page_1 = ($page * $max_posts) - $max_posts;
        }

        $post_select = "SELECT * FROM posts WHERE post_status = 'published' 
                                            ORDER BY post_date DESC
                                            LIMIT $page_1, $max_posts";

        $post_query  = mysqli_query($con, $post_select);

        checkSuccess($post_query);

        postPreviewMarkup($post_query);
    }

    // DISPLAY FULL POST

    function displayFullPost() 
    {
        global $con, $post_id;

        if (isset($_GET['post_id'])) 
        {
            $post_id     = $_GET['post_id'];
            $post_select = "SELECT * FROM posts WHERE post_id = '$post_id'";
            $post_query  = mysqli_query($con, $post_select);

            checkSuccess($post_query);

            while ($post = mysqli_fetch_assoc($post_query)) 
            {
                $post_img     = $post['post_img'];
                $post_date    = $post['post_date'];
                $post_author  = $post['post_author'];
                $post_title   = $post['post_title'];
                $post_content = $post['post_content'];

                echo "
                    <div class='blog-img blog-detail'>
                        <img src='img/$post_img' class='img-responsive'>
                    </div>
                    <div class='desc'>
                        <p class='meta'>
                            <span class='cat'><a href='" . ROOT_URL . "'>Back</a></span>
                            <span class='date'>" . date('d F Y', strtotime($post_date)) . "</span>
                            <span class='pos'>
                                By <a href='" . ROOT_URL . "author.php?post_author=$post_author&post_id=$post_id' target='_blank'>$post_author</a>
                            </span>
                        </p>
                        <h2>$post_title</h2>
                        $post_content
                    </div>
                ";

            }

        }

    }

    // DISPLAY SEARCH RESULTS

    function displaySearchResults() 
    {
        global $con;

        if (isset($_POST['submit'])) 
        {
            $search = $_POST['search'];
            $search_select = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
            $search_query = mysqli_query($con, $search_select);

            checkSuccess($search_query);

            $count = mysqli_num_rows($search_query);

            if ($count == 0) 
            {
                echo "<p>No results...</p>";

            } 
            else 
            {
                while ($row = mysqli_fetch_assoc($search_query)) 
                {
                    $post_img = $row['post_img'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_content = $row['post_content'];

                    echo "
                        <div class='col-md-4'>
                            <div class='blog-entry'>
                                <div class='blog-img'>
                                    <a href='#'><img src='img/$post_img' class='img-responsive' alt='blog-image'></a>
                                </div>
                                <div class='desc'>
                                    <p class='meta'>
                                        <span class='cat'><a href='#'>Read</a></span>
                                        <span class='date'>" . date('d F Y', strtotime($post_date)) . "</span>
                                        <span class='pos'>By <a href='#'>$post_author</a></span>
                                    </p>
                                    <h2><a href='#'>$post_title</a></h2>
                                    <p>" . substr($post_content, 0, 75) . " [<a href='#'>...</a>]</p>
                                </div>
                            </div>
                        </div>
                    ";

                }

            }

        }

    }

    // DISPLAY ARCHIVED POST

    function displayArchivedPosts()
    {

        global $con;

        extract($_REQUEST);

        $post_select = "SELECT * FROM posts WHERE MONTH(post_date) = " . $m . " AND YEAR(post_date) = " . $y;

        $post_query = mysqli_query($con, $post_select);

        checkSuccess($post_query);

        $count = mysqli_num_rows($post_query);

        if ($count == 0) 
        {
            echo "
                <p>No results found...</p>
            ";
        } 
        else 
        {
            while ($row = mysqli_fetch_assoc($post_query)) 
            {
                $post_id      = $row['post_id'];
                $post_img     = $row['post_img'];
                $post_date    = $row['post_date'];
                $post_author  = $row['post_author'];
                $post_title   = $row['post_title'];
                $post_content = $row['post_content'];

                echo "
                    <div class='col-md-4'>
                        <div class='blog-entry'>
                            <div class='blog-img'>
                                <a href='single.php?post_id=$post_id'><img src='img/$post_img' class='img-responsive' alt='blog-image'></a>
                            </div>
                            <div class='desc'>
                                <p class='meta'>
                                    <span class='cat'><a href='single.php?post_id=$post_id'>Read</a></span>
                                    <span class='date'>" . date('d F Y', strtotime($post_date)) . "</span>
                                    <span class='pos'>By <a href='#'>$post_author</a></span>
                                </p>
                                <h2><a href='single.php?post_id=$post_id'>$post_title</a></h2>
                                <p>" . substr($post_content, 0, 75) . " [<a href='single.php?post_id=$post_id'>...</a>]</p>
                            </div>
                        </div>
                    </div>
                ";

            }

        }

    }

    // DISPLAY AUTHOR POSTS

    function displayAuthorPosts()
    {
        global $con;

        if (isset($_GET['post_id'])) 
        {
            $post_id     = $_GET['post_id'];
            $post_author = $_GET['post_author'];
            $post_select = "SELECT * FROM posts WHERE post_author = '$post_author' ORDER BY post_date DESC";
            $post_query  = mysqli_query($con, $post_select);
            
            checkSuccess($post_query);

            while ($row = mysqli_fetch_assoc($post_query)) 
            {
                $post_id      = $row['post_id'];
                $post_img     = $row['post_img'];
                $post_date    = $row['post_date'];
                $post_author  = $row['post_author'];
                $post_title   = $row['post_title'];
                $post_content = $row['post_content'];

                echo "
                    <div class='col-md-4'>
                        <div class='blog-entry'>
                            <div class='blog-img'>
                                <a href='single.php?post_id=$post_id'><img src='img/$post_img' class='img-responsive' alt='blog-image'></a>
                            </div>
                            <div class='desc'>
                                <p class='meta'>
                                    <span class='cat'><a href='single.php?post_id=$post_id'>Read</a></span>
                                    <span class='date'>" . date('d F Y', strtotime($post_date)) . "</span>
                                    <span class='pos'>By <a href='#'>$post_author</a></span>
                                </p>
                                <h2><a href='single.php?post_id=$post_id'>$post_title</a></h2>
                                <p>" . substr($post_content, 0, 75) . " [<a href='single.php?post_id=$post_id'>...</a>]</p>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
    }

    // POST COMMENT 

    function postComment()
    {
        global $con;

        if (isset($_POST['create_comment'])) 
        {
            if (checkUserStatus())
            {
                registeredUserPost();
            } 
            else 
            {
                guestUserPost();
            }

        }

    }

    // REGISTERED USER POST

    function registeredUserPost() 
    {
        global $con;

        $post_id            = mysqli_real_escape_string($con, ($_GET['post_id']));
        $comment_first_name = mysqli_real_escape_string($con, ($_SESSION['first_name']));
        $comment_last_name  = mysqli_real_escape_string($con, ($_SESSION['last_name']));
        $comment_email      = mysqli_real_escape_string($con, ($_SESSION['email']));
        $comment_content    = mysqli_real_escape_string($con, ($_POST['comment_content']));

        if (empty($comment_content)) 
        {
            echo "<p class='alert-danger'>Fields cannot be empty...</p>";
        } 
        else 
        {
            if (checkUserRole())
            {
                $comment_status = "approved";

                echo "
                    <p class='alert-success'>Comment successful...</p>
                ";

            } 
            else 
            {
                $comment_status = "unapproved";
                echo "
                    <p class='alert-success'>Comment awaiting approval...</p>
                ";
            }
    
            $comment_insert = "INSERT INTO comments (comment_post_id, comment_first_name, comment_last_name, comment_email, 
                                                    comment_content, comment_status,     comment_date)

                                            VALUES ($post_id,          '$comment_first_name', '$comment_last_name', '$comment_email', 
                                                    '$comment_content', '$comment_status',      now())";

            $comment_query = mysqli_query($con, $comment_insert);

            checkSuccess($comment_query);
        }
    }

    // GUEST USER POST

    function guestUserPost() 
    {
        global $con;
        
        $post_id            = mysqli_real_escape_string($con, ($_GET['post_id']));
        $comment_first_name = mysqli_real_escape_string($con, ($_POST['comment_first_name']));
        $comment_last_name  = mysqli_real_escape_string($con, ($_POST['comment_last_name']));
        $comment_email      = mysqli_real_escape_string($con, ($_POST['comment_email']));
        $comment_content    = mysqli_real_escape_string($con, ($_POST['comment_content']));

        if ((empty($comment_first_name)) || (empty($comment_last_name)) || 
            (empty($comment_email))      || (empty($comment_content))) 
            {

            echo "
                <p class='alert-danger'>Fields cannot be empty...</p>
            ";

        } 
        else 
        {
            $comment_insert = "INSERT INTO comments (comment_post_id, comment_first_name, comment_last_name, comment_email, 
                                                     comment_content, comment_status,     comment_date)

                                             VALUES ($post_id,          '$comment_first_name', '$comment_last_name', '$comment_email', 
                                                    '$comment_content', 'unapproved',           now())";
    
            $comment_query = mysqli_query($con, $comment_insert);

            checkSuccess($comment_query);

            echo "<p class='alert-success'>Comment awaiting approval...</p>";
        }
    }

    function displayPostComments() 
    {
        global $con, $post_id;
        
        $comment_select = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
        $comment_query = mysqli_query($con, $comment_select);

        while ($comment = mysqli_fetch_assoc($comment_query)) {
            $comment_first_name = $comment['comment_first_name'];
            $comment_last_name = $comment['comment_last_name'];
            $comment_content = $comment['comment_content'];
            $comment_date = $comment['comment_date'];

            echo "
                <div class='review'>
                    <div class='user-img' style='background-image: url(img/user.png)'></div>
                    <div class='desc'>
                        <h4>
                            <span class='text-left'>$comment_first_name $comment_last_name</span>
                            <span class='text-right'>" . date('d F Y', strtotime($comment_date)) . "</span>
                        </h4>
                        <p>$comment_content</p>
                        <br>
                    </div>
                </div>
            ";
        }
    }

    
    // CHECK USERNAME DUPLICATE

    function checkDuplicateUsername($username) 
    {

        global $con;

        $user_select = "SELECT user_username FROM users WHERE user_username = '$username'";
        $user_query  = mysqli_query($con, $user_select);

        checkSuccess($user_query);

        if (mysqli_num_rows($user_query) > 0) 
        {

            return true;

        } 
        else 
        {

            return false;

        }

    }

    // CHECK EMAIL DUPLICATE

    function checkDuplicateEmail($email) 
    {

        global $con;

        $user_select = "SELECT user_email FROM users WHERE user_email = '$email'";
        $user_query  = mysqli_query($con, $user_select);

        checkSuccess($user_query);

        if (mysqli_num_rows($user_query) > 0) 
        {

            return true;

        } 
        else 
        {

            return false;

        }

    }

    // REGISTER USER

    function registerUser()
    {
        global $con;

        if (isset($_POST['register'])) 
        {
            $first_name = mysqli_real_escape_string($con, ($_POST['first_name']));
            $last_name  = mysqli_real_escape_string($con, ($_POST['last_name']));
            $email      = mysqli_real_escape_string($con, ($_POST['email']));
            $username   = mysqli_real_escape_string($con, ($_POST['username']));
            $password   = mysqli_real_escape_string($con, ($_POST['password']));
            $confirm    = mysqli_real_escape_string($con, ($_POST['confirm']));
            $user_date  = date('d/m/Y');

            validateUserRegistration($con,      $first_name, $last_name, $email,   
                                     $username, $password,   $confirm,   $user_date);
        }

    }

    // VALIDATE USER 

    function validateUserRegistration($con,      $first_name, $last_name, $email,   
                                      $username, $password,   $confirm,   $user_date) 
    {
        if ((empty($first_name)) || (empty($last_name)) || 
            (empty($email))      || (empty($username))  || 
            (empty($password))) 
        {
            echo "
                <p class='alert-danger'>Fields cannot be empty...</p>
            ";
        } 
        else if (checkDuplicateUsername($username)) 
        {
            echo "
                <p class='alert-danger'>Username already exists...</p>
            ";
        } 
        else if (checkDuplicateEmail($email)) 
        {
            echo "
                <p class='alert-danger'>Another account is using this email address...</p>
            ";
        } 
        else if ($password !== $confirm) 
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
 
            $user_insert     = "INSERT INTO users(user_username, user_password, user_first_name, 
                                                  user_last_name, user_email, user_role, user_date) 

                                       VALUES ('$username', '$hashed_password', '$first_name', '$last_name', 
                                               '$email',    'subscriber',        now())";

            $user_query  = mysqli_query($con, $user_insert);

            checkSuccess($user_query);
        }
    }

    // LOGIN USER 

    function loginUser() 
    {
        global $con;
        
        if (isset($_POST['login'])) 
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ((empty($username)) || (empty($password))) 
            {
                echo "
                    <p class='alert-danger'>Fields cannot be empty...</p>
                "; 

            } 
            else 
            {
                $username = mysqli_real_escape_string($con, $username);
                $password = mysqli_real_escape_string($con, $password);
    
                $user_select = "SELECT * FROM users WHERE user_username = '$username'";
                $user_query  = mysqli_query($con, $user_select);

                checkSuccess($user_query);

                if (mysqli_num_rows($user_query) === 0) 
                {
                    echo "
                        <p class='alert-danger'>Invalid username...</p>
                    ";

                } 
                else 
                {
                    while ($row = mysqli_fetch_array($user_query)) 
                    {
                        $user_id         = $row['user_id'];
                        $user_username   = $row['user_username'];
                        $user_password   = $row['user_password'];
                        $user_first_name = $row['user_first_name'];
                        $user_last_name  = $row['user_last_name'];
                        $user_email      = $row['user_email'];
                        $user_role       = $row['user_role'];
    
                        $password = crypt($password, $user_password);

                        if ($username !== $user_username && $password !== $user_password) 
                        {
                            echo "
                                <p class='alert-danger'>Incorrect password...</p>
                            ";

                        } 
                        else 
                        {
                            $_SESSION['username']   = $user_username;
                            $_SESSION['first_name'] = $user_first_name;
                            $_SESSION['last_name']  = $user_last_name;
                            $_SESSION['email']      = $user_email;
                            $_SESSION['role']       = $user_role;
            
                            header("Location: index.php");
                        }
                    }
                }
            }
        }
    }

    // DISPLAY CAT POSTS
    
    function displayCatPosts() 
    {
        global $con;

        if (isset($_GET['cat_id'])) 
        {
            $cat_id      = $_GET['cat_id'];
            $post_select = "SELECT * FROM posts WHERE post_cat_id = $cat_id ORDER BY post_date DESC";
            $post_query  = mysqli_query($con, $post_select);

            checkSuccess($post_query);

            $count = mysqli_num_rows($post_query);

            if ($count == 0) 
            {
                echo "
                    <p>No results...</p>
                ";

            } 
            else 
            {
                while ($row = mysqli_fetch_assoc($post_query)) 
                {
                    $post_id      = $row['post_id'];
                    $post_img     = $row['post_img'];
                    $post_date    = $row['post_date'];
                    $post_author  = $row['post_author'];
                    $post_title   = $row['post_title'];
                    $post_content = $row['post_content'];

                    echo "
                        <div class='col-md-4'>
                            <div class='blog-entry'>
                                <div class='blog-img'>
                                    <a href='single.php?post_id=$post_id'><img src='img/$post_img' class='img-responsive' alt='blog-image'></a>
                                </div>
                                <div class='desc'>
                                    <p class='meta'>
                                        <span class='cat'><a href='single.php?post_id=$post_id'>Read</a></span>
                                        <span class='date'>" . date('d F Y', strtotime($post_date)) . "</span>
                                        <span class='pos'>By <a href='#'>$post_author</a></span>
                                    </p>
                                    <h2><a href='single.php?post_id=$post_id'>$post_title</a></h2>
                                    <p>" . substr($post_content, 0, 75) . " [<a href='single.php?post_id=$post_id'>...</a>]</p>
                                </div>
                            </div>
                        </div>
                    ";

                }

            }

        }
        
    }
?>