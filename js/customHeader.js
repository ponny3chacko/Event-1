/**
 * Created by Chig's on 10/19/2016.
 */

// Geting current timezone
function timeZone()
{
    // Getting Current Timezone Offset
    var Cookies = {};
    var expires ='';
    Cookies.create = function (name, value, days)
    {
        if (days)
        {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else
        {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
        this[name] = value;
    };
    var now = new Date();

    return Cookies.create("GMT_bias",now.getTimezoneOffset(),1);
    // End Getting Current Timezone Offset
}


    // timeZone();

function getEvents(value,type){

        $('#searchInput').addClass('loadinggif');
        $('#events').show(500);

        $.ajax({
            url : 'ajax/searchEvents.php',
            type : 'post',
            data : {value : value,type : type},
            success : function (data) {
                
                $('#searchInput').removeClass('loadinggif');
                $('#allEvents').html(data);

                $('#allEvents li').on('click', function () {
                    $('#searchInput').val($(this).text());
                    $('#typesBox').hide(300);
                    $('#eventHidden').val(this.id);
                    var currentLocation = window.location;
                    // console.log(currentLocation);
                    window.location.href = '../Show/'+$(this).text().replace(/\s/g,'-')+'/'+this.id;
                    var load_screen = document.getElementById("load_screen") ;
                    load_screen.style.display = 'block';
                    
                    // $('#searchbtn').prop('disabled', false);
                });
            }
        });
    }

    //  script for calculating total booking amount
    function lo(ticid) {

        var ticIds = new Array();
        var sum = 0;
        var mul = 0;
        var qty = 0;    
        var detail = '';
        var d  = new Array();
        var ticQty = new Array();

        var co = $("#count").val();
        for (var i = 0; i < co; i++) {
            var qtyS = parseInt($("#quantity" + i).val());
            mul = $("#price" + i).val() * qtyS;

            sum = sum + mul;
            qty = qty + qtyS;
            if(qtyS > 0){
                d.push( qtyS + " " + $('#ticketName'+i).html());                        
                ticQty.push(qtyS);
                var index = ticIds.indexOf(ticid);
                if (index > -1) {
                   ticIds.splice(index, 1);
                }else{
                    ticIds.push(ticid);
                }
            }                
        }
        $('#show').html('<span class="load">'+sum+'</span>');

        // var index = ticIds.indexOf(ticid);
        // if (index > -1) {
        //    ticIds.splice(index, 1);
        // }else{
        //     ticIds.push(ticid);
        // }
        // console.log(ticIds);
        if(ticIds.length > 0){
            $.ajax({
                url : 'ajax/ticketData.php',
                data : {price : sum, qty : qty, details : d, ticids : ticIds, ticqty : ticQty},
                type : 'POST',
                success : function(data){
                    // console.log(data);
                }
            });
        }
        if(qty >= 1){
            $('#bookBtn').prop('disabled',false);
        }else{
            $('#bookBtn').prop('disabled',true);
        }
    }