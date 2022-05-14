<aside id="colorlib-hero">
	<div class="flexslider">
		<ul class="slides ">
			<?php 
				$feat_select = "SELECT * FROM featured LIMIT 3";
				$feat_query = mysqli_query($con, $feat_select);
				checkSuccess($feat_query);
				while ($row = mysqli_fetch_assoc($feat_query))
				{
					$feat_id = $row['feat_id'];
					$feat_post_id = $row['feat_post_id'];
					$feat_img = $row['feat_img'];

					$post_select = "SELECT * FROM posts WHERE post_id = $feat_post_id";
					$post_query = mysqli_query($con, $post_select);
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

						echo "
							<li style='background-image: url(img/$feat_img);'>
								<div class='overlay'></div>
								<div class='container'>
									<div class='row'>
										<div class='col-md-6 col-md-pull-3 col-sm-12 col-xs-12 col-md-offset-3 slider-text'>
											<div class='slider-text-inner'>
												<div class='desc'>
													<p class='meta'>
														<span class='cat'><a href='single.php?post_id=$post_id'>Read</a></span>
														<span class='date'>" . date('d F Y', strtotime($post_date)) . "</span>
														<span class='pos'>By <a href='author.php?post_author=$post_author&post_id=$post_id'>$post_author</a></span>
													</p>
													<h1 class='title'><a href='single.php?post_id=$post_id'>$post_title</a></h1>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
						";
					}
				}
			?>
		</ul>
	</div>
</aside>