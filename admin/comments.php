<?php include 'includes/partials/header.php' ?>
    <?php
    updateCommentStatus();
    deleteComment();
    ?>
    <div class="col-lg-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Author</th>
                            <th>Content</th>
                            <th>Email Address</th>
                            <th>Approved</th>
                            <th>Post Title</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php displayComments(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php include 'includes/partials/footer.php' ?>
