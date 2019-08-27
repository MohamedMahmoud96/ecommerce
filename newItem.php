<?php
	session_start();
	$pageTitle = 'Greate New Item';
	include "init.php";	
	if(isset($_SESSION['user'])){
	
		if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$formErrors = array();

				$name 	  = filter_var($_POST['name'], 	  FILTER_SANITIZE_STRING);
				$desc 	  = filter_var($_POST['des'], 	  FILTER_SANITIZE_STRING);
				$price 	  = filter_var($_POST['price'],   FILTER_SANITIZE_NUMBER_INT);
				$country =  filter_var($_POST['country'], FILTER_SANITIZE_STRING);
				$status   = filter_var($_POST['status'],  FILTER_SANITIZE_NUMBER_INT);
				$cate 	  = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);

				if(strlen($name) < 3)		{$formErrors[] = 'Item Title Must Be Least 4 Characters';}
				if(strlen($desc) < 10)		{$formErrors[] = 'Item Description Must Be Least 10 Characters';}
				if(strlen($country) < 2)	{$formErrors[] = 'Item Country Must Be Least 2 Characters';}
				if(strlen($price) < 1)		{$formErrors[] = 'Item price Must Not Empty';}
				if(strlen($status) < 1)		{$formErrors[] = 'Item Status Must Not Empty';}
				if(strlen($cate) < 1)		{$formErrors[] = 'Item category Must Not Empty';}

			if(empty($formErrors)){	

				$stmt= $con->prepare("INSERT INTO 

											items(Name, Description, Price, Date, Country_Made, Status, Member_ID, Category_ID)
											VALUES(:zname, :zdes, :zprice, Now(), :zcount, :zstat, :zmember, :zcat)");
					$stmt->execute(array(

						'zname'     => $name,
						'zdes'	    => $desc,
						'zprice'    => $price,
						'zcount' 	=> $country,
						'zstat'		=> $status, 
						'zmember' 	=> $_SESSION['memberID'],
						'zcat'	  	=>$cate	
						));
					$theMsg = '<div class="alert alert-success">' . $stmt->rowcount() . 'Record Inserted </div>';

					redirectHome($theMsg , 'back');					
			}else{ echo 'Sorry';}
			
				


		}
?>
		<h1 class='text-center'> <?php echo $pageTitle ?> </h1>
	<section class='greate block'>
		<div class='container'>
			<div class='panel panel-primary'>
				<div class='panel-heading'> <?php echo $pageTitle ?> </div>
				<div class='panel-body'>
					<div class='row'>
						<div class='col-md-8'>
							<form class='form-horizontal' action=' <?php echo $_SERVER["PHP_SELF"]?> ' method='POST'>
								<div class='form-group'>
									<label class='control-label col-md-2'>Name</label>
									<div class='col-md-9'>
										<input type='text' pattern=".{4,20}" title='Name Must Be between 4 To 20 Char' name='name' class='form-control ads-name' required='required' placeholder='Type Name Of The Items'/>
									</div>	
								</div>
								<div class='form-group'>
									<label class='control-label col-md-2'>Description</label>
									<div class='col-md-9'>
										<input pattern=".{10,}" title='Description Must Be More 10 Char' type='text' name='des' class='form-control ads-description' required='required' placeholder='Type Description Of The Items'>
									</div>	
								</div>
								<div class='form-group'>
									<label class='control-label col-md-2'>Price</label>
									<div class='col-md-9'>
										<input type='text' name='price' class='form-control ads-price' required='required' placeholder='Type Price of The Items'>
									</div>	
								</div>
								<div class='form-group'>
									<label class='control-label col-md-2'>Country</label>
									<div class='col-md-9'>
										<input pattern=".{3,}" title='Country Must Be More 3 Char' type='text' name='country' class='form-control' required='required' placeholder='Country Made Of The Items'>
									</div>	
								</div>
								<div class='form-group'>
									<label class='control-label col-md-2'>status</label>
									<div class='col-md-9'>
										<select name='status' required>
											<option value=''>....</option>
											<option value='1'>New</option>
											<option value='2'>Like New</option>
											<option value='3'>Used</option>
											<option value='4'>Old</option>
										</select>
									</div>	
								</div>
								<div class='form-group'>
									<label class='control-label col-md-2'>Categories</label>
									<div class='col-md-9'>
										<select name='category' required>
											<option value=''>....</option>
											<?php
											$stmt = $con->prepare("SELECT * FROM categories");
											$stmt->execute();
											$cats= $stmt->fetchAll();
											foreach($cats as $cat){echo "<option value=" . $cat['Cat_ID'].">" . $cat['Name'] . "</option>" ;}
											?>
										</select>
									</div>	
								</div>
								<div class='form-group'>	
									<div class='col-sm-2 col-sm-offset-2'>
									<input type='submit'  value='Add Items' class='btn btn-primary'>
									</div>	
								</div>
							</form>	
						</div>

						<div class='col-md-4'>
							<div class='thumbnail cpd-form'>
								<div class='price'> <span>$0</span> </div>
									<img src='layout/image/user.png'/>
											<h3>Title</h3>
											<p>Description</p>
							</div>
						</div>
					</div>
				</div>
			</div>
				<?php
					if(!empty($formErrors)){
						echo '<div class=text-center>';
							foreach($formErrors AS $error){

								echo "<div class='alert alert-danger'>". $error . "</div>" ;
							}
						echo '</div>';
					}

				?>
		</div>		
	</section>			


<?php	}else{
			header("Location:login.php");
			exit();}

	 	include $tpl . "footer.inc";
