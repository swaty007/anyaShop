// close info banner
	$(".info-banner .close-btn").click(function(e){
		e.preventDefault();
		var container = $(this).closest(".container");
		$(container).hide();
	});

// checkbox clicker
	$(".table .checkbox").click(function(e){
		if ( $(this).hasClass("active") ){
			$(this).removeClass("active");
			var checked = 0;
			$(".table .checkbox").each(function(){
				if ( $(this).hasClass("active") ){
					checked = 1;
				}
			});
			if ( checked == 0 ){
				$(".d-catalog .widgets").removeClass("active");
			}
		}
		else{
			$(this).addClass("active");
			$(".d-catalog .widgets").addClass("active");
		}
	});

// catagories tab
	$(".d-catalog .wrapper .catagories-tabs .tab").click(function(e){
		e.preventDefault();
		$(".d-catalog .wrapper .catagories-tabs .tab").removeClass("active");
		$(this).addClass("active");
		$(".d-catalog .wrapper .products-table .table table").hide();
		$(".d-catalog .wrapper .products-table .table").append('<div class="loader-wrapper d-flex align-items-center justify-content-center"><div class="loader"></div></div>');
		setTimeout(function(){ 
			$(".d-catalog .wrapper .products-table .table .loader-wrapper").remove();
			$(".d-catalog .wrapper .products-table .table table").show();
		}, 2000);
	});

// filters open/hide
	$(".d-catalog .wrapper .products-table .filters-btn").click(function(e){
		e.preventDefault();
		if ( $( ".catalog-filters-content .filters" ).is( ":hidden" ) ) {
			$(".catalog-filters-content .filters").slideDown();
			$(".filters-btn .material-icons").text('keyboard_arrow_up');
		} 
		else {
			$(".catalog-filters-content .filters").slideUp();
			$(".filters-btn .material-icons").text('keyboard_arrow_down');
		}
	});
	