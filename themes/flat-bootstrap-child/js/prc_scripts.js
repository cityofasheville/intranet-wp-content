( function( $ ) {

$(document).ready(function(e){

	$('#myCarousel').carousel({
	  interval: 5000
	});

	var slide_height = $('.item.active').height();

	$('.carousel-inner').animate({height: slide_height }, 500);

	$('#myCarousel').on('slid.bs.carousel', function (e) {
		slide_height = $('.item.active').height(); 
		$('.carousel-inner').animate({height: slide_height }, 500);
		console.log(slide_height);
	});	

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