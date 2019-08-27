<?PHP
	session_start();
	$pageTitle = 'Comments' ;
	// if get request post
	if(isset($_SESSION['admin-name'])){
		include '../../init.php';
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$stats = $_POST['stats'];
			$comid = $_POST['comid'];
			if($stats == 'remove'){
				$check = checkItem('Com_ID', 'comments', $comid);
				if($check > 0){
					$stmt=$con->prepare("DELETE FROM comments WHERE Com_ID = ?");
					$stmt->execute(array($comid));
				}
			}else{
				$check = checkItem('Com_ID', 'comments', $comid);
				if($check > 0){
					$stmt = $con->prepare('UPDATE comments SET Status = 1 WHERE Com_ID = ?');

					$stmt->execute(array($comid));
				}
			}
		}
		// select data form database
		$stmt = $con->prepare("SELECT 
									comments.*,
									items.Name AS Item_Name,
									user.UserName AS User_Name	
								FROM comments
									INNER JOIN items ON items.T_ID = comments.Item_ID 
									INNER JOIN user ON user.UserID = comments.User_ID ");
		$stmt->execute();
		$comm = $stmt->fetchAll(); 
		?>
		
		<div class='row'>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
				 	<div class="x_title">
						<div id ='val'></div>
						<h2>Mange Comments</h2>
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
								<th>Comments</th>
								<th>Item Name</th>
								<th>User Name</th>
								<th>Created at</th>
								<th>Control</th>
							</tr>
						  </thead>
						   <tbody>
							<?php foreach ($comm AS $com) {?>
								<tr>
									<td><?php echo $com['Com_ID']; ?></td>
									<td><?php echo $com['Comments']; ?> </td>
									<td><?php echo $com['Item_Name']; ?></td>
									<td><?php echo $com['User_Name']; ?></td>
									<td><?php echo $com['Date']; ?></td>
									<td class='text-center'>	
										<input id='com_id' class='com_id' type='hidden' value="<?php echo $com['Com_ID'];?>">
										<a href='edit.php?comid=<?php echo $com['Com_ID'];?>' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<button  class="btn btn-danger com-remove"><i class='fa fa-close'></i> Remove</button>
										<?php	 
											if($com["Status"] == 0){?>
												<button class="btn btn-info com-approve"><i class='fa fa-check'></i> Approve</button>
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

<?php		
			// include footer
			include $tpl . "footer.inc" ;?>

			<!-- Remove And Approve	with ajax -->
			<script>
				$('button').on('click', function(){
					var btn = $(this);
					// reomve
					if(btn.hasClass('com-remove')){
						var btnRemove = $(this)
						var comId = btnRemove.siblings('input').val();
						var firm = confirm('you are sure ?!!');
							if(firm == true){
								$.post('comments.php',{stats:'remove', comid:comId},function(){
									if(comId.length == 0){
										$('#val').html("<div class='alert alert-danger'> Not Found this ID</div>");
									}else{
										btnRemove.parents('tr').remove();
									};
								});
							};		
					}else{
						//approve
						if(btn.hasClass('com-approve')){
							var btnApprove = $(this);
							var comId = btnApprove.siblings('input').val();
								$.post('comments.php',{stats:'Approve', comid:comId},function(){
									if(comId.length === 0){
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
<?php
	} else{
		header('Location: index.php');
			exit();
		}

