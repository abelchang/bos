$(function () {
	if ( $('[type="date"]').prop('type') != 'date' ) {
		$('[type="date"]').datetimepicker({
			format: 'YYYY/MM/DD',
		});
	}
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