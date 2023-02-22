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
		<title>Sign Up | GAMINGcomm</title>
		<link rel="stylesheet" meta-charset="utf-8"  href="css/signup.css">
		<link rel="icon" href="icons/logo.png">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</head>
	
	<body>
	
	<div class="top-brandlogo">
		<img src="icons/logo.png">
		<a href="landingpage.php" class="brand">GAMING<span>comm</span></a>
	</div>
	
	<div class="wrapper"> 

		<p id="status-msg"></p>

		<div class="header-title">
			<p class="green"> Create your account</p>
			<p>Fill in the required information</p>
		</div>

		<div class="row-1">
			<div class="column">
				<label id="label-firstname">First Name</label><br>
				<input id="signup-firstname" name="_firstname"><br>
			</div>
			<div class="column">
				<label id="label-lastname">Last Name</label><br>
				<input id="signup-lastname">
			</div>
		</div>

		
		<div class="row-2">
			<div class="column">
				<label for="country" id="label-country">Country</label>
				<select id="country"><br><br>
					<optgroup id="signup-country" label="Select Country">
						<option value="AR">Argentina</option>
						<option value="AU">Australia</option>
						<option value="IT">Italy</option>
						<option value="JP">Japan</option>
						<option value="MO">Mongolia</option>
						<option value="PH">Philippines</option>
						<option value="SG">Singapore</option>
						<option value="SK">South Korea</option>
						<option value="TH">Thailand</option>
						<option value="US">United States</option>
					</optgroup>
				</select>
			</div>
			<div class="column">
				<label for="gender" id="label-gender">Gender</label>
				<select id="gender"> <br><br>
					<optgroup id="signup-gender" label="Select Gender">
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="">Prefer not to say</option>
					</optgroup>
				</select>
			</div>
		</div>

		<div class="row-3">
			<div class="column">
				<label id="label-email">Email</label><br>
				<input text="" class="email" id="signup-email">
			</div>
		</div>

		<div class="row-4">
			<div class="column">
				<label id="label-pwd">Password</label><br>
				<input type="password" id="signup-pwd">
			</div>
			<div class="column">
				<label id="label-confirmpwd">Confirm Password</label><br>
				<input type="password" id="signup-confirmpwd">
			</div>
		</div>

		<div class="row-5">
			<div class="column">
				<button type="submit" id="signup-submit">Sign Up</button>
			</div>
		</div>
		
		<div class="bottom">
			<label>OR</label>
			<label>Already have an account? <a href="login.php">Sign in here</a></label>
		</div>

	</div>
		

	</body>
</html>


<script>

	$("#signup-submit").click(function(){

		$("#label-firstname, #label-lastname, #label-email, #label-gender, #label-pwd, #label-confirmpwd, #label-country").removeClass("text-error");
		$("#signup-firstname, #signup-lastname, #signup-email, #gender, #country, #signup-pwd, #signup-confirmpwd").removeClass("border-error");
		$("#status-msg").removeClass('status-error'); $("#status-msg").removeClass('status-success'); $("#status-msg").text(null);
		
		let firstname 			= $("#signup-firstname").val();
		let lastname 			= $("#signup-lastname").val();
		let gender      		= $("#signup-gender").children("option:selected").val();
		let country      		= $("#signup-country").children("option:selected").val();
		let email				= $("#signup-email").val();
		let pwd 				= $("#signup-pwd").val();
		let confirmpwd 			= $("#signup-confirmpwd").val();

		if($.trim(firstname).length > 0 && $.trim(lastname).length > 0 && $.trim(email).length > 0 &&
		   $.trim(pwd).length > 0 && $.trim(confirmpwd).length > 0 && $.trim(country).length > 0 && 
		   $.trim(gender).length > 0){

			// CALLING AJAX
			$.ajax({
				url: "includes/server-process/signup-ajax.php",
				method: "POST",
				data: {firstname:firstname, 
						lastname: lastname,
						gender: gender,
						country: country,
						email: email,
						pwd: pwd,
						confirmpwd: confirmpwd},
				cache: false,
				success: function(data){
					
					if(data == "errorEmail"){
						$("#status-msg").addClass('status-error');
						$("#label-email").addClass("text-error");
						$("#signup-email").addClass("border-error");

						$("#status-msg").text("Insert a valid Email Address.");
					}

					if(data == "errorSpecialChar"){
						$("#status-msg").addClass('status-error');

						$("#label-firstname").addClass("text-error");
						$("#signup-firstname").addClass("border-error");

						$("#label-lastname").addClass("text-error");
						$("#signup-lastname").addClass("border-error");

						$("#status-msg").text("Special character are not allowed, please try again.");
					}

					if(data == "errorEmailExist"){
						$("#status-msg").addClass('status-error');

						$("#label-email").addClass("text-error");
						$("#signup-email").addClass("border-error");

						$("#status-msg").text("Email already exists.");
					}

					if(data == "errorUserExist"){
						$("#status-msg").addClass('status-error');
						$("#label-firstname, #label-lastname, #label-email, #label-gender, #label-pwd, #label-confirmpwd, #label-country").addClass("text-error");
						$("#signup-firstname, #signup-lastname, #signup-email, #signup-pwd, #signup-confirmpwd").addClass("border-error");
						$("#status-msg").text("User already exists.");
					}

					if(data == "errorPwdNotMatch"){
						$("#status-msg").addClass('status-error');

						$("#label-pwd").addClass("text-error");
						$("#signup-pwd").addClass("border-error");

						$("#label-confirmpwd").addClass("text-error");
						$("#signup-confirmpwd").addClass("border-error");

						$("#status-msg").text("Password does not match, please try again.");
					}

					if(!data.includes("error")){
						location.href="login.php?signup=success";
					}
				}
			});
			
		}else{
			
			$("#status-msg").addClass('status-error');
			$("#label-firstname, #label-lastname, #label-email, #label-gender, #label-pwd, #label-confirmpwd, #label-country").addClass("text-error");
			$("#signup-firstname, #signup-lastname, #signup-email, #signup-pwd, #signup-confirmpwd, #country, #gender").addClass("border-error");
			$("#status-msg").text("Fill-in all the required details.");
		}
	});
	
</script>