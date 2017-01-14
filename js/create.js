var num=1;
url = document.location.href;
var index = url.lastIndexOf("/") + 1;
var filenameWithExtension = url.substr(index);
var filename = filenameWithExtension.split(".")[0];  
var divs = { '#aboutEvent':'Write brief Description about the Event...',
                '#eventTitle':'Add Event Title...',
                '#eventAddress':'Event Address',
                '#eventEmail':'Organiser Email ID',
                '#eventFacebook':'Enter Facebook Link...',
                '#eventTwitter':'Enter Twitter Link...'};

var inputs = {'#eventCategory':'-1',
                '#selectCity1':'-1'};
var neglact = ['#eventFacebook',
                '#eventTwitter'];

var Delta = Quill.import('delta');
var toolbarOptions = [
  ['bold', 'italic', 'underline'],        // toggled buttons          
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],               
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  ];

var description = new Quill('#description', {
    modules: {
        toolbar: toolbarOptions
    },
    placeholder: 'Enter Event Description',
  theme: 'snow', // or 'bubble'       
});
var terms = new Quill('#terms', {
    modules: {
        toolbar: toolbarOptions
    },
    placeholder: 'Enter Terms & Conditions',
    theme: 'snow', // or 'bubble'       
});
// Store accumulated changes     
var change = new Delta(),
html = '';

description.on('text-change', function(delta) {
    change = change.compose(delta);  
    html = document.querySelector(".ql-editor").innerHTML;
    html = html.replace(/"/g, '\\"');     
    ajaxCall('description',html,'');

}); 

terms.on('text-change', function(delta) {
    change = change.compose(delta);  
    html = document.querySelector("#terms .ql-editor").innerHTML;
    html = html.replace(/"/g, '\\"');         
    ajaxCall('e_terms',html,'');

}); 


$(document).ready(function(){    
    $.get("ajax/getPreviousData.php?terms",function(html){
        terms.pasteHTML(html);
    });         
    $.get("ajax/getPreviousData.php?description",function(html){
        description.pasteHTML(html);
    });         
	$('#addTicket').on('click',function() { 
        i = $('#totalTickets').val();
        i++;                 
        $.ajax({
            url : 'ajax/insertTickets.php',
            type : 'post',
            data : {new : 'new'},
            dataType : 'JSON',
            success : function(data){                
                if(data['verify'].indexOf("OK") >= 0 ){                      
                    $('#ticketsCol').show('blind').append('<div class="ticket1" id="'+data['tId']+'">'
                        +'<i class="fa fa-times-circle delete closebtn" onclick="deleteTicket($(this).closest(\'div\').prop(\'id\'));" aria-hidden="true"></i>'
                        +'<div class="ticket-borderTop"> </div>'
                        +'<div class="ticket-div-content">'
                            +'<div class="ticket-cont_main">'                              
                                +'<div class="ticket-eventCatName" style="color: grey">'
                                    +'<div class="ticketName">'
                                        +'<span id = "lticketName'+i+'">Ticket Title - </span>'
                                        +'<input type = "text" title = "Enter Ticket Name" name = "" id = "ticketName'+i+'" onkeyup = "insertData(this.value,this.id,'+data['tId']+');" onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');" placeholder = "Enter Ticket Name" onblur = "labelHide(this.id,\'drop\');">'
                                    +'</div>'
                                    +'<div class="clear"></div>'
                                    +'<div class="ticket-tckdesc" >'
                                        +'<span id = "lticketDescription'+i+'">Ticket Description - </span>'
                                        +'<input type = "text" title = "Enter Description for Ticket" name = "" id = "ticketDescription'+i+'" onkeyup = "insertData(this.value,this.id,'+data['tId']+');" placeholder= "Enter Ticket description"   onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');"  onblur = "labelHide(this.id,\'drop\');">'             
                                    +'</div>'
                                    +'<div  class="ticket-lastdate" >'                                     
                                        +'<span class= "ticSpan">Available from - </span>'
                                        +'<input class= "ticDate" title = "Enter Start date for Tickets" type="text" id="ticketStart_date'+i+'" placeholder="Tickets Available from..." onclick="getDate(this.id);" onfocus="getDate(this.id);" style="" onchange = "insertData(this.value,this.id,'+data['tId']+');" placeholder="Tickets Available from" onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');" onblur = "labelHide(this.id,\'drop\');">'
                                        +'<span class= "ticSpan">Available Till - </span>'
                                        +'<input class= "ticDate" title = "Enter Last date for Tickets" type="text" id="ticketLast_date'+i+'" placeholder="Tickets Available till..." onclick="getDate(this.id);" onfocus="getDate(this.id);" style="" onchange = "insertData(this.value,this.id,'+data['tId']+');" placeholder="Tickets Available till" onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');" onblur = "labelHide(this.id,\'drop\');">'
                                    +'</div>'
                                +'</div>'
                                +'<div class="ticket-eventCatValue">'
                                    +'<span id = "lticketPrice'+i+'">Ticket Price - </span>'
                                    +'<input type = "text" title = "Enter Price for Ticket" style = "text-align:center;width: 100%" name = "" id = "ticketPrice'+i+'" onkeyup = "insertData(this.value,this.id,'+data['tId']+');" onclick = "change(this.id,\'blind\');" onfocus = "change(this.id,\'blind\');" placeholder = "Enter Price"  onblur = "labelHide(this.id,\'blind\');">'
                                +'</div>'                                                     
                                +'<div class="ticket-eventCatSelect">'
                                    +'<div>'
                                        +'<span id = "lticketTotal'+i+'">Total Tickets - </span>'
                                        +'<input type = "text" title = "Enter Total Available Tickets to be Sold" id="ticketTotal'+i+'"  class="tquantity" onkeyup = "insertData(this.value,this.id,'+data['tId']+');"  onfocus = "change(this.id,\'blind\');" onclick = "change(this.id,\'blind\');" placeholder = "Total Tickets"  onblur = "labelHide(this.id,\'blind\');">'
                                    +'</div>'
                                    +'<div >'
                                        +'<span id = "lticketMax'+i+'">Max Tickets - </span>'
                                        +'<input type="text" title = "Enter Max Allowed Tickets to be Purchased by Customer at a Time"  class="tquantity" id="ticketMax'+i+'" onkeyup = "insertData(this.value,this.id,'+data['tId']+');"  onfocus = "change(this.id,\'blind\');" onclick = "change(this.id,\'blind\');" placeholder = "Max Tickets allow to book"  onblur = "labelHide(this.id,\'blind\');">'
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>'                  
                        +'<div class="clear"></div>'                
                        +'<div class="ticket-borderBottom"></div>'                
                    +'</div>');
                    $('#totalTickets').val(i);
                }
            }
        });

    });  
})
function getVal()
{      
    var eventTitleT = $("#eventTitleT").val();
    var bookDate = $("#bookDate").val();
    // var sdate = $("#sdate").val();
    // var edate = $("#edate").val();
    // var u = location.pathname.substring(location.pathname.lastIndexOf("/") + 1).split(".")[0];
    url = 'ajax/getVal.php';    
    $("#show").empty();
    $.ajax({
        url : url,
        type: 'POST',
        data : {eventTitleT: eventTitleT, bookDate : bookDate},
        cache:true,
        success: function(html){
            $("#show").append(html);
        }
    });
}

var evTime1 = $('#evTime1').val() != '' ? $('#evTime1').val() : '';
    evTime1 = evTime1.replace( /(AM|PM)/g, '' );
var evTime2 = $('#evTime2').val() != '' ? $('#evTime2').val() : '';
    evTime2 = evTime2.replace( /(AM|PM)/g, '' );


$('#eventTime1').wickedpicker({ now : evTime1});
$('#eventTime2').wickedpicker({ now : evTime2});

function deleteTicket(id){
    $.ajax({
        url : 'ajax/insertTickets.php',
        type : 'post',
        data : {delete : 'delete', tId : id},
        success : function(data){
            if(data.indexOf("OK") >= 0){
                $('#'+id).effect('drop',400);
            }
        }
    })
}

function getDate(id){
    // var avail = id.replace(/[A-Za-z_]/g,'');

    // var date = "#ticketLast_date"+id;
    //     avail = '#lticketLast_date'+id,
    //     date = "#ticketLast_date"+id;
    //     avail = '#lticketLast_date'+id;
    var date = '#'+id,
        avail = '#l'+id;
        // console.log(avail);
    $(date).datepicker({ minDate: 0, }); 
    $(date).datepicker( "option", "dateFormat", "d M, yy");
    $(date).datepicker("show").removeAttr('placeholder');
    // $(avail).show('fold');
}  


 $( function() {
    var from = $( "#eventFrom" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
          dateFormat : "d M, yy"
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#eventTo" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat : "d M, yy"
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( "d M, yy", element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
function labelHide(id,effect){    
    $('#l'+id).hide(effect)    
    var newId = id.replace(/\d+/g, '');
    if(newId == 'ticketName'){
        $('#'+id).attr('placeholder','Enter Ticket Title');        
    }else if(newId == 'ticketDescription'){
        $('#'+id).attr('placeholder','Enter Ticket Description');
    }else if(newId == 'ticketLast_date'){
        $('#'+id).attr('placeholder','Tickets Available from');        
    }else if(newId == 'ticketPrice'){
        $('#'+id).attr('placeholder','Enter Price');        
    }else if(newId == 'ticketMax'){
        $('#'+id).attr('placeholder','Max Tickets allow to book');        
    }else if(newId == 'ticketTotal'){
        $('#'+id).attr('placeholder','Total Tickets');        
    }
}

function insertData(value,id,e){
    // change(id);
    // console.log(value,id.replace(/[0-9]/g,'').replace(/ket/g,'_'),e);
    $.ajax({
        url : 'ajax/insertTickets.php',
        type : 'post',
        data : {update : e,field : id, val : value}
    });
}
    

function ajaxCall(field,data,load, id){    
    load != '' ? $('#'+load).show() : '';    
    $.ajax({
        url : 'ajax/eventData.php',
        type : 'post',
        data : {field : field, data : data, id : id},
        success : function(data){
            load != '' ? $('#'+load).hide() : '';            
        }
    });
}


$('#confirmImage').on('submit',function(e){
    $('#bannerBtn').hide('blind');
    $('#uploadLoader').show('blind');
    e.stopPropagation();
    e.preventDefault();
    var da = new FormData(this);

    $.ajax({
        url : 'ajax/eventData.php',
        type : 'post',
        data : da,
        contentType: false,
        processData: false,
        success :function(data){
            if(data.indexOf('OK') >= 0){
                $('#uploadLoader').hide('blind');
                $('#bannerBtn').show('blind');
                $('#doneBtn').hide();
            }else if(data.indexOf('NO') >= 0){
                $('#uploadLoader').hide('blind');
                $('#errLaMsg').show('fold');
                $('#bannerBtn').show('blind');
            }
        }
    });

});


function getDivData(name,id,load){
    id = '#'+id;        
    if($.trim($(id).html()) === divs[id]){
        $(id).html('');
    }else{
        ajaxCall(name,$.trim($(id).html()),load);
    }
    
}

function getInputData(name,id,load){            
    id = '#'+id;
    ajaxCall(name,$(id).val(),load,id);
}

function change (id,effect){    
    $('#'+id).css('color','black').removeAttr('placeholder');
    $("#l"+id).show(effect);            

}

function blurDiv(id){
    $('#'+id).css('color','#c4c4c4');
    // if(id == "eventTitle" && $.trim($(id).html()) == ''){        
    //     $('#'+id).html('Add Event Title...');
    // }else if(id == "aboutEvent" && $.trim($(id).html()) == ''){
    //     $('#'+id).html('Write brief Description about the Event...');        
    // }else if(id == "eventTerms" && $.trim($(id).html()) == ''){
    //     $('#'+id).html('Please add Events Terms and Conditions');        
    // }
}

function chkEmpty(id,msg,type){    

    // console.log(id,$.inArray(id,neglact));

    if($.inArray(id,neglact) < 0){

        if(type === 'div'){        
            // console.log(id);
            if($.trim($(id).html()) === '' || $.trim($(id).html()) === msg){
                $(id).css('border','1px solid rgba(255, 0, 0, 0.79)');
            } else{

                $(id).css('border','');            
            }  
        }        
    }
    if(type === 'input'){
        if($(id).val() === '' || $(id).val() === msg){
            
            $(id).css('border','1px solid rgba(255, 0, 0, 0.79)');
        }else{
            $(id).css('border','');

        } 
    }
    
}


// Publish Event
$('#publishBtn').on('click',function(){     
    if($.trim($('#aboutEvent').html()) === '' || $.trim($('#aboutEvent').html()) === divs['#aboutEvent'] ||
        $.trim($('#eventTitle').html()) === '' || $.trim($('#eventTitle').html()) === divs['#eventTitle'] ||
        $('#eventCategory').val() === -1 || 
        $('#selectCity1').val() === '' ||
        $.trim($('#eventEmail').html()) === '' || $.trim($('#eventEmail').html()) === divs['#eventEmail'] ||
        $.trim($('#eventAddress').html()) === '' || $.trim($('#eventAddress').html()) === divs['#eventAddress']
        ){                            
            for(var i in divs)
            {
                chkEmpty(i,divs[i],'div');    
            }
            for(var i in inputs)
            {
                chkEmpty(i,inputs[i],'input');    
            }
            $('#pubMsg').show('blind').html('<span class = "pubSuccess">Please Fill all Required Fields !!!</span>'); 
            window.setTimeout(function(){
                $('#pubMsg').hide('blind'); 
            },5000);
    }else{            
        for(var i in divs)
        {
            chkEmpty(i,divs[i],'div');    
        }
        for(var i in inputs)
        {
            chkEmpty(i,inputs[i],'Input');    
        }
               
        $.ajax({
            url : 'ajax/eventData.php',
            type : 'post',
            data : {field : "status", data : "0", id : ""},
            success : function(data){                
                if(data.indexOf('OK') >= 0){    
                    $('#pubMsg').show('blind').html('<span class = "pubSuccess">Your Event is Published !!</span>'); 
                    window.setTimeout(function(){
                        $('#pubMsg').hide('blind'); 
                    },5000);       
                }else if (data.indexOf('ON') >= 0){
                    $('#pubMsg').show('blind').html('<span class = "pubFailure">Something Went Wrong Please Try Again !!</span>');
                    window.setTimeout(function(){
                        $('#pubMsg').hide('blind'); 
                    },5000);
                }
            }
        });    
    }
    
});
// End of Publish Event