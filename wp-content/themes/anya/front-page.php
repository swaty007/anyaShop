<?php


get_header();
?>


    <section class="home-slider">
        <div class="container no-pad">
            <div id="homeSlider" class="carousel slide" data-ride="carousel" data-interval="8000">
                <div class="carousel-inner" role="listbox">
                    <?php $loop = new WP_Query(array(
                            'post_type' => 'slider',
                            'posts_per_page' => -1,
                        )
                    ); ?>
                    <?php $count = 0;
                    while ($loop->have_posts()) : $loop->the_post();
                        $count++;
                        $button_link = get_post_meta($post->ID, 'button_link', true);
                        $button_text = get_post_meta($post->ID, 'button_text', true);
                        ?>
                        <div class="carousel-item <?= $count === 1 ? 'active' : ''; ?>">
                            <div class="d-block">
                                <img widht="100%"
                                     style="object-fit: <?= get_post_meta($post->ID, 'object_fit', true); ?>"
                                     src="<?php the_post_thumbnail_url(); ?>"
                                     alt="First slide">
                                <? //= get_template_directory_uri(); ?><!--/images/homepage_slider/slide1_desktop.png-->
                                <div class="slider__text one">
                                    <?php the_title(); ?>
                                </div>
                                <div class="slider__text two">
                                    <?php the_excerpt(); ?>
                                </div>
                                <div class="slider__text three">
                                    <?php the_content(); ?>
                                </div>
                                <?php if ($button_text): ?>
                                    <a href="<?= $button_link; ?>"
                                       class="slider__text four">
                                        <?= $button_text; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $count > $i; $i++): ?>
                        <li data-target="#homeSlider" data-slide-to="<?= $i; ?>"
                            class="<?= $i === 0 ? 'active' : ''; ?>"></li>
                    <?php endfor; ?>
                </ol>
                <a class="carousel-control-prev" href="#homeSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"><i class="material-icons">keyboard_arrow_left</i></span>
                    <span class="sr-only">??????????</span>
                </a>
                <a class="carousel-control-next" href="#homeSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"><i class="material-icons">keyboard_arrow_right</i></span>
                    <span class="sr-only">????????????</span>
                </a>
            </div>
        </div>
    </section>

    <div id="main-page-magazine">
        <section class="tabs">
            <div class="container content-container">
                <div class="row tabs-wrapper">
                    <div class="col-md-3 transition-3s tab" :class="{ 'active' : tab === 'popular'}"
                         @click="tab = 'popular'">
                        <?php pll_e("???????????????????? ????????????"); ?>
                    </div>
                    <div class="col-md-3 transition-3s tab" :class="{ 'active' : tab === 'new'}" @click="tab = 'new'">
                        <?php pll_e("??????????????"); ?>
                    </div>
                    <div class="col-md-3 transition-3s tab" :class="{ 'active' : tab === 'discount'}"
                         @click="tab = 'discount'">
                        <?php pll_e("???????????????? ???? ????????????????"); ?>
                    </div>
                    <div class="col-md-3 transition-3s tab" :class="{ 'active' : tab === 'rent'}"
                         @click="tab = 'rent'">
                        <?php pll_e("????????????"); ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="products-table-catalog">
            <div class="container content-container">
                <div class="row">


                    <div v-for="product in products" :key="product.ID"
                         class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                        <a :href="product.guid" class="link">
                            <div class="image-wrapper text-center transition-3s">
                                <img :src="product.thumbnail_url" :alt="product.post_title"/>
                            </div>
                        </a>
                        <div class="info">
                            <div class="title">
                                {{product.post_title}}
                            </div>
                            <div class="advantages">
                                <?php //wc_display_product_attributes($product); ?>
                            </div>
                            <div v-if="product.rent_price && tab === 'rent'" class="price price__rent">
                                <span class="pull-left">
                                    <?php pll_e("???????? ??????????????:"); ?>
                                </span>
                                <span class="woocommerce-Price-amount amount">
                                    <bdi>
                                        <span class="woocommerce-Price-currencySymbol">???</span>{{ product.rent_price }}
                                    </bdi>
                                </span>
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
                                    <i class="fas fa-cart-plus icon"></i> <?php pll_e("????????????"); ?>
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
                    <!--                                -->
                    <?// //= get_template_directory_uri(); ?><!--/images/item1.png">-->
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
                    <!--                                        class="transition-3s compare-btn br_compare_button br_product_-->
                    <?//= $post->ID; ?><!-- --><?//= set_class_compare($post->ID); ?><!--">-->
                    <!--                                    <i class="fas fa-balance-scale"></i>-->
                    <!--                                </button>-->
                    <!---->
                    <!--                                <button class="transition-3s buy-btn"-->
                    <!--                                        data-sku="--><?//= $sku; ?><!--"-->
                    <!--                                        data-id="--><?//= $post->ID; ?><!--">-->
                    <!--                                    <i class="fas fa-cart-plus icon"></i> ????????????-->
                    <!--                                </button>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                --><?php //endwhile;
                    //                wp_reset_query(); ?>

                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button v-if="total_pages > page && products.length" class="view-more-btn transition-3s"
                                @click="loadMore">
                            <?php pll_e("?????????????????? ??????"); ?> (9)
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <section class="timer-offer">
        <div class="container">
            <div class="row">

                <div class="bundle__slider">
                    <?php
                    $loop = new WP_Query(array(
                            'post_type' => 'product',
                            'posts_per_page' => -1,
                            'orderby' => [],
                            'meta_query' => [
                                [
                                    'key' => '_yith_wcpb_bundle_data',
//                                'value' => 'instock',
                                    'compare' => 'EXIST',
                                ]
                            ]
                        )
                    );
                    while ($loop->have_posts()) : $loop->the_post();
                        $gallery = get_post_meta($post->ID, '_product_image_gallery', true);
                        $product_bundle = wc_get_product($post->ID);
                        if (!empty($gallery)) {
                            $gallery = explode(",", $gallery);
                        }
                        ?>
                        <div class="col-md-12">
                            <div class="row offer-wrapper">
                                <div class="col-md-3 d-flex justify-content-center flex-column">
                                    <div class="image-wrapper">
                                        <?php if (!empty($gallery[0])): ?>
                                            <?php $bundle_image_url = get_url_from_img_id($gallery[0]);
                                            if (!empty($bundle_image_url)):?>
                                                <img src="<?= $bundle_image_url; ?>" alt="<?=$gallery[0];?>"/>
                                            <?php else: ?>
                                                <img src="<?= wc_placeholder_img_src(); ?>" alt="placeholder"/>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <h4>
                                            <?php pll_e("?????????????? ??????????????????????"); ?>
                                        </h4>
                                        <h2 class="offer-title">
                                            <?php the_title(); ?>
                                        </h2>
                                        <div class="offer-text">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="price">
                                            <?= $product_bundle->get_price_html(); ?>
                                        </div>
                                        <div id="timer" class="timer"></div>
                                        <!--                                    <script type="text/javascript">-->
                                        <!--                                        window.addEventListener('load', function () {-->
                                        <!--                                            setTimer('timer', 'July 25, 2021 15:37:25');-->
                                        <!--                                        });-->
                                        <!--                                    </script>-->
                                        <a href="<?php the_permalink(); ?>" class="btn transition-3s offer-button">
                                            <?php pll_e("???????????? ??????????????????"); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex justify-content-center flex-column">
                                    <div class="image-wrapper">
                                        <?php if (!empty($gallery[1])): ?>
                                            <?php $bundle_image_url = get_url_from_img_id($gallery[1]);
                                            if (!empty($bundle_image_url)):?>
                                                <img src="<?= $bundle_image_url; ?>" alt="<?=$gallery[1];?>"/>
                                            <?php else: ?>
                                                <img src="<?= wc_placeholder_img_src(); ?>" alt="placeholder"/>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>
            </div>
        </div>
    </section>

    <section class="banners news">
        <div class="container banners-title">
            <div class="row">
                <div class="col-md-12">
                    <h2>
                        <?php pll_e("???????? ????????????????????"); ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="banners-wrapper">
                <div class="responsive">
                    <?php
                    $loop = new WP_Query(array(
                            'post_type' => 'post',
                            'posts_per_page' => 10,
                            'orderby' => [],
                        )
                    );
                    while ($loop->have_posts()) : $loop->the_post(); ?>

                        <div class="banner">
                            <a href="<?php the_permalink(); ?>">
                                <img width="100%" height="100%" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                <div class="hover transition-3s"></div>
                                <div class="description">
                                    <h4 class="description__title"><?php the_title(); ?></h4>
                                    <!--                                    <div>-->
                                    <? //= mb_substr(get_the_excerpt(), 0, 90); ?><!--...</div>-->
                                </div>
                            </a>
                        </div>

                    <?php endwhile;
                    wp_reset_query(); ?>
                </div>
            </div>

        </div>
    </section>
<?= get_template_part('template-parts/components-subscription', 'form'); ?>

    <!--    <div class="global-widgets">-->
    <!--        <div class="transition-3s action-btn"><i class="fas fa-phone icon"></i></div>-->
    <!--    </div>-->

    <script type="text/javascript">
        window.addEventListener('load', function () {
            // setTimer('timer', 'July 25, 2021 15:37:25');


            if ($("body").width() > 575) {
                setProductsSimilarHeight(".products-table-catalog .product");
            }
            // iniBannersSlider(".banners");


            $('.bundle__slider').slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
            })
            $('.responsive').slick({
                dots: true,
                infinite: false,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 1,
                // centerPadding: '60px',
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        })

    </script>

<?php
get_footer();
