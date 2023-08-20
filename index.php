<?php
session_start();
require_once 'backend/class/bdd.php';
require_once 'backend/fonction/fonction.php';
$count = compter('admin');
if(!empty($_SESSION['role'])) : 
	header('location: backend/Gpage.php');
	exit();
?>
<?php else : ?> 
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Login V12</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
	<!--===============================================================================================-->	
		<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="login/css/util.css">
		<link rel="stylesheet" type="text/css" href="login/css/main.css">
	<!--===============================================================================================-->
	</head>
	<body>
		
		<div class="limiter">
			<div class="container-login100" style="background-image: url('login/images/1s.jpg');">
				<div class="wrap-login100 p-t-190 p-b-30">
					<form class="login100-form validate-form" action="backend/auth.php" method="POST">
						<div class="login100-form-avatar">
							<img src="login/images/avatar.jpg" alt="AVATAR">
						</div>
	
						<span class="login100-form-title p-t-20 p-b-45">
							Gestion D'Institut
						</span>
						<?php if(isset($_GET['success']) AND $_GET['success'] == 1) : ?>
						<div style="background-color:cyan" class="alert alert-success m-b-10">
							<p>Modification Réussie</p>
						</div>
						<?php endif ?>
						<?php if(isset($_GET['success']) AND $_GET['success'] == 2) : ?>
						<div style="background-color:cyan" class="alert alert-success m-b-10">
							<p>Operation Réussie</p>
						</div>
						<?php endif ?>
						<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
							<input class="input100" type="text" required name="nad" placeholder="PSEUDO">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-user"></i>
							</span>
						</div>
	
						<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
							<input class="input100" type="password" required name="pass" placeholder="MOT DE PASSE">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock"></i>
							</span>
						</div>
	
						<div class="container-login100-form-btn p-t-10">
							<button class="login100-form-btn">
								Login
							</button>
						</div>
						<?php if($count == 0) : ?>
						<div>
							<a class="txt1" href="user/creatUser.php">
								Creer Un Compte
								<i class="fa fa-long-arrow-right"></i>						
							</a>
						</div>
						<?php endif ?>
						<div>
							<a href="user/mdpOublier.php" class="txt1">
								Mot de Passe Oublier?
							</a>
						</div>
	
						
						
					</form>
				</div>
			</div>
		</div>
		
		
	
		
	<!--===============================================================================================-->	
		<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/bootstrap/js/popper.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
		<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
		<script src="js/main.js"></script>
	
	</body>
	</html>
<?php endif ?>
