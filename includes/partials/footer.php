					</div>
				</div>
			</div>
		</div>
		<footer id="colorlib-footer" role="contentinfo"> 
			<div class="container">
				<div class="row row-pb-md">
					<div class="col-md-3">
						<h2>Categories</h2>
						<p>
							<ul class="colorlib-footer-links">
								<?php 
									$cat_select = "SELECT * FROM categories";
									$cat_query = mysqli_query($con, $cat_select);

									checkSuccess($cat_query);

									while($cat = mysqli_fetch_assoc($cat_query)) {
										$cat_id = $cat['cat_id'];
										$cat_title = $cat['cat_title'];
										echo "<li><a href='category.php?cat_id=$cat_id'><i class='icon-check'></i>$cat_title</a></li>";
									}
								?>
							</ul>
						</p>
					</div>
					<div class="col-md-3">
						<h2>Recent Posts</h2>
						<?php 
							$post_select = "SELECT * FROM posts ORDER BY post_date DESC LIMIT 3";
							$post_query  = mysqli_query($con, $post_select);

							while ($post = mysqli_fetch_assoc($post_query)) {
								$post_id = $post['post_id'];
								$post_img = $post['post_img'];
								$post_date = $post['post_date'];
								$post_title = $post['post_title'];

								echo "
									<div class='f-blog'>
										<a href='single.php?post_id=$post_id' class='blog-img' style='background-image: url(img/$post_img);'>
										</a>
										<div class='desc'>
											<h3><a href='single.php?post_id=$post_id'>$post_title</a></h3>
											<p class='admin'><span>" . date('d F Y', strtotime($post_date)) . "</span></p>
										</div>
									</div>
								";
							}
						?>
					</div>
					<div class="col-md-3">
						<h2>Archive</h2>
						<p>
							<?php 

								$post_select = "SELECT DATE_FORMAT (post_date, '%M %Y') AS 'post', 
												DATE_FORMAT        (post_date, '%m')    AS 'm', 
												DATE_FORMAT        (post_date, '%Y')    AS 'y' 
												FROM posts                             
												GROUP BY DATE_FORMAT(post_date, '%Y %M')";

								$post_query  = mysqli_query($con, $post_select);

								checkSuccess($post_query);

								while ($row = mysqli_fetch_assoc($post_query)) 
								{

									echo "
										<ul class='colorlib-footer-links'>
											<li>
												<a href='archive.php?m=" . $row['m'] . "&y=" . $row['y'] . "'>
													<i class='icon-calendar'></i> " . $row['post']  . "
												</a>
											</li>
										</ul>
									";

								}
							?>
						</p>
					</div>
					<div class="col-md-3">
						<h2>Navigation</h2>
						<ul class="colorlib-footer-links">
							<li><a href="<?php echo ROOT_URL; ?>"><i class="icon-arrow-right2"></i> Home</a></li>
							<li><a href="contact.php"><i class="icon-arrow-right2"></i> Contact</a></li>
							<?php 
								if (checkUserRole()) {
									echo "
										<li><a href='admin/index.php' target='_blank'><i class='icon-arrow-right2'></i> Admin</a></li>
									";
								}
								if (checkUserStatus()) {
									echo "
										<li><a href='admin/logout.php'><i class='icon-arrow-right2'></i> Logout</a></li>
									";
								} else {
									echo "						
										<li><a href='login.php'><i class='icon-arrow-right2'></i> Login</a></li>
										<li><a href='register.php'><i class='icon-arrow-right2'></i> Register</a></li>
									";
								}
							?>
						</ul>
					</div>
					<div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<br><br><p class="text-center mt-5">&copy; Copyright <script>document.write(new Date().getFullYear());</script> STUFF, Inc. All rights reserved.</p>
					</div>
				</div>
			</div>
		</footer>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
	</div>
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Flexslider -->
	<script src="js/jquery.flexslider-min.js"></script>
	<!-- Owl carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<!-- Main -->
	<script src="js/main.js"></script>

	</body>
</html>

