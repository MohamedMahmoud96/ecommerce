<?php
	session_start();
	$pageTitle= "login";
	
	if(isset($_SESSION['user'])){header('location:index.php');}
	include 'init.php'; 

	if($_SERVER['REQUEST_METHOD']=='POST'){
		//Start Login 
		if(isset($_POST['login'])){
			$user = $_POST['name'];
			$pass = $_POST['password'];
			$hashpass = sha1($pass);

			$stmt= $con->prepare("SELECT UserID, UserName, Password FROM user WHERE UserName = ? AND Password = ?");
			$stmt->execute(array($user , $hashpass));
			$get = $stmt->fetch();
			$row = $stmt->rowCount();
		
			if($row > 0){
				$_SESSION['user'] = $user ;
				$_SESSION['memberID'] = $get['UserID'];
				header("Location:index.php");
				exit();

			}else{ $theMsg = "<div class='alert alert-danger'>Sorry UserName Or Password Not Found'</div>";
				   redirectHome($theMsg, 'back', 1); }
		
 //Start Signup
		}else{

			$new_name = $_POST['name'];
			$pass1 	  = $_POST['password'];
			$pass2    = $_POST['password2'];
			$email    = $_POST['Email'];

			$formError = array();

			if(isset($new_name)){
				$filterUser = filter_var($new_name, FILTER_SANITIZE_STRING);
				if(strlen($filterUser) < 4)	 {$formErrors[] = "UserName Can't Be Less Than <strong>4 Character</strong>";}
				if(strlen($filterUser) > 20) {$formErrors[] = "UserName Can't Be More Than <strong>20 Character </strong>";}	
			}
			if(isset($pass1) && isset($pass2)){
				if(strlen($pass1) < 6) {$formErrors[] = "Password Can't Be Less Than <strong>6 Character</strong>";}
				$hashPass1 = sha1($pass1);
				$hashPass2 = sha1($pass2);
				if($hashPass1 !== $hashPass2) { $formErrors[] = 'Sorry Password Not Match';}
			}
			if(isset($email )){
				$filterEmail = filter_var($email , FILTER_SANITIZE_STRING);
				if(filter_var($filterEmail , FILTER_VALIDATE_EMAIL) != true) { $formErrors[] = 'This Email Is Not Vaild';}
			}

			if(empty($formErrors)){

				$check = checkItem("UserName","user", $new_name);
				if($check == 1) {
					 $formErrors[] = "<div class='alert alert-danger'>Sorry This UserName is Exist</div>";
				}else{ 

					$stmt_new = $con->prepare("INSERT INTO 
														user(Username ,Password, Email, Date)
														values(:zname, :zpass, :zemail, now() ) "); 
					$stmt_new->execute(array(
						'zname'  => $new_name,
						'zpass'  => $hashPass1 ,
						'zemail' => $email, ));
						echo "<div class='container'>" ;
							$theMsg = "<div class='alert alert-success'>" . $stmt_new->rowCount() . " Record Inserted </div>";
							redirectHome($theMsg, 'back');
						echo "</div>";	

				}
			}
		}
	}
?>	
	<div class='container login-page'>
		<h1 class='text-center'>
			 <span class='active' data-class='login'>Login</span> |
			 <span data-class='signup'>Signup</span>
		</h1>
		<form class='login' action= "<?PHP echo $_SERVER['PHP_SELF']?>" method ='POST'>
			<div class='form-group'>
				<input class='form-control' type='text'  name='name' placeholder='Type your name' autocomplete='off' />
				<input  class='form-control' type='password' name='password' placeholder='Type your Password' autocomplete='new-password'>
				<input class='btn btn-primary btn-block' name='login' type='submit' value='Login'>
			</div>
		
		</form> 
		<form class= 'signup' action ="<?PHP echo $_SERVER['PHP_SELF']?>" method='POST'>
			<div class='form-group'>
				<input pattern = '.{4,20}' title='UserName Must Be Between 4 to 20 char'
					class='form-control' type='text'  name='name' placeholder='Type your name' autocomplete='off'
					 required />
				<input  minlength ='6' class='form-control' type='password' name='password' placeholder='Type your Password' autocomplete='new-password' required>
				<input  class='form-control' type='password' name='password2' placeholder='Type your Password' autocomplete='new-password'>
				<input  class='form-control' type='email' name='Email' placeholder='Type a valid Email'>
				<input class='btn btn-success btn-block' name='signup' type='submit' value='SignUp'>
			</div>
		</form>
			
		<div class='text-center'>
<?php 	
	if(!empty($formErrors)){ foreach($formErrors AS $error){ echo "<div class=''>" . $error . "</div>"; "<br/>"; } }	
?>		
		</div>
	</div>

<?php include $tpl . "footer.inc"; ?>