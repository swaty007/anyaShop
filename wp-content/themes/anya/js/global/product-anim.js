// show product menu
	function showProductMenu(){
		var heightToSlider = $(".product-page .image-slider").offset().top;
		var currentScroll = $(window).scrollTop();
		if ( currentScroll > (heightToSlider - 100) ){
			$(".product-fixed-menu").css("top","0");
		}
		else{			
			$(".product-fixed-menu").css("top","-100%");
		}		
	}
	$(window).scroll(function(){ showProductMenu(); });
	$(document).ready(function(){ showProductMenu(); });


// product image slider
	// change slide
		function changeSlide(text, src){
			$(".product-page .image-slider .active-slide").find("img").attr("src", src);
			$(".product-page .image-slider .active-slide").find("h1").text(text);
		}
	// block image click
		$(".product-page .image-slider .slides .slide").click(function(e){			
			e.preventDefault();
			$(".product-page .image-slider .slides .slide").removeClass("active");
			$(this).addClass("active");
			var text = $(this).find("img").attr("data-title");
			var src = $(this).find("img").attr("src");
			changeSlide(text, src);
		});
	// btn click
		$(".product-page .image-slider .navigation button").click(function(e){
			var side = $(this).attr('data-value');

			if ( side == 'next' ){
				if ( $(".product-page .image-slider .slides .slide.active").next().length === 0 ){
					$(".product-page .image-slider .slides .slide.active").removeClass('active');
					$(".product-page .image-slider .slides .slide").first().addClass("active");
					var text = $(".product-page .image-slider .slides .slide").first().find("img").attr("data-title");
					var src = $(".product-page .image-slider .slides .slide").first().find("img").attr("src");	
					changeSlide(text, src);					
				}
				else{
					$(".product-page .image-slider .slides .slide.active").next().addClass('active');
					var text = $(".product-page .image-slider .slides .slide.active").next().find("img").attr("data-title");
					var src = $(".product-page .image-slider .slides .slide.active").next().find("img").attr("src");	
					changeSlide(text, src);				
					$(".product-page .image-slider .slides .slide.active").prev().removeClass('active');
				}
			}
			if ( side == 'prev' ){
				if ( $(".product-page .image-slider .slides .slide.active").prev().length === 0 ){
					$(".product-page .image-slider .slides .slide.active").removeClass('active');
					$(".product-page .image-slider .slides .slide").last().addClass("active");
					var text = $(".product-page .image-slider .slides .slide.active").find("img").attr("data-title");
					var src = $(".product-page .image-slider .slides .slide.active").find("img").attr("src");	
					changeSlide(text, src);
				}
				else{
					$(".product-page .image-slider .slides .slide.active").prev().addClass('active');
					var text = $(".product-page .image-slider .slides .slide.active").find("img").attr("data-title");
					var src = $(".product-page .image-slider .slides .slide.active").find("img").attr("src");	
					changeSlide(text, src);				
					$(".product-page .image-slider .slides .slide.active").next().removeClass('active');
				}
			}
		});


// view all specifications
	$(document).on("click", ".view-full-specifications", function () {
		if ( $(this).hasClass("active") ){
			$(this).removeClass('active');
			$(".product-page .specifications .full-features").slideUp();
			$(".product-page .specifications .full-specifications").slideUp();
			$(this).text("Все характеристики");
			$(this).css("margin-top",35+"px");
			$('html, body').animate({
			    scrollTop: $(".product-page .specifications").offset().top - 100
			}, 1000);			
		}else{
			$(this).addClass('active');
			$(".product-page .specifications .full-features").slideDown();
			$(".product-page .specifications .full-specifications").slideDown();
			$(this).text("Свернуть");
			$(this).css("margin-top",100+"px");
			$('html, body').animate({
			    scrollTop: $(".product-page .specifications").offset().top + 150
			}, 1000);				
		}
	});


// anchor links scroll
	$(".anchor-link").click(function(e){
		var target = $(this).attr("href");
		if ( target == '#review' ){
			var correction = 90;
		}		
		else if ( target == '#specifications' ){
			var correction = 117;
		}
		else if ( target == '#materials' ){
			var correction = 190;
		}
		else if ( target == '#related-products' ){
			var correction = 170;
		}
		$('html, body').animate({
		    scrollTop: $(target).offset().top - correction
		}, 1000);		
	});


// scroll body and activate anchor links
	$(window).scroll(function(){
		if ( ($(window).scrollTop() > $(".product-page #review").offset().top - 90) && ($(window).scrollTop() < $(".product-page #specifications").offset().top - 127) ){
			$('.anchor-link').closest('div').removeClass("active");
			$('.anchor-link[href="#review"]').closest('div').addClass("active");
		}
		else if ( ($(window).scrollTop() > $(".product-page #specifications").offset().top - 127) && ($(window).scrollTop() < $(".product-page #materials").offset().top - 200) ){
			$('.anchor-link').closest('div').removeClass("active");
			$('.anchor-link[href="#specifications"]').closest('div').addClass("active");
		}
		else if ( ($(window).scrollTop() > $(".product-page #materials").offset().top - 200) && ($(window).scrollTop() < $(".product-page #related-products").offset().top - 180) ){
			$('.anchor-link').closest('div').removeClass("active");
			$('.anchor-link[href="#materials"]').closest('div').addClass("active");
		}
		else if ( ($(window).scrollTop() > $(".product-page #related-products").offset().top - 180) ){
			$('.anchor-link').closest('div').removeClass("active");
			$('.anchor-link[href="#related-products"]').closest('div').addClass("active");
		}
	});