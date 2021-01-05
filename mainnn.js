;(function () {

	'use strict';

	var mobileMenuOutsideClick = function() {

		$(document).click(function (e) {
	    var container = $("#gtco-offcanvas, .js-gtco-nav-toggle");
	    if (!container.is(e.target) && container.has(e.target).length === 0) {

	    	if ( $('body').hasClass('offcanvas') ) {

    			$('body').removeClass('offcanvas');
    			$('.js-gtco-nav-toggle').removeClass('active');

	    	}


	    }
		});

	};


	var offcanvasMenu = function() {

		$('#page').prepend('<div id="gtco-offcanvas" />');
		$('#page').prepend('<a href="#" class="js-gtco-nav-toggle gtco-nav-toggle gtco-nav-white"><i></i></a>');
		var clone1 = $('.menu-1 > ul').clone();
		$('#gtco-offcanvas').append(clone1);
		var clone2 = $('.menu-2 > ul').clone();
		$('#gtco-offcanvas').append(clone2);

		$('#gtco-offcanvas .has-dropdown').addClass('offcanvas-has-dropdown');
		$('#gtco-offcanvas')
			.find('li')
			.removeClass('has-dropdown');

		// Hover dropdown menu on mobile
		$('.offcanvas-has-dropdown').mouseenter(function(){
			var $this = $(this);

			$this
				.addClass('active')
				.find('ul')
				.slideDown(500, 'easeOutExpo');
		}).mouseleave(function(){

			var $this = $(this);
			$this
				.removeClass('active')
				.find('ul')
				.slideUp(500, 'easeOutExpo');
		});


		$(window).resize(function(){

			if ( $('body').hasClass('offcanvas') ) {

    			$('body').removeClass('offcanvas');
    			$('.js-gtco-nav-toggle').removeClass('active');

	    	}
		});
	};


	var burgerMenu = function() {

		$('body').on('click', '.js-gtco-nav-toggle', function(event){
			var $this = $(this);


			if ( $('body').hasClass('overflow offcanvas') ) {
				$('body').removeClass('overflow offcanvas');
			} else {
				$('body').addClass('overflow offcanvas');
			}
			$this.toggleClass('active');
			event.preventDefault();

		});
	};



	var contentWayPoint = function() {
		var i = 0;
		$('.animate-box').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('animated-fast') ) {

				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .animate-box.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn animated-fast');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft animated-fast');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight animated-fast');
							} else {
								el.addClass('fadeInUp animated-fast');
							}

							el.removeClass('item-animate');
						},  k * 200, 'easeInOutExpo' );
					});

				}, 100);

			}

		} , { offset: '85%' } );
	};


	var dropdown = function() {

		$('.has-dropdown').mouseenter(function(){

			var $this = $(this);
			$this
				.find('.dropdown')
				.css('display', 'block')
				.addClass('animated-fast fadeInUpMenu');

		}).mouseleave(function(){
			var $this = $(this);

			$this
				.find('.dropdown')
				.css('display', 'none')
				.removeClass('animated-fast fadeInUpMenu');
		});

	};


	var testimonialCarousel = function(){

		var owl = $('.owl-carousel-fullwidth');
		owl.owlCarousel({
			items: 1,
			loop: true,
			margin: 0,
			nav: false,
			dots: true,
			smartSpeed: 800,
			autoHeight: true
		});

	};

	var tabs = function() {

		// Auto adjust height
		$('.gtco-tab-content-wrap').css('height', 0);
		var autoHeight = function() {

			setTimeout(function(){

				var tabContentWrap = $('.gtco-tab-content-wrap'),
					tabHeight = $('.gtco-tab-nav').outerHeight(),
					formActiveHeight = $('.tab-content.active').outerHeight(),
					totalHeight = parseInt(tabHeight + formActiveHeight + 90);

					tabContentWrap.css('height', totalHeight );

				$(window).resize(function(){
					var tabContentWrap = $('.gtco-tab-content-wrap'),
						tabHeight = $('.gtco-tab-nav').outerHeight(),
						formActiveHeight = $('.tab-content.active').outerHeight(),
						totalHeight = parseInt(tabHeight + formActiveHeight + 90);

						tabContentWrap.css('height', totalHeight );
				});

			}, 100);

		};

		autoHeight();


		// Click tab menu
		$('.gtco-tab-nav a').on('click', function(event){

			var $this = $(this),
				tab = $this.data('tab');

			$('.tab-content')
				.addClass('animated-fast fadeOutDown');

			$('.gtco-tab-nav li').removeClass('active');

			$this
				.closest('li')
					.addClass('active')

			$this
				.closest('.gtco-tabs')
					.find('.tab-content[data-tab-content="'+tab+'"]')
					.removeClass('animated-fast fadeOutDown')
					.addClass('animated-fast active fadeIn');


			autoHeight();
			event.preventDefault();

		});
	};


	var goToTop = function() {
		/*
		$(window).scroll(function() {
			if ($(this).scrollTop() > 200) {
					$('.js-gotop').fadeIn(200);
						} else {
								$('.js-gotop').fadeOut(200);
					 }
				});
					// Animate the scroll to top
				$('.js-gotop').click(function(event) {
					event.preventDefault();
				$('html, body').animate({scrollTop: 0}, 1200);
		});
		*/
		$(window).scroll(function() {
    if ($(window).scrollTop() < 2500) {
        $('#rocketmeluncur').slideUp(800)
    } else {
        $('#rocketmeluncur').slideDown(800)
    }
});
$('#rocketmeluncur').click(function() {
    $("html, body").animate({
        scrollTop: '0px'
    }, {
        duration: 1000,
        easing: 'linear'
    });
    var self = this;
    this.className += ' ' + "launchrocket";
    setTimeout(function() {
        self.className = 'showrocket'
    }, 800)
});


		$(window).scroll(function(){

			var $win = $(window);
			if ($win.scrollTop() > 200) {
				$('.js-top').addClass('active');
			} else {
				$('.js-top').removeClass('active');
			}

		});

	};

	$(window).load(function(){
	    $('.preloader').fadeOut(1000); // set duration in brackets
	});

	var counter = function() {
		$('.js-counter').countTo({
			 formatter: function (value, options) {
	      return value.toFixed(options.decimals);
	    },
		});
	};

	var counterWayPoint = function() {
		if ($('#gtco-counter').length > 0 ) {
			$('#gtco-counter').waypoint( function( direction ) {

				if( direction === 'down' && !$(this.element).hasClass('animated') ) {
					setTimeout( counter , 400);
					$(this.element).addClass('animated');
				}
			} , { offset: '90%' } );
		}
	};

	/*---------------------------------------------*
	 * Easy Pie Chart
	 ---------------------------------------------*/



	$('.skills').waypoint(function () {
			$('.chart').easyPieChart({
					animate: 2000,
					scaleColor: false,
					lineWidth: 4,
					lineCap: 'square',
					size: 130,

					trackColor: false,
					barColor: '#d85050',
					onStep: function (from, to, percent) {
							$(this.el).find('.percent').text(Math.round(percent));
					}
			});
	});

var smoothscroll = function() {
	$(function() {
			$('.navbar-default a').bind('click', function(event) {
					var $anchor = $(this);
					$('html, body').stop().animate({
							scrollTop: $($anchor.attr('href')).offset().top - 49
					}, 1500);
					event.preventDefault();
			});
	});
}

var db, isfullscreen = false;
	function toggleFullScreen(){
		db = document.body;
		if(isfullscreen == false){
			if(db.requestFullScreen){
			    db.requestFullScreen();
			} else if(db.webkitRequestFullscreen){
			    db.webkitRequestFullscreen();
			} else if(db.mozRequestFullScreen){
			    db.mozRequestFullScreen();
			} else if(db.msRequestFullscreen){
			    db.msRequestFullscreen();
			}
			isfullscreen = true;
			wrap.style.width = window.screen.width+"px";
			wrap.style.height = window.screen.height+"px";
		} else {
			if(document.cancelFullScreen){
			    document.cancelFullScreen();
			} else if(document.exitFullScreen){
			    document.exitFullScreen();
			} else if(document.mozCancelFullScreen){
			    document.mozCancelFullScreen();
			} else if(document.webkitCancelFullScreen){
			    document.webkitCancelFullScreen();
			} else if(document.msExitFullscreen){
			    document.msExitFullscreen();
			}
			isfullscreen = false;
			wrap.style.width = "100%";
			wrap.style.height = "auto";
		}
	}


	$(function(){
		mobileMenuOutsideClick();
		offcanvasMenu();
		burgerMenu();
		contentWayPoint();
		dropdown();
		testimonialCarousel();
		tabs();
		goToTop();
		counterWayPoint();
		smoothscroll();
		//toggleFullScreen();
	});


}());
