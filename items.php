<?php
	session_start();
	$pageTitle = 'items';
	include "init.php";	
	
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
		$check = checkItem("T_ID", "items" , $itemid);
	if($check > 0){
		$stmt= $con->prepare("SELECT 
									items .*, 
									categories.Name AS Cate_Name ,
									user.UserName AS Member_Name  
								FROM items 
									
									INNER JOIN categories ON categories.Cat_ID = items.Category_ID 							
									 INNER JOIN user ON user.UserID = items.Member_ID	
									 WHERE T_ID = ? AND Approve = 1");

		$stmt->execute(array($itemid));
		$item = $stmt->fetch();
		if($item){
	
?>
	<h1 class='text-center'><?php echo $item['Name'];?></h1>	
	<div class='container'>
		<div class='row'>
			<div class='col-md-3'>
				<img class='img-responsive img-thumbnail center-block' src='layout/image/user.png'/>
			</div>
			<div class='col-md-8 item-info'>
				<h2><?php echo $item ['Name'];?></h2>
				<p><?php echo $item ['Description'];?></p>
				<ul class="list-unstyled">
					<li>
						<i class='fa fa-calendar fa-fw'></i> 
						<span>Added Date</span> : <?php echo $item ['Date'];?> 
					</li>

					<li>
						<i class='fa fa-money fa-fw'></i> 
						<span>Price</span> : <?php echo $item ['Price'];?>
					</li>
					<li>
						<i class='fa fa-building fa-fw'></i> 
						<span> Made In </span> : <?php echo $item ['Country_Made'];?> 
					</li>

					<li>
						<i class='fa fa-tags fa-fw'></i> 
						<span> Category</span> : <a href='#'><?php echo $item ['Cate_Name'];?></a> 
					</li>
					<li>
						<i class='fa fa-user fa-fw'></i> 
						<span>Added by </span>  :
							<?php echo "<a href='#'>" . $item['Member_Name'] . " </a>" ?> 
									
					</li>
				</ul>	
			</div>
		</div> 
		<hr/>

		
			
<?php 
		if(isset($_SESSION['user'])){
?>	
			<div class='row'>
				<div class='col-md-offset-3'>
					<div class='add-comment'>
						<h3>Add Your Comment</h3>
						<form action="<?php echo $_SERVER['PHP_SELF'] .'?itemid=' . $item['T_ID'] ?>" method = 'POST' >
							<textarea name='comment' required></textarea>
							<input type='submit' class='btn btn-danger' value='Add Comment'/>
						</form>
<?PHP
				if($_SERVER['REQUEST_METHOD'] == 'POST'){

					$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
					$Mid  = $_SESSION['memberID'];
					$itemid  = $item['T_ID'];
					if(!empty($comment)){

						$stmt =$con->prepare("INSERT INTO 
													comments(Comments, Date, Item_ID, User_ID)
													VALUES(:zcomm, now(), :zitem, :zuser) 
													 ");
						$stmt->execute(array(

							'zcomm' => $comment,
							'zitem' => $itemid,
							'zuser' => $Mid
						));
						echo "<div class='alert-info'>Waiting Aprrove Your Comment</div>";
						
					}else{ echo "<div class='alert alert-danger'>Must Be Add Comment</div>";}

				}?>	
					</div>	
				</div>	
			</div>		
<?php }else{ echo '<a href="login.php">Login</a> OR <a href="login.php">Register</a> To Add Comment'; }?>

		<hr/>
<?PHP		
		$stmt = $con->prepare("SELECT comments.*, user.UserName As member 

											FROM comments 
											INNER JOIN user ON user.UserID = comments.User_ID
											WHERE Item_ID = ? AND Status = 1
											ORDER BY Com_ID DESC

										");
					$stmt->execute(array($item['T_ID']));
					$comments = $stmt->fetchAll();

					foreach($comments AS $comment){?>
						<div class='comment-box'>
						
							<div class='row'>
								<div class='col-md-2 text-center'>
								 <img class='img-responsive img-thumbnail img-circle center-block' src='layout/image/user.png'/>
									<h3> <?php echo $comment['member'] ?></h3>
								</div>
								<div class='col-md-10'>
									<p class='lead'> <?php echo  $comment['Comments'] ?> </p>
								</div>
							</div>
							<hr/>
						</div>
<?php					}	
	 }else{
	 		
	 	$theMsg = "<div class='alert alert-danger'>This Item Is Waiting Approve</div>";
	 	redirectHome($theMsg, 'back');
	 }

	}else{
		$theMsg = "<div class='alert alert-danger'>There\'s No Such ID</div>";
	 	redirectHome($theMsg);
	 }	

	include $tpl . "footer.inc";