<?php include 'includes/partials/header.php' ?>
    <div id="colorlib-container">
        <div class="container">
            <div class="row">
            <?php registerUser(); ?>
                <div class="col-lg-12">
                    <h2 class="heading-2">Register</h2>
                    <form role="form" action="register.php" method="POST">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter your first name">
                            </div>
                            <div class="col-md-6">
                                <label for="username">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter your last name">
                            </div>
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address">
                            </div>
                            <div class="col-md-12">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter desired username">
                            </div>
                            <div class="col-md-12">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Your password">
                            </div>
                            <div class="col-md-12">
                                <label for="confirm">Password</label>
                                <input type="password" name="confirm" id="confirm" class="form-control" placeholder="Confirm password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="register" value="Register" class="btn btn-primary">
                        </div>
                    </form>	
                    <?php include 'includes/partials/footer.php' ?>

                </div>
            </div>
        </div>

