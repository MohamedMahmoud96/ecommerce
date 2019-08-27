<?php
		session_start();
		$pageTitle = 'Edit Product';
		if(isset($_SESSION['admin-name']))
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				$noheader='';
				$noNavbar='';
			// include importent files 
				include '../../init.php';	
				$id = $_POST['itemid'];
				$name =$_POST['name'];
				$des = $_POST['des'];
				$price = $_POST['price'];
				$country = $_POST['country'];
				$status =$_POST['status'];
				$member = $_POST['user'];
				$category =$_POST['category'];
				$image 	= $_FILES['image'];
				$valid = array('success' => false, 'messages' => array());
				$formError = array();
				// check errors
				if(empty($name)){ $formError[] = 'Name Can\'t Be <strong>Empty</strong>';}
				if(empty($des)){ $formError[] = 'Description Can\'t Be <strong>Empty</strong>';}
				if(empty($price)){ $formError[] = 'Price Can\'t Be <strong>Empty</strong>';}
				if(empty($country)){ $formError[] = 'Country Can\'t Be <strong>Empty</strong>';}
				if($status == 0 ){ $formError[] = 'Status Can\'t Be <strong>Empty</strong>';}
				if($member == 0 ){ $formError[] = 'Member Can\'t Be <strong>Empty</strong>';}
				if($category == 0 ){ $formError[] = 'Category Can\'t Be <strong>Empty</strong>';}
			
				// updata data
				if(empty($formError)){
				
				// handel image url and upload in file
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
					$stmt=$con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, image = ?, Status = ?, Member_ID = ?, Category_ID = ? WHERE T_ID = ?");
					$stmt->execute(array( $name, $des, $price, $country, $url, $status, $member, $category, $id));
					if($stmt->rowcount() >= 1 ){ $valid['success'] = true; $valid['messages'] = 'Successfully Updata';
					}else{ $valid['success'] = false; $valid['messages'] = 'No Data Change to Updata'; }		
				}else{
						// send messages Errors
					foreach($formError AS $error){$valid['success'] = false; $valid['messages'] = $error;}
				}
				echo json_encode($valid);
			}else{

			include '../../init.php';
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
			$stmt= $con->prepare("SELECT * FROM items WHERE T_ID = ?");
			$stmt->execute(array($itemid));
			$item = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0 ){ ?>
				<br/><br/><br/>
				<h1 class='text-center'>Edit items</h1>
				<br/><br/>
				<div class='container'>
					<div id='val' class='col-md-offset-3 col-md-6 col-xs-10'></div>
					<form class='form-horizontal' action="<?php echo $_SERVER['PHP_SELF'];?>" method='POST'>
						<div class='col-xs-12'>
							<input id='pro-id' type='hidden' name='itemid' value="<?php echo $itemid ;?>"/>
							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>Name</label>
								<div class='col-sm-6 col-xs-10'>
									<input id='pro-name' type='text' name='name' class='form-control'  value="<?php echo $item['Name'];?>" required='required' placeholder='Type Name Of The Items'/>
								</div>	
							</div>
							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>Description</label>
								<div class='col-sm-6 col-xs-10'>
									<input id='pro-des' type='text' name='des' class='form-control' required='required' value="<?php echo $item['Description']?>" placeholder='Type Description Of The Items'/>
								</div>	
							</div>
							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>Price</label>
								<div class='col-sm-6 col-xs-10'>
									<input  id='pro-price' type='text' name='price' class='form-control' required='required' value="<?php echo $item['Price']?>" placeholder='Type Price of The Items'/>
								</div>	
							</div>
							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>Country</label>
								<div class='col-sm-6 col-xs-10'>
									<input  id='pro-country' type='text' name='country' class='form-control' required='required' value="<?php echo $item['Country_Made']?>" placeholder='Country Made Of The Items'/>
								</div>	
							</div>
							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>status</label>
								<div class='col-sm-6 col-xs-10'>
									<select  id='pro-status' name='status' value="<?php echo $item['Status']?>">
										<option value='1' <?php if( $item['Status'] == 1) {echo 'selected';}?>> New</option>
										<option value='2' <?php if( $item['Status'] == 2) {echo 'selected';}?>>Like New</option>
										<option value='3' <?php if( $item['Status'] == 3) {echo 'selected';}?>>Used</option>
										<option value='4' <?php if( $item['Status'] == 4) {echo 'selected';}?>>Old</option>
									</select>
								</div>	
							</div>
							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>Members</label>
								<div class='col-sm-6 col-xs-10'>
									<select  id='pro-user' name='user'>
										<?php
											$stmt=$con->prepare("SELECT * FROM user");
											$stmt->execute();
											$users=$stmt->fetchAll();
											foreach($users as $user){
												echo "<option value ='" . $user['UserID'] ."'"; 
												if($item['Member_ID'] == $user['UserID'] ) {echo 'selected';} 
												echo ">" . $user['UserName']." </option>";
											}
										?>
									</select>
								</div>	
							</div>
							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>Categories</label>
								<div class='col-sm-6 col-xs-10'>
									<select id='pro-cat'  name='category'>
									 	<?php
											$stmt = $con->prepare("SELECT * FROM categories");
											$stmt->execute();
											$cats= $stmt->fetchAll();
											foreach($cats as $cat){
												echo "<option value='" . $cat['Cat_ID']."'";
												if($item['Category_ID'] == $cat['Cat_ID']){echo 'selected';}	
												echo ">" . $cat['Name'] . "</option>" ;
											}
										?>
									</select>
								</div>	
							</div>

							<div class='form-group'>
								<label class='control-label col-xs-2 col-sm-offset-1'>Image</label>
								<div class='col-sm-6 col-xs-10'>
									<input type='hidden' name='old-img' value='<?php echo $item['image']?>'>
									<a id='edit-image' href="#">
										<img src="<?php echo $item['image']?>" style='width:200px'>
									</a>
									<input type='file' name='image' style='display:none'>
								</div>	
							</div>
							<br>
							<div class='form-group'>					
								<div class='col-sm-6 col-xs-10 col-sm-offset-3 col-xs-offset-2'>
									<input  id='pro-save' type='submit'  value='Edit Items' class='btn btn-success btn-lg btn-block'/>
								</div>	
							</div>	
						</div>	
					</form>
				</div>	
	  <?php }else{
				$theMsg = "<div class='alert alert-danger'>This ID Not exist</div>";
				redirectHome($theMsg, 'back'); 
			};	
 		
		include $tpl . 'footer.inc';?>	

		<script>
			$('#pro-save').on('click',function(e){
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

<?php }}else{
	header('location:/');
	exit();
} ?>