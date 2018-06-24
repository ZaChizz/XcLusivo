$(document).ready(function(){
	
	//placeholder
    $('[placeholder]').focus(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function() {
        var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
    }).blur();
    $('[placeholder]').parents('form').submit(function() {
        $(this).find('[placeholder]').each(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
            }
        })
    });
		
	//
	var ww = document.body.clientWidth;
	var wc = $('#container').width();
	$(document).ready(function() {
		adjustMenu();
	});	
	$(window).bind('resize orientationchange', function() {
		ww = document.body.clientWidth;
		wc = $('#container').width();
		adjustMenu();
	});
	
	var adjustMenu = function() {				
		if (wc < 768) {
			
		}
		else if (wc >= 768) {
			$('.search-form').show();
			$('.filt-hid').removeClass('open');
			$('.cover2').removeClass('open');
		}
		
	}
	
	
	$('.girl-prof.user-cont .user-col h1').click(function(){
		$('.filt-hid').toggleClass('open');
		$('.cover2').toggleClass('open');
	});	
	$('.cover2').click(function(){
		$('.filt-hid').removeClass('open');
		$('.cover2').removeClass('open');
		$('.sidebar').hide();
	});	

	//
	$('.fav-slider2').slick({
	  slidesToShow: 2,
	  arrows: true,
	  dots: false,
	  vertical: true,
	  speed: 200,
	  responsive: [		
		{
		  breakpoint: 960,
		  settings: {
			slidesToShow: 2,
			vertical: false
		  }
		}
	  ]
	});
			
	$('.fav-slider').slick({
	  slidesToShow: 2,
	  arrows: true,
	  dots: false,
	  vertical: true,
	  speed: 200,
	  responsive: [
		{
		  breakpoint: 960,
		  settings: {
			slidesToShow: 3
		  }
		},
		{
		  breakpoint: 700,
		  settings: {
			slidesToShow: 2,
			vertical: false
		  }
		}
	  ]
	});
	
	
	$('.booking-slider').slick({
	  slidesToShow: 1,
	  arrows: true,
	  dots: false,
	  vertical: true,
	  speed: 200,
	  responsive: [
		
	  ]
	});
	
	
	//
	$('.check input, .curr select, select, input[type="file"]').styler({fileBrowse: 'Take photo'});
	
	//	
	$('.log-op1').click(function(){
		$('#head-link2, .head-link2').removeClass('active');
		$(this).toggleClass('active');
		$('.head-link1').toggleClass('active');
		$('#header').toggleClass('open');
		$('.log-drop2').removeClass('open');
		$('.log-drop1').toggleClass('open');
		return false;
	});	
	$('#head-link1, .head-link1').click(function(){
		$('#head-link2, .head-link2').removeClass('active');
		$(this).addClass('active');
		$('.head-link1').addClass('active');
		$('#header').addClass('open');
		$('.log-drop2').removeClass('open');
		$('.log-drop1').addClass('open');
		return false;
	});	
	$('#head-link2, .head-link2').click(function(){
		$('#head-link1, .head-link1').removeClass('active');
		$("#head-link2").addClass('active');
		$('.head-login > .head-link2').addClass('active');
		$('#header').addClass('open');
		$('.log-drop1').removeClass('open');
		$('.log-drop2').addClass('open');
		return false;
	});	
	$('#head-link3, .log-op3').click(function(){
		$('#head-link1').removeClass('active');
		$(this).addClass('active');
		$('#header').addClass('open');
		$('.log-drop3').addClass('open');
		$('.head-lang .jq-selectbox').removeClass('opened');
		$('.head-lang .jq-selectbox__dropdown').hide();
		return false;
	});	
	$('.log-drop .close, .close-link').click(function(){
		$('.head-link').removeClass('active');
		$('#header').removeClass('open');
		$('.log-drop').removeClass('open');
		return false;
	});

	$('.search-btn').click(function(){
		$('.head-search').toggleClass('open');
		$('.head-lang .jq-selectbox').removeClass('opened');
		$('.head-lang .jq-selectbox__dropdown').hide();
		$('#header').removeClass('open');	
		$('.log-op').removeClass('active');	
		return false;
	});	
	
	$(document).mouseup(function (e){
		var container = $('.head-search');
		if (!container.is(e.target) // if the target of the click isn't the container...
			&& container.has(e.target).length === 0) // ... nor a descendant of the container
		{
			$('.head-search').removeClass('open');
		}
	});

	
	$('.filter-btn').click(function(){
		$('.sidebar').toggle();
		// $('.cover2').toggleClass('open');
		return false;
	});	
	
	$('.filter-opener').click(function(){
		$(this).parent().toggleClass('active');
		return false;
	});	
	
	$('.user-info .opener').click(function(){
		$(this).parent().toggleClass('active');
		return false;
	});	
	
	
	//
	$(".scroll").mCustomScrollbar({
		axis:"y",
		scrollButtons:{enable:false},
		advanced:{autoExpandHorizontalScroll:true},
		scrollInertia: 0
	});
	
	//
	$('.acc-title').click(function(){
		/*$(this).siblings('.acc-title').removeClass('active');
		$(this).siblings('.acc-drop').not($(this).next('.acc-drop')).removeClass('active');*/
		$(this).toggleClass('active');
		$(this).next('.acc-drop').toggleClass('active');
		return false;
	});	
	
	//
	$('.col-clnd').tabs();
	
	//
	$('.fancy').fancybox();
	
	//range
	jQuery("#range").slider({
		min: 0,
		max: 1000,
		values: [0,1000],
		range: true,
		stop: function(event, ui) {
			jQuery("input#minCost").val(jQuery("#filter-slider").slider("values",0));
			jQuery("input#maxCost").val(jQuery("#filter-slider").slider("values",1));
		},
		slide: function(event, ui){
			jQuery("input#minCost").val(jQuery("#filter-slider").slider("values",0));
			jQuery("input#maxCost").val(jQuery("#filter-slider").slider("values",1));
		}
	});
	
	//win-close
	$('.win-close').click(function(){
		$(this).parent('.window').fadeOut(300);
		return false;
	});	
	
});
