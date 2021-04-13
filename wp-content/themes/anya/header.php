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

    <?php wp_head(); ?>
</head>

<body <?php //body_class(); ?> class="<?= is_user_logged_in() ? 'log_in' : 'log_out' ?>">
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
    <img src="<?= get_template_directory_uri(); ?>/images/logo/logo_white.svg" style="max-width:300px;"/>
</div>
<!--preloader-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('pre-loader').style.opacity = '0'
        setTimeout(function () {document.getElementById('pre-loader').style.display = 'none' }, 350)
    })
</script>

<header>
    <div class="container">
        <div class="row justify-content-between">
            <ul class="d-flex">
                <li class="icon-item d-flex align-items-center left-border transition-3s">
					<span class="icon">
						<i class="fas fa-search"></i>
					</span>
                </li>
                <li class="menu-item d-flex align-items-center transition-3s">
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
                    <a href="#">О компании</a>
                </li>
                <li class="text-item d-flex align-items-center no-marg d-none">
                    <a href="#">Публикации</a>
                </li>
            </ul>
            <ul class="d-flex">
                <li class="logo-item d-flex align-items-center d-none">
                    <!-- <a href="#">Prophoto</a> -->
                    <a href="#"><img width="170px" src="<?= get_template_directory_uri(); ?>/images/text-logo.png"></a>
                </li>
            </ul>
            <ul class="d-flex">
                <li class="text-item d-flex align-items-center d-none">
                    <a href="#">Контакты</a>
                </li>
                <li class="icon-item d-flex align-items-center left-border transition-3s">
					<span class="icon">
						<i class="far fa-user"></i>
					</span>
                </li>
                <li class="icon-item d-flex align-items-center transition-3s">
					<span class="icon">
						<i class="far fa-heart"></i>
						<span class="counter">2</span>
					</span>
                </li>
                <li class="icon-item d-flex align-items-center transition-3s">
					<span class="icon">
						<i class="fas fa-balance-scale"></i>
						<span class="counter">2</span>
					</span>
                </li>
                <li class="icon-item d-flex align-items-center transition-3s">
					<span class="icon">
						<i class="fas fa-shopping-basket"></i>
						<span class="counter">2</span>
					</span>
                </li>
            </ul>
        </div>
    </div>
</header>