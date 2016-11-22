jQuery(document).ready(function($){

	console.log("Let's do this");

	$('.filter h3').click(function(){
		console.log('Clicked!');
		$(this).next('ul, form, fieldset').slideToggle('fast');
		$(this).toggleClass('open');
	});

}); //end doc ready