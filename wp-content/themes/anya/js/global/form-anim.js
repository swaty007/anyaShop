// view/hide password using tooltip
	$(".password-tooltip span").click(function(e){
		e.preventDefault();
		var input = $(this).closest(".form-group").find("input");
		if ( $(input).attr("type") == "password" ) { 
			$(input).attr("type","text");
			$(this).text("Скрыть пароль");
		}
		else if ( $(input).attr("type") == "text" ) {
			$(input).attr("type","password");
			$(this).text("Показать пароль");
		}
	});