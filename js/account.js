	
	$("#list li").each(function(i){	
		

		$(["#changeSection", "#companySection", "#bankSection"].join(", ")).hide();

		$("#"+this.id).on('click',function(){
			$(this).addClass('active');
			var id = '#'+this.id+'Section';
			var tab = '#'+this.id;
			$(id).show();
			var Section = ["#personalSection","#changeSection", "#bankSection", "#companySection"];
			var Tabs = ["#personal","#change", "#bank", "#company"];

			Section = jQuery.grep(Section, function(value) {
			  return value != id;
			});			
			Tabs = jQuery.grep(Tabs, function(value) {
			  return value != tab;
			});	
			$(Tabs.join(", ")).removeClass('active');
			$(Section.join(", ")).hide();			
		});
	});
	
	function successMessage(msg){
		$('#updateLoader').hide();
		$('#message').show('blind').html('<span>'+msg+'</span>');
		window.setTimeout(function(){
	      $('#message').hide('blind');
	    },5000);
	}
	$('#personalForm').on('submit',function(e){
		$('#updateLoader').show();
		e.preventDefault();
		var da = new FormData(this);
		
		$.ajax({
			url : 'ajax/updateDetails.php',
			type : 'post',
			data : da,			
		    contentType: false,
		    processData: false		    
		}).done(function(data){
		    	if(data.indexOf('OK') >= 0){
		    		successMessage('Personal Details Updated Successfully!!');
		    	}
		    });		
	});

	$('#companyForm').on('submit',function(e){
		$('#updateLoader').show();
		e.preventDefault();
		var da = new FormData(this);
		
		$.ajax({
			url : 'ajax/updateDetails.php',
			type : 'post',
			data : da,			
		    contentType: false,
		    processData: false
		}).done(function(data){
		    	if(data.indexOf('OK') >= 0){
		    		successMessage('Company Details Updated Successfully!!');
		    	}
		    });		
	});

	$('#bankForm').on('submit',function (e){
		$('#updateLoader').show();
		e.preventDefault();
		var da = new FormData(this);
		
		$.ajax({
			url : 'ajax/updateDetails.php',
			type : 'post',
			data : da,			
		    contentType: false,
		    processData: false
		}).done(function(data){
			console.log(data);
		    	if(data.indexOf('OK') >= 0){
		    		successMessage('Bank Details Updated Successfully!!');
		    	}
		    });		
	});

	$('#changeForm').on('submit',function (e){
		$('#updateLoader').show();
		e.preventDefault();
		var da = new FormData(this);
		
		$.ajax({
			url : 'ajax/updateDetails.php',
			type : 'post',
			data : da,			
		    contentType: false,
		    processData: false
		}).done(function(data){
			// console.log(data);
		    	if(data.indexOf('OK') >= 0){
		    		successMessage('New Password Updated Successfully!!');
		    	}else if(data.indexOf('NO') >= 0){
		    		$(this).css('border','1px solid red');			    		
					$('#oldMsg').show('fold');
					$('#updateLoader').hide();
		    	}
		    });		
	});

	function checkBtn(){
		if($('#oldPass').val().length > 0 
			&& $('#newPass').val().length > 0 
			&& $('#conNewPass').val().length > 0 ){
			$('#changeBtn').prop('disabled',false);
		}
	}
	$('#newPass').on('keyup',function(){

		if(this.value.length < 8){
			$('#passMsg').html('<span>Password Must be of 8 characters</span>');			
			$('#passMsg').show('fold');
		}else{
			$('#passMsg').hide('fold');
		}
		checkBtn();
	});				

	$('#conNewPass').on('keyup',function(){		
		if(this.value.length >= $('#newPass').val().length){						
			if(this.value != $('#newPass').val()){				
				$('#coPassMsg').html('<span>Password Doesn\'t Match</span>');
				$('#coPassMsg').show('fold');
			}else{				
				$('#coPassMsg').hide('fold');				
			}
		}
		checkBtn();
	});

	$('#requestChange').on('click',function(){
		$.ajax({
			url : 'ajax/resetMail.php',
			data : {data : 'true'},
			type : 'post'
		}).done(function(data){
			if(data.indexOf('OK') >= 0){
				$('#resetM').hide('blind');
				$('#resetMsg').show('blind').html('<span>Please Check your mail for password reset</span>');
			}
		});
	});
