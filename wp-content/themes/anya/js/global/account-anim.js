// open/hide order details window
	$(".account-orders-history .view-order-details-btn").click(function(e){
		e.preventDefault();
		$(".account-order-details").addClass("active");
	});
	$(".account-order-details .close-btn").click(function(e){
		e.preventDefault();
		$(".account-order-details").removeClass("active");
	});

// open/hide tabs content
	$(".account-menu .tab").click(function(e){
		e.preventDefault();
		$(".account-menu .tab").removeClass("active");
		$(this).addClass("active");
		var contentName = $(this).attr("data-value");
		$(".tab-content-wrapper").hide();
		$(".tab-content-wrapper").removeClass("active");
		$(".tab-content-wrapper."+contentName).show();
		$(".tab-content-wrapper."+contentName).addClass("active");
	});