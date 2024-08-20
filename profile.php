<?php
include('config.php');

$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

if (!isset($_SESSION['userid'])) {
    echo '<meta http-equiv="refresh" content="0;url=/signin.php">';
    exit();
}

$alert = ""; // Initialize alert variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        // Handle profile update
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $username = $_POST['username'];

        $update_sql = "UPDATE users SET fname = ?, lname = ?, username = ? WHERE userid = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $fname, $lname, $username, $userid);

        if ($update_stmt->execute()) {
            $_SESSION['alert'] = "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Profile updated successfully.',
                    allowOutsideClick: false
                });
            </script>";
            echo '<meta http-equiv="refresh" content="0;url=profile.php">';
			exit();
        } else {
            $_SESSION['alert'] ="<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update profile. Please try again.',
                    allowOutsideClick: false
                });
            </script>";
            echo '<meta http-equiv="refresh" content="0;url=profile.php">';
			exit();
        }
    }

    if (isset($_POST['changepassword'])) {
        // Handle password change
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Fetch the current password from the database
        $password_sql = "SELECT password FROM users WHERE userid = ?";
        $password_stmt = $conn->prepare($password_sql);
        $password_stmt->bind_param("i", $userid);
        $password_stmt->execute();
        $password_res = $password_stmt->get_result();
        $user_password = $password_res->fetch_assoc()['password'];

        // Verify the current password
        if ($current_password === $user_password) {
            if ($new_password === $confirm_password) {
                $update_password_sql = "UPDATE users SET password = ? WHERE userid = ?";
                $update_password_stmt = $conn->prepare($update_password_sql);
                $update_password_stmt->bind_param("si", $new_password, $userid);

                if ($update_password_stmt->execute()) {
                    $_SESSION['alert'] = "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Password changed successfully.',
                            allowOutsideClick: false
                        });
                    </script>";
                    echo '<meta http-equiv="refresh" content="0;url=profile.php">';
			exit();
                } else {
                    $_SESSION['alert'] = "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to change password. Please try again.',
                            allowOutsideClick: false
                        });
                    </script>";
                    echo '<meta http-equiv="refresh" content="0;url=profile.php">';
			exit();
                }
            } else {
                $_SESSION['alert'] = "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'New passwords do not match.',
                        allowOutsideClick: false
                    });
                </script>";
                echo '<meta http-equiv="refresh" content="0;url=profile.php">';
			exit();
            }
        } else {
           $_SESSION['alert'] = "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Current password is incorrect.',
                    allowOutsideClick: false
                });
            </script>";
            echo '<meta http-equiv="refresh" content="0;url=profile.php">';
			exit();
        }
    }
}

// Fetch user info for profile editing
$userinfo_sql = "SELECT fname, lname, username FROM users WHERE userid = ?";
$userinfo_stmt = $conn->prepare($userinfo_sql);
$userinfo_stmt->bind_param("i", $userid);
$userinfo_stmt->execute();
$userinfo_res = $userinfo_stmt->get_result();
$userinfo = $userinfo_res->fetch_assoc();

?>

<!doctype html>
<html lang="en">

<head>
    <title>Genius Lyrics | Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style1.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">Genius <span>Lyrics</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span> Menu
            </button>
            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item active"><a href="profile.php" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="?logout" class="nav-link">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3 class="text-center">Edit Profile</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($userinfo['fname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($userinfo['lname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($userinfo['username']); ?>" required>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary btn-block">Update Profile</button>
                </form>

                <h4 class="mt-5">Change Password</h4>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" name="changepassword" class="btn btn-warning btn-block">Change Password</button>
                </form>
            </div>
        </div>
    </div>

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
