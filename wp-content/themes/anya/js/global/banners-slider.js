// set banners slider container width
	function setBannerContainerWidth( selector ){
		var sectionWidth = $(selector).outerWidth();
		var defaultContainerWidth = $(selector).find(".container.banners-wrapper").outerWidth();
		var sliderWidth = (sectionWidth - defaultContainerWidth)/2;
		sliderWidth += defaultContainerWidth;
		$(selector).find(".container.banners-wrapper").css("max-width",sliderWidth+"px");		
	}

// set navigation buttons margin top
	function setNavigationButtonsMarginTop( selector ){
		var navigationSectionHeight = $(selector).find(".banners-wrapper .tns-outer").outerHeight();
		var navigationButtonsHeight = $(selector).find(".banners-wrapper .tns-outer .tns-controls button").outerHeight();
		var marginTop = (navigationSectionHeight-navigationButtonsHeight)/2;
		$(selector).find(".banners-wrapper .tns-outer .tns-controls button").css("margin-top",marginTop+"px");
	}

// set banners slider config 
	function setBannerSliderConfig( selector ){	
		var slider = selector + ' .banners-slider';
		var sectionWidth = $(selector).outerWidth();
		var slideWidth = 490;
		var slideGutter = 30;
		if ( sectionWidth < 400 ){
			slideWidth = sectionWidth-30;
			slideGutter = 10;
		}
		var slider = tns({
			container: slider,
			fixedWidth: slideWidth,
			swipeAngle: false,
			gutter: slideGutter,
			controlsText: ['<i class="material-icons">keyboard_arrow_left</i>','<i class="material-icons">keyboard_arrow_right</i>'],
			loop: false,
			nested: 'inner',
  			slideBy: 'page'
		});			
	}

// inizialization banners slider
	function iniBannersSlider( selector ){
		setBannerContainerWidth( selector );
		setBannerSliderConfig( selector );
		setNavigationButtonsMarginTop( selector );
	}

