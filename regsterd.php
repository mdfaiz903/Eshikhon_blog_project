<?php
	include_once 'database/connection.php';
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;

		require 'phpmailer/src/Exception.php';
		require 'phpmailer/src/PHPMailer.php';
		require 'phpmailer/src/SMTP.php';
		


	$error = '';
	$length = '';
	$pwd = '';
	$email_check = '';
	

	if(isset($_POST['singup'])){
		$name = mysqli_escape_string($conn,$_POST['name']);
		$email = mysqli_escape_string($conn,$_POST['email']);
		$password = mysqli_escape_string($conn,$_POST['password']);
		$comfirm_password = mysqli_escape_string($conn,$_POST['com_password']);
		$mobile = mysqli_escape_string($conn,$_POST['mobile']);
		$university = mysqli_escape_string($conn,$_POST['university']);
		$email_exist = "SELECT email FROM user where email='$email'";

		$query = mysqli_query($conn,$email_exist);

		if(mysqli_num_rows($query)>0){
				$email_check = "Yout email is already existed";
		}
		
		if(empty($name) || empty($email)||empty($password)||empty($comfirm_password)||empty($mobile)||empty($university)){
			$error = "This field is required";
		}elseif(strlen($name)<5){
				$length ="Length must be greater than 4";
		}elseif($password != $comfirm_password){
			$pwd = "Your password does not match";
		}else{
			$password = md5($password);
			$vkey = md5(time().$mobile);
			echo "<script>alert('$vkey')</script>";
			$sql = "INSERT INTO user (name,email,password,mobile,university,v_key,v_status) VALUES ('$name','$email','$password','$mobile','$university','$vkey',0)";
			$query = mysqli_query($conn,$sql);

			
				if($query){
				$mail = new PHPMailer;
				//* set phpmailer to use SMTP */
				$mail->isSMTP();
				/* smtp host */
				$mail->Host = "smtp.gmail.com";

				$mail->SMTPAuth = true;
				
				/* Provide User Name and Password as your email address$mai(FromEmail) */
				$mail->Username = "bishobabubrand@gmail.com";/* your email please */

				$mail->Password = "your password please";/* your password please */

				$mail->SMTPSecure ="tls";

				$mail->Port= 587;

				$mail->From = "bishobabubrand@gmail.com";/* your email please */

				$mail ->FromName = "fayez";

				$mail ->addAddress($email,"fayez");

				$mail ->isHTML(true);
				$mail ->Subject = "Email varification";
				$mail ->Body = "<a href = 'http://localhost/university%20project%20eshikhon/verify.php?vkey=$vkey'>Click this activation link</a>";

				if(!$mail->send()){
					echo "Mail Error".$mail->ErrorInfo;
				}else{
					echo "<script>alert('verificatin key has been send successully')</script>";
				}
				header ("location:success.php");
				
			}
			else{
				echo mysqli_error($conn);
	}
		}

		


	}
	

?>




<!doctype html>
<html lang="en" class="fullscreen-bg">
<!-- css link layout -->
<?php
	include_once 'layouts/css/css_layout.php';
?>
<!-- css link layout // -->
<body>
	<!-- WRAPPER -->
<div id="wrapper">
	<div class="vertical-align-wrap">
		<div class="vertical-align-middle">
			<div class="auth-box" style="height: 540px">
				<div class="left">
					<div class="content">
						<div class="header">
							<div class="logo text-center"><img src="assets/img/logo-dark.png" alt="Klorofil Logo"></div>
							<p class="lead">signup to your account</p>
						</div>
			<!-- form page start  -->
						<form class="form-auth-small" action="" method="POST">
							<div class="form-group">
								<label for="name" class="control-label sr-only">Name</label>
								<input type="text" class="form-control" placeholder="Enter your name"  id="name" name="name">
							<span class="text-danger mt-2"><?=$error;?><?=$length;?></span>	
							</div>
							<div class="form-group">
								<label for="signed-email" class="control-label sr-only">Email</label>
								<input type="email" class="form-control" placeholder="Enter yur email"  id="email" name="email">
							<span class="text-danger mt-2"><?=$error;?><?=$email_check;?></span>
							</div>
							<div class="form-group">
								<label for="password" class="control-label sr-only">password</label>
								<input type="password" class="form-control" placeholder="password" id="password" name="password">
							<span class="text-danger mt-2"><?=$error;?></span>
							</div>
							<div class="form-group">
								<label for="comf-password" class="control-label sr-only">comfirm-password</label>
								<input type="password" class="form-control" placeholder="comfirm-password"  id="comf-password" name="com_password">
							<span class="text-danger mt-2"><?=$error;?><?=$pwd;?></span>
							</div>
							<div class="form-group">
								<label for="mobile" class="control-label sr-only">Mobile</label>
								<input type="mobile" class="form-control" placeholder="Mobile Number" id="mobile" name="mobile">
							<span class="text-danger mt-2"><?=$error;?></span>
							</div>
							<div class="form-group">
								<label for="uniersity" class="control-label sr-only">uniersity</label>
								<input type="text" class="form-control" placeholder="Enter your uniersity Name"  id="uniersity" name="university">
							<span class="text-danger mt-2"><?=$error;?></span>
							</div>
							<div class="form-group clearfix">
								 
							</div>
							<button type="submit" class="btn btn-primary btn-lg btn-block" name="singup" >signup</button>
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
