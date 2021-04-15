<?php


get_header();
//the_post();
//$post_id = pll_get_post($post->ID, 'ru');
$post_id = $post->ID;
?>


    <section class="home-slider">
        <div class="container no-pad">
            <div id="homeSlider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#homeSlider" data-slide-to="0" class="active"></li>
                    <li data-target="#homeSlider" data-slide-to="1"></li>
                    <li data-target="#homeSlider" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <a href="#" class="d-block"><img widht="100%" src="<?= get_template_directory_uri(); ?>/images/homepage_slider/slide1_desktop.png" alt="First slide"></a>
                    </div>
                    <div class="carousel-item">
                        <a href="#" class="d-block"><img widht="100%" src="<?= get_template_directory_uri(); ?>/images/homepage_slider/slide1_desktop.png" alt="First slide"></a>
                    </div>
                    <div class="carousel-item">
                        <a href="#" class="d-block"><img widht="100%" src="<?= get_template_directory_uri(); ?>/images/homepage_slider/slide1_desktop.png" alt="First slide"></a>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#homeSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"><i class="material-icons">keyboard_arrow_left</i></span>
                    <span class="sr-only">Назад</span>
                </a>
                <a class="carousel-control-next" href="#homeSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"><i class="material-icons">keyboard_arrow_right</i></span>
                    <span class="sr-only">Вперед</span>
                </a>
            </div>
        </div>
    </section>

    <section class="tabs">
        <div class="container content-container">
            <div class="row tabs-wrapper">
                <div class="col-md-4 transition-3s tab active">Популярные товары</div>
                <div class="col-md-4 transition-3s tab">Новинки</div>
                <div class="col-md-4 transition-3s tab">Продукты со скидками</div>
            </div>
        </div>
    </section>

    <section class="products-table-catalog">
        <div class="container content-container">
            <div class="row">


                <?php
                $loop = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'orderby' => []
                    )
                );
                while ($loop->have_posts()) : $loop->the_post();?>
                <?php $product = wc_get_product( get_the_ID() );?>

                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                        <a href="<?php the_permalink();?>" class="link">
                            <div class="image-wrapper text-center transition-3s">
                                <img src="<?= get_template_directory_uri(); ?>/images/item1.png">
                            </div>
                        </a>
                        <div class="info">
                            <div class="title"><?php the_title(); ?></div>
                            <div class="advantages">
                                <ul>
                                    <li>Ультра высокое качество изображения</li>
                                    <li>Покрытие eBAND</li>
                                    <li>Двойной микропроцессор Dual MPU</li>
                                </ul>
                            </div>
                            <div class="price"><?=$product->get_price_html();?></div>
                            <div class="buttons">
                                <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                                <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                                <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                                <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
                    wp_reset_query(); ?>



                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item2.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Студийная вспышка Rime Lite i.4 TTL</div>
                        <div class="advantages">
                            <ul>
                                <li>Работа вспышки в автоматическом TTL или в ручном режиме</li>
                                <li>Совместимость с системами Canon E-TTL II и Nikon i-TTL</li>
                                <li>Короткий импульс до 1/12800 секунды</li>
                            </ul>
                        </div>
                        <div class="price">$ 687</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item3.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Штатив профессиональный Photex VT-1550 PRO</div>
                        <div class="advantages">
                            <ul>
                                <li>Максимальная высота съемки 155см</li>
                                <li>Минимальная высота съемки 43см</li>
                                <li>Длина в сложенном состоянии 550мм</li>
                            </ul>
                        </div>
                        <div class="price">$ 73</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item4.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Софтбокс для накамерных вспышек Lastolite Hotrod Strip Softbox</div>
                        <div class="advantages">
                            <ul>
                                <li>Размер 30 x 120 см</li>
                                <li>Оснащен внутренней панелью рассеивания света и установочным адаптерным кольцом</li>
                                <li>Oбеспечивает узконаправленную полосу света</li>
                            </ul>
                        </div>
                        <div class="price">$ 140</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item1.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Объектив	Tamron 70-210mm F/4 Di VC USD</div>
                        <div class="advantages">
                            <ul>
                                <li>Ультра высокое качество изображения</li>
                                <li>Покрытие eBAND</li>
                                <li>Двойной микропроцессор Dual MPU</li>
                            </ul>
                        </div>
                        <div class="price">$ 799</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item2.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Студийная вспышка Rime Lite i.4 TTL</div>
                        <div class="advantages">
                            <ul>
                                <li>Работа вспышки в автоматическом TTL или в ручном режиме</li>
                                <li>Совместимость с системами Canon E-TTL II и Nikon i-TTL</li>
                                <li>Короткий импульс до 1/12800 секунды</li>
                            </ul>
                        </div>
                        <div class="price">$ 687</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item3.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Штатив профессиональный Photex VT-1550 PRO</div>
                        <div class="advantages">
                            <ul>
                                <li>Максимальная высота съемки 155см</li>
                                <li>Минимальная высота съемки 43см</li>
                                <li>Длина в сложенном состоянии 550мм</li>
                            </ul>
                        </div>
                        <div class="price">$ 73</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item4.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Софтбокс для накамерных вспышек Lastolite Hotrod Strip Softbox</div>
                        <div class="advantages">
                            <ul>
                                <li>Размер 30 x 120 см</li>
                                <li>Оснащен внутренней панелью рассеивания света и установочным адаптерным кольцом</li>
                                <li>Oбеспечивает узконаправленную полосу света</li>
                            </ul>
                        </div>
                        <div class="price">$ 140</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a href="#" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img src="<?= get_template_directory_uri(); ?>/images/item1.png">
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">Объектив	Tamron 70-210mm F/4 Di VC USD</div>
                        <div class="advantages">
                            <ul>
                                <li>Ультра высокое качество изображения</li>
                                <li>Покрытие eBAND</li>
                                <li>Двойной микропроцессор Dual MPU</li>
                            </ul>
                        </div>
                        <div class="price">$ 799</div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <button class="transition-3s like-btn"><i class="far fa-heart"></i></button>
                            <button class="transition-3s compare-btn"><i class="fas fa-balance-scale"></i></button>
                            <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> Купить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="view-more-btn transition-3s">Загрузить еще (9)</button>
                </div>
            </div>
        </div>
    </section>

    <section class="banners">
        <div class="container banners-title">
            <div class="row">
                <div class="col-md-12">
                    <h1>Принуждаем к фотографии</h1>
                </div>
            </div>
        </div>
        <div class="container banners-wrapper">
            <div class="banners-slider">
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner1.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner2.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner3.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner1.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner2.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner3.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="timer-offer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row offer-wrapper">
                        <div class="col-md-3 d-flex justify-content-center flex-column">
                            <div class="image-wrapper">
                                <img width="100%" src="<?= get_template_directory_uri(); ?>/images/timer-offer1.png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <h4>Горячее предложение</h4>
                                <h1>Объектив + Светофильтр</h1>
                                <p>При покупке объектива Tamron SP 24-70мм F/2.8 Di VC USD G2, светофильтр Marumi CREATION VARI. ND2.5-ND500 в подарок!</p>
                                <div class="price"></div>
                                <div id="timer" class="timer"></div>
                                <button class="btn transition-3s">Узнать подробнее</button>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center flex-column">
                            <div class="image-wrapper">
                                <img width="100%" src="<?= get_template_directory_uri(); ?>/images/timer-offer2.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="banners news">
        <div class="container banners-title">
            <div class="row">
                <div class="col-md-12">
                    <h1>Наши публикации</h1>
                </div>
            </div>
        </div>
        <div class="container banners-wrapper">
            <div class="banners-slider">
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner1.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner2.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner3.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner1.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner2.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
                <div class="banner">
                    <a href="#">
                        <img width="100%" height="100%" src="<?= get_template_directory_uri(); ?>/images/banner3.jpg">
                        <div class="hover transition-3s"></div>
                        <div class="description">
                            <h1>Заголовок</h1>
                            <p>Текст текст текст</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="subscription">
        <div class="container">
            <div class="row justify-content-center no-marg">
                <div class="col-md-6 text-center">
                    <p class="title">Подпишитесь на наши новости</p>
                    <p class="text">Будьте в курсе новостей, продуктов и событий Prophoto</p>
                    <div class="d-flex justify-content-center">
                        <div class="relative">
                            <input class="transition-3s" type="text" name="email" placeholder="Введите свой email">
                            <i class="far fa-paper-plane icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="global-widgets">
        <div class="transition-3s action-btn"><i class="fas fa-phone icon"></i></div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            setTimer('timer', 'July 25, 2021 15:37:25');


            if ( $("body").width() > 575 ){
                setProductsSimilarHeight(".products-table-catalog .product");
            }
            iniBannersSlider(".news");
            iniBannersSlider(".banners");
        })

    </script>

<?php
get_footer();