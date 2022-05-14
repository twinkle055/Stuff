<nav class="colorlib-nav" role="navigation">
	<div class="top-menu">
		<div class="container">
			<div class="row">
				<div class="col-xs-2">
					<div id="colorlib-logo"><a href="<?php echo ROOT_URL; ?>">Stuff</a></div>
				</div>
				<div class="col-xs-10 text-right menu-1">
					<ul>
						<?php 
							$page = basename($_SERVER['PHP_SELF']);

							$active_home     = '';
							$active_contact  = '';
							$active_login    = '';
							$active_register = '';

							switch ($page) 
							{
								case 'index.php': 

									$active_home     = 'active';
									break;

								case 'contact.php':
								
									$active_contact  = 'active';
									break;
									
								case 'login.php':

									$active_login    = 'active';
									break;

								case 'register.php':

									$active_register = 'active';
									break;

								default:

									break;
							}
						?>
						<li class="<?php echo $active_home; ?>"><a href="<?php echo ROOT_URL; ?>">Home</a></li>
						<li class="<?php echo $active_contact; ?>"><a href="contact.php">Contact</a></li>
						<?php 
							if (checkUserRole()) 
							{

								echo "
									<li><a href='admin/index.php' target='_blank'>Admin</a></li>
								";

							}
							if (checkUserStatus()) 
							{

								echo "
									<li><a href='admin/logout.php'>Logout</a></li>
								";

							} 
							else 
							{

								echo "						
									<li class='$active_login'><a href='login.php'>Login</a></li>
									<li class='$active_register'><a href='register.php'>Register</a></li>
								";

							}
							
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</nav>

