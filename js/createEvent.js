$(document).ready(function(){
	// Clone of Ticket Divs
    var num=0;
    $('#doit').click(function(){
        // console.log($('klon1').html());
        // get the last DIV which ID starts with ^= "klon"
        var $div = $('div[id^="klon"]:last');   
        // Read the Number from that DIV's ID (i.e: 3 from "klon3")
        // And increment that number by 1
        num1 = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
        // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
        var $klon = $div.clone().prop('id', 'klon'+num1 );
        num = num1;
        // Finally insert $klon wherever you want
        $div.after( $klon );

    });

    var data = {};
    data['name'] = [];
    data['description'] = [];
    data['lastdate'] = [];
    data['price'] = [];
    data['max'] = [];
    // console.log(num);
    // for(var i = 0; i <num; i++){
    //     $('#deleteTicket\\[\\]').on('click',function(){
    //         alert('click on '+i);
    //     });  
    // }

    $('#getData').on('click',function(){
        for(i = 0; i <num; i++){
            data['name'].push(JSON.stringify($.trim($('#ticketName\\[\\]').eq(i).html())));
            data['description'].push(JSON.stringify($('#ticketDes\\[\\]').eq(i).html()));
            data['lastdate'].push(JSON.stringify($('#ticketLastDate\\[\\]').eq(i).html()));
            data['price'].push(JSON.stringify($('#ticketPrice\\[\\]').eq(i).html()));
            data['max'].push(JSON.stringify($('#ticketMax\\[\\]').eq(i).html()));
        }       
        $.post('ajax/insertTickets.php',{data : data}, function(data){
            console.log(data);
        });
    });  
});

function ajaxCall(field,data){    
    $.ajax({
        url : 'ajax/eventData.php',
        type : 'post',
        data : {field : field, data : data},
        success : function(data){
            // $('#editAbout').removeClass('loadingSpan');
            // console.log(data);
        }
    });
}

function getdata(name,id){
    // id = id.replace(/\[.*?\]/g, "\\\[\\\]");      
    // var data = $('#'+id).html();
    console.log(id+name);
}

function getdatad(d){
    console.log(d);
}
var eventTitle = $('#eventTitle'),
    aboutEvent = $('#aboutEvent');

function change (id){

    $('#'+id).css('color','black');

}
// aboutEvent.on('click', function () {
    
//     aboutEvent.css('color','black');
//     aboutEvent.on('keyup',function(){
//         // $('#editAbout').html('saving..');
//         // $('#editAbout').addClass('loadingSpan');                
//         var data = aboutEvent.html();

//         ajaxCall('description',data);
        
//     });
// });

eventTitle.on('click', function () {    
    var data =$.trim(eventTitle.text());

    eventTitle.on('keyup',function(){
        ajaxCall('title',data);
    });
    
});
