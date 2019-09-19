<?php 

	if (isset($_POST)) {
		//connecting the DB
		require_once 'includes/db.php';
		//listening to the $_POST['parks']
		
		if (isset($_POST['parks'])) {
			//this lists parks
			$query=("SELECT * FROM parks ORDER BY name ASC ");
			$res=$db->query($query);
			$ans=mysqli_num_rows($res);
			if ($ans>0) {
				//then looping
				$data_json=array();
				while ($data=mysqli_fetch_assoc($res)) {
				//create datz to carry the Sub Array!
				$datz=array();
				foreach ($data as $key=>$dat) {
				//print_r($key."=>".$dat."<br>");
				//Pushing data to $datz
				$datz[$key]=$dat;
				}
				//pushing the datz to data_json
				array_push($data_json, $datz);
			}
				//Passing the Json
				echo json_encode($data_json);
				//echo '<pre>';
				//print_r($data_json);
			}elseif ($ans==0) {
				echo '0';
			}
		}if (isset($_POST['park'])) {

			$park=mysqli_real_escape_string($db,$_POST['park']);
			$park=$_POST['park'];
			 $query=("SELECT *,parks.name as pname FROM `parks` join results ON results.park_id=parks.id JOIN species ON species.id=results.species_id WHERE parks.id=$park");
			$res=$db->query($query);
			$ans=mysqli_num_rows($res);
			if ($ans>0) {
				$all=array();
				while ($dataz=mysqli_fetch_assoc($res)) {
				//appending to all
					array_push($all, $dataz);
				}		
				//then finally sending
				echo json_encode($all);
			}elseif ($ans==0) {
				echo 0;
			}
		}if (isset($_POST['animals'])) {
			//listing the animals in the darabase
			$query=("SELECT * FROM species");
			$res=$db->query($query);
			$ans=mysqli_num_rows($res);
			if ($ans==0) {
				echo 0;
			}elseif ($ans>0) {
				//Looping the animals
				?><ul class="w3-ul w3-container constp2 " style="list-style-type: none;" >
				<?php
				while ($data=mysqli_fetch_assoc($res)) {
				    ?>
				    <li class="w3-border" >
				    	<button value="<?php echo $data['id'] ?>" class="w3-btn btnstp3 w3-blue w3-block" >	
				    		<?php echo $data['name']; ?>
				    	</button>
				    </li>
				    <?php
				}
			}
		}
		if (isset($_POST['animal']) && !empty($_POST['animal']) ) {
			//quering the animal/Specie
			///But first making sure that no string attached
			$animal=mysqli_real_escape_string($db,$_POST['animal']);
			$query=("SELECT *,parks.name as pname FROM `species` left JOIN results ON results.species_id=species.id JOIN parks on parks.id=results.park_id WHERE species.id=$animal");
			//Running ze query
			$res=$db->query($query);
			$ans=mysqli_num_rows($res);
			if ($ans>=1) {
				$all=array();
				//Looping to fetch alllllllll of them
				while ($data=mysqli_fetch_assoc($res)) {
				    array_push($all, $data);
				}
				echo json_encode($all);
			}elseif ($ans==0) {
				//incase the animal has never bieng recorded!
				echo 0;
			}
		}
		
	}elseif (!isset($_POST)) {
		die("Sorry you cant do this");
	}
 ?>