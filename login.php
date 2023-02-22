<?php
	session_start();
	if(isset($_SESSION['id_user'])){
		header("location: homepage.php");
	}
?>

<!DOCTYPE HTML>
<html>
	<head> 
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login | GAMINGcomm</title>
		<link rel="stylesheet" meta-charset="utf-8"  href="css/login.css">
		<link rel="icon" href="icons/logo.png">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	
	<body>
		<div class="top-brandlogo">
			<img src="icons/logo.png">
			<a href="homepage.html" class="brand">GAMING<span>comm</span></a>
		</div>
		
			<div class="wrapper"> 
			<p id="status-msg" style="text-align: center; border-radius: 5px 5px 5px 5px; font-size: 15px; color: black; margin-bottom: 10px;"></p>
				<center>
					<label class="green"> Login</label><br>
					<label>Sign in to your account</label>
				</center>

				<div class="row">
					<div class="column">
						<label for="login-email" id="label-email">Email:</label><br>
						<input class="textbox2" id="login-email"><br>
						<label for="login-pwd" id="label-pwd">Password:</label><br>
						<input type="password" class="textbox2" id="login-pwd">
					</div>	
				</div>
				<div class="row">
					<div class="column">
						<button id="login-submit" type="submit">Log In</button>
					</div>
				</div>
				
				<div class="bottom">
					<label class="label-1">OR</label>
				</div>

				<div class="bottom-1">
					<label><a href="signup.php">Create an account</a></label>
				</div>
			</div>

			<div class="end-credits">
				<label>Created By: Tracer • Infomation Assurance and Security • 2022</label>
			</div>

	</body>
	
</html>

<script>
	$("#login-submit").click(function(){

		$("#label-email, #label-pwd").removeClass("text-error");
		$("#login-email, #login-pwd").removeClass("border-error");
		$("#status-msg").removeClass('status-error'); $("#status-msg").removeClass('status-success'); $("#status-msg").text(null);

		let email 	= $("#login-email").val();
		let pwd 	= $("#login-pwd").val();

		if($.trim(email).length > 0 && $.trim(pwd).length > 0){

			$.ajax({
				url: "includes/server-process/login-ajax.php",
				method: "POST",
				data: {
					email: email,
					pwd: pwd
				},
				cache: false,
				success: function(data){

					if(data == 'errorEmail'){
						$("#status-msg").addClass('status-error');
						$("#label-email").addClass("text-error");
						$("#login-email").addClass("border-error");
						$("#status-msg").text("Insert a valid Email Address.");
					}
					
					if(data == 'errorUserNotFound'){
						$("#status-msg").addClass('status-error');
						$("#label-email, #label-pwd").addClass("text-error");
						$("#login-email, #login-pwd").addClass("border-error");
						$("#status-msg").text("There is no user registered on that email.");
					}

					if(data == 'errorNotMatch'){
						$("#status-msg").addClass('status-error');
						$("#label-email, #label-pwd").addClass("text-error");
						$("#login-email, #login-pwd").addClass("border-error");
						$("#status-msg").text("Email or Password is incorrect.");
					}

					if(!data.includes("error")){
						location.href="homepage.php";
					}
				}
			});
		}else{
			$("#status-msg").addClass('status-error');
			$("#label-email, #label-pwd").addClass("text-error");
			$("#login-email, #login-pwd").addClass("border-error");
			$("#status-msg").text("Fill-in all the required details.");
		}



	});

</script>

