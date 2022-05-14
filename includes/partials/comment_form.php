<div class="row">
	<div class="col-md-12">
		<h2 class="heading-2">Say something</h2>
		<form action="" method="POST" role="form">
			<?php 
				if (!checkUserStatus()) {
					echo "
						<div class='row form-group'>
							<div class='col-md-6'>
								<label for='comment_first_name'>First Name</label>
								<input type='text' id='comment_first_name' name='comment_first_name' class='form-control' placeholder='Your first name'>
							</div>
							<div class='col-md-6'>
								<label for='comment_last_name'>Last Name</label>
								<input type='text' id='comment_last_name' name='comment_last_name' class='form-control' placeholder='Your last name'>
							</div>
						</div>
						<div class='row form-group'>
							<div class='col-md-12'>
								<label for='comment_email'>Email</label>
								<input type='email' id='comment_email' name='comment_email' class='form-control' placeholder='Your email'>
							</div>
						</div>
						<div class='row form-group'>
							<div class='col-md-12'>
								<label for='comment_content'>Message</label>
								<textarea name='comment_content' id='comment_content' cols='30' rows='10' class='form-control' placeholder='Say something'></textarea>
							</div>
						</div>
						<div class='form-group'>
							<input type='submit' name='create_comment' value='Post Comment' class='btn btn-primary'>
						</div>
					";
				} else {
					echo "
						<div class='row form-group'>
							<div class='col-md-12'>
								<label for='comment_content'>Message</label>
								<textarea name='comment_content' id='comment_content' cols='30' rows='10' class='form-control' placeholder='Say something'></textarea>
							</div>
						</div>
						<div class='form-group'>
							<input type='submit' name='create_comment' value='Post Comment' class='btn btn-primary'>
						</div>
					";
				}
			?>
		</form>	
	</div>
</div>