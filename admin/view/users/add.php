<?php 
	session_start(); 	
	$pageTitle = 'Add User';	
	if(isset($_SESSION['admin-name']))
	{
		
	if ($_SERVER['REQUEST_METHOD'] =='POST') {
		$noheader='';
		$noNavbar='';
		include "../../init.php";
	    $user  = $_POST ['username'] ;
	    $pass  = $_POST ['password'] ;
	    $email = $_POST ['email'] ;
	    $name  = $_POST ['full'] ;
	    $hashpass= sha1($_POST['password']);
	    $image	= $_FILES['image'];
	    $valid = array('success' => false, 'messages' => array());
		$formErrors = array() ;
 		
 		if (empty($name)) 	    {$formErrors[]  = "Full Name Can't Be <strong>Empty</strong>";}
 		if (empty($email))	    {$formErrors[]  = "Email can't Be <strong>Empty</strong>";}
 		if (empty($pass)) 	    {$formErrors[]  = "Password Can't Be <strong> Empty </strong>";}
 		if (strlen($user) > 20) {$formErrors[]  = "UserName Can't Be More Than <strong>20 Character </strong>";}
 		if (strlen($user) < 4 ) {$formErrors[]  = "UserName Can't Be Less Than <strong>4 Character</strong>";}
 		if (empty($user)) 	    {$formErrors[]  = "UserName Can't Be <strong> Empty </strong>";}
 		

 		if(empty($formErrors)){
			if(!empty($image['name'])){
		 		$type = explode('.', $image['name']);
				$type = $type[count($type) - 1];
				$imageName =  uniqid(rand()). '.'. $type;
				$url =  pathFolder() . '/admin/layout/upload/' . $imageName;
				if(in_array($type, array('gif', 'jpg','jpeg', 'png'))){
					if(is_uploaded_file($image['tmp_name'])){
						if(move_uploaded_file($image['tmp_name'], $url)){
							$url = pathUrl() . '/admin/layout/upload/'. $imageName;
						}
					}
			}
			
		}else{$url =  pathUrl() . '/admin/layout/upload/default-avatar.jpg';}  
 			$check = checkItem("UserName", "user", $user);
 			if ($check == 1 ){
 				$valid['success'] = false; $valid['messages'] = 'Sorry Is User Is Exist';
 			}else{
	 			$stmt= $con->prepare("INSERT INTO 
	 										user(Username , Password , Email , FullName, image, Restatus,  created_at) 
	 									    VALUES(:user, :pass, :mail, :name,  :img, 1, now())");
	 			$stmt->execute(array(
	 				'user' => $user,
	 				'pass' => $hashpass,
	 				'mail' => $email,
	 				'name' => $name ,
	 				'img'  => $url   ));
	 			if($stmt->rowcount() >= 1){$valid['success'] = true; $valid['messages'] = 'Successfully Inserted';
	 				}else{$valid['success'] = false; $valid['messages'] = 'Error While Inserting';}		
 			}

 		}else{foreach($formErrors AS $error){$valid['success'] = false; $valid['messages'] = $error;}}
 		echo json_encode($valid);
	}else{		
		
		include "../../init.php";?>
		<!--Front end Code -->
		<br/><br/><br/>
	   <h1 class="text-center">Add New Member</h1>
	   <br/><br/>
	   <div class="container">
	   		<div id='val' class='col-md-offset-3 col-md-6 col-xs-10'></div>
			<form class="form-horizontal" action='<?php echo $_SERVER['PHP_SELF'];?>' method="POST" enctype='multipart/form-data'>
				<div class='col-xs-12'>
					<div class="form-group">										
						<label class="control-label col-xs-2 col-sm-offset-1" >Image</label>
						<div class="col-sm-6 col-xs-10">
							<input type='file' name='image'>
						</div>	
					</div>
					<div class="form-group">										
						<label class="control-label col-xs-2 col-sm-offset-1" >UserName</label>
						<div class="col-sm-6 col-xs-10">
							<input id='user_name' type="text" name="username" class="form-control"  required="required" placeholder="User Name To Long Into Shop" autocomplete="off"/>
						</div>	
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-offset-1" >Password</label>
						<div class="col-sm-6 col-xs-10">
							<input id='user_pass' type="password" name="password" class="form-control"  required="required" placeholder="Password Must Be Hard & Complex" autocomplete="off"/>
						</div>	
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-offset-1" >Email</label>
						<div class="col-sm-6 col-xs-10">
							<input id='user_email' type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid"/>
						</div>	
							</div>
					<div class="form-group">
						<label class="control-label col-xs-2 col-sm-offset-1" >Full Name</label>
						<div class="col-sm-6 col-xs-10">
							<input id='name_full' type="text" name="full" class="form-control" placeholder="Full Name Appear IN Your Profile Page"/>
						</div>	
					</div>
					<br>
					<div class="form-group">
						<div class="col-sm-6 col-xs-10 col-sm-offset-3 col-xs-offset-2">
							<input id='add_user' type="submit" value="Add New Member" class="btn btn-danger btn-lg btn-block">
						</div>	
					</div>
				</div>	
			</form>
   		</div> 
    <!--End Front end Code -->
<?php	
	include $tpl . "footer.inc"; ?>
	<script>
	 	 $('#add_user').on('click', function(){
	 	 	var form = $(this).parents('form'),
	 		formData =  new FormData(form[0]),
	 		val 	= $('#val');
	 	$.ajax({
	 		url: form.attr('action'),
	 		type: form.attr('method'),
	 		data: formData,
	 		dataType: 'json',
	 		cache: false,
	 		contentType: false,
	 		processData: false,
	 		success: function(data){
	 			if(data.success == true){
	 			val.html('<div class="alert alert-success">' + data.messages +'</div>');
				val.toggle(2000).hide(3000);
				$('form')[0].reset();
		 		}else{
		 			val.html('<div class="alert alert-warning" >' +data.messages + '</div>');
		 		};
	 		}

	 	});
	 		return false;
	 	});
			 
	</script>
<?php }
}else{
	header('location:/');
	exit();
}	