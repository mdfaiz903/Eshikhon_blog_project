<?php
	include_once 'database/connection.php';
	$error = '';
	$invalid='';

	if(isset($_POST['login'])){
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$password = mysqli_real_escape_string($conn,$_POST['password']);

		if(empty($email)||empty($password)){
			$error = "<span> This field is required</span>";
		}else{
			$password = md5($password);
			$sql = "SELECT * FROM WHERE email='$email' AND password='$password'";
			$query = mysqli_query($conn,$sql);
			if(mysqli_num_rows($query)>0){
				header ('location:index.php');
			}else{
				$invalid = "INVALID EMAIL & PASSWORD";
			}
		}
	}

?>


<!doctype html>
<html lang="en" class="fullscreen-bg">
	<!-- add headder.php -->
<?php
	include_once 'layouts/css/css_layout.php';
?>
<!-- add header.php// -->

	
<body>
	<!-- WRAPPER -->
<div id="wrapper">
	<div class="vertical-align-wrap">
		<div class="vertical-align-middle">
			<div class="auth-box ">
				<div class="left">
					<div class="content">
						<div class="header">
							<div class="logo text-center"><img src="assets/img/logo-dark.png" alt="Klorofil Logo"></div>
							<p class="lead">Login to your account</p>
						</div>
					<!-- form start -->
						<form class="form-auth-small" action="" method="POST">
							<div class="form-group">
								<label for="email" class="control-label sr-only">Email</label>
								<input type="email" class="form-control" placeholder="Enter your email" id="email" name="email">
								<?=$error;?>
								<?=$invalid;?>
							</div>
							<div class="form-group">
								<label for="assword" class="control-label sr-only">Password</label>
								<input type="password" class="form-control" name="password" placeholder="Password"  id="password" name="password">
								<?=$error;?>
								<?=$invalid;?>
							</div>
							<div class="form-group clearfix">
								<label class="fancy-checkbox element-left">
									<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
									<span>Remember me</span>
								</label>
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-block" name="login">LOGIN</button>
							<div class="bottom">
								<span class="helper-text"><i class="fa fa-lock"></i> <a href="">Forgot password?</a></span>
							</div>
						</form>
					</div>
				</div>
				<div class="right">
					<div class="overlay"></div>
					<div class="content text">
						
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
	<!-- END WRAPPER -->
</body>

</html>
