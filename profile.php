<?php
	session_start();
	$pageTitle = 'Profile';

	include "init.php";	 
	if(isset($_SESSION['memberID'])){

		$userstmt = $con->prepare("SELECT * FROM user WHERE UserID = ?");
		$userstmt->execute(array($sessionID));
		$info = $userstmt->fetch();
		$userid = $info['UserID'];
?>	
	<h1 class='text-center'>My Profile</h1>
	<section class='information block'>
		<div class='container'>
			<div class='panel panel-primary'>
				<div class='panel-heading'>My Infromation</div>
				<div class='panel-body'>
					<ul class='list-unstyled'>
						<li>
							<i class='fa fa-unlock-alt fa-fw'></i> 
							<span> Name </span> : <?php echo $info['UserName']; ?> 
						</li>
						<li> 
							<i class='fa fa-envelope-o fa-fw'></i> 
							<span> Email </span> : <?php echo $info['Email']; ?>
						 </li>
						<li> 
							<i class='fa fa-user fa-fw'></i> 
							<span> Full Name </span> : <?php echo $info['FullName']; ?> 
						</li>
						<li> 
							<i class='fa fa-calendar fa-fw'></i> 
							<span> register-Dat </span> : <?php echo $info['created_at']; ?> 
						</li>
						<li> 
							<i class='fa fa-tags fa-fw'></i> 
							<span> fav category </span> :
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class='my-ads block'>
		<div class='container'>
			<div class='panel panel-primary'>
				<div class='panel-heading'>My Ads</div>
				<div class='panel-body'>
					
<?php
						$ads_stmt =$con->prepare("SELECT items.*, user.UserName As Member_Name 
													FROM items
													INNER JOIN user ON user.UserID = items.Member_ID  
													WHERE Member_ID = ?");

						$ads_stmt->execute(array($info['UserID']));
						$items = $ads_stmt->fetchAll();
						if(!empty($items)){
							echo "<div class='row'>";	
								foreach($items as $item ){
									echo "<div class= 'col-md-3 col-sm-6'>";
										echo "<div class='thumbnail box-ads'>";
									if($item['Approve'] == 0){echo '<span class="pull-right not-Approve"><strong>Waiting Approve</strong></span>';}
									
											echo "<div class='price'> <span>". $item['Price']."</span> </div>";
											echo "<img src='layout/image/user.png'/>";
											echo "<h3><a href='items.php?itemid=". $item['T_ID'] . "'>".$item['Name'] . "</a></h3>";
											echo "<p>". $item['Description'] ."</p>";
											echo "<div><span class='date'>". $item['Date'] ."</span></div>";
										echo "</div>";
									echo "</div>";
								}	
							echo "</div>";
						}else{echo "sorry there is No Ads To Show, <a href='newItem.php'>Great New Ads</a> ";}
?>	
				</div>
			</div>
		</div>
	</section>

	<section class='my-comments block'>
		<div class='container'>
			<div class='panel panel-primary'>
				<div class='panel-heading'>Latst Comments</div>
				<div class='panel-body'>
<?php					
				$comm = $con->prepare("SELECT comments FROM comments WHERE User_ID = ?");
				$comm->execute(array($info['UserID']));
				$comments = $comm->fetchAll();
				if(!empty($comments)){
					foreach($comments AS $comment){
						echo "<p>".$comment['comments']."</p>";
					}

				}else{echo "Sorry there is No Comment's To Show";};
?>
				</div>
			</div>
		</div>
	</section>

<?php } else {

	header("Location:login.php");
	exit();
}	



	include $tpl . "footer.inc";

  ?>