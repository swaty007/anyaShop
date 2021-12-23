<?php
get_header();
the_post();
$product = wc_get_product($post->ID);
$productStock = $product->get_stock_status() === 'instock';
$sku = $product->get_sku();

$term = get_the_terms($post->ID, 'product_cat')[0];
$term_id = $term->term_id;

$youtube = get_post_meta($post->ID, 'youtube', true);
$gallery = get_post_meta($post->ID, '_product_image_gallery', true);
if (!empty($gallery)) {
    $gallery = explode(",", $gallery);
} else {
    $gallery = [];
}
$additional_information = get_post_meta($post->ID, 'additional_information', true); //repeater
$additional_materials = get_post_meta($post->ID, 'additional_materials', true); //repeater
$vc_icon = get_post_meta($post->ID, 'vc_icon', true);
$usd_icon = get_post_meta($post->ID, 'usd_icon', true);
$eband_icon = get_post_meta($post->ID, 'eband_icon', true);

$attributes = [];
foreach ($product->get_attributes() as $attribute) {
    $attr_name = wc_attribute_label($attribute->get_name(), $product);
    $attributes[$attr_name] = [];
    foreach ($attribute->get_options() as $option) {
        $attributes[$attr_name][] = get_term($option, $attribute->get_name())->name;
    }
}
$attributes_column_size = 8;
$attributes_count = count($attributes);
$attributes_count_more = ceil(($attributes_count - $attributes_column_size) / 2);

$type = $product->get_type(); //yith_bundle, simple
$bundle_data = get_post_meta($post->ID, '_yith_wcpb_bundle_data', true);
if (empty($bundle_data)) {
    $bundle_data = [];
}
$bundle_products = [];
//the_content();
foreach ($bundle_data as $data) {
    $bundle_products[] = $data['product_id'];
    $data_gallery = get_post_meta($data['product_id'], '_product_image_gallery', true);
    if (!empty($data_gallery)) {
        $gallery = array_merge($gallery, explode(",", $data_gallery));
    }

}
?>

<section class="product-fixed-menu transition-3s">
    <div class="container content-container">
        <div class="row">
            <div class="col-md-12 d-flex align-items-center justify-content-between desktop">
                <div class="d-flex align-items-center">
                    <img width="50px" src="<?= get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    <!--                    --><? //= woocommerce_get_product_thumbnail();?>
                    <span class="product-title"><?php the_title(); ?></span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="price"><?= $product->get_price_html(); ?></span>
                    <?php if ($productStock): ?>
                        <button class="transition-3s buy-btn" data-sku="<?= $sku; ?>" data-id="<?= $post->ID; ?>">
                            <i class="fas fa-cart-plus icon"></i>
                            <?php pll_e("В корзину"); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12 tablet-mobile">
                <div class="image-title d-flex align-items-center">
                    <img width="50px" src="<?= get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    <!--                    --><? //= woocommerce_get_product_thumbnail();?>
                    <span class="product-title"><?php the_title(); ?></span>
                </div>
                <div class="price-btn">
                    <span class="price"><?= $product->get_price_html(); ?></span>
                    <?php if ($productStock): ?>
                        <button class="transition-3s buy-btn" data-sku="<?= $sku; ?>" data-id="<?= $post->ID; ?>">
                            <i class="fas fa-cart-plus icon"></i>
                            <?php pll_e("В корзину"); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="product-menu">
                    <div class="anchor-link-menu d-flex flex-nowrap">
                        <div class="transition-3s d-flex link active">
                            <a class="anchor-link" href="#review">
                                <?php pll_e("Описание"); ?>
                            </a>
                        </div>
                        <?php if (!empty($attributes)): ?>
                            <div class="transition-3s d-flex link">
                                <a class="anchor-link" href="#specifications">
                                    <?php pll_e("Характеристики и особенности"); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if (have_rows('additional_materials')): ?>
                            <div class="transition-3s d-flex link">
                                <a class="anchor-link" href="#materials">
                                    <?php pll_e("Дополнительные материалы"); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="transition-3s d-flex link">
                            <a class="anchor-link" href="#related-products">
                                <?php pll_e("Похожие товары"); ?>
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
                         src="<?= get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </a>

                <!--                <div class="product-avatar">-->
                <!--                    --><? //= woocommerce_get_product_thumbnail();?>
                <!--                </div>-->
            </div>
            <div class="col-12 col-sm-9 col-md-10 col-lg-7 col-xl-7">
                <a class="back-link d-flex align-items-center" href="<?= get_term_link($term_id); ?>">
                    <i class="material-icons">keyboard_arrow_left</i>
                    <span><?= $term->name; ?></span>
                </a>
                <h1 class="product-title"><?php the_title(); ?></h1>
                <div class="price-info">
                    <button data-id="<?= $post->ID; ?>"
                            class="transition-3s compare-btn add_to_cart_button br_compare_button br_product_<?= $post->ID; ?> <?= set_class_compare($post->ID); ?>">
                        <i class="fas fa-balance-scale"></i>
                        <?php pll_e("Сравнить"); ?>
                    </button>
                    <!--                    <button class="transition-3s like-btn"><i class="far fa-heart"></i> Добавить в избранное</button>-->
                    <div class="status">
                        <?= wc_get_stock_html($product); ?>
                    </div>
                    <div class="line"></div>
                </div>
                <div class="additional-options">
                    <div class="option-wrapper">
                        <h3><?php pll_e("Количество:"); ?></h3>
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
                        <h3><?php pll_e("Код товара:"); ?></h3>
                        <ul>
                            <li class="transition-3s"><?= $sku; ?></li>
                        </ul>
                    </div>
                    <div class="option-wrapper tablet-view">
                        <div class="price-info">
                            <?php if ($productStock): ?>
                                <button class="transition-3s buy-btn" data-sku="<?= $sku; ?>"
                                        data-id="<?= $post->ID; ?>">
                                    <i class="fas fa-cart-plus icon"></i> <?php pll_e("В корзину"); ?>
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
                            <i class="fas fa-cart-plus icon"></i> <?php pll_e("В корзину"); ?>
                        </button>
                    <?php endif; ?>
                    <div class="price align-items-center d-flex">
                        <?= $product->get_price_html(); ?>
                    </div>
                </div>

                <?php foreach ($bundle_products as $bundle_product): ?>
                    <div class="bundle__product align-items-center bundle__product d-flex justify-content-between">
                        <?php $related_image_url = get_the_post_thumbnail_url($bundle_product);
                        if (!empty($related_image_url)):?>
                            <img src="<?= $related_image_url; ?>" class="bundle__product--img">
                        <?php else: ?>
                            <img src="<?= wc_placeholder_img_src(); ?>" class="bundle__product--img">
                        <?php endif; ?>

                        <a href="<?= get_the_permalink($bundle_product); ?>" class="bundle__product--text">
                            <?= get_the_title($bundle_product); ?>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <div class="product-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="anchor-link-menu d-flex flex-nowrap">
                        <div class="transition-3s d-flex link active">
                            <a class="anchor-link" href="#review">
                                <?php pll_e("Описание"); ?>
                            </a>
                        </div>
                        <?php if (!empty($attributes)): ?>
                            <div class="transition-3s d-flex link">
                                <a class="anchor-link" href="#specifications">
                                    <?php pll_e("Характеристики и особенности"); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if (have_rows('additional_materials')): ?>
                            <div class="transition-3s d-flex link">
                                <a class="anchor-link" href="#materials">
                                    <?php pll_e("Дополнительные материалы"); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="transition-3s d-flex link">
                            <a class="anchor-link" href="#related-products">
                                <?php pll_e("Похожие товары"); ?>
                            </a>
                        </div>
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
                                            <img src="<?= get_url_from_img_id($gallery[0]) ?>" alt="<?php the_title(); ?>">
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
                                         data-fancybox="gallery"
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
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12 text-left"
                                             style="white-space: pre-line;line-height: 24px;">
                                            <?= get_post($post->ID)->post_content; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($attributes)): ?>

                                <div class="col-md-12">
                                    <h3 class="specifications__title">
                                        <?php pll_e("Характеристики и особенности"); ?>
                                    </h3>
                                </div>
                                <div class="col-md-4">
                                    <ul class="specifications-list">
                                        <?php
                                        $count = 0;
                                        foreach ($attributes as $label => $attributeArr):
                                            if ($count >= ceil($attributes_column_size / 2)) continue;
                                            ?>
                                            <li>
                                                <h3 class="specifications-title"><?= $label; ?>:</h3>
                                                <?php foreach ($attributeArr as $attribute): ?>
                                                    <p class="specifications-value"><?= $attribute; ?></p>
                                                <?php endforeach; ?>
                                            </li>
                                            <?php unset($attributes[$label]);
                                            $count++; endforeach; ?>
                                        <?php if ($attributes_count > $attributes_column_size): ?>
                                            <div class="full-specifications">
                                                <ul>
                                                    <?php
                                                    $count = 0;
                                                    foreach ($attributes as $label => $attributeArr):
                                                        if ($count >= $attributes_count_more) continue;
                                                        ?>
                                                        <li>
                                                            <h3 class="specifications-title"><?= $label; ?>:</h3>
                                                            <?php foreach ($attributeArr as $attribute): ?>
                                                                <p class="specifications-value"><?= $attribute; ?></p>
                                                            <?php endforeach; ?>
                                                        </li>
                                                        <?php unset($attributes[$label]);
                                                        $count++; endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </ul>
                                    <?php if ($attributes_count > $attributes_column_size): ?>
                                        <button class="view-full-specifications transition-3s">
                                        <span>
                                            <?php pll_e("Все характеристики"); ?>
                                        </span>
                                            <span class="d-none">
                                            <?php pll_e("Свернуть"); ?>
                                        </span>
                                        </button>
                                    <?php endif; ?>
                                    <!--                                <button class="transition-3s"><i class="fas fa-balance-scale"></i> Сравнить</button>-->
                                </div>
                                <div class="col-md-4">
                                    <ul class="specifications-list">
                                        <?php
                                        $count = 0;
                                        foreach ($attributes as $label => $attributeArr):
                                            if ($count >= ceil($attributes_column_size / 2)) continue;
                                            ?>
                                            <li>
                                                <h3 class="specifications-title"><?= $label; ?>:</h3>
                                                <?php foreach ($attributeArr as $attribute): ?>
                                                    <p class="specifications-value"><?= $attribute; ?></p>
                                                <?php endforeach; ?>
                                            </li>
                                            <?php unset($attributes[$label]);
                                            $count++; endforeach; ?>
                                        <?php if ($attributes_count > $attributes_column_size): ?>
                                            <div class="full-specifications">
                                                <ul>
                                                    <?php
                                                    $count = 0;
                                                    foreach ($attributes as $label => $attributeArr):
                                                        if ($count >= $attributes_count_more) continue;
                                                        ?>
                                                        <li>
                                                            <h3 class="specifications-title"><?= $label; ?>:</h3>
                                                            <?php foreach ($attributeArr as $attribute): ?>
                                                                <p class="specifications-value"><?= $attribute; ?></p>
                                                            <?php endforeach; ?>
                                                        </li>
                                                        <?php unset($attributes[$label]);
                                                        $count++; endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="col-md-4">
                                <?php if (!empty($vc_icon)): ?>
                                    <div class="feature">
                                        <img src="<?= get_template_directory_uri(); ?>/images/product/f1.png" alt="f1">
                                        <div class="title"><?php pll_e("VC (компенсация вибраций)"); ?></div>
                                        <div class="text">
                                            <?php pll_e("Стабилизатор изображения VC обеспечивает резкое изображение без дрожания, а также обеспечивает резкое изображение в видоискателе."); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($usd_icon)): ?>
                                    <div class="feature">
                                        <img src="<?= get_template_directory_uri(); ?>/images/product/f2.png" alt="f2">
                                        <div class="title"><?php pll_e("USD (ультразвуковой мотор)"); ?></div>
                                        <div class="text">
                                            <?php pll_e("Мощный ультразвуковой двигатель для съемки быстрых и динамичных объектов. Чрезвычайно тихий и точный, позволяет осуществлять ручное управление фокусировкой во время съемки."); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="full-features">
                                    <?php if (!empty($eband_icon)): ?>
                                        <div class="feature">
                                            <img src="<?= get_template_directory_uri(); ?>/images/product/f3.png" alt="f3">
                                            <div class="title"><?php pll_e("Покрытие eBAND"); ?></div>
                                            <div class="text">
                                                <?php pll_e("Нано - антибликовое покрытие для защиты от нежелательных отражений и ореола."); ?>
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
                                        <!--                                        <h3>-->
                                        <!--                                            Профото является эксклюзивным представителем в Украине известного мирового-->
                                        <!--                                            производителя компании Tamron.-->
                                        <!--                                        </h3>-->
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
                                                     alt="<?= get_sub_field('text') ?>"
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
                            <?php
                            parse_str(parse_url($youtube, PHP_URL_QUERY), $youtubeArray);
                            $videoId = $youtubeArray['v'];
                            ?>
                            <div class="video">
                                <div class="container">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-12">
                                            <h2><?php the_title(); ?></h2>
                                            <iframe width="100%" height="600px"
                                                    style="max-height: 60vh;"
                                                    src="https://www.youtube.com/embed/<?= $videoId; ?>?rel=0&amp;controls=1&amp;showinfo=0"
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
                                                        alt="icon_pdf"
                                                        src="<?= get_template_directory_uri(); ?>/images/icon_pdf.png">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ut enim ad minim veniam</td>
                                            <td class="text-center">En</td>
                                            <td class="text-center"><img
                                                        alt="icon_windows"
                                                        src="<?= get_template_directory_uri(); ?>/images/icon_windows.png">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sed quia consequuntur</td>
                                            <td class="text-center">Ru</td>
                                            <td class="text-center"><img
                                                        alt="icon_apple"
                                                        src="<?= get_template_directory_uri(); ?>/images/icon_apple.png">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Neque porro quisquam est</td>
                                            <td class="text-center">En</td>
                                            <td class="text-center"><img
                                                        alt="icon_linux"
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
                            <div class="col-md-10">
                                <?php
                                // If comments are open or we have at least one comment, load up the comment template.
                                if (comments_open() || get_comments_number()) :
                                    comments_template();
                                endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <br>
                                <br>
                                <h3><?php pll_e("Похожие товары"); ?></h3>
                            </div>
                            <div class="col-md-12">
                                <div class="products-table-catalog">
                                    <div class="row">
                                        <?php foreach (wc_get_related_products($post->ID, 3) as $related_product): ?>
                                            <?php
                                            $productWC = wc_get_product($related_product);
                                            $skuWC = $product->get_sku();
                                            ?>
                                            <div class="col-sm-12 col-md-6 col-xl-4 product">
                                                <a class="link" href="<?= get_the_permalink($related_product); ?>">
                                                    <div class="image-wrapper text-center transition-3s">
                                                        <?php
                                                        $related_image_url = get_the_post_thumbnail_url($related_product);
                                                        if (!empty($related_image_url)):?>
                                                            <img src="<?= $related_image_url; ?>" alt="<?= get_the_title($related_product); ?>">
                                                        <?php else: ?>
                                                            <img src="<?= wc_placeholder_img_src(); ?>" alt="<?= get_the_title($related_product); ?>">
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
                                                            <a class="transition-3s like-btn tinvwl_add_to_wishlist_button"
                                                               role="button"
                                                               aria-label="Add to Wishlist"
                                                               data-tinv-wl-list="[]"
                                                               data-tinv-wl-product="<?= $related_product; ?>"
                                                               data-tinv-wl-productvariation="0"
                                                               data-tinv-wl-productvariations="[0]"
                                                               data-tinv-wl-producttype="simple"
                                                               data-tinv-wl-action="add">
                                                                <i class="far fa-heart"></i>
                                                            </a>
                                                            <button data-id="<?= $related_product; ?>"
                                                                    class="transition-3s compare-btn br_compare_button br_product_<?= $related_product; ?> <?= set_class_compare($related_product); ?>">
                                                                <i class="fas fa-balance-scale"></i>
                                                            </button>
                                                            <button class="transition-3s buy-btn"
                                                                    data-sku="<?= $skuWC; ?>"
                                                                    data-id="<?= $related_product; ?>">
                                                                <i class="fas fa-cart-plus icon"></i> <?php pll_e("Купить"); ?>
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
<?= get_template_part('template-parts/components-subscription', 'form'); ?>

<script type="text/javascript">
    window.addEventListener('load', function () {
        if ($("body").width() > 575) {
            setProductsSimilarHeight(".products-table-catalog .product");
        }
    })
</script>

<?php get_footer(); ?>
