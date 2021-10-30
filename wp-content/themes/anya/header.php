<!doctype html>
<html <?= is_user_logged_in() ? 'style="margin-top:32px;"' : '' ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!--    <link rel="shortcut icon" href="-->
    <? //= get_template_directory_uri(); ?><!--/img/favicon.ico" type="image/ico">-->
    <!--    <title>--><?php //the_title();?><!--</title>-->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!--class="--><? //= is_user_logged_in() ? 'log_in' : 'log_out' ?><!--"-->
<?php
if (function_exists('wp_body_open')) {
    wp_body_open();
}
?>


<div id="pre-loader" style="width: 100%;
    height: 100%;
    z-index: 100000;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    position: fixed;
    transition: 1s;
    background: #14192A;
    align-items: center;
    justify-content: center;
    display: flex;
">
        <img src="<?= get_url_from_img_id(get_theme_mod('custom_logo')); ?>" style="max-width:300px;"/>
</div>
<!--preloader-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('pre-loader').style.opacity = '0'
        setTimeout(function () {
            document.getElementById('pre-loader').style.display = 'none'
        }, 350)
    })
</script>

<header>
    <div class="container">
        <div class="row justify-content-between">
            <ul class="d-flex">
                <li id="navbar__search--btn" class="icon-item d-flex align-items-center left-border transition-3s">
					<span class="icon">
						<i class="fas fa-search"></i>
						<i class="fas fa-close" style="display: none;"></i>
					</span>
                </li>
                <li id="navbar__search" class="navbar__search">
                    <form class="navbar__search--form form-inline" method="get" action="<?= site_url(); ?>"
                          role="search">
                        <!--<input type="hidden" name="post_type" value="products">-->
                        <input id="navbar__search--input" class="navbar__search--input" type="text" name="s"
                               placeholder="<?php pll_e('Поиск'); ?>">
                    </form>
                </li>
                <li id="menu__btn" class="menu-item d-flex d-lg-none align-items-center transition-3s">
                    <div class="icon">
                        <!-- <i class="fas fa-bars"></i> -->
                        <span class="transition-3s"></span>
                        <span class="transition-3s"></span>
                        <span class="transition-3s"></span>
                        <span class="transition-3s"></span>
                    </div>
                    <div class="text">Меню</div>
                </li>
                <li class="text-item d-flex align-items-center d-none">
                    <ul class="pll_language">
                        <?php pll_the_languages([
                            'echo' => 1,
                            'hide_current' => false,
                            'show_names' => 1,
                            'display_names_as' => 'slug',
                            'show_flags' => 1,
                        ]); ?>
                    </ul>
                </li>
                <!--                <li class="text-item d-flex align-items-center d-none">-->
                <!--                    <a href="#">О компании</a>-->
                <!--                </li>-->
                <!--                <li class="text-item d-flex align-items-center no-marg d-none">-->
                <!--                    <a href="#">Публикации</a>-->
                <!--                </li>-->
            </ul>
            <ul class="d-flex width33-lg" >
                <li class="logo-item d-flex align-items-center d-none">
                    <!-- <a href="#">Zoom</a> -->
                    <a href="<?= pll_home_url(); ?>">
                        <img width="170px" src="<?= get_url_from_img_id(get_theme_mod('custom_logo')); ?>"/>
                    </a>
                </li>
            </ul>
            <ul class="d-flex">
                <!--                <li class="text-item d-flex align-items-center d-none">-->
                <!--                    <a href="#">Контакты</a>-->
                <!--                </li>-->
                <li class="icon-item d-flex align-items-center left-border transition-3s">
                    <a href="<?= get_permalink(wc_get_page_id('myaccount')); ?>" class="icon">
                        <i class="far fa-user"></i>
                    </a>
                </li>
                <li class="icon-item d-lg-none d-flex align-items-center transition-3s">
                    <a href="<?= get_permalink(pll_get_post(2540)); ?>" class="icon">
                        <i class="far fa-heart"></i>
<!--                                        						<span class="counter">2</span>-->
                    </a>
                </li>
<!--                <li class="icon-item d-flex align-items-center transition-3s">-->
<!--                    <a href="--><?//= get_permalink(pll_get_post(1890)); ?><!--" class="icon">-->
<!--                        <i class="fas fa-balance-scale"></i>-->
<!--                        <span id="compare__counter" class="counter"></span>-->
<!--                    </a>-->
<!--                </li>-->
                <li class="icon-item d-lg-none d-flex align-items-center transition-3s dropdown__li">
					<span class="icon">
						<i class="fas fa-shopping-basket"></i>
						<span id="cart__counter" class="counter cart__counter">1</span>
					</span>
                    <div class="dropdown__widget">
                        <div class="widget_shopping_cart_content"></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>


<section class="mobile-menu transition-5s">
    <div class="header relative">
        <div class="logo-wrapper">
            <div class="logo">Zoom</div>
        </div>
        <div class="close-btn">
            <i class="fas fa-times"></i>
        </div>
        <?php
        wp_nav_menu([
            'theme_location' => 'menu-header',
            'menu_id' => 'header_menu_mobile',
            'container' => 'ul',
            'menu_class' => 'menu-list d-block',
        ]);
        ?>
    </div>
</section>

<section class="header_top">
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu-header',
                    'menu_id' => 'header_menu',
                    'container' => 'ul',
                    'menu_class' => 'header_top__menu d-flex',
                ]);
                ?>

                <ul class="header_top__menu2 d-flex">
                    <li class="icon-item d-flex align-items-center transition-3s">
                        <a href="<?= get_permalink(pll_get_post(2540)); ?>" class="icon transition-3s">
                            <i class="far fa-heart"></i>
                            <!--                						<span class="counter">2</span>-->
                        </a>
                    </li>
                    <li class="icon-item d-flex align-items-center transition-3s">
                        <a href="<?= get_permalink(pll_get_post(1890)); ?>" class="icon transition-3s">
                            <i class="fas fa-balance-scale"></i>
                            <span id="compare__counter" class="counter">1</span>
                        </a>
                    </li>
                    <li class="icon-item d-flex align-items-center transition-3s dropdown__li">
					<span class="icon transition-3s">
						<i class="fas fa-shopping-basket"></i>
						<span id="cart__counter" class="counter cart__counter">1</span>
					</span>
                        <div class="dropdown__widget">
                            <div class="widget_shopping_cart_content"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>