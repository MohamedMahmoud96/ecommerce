<?php
		
			echo "<h1 class='text-center'>Edit Comments</h1>";
			echo "<div class='container'>";
			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
			$check = checkItem('Com_ID', 'comments', $comid);

			if($check > 0 ){
				$stmt = $con->prepare("SELECT * FROM comments WHERE Com_ID = ? ");
				$stmt->execute(array($comid));
				$com = $stmt->fetch();
?>			
					<form class='form-horizontal' action='?do=Update' method='POST'/>
						<input type='hidden' name='comid' value='<?php echo $comid?>'/>
						<div class='form-group'>
							<label class='control-label col-md-2'>Comment</label>
							<div class='col-md-6'>
								<textarea type='text' name='comment' class='form-control' ><?php echo $com['Comments'];?></textarea>
							</div>
						</div>		
						<div class='form-group'>					
							<div class='col-sm-2 col-sm-offset-2'>
								<input type='submit'  value='Save' class='btn btn-success'>
							</div>	
						</div>		
					</form>
<?php		
			}else{
				$theMsg = "<div class='alert alert-danger'>This ID Not exist</div>";
				redirectHome($theMsg); }
			echo "</div>";	

			include $tpl . "footer.inc" ;	