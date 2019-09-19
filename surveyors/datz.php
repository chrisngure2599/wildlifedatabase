<?php 
	require '../includes/db.php';
	require_once 'gaurd.php';
?>
<?php 
print_r($_SESSION);
if (isset($_POST['data'])) {
	$data=$_POST['data'];
	$park_id=$_POST['parkid'];
	$date=$_POST['date'];
 	//Going through the array collecting the data
 	foreach ($data as $collection) {
 	//From the collection 0 is animal $aid
 	//Ans 1 is value $value
 	$aid=$collection['0'];	
 	$total=$collection['3'];
 	$total_male=$collection['1'];
 	$total_female=$collection['2'];
 	//Creating the query 
 	$uid=$_SESSION['id'];
 	echo $query=("INSERT INTO `results`
 		( `species_id`,`total`,`total_male`,`total_female`, `park_id`, `user_id`,`time`) VALUES 
 		($aid,$total,$total_male,$total_female,$park_id,$uid,'$date')");
 	$db->query($query);
 	}
 
 } ?>