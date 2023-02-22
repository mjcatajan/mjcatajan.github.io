<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="icons/logo.png">
	
	<link rel="stylesheet" type="text/css" href="css/landingpage-navbar.css">
	<link rel="stylesheet" type="text/css" href="css/landingpage.css">
	
	<title>Gamingcomm</title>

	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js'></script>

</head>
<body>



<header>

	<div class="navbar-brandlogo">
		<img src="icons/logo.png">
		<a href="#" class="brand">GAMING<span>comm</span></a>
	</div>

	<div class="list-of-header-buttons">
		<div class="container-list-header-buttons">
			<div class="header-button-1">
				<img src="icons/hot-sale.png" alt="">
			</div>

			<div class="header-button-2">
				<img src="icons/games.png" alt="">
			</div>

			<div class="header-button-3">
				<img src="icons/magnifying-glass.png" alt="">
			</div>
		</div>
	</div>

	<?php 
	if(isset($_SESSION['id_user'])){

		echo '
		<div class="wrapper-dropdown stayput" onclick="closeandopen()" id="clicks">
			<div class="container-dropdown stayput" id="clicks">
				<div>
					<img src="pictures/diva.jpg" alt="" class="dropdown-image stayput" id="clicks">
				</div>
				<div class="dropdown-user-info stayput" id="clicks">
					<span class="stayput" id="clicks">'.$userInfo[0]['first_name']." ".$userInfo[0]['last_name'].'</span>
					<img src="icons/arrow-down-white.png" alt="" class="dropdown-arrow stayput" id="clicks rotateArrowMenu">
				</div>
			</div>
			<div class="container-links" id="toggleOpenClose">
					<a href="viewprofile.php"><img src="icons/user.png" alt="" class="stayput fix-icon-dropdown "> View Profile</a>
					<a href="#"><img src="icons/settings.png" alt="" class="stayput fix-icon-dropdown "> Settings</a>
					<a href="#"><img src="icons/support.png" alt="" class="stayput fix-icon-dropdown "> Get Support</a>
					<a href="includes/logout.php"><img src="icons/logout.png" alt="" class="stayput fix-icon-dropdown">Log Out</a>
			</div>
		</div>
		';

	}else{

		echo '
			<div class="navbar-buttons">
				<a href="login.php" class="navbar-login">LOG IN</a>
				<a href="signup.php" class="navbar-signup"> GET STARTED</a>
			</div>
		';
	}
	?>
	
</header>

<div class="forum-content">
	<div class="left">
		<div class="left-column-content">
			<div class="title-ListofContent">
				<p>LIST OF GAMES</p>
			</div>

			<div class="content-ListofContent">
				<p>League of Legends</p>
				<p>Overwatch 2</p>
				<p>PlayersUnknown's Battleground</p>
				<p>Genshin Impact</p>
				<p>Call of Duty: Warzone 2.0</p>
				<a href="#">See all <img src="icons/arrow-down.png"></a>
			</div>
		</div>

		<div class="left-column-content">
			<div class="title-ListofContent">
				<p>LIST OF GENRE</p>
			</div>

			<div class="content-ListofContent">
				<p>Role Playing</p>
				<p>FPS</p>
				<p>Battle Royale</p>
				<p>SandBox / OpenWorld Games</p>
				<p>Action</p>
				<a href="#">See all <img src="icons/arrow-down.png"></a>
			</div>
		</div>

		<div class="left-column-content">
			<div class="title-ListofContent">
				<p>FORUM GUIDES</p>
			</div>

			<div class="content-ListofContent">
				<p>Rules and Regulation</p>
				<p>How to start a thread?</p>
				<p>Avoid Plagiarism; Here's How</p>
				<p>Welcome page for Newcomers</p>
				<p>Frequently Asked Questions</p>
				<a href="#">See all <img src="icons/arrow-down.png"></a>
			</div>
		</div>

		<div class="left-column-content">
			<div class="title-ListofContent">
				<p>GAME TUTORIALS</p>
			</div>

			<div class="content-ListofContent">
				<p>League of Legends</p>
				<p>Overwatch 2</p>
				<p>PlayersUnknown's Battleground</p>
				<p>Genshin Impact</p>
				<p>Call of Duty: Warzone 2.0</p>
				<a href="#">See all <img src="icons/arrow-down.png"></a>
			</div>
		</div>


	</div>
	<div class="center">
		
		<div class="center-label">
			<p>Latest Posts</p>
		</div>

		<div class="center-content-post">

			<!-- Post of the user -->
			<div class="load-posts-here">
			</div>
			<!-- Post of the user -->
		</div>
	</div>

	<div class="right">
		<div class="left-column-content">
			<div class="title-ListofContent">
				<p>POPULAR POSTS</p>
			</div>

			<div class="content-ListofContent">
				<p>How to Install League of Legends</p>
				<p>Update Log 3.1</p>
				<p>New Update: Gamingcomm</p>
				<p>Avoid Losing in every Game!</p>
				<p>Competitive game conversation</p>
				<a href="#">See all <img src="icons/arrow-down.png"></a>
			</div>
		</div>

		<div class="contact-us">
			<p>GET INTOUCH WITH US!</p>

			<div class="contact-us-logo">
				<img src="icons/facebook.png">
				<img src="icons/twitter.png">
			</div>
		</div>

		<div class="end-credits">
			<p>Created By: Tracer • Infomation Assurance and Security • 2022</p>
		</div>

	</div>
</div>

</body>
</html>

<script>
	$(document).ready(function(){
		$.ajax({
			url: "includes/server-process/notlogin-refresh.ajax.php",
			type: "POST",
			cache: false,
			success: function(data){
				$(".load-posts-here").html(data);
			}
		});
	});
</script>