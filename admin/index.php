<?php include 'includes/partials/header.php' ?>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <?php $post_count = tableCount('posts'); ?>
            <a href="posts.php">
                <div class="card">
                    <div class="content text-primary">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-file-text fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                            <div class="fs-lg"><?php echo $post_count; ?></div>
                                <div>Posts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <?php $comment_count = tableCount('comments'); ?>
            <a href="comments.php">
                <div class="card">
                    <div class="content text-success">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                            <div class="fs-lg"><?php echo $comment_count; ?></div>
                            <div>Comments</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <?php $user_count = tableCount('users'); ?>
            <a href="users.php">
                <div class="card">
                    <div class="content text-warning">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="fs-lg"><?php echo $user_count; ?></div>
                                <div> Users</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6">
            <?php $cat_count = tableCount('categories'); ?>
            <a href="categories.php">
                <div class="card">
                    <div class="content text-danger">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-list fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="fs-lg"><?php echo $cat_count; ?></div>
                                <div>Categories</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="content">
                    <?php 
                        $post_draft_count = tableCount("posts WHERE post_status = 'draft'");
                        $unapproved_comment_count = tableCount("comments WHERE comment_status = 'unapproved'");
                        $user_admin_count = tableCount("users WHERE user_role = 'admin'");
                        $user_sub_count = tableCount("users WHERE user_role = 'subscriber'");
                    ?>
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count', { role: 'style' }],
                            <?php 
                                $element_text = ['Published Posts', 'Unpublished Posts', 'Approved Comments', 'Unapproved Comments', 
                                    'Users', 'Admin Accounts', 'Subscribers', 'Categories'];

                                $element_count = [$post_count, $post_draft_count, $comment_count, $unapproved_comment_count, $user_count, $user_admin_count, 
                                    $user_sub_count, $cat_count];

                                $element_color = ['#396AB1', '#DA7C30', '#3E9651', '#CC2529', '#535154', '#6B4C9A', '#922428', '#948B3D'];

                                for ($i = 0; $i < 8; $i++) {
                                    echo "
                                        ['$element_text[$i]', $element_count[$i], '$element_color[$i]'],
                                    ";
                                }
                            ?>
                            ]);

                            var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
<?php include 'includes/partials/footer.php' ?>
