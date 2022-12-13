<?php
/**
 * File             : View Log in Form
 * @author          : Rhea Labayo
 * @copyright       : 2016 December
 * Date Updated     : December 1, 2016
 *
 */
?>

<html>
	<head>
		<title>TRUSERV</title>
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
		<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo.png" />
	</head>
	<body>
	<div id="wrapper">	
		<div class="row col-lg-12">
			<div class="col-xs-12" id="create-div-1">
			<div class="container">
				<div class="col-xs-4 content">
					<h2><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="TRUSERV" width="70" />TRUSERV</h2>
					<hr/>
					<?php echo form_open('process');
					?>
					<div class="form-group">
						<label for="user name">User Name</label>
						<input type="text" class="form-control" id="name" name="username" aria-describedby="usernameHelp" placeholder="Enter user name">
					</div>
					<div class="form-group">
						<label for="user name">Password</label>
						<input type="password" class="form-control" id="password" name="password" aria-describedby="usernameHelp" placeholder="Enter password">
					</div>
					<div class="text-center">
						<button type="submit" value='Login' name="submit" class="btn btn-primary">Log In</button><br><br>
					</div>
					
					<div class="error_msg text-center">
						<?php 
							if (isset($error_message)) {
								echo "<p>" . $error_message . "</p>";
							}
						?>
					</div>
					<?php 
					echo form_close(); 
					?>
					
				</div>
				</div>
			</div>
		</div>
	</body>
</html>

