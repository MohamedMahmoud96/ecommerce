<?php include "admin/connect.php"; ?>
<script  src='layout/js/jquery-2.2.3.min.js'></script>
<?php

$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

if($do == 'manage' ){?>
	<h3>Add Your Comment</h3>
	<form id = 'valform' action="" method = 'POST'>
		<textarea id ='comment' name='comment' required rows="12"></textarea></br>
		<input id='btn' type='submit' class='btn btn-danger' value='Add Comment'/>
	</form>

<?php }
if($do == 'Add' ){
	if($_SERVER['REQUEST_METHOD']=='POST'){?>
			<script >
				$('h3').css('color:red');
			</script>
<?php	}
}
?>


<script>

$('#btn').on('click', function(){
	val = $('#comment').val();
	$.ajax({
		
		type:'POST',
		data:{n: val},

	})
	return false;
});

</script>