<?php
get_header();
the_post();
$product = wc_get_product($post->ID);
$productStock = $product->get_stock_status() === 'instock';
$sku = $product->get_sku();

$youtube = get_post_meta($post->ID, 'youtube', true);
$gallery = get_post_meta($post->ID, '_product_image_gallery', true);
if (!empty($gallery)) {
    $gallery = explode(",", $gallery);
}
$additional_information = get_post_meta($post->ID, 'additional_information', true); //repeater
$additional_materials = get_post_meta($post->ID, 'additional_materials', true); //repeater
$vc_icon = get_post_meta($post->ID, 'vc_icon', true);
$usd_icon = get_post_meta($post->ID, 'usd_icon', true);
$eband_icon = get_post_meta($post->ID, 'eband_icon', true);
//woocommerce_template_loop_add_to_cart();
//the_content();
?>


<section class="product-fixed-menu transition-3s">
    <div class="container content-container">
        <div class="row">
            <div class="col-md-12 d-flex align-items-center justify-content-between desktop">
                <div class="d-flex align-items-center">
                    <img width="50px" src="<?= get_the_post_thumbnail_url(); ?>">
                    <!--                    --><? //= woocommerce_get_product_thumbnail();?>
                    <span class="product-title"><?php the_title(); ?></span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="price"><?= $product->get_price_html(); ?></span>
                    <?php if ($productStock): ?>
                        <button class="transition-3s buy-btn"><i class="fas fa-cart-plus icon"></i> В корзину</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12 tablet-mobile">
                <div class="image-title d-flex align-items-center">
                    <img width="50px" src="<?= get_the_post_thumbnail_url(); ?>">
                    <!--                    --><? //= woocommerce_get_product_thumbnail();?>
                    <span class="product-title"><?php the_title(); ?></span>
                </div>
                <div class="price-btn">
                    <span class="price"><?= $product->get_price_html(); ?></span>
                    <?php if ($productStock): ?>
                        <button class="transition-3s buy-btn" data-sku="<?= $sku; ?>" data-id="<?= $post->ID; ?>">
                            <i class="fas fa-cart-plus icon"></i> В корзину
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="product-menu">
                    <div class="anchor-link-menu d-flex flex-nowrap">
                        <div class="transition-3s d-flex link active">
                            <a class="anchor-link" href="#review">Описание</a>
                        </div>
                        <div class="transition-3s d-flex link">
                            <a class="anchor-link" href="#specifications">Характеристики
                                и особенности</a>
                        </div>
                        <?php if (have_rows('additional_materials')): ?>
                            <div class="transition-3s d-flex link">
                                <a class="anchor-link" href="#materials">
                                    Дополнительные материалы</a>
                            </div>
                        <?php endif; ?>
                        <div class="transition-3s d-flex link">
                            <a class="anchor-link" href="#related-products">Похожие
                                товары
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-page">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-3 col-md-2 col-lg-2 col-xl-2">
                <a href="<?= get_the_post_thumbnail_url(); ?>" data-fancybox="gallery">
                    <img class="product-avatar"
                         src="<?= get_the_post_thumbnail_url(); ?>">
                </a>

                <!--                <div class="product-avatar">-->
                <!--                    --><? //= woocommerce_get_product_thumbnail();?>
                <!--                </div>-->
            </div>
            <div class="col-12 col-sm-9 col-md-10 col-lg-7 col-xl-7">
                <a class="back-link d-flex align-items-center" href="#"><i
                            class="material-icons">keyboard_arrow_left</i><span>Объективы</span></a>
                <h1 class="product-title"><?php the_title(); ?></h1>
                <div class="price-info">
                    <button data-id="<?=$post->ID;?>"
                            class="transition-3s compare-btn add_to_cart_button br_compare_button br_product_<?=$post->ID;?> <?= set_class_compare($post->ID);?>">
                        <i class="fas fa-balance-scale"></i>
                        Сравнить
                    </button>
                    <button class="transition-3s like-btn"><i class="far fa-heart"></i> Добавить в избранное</button>
                    <div class="status">
                        <?= wc_get_stock_html($product); ?>
                    </div>
                    <div class="line"></div>
                </div>
                <div class="additional-options">
                    <div class="option-wrapper">
                        <h3>Количество:</h3>
                        <span id="amount_checker" class="amount-checker"
                              data-min="<?= $product->get_min_purchase_quantity(); ?>"
                              data-max="<?= $product->get_max_purchase_quantity(); ?>">
							<button class="minus">-</button>
							<span class="amount-value">1</span>
							<button class="plus">+</button>
						</span>
                    </div>
                    <!--                    <div class="option-wrapper">-->
                    <!--                        <h3>Размер:</h3>-->
                    <!--                        <ul>-->
                    <!--                            <li class="transition-3s active">12</li>-->
                    <!--                            <li class="transition-3s">24</li>-->
                    <!--                            <li class="transition-3s">36</li>-->
                    <!--                            <li class="transition-3s">48</li>-->
                    <!--                            <li class="transition-3s">60</li>-->
                    <!--                        </ul>-->
                    <!--                    </div>-->
                    <div class="option-wrapper">
                        <h3>Код товара:</h3>
                        <ul>
                            <li class="transition-3s"><?= $sku; ?></li>
                        </ul>
                    </div>
                    <div class="option-wrapper tablet-view">
                        <div class="price-info">
                            <?php if ($productStock): ?>
                                <button class="transition-3s buy-btn" data-sku="<?= $sku; ?>"
                                        data-id="<?= $post->ID; ?>">
                                    <i class="fas fa-cart-plus icon"></i> В корзину
                                </button>
                            <?php endif; ?>
                            <div class="price align-items-center d-flex">
                                <?= $product->get_price_html(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 d-sm-block d-md-none d-lg-block col-lg-3 d-xl-block col-xl-3">
                <div class="price-info">
                    <?php if ($productStock): ?>
                        <button class="transition-3s buy-btn" data-sku="<?= $sku; ?>" data-id="<?= $post->ID; ?>">
                            <i class="fas fa-cart-plus icon"></i> В корзину
                        </button>
                    <?php endif; ?>
                    <div class="price align-items-center d-flex">
                        <?= $product->get_price_html(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="anchor-link-menu d-flex flex-nowrap">
                        <div class="transition-3s d-flex link active"><a class="anchor-link" href="#review">Описание</a>
                        </div>
                        <div class="transition-3s d-flex link"><a class="anchor-link" href="#specifications">Характеристики
                                и особенности</a></div>
                        <div class="transition-3s d-flex link"><a class="anchor-link" href="#materials">Дополнительные
                                материалы</a></div>
                        <div class="transition-3s d-flex link"><a class="anchor-link" href="#related-products">Похожие
                                товары</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($gallery)): ?>
        <div id="review" class="image-slider">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-8 offset-2 col-lg-6 offset-lg-3">
                                <div class="text-center relative" style="z-index: 4;">
                                    <div class="active-slide">
                                        <a href="<?= get_url_from_img_id($gallery[0]) ?>" data-fancybox="gallery">
                                            <img src="<?= get_url_from_img_id($gallery[0]) ?>">
                                        </a>

                                        <h2><?php the_title(); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slides d-flex justify-content-center">
                            <?php foreach ($gallery as $i => $image): ?>
                                <div class="slide transition-3s <?php if ($i === 0) echo "active"; ?>">
                                    <img data-title="Объектив Tamron SP 24-70mm Nicon <?php if ($i !== 0) echo $i; ?>"
                                         src="<?= get_url_from_img_id($image) ?>">
                                </div>
                            <?php endforeach; ?>


                            <!--                        <div class="slide transition-3s"><img data-title="Объектив Tamron SP 24-70mm Nicon 2"-->
                            <!--                                                              src="-->
                            <? //= get_template_directory_uri(); ?><!--/images/product/avatar.png">-->
                            <!--                        </div>-->
                            <!--                        <div class="slide transition-3s"><img data-title="Объектив Tamron SP 24-70mm Nicon 3"-->
                            <!--                                                              src="-->
                            <? //= get_template_directory_uri(); ?><!--/images/product/1.png">-->
                            <!--                        </div>-->
                            <!--                        <div class="slide transition-3s"><img data-title="Объектив Tamron SP 24-70mm Nicon 4"-->
                            <!--                                                              src="-->
                            <? //= get_template_directory_uri(); ?><!--/images/product/3.png">-->
                            <!--                        </div>-->
                            <!--                        <div class="slide transition-3s"><img data-title="Объектив Tamron SP 24-70mm Nicon 5"-->
                            <!--                                                              src="-->
                            <? //= get_template_directory_uri(); ?><!--/images/product/4.png">-->
                            <!--                        </div>-->
                        </div>
                        <div class="navigation d-flex justify-content-between">
                            <button data-value="prev"><i class="material-icons">keyboard_arrow_left</i></button>
                            <button data-value="next"><i class="material-icons">keyboard_arrow_right</i></button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <div id="specifications" class="specifications">
        <div class="container content-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-text">
                                    <div class="container">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12 text-left" style="white-space: pre-line;">
                                                <?= get_post($post->ID)->post_content; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3>Характеристики и особенности</h3>
                            </div>
                            <div class="col-md-4">
                                <ul class="specifications-list">
                                    <li>
                                        <h3 class="specifications-title">Фокусное расстояние:</h3>
                                        <h3 class="specifications-value">24-70</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Максимальная диафрагма:</h3>
                                        <h3 class="specifications-value">F/2.8</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Минимальное расстояние фокусировки:</h3>
                                        <h3 class="specifications-value">0,38 мм</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Максимальное отношение увеличения:</h3>
                                        <h3 class="specifications-value">1:5</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Размер светофильтра:</h3>
                                        <h3 class="specifications-value">82 мм</h3>
                                    </li>
                                    <div class="full-specifications">
                                        <li>
                                            <h3 class="specifications-title">Максимальное отношение увеличения:</h3>
                                            <h3 class="specifications-value">1:5</h3>
                                        </li>
                                        <li>
                                            <h3 class="specifications-title">Размер светофильтра:</h3>
                                            <h3 class="specifications-value">82 мм</h3>
                                        </li>
                                        <li>
                                            <h3 class="specifications-title">Минимальное расстояние фокусировки:</h3>
                                            <h3 class="specifications-value">0,38 мм</h3>
                                        </li>
                                    </div>
                                </ul>
                                <button class="view-full-specifications transition-3s">Все характеристики</button>
                                <button class="transition-3s"><i class="fas fa-balance-scale"></i> Сравнить</button>
                            </div>
                            <div class="col-md-4">
                                <ul class="specifications-list">
                                    <li>
                                        <h3 class="specifications-title">Группы / элементы:</h3>
                                        <h3 class="specifications-value">12 / 17</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Лепестки диафрагмы:</h3>
                                        <h3 class="specifications-value">9</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Угол обзора:</h3>
                                        <h3 class="specifications-value">84°04'-34°21'</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Минимальная диафрагма:</h3>
                                        <h3 class="specifications-value">F/22</h3>
                                    </li>
                                    <li>
                                        <h3 class="specifications-title">Вес:</h3>
                                        <h3 class="specifications-value">Canon - 905 г <br> Nikon - 900 г</h3>
                                    </li>
                                    <div class="full-specifications">
                                        <li>
                                            <h3 class="specifications-title">Минимальная диафрагма:</h3>
                                            <h3 class="specifications-value">F/22</h3>
                                        </li>
                                        <li>
                                            <h3 class="specifications-title">Вес:</h3>
                                            <h3 class="specifications-value">Canon - 905 г <br> Nikon - 900 г</h3>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <?php if (!empty($vc_icon)): ?>
                                    <div class="feature">
                                        <img src="<?= get_template_directory_uri(); ?>/images/product/f1.png">
                                        <div class="title">VC (компенсация вибраций)</div>
                                        <div class="text">Стабилизатор изображения VC обеспечивает резкое изображение
                                            без
                                            дрожания, а также обеспечивает резкое изображение в видоискателе.
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($usd_icon)): ?>
                                    <div class="feature">
                                        <img src="<?= get_template_directory_uri(); ?>/images/product/f2.png">
                                        <div class="title">USD (ультразвуковой мотор)</div>
                                        <div class="text">Мощный ультразвуковой двигатель для съемки быстрых и
                                            динамичных
                                            объектов. Чрезвычайно тихий и точный, позволяет осуществлять ручное
                                            управление
                                            фокусировкой во время съемки.
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="full-features">
                                    <?php if (!empty($eband_icon)): ?>
                                        <div class="feature">
                                            <img src="<?= get_template_directory_uri(); ?>/images/product/f3.png">
                                            <div class="title">Покрытие eBAND</div>
                                            <div class="text">Нано- антибликовое покрытие для защиты от нежелательных
                                                отражений и ореола.
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (have_rows('additional_information') || $youtube): ?>


        <div class="overview-componentets">
            <div class="container content-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-text">
                            <div class="container">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-7 text-center">
                                        <h3>Профото является эксклюзивным представителем в Украине известного мирового
                                            производителя компании Tamron.</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $count = 0;
                        while (have_rows('additional_information')): the_row(); ?>


                            <div class="image-text <?php if ($count % 2) echo 'text-image'; ?>">
                                <div class="container">
                                    <div class="row align-items-md-center justify-content-md-center">
                                        <div class="col-md-5 <?php if ($count % 2) echo 'order-md-2'; ?>">
                                            <div class="image-wrapper">
                                                <img width="100%"
                                                     src="<?= get_sub_field('img') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-wrapper">
                                            <?= get_sub_field('text') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $count++;endwhile; ?>

                        <!--                        <div class="image-text text-image">-->
                        <!--                            <div class="container">-->
                        <!--                                <div class="row">-->
                        <!--                                    <div class="col-md-6 text-wrapper">-->
                        <!--                                        <h2>Excepteur sint occaecat cupidatat non proident</h2>-->
                        <!--                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod-->
                        <!--                                            tempor-->
                        <!--                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.-->
                        <!--                                            Excepteur-->
                        <!--                                            sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt-->
                        <!--                                            mollit-->
                        <!--                                            anim id est laborum. <br><br> Sed quia consequuntur magni dolores eos qui-->
                        <!--                                            ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem-->
                        <!--                                            ipsum-->
                        <!--                                            quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius-->
                        <!--                                            modi-->
                        <!--                                            tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. <br><br>-->
                        <!--                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod-->
                        <!--                                            tempor-->
                        <!--                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis-->
                        <!--                                            nostrud exercitation ullamco laboris.-->
                        <!--                                        </p>-->
                        <!--                                    </div>-->
                        <!--                                    <div class="col-md-5">-->
                        <!--                                        <div class="image-wrapper">-->
                        <!--                                            <img width="100%"-->
                        <!--                                                 src="-->
                        <? //= get_template_directory_uri(); ?><!--/images/product/i1.jpg">-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <?php if (!empty($youtube)): ?>

                            <div class="video">
                                <div class="container">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12">
                                            <h2><?php the_title(); ?></h2>
                                            <iframe width="100%" height="600px"
                                                    src="https://www.youtube.com/embed/XC7ZUTmvZ1A?rel=0&amp;controls=0&amp;showinfo=0"
                                                    frameborder="0" allow="autoplay; encrypted-media"
                                                    allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (have_rows('additional_materials')): ?>


        <div id="materials" class="materials">
            <div class="container content-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3>Дополнительные материалы</h3>
                                </div>
                                <div class="col-md-12">
                                    <table width="100%">
                                        <thead>
                                        <tr>
                                            <td>Описание</td>
                                            <td class="text-center">Язык</td>
                                            <td class="text-center">Файл</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = 0;
                                        while (have_rows('additional_materials')): the_row(); ?>
                                            <?= get_sub_field('file') ?>
                                            <?php $count++;endwhile; ?>
                                        <tr>
                                            <td>Lorem ipsum dolor sit amet</td>
                                            <td class="text-center">Ru</td>
                                            <td class="text-center"><img
                                                        src="<?= get_template_directory_uri(); ?>/images/icon_pdf.png">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ut enim ad minim veniam</td>
                                            <td class="text-center">En</td>
                                            <td class="text-center"><img
                                                        src="<?= get_template_directory_uri(); ?>/images/icon_windows.png">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sed quia consequuntur</td>
                                            <td class="text-center">Ru</td>
                                            <td class="text-center"><img
                                                        src="<?= get_template_directory_uri(); ?>/images/icon_apple.png">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Neque porro quisquam est</td>
                                            <td class="text-center">En</td>
                                            <td class="text-center"><img
                                                        src="<?= get_template_directory_uri(); ?>/images/icon_linux.png">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div id="related-products" class="related-products">
        <div class="container content-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Похожие товары</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="products-table-catalog">
                                    <div class="row">
                                        <?php foreach (wc_get_related_products($post->ID, 3) as $related_product): ?>
                                            <?php
                                            $productWC = wc_get_product($related_product);
                                            $skuWC = $product->get_sku();
                                            ?>
                                            <div class="col-sm-12 col-md-6 col-lg-4 product">
                                                <a class="link" href="<?= get_the_permalink($related_product); ?>">
                                                    <div class="image-wrapper text-center transition-3s">
                                                        <?php
                                                        $related_image_url = get_the_post_thumbnail_url($related_product);
                                                        if (!empty($related_image_url)):?>
                                                            <img src="<?= $related_image_url; ?>">
                                                        <?php else: ?>
                                                            <img src="<?= wc_placeholder_img_src(); ?>">
                                                        <?php endif; ?>

                                                    </div>
                                                </a>
                                                <div class="info">
                                                    <a href="<?= get_the_permalink($related_product); ?>">
                                                        <div class="title">
                                                            <?= get_the_title($related_product); ?>
                                                        </div>
                                                    </a>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="buttons">
                                                            <button class="transition-3s like-btn"><i
                                                                        class="far fa-heart"></i></button>
                                                            <button data-id="<?=$related_product;?>"
                                                                    class="transition-3s compare-btn br_compare_button br_product_<?=$related_product;?> <?=set_class_compare($related_product);?>">
                                                                <i class="fas fa-balance-scale"></i>
                                                            </button>
                                                            <button class="transition-3s buy-btn"
                                                                    data-sku="<?= $skuWC; ?>"
                                                                    data-id="<?= $related_product; ?>">
                                                                <i class="fas fa-cart-plus icon"></i> Купить
                                                            </button>
                                                        </div>
                                                        <div class="price">
                                                            <?= $productWC->get_price_html(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

<script type="text/javascript">
    window.addEventListener('load', function () {
        if ($("body").width() > 575) {
            setProductsSimilarHeight(".products-table-catalog .product");
        }
    })
</script>

<?php get_footer(); ?>
