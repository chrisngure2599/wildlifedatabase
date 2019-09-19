$(document).ready(function() {


	$("body").on('click', '.stp1', function(event) {
		event.preventDefault();
		/* Act on the event */
		var ans= $.trim($(this).attr('value'));

		if (ans=="parks") {
			addparks();
		}else if (ans=="animals") {
			addanimals();
		}
	});
	$("body").on('click', '.btnstp2', function(event) {
		event.preventDefault();
		/* Act on the event */
		var id= $.trim($(this).attr('value'));
		//Calling the function 
		addpark(id);
	});
	//Listening to btnstp3 (animals)
	$("body").on('click', '.btnstp3', function(event) {
		event.preventDefault();
		//Getting some stuff
		var id= $.trim($(this).attr('value'));
		//Calling the function to add animal "addanimal(id)"
		addanimal(id);
	});
});
//////////////
//Functions //
//////////////
//#function to add the parks
function addparks() 
	{
		// first ajaxing to fetch the parks at ajaxvfd
		$.post('ajaxvfd.php', {parks:'parks'}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			//Checking if there is any park
			data=$.trim(data);

			if (data=='0') {
				alert("Sorry there is  "+data+"park")
			}else{
				//then actually adding
				//#First removing the constp1
				$("body").find(".constp1").remove();
				//Parsing to the data towards Json
				var json=JSON.parse(data);
				//yes Just after parsing its to loop em!
				//counting them 
				var count = json.length;
				var i=0;

					while (count>i) 
					{
					var obj=json[i];
					var item="<div class='constp2' >"
					 item += "<li><button  class='btnstp2 w3-button w3-blue' value="+obj.id+">"+obj.name+"</li>";
						item+="<br></div>"
					//appending
					$("body").append(item);
					i++;
					}			
			}
		});
		
	
	}
function addanimals() 
	{
		$.post('ajaxvfd.php', {animals: 'animals'}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			//Checkingif there is atleast one animal from the darabase
			data=$.trim(data);
			if (data==0) {
				alert("Sorry no animal found yet!");
			}else if (data!==0) {
				//then actually adding
				//#First removing the constp1
				$("body").find(".constp1").remove();
				//#Appending the data
				$("body").append(data);

			}
		});
	}
function addpark(id) 
	{
		
		// Function to display the choosen park
		$.post('ajaxvfd.php', {park:id}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			if (data==0) {
				alert("Sorry 0 Data found")
			}else {
				//removing stp2
				
		$("body").find('.constp2').remove();
		var all=$.parseJSON(data);
		var rez="<h1 class='w3-container' style='font-family:verdana' >";
		rez+=""+all[0].pname+"<b><i></i></b></h1>";

		$("body").append(rez);
		var add="<table class='w3-table' >";
		add+="<tr><th>Animals name</th><th>Date recorded</th><th>Total_Male</th><th>Total_Female</th><th>Total</th></tr>";
		all.forEach( function(element, index) {
			// statements
		add+="<tr><td>"+element.name+"</td><td>"+element.time+"</td><td>"+element.total_male+"</td><td>"+element.total_female+"</td><td>"+element.total+"</td></tr>";
			
		});
		//then appending with the rows
		
		$("body").append(add);
		}
		});			
	}
function addanimal(id) {
	//then checking wiz Ajax
	$.post('ajaxvfd.php', {animal: id}, function(data, textStatus, xhr) {
		data=$.trim(data);
		
		if (data==0) {
			alert("Sorry the animal is either not found or not recorded");
		}else {
			//appending Tha data
			$("body").find('.constp2').remove();
			//$("body").append(data)
			//parsing into JSON
			var all=$.parseJSON(data);
			var add="<table class='w3-table' >";
		add+="<tr><th>Park name</th><th>Date recorded</th><th>Total_Male</th><th>Total_Female</th><th>Total</th></tr>";
		all.forEach( function(element, index) {
			// statements
		add+="<tr><td>"+element.pname+"</td><td>"+element.time+"</td><td>"+element.total_male+"</td><td>"+element.total_female+"</td><td>"+element.total+"</td></tr>";
		
		});
		//then appending with the rows
		
		$("body").append(add);
		}
	});
}
