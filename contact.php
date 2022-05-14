<?php include 'includes/partials/header.php' ?>
	<div id="colorlib-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="heading-2">Contact Information</h2>
					<div class="row contact-info-wrap row-pb-lg">
						<div class="col-md-3">
							<p><span><i class="icon-location-2"></i></span> 20 North Audley St, Suite 721 <br> Mayfair, London W1K 6HX </p>
						</div>
						<div class="col-md-3">
							<p><span><i class="icon-phone3"></i></span> <a href="tel://02080893152">+44 (0) 208 089 3152</a></p>
						</div>
						<div class="col-md-3">
							<p><span><i class="icon-paperplane"></i></span> <a href="mailto:info@yoursite.com">info@stuff.io</a></p>
						</div>
						<div class="col-md-3">
							<p><span><i class="icon-globe"></i></span> <a href="#">stuff.io</a></p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<?php 
						if (isset($_POST['submit'])) 
						{
							$to         = "isummerlin95@gmail.com";
							$first_name = $_POST['first_name'];
							$last_name  = $_POST['last_name'];
							$subject    = wordwrap($_POST['subject'], 70);
							$message    = $_POST['message'];
							$header     = "FROM: " . $_POST['email'];

							$mail = mail($to, $subject, $message, $header);
							if ($mail) 
							{
								echo "<p class='alert-success'>Email successfully sent...</p>";
							} else {
								echo "<p class='alert-danger'>Email failed...</p>";
							}

						}
					?>
					<div class="row">
						<div class="col-lg-12">
							<h2 class="heading-2">Get In Touch</h2>
							<form action="#">
								<div class="row form-group">
									<div class="col-md-6">
										<label for="first_name">First Name</label>
										<input type="text" id="first_name" name="first_name" class="form-control" placeholder="Your first name">
									</div>
									<div class="col-md-6">
										<label for="last_name">Last Name</label>
										<input type="text" id="last_name" name="first_name" class="form-control" placeholder="Your last name">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-12">
										<label for="email">Email</label>
										<input type="email" id="email" name="email" class="form-control" placeholder="Your email address">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-12">
										<label for="subject">Subject</label>
										<input type="text" id="subject" name="subject" class="form-control" placeholder="The subject of this message">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-md-12">
										<label for="message">Message</label>
										<textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Your message"></textarea>
									</div>
								</div>
								<div class="form-group">
									<input type="submit" name="submit" value="Send Message" class="btn btn-primary">
								</div>
							</form>	
						</div>
					</div>
					<?php include 'includes/partials/footer.php'; ?>

				</div>
			</div>
		</div>

