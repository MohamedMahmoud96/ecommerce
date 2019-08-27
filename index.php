<?php
	session_start();
	$pageTitle = 'Home';
	include "init.php";	
    setcookie('colors', 'black', time() + 3600, '/mkj');

	echo "<div class='container'>";
		echo "<div class='row'>";			
			$All = getAll('items', 'T_ID');	
			foreach($All as $item ){

				echo "<div class= 'col-md-4 col-sm-6'>";
					echo "<div class='thumbnail box-ads'>";
						echo "<div class='price'> <span>$". $item['Price']."</span> </div>";
						echo "<img src='layout/image/user.png'/>";
						echo "<h3><a href='items.php?itemid=". $item['T_ID'] . "'>".$item['Name'] . "</a></h3>";
						echo "<p>". $item['Description'] ."</p>";
						echo "<div><span class='date'>". $item['Date'] ."</span></div>";
					echo "</div>";
				echo "</div>";
			}
		echo "</div>";
	echo "</div>"	; 

include $tpl . "footer.inc";

 ?>
