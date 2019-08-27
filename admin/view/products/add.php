<?php 
		session_start();
		$pageTitle = 'Add Product';
		if(isset($_SESSION['admin-name'])){
			// when get request 
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$noheader='';
			$noNavbar='';
			// include importent files 
			include '../../init.php';	
			// get all data
			$name 	  = $_POST['name'];
			$des  	  = $_POST['des'];
			$price    = $_POST['price'];
			$country  = $_POST['country'];
			$image   = $_FILES['image'];
			$stat 	  = $_POST['status'];
			$category = $_POST['category'];
			$member   = $_POST['user'];
			
			// 
			$valid = array('success' => false, 'messages' => array());
			// check date not empty
			$formError = array();
			if($category == 0 ){$formError[] = 'Category Can\'t Be <strong>Empty</strong>';}
			if($member == 0 ){$formError[] = 'Member Can\'t Be <strong>Empty</strong>';}
			if($stat == 0 ){ $formError[] = 'Status Can\'t Be <strong>Empty</strong>';}
			if(empty($image)){$formError[] = 'Image Can\'t Be <strong>Empty</strong>';}
			if(empty($country)){ $formError[] = 'Country Can\'t Be <strong>Empty</strong>';}
			if(empty($price)){ $formError[]= 'Price Can\'t Be <strong>Empty</strong>';}
			if(empty($des)){ $formError[] = 'Description Can\'t Be <strong>Empty</strong>';}
			if(empty($name)){ $formError[] = 'Name Can\'t Be <strong>Empty</strong>';}
			
			if(empty($formError)){
				// handel image url and upload in file
		 		$type = explode('.', $image['name']);
				$type = $type[count($type) - 1];
				$imageName =  uniqid(rand()). '.'. $type;
				$url =  pathFolder() . '/admin/layout/upload/' . $imageName;
				if(in_array($type, array('gif', 'jpg','jpeg', 'png'))){
					if(is_uploaded_file($image['tmp_name'])){
						if(move_uploaded_file($image['tmp_name'], $url)){
							$url = pathUrl() . '/admin/layout/upload/'. $imageName;
						// insert data in database
							$stmt= $con->prepare("INSERT INTO 
										items(Name, Description, Price, Date , Country_Made, image, Status, Category_ID, Member_ID, Approve)
										VALUES(:zname, :zdes, :zprice, Now(), :zcount, :zimage, :zstat, :zcat, :zmember, 1 )");
							$stmt->execute(array(
								'zname'   => $name,
								'zdes'	  => $des,
								'zprice'  => $price,
								'zcount'  => $country,
								'zimage'  => $url,
								'zstat'	  => $stat, 
								'zcat'	  => $category,	
								'zmember' => $member
								));
							if($stmt->rowcount() >= 1 ){$valid['success'] = true; $valid['messages'] = 'Successfully Inserted';
								}else{$valid['success'] = false; $valid['messages'] = 'Error While Inserting';}
						}else{$valid['success'] = false; $valid['messages'] = 'Error While Inserting';}
					}
		 		}
			}else{foreach($formError AS $error){$valid['success'] = false; $valid['messages'] = $error;}}
			echo json_encode($valid);

			// not found request		
		}else{
			include '../../init.php';				
?>
		<br/><br/><br/>
		<h1 class='text-center'>Add New items </h1>
		<br/><br/>
		<div class='container'>
			<div id='val' class='col-md-offset-3 col-md-6 col-xs-10'></div>
			<form id='pro-form' class='form-horizontal' action="<?php echo $_SERVER['PHP_SELF']?>" method='POST' enctype='multipart/form-data'>	
				<div class='col-xs-12'>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>Name</label>
					<div class='col-sm-6 col-xs-10'>
						<input id='pro-name' type='text' name='name' class='form-control' required='required' placeholder='Type Name Of The Items'/>
					</div>	
				</div>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>Description</label>
					<div class='col-sm-6 col-xs-10'>
						<input id='pro-des' type='text' name='des' class='form-control' required='required' placeholder='Type Description Of The Items'>
					</div>	
				</div>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>Price</label>
					<div class='col-sm-6 col-xs-10'>
						<input id='pro-price' type='text' name='price' class='form-control' required='required' placeholder='Type Price of The Items'>
					</div>	
				</div>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>Country</label>
					<div class='col-sm-6 col-xs-10'>
						<input id='pro-country' type='text' name='country' class='form-control' required='required' placeholder='Country Made Of The Items'>
					</div>	
				</div>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>status</label>
					<div class='col-sm-6 col-xs-10'>
						<select id='pro-status' name='status'>
							<option value='0'>....</option>
							<option value='1'>New</option>
							<option value='2'>Like New</option>
							<option value='3'>Used</option>
							<option value='4'>Old</option>
						</select>
				</div>	
				</div>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>Members</label>
					<div class='col-sm-6 col-xs-10'>
						<select id='pro-user'  name='user'>
							<option value='0'>....</option>
							<?php
								$stmt=$con->prepare("SELECT * FROM user");
								$stmt->execute();
								$users=$stmt->fetchAll();
								foreach($users as $user){echo "<option value=" . $user['UserID'] ."> " . $user['UserName'] ." </option>";}
							?>
						</select>
					</div>	
				</div>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>Categories</label>
					<div class='col-sm-6 col-xs-10'>
						<select id='pro-cat' name='category'>
							<option value='0'>....</option>
						<?php
							$stmt = $con->prepare("SELECT * FROM categories");
							$stmt->execute();
							$cats= $stmt->fetchAll();
							foreach($cats as $cat){echo "<option value=" . $cat['Cat_ID'] .">" . $cat['Name'] . "</option>" ;}
						?>
						</select>
					</div>	
				</div>
				<div class='form-group'>
					<label class='control-label col-xs-2 col-sm-offset-1'>Image</label>
					<div class='col-sm-6 col-xs-10'>
						<input type='file' name='image' required='required' style='margin-bottom:10px'>
					</div>
						
				</div>
				

				<br/><br/>
				<div class='form-group'>
					<div class='col-sm-6 col-xs-10 col-sm-offset-3 col-xs-offset-2'>
						<input id='pro-save' type='submit'  value='Add Product' class='btn btn-success btn-lg btn-block'>
					</div>	
				</div>
			</div>	
			</form>
		</div>

<?php 	include $tpl . "footer.inc"; 
	
?>
	<script>
	
	 	 $('#pro-save').on('click', function(){
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
				val.toggle(3000).hide(3000);
				$('form')[0].reset();
		 		}else{
		 			val.html('<div class="alert alert-warning" >' +data.messages + '</div>');
		 		};
	 		}

	 	});
	 		return false;
	 	});
			 	
			
		

	
		// $('#pro-save').on('click', function(e){
		// 	e.preventDefault();

		// 	var val 	= $('#val'),
		// 		name 	= $('#pro-name').val(),
		// 		des 	= $('#pro-des').val(),
		// 		price 	= $('#pro-price').val(),
		// 		country = $('#pro-country').val(),
		// 		image 	= $('#pro-image').val(),
		// 		status 	= $('#pro-status').val(),
		// 		user 	= $('#pro-user').val(),
		// 		cat 	= $('#pro-cat').val();
		// 		$.post('add.php', {name:name,des:des,price:price,country:country,image:image, status:status,user:user,cat:cat},function(data){
		// 			val.html(data);
		// 			//val.html("<div class='alert alert-success'>Product save</div>");
		// 			// if(cat  == 0){val.html("<div class='alert alert-danger'>Category Can't Be <strong>Empty</strong></div>")}
		// 			// if(user == 0){val.html("<div class='alert alert-danger'>User Can't Be <strong>Empty</strong></div>")}
		// 			// if(status == 0){val.html("<div class='alert alert-danger'>Status Can't Be <strong>Empty</strong></div>")}
		// 			// if(country.length == 0){val.html("<div class='alert alert-danger'>Country Can't Be <strong>Empty</strong></div>")}
		// 			// if(price .length == 0){val.html("<div class='alert alert-danger'>Price Can't Be <strong>Empty</strong></div>")}
		// 			// if(des .length == 0){val.html("<div class='alert alert-danger'>Description Can't Be <strong>Empty</strong></div>")}	
		// 			// if(name.length == 0 ){val.html("<div class='alert alert-danger'>Name Can't Be <strong>Empty</strong></div>")}
		// 			// if(val.text() == "Product save"){
		// 			// 	val.toggle(3000).hide(3000);
		// 			// 	$('form')[0].reset();
		// 			// }	
					
		// 		});
		// });
	</script>

<?php }}else{
	header('location:/');
	exit();
}	