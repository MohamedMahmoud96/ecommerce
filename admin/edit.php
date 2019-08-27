<?php
			include 'init.php';
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
?>
			<h1 class='text-center'>Edit Comments</h1>
			<div class='container'>
<?php				
			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
			$check = checkItem('Com_ID', 'comments', $comid);

			if($check > 0 ){
				$stmt = $con->prepare("SELECT * FROM comments WHERE Com_ID = ? ");
				$stmt->execute(array($comid));
				$com = $stmt->fetch();
?>					<div id='val'></div>
					<form class='form-horizontal' action='#' method='POST'/>
						<input id='com-id' type='hidden' name='comid' value='<?php echo $comid?>'/>
						<div class='form-group'>
							<label class='control-label col-md-2'>Comment</label>
							<div class='col-md-6'>
								<textarea id='comment' type='text' name='comment' class='form-control' ><?php echo $com['Comments'];?></textarea>
								
							</div>
						</div>		
						<div class='form-group'>					
							<div class='col-sm-2 col-sm-offset-2'>
								<input type='submit' id='btn-edit' value='Save' class='btn btn-success'>
							</div>	
						</div>		
					</form>
<?php		
			}else{
				$theMsg = "<div class='alert alert-danger'>This ID Not exist</div>";
				redirectHome($theMsg); }
			echo "</div>";	
	
			include $tpl . "footer.inc" ;?>

			<script>
				$('#btn-edit').on('click',function(){
					id = $('#com-id').val();
					com   =	$('#comment').val();

					$.post('edit.php',{comid:id, comment:com}, function(){
						if(com.length === 0){
							$('#val').html("<div class='alert alert-danger'> Comment Can't Be <strong>Empty</strong> </div>");
						}else{
							$('#val').html("<div class='alert alert-success'>Update Save</div>");
						}
					});
					return false;
				});	

			
			</script>



			