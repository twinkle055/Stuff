<?php include 'includes/partials/header.php' ?>
    <?php
        deleteUser();
    ?>
    <div class="col-lg-12">
        <div class="form-group">
            <a href="add_user.php" class="btn btn-danger">Add new user</a>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php displayUsers(); ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php include 'includes/partials/footer.php' ?>
