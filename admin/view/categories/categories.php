<?php

	session_start()	;

	$pageTitle = "Categories";
	if(isset($_SESSION['admin-name'])) 
	{
		include '../../init.php';
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$id = $_POST['id'];
			$check = checkItem('Cat_ID' ,'categories', $id);
			if($check > 0){
				$stmt = $con->prepare("DELETE FROM categories WHERE Cat_ID = :zid");
				$stmt->bindParam(":zid" , $id);
				$stmt->execute();
			}	
		}

			$sort = 'ASC';
			$sort_Array = array('ASC' , 'DESC');
			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_Array)){
				$sort = $_GET['sort'];
			}

			$stmt =$con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
			$stmt->execute();
			$cate =$stmt->fetchAll(); ?>

			<h1 class='text-center'>Manage Categories</h1>
			<div class='container'>
				<div class='panel panel-default'>
					<div class='panel-heading'>All Categories
						<div class='ordering pull-right'>
							Ordering: 

							<a class= "<?php if($sort == 'ASC'){echo 'active';} ?>" href="?sort=ASC">ASC</a> |
							
							<a class= "<?php if($sort == 'DESC'){echo 'active';} ?>" href="?sort=DESC">DESC</a>
						</div>
					</div>
					<class='panel-body'>
						<?php
							foreach($cate as $cat){ ?>
								<div class="cate">
									<hr>
										<div class='hidden-buttons'>
											<input id='cat-id' type='hidden' value='<?php echo $cat['Cat_ID']; ?>' >
											<a href='edit.php?cateid=<?php echo  $cat['Cat_ID'];?>' class='btn btn-primary btn-xs'><i class='fa fa-edit'></i> Edit</a>
											<button  class='btn btn-danger btn-xs cat-remove'><i class='fa fa-close'></i> Delete</button>	
										</div>
										<h3><?php echo  $cat["Name"];?> </h3>
										<p><?phpecho  $cat["Description"];?></p>
										<?php
											if ($cat["visiblty"] == 1 ){echo '<span class="visiblty">Hidden</span>';}
											if ($cat["Allow_Comment"] == 1 ){echo '<span class="commenting">Comment Disabled</span>';}
											if ($cat["Allow_Ads"] == 1 ){echo '<span class="ads">Ads Disabled</span>';}	
										?>
									<hr>						
								</div>
								
						<?php } ?>	
					</div>
				</div>
			</div>
		<?php include $tpl . "footer.inc"; ?>
			<script>
				$('.cat-remove').on('click', function(e){
					e.preventDefault();
					var btn = $(this),
						id 	= btn.siblings('input').val();
						$.post('categories.php', {id:id}, function(){
							btn.parents('.cate').remove();
						});

				});
			</script>

<?php	} else {
		header('location: ../');
		exit();
	}


	