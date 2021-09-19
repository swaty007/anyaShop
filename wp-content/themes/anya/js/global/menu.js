// open/close desktop menu
$("#menu__btn").click(function (e) {
    e.preventDefault();
    if ($("body").width() <= 991) {
        var menu = ".mobile-menu";
    } else {
        var menu = ".menu";
    }

    if ($(menu).hasClass("open")) {
        $(this).removeClass("open");
        $(menu).removeClass("open");
        $("body").removeClass("open-modal");
    } else {
        if (menu == '.menu') {
            $(this).addClass("open");
        }
        $(menu).addClass("open");
        $("body").addClass("open-modal");
    }
})

// hide/show link under-list mobile menu
$(".open-list-btn").click(function (e) {
    e.preventDefault();
    if ($(this).closest("section").hasClass("menu")) {
        var underList = $(this).closest(".link-wrapper").find(".under-list");
    } else if ($(this).closest("section").hasClass("mobile-menu")) {
        var underList = $(this).closest(".link").find(".under-list");
    }
    if ($(underList).hasClass("open")) {
        $(underList).height(0);
        $(underList).removeClass("open");
        $(this).find(".fas.fa-minus").removeClass("show");
        $(this).find(".fas.fa-minus").addClass("hide");
        $(this).find(".fas.fa-plus").addClass("show");
        $(this).find(".fas.fa-plus").removeClass("hide");
    } else {
        var height = 0;
        $(underList).find("li").each(function (e) {
            height += $(this).outerHeight(true);
        });
        $(underList).height(height + 15);
        $(underList).addClass("open");
        $(this).find(".fas.fa-plus").removeClass("show");
        $(this).find(".fas.fa-plus").addClass("hide");
        $(this).find(".fas.fa-minus").addClass("show");
        $(this).find(".fas.fa-minus").removeClass("hide");
    }
});

$(".mobile-menu .menu-item-has-children>a").on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    let _this = $(this).parent('li')
    if (_this.hasClass("open")) {
        _this.find(".sub-menu").first().height(0);
        _this.removeClass("open");
    } else {
		let height = 0;
        _this.find("li").each(function (e) {
            height += $(this).outerHeight(true);
        });
        _this.find(".sub-menu").first().height(height + 15);
        _this.addClass("open");
    }
})

// close mobile menu
$(".mobile-menu .close-btn").click(function (e) {
    e.preventDefault();
    $(".mobile-menu").removeClass("open");
    $("body").removeClass("open-modal");
});

// set desktop menu margin top
if ($("body").width() > 767) {
    var headerHeight = $("header").height();
    $(".menu").css("top", headerHeight + "px");
}