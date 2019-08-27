<?php
	session_start(); 
	$pageTitle= "All Users" ;
	
	if (isset($_SESSION['admin-name']))
	{
		include "../../init.php";
			if($_SERVER['REQUEST_METHOD']=='POST'){
			$stats = $_POST['stats'];
			$userid = $_POST['userid'];
			if($stats == 'remove'){
				$check = checkItem('UserId', 'user', $userid);
				if($check > 0){
					$stmt=$con->prepare("DELETE FROM user WHERE UserId = ?");
					$stmt->execute(array($userid));
				}
			}else{
				$check = checkItem('UserId', 'user', $userid);
				if($check > 0){
					$stmt = $con->prepare('UPDATE user SET Restatus = 1 WHERE UserId = ?');

					$stmt->execute(array($userid));
				}
			}
		}
		
			$query = '';
			if(isset($_GET['page']) && $_GET['page']== 'pending'){ $query = 'AND ReStatus = 0';}
			$stmt = $con-> prepare("SELECT * FROM user WHERE GroupID != 1 $query ");
			$stmt->execute(); 
			$rows = $stmt->fetchAll(); ?>

			<!--Front End code-->
			<div class='row'>
				<div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
	                  <div class="x_title">
		                    <h2> <?php if($query !== ''){echo 'Pending Users';}else{echo 'Mange Page';}?> </h2>
		                    <ul class="nav navbar-right panel_toolbox">
		                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		                      </li>
		                      <li><a class="close-link"><i class="fa fa-close"></i></a>
		                      </li>
		                    </ul>
	                    <div class="clearfix"></div>
	                  </div>
	                  <div class="x_content">
	                   	 	<table id="datatable-fixed-header" class="table table-striped table-bordered bulk_action dt-responsive nowrap">
		                      <thead>
		                        <tr>
				                    <th>ID</th>
					  				<th>UserName</th>
					  				<th>Email</th>
					  				<th>Full Name</th>
					  				<th>Image</th>
					  				<th>Registered Date</th>
					  				<th>Control</th>
		                        </tr>
		                      </thead>
		                       <tbody>
		                       	<?php foreach ($rows as $row) {?>
			                        <tr>
			                           	<td><?php echo $row['UserID']; ?></td>
			                          	<td><?php echo $row['UserName']; ?> </td>
			                          	<td><?php echo $row['Email']; ?></td>
			                          	<td><?php echo $row['FullName']; ?></td>
			                          	<td class='text-center'><img src="<?php echo $row['image'];?>" style="width:100px"></td>
			                          	<td><?php echo $row['created_at']; ?></td>
			                          
			                          	<td class='text-center'>
			                          		<input id='user_id' class='user_id' type='hidden' value="<?php echo $row['UserID'];?>">	
				                          	<a href='edit.php?userid=<?php echo $row['UserID'];?>' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
											<button  class="btn btn-danger user-remove"><i class='fa fa-close'></i> Remove</button>
										<?php	 
											if($row["Restatus"] == 0){?>
												<button class="btn btn-info user-approve"><i class='fa fa-check'></i> Approve</button>
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

    <?php  include $tpl . "footer.inc"; ?>
					<!-- Remove And Approve	with ajax -->
			<script>
				$('button').on('click', function(e){
					e.preventDefault();
					var btn = $(this);
					// reomve
					if(btn.hasClass('user-remove')){
						var btnRemove = $(this)
						var userId = btnRemove.siblings('input').val();
						var firm = confirm('you are sure ?!!');
							if(firm == true){
								$.post('users.php',{stats:'remove', userid:userId},function(){
									if(userId.length == 0){
										$('#val').html("<div class='alert alert-danger'> Not Found this ID</div>");
									}else{
										btnRemove.parents('tr').remove();
									};
								});
							};		
					}else{
						//approve
						if(btn.hasClass('user-approve')){
							var btnApprove = $(this);
							var userId = btnApprove.siblings('input').val();
								$.post('users.php',{stats:'Approve', userid:userId},function(){
									if(userId.length === 0){
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

<?php } else{
	header('location:/');
	exit();	
}