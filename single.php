<?php include 'includes/partials/header.php' ?>
<?php postComment(); ?>
	<div id="colorlib-container">
		<div class="container">
			<div class="row">
				<?php include 'includes/partials/sidebar.php' ?>
				<div class="col-md-9 content">
					<div class="row row-pb-lg">
						<div class="col-md-12">
							<div class="blog-entry">
								<?php displayFullPost(); ?>
							</div>
						</div>
					</div>
					<?php include 'includes/partials/comment_form.php' ?>
					<div class="row row-pb-lg">
						<div class="col-md-12">
							<?php 
								$comment_count_select = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved'";
								$comment_count_query = mysqli_query($con, $comment_count_select);

								checkSuccess($comment_count_query);

								$comment_count = mysqli_num_rows($comment_count_query);
							?>
							<h2 class="heading-2"><?php echo $comment_count; ?> Comments</h2>
							<?php 
								displayPostComments();
							?>
						</div>

					</div>
					<?php include 'includes/partials/footer.php' ?>

				</div>

			</div>

		</div>
	</div>
</div>
