$('#help').on('click',function(){
	$('body').css('overflow', 'hidden');
	$('#fade2').show();
});

$('#imagePreviewIns').on('click', function(){
	id = '#'+this.id.replace(/Ins/g,'');	
	$('#instruction').css('display','none');
	$('#bannerIns').show();
	$(id).addClass('makeUpper').focus();
});
$('#eventDescriptionIns').on('click', function(){
	$('#imagePreview').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');
	$('#bannerIns').css('display','none');
	$('#eventDescriptionDiv').show();
	$(id).addClass('makeUpper').css('background','beige').focus();
});

$('#eventTitleIns').on('click', function(){
	$('#eventDescription').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('#eventDescriptionDiv').css('display','none');
	$('#eventTitleDiv').show();
	$(id).addClass('makeUpper').focus();
});

$('#ticketDataIns').on('click', function(){	
	$('html,body').animate({scrollTop: $("#ticketData").offset().top},'slow');     
	$('body').css('overflow', 'hidden');
	$('#eventTitle').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('#eventTitleDiv').css('display','none');
	$('#ticketDataDiv').show();
	$(id).addClass('makeUpper');
	$('#ticketName1').focus();
});

$('#addTicketIns').on('click', function(){		
	$('#ticketData').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('#ticketDataDiv').css('display','none');
	$('#addTicketDiv').show();
	$(id).addClass('makeUpper').focus();
});

$('#eventTermsIns').on('click', function(){		
	$('#addTicket').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('#addTicketDiv').css('display','none');
	$('#eventTermsDiv').show();
	$(id).addClass('makeUpper').focus();
});


$('#eventCategoryIns').on('click', function(){	
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-90},'slow');	
	$('#eventTerms').removeClass('makeUpper');
	$('#eventTermsDiv').css('display','none');
	$('#eventCategoryDiv').show();
	$('#details').addClass('makeUpper');
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake","slow" ).focus();
});

$('#eventFromIns').on('click', function(){	
	// $('#eventCategory').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-90},'slow');	
	$('#eventCategoryDiv').css('display','none');
	$('#eventFromDiv').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#eventToIns').on('click', function(){	
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-90},'slow');	
	// $('#eventFrom').removeClass('makeUpper');
	$('#eventFromDiv').css('display','none');
	$('#eventToDiv').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#eventTime1Ins').on('click', function(){	
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-90},'slow');	
	// $('#eventTo').removeClass('makeUpper');
	$('#eventToDiv').css('display','none');
	$('#eventTime1Div').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#eventTime2Ins').on('click', function(){	
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-90},'slow');	
	// $('#eventTime1').removeClass('makeUpper');
	$('#eventTime1Div').css('display','none');
	$('#eventTime2Div').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#eventAddressIns').on('click', function(){	
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-100},'slow');	
	// $('#eventTime1').removeClass('makeUpper');
	$('#eventTime2Div').css('display','none');
	$('#eventAddressDiv').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#selectCity1Ins').on('click', function(){	
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-100},'slow');	
	// $('#eventTime1').removeClass('makeUpper');
	$('#eventAddressDiv').css('display','none');
	$('#selectCity1Div').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#eventEmailIns').on('click', function(){	
	// $('#eventTime1').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-100},'slow');	
	$('#selectCity1Div').css('display','none');
	$('#eventEmailDiv').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});
$('#eventFacebookIns').on('click', function(){	
	// $('#eventTime1').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-10},'slow');	
	$('#eventEmailDiv').css('display','none');
	$('#eventFacebookDiv').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});
$('#eventTwitterIns').on('click', function(){	
	// $('#eventTime1').removeClass('makeUpper');
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-10},'slow');	
	$('#eventFacebookDiv').css('display','none');
	$('#eventTwitterDiv').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#publishBtnIns').on('click', function(){	
	id = '#'+this.id.replace(/Ins/g,'');	
	$('html,body').animate({scrollTop: $(id).offset().top-400},'slow');	
	$('#details').removeClass('makeUpper');
	$('#eventTwitterDiv').css('display','none');
	$('#publishData').addClass('makeUpper');
	$('#publishBtnDiv').show();
	$(id).css({'background':'beige','padding':'1%'}).effect( "shake" ).focus();
});

$('#publishBtn,#tutCancel,.skip').on('click', function(){
	
	$('body').css('overflow-y', 'scroll');
	$('#fade2').css('display','none');
});