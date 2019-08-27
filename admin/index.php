<?php
	session_start();
	$noNavbar = '';
	$pageTitle= "login";
	include "init.php";
	if (isset($_SESSION['admin-name'])){ header("location:".view('dashboard.php'));};
	
	/*
	require 'classess.php';
	if ($_SERVER['REQUEST_METHOD']== 'POST') {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$check = new Allinfo($user, $pass);
		print_r ($check);
	}
	*/
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$username = $_POST ['user'];
		$password = $_POST ['pass'];
		$hashedpass = sha1($password);
	
		$stmt = $con->prepare("SELECT UserName, Password , UserID FROM user WHERE UserName = ? AND Password = ? AND GroupID = 1  LIMIT 1 " );
		$stmt->execute(array($username, $hashedpass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if ($count > 0) {
			$_SESSION['admin-name'] = $username;
			$_SESSION['ID']= $row['UserID'];
			header("location:".view('dashboard.php'));
			exit(); }}
?>	
	<div class="login_wrapper login">
        <div class="animate form login_form">
          <section class="login_content">
				<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method='POST'>
					<h3 class="text-center">Admin Control</h3>
					<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off"/>
					<input  class="form-control" type ="password" name="pass" value"password" placeholder="Password" autocomplete="new-password"/>
					<button class='btn btn-info btn-block'>login</botton>
				</form> 
			</section>
		</div>
	</div>

