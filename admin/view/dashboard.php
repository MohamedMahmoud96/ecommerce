<?php 

	session_start(); 
	$pageTitle= "Dashboard";

	if(isset($_SESSION['admin-name'])) {
		include "../init.php";
		$latestUser = 5;
    $lastComments = 5;
    $latestProduct = 5;
    $lastCategory = 5;
		$theLatestusers = getLatest('*', 'user', 'UserID', $latestUser);
    $theLatestComments = getLatest('*', 'comments', 'Com_ID', $lastComments);
    $theLatestProducts = getLatest('*', 'items', 'T_ID', $latestProduct);
    $theLatestCategory = getLatest('*', 'categories', 'Cat_ID', $lastCategory);

?>
          <!-- top tiles -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>Total Users</span>
              <div class="count"><a href="<?php echo view('users/users.php');?>"> <?php echo stats("UserID", "user"); ?></a></div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Pending Users</span>
              <div class="count">
              		<a href='<?php echo view('users/users.php');?>?page=pending'>
					         <?php echo checkItem('Restatus','user', '0')?> 
					       </a>
				      </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-shopping-cart"></i> Total Products</span>
              <div class="count green">
              	<a href="<?php echo view('products/products.php');?>"> <?php echo stats("T_ID", "items"); ?></a>
              </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Pending Products</span>
              <div class="count">
                  <a href='<?php echo view('products/products.php');?>?page=pending'>
                   <?php echo checkItem('Approve','items', '0')?> 
                 </a>
              </div>
            </div>

             <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-group"></i> Total Categories</span>
              <div class="count">
                <a href='<?php echo view('categories/categories.php');?>'> <?php echo stats('Cat_ID', 'categories');?> </a>
              </div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-comment"></i> Total Comments</span>
              <div class="count">
              	<a href='<?php echo view('comments/comments.php');?>'> <?php echo stats('Com_ID', 'Comments');?> </a>
              </div>
            </div>
          <!-- /top tiles -->
          <!--Latest 5 Users -->
          	<div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Latest <?php echo $latestUser; ?> Register User</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Username</th>
                          <th>Full Name</th>
                          <th>Email</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<?php 
                      		foreach ($theLatestusers  as $user) {?>
                      			 <tr>
                          			<th scope="row"><?php echo $user['UserID']; ?></th>
                          			<td><?php echo $user['UserName']?></td>
                          			<td><?php echo $user['FullName']?></td>
                          			<td><?php echo $user['Email']?></td>
                        		</tr>
                      <?php	} ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
              <!--Latest 5 Comments-->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Latest <?php echo $lastComments; ?> Comments</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Comments</th>
                          <th>Item Name</th>
                          <th>User Name</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($theLatestComments as $com) {?>
                             <tr>
                                <th scope="row"><?php echo $com['Com_ID']; ?></th>
                                <td><?php echo $com['Comments']?></td>
                                <td><?php echo $com['Item_ID']?></td>
                                <td><?php echo $com['User_ID']?></td>
                            </tr>
                      <?php } ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
                <!--latest 5 products-->
               <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Latest <?php echo $latestProduct; ?> Products</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Price</th>
                          <th>Country</th>
                          <th>Category</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($theLatestProducts as $product) {?>
                             <tr>
                                <th scope="row"><?php echo $product['T_ID']; ?></th>
                                <td><?php echo $product['Name']?></td>
                                <td>$<?php echo $product['Price']?></td>
                                <td><?php echo $product['Country_Made']?></td>
                                <td><?php echo $product['Category_ID']?></td>
                            </tr>
                      <?php } ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>

                <!--latest 5 categories-->
               <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Latest <?php echo $latestProduct; ?> Categories</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Description</th>
                          <th>count Items</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($theLatestCategory as $cat) {?>
                             <tr>
                                <th scope="row"><?php echo $cat['Cat_ID']; ?></th>
                                <td><?php echo $cat['Name']?></td>
                                <td>$<?php echo $cat['Description']?></td>
                            </tr>
                      <?php } ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>
<?php 
	   include $tpl . "footer.inc";
	}else{
		header("location:index.php");
		exit();
	}
 


