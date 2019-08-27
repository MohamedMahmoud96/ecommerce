<?php 
	session_start();
	$pageTitle = 'Add Category';
	if(isset($_SESSION['admin-name']))		 
	{
		include '../../init.php';
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
		    $name  	= $_POST ['name'] ;
		    $des   	= $_POST ['des'] ;
		    $order 	= $_POST ['order'] ;
		    $visible = $_POST ['visibil'] ;
		    $comment = $_POST['comment'];
		    $ads 	= $_POST ['ads'];
	    	if(empty($name)){ $formError[] = 'Name Can\'t Be <strong>Empty</strong>';}
			if(empty($des)){ $formError[] = 'Description Can\'t Be <strong>Empty</strong>';}
			if(empty($order)){ $formError[] = 'Order Can\'t Be <strong>Empty</strong>';}
	 	    if(empty($formError)){ 
				$check = checkItem("Name", "categories", $name);
	 			if ($check == 1 ){
	 				$theMsg = '<div class="alert alert-danger">Sorry Is Caregory Is Exist</div>' ;
	 				redirectHome($theMsg, 'back');
	 			}else{
	 				$stmt= $con->prepare("INSERT INTO 
	 										categories(Name , Description , Ordering , Visiblty, Allow_Comment, Allow_Ads) 
	 									    VALUES(:name, :des, :order, :visiblte, :comment, :ads)");
	 				$stmt->execute(array(
		 				'name'	   => $name,
		 				'des'      => $des,
		 				'order'    => $order,
		 				'visiblte' => $visible,
		 				'comment'  => $comment,
		 				'ads' 	   => $ads			 				
	 				));	
	 			}	
			}
		}
		
?>
			<!--Front End code --> 
			<br><br><br>
			<h1 class="text-center">Add New Category</h1>
			<br><br>
		  		   <div class="container">
		  		   	<div id='val' class='col-md-offset-3 col-md-6 col-xs-10'></div>
						<form class="form-horizontal" action='?do=Insert' method="POST">
							<div class='col-xs-12'>
								<div class="form-group">										
									<label class="control-label col-xs-2 col-sm-offset-1" >Name</label>
									<div class=" col-md-6 col-sm-10">
										<input id='cat-name' type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name of Category"/>
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2 col-sm-offset-1" >Description</label>
									<div class="col-sm-6 col-xs-10">
										<input id='cat-des' type="text" name="description" class="form-control"  placeholder="Type your discription"/>
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2 col-sm-offset-1" >Ordering</label>
									<div class="col-sm-6 col-xs-10">
										<input id='cat-order' type="text" name="ordering" class="form-control"  placeholder="Nuber to ordering"/>
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2 col-sm-offset-1" >Visible</label>
									<div class="col-sm-6 col-xs-10">
									<div>
										<input id='vis-yes' type='radio' name='visibilty' value='0' checked>
										<label for='vis-yes'>Yes</label>
									</div>
									<div>
										<input id='vis-no' type='radio' name='visibilty' value='1' >
										<label for='vis-no'>No</label>
									</div>	
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2 col-sm-offset-1" >Allow Commenting</label>
									<div class="col-sm-6 col-xs-10">
									<div>
										<input id='com-yes' type='radio' name='commenting' value='0' checked> 
										<label for='com-yes'>Yes</label>
									</div>
									<div>
										<input id='com-no' type='radio' name='commenting' value='1' >
										<label for='com-no'>No</label>
									</div>	
									</div>	
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2 col-sm-offset-1" >Allow Ads</label>
									<div class="col-sm-6 col-xs-10">
									<div>
										<input id='ads-yes' type='radio' name='Ads' value='0' checked>
										<label for='ads-yes'>Yes</label>
									</div>
									<div>
										<input id='ads-no' type='radio' name='Ads' value='1' >
										<label for='ads-no'>No</label>
									</div>	
									</div>	
								</div>	
								<div class="form-group">
									<div class="col-sm-6 col-xs-10 col-sm-offset-3 col-xs-offset-2">
										<input id='cat-save' type="submit" value="Add Category" class="btn btn-danger btn-lg btn-block">
									</div>	
								</div>
							</div>							
						</form>
			        </div> 
			       <!--End Front End code --> 
		<?php include $tpl . 'footer.inc';?>
		<script>
			/* Add Checked on radio click */
			$('input[name=visibilty]').click(function(){
				$(this).attr('checked', 'checked');
			});
			$('input[name=commenting]').click(function(){
				$(this).attr('checked', 'checked');
			});
			$('input[name=Ads]').click(function(){
				$(this).attr('checked', 'checked');
			});
			/* End Add Checked on radio click */

			$('#cat-save').on('click', function(e){
				e.preventDefault();
				var val 	= $('#val'),
					name 	= $('#cat-name').val(),
					des 	= $('#cat-des').val(),
					order 	= $('#cat-order').val(),
					visibil = $(":checked")[0].value,
					comment = $(":checked")[1].value,
					ads 	= $(":checked")[2].value;
					$.post('add.php', {name:name, des:des,order:order,visibil:visibil, comment:comment, ads:ads}, function(){
						val.html("<div class='alert alert-success'>Category Save</div>");	
						if(order  == 0){val.html("<div class='alert alert-danger'>Name Can't Be <strong>Empty</strong></div>")}
						if(des == 0){val.html("<div class='alert alert-danger'>Description Can't Be <strong>Empty</strong></div>")}
						if(name  == 0){val.html("<div class='alert alert-danger'>Name  Can't Be <strong>Empty</strong></div>")}
						if(val.text() == "Category Save"){
							val.toggle(3000).hide(3000);
							$('form')[0].reset();
						}
					});
			});

		</script>

<?php } else{
	header('location:' . $_SERVER['HTTP_REFERER']);
	exit();
}