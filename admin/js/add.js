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
            url : '../ajax/getCities.php',
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
    $.post('../ajax/getState.php', {coId : countryId}, function(data){
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
        url : '../ajax/addCity', 
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

$('#selectUser').on('click focus',function(){
    var showUser = $('#showUser'),           
        listUser = $('#listUser'),
        hiddenUser = $('#hiddenUser');
        // console.log($('#listCities1 li'));

    $(this).val('');    
    showUser.show('blind');    
    $(this).on('keyup',function(){                       
        $.ajax({
            url : 'ajax/getUser.php',
            type : 'post',
            data : {data : this.value},
            success : function(data){
                listUser.html(data);
                $('#listUser li').each(function(i){                
                    $("#"+this.id).on('click',function(){
                        
                        showUser.hide('blind');
                        $('#selectUser').val($(this).attr('value'));
                        hiddenUser.val(this.id.replace('user-',''));

                    });
                });
            }
        });
    });
});

$('#eventForm').on('submit', function(e){
    e.preventDefault();
    var data = new FormData(this)    
    $.ajax({
        url : 'ajax/addEvent.php',
        type : 'post',
        data : data,
        processData : false,
        contentType : false,
        success : function(data){
            if(data.indexOf('OK') >= 0 ){
                $('#message').html('Event Generated Successfully');
                window.setTimeout(function(){
                    $('#message').hide('blind');
                },5000);
            }else {
                $('#message').html('Something went Wrong please check details again');
                window.setTimeout(function(){
                    $('#message').hide('blind');
                },5000);
            }
        }
    })
});