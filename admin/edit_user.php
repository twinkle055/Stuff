<?php include 'includes/partials/header.php' ?>
    <div class="col-lg-12">
        <?php 
            editUser();
        ?>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2 class="title">Edit User</h2>
            </div>
            <div class="content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" value="<?php echo $password; ?>">
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" name="last_name"value="<?php echo $last_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <br>
                        <select name="role" id="">
                            <option value="<?php echo $role?>"><?php echo $role?></option>
                            <?php 
                                if ($role == 'admin') {
                                    echo "                                        
                                        <option value='subscriber'>subscriber</option>
                                    ";
                                } else {
                                    echo "                                        
                                        <option value='admin'>admin</option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-danger btn-lg" type="submit" name="update" value="Update User">
                    </div>
                </form>
            </div>
        </div>
<?php include 'includes/partials/footer.php' ?>
