<?php include 'config.php' ?>
<!doctype html>
<html lang="en">

<head>
	<title>Sign-Up</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Genius Lyrics</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(images/bg.png);">
						</div>
						<div class="login-wrap p-4 p-md-5">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="mb-4">Sign Up</h3>
								</div>
							</div>
							<form action="#" class="signin-form" method="post">
								<div class="form-group mb-3">
									<label class="label" for="name">Username</label>
									<input type="text" class="form-control" name="username" placeholder="Username" required>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="password">Password</label>
									<input type="password" name="password" class="form-control" placeholder="Password" required>
								</div>
								<div class="form-group">
									<button type="submit" name="login" class="form-control btn btn-primary rounded submit px-3">Sign
										In</button>
								</div>
							</form>
							<p class="text-center">Not a member? <a href="signup.php">Sign Up</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php

	if (isset($_POST['login'])) {
		$uname = $_POST['username'];
		$password = $_POST['password'];

		// Query to check username and password
		$sql = "SELECT userid FROM users WHERE username = '$uname' AND password = '$password'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$userid = $row['userid'];
			$_SESSION['userid'] = $userid;
			$_SESSION['alert'] = "<script>
			Swal.fire({
				icon: 'success',
				title: 'Login Successful',
				text: 'Welcome User',
				allowOutsideClick: false
			}).then((result) => {
				if (result.isConfirmed) {
					window.location.href = '/index.php';
				}
			});
		</script>";
			echo '<meta http-equiv="refresh" content="0;url=signin.php">';
			exit();
		} else {
			$_SESSION['alert'] = "<script>
		Swal.fire({
			icon: 'info',
			title: 'Invalid',
			text: 'Invalid username or password',
		})
	</script>";
			echo '<meta http-equiv="refresh" content="0;url=signin.php">';
			exit();
		}

		$conn->close();
	}
	?>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<?php 
if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
}
?>
</body>

</html>