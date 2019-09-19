	function adder(name,id) {
		/*this function is to add the row to the table;
		*/
		//The row
		//coa = container of animals
		var row="<tr class='w3-border coa' value="+id+" >";
			row+="<td>"+name+"</td>";
			row+="<td><input type='number' min='0' name='female'  value='0'></td>";
			row+="<td><input type='number' min='0' name='male'  value='0'></td>";
			row+="<td><button class='w3-btn w3-round rem' >X</button></td>";			
			row+="</tr>";
		//Adding to the table
		$("body").find('#maintable').append(row);
	}
	/**
	*Function to remove the row in the table
	*@var thiz
	 */
	function remover(thiz) {
		//removing...
		par=thiz.parent().parent();
		id=par.attr('value');
		//Hiding
		par.remove();
		//Finding the animal to display
		$("body").find('#list'+id).show();
			
	}
	/**Funtion submitor() 
	 *@var no idea!
	 *To do
	 *1.Collect the data
	 *2.Submiting the data
	 *3.redirect to other places
	 */
	function submitor() {
		//counting the number of rows present in the table
		var maintable = $("body").find('#maintable');
		//.......*/
		var count=0;
		$(".coa").each(function(index, el) {
			count++;
		});
		
		if (count>0) {
			//collecting the data
			var data=[];
			var values=[];
			var ac=0;
			$(".coa").each(function(index, el) {
				//finding the id and total
				//#id
				var id= $(this).attr('value');
				//total
				var female=$(this).find('[name=female]').val();
				var male=$(this).find('[name=male]').val();
				female=new Number(female);
				male=new Number(male);
				//then its time to push
				data[ac]=[];
				//starting with id
				data[ac].push(id);
				//Then its total
				data[ac].push(male);
				data[ac].push(female);
				//The total variable
				var total=male+female;
				data[ac].push(total);
			ac++;	
			});
			//Before Submitting we are adding  the basic info
			var parkid= $("body").find('[name=parkid]').val();
			var date= $("body").find('[name=date]').val();
			//Pushing to the array
			//Submiting to the datz.php
			//alert(data);
			$.post('datz.php', {date:date,parkid:parkid,data: data}, function(dataz, textStatus, xhr) {
				/*optional stuff to do after success */
				//Redirecting
				location.href="index.php";
			});
			

			}else if(count==0){
			alert("Sorry you cant submit if there is no atleast one animal filled")
		}
	}
		
	$(document).ready(function() {
		$("body").on('click', '.animal', function(event) {
			event.preventDefault();
			/* Act on the event 
			*/
			//obtaining the name
			var name= $(this).parent().find('#text').text();
			name= $.trim(name);
			//the id
			var id= $(this).val();
			//think its time to add
			//Hiding the ul
			$(this).parent().hide('fast', function() {
				adder(name,id);
			});
			
		});

		//Removing....
		$("body").on('click', '.rem', function(event) {
			event.preventDefault();
			/* Act on the event */
			var thiz=$(this);
			remover(thiz);
		});
		$("body").on('click', '#submit', function(event) {
			event.preventDefault();
			/* Act on the event */
			submitor();
		});
	});
