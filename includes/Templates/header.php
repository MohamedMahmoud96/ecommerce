<!DOCTYPE html>
	<html>

		<head>
			<meta charset="UTF-8">
			<title><?php getTitle () ?></title>
			<link rel="stylesheet" href="<?php echo $css ;?>bootstrap.min.css "/>
			<link rel="stylesheet" href="<?php echo $css ;?>font-awesome.min.css"/>
			<link rel="stylesheet" href="<?php echo $css ;?>jquery-ui.css"/>
			<link rel="stylesheet" href="<?php echo $css ;?>jquery-selectBoxIt.css"/>
			<link rel="stylesheet" href="<?php echo $css ;?>front-end.css"/>
		</head>

		<body> 


       
	  <div class="navbar navbar-inverse">
          <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">Home</a>
            <?php
               if(isset($_SESSION['memberID'])){ 
                  $stmtu= $con->prepare("SELECT *  FROM user WHERE UserID = ? ");
                  $stmtu->execute(array($_SESSION['memberID']));
                  $item = $stmtu->fetch();
                  if($item['GroupID'] == 1 ){echo '<a class="navbar-brand" href="admin/index.php">Home Admin</a>'; }}
            ?> 
                    <div class='btn-group my-info'>
                    <span class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                 categories
                  <span class='caret'></span>
                 </span> 
                  <ul class='dropdown-menu'>
                          <?php
                 $cate = getLatest('*', 'categories', 'Cat_ID', 5);
          foreach ($cate as $cat) {

            echo "<li> <a href='categories.php?catid= " . $cat['Cat_ID'] . "&cat=". str_replace(' ','-', $cat['Name']). "'>"   . $cat['Name'] . "</a></li>";
            }                            
             ?>
                  </ul>
                </span>
              </div>
            </div>
            

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
        
                    <div class='upper-bar'>
        <div class=' text-right'>


<?php   

          if(isset($_SESSION['user'])){  ?>
              <img class='img-thumbnail img-circle' src='layout/image/user.png'/>
              <div class='btn-group my-info'>
                
                <span class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                  <?php echo $_SESSION['user']?>
                  <span class='caret'></span>
                 </span> 
                  <ul class='dropdown-menu'>
                    <li><a href='profile.php'>My Profile</a></li>
                    <li><a href='newItem.php'>New Item</a></li>
                    <li><a href='logout.php'>Logout</a></li>
                  </ul>
                </span>
              </div>
       

<?php 

        }else{ echo "<a href='login.php'> <span class='pull-right'>Login/Signup</sapn> </a>"; }
?>         
        </div>
      </div>
             </ul>
            </div><!-- /.navbar-collapse -->

          </div><!-- /.container-fluid -->
        </div>