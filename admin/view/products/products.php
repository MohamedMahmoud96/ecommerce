<?php 
	session_start() ;
	$pageTitle = 'All Products';

	if(isset($_SESSION['admin-name']))
	{	include '../../init.php';

		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$status = $_POST['status'];
			$itemid = $_POST['pro_id'];
			if($status == 'remove'){
				$check = checkItem('T_ID', 'items', $itemid);
			if($check > 0){
				$stmt =$con->prepare("DELETE FROM items WHERE T_ID = :zid ");
				$stmt->bindParam(":zid", $itemid);
				$stmt->execute();
			}
			}else{
				$check = checkItem('T_ID', 'items', $itemid);
				if($check > 0){
					$stmt= $con->prepare("UPDATE items SET Approve = 1 WHERE T_ID = ? ");
					$stmt->execute(array($itemid));
				}
			}
		}

		$query = '';
		if(isset($_GET['page']) && $_GET['page']== 'pending'){$query = 'WHERE Approve = 0';}
		$stmt=$con->prepare("SELECT items .*, 
								categories.Name AS Category_Name, 
								user.UserName AS Member_Name  
								FROM items 
								INNER JOIN categories ON categories.Cat_ID = items.category_ID 
								INNER JOIN user ON user.UserID = items.Member_ID $query ");
		$stmt->execute();
		$items = $stmt->fetchAll();
		?>		
			<h1 class="text-center"></h1>
				<div class="container">';
				<div class='row'>
					<div class="col-md-12 col-sm-12 col-xs-12">
		                <div class="x_panel">
		                  <div class="x_title">
			                    <h2><?php if($query !== ''){echo 'Pending Member';}else{echo 'Mange Page';}?></h2>
			                    <ul class="nav navbar-right panel_toolbox">
			                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			                      </li>
			                      <li><a class="close-link"><i class="fa fa-close"></i></a>
			                      </li>
			                    </ul>
		                    <div class="clearfix"></div>
		                  </div>
		                  <div class="x_content">
		                   	 	<table id="datatable-fixed-header" class="table table-striped table-bordered bulk_action nowrap">
			                      <thead>
			                        <tr>
								        <th>ID</th>
										<th>Name</th>
										<th>Description</th>
										<th>Price</th>
										<th>Created at</th>
										<th>Country</th>
										<th>image</th>
										<th>Status</th>
										<th>Category</th>
										<th>Member</th>
										<th>Control</th>
			                        </tr>
			                      </thead>
			                       <tbody>
			                       	<?php foreach ($items as $item) {
			                       		$status = '';
			                       		if($item['Status'] == 1){$status = 'New';}
			                       		elseif ($item['Status'] == 2) {$status ='Like New';}	
			                       		elseif ($item['Status'] == 3) {$status ='Used';}
			                       		else{$status ='old';}	
			                       		?>
				                        <tr>
				                           	<td><?php echo $item['T_ID'];  ?></td>
				                          	<td><?php echo $item['Name']; ?> </td>
				                          	<td><?php echo $item['Description'] ?></td>
				                          	<td><?php echo $item['Price']; ?></td>
				                          	<td><?php echo $item['Date']; ?></td>
				                          	<td><?php echo $item['Country_Made'] ?></td>
				                          	<td class='text-center'><img src="<?php echo $item['image'];?>" style="width:100px"></td>
				                          	<td><?php echo $status; ?></td>
				                          	<td><?php echo $item['Category_Name']; ?></td>
				                          	<td><?php echo $item['Member_Name']; ?></td>
				                          	<td class='text-center'>
				                          		<input type='hidden' value='<?php echo $item['T_ID'];?>'>	
					                          	<a href='edit.php?itemid=<?php echo $item['T_ID'];?>' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
				  								<button  class='btn btn-danger pro-Remove'><i class='fa fa-close'></i> Remove</button>
				  							    <?php	 
				  							    	if($item["Approve"] == 0){?>
														<button  class='btn btn-info pro-Approve'><i class='fa fa-check'></i>Approve</button>
				  							    <?php } ?>
			  							   </td>
				                        </tr>
				                    <?php }?>    

				                     </tbody>  
			                    </table> 
	               		 	</div>
	           	 		</div>
	                 </div> 
	             </div>  
	         </div>

<?php  include $tpl . "footer.inc" ; ?>

					<!-- Remove And Approve	with ajax -->
			<script>
				$('button').on('click', function(e){
					e.preventDefault();
					var btn = $(this);
					// reomve
					console.log(btn);
					if(btn.hasClass('pro-Remove')){
						var btnRemove = $(this);
						console.log(btnRemove);
						console.log(btnRemove.siblings('input').val());
						var pro_Id = btnRemove.siblings('input').val();
						var firm = confirm('you are sure ?!!');
							if(firm == true){
								$.post('products.php',{status:'remove', pro_id:pro_Id},function(){
									if(pro_Id.length == 0){
										$('#val').html("<div class='alert alert-danger'> Not Found this ID</div>");
									}else{
										btnRemove.parents('tr').remove();
									};
								});
							};		
					}else{
						//approve
						if(btn.hasClass('pro-Approve')){
							var btnApprove = $(this);
							var pro_Id = btnApprove.siblings('input').val();
								$.post('products.php',{status:'Approve', pro_id:pro_Id},function(){
									if(pro_Id.length === 0){
										$('#val').html("<div class='alert alert-danger'> Not Found this ID</div>");
									}else{
										btnApprove.remove();
									}
								});
						};	
					}
					return false;
				});
			</script>	

<?php }else{
		header('Location: index.php');
			exit();
		}