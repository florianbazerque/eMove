$( document ).ready(function() {
	/*******************************************************/
	/************************ INPUT ************************/
	/*******************************************************/

	$('.start').datetimepicker({
        format:'d/m/Y H:i',
        onShow:function( ct ){
            this.setOptions({
                maxDate:jQuery('.end').val()?jQuery('.end').val():false
            })
        }
	});
	$('.end').datetimepicker({
        format:'d/m/Y H:i',
        onShow:function( ct ){
            this.setOptions({
                minDate:jQuery('.start').val()?jQuery('.start').val():false
            })
        },
    });
	$('.date input').datepicker({
		format: "dd/mm/yyyy",
	    startDate: "today",
	    todayBtn: "linked",
	    language: "fr",
	    orientation: "bottom auto",
	    autoclose: true,
	    todayHighlight: true,
	    toggleActive: true
	});
	$('.naissance').datepicker({
	    format: "dd/mm/yyyy",
		language: "fr",
		todayHighlight: true,
	});
	/*******************************************************/
	/******************* RESERVATION ***********************/
	/*******************************************************/

	$('.reservation .custom-radio').click(function() {
  		if($('#credit').is(':checked')) { 
  			$( ".identity_card" ).css( "display", "flex" );
  		}else{
  			$( ".identity_card" ).css( "display", "none" );
  		}
	});

	/*******************************************************/
	/************ SLICK/OWL-CAROUSSEL/FANCYBOX *************/
	/*******************************************************/
	$(".owl-carousel").owlCarousel({
		loop:true,
	    margin:10,
	    nav:true,
	    responsive:{
	        0:{
	            items:1,
	            nav:true
	        },
	        800:{
	            items:2,
	            nav:false
	        },
	        1000:{
	            nav:true,
	            loop:false
	        }
	    }
	});

	$('.components a').click(function () {
	    var currentIndex = $(this).attr('data-slick-index');
	    console.log(currentIndex);
		$('.dashboard-carousel').slick('slickGoTo', currentIndex); 
	});

	$(".gallery_image").fancybox({
		'hideOnContentClick': true,
        'transitionIn'	:	'elastic',
        'transitionOut'	:	'elastic',
        'speedIn'		:	600,
        'speedOut'		:	200,
        'overlayShow'	:	false
	});

	/*******************************************************/
	/********************** PROFILE  ***********************/
	/*******************************************************/

	$('.profile .col-sm-3 .list-group a').click(function(){
	    var data = $(this).attr('data');
	    $('.col-sm-9 .jumbotron-fluid').hide();
	    $('.' + data).show();

	})

});

