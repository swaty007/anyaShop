<?php


get_header();
global $wp_query;
//the_post();
?>

<section class="search">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="title__md mb-2">
                    <?php pll_e("Результаты поиска по запросу");?>
                    <span class="text__red"> “<?php printf(get_search_query());?>”</span>
                </h1>
                <p class="search__desc">
                    <span class="text__red"><?= $wp_query->found_posts;?></span> <?php pll_e("products");?>
                </p>
            </div>
        </div>

            <?php
            if ( function_exists( 'relevanssi_didyoumean' ) ) {
                relevanssi_didyoumean( get_search_query(), '<p>Did you mean: ', '</p>', 5 );
            }
            if (have_posts()):?>
        <div class="row no-gutters row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                <?php
                while(have_posts()): the_post();?>
                    <div class="col">
                        <a href="<?php the_permalink();?>" class="lots__item">
                            <button class="lots__item--favorite" data-id="<?=$post->ID;?>"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="<?= pll__("Add to favourites");?>"
                                    title2="<?= pll__("Remove from favorites");?>">
                            </button>
                            <img src="<?php the_post_thumbnail_url() ?>" />
                            <div>
                                <h4 class="lots__item--title">
                                    <?php the_title(); ?>
                                </h4>
                                <div class="lots__item--desc">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile;wp_reset_query();?>
        </div>
            <div class="row">
                <div class="col">
                    <div class="pagination">
                        <?php the_posts_pagination([
                            'prev_text' => '&lsaquo;',//&laquo;
                            'next_text' => '&rsaquo;'//&raquo;
                        ]); ?>
                    </div>
                </div>
            </div>

                <?php else: ?>
                <div class="row">
                    <div class="col">
                        <h2 class="title__xm mb-2"><?php pll_e("По вашему запросу ничего не найдено");?></h2>
                        <div class="search__desc"><?php pll_e("К сожалению, по вашему запросу не найдено подходящих продуктов.");?></div>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>
</section>



<?php
set_query_var('featured-products', 'my_var_value');
get_template_part('template-parts/sections', 'featured-products'); ?>

<?php
get_footer();
