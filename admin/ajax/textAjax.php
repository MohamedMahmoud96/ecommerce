
<?php include '../init.php';?>
<?php echo $_SERVER['DOCUMENT_ROOT'].'<br>'; ?>
<?php echo $_SERVER['HTTP_HOST'].'<br>'; ?>
<?php echo $_SERVER['REQUEST_URI'].'<br>'; ?>
<?php echo $_SERVER['SCRIPT_FILENAME'].'<br>'?>
<?php echo dirname($_SERVER['SCRIPT_NAME']).'<br>'?>
<?php echo $_SERVER['REQUEST_URI'].'<br>'?>
<?php echo $_SERVER['SERVER_NAME'].'<br>'?>
<?php echo $_SERVER['HTTP_HOST'].'<br>'?>
<?php echo __FILE__.'<br>'?>
<?php echo DIRECTORY_SEPARATOR.'<br>'?>
<?php
$folderProject = substr((str_replace('/', DIRECTORY_SEPARATOR, dirname($_SERVER['SCRIPT_NAME']).'/')), 1);
echo 'this=>'.$folderProject.'<br>';

$path = explode(DIRECTORY_SEPARATOR, $folderProject);
print_r($path[0].'<br>');

 echo $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.$path[0].'/'.'<br>';
$vi = view('categories/add.php');
echo "<a href='". view('categories/add.php')."'>welcom</a>";

?>
<a href="<?php  view('categories/add.php'); ?>">wel</a>


<?php echo dirname(__FILE__); ?>

<!-- <button id='btns'>click</button>
<input id = 'inp-1'>
<input id = 'inp-2'>
<a href="#" id='bt'>click</a> -->

<script>
/*
	$('#btn').on('click', function() {
		sendData = $('form').serialize();

		$.ajax({
			url : 'test.php',

			type : 'post',
			dataType : 'json',	

			data : $('form').serialize(),

			beforeSend: function () {
				$('#val').html('loading....');
			},
			success: function(error){
				console.log(error);
				 if(error['error_comment']){
				 	$('#comment').after('<span style="color:red">'+ error['error_comment'] +'</span>');
				 }
				 if(error['error_length']){
				 	$('#comment').after('<span style="color:red">'+ error['error_length']+'</span>');
				 }
			}		
		});

	return false;
	});
*/

</script> 
<?php
$do = isset($_GET['do']) ? $_GET['do'] : 'manage' ;
if($do == 'manage' ){?>
	<h3>Add Your Comment</h3>
	<form id = 'valform' action="" method = 'POST'>
		<textarea id ='comment' name='comment' required rows="12"></textarea></br>
		<input id='btn' type='submit' class='btn btn-danger' value='Add Comment'/>
	</form>
<?php }
if($do == 'Add' ){
		
}
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
 	echo $_POST['n'];

//  $stm = $con->prepare("INSERT INTO comments(Comments)VALUES(:zcom)");
// $stm->execute(array(
//  	'zcom' => $_POST['n']	
 	

 }
 ?> 
<script  src='layout/js/jquery-2.2.3.min.js'></script>
<script>

$('#btn').on('click', function(){
	val = $('#comment').val();
	$.ajax({
		url:'',
		type:'POST',
		data:{n: val},
		success: function(data){
			$('#val').html(data);	
				
			
		}
	})
	return false;
});

</script>


