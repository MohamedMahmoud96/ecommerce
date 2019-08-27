<?php 
	session_start();
	$pageTitle = $_GET['cat'];

	include "init.php";	
			
	$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
	$check = checkItem('Cat_ID', 'categories', $catid);
	if($check > 0){ 
		$stmt = $con->prepare(" SELECT 
									items.*, user.UserName As Member_Name
								 FROM 
								 	items 	
								 	INNER JOIN user ON user.UserID = items.Member_ID 							 	
								 WHERE 
								  Category_ID = ? AND Approve = 1 ORDER BY T_ID ASC");

		$stmt->execute(array($catid));
		$items = $stmt->fetchAll();	
	echo "<div class='container'>";
		echo "<h1 class='text-center'>". $_GET['cat'] . "</h1>";
		echo "<div class='row'>";
		if(!empty($items)){				
			foreach ($items as $item ){
						echo "<div class='col-md-3 col-sm-6'>";
							echo "<div class='thumbnail'>";
									echo "<div class='price'> <span>". $item['Price']."</span> </div>";
								echo "<img src='layout/image/user.png'/>";
								echo "<h3><a href='items.php?itemid=". $item['T_ID'] . "'>".$item['Name'] . "</a></h3>";
								echo "<ph>". $item['Description'] ."</p>";
									echo "<ph>". $item['Member_Name'] ."</p>";
							echo "</div>";
						echo "</div>";}		

			}else{ echo '<div class="alert alert-info">Sorry This Category Is Empty</div>'; }

		echo "</div>";						
	echo "</div>";		
		
	}else {echo 'sorry';}

 	include $tpl . "footer.inc";