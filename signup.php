<?php
	if(isset($_POST["data"])){
		//@require_once "db_connection.php";
		
		if($_POST["data"]=="submit"){
			
			$callbacks = array();

			function callbacks($field, $status, $message){
				global $callbacks;
				$callback = array(
					"field" => $field,
					"status" => $status,
					"message" => $message
				);
				array_push($callbacks, $callback);
			}

			//Email validation
			if(!isset($_POST["email"])){
				callbacks("email", false, "Email address field isn't set. Please refresh the page.");
			}else if(trim($_POST["email"])==NULL){
				callbacks("email", false, "Please enter email address.");
			}else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
				callbacks("email", false, "Please enter a valid email address.");
			}else{
				callbacks("email", true, NULL);
			}

			//Name validation
			if(!isset($_POST["name"])){
				callbacks("name", false, "Name field isn't set. Please refresh the page.");
			}else if(trim($_POST["name"])==NULL){
				callbacks("name", false, "Please enter your name.");
			}else{
				callbacks("name", true, NULL);
			}

			//DOB validation
			if(!isset($_POST["day"], $_POST["month"], $_POST["year"])){
				callbacks("dob", false, "Date of birth field isn't set. Please refresh the page.");
			}else if(!checkdate($_POST["month"], $_POST["day"], $_POST["year"])){
				callbacks("dob", false, "Please select a valid date.");
			}else if(((new DateTime($_POST["year"]."-".$_POST["month"]."-".$_POST["day"]))->diff(new DateTime())->y)<18){
				callbacks("dob", false, "User must be atleast 18 years of age.");
			}else{
				callbacks("dob", true, NULL);
			}
			
			//Gender validation
			if(!isset($_POST["gender"])){
				callbacks("gender", false, "Gender dropdown isn't set. Please refresh the page.");
			}else if(!in_array($_POST["gender"], [0, 1, 2, 3])){
				callbacks("gender", false, "Please select your gender");
			}else{
				callbacks("gender", true, NULL);
			}

			//Username validation
			if(!isset($_POST["username"])){
				callbacks("username", false, "Username field isn't set. Please refresh the page.");
			}else if(trim($_POST["username"])==NULL){
				callbacks("username", false, "Please enter your username.");
			}else{
				callbacks("username", true, NULL);
			}

			//Password validation
			if(!isset($_POST["password"])){
				callbacks("password", false, "Password field isn't set. Please refresh the page.");
			}else if(strlen(trim($_POST["password"]))<6){
				callbacks("password", false, "Please enter a password of atleast 6 characters.");
			}else{
				callbacks("password", true, NULL);
			}
			echo(json_encode($callbacks));

		}else if($_POST["data"]=="check"){
			
		}
		die();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign up | Hive</title>
	<link rel="shortcut icon" type="image/x-icon" href="media/images/branding-images/favicon.svg">
	<link rel="stylesheet" type="text/css" href="cdn/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="cdn/fontawesome-free-6.3.0-web/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="static/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
	<header class="navbar">
		<div class="container-fluid">
			<a href="/" class="navbar-brand"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 42" width=64><path d="M29.44 17.89a17.32 17.32 0 0 1-.21 2.72l-.44 2.86-2.82 18.18h-5.76c-.55 0-.99-.19-1.32-.58a3.69 3.69 0 0 1-.73-1.37c-.16-.52-.23-.93-.23-1.25 0-.54.04-1.23.12-2.09l.29-2.7.34-2.47 1-5.81.47-2.55c.16-.81.24-1.45.24-1.92a2.1 2.1 0 0 0-.24-.96c-.15-.29-.4-.44-.76-.44-.51 0-1.26.45-2.26 1.34-.99.88-2.07 2.18-3.23 3.88-1.15 1.71-2.19 3.78-3.11 6.22-.92 2.43-1.54 5.2-1.85 8.3-.05.51-.49.96-1.36 1.34-.85.41-1.81.71-2.85.94-1.03.24-1.88.35-2.55.35-.51 0-.95-.11-1.32-.35-.38-.23-.64-.73-.77-1.48s-.12-1.91.04-3.46l2.52-22.88.88-6.6c.35-2.18.59-4.38.71-6.58h5.58c.98 0 1.77.48 2.4 1.48.64.99.94 2.01.94 3.05 0 .85-.06 1.63-.17 2.35l-.44 2.24-.67 2.84-3.53 15c1.19-2.75 2.48-5.07 3.87-6.98 2.01-2.75 4-4.76 6-6.01s3.79-1.89 5.41-1.89c1.91 0 3.37.48 4.35 1.45.97.97 1.46 2.25 1.46 3.83zM33.79 42c-.74 0-1.36-.53-1.85-1.6-.49-1.06-.73-2.26-.73-3.57l.09-2.5.32-3.14 2.11-18.65h5.99c.98 0 1.66.43 2.06 1.28.39.85.59 1.82.59 2.9a12.96 12.96 0 0 1-.12 1.71l-.35 2.76-1.12 9.47-.59 4.88-.5 3.57-.38 2.87h-5.52zm5.17-31.37c-1.37 0-2.56-.47-3.55-1.39-1-.93-1.5-2.13-1.5-3.6 0-1.78.58-3.17 1.73-4.15C36.79.49 38.14 0 39.66 0c1.41 0 2.59.41 3.55 1.22s1.44 2.05 1.44 3.72c0 1.63-.57 2.98-1.7 4.07-1.13 1.08-2.46 1.62-3.99 1.62zM53.64 42c-1.8 0-3.31-.59-4.52-1.77s-1.94-2.97-2.17-5.37l-1.29-13.01c-.08-.89-.21-1.79-.38-2.7-.18-.91-.4-1.64-.68-2.18-.27-.54-.51-.92-.71-1.13s-.29-.47-.29-.78.28-.61.85-.9 1.26-.56 2.09-.81a18.99 18.99 0 0 1 2.53-.58c.86-.14 1.59-.2 2.17-.2.9 0 1.57.37 2 1.1.43.74.76 2.19 1 4.36l1.64 14.76c.12 1.12.26 1.92.44 2.38.18.47.46.7.85.7.2 0 .57-.31 1.12-.93s1.15-1.59 1.79-2.9c.65-1.32 1.2-3 1.65-5.05s.68-4.51.68-7.38c0-.93-.13-1.65-.38-2.15-.26-.5-.38-.95-.38-1.34 0-.43.27-.85.82-1.28s1.23-.81 2.06-1.16a15.16 15.16 0 0 1 2.44-.81c.8-.19 1.46-.29 1.97-.29.59 0 1.17.15 1.76.46s.88 1.12.88 2.44c0 1.78-.28 3.82-.85 6.13s-1.38 4.65-2.44 7.03-2.32 4.59-3.79 6.62-3.11 3.67-4.94 4.91c-1.83 1.21-3.8 1.83-5.92 1.83zm39.84-10.06c-.23 0-.51.1-.82.27l-.94.56c-.98.62-2.23 1.25-3.73 1.89-1.51.63-3.06.96-4.68.96-1.6 0-2.64-.59-3.11-1.78-.29-.73-.49-1.62-.61-2.66 2.75-.67 5.23-1.44 7.43-2.32 2.82-1.15 5.02-2.52 6.61-4.1 1.57-1.6 2.37-3.44 2.37-5.54 0-2.17-.86-3.82-2.58-4.96-1.73-1.15-3.84-1.72-6.34-1.72a15.34 15.34 0 0 0-6.44 1.39c-2.02.93-3.79 2.25-5.35 3.96-1.54 1.71-2.75 3.69-3.61 5.98-.87 2.29-1.3 4.8-1.3 7.55 0 3.29.98 5.88 2.91 7.76S77.71 42 80.72 42c2.24 0 4.2-.33 5.87-.99 1.69-.65 3.11-1.46 4.26-2.43 1.16-.97 2.03-1.96 2.62-2.96s.88-1.86.88-2.55c0-.31-.09-.58-.24-.79-.14-.23-.36-.34-.63-.34zm-13.11-8.88c.59-1.86 1.32-3.35 2.2-4.48.88-1.11 1.75-1.68 2.62-1.68.71 0 1.24.33 1.59.96.34.64.49 1.43.4 2.36-.07 1.36-.62 2.55-1.64 3.59-1.02 1.05-2.33 1.89-3.9 2.53-.66.27-1.35.5-2.06.69a19.53 19.53 0 0 1 .79-3.97z"/></svg></a>
			<a href="login" class="btn btn-primary rounded-pill">Login</a>
		</div>
	</header>
	<main class="bg-body-secondary flex-grow-1">
		<article class="container-xxl">
			<div class="mx-auto my-5 p-3 rounded bg-white" style="max-width: 350px">
				<h4>Sign up</h4>
				<form id="signup-form" method="post">
					<div>
						<label for="email" class="form-label">Email address</label>
						<input type="email" id="email" name="email" class="form-control" data-field="email" spellcheck="false">
						<div data-feedback="email"></div>
					</div>
					<div class="my-3">
						<label for="name" class="form-label">Full name</label>
						<input type="text" id="name" name="name" class="form-control" data-field="name" spellcheck="false">
						<div data-feedback="name"></div>
					</div>
					<div>
						<label for="day" class="form-label">Date of birth</label>
						<div class="input-group">
							<select id="day" name="day" class="form-select" data-field="dob">
							</select>
							<select id="month" name="month" class="form-select" data-field="dob">
							</select>
							<select id="year" name="year" class="form-select" data-field="dob">
							</select>
						</div>
						<div data-feedback="dob"></div>
					</div>
					<div class="my-3">
						<label for="gender" class="form-label">Gender</label>
						<select id="gender" name="gender" class="form-select" data-field="dob">
							<option value="1">Male</option>
							<option value="2">Female</option>
							<option value="3">Non Binary</option>
							<option value="0">Rather Not Say</option>
						</select>
						<div data-feedback="gender"></div>
					</div>
					<div>
						<label for="username" class="form-label">Username</label>
						<input type="text" id="username" name="username" class="form-control" data-field="dob" spellcheck="false">
						<div data-feedback="username"></div>
					</div>
					<div class="my-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" id="password" name="password" class="form-control" data-field="dob" autocomplete="off" minlength="6">
						<div data-feedback="password"></div>
					</div>
					<div><button type="submit" id="submit-button" class="btn btn-primary w-100">Continue</button></div>
				</form>
                <div class="my-3"><a href="login" class="text-decoration-none">Already have an account?</a></div>
                <div class="small">By signing up, you agree to our <a href="legal" class="text-decoration-none">User Agreement</a>, <a href="legal" class="text-decoration-none">Privacy Policy</a> and <a href="legal" class="text-decoration-none">Cookies Policy</a>.</div>
            </div>
		</article>
	</main>
	<footer class="d-flex flex-wrap justify-content-center p-2">
		<a href="#" class="my-1 mx-2 link-dark text-decoration-none small">About us</a>
		<a href="#" class="my-1 mx-2 link-dark text-decoration-none small">Privacy policy</a>
		<a href="#" class="my-1 mx-2 link-dark text-decoration-none small">User agreement</a>
		<a href="#" class="my-1 mx-2 link-dark text-decoration-none small">Cookie policy</a>
		<a href="#" class="my-1 mx-2 link-dark text-decoration-none small">Join team</a>
		<small class="my-1 mx-2">Hive © 2023. All rights reserved</small>
	</footer>
</body>
<script src="cdn/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>
<script src="cdn/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function(){
	var currentDate = new Date();
	var currentYear = currentDate.getFullYear();
	var $daySelect = $("#day");
	for (var day = 1; day <= 31; day++) {
		var option = $("<option>").val(day).text(day);
		$daySelect.append(option);
	}
	var $monthSelect = $("#month");
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	$.each(months, function(index, month) {
		var monthNumber = index + 1;
		var option = $("<option>").val(monthNumber).text(month);
		$monthSelect.append(option);
	});
	var $yearSelect = $("#year");
	for (var year = currentYear - 100; year <= currentYear; year++) {
		var option = $("<option>").val(year).text(year);
		$yearSelect.append(option);
	}
	var currentDay = currentDate.getDate();
	$daySelect.val(currentDay);
	var currentMonth = currentDate.getMonth() + 1;
	$monthSelect.val(currentMonth);
	$yearSelect.val(currentYear);

	//Submitting data
	$("#signup-form").submit(function(e){
		e.preventDefault();
		$("#submit-button").html("<i class='fa-solid fa-circle-notch fa-spin'></i>");
		var form_data = $(this).serializeArray();
		form_data.push({name: "data", value: "submit"});
		form_data = $.param(form_data);

		//sending form data
		$.post(window.location.href, form_data)
		.done(function(t){
			console.log(JSON.parse(t));
		})
		.fail(function(){
			console.log(error);
		})
		.always(function(){
			$("#submit-button").html("Continue");
		})
	})
	
});
</script>
</html>