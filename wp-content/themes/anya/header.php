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
<!--class="--><?//= is_user_logged_in() ? 'log_in' : 'log_out' ?><!--"-->
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
<!--    <img src="--><?//= get_template_directory_uri(); ?><!--/images/logo/logo_white.svg" style="max-width:300px;"/>-->
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
                    <a href="<?= pll_home_url(); ?>"><img width="170px" src="<?= get_template_directory_uri(); ?>/images/text-logo.png"></a>
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
					<a href="<?=get_permalink(1890);?>" class="icon">
						<i class="fas fa-balance-scale"></i>
						<span id="compare__counter" class="counter">1</span>
					</a>
                </li>
                <li class="icon-item d-flex align-items-center transition-3s dropdown__li">
					<span class="icon">
						<i class="fas fa-shopping-basket"></i>
						<span id="cart__counter" class="counter">1</span>
					</span>
                    <div class="dropdown__widget">
                        <div class="widget_shopping_cart_content"></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>


<section class="menu transition-5s">
    <div class="container no-pad">
        <div class="row no-marg content-wrapper">
            <div class="col-md-3 column">
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Объективы</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Серия Di (полноразмерная матрица)</a></li>
                        <li><a class="transition-2s" href="#">Серия Di II (APS-C)</a></li>
                        <li><a class="transition-2s" href="#">Серия Di III (для цифровых системных камер</a></li>
                    </ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Студийный свет</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Rime Lite i.TTL</a></li>
                        <li><a class="transition-2s" href="#">Rime Lite Ni</a></li>
                        <li><a class="transition-2s" href="#">Rime Lite i</a></li>
                        <li><a class="transition-2s" href="#">Rime Lite Fame Plus</a></li>
                        <li><a class="transition-2s" href="#">Rime Lite XB-Prime</a></li>
                        <li><a class="transition-2s" href="#">Rime Lite F Plus</a></li>
                        <li><a class="transition-2s" href="#">Комплекты студийного света</a></li>
                        <li><a class="transition-2s" href="#">Сумки для вспышек</a></li>
                        <li><a class="transition-2s" href="#">Аксессуары</a></li>
                    </ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Штативные головки</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Радиосинхронизаторы и ДУ</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Аксессуары для вспышек</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
            </div>
            <div class="col-md-3 column">
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Светофильтры</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Защитные</a></li>
                        <li><a class="transition-2s" href="#">Поляризационные</a></li>
                        <li><a class="transition-2s" href="#">Нейтральные</a></li>
                        <li><a class="transition-2s" href="#">Макролинзы</a></li>
                        <li><a class="transition-2s" href="#">Смягчающие</a></li>
                        <li><a class="transition-2s" href="#">Лучевые, Эффектные</a></li>
                        <li><a class="transition-2s" href="#">Градиентные</a></li>
                        <li><a class="transition-2s" href="#">Конвертеры</a></li>
                        <li><a class="transition-2s" href="#">Аксессуары</a></li>
                    </ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Фоны</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Фоны тканевые </a></li>
                        <li><a class="transition-2s" href="#">Фоны бумажные, виниловые </a></li>
                        <li><a class="transition-2s" href="#">Фоны двухсторонние складные </a></li>
                        <li><a class="transition-2s" href="#">Фоны Chromakey </a></li>
                    </ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Боксы для макросъемки</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Стойки</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Зонты</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
            </div>
            <div class="col-md-3 column">
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Штативы</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Штативы профессиональные </a></li>
                        <li><a class="transition-2s" href="#">Штативы без головок </a></li>
                        <li><a class="transition-2s" href="#">Штативы видео </a></li>
                        <li><a class="transition-2s" href="#">Штативы любительские </a></li>
                        <li><a class="transition-2s" href="#">Штативы Sprint </a></li>
                        <li><a class="transition-2s" href="#">Аксессуары </a></li>
                    </ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Рефлекторы</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Аксессуары </a></li>
                    </ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Столы для предметной съемки</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Наборы для чистки</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Аксессуары</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
            </div>
            <div class="col-md-3 column relative">
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Софтбоксы</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Узкие софтбоксы </a></li>
                        <li><a class="transition-2s" href="#">Восьмиугольные софтбоксы </a></li>
                        <li><a class="transition-2s" href="#">Прямоугольные софтбоксы </a></li>
                        <li><a class="transition-2s" href="#">Квадратные софтбоксы </a></li>
                        <li><a class="transition-2s" href="#">Grand Box софтбоксы </a></li>
                        <li><a class="transition-2s" href="#">Portable Box софтбоксы </a></li>
                        <li><a class="transition-2s" href="#">Аксессуары </a></li>
                    </ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Моноподы</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Соты</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative">
                    <div class="title">
                        <a class="transition-2s" href="#">Отражатели</a>
                    </div>
                    <ul class="under-list transition-5s"></ul>
                </div>
                <div class="link-wrapper relative pages-navigation">
                    <div class="title">
                        <a class="transition-2s" href="#">Навигация</a>
                        <span class="open-list-btn">
							<i class="fas fa-plus show transition-5s"></i>
							<i class="fas fa-minus hide transition-5s"></i>
						</span>
                    </div>
                    <ul class="under-list transition-5s">
                        <li><a class="transition-2s" href="#">Про компанию </a></li>
                        <li><a class="transition-2s" href="#">Публикации </a></li>
                        <li><a class="transition-2s" href="#">Контакты </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 brands">
                <div class="brands-colums d-table">
                    <div class="brand d-table-cell">
                        <a href="#" class="image-link d-block">
                            <img width="100%" src="<?= get_template_directory_uri(); ?>/images/logo1.png">
                        </a>
                    </div>
                    <div class="brand d-table-cell">
                        <a href="#" class="image-link d-block">
                            <img width="100%" src="<?= get_template_directory_uri(); ?>/images/logo2.png">
                        </a>
                    </div>
                    <div class="brand d-table-cell">
                        <a href="#" class="image-link d-block">
                            <img width="100%" src="<?= get_template_directory_uri(); ?>/images/logo3.jpg">
                        </a>
                    </div>
                    <div class="brand d-table-cell">
                        <a href="#" class="image-link d-block">
                            <img width="100%" src="<?= get_template_directory_uri(); ?>/images/logo4.png">
                        </a>
                    </div>
                    <div class="brand d-table-cell">
                        <a href="#" class="image-link d-block">
                            <img width="100%" src="<?= get_template_directory_uri(); ?>/images/logo5.jpg">
                        </a>
                    </div>
                    <div class="brand d-table-cell">
                        <a href="#" class="image-link d-block">
                            <img width="100%" src="<?= get_template_directory_uri(); ?>/images/logo6.jpg">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mobile-menu transition-5s">
    <div class="header relative">
        <div class="logo-wrapper">
            <div class="logo">Prophoto</div>
        </div>
        <div class="close-btn">
            <i class="fas fa-times"></i>
        </div>
        <ul class="menu-list d-block">
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Объективы</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Серия Di (полноразмерная матрица)</a></li>
                    <li><a class="transition-2s" href="#">Серия Di II (APS-C)</a></li>
                    <li><a class="transition-2s" href="#">Серия Di III (для цифровых системных камер</a></li>
                </ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Студийный свет</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Rime Lite i.TTL</a></li>
                    <li><a class="transition-2s" href="#">Rime Lite Ni</a></li>
                    <li><a class="transition-2s" href="#">Rime Lite i</a></li>
                    <li><a class="transition-2s" href="#">Rime Lite Fame Plus</a></li>
                    <li><a class="transition-2s" href="#">Rime Lite XB-Prime</a></li>
                    <li><a class="transition-2s" href="#">Rime Lite F Plus</a></li>
                    <li><a class="transition-2s" href="#">Комплекты студийного света</a></li>
                    <li><a class="transition-2s" href="#">Сумки для вспышек</a></li>
                    <li><a class="transition-2s" href="#">Аксессуары</a></li>
                </ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Штативные головки</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Радиосинхронизаторы и ДУ</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Аксессуары для вспышек</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Светофильтры</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Защитные</a></li>
                    <li><a class="transition-2s" href="#">Поляризационные</a></li>
                    <li><a class="transition-2s" href="#">Нейтральные</a></li>
                    <li><a class="transition-2s" href="#">Макролинзы</a></li>
                    <li><a class="transition-2s" href="#">Смягчающие</a></li>
                    <li><a class="transition-2s" href="#">Лучевые, Эффектные</a></li>
                    <li><a class="transition-2s" href="#">Градиентные</a></li>
                    <li><a class="transition-2s" href="#">Конвертеры</a></li>
                    <li><a class="transition-2s" href="#">Аксессуары</a></li>
                </ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Фоны</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Фоны тканевые </a></li>
                    <li><a class="transition-2s" href="#">Фоны бумажные, виниловые </a></li>
                    <li><a class="transition-2s" href="#">Фоны двухсторонние складные </a></li>
                    <li><a class="transition-2s" href="#">Фоны Chromakey </a></li>
                </ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Боксы для макросъемки</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Стойки</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Зонты</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Штативы</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Штативы профессиональные </a></li>
                    <li><a class="transition-2s" href="#">Штативы без головок </a></li>
                    <li><a class="transition-2s" href="#">Штативы видео </a></li>
                    <li><a class="transition-2s" href="#">Штативы любительские </a></li>
                    <li><a class="transition-2s" href="#">Штативы Sprint </a></li>
                    <li><a class="transition-2s" href="#">Аксессуары </a></li>
                </ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Рефлекторы</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Аксессуары </a></li>
                </ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Столы для предметной съемки</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Наборы для чистки</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Аксессуары</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Софтбоксы</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Узкие софтбоксы </a></li>
                    <li><a class="transition-2s" href="#">Восьмиугольные софтбоксы </a></li>
                    <li><a class="transition-2s" href="#">Прямоугольные софтбоксы </a></li>
                    <li><a class="transition-2s" href="#">Квадратные софтбоксы </a></li>
                    <li><a class="transition-2s" href="#">Grand Box софтбоксы </a></li>
                    <li><a class="transition-2s" href="#">Portable Box софтбоксы </a></li>
                    <li><a class="transition-2s" href="#">Аксессуары </a></li>
                </ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Моноподы</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Соты</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block">
                <div class="title">
                    <a class="transition-2s" href="#">Отражатели</a>
                </div>
                <ul class="under-list transition-5s"></ul>
            </li>
            <li class="link relative d-block pages-navigation">
                <div class="title">
                    <a class="transition-2s" href="#">Навигация</a>
                    <span class="open-list-btn pull-right">
						<i class="fas fa-plus show transition-5s"></i>
						<i class="fas fa-minus hide transition-5s"></i>
					</span>
                </div>
                <ul class="under-list transition-5s">
                    <li><a class="transition-2s" href="#">Про компанию </a></li>
                    <li><a class="transition-2s" href="#">Публикации </a></li>
                    <li><a class="transition-2s" href="#">Контакты </a></li>
                </ul>
            </li>
        </ul>
    </div>
</section>

<section class="header_top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
</section>