<?php
global $wp_query;
$term = get_queried_object();
$term_id = empty($term->term_id) ? NULL : $term->term_id;
$term_image_url = wp_get_attachment_url(get_term_meta($term_id, 'thumbnail_id', true));
$parents = [];
if (!empty($term->parent)) {
    $parentI = get_term($term->parent);
    $parents[] = $parentI;
    while ($parentI->parent !== 0) {
        $parentI = get_term($parentI->parent);
        array_unshift($parents, $parentI);
    }
}

$child_categories = get_terms('product_cat', [
    'hide_empty' => true,
    'parent' => $term_id,
]);
?>
    <section class="catalog-way">
        <div class="container no-pad">
            <div class="content-wrapper d-flex justify-content-between">
                <div class="way-name d-flex flex-column justify-content-center">
                    <?php if (empty($parents)): ?>
                        <h1>
                            <?= pll__($term->name); ?>
                        </h1>
                    <?php else: ?>
                        <?php foreach ($parents as $ip => $parent): ?>
                            <? if ($ip === 0): ?>
                                <a href="<?= get_term_link($parent->term_id); ?>">
                                    <h1>
                                        <?= $parent->name; ?>
                                    </h1>
                                </a>
                            <?php else: ?>
                                <a href="<?= get_term_link($parent->term_id); ?>">
                                    <h3><?= $parent->name; ?></h3>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <h3><?= $term->name; ?></h3>
                    <?php endif; ?>


                </div>
                <div class="image d-flex flex-column justify-content-center">
                    <?php if (!empty($term_image_url)): ?>
                        <img src="<?= $term_image_url; ?>" width="100%" height="100%" alt="<?= $term->name; ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php if (!empty($child_categories)): ?>
    <section class="tabs image-tabs">
        <div class="container content-container">
            <div class="row tabs-wrapper d-flex flex-nowrap">
                <?php
                foreach ($child_categories as $child_category):?>
                    <?php $child_term_image_url = wp_get_attachment_url(get_term_meta($child_category->term_id, 'thumbnail_id', true)); ?>
                    <a class="d-flex align-items-center justify-content-center transition-3s tab active"
                       href="<?= get_term_link($child_category->term_id); ?>">
                        <div>
                            <?php if (!empty($child_term_image_url)): ?>
                                <img src="<?= $child_term_image_url; ?>" class="category__img" alt="<?= $child_category->name; ?>"/>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?= $child_category->name; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
    <section class="catalog-filters-menu">
        <div class="container content-container filters-menu no-pad d-flex align-items-center justify-content-between desktop">
            <div class="d-flex align-items-center">
<!--                <div class="currency-checker">-->
<!--                    <span class="currency usd active">USD</span>-->
<!--                    <span class="line"></span>-->
<!--                    <span class="currency uah">UAH</span>-->
<!--                </div>-->
                <button class="transition-3s filters-btn"><?php pll_e("??????????????");?> <i class="material-icons">keyboard_arrow_down</i>
                </button>
                <span class="products-count"><?= $wp_query->found_posts; ?> <?php pll_e("??????????????");?></span>
            </div>
            <div class="d-flex align-items-center">
<!--                <button class="transition-3s compare-btn">????????????????</button>-->
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>
        <div class="container content-container filters-menu no-pad mobile">
            <div class="products-count"><?= $wp_query->found_posts; ?> <?php pll_e("??????????????");?></div>
            <div>
<!--                <button class="transition-3s compare-btn">????????????????</button>-->
            </div>
            <div>
                <?php woocommerce_catalog_ordering(); ?>
            </div>
            <div>
                <button class="transition-3s filters-btn"><?php pll_e("??????????????");?> <i class="material-icons">keyboard_arrow_down</i>
                </button>
            </div>
        </div>
    </section>
    <section class="catalog-filters-content">
        <div class="container content-container filters-content no-pad">
            <div class="filters">
<!--                <div class="filter-wrapper">-->
<!--                    <div class="title">??????????????????</div>-->
<!--                    <div class="transition-2s block">Nikon</div>-->
<!--                    <div class="transition-2s block">Canon</div>-->
<!--                    <div class="transition-2s block">Sony</div>-->
<!--                    <div class="transition-2s block">Pentax</div>-->
<!--                </div>-->
                <div class="filter-wrapper">
                    <?= do_shortcode('[woof]');?>
<!--                    <div class="title">??????????????????????????</div>-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <div class="checker">-->
<!--                                <div class="checkbox transition-2s"><i class="material-icons transition-2s">done</i>-->
<!--                                </div>-->
<!--                                <div class="label">Tamron</div>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    </ul>-->
                </div>
                <div class="filter-wrapper">
                    <form method="get">
                    <div class="title"><?php pll_e("????????");?></div>
                    <div class="range-slider">
                        <input type="text" class="js-range-slider" value=""/>
                    </div>
                    <div class="price-slider extra-controls form-inline">
                        <?php $prices = get_filtered_price();?>
                        <div class="form-group">
                            <input type="text" class="js-input-from form-control" name="min_price"
                                   value="<?=$prices['min'];?>" data-val="<?= !empty($_GET['min_price']) ? $_GET['min_price'] : "";?>"/>
                            <input type="text" class="js-input-to form-control" name="max_price"
                                   value="<?=$prices['max'];?>" data-val="<?= !empty($_GET['max_price']) ? $_GET['max_price'] : "";?>"/>
                        </div>
                    </div>

<!--                    <div class="price-block-wrapper">-->
<!--                        <div class="transition-2s block price-block">$100-$250</div>-->
<!--                        <div class="transition-2s block price-block">$250-$400</div>-->
<!--                        <div class="transition-2s block price-block">$400-$650</div>-->
<!--                    </div>-->
<!--                    <div class="price-block-wrapper">-->
<!--                        <div class="transition-2s block price-block">$650-$900</div>-->
<!--                        <div class="transition-2s block price-block">$900-$1200</div>-->
<!--                        <div class="transition-2s block price-block">$1200+</div>-->
<!--                    </div>-->
                        <button type="submit" class="main__btn"><?php pll_e("??????????????????????");?></button>
                        <?php foreach($_GET as $get_key => $get):
                            if (in_array($get_key, ['min_price', 'max_price'])) continue;?>
                            <input type="hidden" name="<?=$get_key;?>" value="<?=$get;?>">
                        <?php endforeach;?>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <section class="products-table-catalog">
        <div class="container content-container">
            <div class="row">
                <?php while (have_posts()): the_post(); ?>
                    <?php
                    $product = wc_get_product($post->ID);
                    if (!$product) continue;
                    $sku = $product->get_sku();
                    ?>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4 product">
                        <a href="<?php the_permalink(); ?>" class="link">
                            <div class="image-wrapper text-center transition-3s">
                                <?= woocommerce_get_product_thumbnail('full'); ?>
                            </div>
                        </a>
                        <div class="info">
                            <a href="<?php the_permalink(); ?>">
                                <div class="title"><?php the_title(); ?></div>
                            </a>

                            <div class="advantages">
<!--                                --><?php //wc_display_product_attributes($product); ?>
                            </div>
                            <div class="price">
                                <?= $product->get_price_html(); ?>
                            </div>
                            <div class="buttons">
                                <!-- <a href="#" class="transition-3s"><i class="far fa-eye"></i></a> -->
                                <a class="transition-3s like-btn tinvwl_add_to_wishlist_button"
                                        role="button"
                                        aria-label="Add to Wishlist"
                                        data-tinv-wl-list="[]"
                                        data-tinv-wl-product="<?=$post->ID;?>"
                                        data-tinv-wl-productvariation="0"
                                        data-tinv-wl-productvariations="[0]"
                                        data-tinv-wl-producttype="simple"
                                        data-tinv-wl-action="add">
                                    <i class="far fa-heart"></i>
                                </a>
                                <button data-id="<?= $post->ID; ?>"
                                        class="transition-3s compare-btn br_compare_button br_product_<?= $post->ID; ?> <?= set_class_compare($post->ID); ?>">
                                    <i class="fas fa-balance-scale"></i>
                                </button>
                                <button class="transition-3s buy-btn"
                                        data-sku="<?= $sku; ?>"
                                        data-id="<?= $post->ID; ?>">
                                    <i class="fas fa-cart-plus icon"></i> <?php pll_e("????????????");?>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php the_posts_pagination([
                        'prev_text' => '&lsaquo;',//&laquo;
                        'next_text' => '&rsaquo;'//&raquo;
                    ]); ?>
<!--                    <button class="view-more-btn transition-3s">?????????????????? ?????? (9)</button>-->
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener('load', function () {
            if ($("body").width() > 575) {
                setProductsSimilarHeight(".products-table-catalog .product");
            }
            $(".filters-btn").click(function (e) {
                if ($(".catalog-filters-content .filters").is(":hidden")) {
                    $(".catalog-filters-content .filters").slideDown();
                    $(".filters-btn .material-icons").text('keyboard_arrow_up');
                } else {
                    $(".catalog-filters-content .filters").slideUp();
                    $(".filters-btn .material-icons").text('keyboard_arrow_down');
                }
            });
        })
    </script>