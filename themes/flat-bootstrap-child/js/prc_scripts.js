( function( $ ) {

$(document).ready(function(){

	$('#myCarousel').carousel({
	  interval: 5000
	})

	$('.actions-menus .toggle').on('click', function(e){
		$(this).siblings('div').slideToggle();
		e.preventDefault();
		
	});

	$('.slide-right').on('click', function(){
		$('#myCarousel').carousel('next');
		
	});

	$('.slide-left').on('click', function(){
		$('#myCarousel').carousel('prev');
	});	


});	

} )( jQuery );