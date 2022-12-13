<?php
/**
 * File             : View Registration Form
 * @author          : Rhea Labayo
 * @copyright       : 2016 December
 * Date Updated     : December 1, 2016
 *
 */
?>
<html>
	<head>
		<title>Registration Form</title>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery/jquery-1.11.0.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap-theme.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap-theme.min.css" />
	</head>
	<body>
		<div id="wrapper">
			<div class="container">
				<div class="col-xs-4 content">
					<h2>Registration Form</h2>
					<hr/>
					<?php
						echo form_open('user_authentication/new_user_registration');
					?>
					<div class="form-group">
						<label for="user name">Create User Name</label>
						<input type="text" class="form-control" id="name" name="username" aria-describedby="usernameHelp" placeholder="Enter user name">
						<?php
							if (isset($message_display)) {
								echo $message_display;
							}
						?>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email_value" name="email_value" aria-describedby="emailHelp" placeholder="Enter email address">
					</div>
					<div class="form-group">
						<label for="user name">Password</label>
						<input type="password" class="form-control" id="password" name="password" aria-describedby="passwordHelp" placeholder="Enter password">
					</div>
					<div class='error_msg'><?php  validation_errors(); ?></div>
					<button type="submit" value='Login' name="submit" class="btn btn-primary">Sign Up</button><br>
					<?php
						echo form_close();
					?>
					<a href="<?php echo base_url() ?> ">For Login Click Here</a>
				</div>
			</div>
		</div>
	</body>
</html>

