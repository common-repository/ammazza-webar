jQuery( document ).ready( function($) {
	
	$(document).on('click','.popup-tryon',function(){
            var hid = $(this).attr('data-hid');

            var pifrm ="<div class='modal-wrapper popupCloseDiv' id='tryPopupGen'><div class='modal'><div class='head'><a class='btn-close trigger pClose' href='javascript:void(0);'></a></div><div class='content'><iframe src='"+hid+"' height='100%' width='100%' allow='camera *;microphone *'></iframe></div></div></div>";

            $('body').append(pifrm);
            $('.modal-wrapper').addClass('open');
            $('header').hide();

            return false;
	});


	$(document).on('click','.pClose',function(){		
            $('.popupCloseDiv').remove();
            $('header').show();
	});
	
});