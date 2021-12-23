<?php
/* Template Name: Product New */

get_header();
the_post();
?>

<section class="catalog-way">
    <div class="container no-pad">
        <div class="content-wrapper d-flex justify-content-between">
            <div class="way-name d-flex flex-column justify-content-center">
                <h1>
                    <?php the_title();?>
                </h1>
            </div>
            <div class="image d-flex flex-column justify-content-center">
                <?php if (!empty(get_the_post_thumbnail_url())): ?>
                    <img src="<?= get_the_post_thumbnail_url(); ?>" width="100%" height="100%" alt="<?php the_title();?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section id="product_new_vue" class="products-table-catalog">
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
                            <i class="fas fa-cart-plus icon"></i> <?php pll_e("Купить"); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button v-if="total_pages > page && products.length" class="view-more-btn transition-3s" @click="loadMore">
                    <?php pll_e("Загрузить еще"); ?> (9)
                </button>
            </div>
        </div>
    </div>
</section>

<?php get_footer();?>
