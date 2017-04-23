$(function(){

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.statusAjax').click(function() {
    $.ajax({
        url: $(this).data("url"),
        data: {
        	orderID: $(this).data("id"),
            orderStatus: $(this).data("value"),
        },
        type: "POST",
        dataType: "json",
        success: function(data,statusTxt,xhr) {
            $('#status'+data.id).html(data.status);
        },
        error: function(data,statusTxt,xhr) {
            console.log("fail"+statusTxt+xhr);
        },
        complete: function() {
        } 
    });
});
 
});