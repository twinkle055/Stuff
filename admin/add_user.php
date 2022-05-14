<?php include 'includes/partials/header.php' ?>
    <?php 
        addUser();
    ?>
    <div class="card">
        <div class="header">
            <h2 class="title">Add New User</h2>
        </div>
        <div class="content">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password">
                </div>
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" name="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" name="last_name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email"/>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <br>
                    <select name="role" id="">
                        <option value="0">Select user role</option>
                        <option value="subscriber">subscriber</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <input class="btn btn-danger btn-lg" type="submit" name="add_user" value="Add User">
                </div>
            </form>
        </div>
    </div>
<?php include 'includes/partials/footer.php' ?>
