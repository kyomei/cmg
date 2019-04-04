$(function(){
	var reset = $('#reset-senha').bind('click', function(){
		$('#form-login').hide(1000);
		$('#create-account').hide(1000);
		$('.form-reset').show(1000);
		/*
		$('#form-login').addClass('hidden');
		$('#create-account').addClass('hidden');
		$('.form-reset').removeClass('hidden');
		*/
	});
});