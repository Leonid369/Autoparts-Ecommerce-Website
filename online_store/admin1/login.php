<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/online_store/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email'])) ? sanitize($_POST['email']) : '');
$email = trim($email);
$password = ((isset($_POST['password'])) ? sanitize($_POST['password']) : '');
$password = trim($password);
$errors = array();
?>



<style>
	body {
		background-image: url('/online_store/img/bg-hero.jpg');
		background-size: 100vw 100vh;
		background-attachment: fixed;
	}
</style>

<div id="login-form">
	<div>
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
	</div>
	<h2 class="text-center">Log In</h2>
	<form action="login.php" method="POST" class="login">
		<div class="login-input">
			<label for="email">Email :</label>
			<input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>">
		</div>
		<div class="login-input">
			<label for="password">Password :</label>
			<input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>">
		</div>
		<div class="login-input">
			<input type="submit" value="Login" class="login-btn">
		</div>
	</form>
	<p class="visit"><a href="/online_store/index.php" alt="home">Visit Site</a></p>
</div>
<div class="login-page-title">
    <h2>ONLINE STORE</h2>
</div>

<?php include 'includes/footer.php'; ?>