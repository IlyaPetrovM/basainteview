
<?php 
	$query = $_POST['getLastId'];
	if($query!=''){
		include 'select.php';
		echo execute_query("SELECT count(place_id) FROM interview where place_id='$query'");
	}
?>