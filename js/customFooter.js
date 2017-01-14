/**
 * Created by Chig's on 10/19/2016.
 */



 $(document).ready(function () {


    $("#check").click(function() {
        $("#flash").hide();

        var url = $("#url").val();
        var len = url.length;
        $.ajax({
            type: "POST",
            url: "check.php",
            data: { url:url ,len:len}
        }).done(function( data ) {
            if (data.indexOf("OK") >= 0){
                $("#flash").show();
                $("#flash").fadeIn(400).html('<span style ="color:red;" class="load">Already Taken &#9785;</span>');

            }else if(data.indexOf("NG") >= 0){
                $("#flash").show();
                $("#flash").fadeIn(400).html('<span style ="color:green;" class="load">Available &#9786;</span>');
            }
            else if(data.indexOf("NO") >= 0){
                $("#flash").show();
                $("#flash").fadeIn(400).html('<span style ="color:green;" class="load">Please Fill Sometime &#9786;</span>');
            }
            else if(data.indexOf("MO") >= 0){
                $("#flash").show();
                $("#flash").fadeIn(400).html('<span style ="color:green;" class="load">URL MUST be of 8 Character &#9786;</span>');
            }
        });
    });   

    $('#events').hide();

    
    $('#searchInput').on('click', function (e) {
        e.stopPropagation();
        var search = '';
        $('#typesBox').show(500);

        $('#searchBox li').on('click',function(e) {
            e.stopPropagation();
            getEvents(this.id,'id');            
        });
        
        $('#searchInput').on('keyup', function (e) {        
            e.stopPropagation();        
            if (search != '' || search != null) {
                getEvents(this.value,'title');
            }        
        });
    });

    $('#profile').on('click', function (e) {
        e.stopPropagation();
        $('#subMenu').toggle('fold');
    });
    $('#loginMain').on('click',function(e){
        e.stopPropagation();
    });

    $('#loginBox').on('click', function (e) {
        e.stopPropagation();

        $('#loginMain').slideToggle();

    });

    // $('#loginBlock').hide('fold');
    // $('#signUpBlock').show('fold');

    $('#signUpBtn').on('click', function (e) {
        // alert('hi');
        e.stopPropagation();
        $('#loginBlock').hide();
        $('#signUpBlock').show('blind');

    });
    $('#sLoginBtn').on('click', function (e) {
        // alert('hi');
        e.stopPropagation();
        $('#loginBlock').show('blind');
        $('#signUpBlock').hide();

    });

    $(document).on('click',function (e) {
        $('#typesBox').hide('fold');
        $("#subMenu").hide('fold');
        $('#loginMain').slideUp();
        
    }); 


    

});

//      city selection script for creating session in php
function cityse(cty)
{
    $.ajax({
        url:'ajax/session_city.php',
        data : {city : cty},
        type : 'post',
        cache : false,
        success : function (data) {
            // console.log(data);
            location.reload();
        }
    });
}

$('#loginForm').on('submit', function(e){
    e.preventDefault();
    // $('#loadScreen').show();
    $('#errorMsg').slideUp();
    $.ajax({
        url : 'ajax/login.php',
        data : {username : $('#username').val(), password: $('#password').val()},
        type : 'post'        
    }).done(function( data ) {
        // console.log(data);
        if (data.indexOf("OK") >= 0){
            $('#loadScreen').hide();  
            location.reload();              
        }else if(data.indexOf("NO") >= 0){
            $('#loadScreen').hide();
            $('#errorMsg').slideDown().html('<span>Incorrect Username or Password</span>');
        }
    });
});
$('#loginBtn').on('click',function(e){
    e.preventDefault();
    console.log($('#username').val(),$('#password').val());
    $('#loadScreen').show();
    $('#errorMsg').slideUp();
    $.ajax({
        url : 'ajax/login.php',
        data : {username : $('#username').val(), password: $('#password').val()},
        type : 'post'        
    }).done(function( data ) {
        console.log(data);
        if (data.indexOf("OK") >= 0){
            $('#loadScreen').hide();  
            location.reload();              
        }else if(data.indexOf("NO") >= 0){
            $('#loadScreen').hide();
            $('#errorMsg').slideDown().html('<span>Incorrect Username or Password</span>');
        }
    });
});
var signUsername = $('#signUsername'),    
signEmail = $('#signEmail'),    
signMobile = $('#signMobile'),
signPassword = $('#signPassword'),    
signCPassword = $('#signCPassword'),    
signTerm = $('#signTerm'),
signUpBtn1 = $('#signUpBtn1');

var errUsername = $('#errUsername'),
errMail = $('#errEmail'),
errMobile = $('#errMobile'),    
errPassword = $('#errPassword'),
errConfirmPassword = $('#errConfirmPassword');

var msgUsername = "Username already taken",
msgMail = "Invalid Email Address",
msgMail1 = "Email is already in use.",
msgMobile = "Please enter a valid phone number.",
msgPassword = "Password must be greater than 8 characters.",
msgCPassword = "Password doesn't matach.";
//Sign Up Section
function error(id,err,msg){
    id.addClass('errorBorder');
    err.slideDown().html('<span>'+msg+'</span>');          
}

function remove(id,err){
    id.removeClass('errorBorder');
    err.hide('blind');
}
signUsername.on('blur',function () {    
    $.ajax({
        url : 'ajax/signUpValidation.php',
        type : 'post',
        data : {username : this.value}
    }).done(function (data) {
        if(data.indexOf("OK") >= 0){
          error(signUsername,errUsername,msgUsername);
      }else{
        remove(signUsername,errUsername);
    }
});
    

});

signEmail.on('blur',function () {
    // var email = $('#signEmail').val();
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if(!this.value.match(mailformat)){
        error(signEmail,errMail,msgMail);        
    }else {
        remove(signEmail,errMail);
        $.ajax({
            url: 'ajax/signUpValidation.php',
            type: 'post',
            data: {email: this.value}
        }).done(function (data) {
            if(data.indexOf("OK") >= 0){
                error(signEmail,errMail,msgMail1);
            }else {
                remove(signEmail,errMail);
            }
        });
    }    
});

signMobile.on('blur',function () {
    var num = this.value;
    intRegex = /[0-9 -()+]+$/;
    if((num.length < 10) || (!intRegex.test(num))) {
        error(signMobile,errMobile,msgMobile);
    }else{
        remove(signMobile,errMobile);
    }
});

signPassword.on('blur',function () {
    var pass = this.value;

    if(pass.length < 8){
        error(signPassword,errPassword,msgPassword);        
    }else{
        remove(signPassword,errPassword);
    }
});

signCPassword.on('blur',function () {
    var cpass = this.value;
        // pass = $('#signPassword').val();

        if(signPassword.val() !== cpass){
            error(signCPassword,errConfirmPassword,msgCPassword);
        }else{
            remove(signCPassword,errConfirmPassword);
        }
    });

signTerm.on('click',function(){
    if(!this.checked){
        signTerm.css('outline','1px solid #c00');
    }else{
        signTerm.css('outline','0px solid #c00');
    }
});

$('#signUpForm').submit(function (e) {    
    e.preventDefault();
    msg = "required";
    if(signUsername.val() == '' || 
        signEmail.val() == '' || 
        signMobile.val() == '' || 
        signPassword.val() == '' || 
        signCPassword.val() == '' ||
        signTerm.checked){

        if(signUsername.val() == ''){
            error(signUsername,errUsername,msg);
        }
        if(signEmail.val() == ''){
            error(signEmail,errMail,msg);
        }
        if(signMobile.val() == ''){
            error(signMobile,errMobile,msg);
        }
        if(signPassword.val() == ''){
            error(signPassword,errPassword,msg);
        }
        if(signCPassword.val() == ''){
            error(signCPassword,errConfirmPassword,msg);
        }
        if(signTerm.checked){
            signTerm.css('outline','1px solid #c00');
        }
    }else {     
        $('#loadScreen').show();             
        $.ajax({
            url : 'ajax/signUp.php',
            type : 'post',
            cache: false,
            contentType: false,
            processData: false,
            data : new FormData(this)            
        }).done(function(data){
            // console.log(data);
            if(data.indexOf('OK') >= 0){
                $('#loadScreen').hide();  
                location.reload();
            }
        });
    }

});

//End of Sign Up section

// Change Image div on upload
$(function() {
    $("#file-2").on("change", function()
    {
        $('#doneBtn').css('display','inline-block');
        var files = !!this.files ? this.files : [];

        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
            // console.log(files[0]);
            // console.log(reader.readAsDataURL(files[0]));
            reader.onloadend = function(upImg){ // set image data as background of div
                $("#imagePreview").css("background-image", "url("+this.result+")");                                
                urlValue = this.result;
                
                var image = new Image();                
                image.src = upImg.target.result;

                image.onload = function() {
                    if($('#uploadBanner').length){
                        if(this.height > 410 || this.height < 390){                            
                            $('#errorImage').show('blind');
                            $('#uploadBanner').hide('blind');
                            $('#doneBtn').hide();                            
                            $('#bannerBtn').removeClass('hidden').show('blind');
                        }else{       
                            $('#errorImage').hide('blind');
                            $('#uploadBanner').hide('blind');
                            $('#bannerBtn').removeClass('hidden').show('blind');
                            $('#doneBtn').css('display','inline-block');
                        }
                    }
                };

                // document.getElementById("labelPic").innerHTML = "Choose Other";
                // $("#upbtnPic").css("display" , "block");    
            }
                // var i = new Image();
                // i.onload = function(){
                // };

                // i.src = reader; 
            }


        });
});


function selectCities(id){          
    var selectCity = $('#selectCity'+id),
    showCity = $('#showCity'+id),           
    backResult = $('#back_result'+id),
    addCity = $('#addCity'+id),
    hiddenCity = $('#hiddenCity'+id);
            // console.log($('#listCities1 li'));

            $(this).val('');
            addCity.hide();
            showCity.show('blind');
            selectCity.on('keyup',function(){                       
                $.ajax({
                    url : 'ajax/getCities.php',
                    type : 'post',
                    data : {data : this.value},
                    success : function(data){
                        backResult.html(data);
                        $('#listCities'+id+' li').each(function(i){

                            $("#"+this.id).on('click',function(){
                                if(this.id == 'addOtherCity'){
                                    showCity.hide('blind');
                                    addCity.show('blind');
                                }else {
                                    showCity.hide('blind');
                                    selectCity.val($(this).attr('value'));
                                    hiddenCity.val(this.id);

                                    if(filename === 'create_event'){
                                        ajaxCall('event_city_id',this.id,load='',id='');
                                    }
                                }               

                            });
                        });
                    }
                });
            });
        }

        function statesData(id,countryId){  
            var states = $('#states'+id);

            states.addClass('loadingState');
            $.post('ajax/getState.php', {coId : countryId}, function(data){
                states.prop('disabled',false).html(data);
                states.removeClass('loadingState');
            }); 
        }
        function cityName(id){
            $('#cityname'+id).prop('disabled', false).focus();
        }   
        function addCities(id){
            var addCityBtn = $('#addCityBtn'+id),
            btnIcon = $('#btnIcon'+id),
            addCity = $('#addCity'+id),
            hiddenCity = $('#hiddenCity'+id),
            selectCity = $('#selectCity'+id);

            addCityBtn.addClass('loadingState');
            btnIcon.hide();
            var co = {};
            co['country'] = $('#country'+id).val();
            co['state'] = $('#states'+id).val(); 
            co['city'] = $('#cityname'+id).val();
        // console.log(co);
        $.ajax({
            url : 'ajax/addCity', 
            data : {data : co},
            dataType : 'JSON', 
            type : 'POST',
            success: function(data){                
                addCity.hide('blind');              
                hiddenCity.val(data['cityId']);
                selectCity.val(data['city']);
                // $('#country'+id).re();
                // co['state'] = $('#states'+id).val(); 
                // co['city'] = $('#cityname'+id).val();
            }
        });
    }

    function checkCity(id,cityName){
        var addCityBtn = $('#addCityBtn'+id),
        cityname = $('#cityname'+id);
        if(cityName > ''){
            addCityBtn.show();
        }else{
            addCityBtn.hide();
        }
    }




// lo();

//Payment code
var payEmail = $('#payEmail'),
payErrMail = $('#payErrMail'),
payMobile = $('#payMobile'),
payErrMobile = $('#payErrMobile'),
payTerms = $('#payTerms')
payBtn = $('#payBtn');

payEmail.on('blur',function(){
    console.log(this.value.replace(/\@.*/,''));

    remove(payEmail,payErrMail);
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;    
    if(!this.value.match(mailformat)){
        error(payEmail,payErrMail,msgMail);        
    }else{
        var value = this.value;
        $.ajax({
            url : 'ajax/paymentUser.php',
            data : {newUser : value},
            type : 'post',
        }).done(function(data){
            // console.log(data);
            if(data.indexOf('OK') >= 0){
                $('#payBtn').prop('disabled',false);
            }else if(data.indexOf('same') >= 0){
                error(payEmail,payErrMail,'Email address already in use.'); 
            }
            // console.log(value.replace(/@[a-zA-Z]/g, ''));
            $('#firstname').val(value.replace(/\@.*/,''));
        });
    }    
});

payMobile.on('blur',function(){
    remove(payMobile,payErrMobile);
    var num = this.value;
    if(payEmail.val() == '' || payEmail.val() == null){
        error(payEmail,payErrMail,'These Field is Required');  
    }
    intRegex = /[0-9 -()+]+$/;

    if((num.length < 10) || (!intRegex.test(num))) {
        error(payMobile,payErrMobile,msgMobile);
    }else{
        remove(payMobile,payErrMobile);
        $.ajax({
            url : 'ajax/paymentUser.php',
            type : 'post',
            data : {newMobile : num, email : payEmail.val()}
        }).done(function(data){
            // console.log(data);
            // if(data.indexOf('same') >= 0){
            //     error(payMobile,payErrMobile,'Mobile Number is already in use.');
            // }
        });
    }

});

payTerms.on('click',function(){
    if(!this.checked){
        payTerms.css('outline','1px solid #c00');
    }else{
        payTerms.css('outline','0px solid #c00');
    }
});

// function submitPayuForm() {  
//         // e.preventDefault();

//     // console.log(hash);

//     if(hash == '') {
//       return;
//     }

//     var payuForm = document.forms.payuForm;  

//     payuForm.submit(function(e){

//         $("#load_screen").css('display','block');

//         // load_screen.style.display = 'block';
//     });

// }

payBtn.on('click', function(){        
    $('#load_screen').css('display','block');
    $.ajax({
        url : 'ajax/tryAgain.php',
        data : {try : 'try'},
        type : 'post',
        success : function(data){
            console.log(data);
        }
    });
});

// Menu Sliding script
$('#right-button').click(function() {
  event.preventDefault();
  $('#content').animate({
    marginLeft: "-=200px",
    marginRight: "+=200px"
}, "fast");
});
$('#left-button').click(function() {
  event.preventDefault();
  $('#content').animate({
    marginLeft: "+=200px",
    marginRight: "-=200px"
}, "fast");
});


$('#mobileBtn').on('click', function () {
    $('#mobileBtn').addClass('loadingButton').attr('disabled',true);
    email = $('#fbEmail').val();
    mobile = $('#mobileNum').val();
    var errMobile = $('#errMobile'),
    mobileNum = $('#mobileNum');    

    intRegex = /[0-9 -()+]+$/;

    if((mobile.length < 10) || (!intRegex.test(mobile))) {
        error(mobileNum,errMobile,'Incorrect Mobile Number');
    }else{        
        remove(mobileNum,errMobile);
        $.ajax({
            url : 'ajax/paymentUser.php',
            type : 'post',
            data : {newMobile : mobile, email : email, verify : 'verify'},
            success : function(data){
                // console.log(data);
                if(data.indexOf('OK') >= 0){
                    $('#mobileDiv').hide();
                    $('#otpDiv').show();
                    $('#verifyMobile').html(mobile);                
                }
            }
        });
    }
});

$('#verifyBtn').on('click', function(){
    var otp = $('#verifyOtp').val(),
    errOtp = $('#errOtp'),
    verifyOtp = $('#verifyOtp');
    intRegex = /[0-9 -()+]+$/;

    if((otp.length < 6) || (!intRegex.test(otp))) {
        error(verifyOtp,errOtp,'Enter Valid OTP!!!');
    }else{
        $.ajax({
            url : 'ajax/paymentUser.php',
            type : 'post',
            data : {otp : otp},
            success : function(data){   
                console.log(data);
                if(data.indexOf('OK') >= 0){                
                    $('#verifyBox').empty().html('Thank You!!');
                    window.setTimeout(function(){     
                        $('#verifyOtp, #verifyBtn').hide('blind');
                        $('#mobileBox').css('display','none');
                        $('#mobileFade').hide('blind');
                    },1200);                    
                }else if (data.indexOf('NO') >= 0){
                    error(verifyOtp,errOtp,'Invalid! Try Again.');                    
                }
            }
        });
    }
});

$('#closePop').on('click', function(){
    $('#newUserBox').css('display','none');
    $('#mobileFade').hide('blind');
});