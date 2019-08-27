$(function(){

	"use strict";


	$('[placeholder]').focus(function(){

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', "");

	}).blur (function(){

		$(this).attr('placeholder',$(this).attr('data-text'));
	});

	$(".confirm").click(function(){

		return confirm('Are You Sure?');
	});
//clone()
	$('#image-plus').on('click',function(){
		var btn = $(this),
		 	input  = btn.siblings('div').children(),
			parent = btn.siblings('div').append(input.first().clone());
			if(input.length == 4){
				btn.remove();
			}
		
		console.log(input);
	});


	$('#edit-image').on('click', function(){
		 $(this).siblings("input[type=file]").click();
		return false
	});
});