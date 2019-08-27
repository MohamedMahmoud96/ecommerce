<?php 

	function getTitle() {

		global $pageTitle ;

		if(isset($pageTitle)) {

			echo $pageTitle; 
		} else {

			echo 'Default';
		};
	};


	function getAll($from , $order ){

		global $con ;

		$stmt = $con->prepare("SELECT * FROM $from where Approve = 1  ORDER BY $order DESC");

		$stmt->execute();

		$count = $stmt->fetchAll();
	
		return $count ;
	}

	function redirectHome($theMsg, $url = null, $seconds = 3) {

		if ($url === null){

			$url = 'index.php' ;
			$link = 'HomePage' ;

		} else {

			if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER']!== ''){

				$url =$_SERVER['HTTP_REFERER'];
				$link = 'BackPage' ;
		}else {

			$url = 'index.php';
			$link = 'index.php' ;
		} }

		echo  $theMsg  ;
		echo '<div class="alert alert-info">You Will Be Redirectly To ' . $link . ' After ' . $seconds .  ' Seconds</div>'; 

		header("refresh:$seconds;url=$url") ;
		exit() ;
	}




	function checkItem($select, $from, $value){

		global $con ;

		$stmt = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$stmt->execute(array($value));

		$count= $stmt->rowCount();
	
		return $count;
	}



	function stats($item, $table){
		global $con ;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
		$stmt2->execute();

		return  $stmt2->fetchColumn(); 
	}



	function getLatest($select, $from, $order, $limit = 5){

		global $con ;

		$stmt= $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");

		$stmt->execute();

		$row =$stmt->fetchAll();

		return $row ;
	}

	function checkuserStatus($user){

		global $con ;

		$stmtu= $con->prepare("SELECT UserName, Restatus  FROM user WHERE Restatus = ?");

		$stmtu->execute(array($user));

		$checkuser =$stmtu->rowCount();

		return $checkuser ;
	}	