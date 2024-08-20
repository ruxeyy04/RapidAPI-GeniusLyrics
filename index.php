<?php
include('config.php');
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

if (isset($_SESSION['userid'])) {
    $userinfo_sql = "SELECT *
FROM users 
WHERE userid = ?";
    $userinfo_stmt = $conn->prepare($userinfo_sql);
    $userinfo_stmt->bind_param("i", $userid);
    $userinfo_stmt->execute();
    $userinfo_res = $userinfo_stmt->get_result();
    $userinfo = $userinfo_res->fetch_assoc();
}
if (!isset($_SESSION['userid'])) {
	echo '<meta http-equiv="refresh" content="0;url=/signin.php">';
	exit();
}

?>
<!doctype html>
<html lang="en">

<head>
	<title>Genius Lyrics</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style1.css">
	<style>
		.header,
		.footer {
			background-color: #2196f3;
			color: white;
			text-align: center;
			padding: 1rem;
			transition: background-color 0.3s ease;
		}

		.content {
			flex: 1;
			padding: 1rem;
			overflow-y: auto;
		}

		.station-tab {
			background-color: #f1f1f1;
			border-radius: 8px;
			margin-bottom: 1rem;
			padding: 1rem;
			display: flex;
			align-items: center;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.station-tab:hover {
			background-color: #e0e0e0;
		}

		.station-logo {
			width: 60px;
			height: 60px;
			margin-right: 1rem;
		}

		.station-info {
			flex: 1;
		}

		.station-name {
			font-weight: bold;
			margin-bottom: 0.5rem;
		}

		.station-genre {
			font-size: 0.9rem;
			color: #666;
		}

		.playing {
			background-color: #4caf50;
			color: white;
		}

		.playing .station-genre {
			color: #eee;
		}

		.dark-theme {
			background-color: #333;
			color: white;
		}

		.dark-theme .header,
		.dark-theme .footer {
			background-color: #1565c0;
		}

		.dark-theme .station-tab {
			background-color: #424242;
			color: white;
		}

		.dark-theme .station-tab:hover {
			background-color: #616161;
		}

		.dark-theme .station-genre {
			color: #bbb;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="index.html">Genius <span>Lyrics</span></a>
	
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="fa fa-bars"></span> Menu
			</button>
			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav m-auto">
					<li class="nav-item active"><a href="#" class="nav-link">Home</a></li>
					<li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
					<li class="nav-item"><a href="?logout" class="nav-link">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row d-flex justify-content-center mt-5">
					<div class="col-md-6">
						<div class="form-group">
							<label for="formGroupExampleInput">Search</label>
							<input type="text" class="form-control" id="search_music" placeholder="Search Music">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div id="music_recommendations" class="mt-3">

				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="lyricsModal" tabindex="-1" role="dialog" aria-labelledby="lyricsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="lyricsModalTitle">Lyrics</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="lyrics_content" style="max-height: 400px; overflow-y: auto;">
			
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>

</body>

</html>