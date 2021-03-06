$(function () {
	if ( $('[type="date"]').prop('type') != 'date' ) {
		$('[type="date"]').datetimepicker({
			format: 'YYYY/MM/DD',
		});
	}


	$(".overDateOrders").hide();
	$("#showOrders").click(function(){
	    $(".overDateOrders").slideToggle("normal",function() {
	    	if($('.overDateOrders').is(':visible')) {
		    	$('#showOrders > span').text("-");
		    } else {
		    	$('#showOrders > span').text("+");
		    }
	    });
	    
	  });
	
});

$(function(){
    $(window).scroll(function() {
        if ( $(this).scrollTop() > 150){
            $('#gotop-right').fadeIn("fast");
            $('#gotop-left').fadeIn("fast");
        } else {
            $('#gotop-right').stop().fadeOut("fast");
            $('#gotop-left').stop().fadeOut("fast");
        }
    });
});

$(function() {      
      //Enable swiping...
      $("#swipePage").swipe( {
        //Single swipe handler for left swipes
        swipeLeft:function(event, direction, distance, duration, fingerCount) {
        	
          $('#nextLink')[0].click();
        },
        swipeRight:function(event, direction, distance, duration, fingerCount) {
        
          $('#previousLink')[0].click();
        },
        //Default is 75px, set to 0 for demo so any distance triggers swipe
        maxTimeThreshold:5000,
        threshold: 200
   	});
});
