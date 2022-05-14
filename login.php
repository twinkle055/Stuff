<?php include 'includes/partials/header.php' ?>
    <?php 
        loginUser();
    ?>
    <div id="colorlib-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="heading-2">Login</h2>
                    <form action="" method="POST">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Your username">
                            </div>
                            <div class="col-md-12">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Your password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="login" value="Login" class="btn btn-primary">
                        </div>
                    </form>	
                    <?php include 'includes/partials/footer.php' ?>

                </div>
            </div>
        </div>

