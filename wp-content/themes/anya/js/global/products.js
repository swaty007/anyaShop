// set similar height
	function getBiggestHeightProductNumber( selector ){
		var height = 0;
		var elemNumber = 0;
		var i = 1;
		$(selector).each(function(){
			elemHeight = $(this).outerHeight();
			if ( elemHeight > height ) {
				elemNumber = i
				height = elemHeight
			}
			i++;
		});
		return elemNumber;
	}
	function setProductsSimilarHeight( selector ){
		elemNumber = getBiggestHeightProductNumber(selector+" .info");
		var titleHeight = $(selector+":nth-child("+elemNumber+")"+" .info").find(".title").innerHeight();
		var advantagesHeight = $(selector+":nth-child("+elemNumber+")"+" .info").find(".advantages").outerHeight();
		console.log(advantagesHeight)
		// $(selector+" .info").find(".title").css("height",titleHeight);
		$(selector+" .info").find(".advantages").css("height",advantagesHeight);
	}