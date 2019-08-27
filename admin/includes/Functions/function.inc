<?php 


	function getTitle() {

		global $pageTitle ;

		if(isset($pageTitle)) {

			echo $pageTitle; 
		} else {

			echo 'Default';
		};
	};


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

		header("Refresh:$seconds;url=$url");
		exit();
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

	function getAll($select , $from , $where , $value)
	{
		global $con ;	
		$stmt = $con->prepare("SELECT $select FROM $from WHERE $where = $value ");
		$stmt->execute();
		$row =$stmt->fetchAll();
		return $row;

	}

	function NameFolderProject()
	{
		$ProjectFolder = substr(str_replace('/', DIRECTORY_SEPARATOR, dirname($_SERVER['SCRIPT_NAME'])), 1);
		$ProjectFolder = explode(DIRECTORY_SEPARATOR, $ProjectFolder);
		// Name Folder this Project
		return $ProjectFolder[0];
	}
	function pathUrl()
	{
		$pathUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'. NameFolderProject();
		//http://hostName/NameFolderProdject [url]
		return $pathUrl;
	}
	function pathFolder()
	{
		$pathfolder = $_SERVER['DOCUMENT_ROOT'].'/'.NameFolderProject();
		//path in computer [folder]
		return $pathfolder;
	}

	function view($path)
	{
		// path view folder
		$view = pathUrl().'/admin/view/'. $path;
		return $view ;
	}

	function get_script()
	{
		global $scripts;
		if(isset($scripts))
		{
			if(is_array($scripts))
			{
				foreach($scripts as $script)
				{
					echo $script;
				}
			}else{
				echo $scripts;
			}
		}
		
	}