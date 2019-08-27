<?php			
	// title 
	$pageTitle = 'Edit Comment';
	// include init 
	include '../../init.php';	

	// if get request post
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$comid = $_POST['comid'];
		$comment = $_POST['comment'];
		echo $comid;
		echo $comment;
		if(empty($comment)){ 
			echo "<div class='alert alert-danger'> Comment Can't Be <strong>Empty</strong> </div>";
		}else{
			$stmt=$con->prepare("UPDATE comments SET Comments = ? WHERE Com_ID = ?");
			$stmt->execute(array($comment, $comid));
		}	
	}
	// check if get id			
	$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
	//check isset id in database
	$check = checkItem('Com_ID', 'comments', $comid);
	if($check > 0 ){

		// select comment form database
		$stmt = $con->prepare("SELECT Comments FROM comments WHERE Com_ID = ? ");
		$stmt->execute(array($comid));
		$com = $stmt->fetch(); ?>	

		<!-- front end code -->
		<br><br><br>
		<h1 class='text-center'>Edit Comments</h1>
		<br><br>
		<div class='container'>
			<div id='val' class='col-md-offset-3 col-md-6 col-xs-10'></div>
			<form class='form-horizontal' action='<?php echo $_SERVER['PHP_SELF'];?>' method='POST'>
				<div class='col-xs-12'>
					<input id='com-id' type='hidden' name='comid' value='<?php echo $comid?>'/>
					<div class='form-group'>
						<label class='control-label col-xs-2 col-sm-offset-1'>Comment</label>
						<div class='col-sm-6 col-xs-10'>
							<textarea id='comment' type='text' name='comment' class='form-control' ><?php echo $com['Comments'];?></textarea>
						</div>
					</div>	
					<br>	
					<div class='form-group'>					
						<div class='col-sm-6 col-xs-10 col-sm-offset-3 col-xs-offset-2'>
							<input type='submit' id='btn-edit' value='Save' class='btn btn-success btn-lg btn-block'>
						</div>	
					</div>
				</div>		
			</form>
		</div>
		<!-- End front end -->
	<?php	
	}else{
		$theMsg = "<div class='alert alert-danger'>This ID Not exist</div>";
		redirectHome($theMsg); 
	}
	// include footer
	include $tpl . "footer.inc" ;?>

	<!-- Update with ajax-->
	<script>
		$('#btn-edit').on('click',function(){
			var id = $('#com-id').val();
			var com   =	$('#comment').val();

			$.post('edit.php',{comid:id, comment:com}, function(){
				if(com.length === 0){
					$('#val').html("<div class='alert alert-danger'> Comment Can't Be <strong>Empty</strong> </div>");
				}else{
					$('#val').html("<div class='alert alert-success'>Update Save</div>").toggle(3000).hide(3000);
				}
			});
			return false;
		});	
	</script>



			