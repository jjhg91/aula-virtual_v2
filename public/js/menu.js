// $(window).on('load', function(){
// 	$('.loader').css({visibility: "hidden",opacity: "0"});
	
// })


$(document).ready(main);
 


function main () {
	$('.loader').css({visibility: "hidden",opacity: "0"});


	checkCookie();
	function checkCookie(){
		if ($.cookie('menu')) {
			menu = $.cookie('menu');
			if (menu==1) {
				menu=0;
			}else{
				menu = 1;
			}

			if (menu == 0){		
				menu = 1;
				$('nav').removeClass('nav_oculto');
				$('main').removeClass('main_completo');
				
			}else{
				menu = 0;
				$('nav').addClass('nav_oculto');
				$('main').addClass('main_completo');
				
			};
		}else{
			menu = 0;
		}
	}
	
console.log("1cookie: "+$.cookie('menu'));
console.log("1menu  : "+menu);


	// MOSTRAR Y OCULTAR MENU 
	$('.menuPadre').click(function(){
		if (menu == 0) {
			$('nav').removeClass('nav_oculto');
			$('main').removeClass('main_completo');
			
			menu = 1;
		}else{
			$('nav').addClass('nav_oculto');
			$('main').addClass('main_completo');
			
			menu = 0;
		};
		$.cookie('menu',menu,{expires:360,path: '/'});
		console.log("2cookie: "+$.cookie('menu'));
		console.log("2menu: "+menu);
		// $('nav').toggleClass('nav_oculto');
		// $('main').toggleClass('main_completo');
		
	});



	// Mostramos y ocultamos submenus
	$('.aqui').click(function(){

		$(this).toggleClass('active');
		$(this).siblings('.children').toggleClass('open');
				


	});










}