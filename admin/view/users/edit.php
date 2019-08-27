<?php 
	session_start(); 	
	$pageTitle = 'Edit User';	
	if(isset($_SESSION['admin-name']))
	{
		//isset Request Post 
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$noheader='';
			$noNavbar='';
			include "../../init.php";
			$id  = $_POST ['userid'];
			$user = $_POST['username'];
			$email =$_POST['email'];
			$name =$_POST['full'];
			$image = $_FILES['image'];
			$pass = empty($_POST['newpassword']) ? $pass = $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);
			$valid = array('success' => false, 'messages' => array());
			$formErrors = array() ;
	 		if(strlen($user) < 4 ) {$formErrors[] = "UserName Can't Be Less Than <strong>4 Character</strong>";}
	 		if(strlen($user) > 20) {$formErrors[] = "UserName Can't Be More Than <strong>20 Character </strong>";}
	 		if (empty($user)) 	   {$formErrors[] = "UserName Can't Be <strong> Empty </strong>";}
	 		if (empty($email))	   {$formErrors [] = "Email can't Be <strong>Empty</strong>";}
	 		if (empty($name)) 	   {$formErrors[] = "Full Name Can't Be <strong>Empty</strong>";}
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
				}else{$url = $_POST['old-img'];} 
				$stmt = $con->prepare("UPDATE user SET UserName = ?, Password = ?, Email = ?,
										FullName = ?, image = ? WHERE UserID = ?");
				$stmt->execute(array($user, $pass, $email, $name, $url, $id ));
				if($stmt->rowcount() >= 1){$valid['success'] = true; $valid['messages'] = 'Successfully Inserted';
					}else{$valid['success'] = false; $valid['messages'] = 'No Data Change to Updata';}
				// send messages Errors
			}else{foreach($formErrors AS $error){$valid['success'] = false; $valid['messages'] = $error;}}

				echo json_encode($valid);
		}else{
		include "../../init.php";
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0 ;
		$stmt = $con->prepare("SELECT * FROM user WHERE UserID = ? LIMIT 1 " );
		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if ($stmt->rowCount() > 0 ){ ?>
		<br/><br/><br/>
			<h1 class="text-center">Edit Member</h1>
			<br/><br/>
			<div class="container">
				<div id='val' class='col-md-offset-3 col-md-6 col-xs-10'></div>
				<form class='form-horizontal' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='POST' enctype="multipart/form-data">
					<div class='col-xs-12'>
						<input id='user_id' type="hidden" name="userid" value="<?php echo $userid ?>">
							<div class="form-group">
							<label class="control-label col-xs-2 col-sm-offset-1" >Image</label>
							<div class="col-sm-6 col-xs-10">
								<input type='hidden' name='old-img' value='<?php echo $row['image']?>'>
								<a id='edit-image' href="#">
									<img src="<?php echo $row['image']?>" style='width:200px'>
								</a>
								<input type='file' name='image' style='display:none'>
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 col-sm-offset-1" >UserName</label>
							<div class="col-sm-6 col-xs-10">
								<input id='user_name' type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['UserName'] ?>" required="required">
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 col-sm-offset-1" >Password</label>
							<div class="col-sm-6 col-xs-10">
								<input id='old_pass' type="hidden" name="oldpassword" value="<?php echo $row['Password']?>">
								<input id='new_pass' type="password" name="newpassword" class="form-control" autocomplete="new-password" >
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 col-sm-offset-1" >Email</label>
							<div class="col-sm-6 col-xs-10">
								<input id='user_email' type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required">
							</div>	
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2 col-sm-offset-1" >Full Name</label>
							<div class="col-sm-6 col-xs-10">
								<input id='full_name' type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>">
							</div>	
						</div>
							<div class="form-group">
								<div class="col-sm-6 col-xs-10 col-sm-offset-3 col-xs-offset-2">
								<input id='user_edit' type="submit" value="save" class="btn btn-danger btn-lg btn-block">
							</div>	
						</div>
					</div>	
				</form>	
				
	        </div> 
<?php   }else {

			$theMsg ='<div class="alert alert-danger">This ID Not exist</div>';			
			redirectHome($theMsg,'back');

		} 


//Section Update 
   		
	 		// $formErrors = array() ;
	 		// if(strlen($user) < 4 ) {$formErrors[] = "UserName Can't Be Less Than <strong>4 Character</strong>";}
	 		// if(strlen($user) > 20) {$formErrors[] = "UserName Can't Be More Than <strong>20 Character </strong>";}
	 		// if (empty($user)) 	   {$formErrors[] = "UserName Can't Be <strong> Empty </strong>";}
	 		// if (empty($email))	   {$formErrors [] = "Email can't Be <strong>Empty</strong>";}
	 		// if (empty($name)) 	   {$formErrors[] = "Full Name Can't Be <strong>Empty</strong>";}
	 		// foreach ($formErrors as $error) {echo "<div class='alert alert-danger'>" . $error ."</div>";};


	include $tpl . "footer.inc"; ?>

	<script>
		$('#user_edit').on('click',function(e){
				var form = $(this).parents('form'),
	 				formData =  new FormData(form[0]),
	 				val = $('#val');
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
						val.toggle(3000).hide(3000);
						
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
		 	