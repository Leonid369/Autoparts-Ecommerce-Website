<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online_store/core/init.php';

$email = ((isset($_POST['email'])) ? sanitize($_POST['email']) : '');
$email = trim($email);
$password = ((isset($_POST['password'])) ? sanitize($_POST['password']) : '');
$password = trim($password);
$errors = array();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<title>Administrator</title>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/style.css" rel="stylesheet" media="all">
<link href="css/font-awesome.css" rel="stylesheet">
<link href='//fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet'>
<link href='//fonts.googleapis.com/css?family=Work+Sans:400,500,600' rel='stylesheet'>
<link rel="stylesheet" href="../../css/bootstrap.min.css" media="all">
<link rel="stylesheet" href="../../css/main.css" media="all">
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/main.js"></script>
</head>
<body>	
<div class="login-page">
   <?php
			if ($_POST) {
				// Form validation
				if (empty($_POST['email']) || empty($_POST['password'])) {
					$errors[] = 'You must provide email and password.';
				}
				// Validate email
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errors[] = 'You must enter a valid email.';
				}
				// Password is more than 6 characters
				if (strlen($password) < 6) {
					$errors[] = 'Password must be at least 6 characters.';
				}

				// Check if email exists in the database
				$query = $db->query("SELECT * FROM users WHERE email = '$email'");
				$user = mysqli_fetch_assoc($query);
				$userCount = mysqli_num_rows($query);
				if ($userCount < 1) {
					$errors[] = 'That email doesn\'t exist in our database.'; 
				}
				if (!password_verify($password, $user['password'])) {
					$errors[] = 'The password the match our records. Please try again.';
				}

				// Check for errors
				if (!empty($errors)) {
					echo display_errors($errors);
				} else {
					// Log user in
					$user_id = $user['id'];
					login($user_id);
				}
			}
		?>
    <div class="login-main">  	
    	 <div class="login-head">
				<h1>Login</h1>
			</div>
			<div class="login-block">
				<form action="login.php" method="POST">
					<input type="text" name="email" placeholder="Email" value="<?= $email; ?>">
					<input type="password" name="password" class="lock" placeholder="Password" value="<?= $password; ?>">
					<div class="forgot-top-grids">
						<div class="forgot-grid">
							<ul>
								<li>
									<input type="checkbox" id="brand1" value="">
									<label for="brand1"><span></span>Remember me</label>
								</li>
							</ul>
						</div>
						<div class="forgot">
							<a href="#">Forgot password?</a>
						</div>
						<div class="clearfix"> </div>
					</div>
					<input type="submit" name="Sign In" value="Login">	
					<h3><a href="signup.html"> Sign up</a></h3>
				</form>
			</div>
      </div>
</div>
<div class="copyrights">
	 <p>© 2017 Online Store.</p>
</div>	
		<script src="js/jquery.nicescroll.js"></script>
		<script src="js/scripts.js"></script>
<script src="js/bootstrap.js"> </script>
</body>
</html>


                      
						
