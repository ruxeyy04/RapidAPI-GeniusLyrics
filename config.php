
<?php
date_default_timezone_set('Asia/Manila');
// Create a DateTime object
$dateTime = new DateTime();

// Format the DateTime object
$timestamp = $dateTime->format('Y-m-d H:i:s');

session_start();
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "noridel_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

$delivery_fee = 20.00;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['logout'])) {
    session_destroy();
    session_unset();
    session_start();
    $_SESSION['alert'] = "<script>
    Swal.fire({
        icon: 'success',
        title: 'Logout Successful',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/signin.php';
        }
    });
</script>";
}