<?php 
	session_start();
	$pageTitle = 'Edit Category';
	if(isset($_SESSION['admin-name']))
	{
		include '../../init.php';
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			if ($_SERVER['REQUEST_METHOD'] =='POST')
			{
			   $id	 	= $_POST ['cateid'];
			   $name  	= $_POST ['name'] ;
			   $des   	= $_POST ['des'] ;
			   $order 	= $_POST ['order'] ;
			   $visible = $_POST ['visibil'] ;
			   $comment = $_POST ['comment'];
			   $ads 	= $_POST ['ads'];
			   	if(empty($name)){ $formError[] = 'Name Can\'t Be <strong>Empty</strong>';}
				if(empty($des)){ $formError[] = 'Description Can\'t Be <strong>Empty</strong>';}
				if(empty($order)){ $formError[] = 'Order Can\'t Be <strong>Empty</strong>';}
	 	    	if(empty($formError)){ 
					$check = checkItem("Name", "categories", $name);
		 			if ($check == 1 ){
		 				$theMsg = '<div class="alert alert-danger">Sorry Is Caregory Is Exist</div>' ;
		 				redirectHome($theMsg, 'back');
		 			}	
			 		$stmt= $con->prepare("UPDATE categories SET Name=?, Description = ?, Ordering =? , Visiblty = ?, Allow_Comment = ?, Allow_Ads = ? WHERE Cat_ID = ?"); 			 									   
			 		$stmt->execute(array($name, $des, $order, $visible, $comment, $ads, $id ));	
				}
			}
		}


			$cateid = isset($_GET['cateid']) && is_numeric($_GET['cateid']) ? intval($_GET['cateid']): 0 ;
			$stmt = $con->prepare("SELECT * FROM categories WHERE Cat_ID = ?" );
			$stmt->execute(array($cateid));
			$cat = $stmt->fetch();
			$count = $stmt->rowCount();

			if ($count > 0 	){ ?>
				<br><br><br>
				<h1 class="text-center">Edit Category</h1>
				<br><br>
				<div class="container">
					<div id='val' class='col-md-offset-3 col-md-6 col-xs-10'></div>
					<form class="form-horizontal" action='?do=Update' method="POST">
						<div class='col-xs-12'>
							<input id='cat-id' type="hidden" name="cateid" value="<?php echo $cateid ?>">
							<div class="form-group">										
								<label class="control-label col-xs-2 col-sm-offset-1" >Name</label>
								<div class="col-sm-6 col-xs-10">
									<input id='cat-name' type="text" name="name" class="form-control" value="<?php echo $cat['Name'];?>" required="required" />
								</div>	
							</div>
							<div class="form-group">
								<label class="control-label col-xs-2 col-sm-offset-1" >Description</label>
								<div class="col-sm-6 col-xs-10">
									<input id='cat-des' type="text" name="description" class="form-control" value="<?php echo $cat['Description']?>"/>
								</div>	
							</div>
							<div class="form-group">
								<label class="control-label col-xs-2 col-sm-offset-1" >Ordering</label>
								<div class="col-sm-6 col-xs-10">
									<input id='cat-order' type="text" name="ordering" class="form-control"  value="<?php echo $cat['Ordering']?>"/>
								</div>	
							</div>
							<div class="form-group">
								<label class="control-label col-xs-2 col-sm-offset-1">Visible</label>
								<div class="col-sm-6 col-xs-10">
								<div>
									<input id='vis-yes' type='radio' name='visibilty' value='0' <?php if($cat['visiblty'] == 0){echo 'checked';}?>>
									<label for='vis-yes'>Yes</label>
								</div>
								<div>
									<input id='vis-no' type='radio' name='visibilty' value='1' <?php if($cat['visiblty']==1){echo 'checked';}?>>
									<label for='vis-no'>No</label>
								</div>	
								</div>	
							</div>
							<div class="form-group">
								<label class="control-label col-xs-2 col-sm-offset-1" >Allow Commenting</label>
								<div class="col-sm-6 col-xs-10">
								<div>
									<input id='com-yes' type='radio' name='commenting' value='0' <?php if($cat['Allow_Comment']==0){echo 'checked';}?>>
									<label for='com-yes'>Yes</label>
								</div>
								<div>
									<input id='com-no' type='radio' name='commenting' value='1' <?php if($cat['Allow_Comment']==1){echo 'checked';}?> >
									<label for='com-no'>No</label>
								</div>	
								</div>	
							</div>
							<div class="form-group">
								<label class="control-label col-xs-2 col-sm-offset-1" >Allow Ads</label>
								<div class="col-sm-6 col-xs-10">
								<div>
									<input id='ads-yes' type='radio' name='Ads' value='0' <?php if($cat['Allow_Ads']== 0){echo 'checked';}?> />
									<label for='ads-yes'>Yes</label>
								</div>
								<div>
									<input id='ads-no' type='radio' name='Ads' value='1' <?php if($cat['Allow_Ads']== 1){echo 'checked';}?> />
									<label for='ads-no'>No</label>
								</div>	
								</div>	
							</div>	
							<div class="form-group">
								<div class="col-sm-6 col-xs-10 col-sm-offset-3 col-xs-offset-2">
									<input id='edit-save' type="submit" value="Save Edit" class="btn btn-success btn-lg btn-block">
								</div>	
							</div>
						</div>							
					</form>
	        	</div> 
					    
<?php              }else{
						$theMsg ='<div class="alert alert-danger">Sorry You Cnat Brows This Page redirectly</div>';
						redirectHome($theMsg,'back');
					}
			include $tpl .'footer.inc'; ?> 	

			<script>
				$('#edit-save').on('click', function(e){
				e.preventDefault();
				var val 	= $('#val'),
					id 		= $('#cat-id').val(),
					name 	= $('#cat-name').val(),
					des 	= $('#cat-des').val(),
					order 	= $('#cat-order').val(),
					visibil = $(":checked")[0].value,
					comment = $(":checked")[1].value,
					ads 	= $(":checked")[2].value;
					$.post('edit.php', {cateid:id, name:name, des:des,order:order,visibil:visibil, comment:comment, ads:ads}, function(){
						val.html("<div class='alert alert-success'>Update Save</div>");	
						if(order  == 0){val.html("<div class='alert alert-danger'>Name Can't Be <strong>Empty</strong></div>")}
						if(des == 0){val.html("<div class='alert alert-danger'>Description Can't Be <strong>Empty</strong></div>")}
						if(name  == 0){val.html("<div class='alert alert-danger'>Name  Can't Be <strong>Empty</strong></div>")}
						if(val.text() == "Update Save"){
							val.toggle(3000).hide(3000);
						}
					});
			});
			</script>	 

<?php } else{
		header('location:../');
		exit();
	}
