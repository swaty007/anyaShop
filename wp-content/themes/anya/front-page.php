<?php


get_header();
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
                        <a href="#" class="d-block"><img widht="100%"
                                                         src="<?= get_template_directory_uri(); ?>/images/homepage_slider/slide1_desktop.png"
                                                         alt="First slide"></a>
                    </div>
                    <div class="carousel-item">
                        <a href="#" class="d-block"><img widht="100%"
                                                         src="<?= get_template_directory_uri(); ?>/images/homepage_slider/slide1_desktop.png"
                                                         alt="First slide"></a>
                    </div>
                    <div class="carousel-item">
                        <a href="#" class="d-block"><img widht="100%"
                                                         src="<?= get_template_directory_uri(); ?>/images/homepage_slider/slide1_desktop.png"
                                                         alt="First slide"></a>
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

<div id="main-page-magazine">
    <section class="tabs">
        <div class="container content-container">
            <div class="row tabs-wrapper">
                <div class="col-md-4 transition-3s tab" :class="{ 'active' : tab === 'popular'}" @click="tab = 'popular'">
                    Популярные товары</div>
                <div class="col-md-4 transition-3s tab" :class="{ 'active' : tab === 'new'}" @click="tab = 'new'">
                    Новинки</div>
                <div class="col-md-4 transition-3s tab" :class="{ 'active' : tab === 'discount'}" @click="tab = 'discount'">
                    Продукты со скидками</div>
            </div>
        </div>
    </section>

    <section class="products-table-catalog">
        <div class="container content-container">
            <div class="row">



                <div v-for="product in products" :key="product.ID" class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                    <a :href="product.guid" class="link">
                        <div class="image-wrapper text-center transition-3s">
                            <img :src="product.thumbnail_url" />
                        </div>
                    </a>
                    <div class="info">
                        <div class="title">
                            {{product.post_title}}
                        </div>
                        <div class="advantages">
                            <?php //wc_display_product_attributes($product); ?>
                        </div>
                        <div v-html="product.price_html" class="price">

                        </div>
                        <div class="buttons">
                            <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                            <a class="transition-3s like-btn tinvwl_add_to_wishlist_button"
                               role="button"
                               aria-label="Add to Wishlist"
                               data-tinv-wl-list="[]"
                               :data-tinv-wl-product="product.ID"
                               data-tinv-wl-productvariation="0"
                               data-tinv-wl-productvariations="[0]"
                               data-tinv-wl-producttype="simple"
                               data-tinv-wl-action="add">
                                <i class="far fa-heart"></i>
                            </a>

                            <button :data-id="product.ID"
                                    :class="`br_product_${product.ID} ${product.class_compare}`"
                                    class="transition-3s compare-btn br_compare_button">
                                <i class="fas fa-balance-scale"></i>
                            </button>

                            <button class="transition-3s buy-btn"
                                    :data-sku="product.sku"
                                    :data-id="product.ID">
                                <i class="fas fa-cart-plus icon"></i> Купить
                            </button>
                        </div>
                    </div>
                </div>

<!--                --><?php
//                $loop = new WP_Query(array(
//                        'post_type' => 'product',
//                        'posts_per_page' => 20,
//                        'orderby' => [],
//                        'meta_query' => [
//                            [
//                                'key' => '_stock_status',
//                                'value' => 'instock',
//                                'compare' => '=',
//                            ]
//                        ]
//                    )
//                );
//                while ($loop->have_posts()) : $loop->the_post(); ?>
<!--                    --><?php
//                    $product = wc_get_product($post->ID);
//                    $sku = $product->get_sku();
//                    ?>
<!---->
<!--                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">-->
<!--                        <a href="--><?php //the_permalink(); ?><!--" class="link">-->
<!--                            <div class="image-wrapper text-center transition-3s">-->
<!--                                                             <img src="-->
<!--                                --><?// //= get_template_directory_uri(); ?><!--/images/item1.png">-->
<!--                                --><?//= woocommerce_get_product_thumbnail('full'); ?>
<!--                            </div>-->
<!--                        </a>-->
<!--                        <div class="info">-->
<!--                            <div class="title">--><?php //the_title(); ?><!--</div>-->
<!--                            <div class="advantages">-->
<!--                                                            --><?php ////wc_display_product_attributes($product); ?>
<!--                            </div>-->
<!--                            <div class="price">-->
<!--                                --><?//= $product->get_price_html(); ?>
<!--                            </div>-->
<!--                            <div class="buttons">-->
<!--                                 <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
<!--                                <a class="transition-3s like-btn tinvwl_add_to_wishlist_button"-->
<!--                                   role="button"-->
<!--                                   aria-label="Add to Wishlist"-->
<!--                                   data-tinv-wl-list="[]"-->
<!--                                   data-tinv-wl-product="--><?//= $post->ID; ?><!--"-->
<!--                                   data-tinv-wl-productvariation="0"-->
<!--                                   data-tinv-wl-productvariations="[0]"-->
<!--                                   data-tinv-wl-producttype="simple"-->
<!--                                   data-tinv-wl-action="add">-->
<!--                                    <i class="far fa-heart"></i>-->
<!--                                </a>-->
<!---->
<!--                                <button data-id="--><?//= $post->ID; ?><!--"-->
<!--                                        class="transition-3s compare-btn br_compare_button br_product_--><?//= $post->ID; ?><!-- --><?//= set_class_compare($post->ID); ?><!--">-->
<!--                                    <i class="fas fa-balance-scale"></i>-->
<!--                                </button>-->
<!---->
<!--                                <button class="transition-3s buy-btn"-->
<!--                                        data-sku="--><?//= $sku; ?><!--"-->
<!--                                        data-id="--><?//= $post->ID; ?><!--">-->
<!--                                    <i class="fas fa-cart-plus icon"></i> Купить-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                --><?php //endwhile;
//                wp_reset_query(); ?>

            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button v-if="total_pages > page" class="view-more-btn transition-3s" @click="loadMore">Загрузить еще (9)</button>
                </div>
            </div>
        </div>
    </section>
</div>




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
                                <p>При покупке объектива Tamron SP 24-70мм F/2.8 Di VC USD G2, светофильтр Marumi
                                    CREATION VARI. ND2.5-ND500 в подарок!</p>
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
        window.addEventListener('load', function () {
            setTimer('timer', 'July 25, 2021 15:37:25');


            if ($("body").width() > 575) {
                setProductsSimilarHeight(".products-table-catalog .product");
            }
            iniBannersSlider(".banners");
        })

    </script>

<?php
get_footer();
