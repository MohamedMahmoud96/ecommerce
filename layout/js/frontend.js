$(function () {

	"use strict";
	$("select").selectBoxIt({

		autoWidth: false
	
	});
    
	$('[placeholder]').focus(function(){
		$(this).attr('data-place', $(this).attr('placeholder'));

		$(this).attr('placeholder', "");

	}).blur(function(){
		$(this).attr('placeholder', $(this).attr('data-place'));
	});

	$(".confirm").click(function(){

		return confirm('Are You Sure?');
	});

	$(".login-page h1 span").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
		$(".login-page form").hide();
		console.log($('.' + $(this).data('class')).show());

	});

	$('.ads-name').keyup(function () {

		$('.cpd-form h3').text($(this).val())
	});

	$('.ads-price').keyup(function () {

		$('.cpd-form .price span ').text(' $' + $(this).val());
	});

	$('.ads-description').keyup(function () {

		$('.cpd-form p').text($(this).val());
	});

});
   
