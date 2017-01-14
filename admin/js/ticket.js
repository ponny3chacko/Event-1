function datePicker(){
	$('.form_datetime').datetimepicker({
	    //language:  'fr',
	    weekStart: 1,
	    todayBtn:  1,
	    autoclose: 1,
	    todayHighlight: 1,
	    startView: 2,
	    forceParse: 0,
	    showMeridian: 1
	});
}
$('#events').on('change', function(e){
	if(this.value != '-1'){
		$('#ticketsHolder, #more').show();
		$.ajax({
			url : 'ajax/getTickets.php',
			type : 'post',
			dataType : 'JSON',
			data : {eid : this.value},
			success :function(data){
				
				$('#count').val(data.length);
				if(data.length > 0){
					$('#ticketsHolder').empty();
					var count = 1;
					$.each(data,function(k,j){
						var data = '<div class="col-sm-6" '+count+'>'
									+'<input type="hidden" name="ticketId[]" value = "'+j.tic_id+'">'
									+'<h5 class="text-center">Ticket '+count+'</h5>'
									+'<hr>'
									+'<div class="col-sm-12">'
										+'<input type="text" class="form-control" name = "ticketname[]" placeholder="Ticket Name" value = "'+j.tic_name+'"><br/>'
										+'<input type="text" class="form-control" name = "description[]" placeholder="Ticket Description" value = "'+j.tic_description+'"><br/>'
										+'<div class="input-group date form_datetime col-md-12" data-date="'+j.tic_start_date+'Z" data-date-format="dd MM yyyy" data-link-field="dtps_input'+count+'">'
									        +'<input class="form-control" size="16" type="text" value="'+j.tic_start_date+'" readonly>'
									        +'<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>'
											+'<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>'
									    +'</div>'
										+'<div class="input-group date form_datetime col-md-12" data-date="'+j.tic_last_date+'Z" data-date-format="dd MM yyyy" data-link-field="dtpl_input'+count+'">'
									        +'<input class="form-control" size="16" type="text" value="'+j.tic_last_date+'" readonly>'
									        +'<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>'
											+'<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>'
									    +'</div>'
										+'<input type="hidden" name = "startdate[]" id="dtps_input'+count+'" value = "'+j.tic_start_date+'" /><br/>'
										+'<input type="hidden" name = "lastdate[]" id="dtpl_input'+count+'" value = "'+j.tic_last_date+'" /><br/>'
									+'</div>'
									+'<div class="col-sm-4">'
										+'<input type="text" class="form-control" name = "price[]" placeholder="Price" value = "'+j.tic_price+'">'
									+'</div>'
									+'<div class="col-sm-4">'
										+'<input type="text" class="form-control" name = "total[]" placeholder="Total" value = "'+j.tic_total+'">'
									+'</div>'
									+'<div class="col-sm-4">'
										+'<input type="text" class="form-control" name = "max[]" placeholder="Maximum Tickets" value = "'+j.tic_max+'">'
									+'</div>'
									+'<hr>'	
								+'</div>';
						count++;				
						$('#ticketsHolder').append(data);
						datePicker();
					});
				}
			}
		});
	}else{
		$('#ticketsHolder, #more').hide();		
	}
});

$('#more').on('click', function(){	
	var count = $('#count').val(),
		date = $('#date').val();	
		count++;
	var data = '<div class="col-sm-6" '+count+'>'
					+'<input type="hidden" name="ticketId[]">'
					+'<h5 class="text-center">Ticket '+count+'</h5>'
					+'<hr>'
					+'<div class="col-sm-12">'
					+'<input type="text" class="form-control" name = "ticketname[]" placeholder="Ticket Name"><br/>'
					+'<input type="text" class="form-control" name = "description[]" placeholder="Ticket Description"><br/>'
					+'<div class="input-group date form_datetime col-md-12" data-date="'+date+'Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtps_input'+count+'">'
				        +'<input class="form-control" size="16" type="text" value="" placeholder = "Start Date" readonly>'
				        +'<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>'
						+'<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>'
				    +'</div>'
				    +'<div class="input-group date form_datetime col-md-12" data-date="'+date+'Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtpl_input'+count+'">'
				        +'<input class="form-control" size="16" type="text" value="" placeholder = "Start Date" readonly>'
				        +'<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>'
						+'<span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>'
				    +'</div>'
					+'<input type="hidden" name = "startdate[]" id="dtps_input'+count+'" value="" /><br/>'
					+'<input type="hidden" name = "lastdate[]" id="dtpl_input'+count+'" value="" /><br/>'
				+'</div>'
				+'<div class="col-sm-4">'
					+'<input type="text" class="form-control" name = "price[]" placeholder="Price">'
				+'</div>'
				+'<div class="col-sm-4">'
					+'<input type="text" class="form-control" name = "total[]" placeholder="Total">'
				+'</div>'
				+'<div class="col-sm-4">'
					+'<input type="text" class="form-control" name = "max[]" placeholder="Maximum Tickets">'
					+'</div>'
				+'<hr>'
				+'</div>';

	$('#ticketsHolder').append(data);
	$('#count').val(count);

	datePicker();
});

$('#eventForm').on('submit', function(e){
	e.preventDefault();
	var data = new FormData(this);
	$.ajax({
		url : 'ajax/addTickets.php',
		type : 'post',
		data : data,
		processData : false,
		contentType : false,
		success : function(data){
			if(data.indexOf('OK') >= 0){				
				$('#message').html('Successfully Inserted and updated!');
	            window.setTimeout(function(){
	                $('#message').hide('blind');
	            },5000);
	        }else{
	        	$('#message').html('Something Went wrong Please Try Again!');
	            window.setTimeout(function(){
	                $('#message').hide('blind');
	            },5000);
	        }
		}
	})
});
