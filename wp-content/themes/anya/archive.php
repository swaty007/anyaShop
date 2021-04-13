<?php
get_header();
?>


<div class="page blog__page blog__page--theme template--light">
    <div class="blog__block blog__block--wide">
        <div class="container blog__container">
            <div class="blog__main">
                <img class="blog__main-photo" src="<?= get_template_directory_uri(); ?>/img/theme.png" />
                <div class="blog__main-dark"></div>
                <div class="blog__main-content">
                    <img class="blog__main-icon-photo" src="<?= get_template_directory_uri(); ?>/img/icons/category.svg" />
                    <div class="desc desc--sm text--white text-medium">
                        <?php pll_e("Что нового в");?>
                    </div>
                    <div class="icon-title icon-title--hashtag icon-title--nobg blog__main-icon-title">
                        <?php single_cat_title();?>
<!--                        --><?php //the_archive_title();?>
                    </div>
                    <div class="desc desc--sm text--white text-medium desc--center blog__main-desc">
                        <?php pll_e("В этой рубрике мы рассматриваем способы влиться в IT-сферу с минимальным опытом и чуствовать себя в ней как рыба в воде");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container page__container blog__container">
        <div class="page__content ">
            <div class="blog__block">

                <?php
                while(have_posts()): the_post();?>
                    <div class="paper paper--sm">
                        <div class="paper__image">
                            <?php //the_post_thumbnail(); ?>
                            <img class="paper__image-photo" src="<?php the_post_thumbnail_url();?>" />
                            <?php $terms = wp_get_post_terms($post->ID); ?>
                            <?php if (!empty($terms)):?>
                                <div class="icon-title icon-title--white icon-title--hashtag paper__image-icon-title">
                                    <?=$terms[0]->name?>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="paper__body">
                            <a href="<?php the_permalink();?>" class="title text-bold paper__title"><?php the_title(); ?></a>
                            <div class="desc desc--sm paper__desc hidemobile"><?php the_excerpt(); ?></div>
                            <div class="desc desc--xs paper__time">
                                <div class="paper__time--date">
                                    <img src="<?= get_template_directory_uri(); ?>/img/icons/date.svg"/>
                                    <?php the_modified_time('F jS, Y'); ?>
                                </div>
                                <div class="paper__time--views">
                                    <img src="<?= get_template_directory_uri(); ?>/img/icons/eye.svg"/>
                                    <?= get_post_meta($post->ID, '_pageviews', true) ;?>
                                    <?php pll_e("просмотров");?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; the_posts_pagination([
                    'prev_text' => '&lsaquo;',//&laquo;
                    'next_text' => '&rsaquo;'//&raquo;
                ]); ?>
            </div>
        </div>
        <div class="sidebar page__sidebar blog__sidebar blog__sidebar--theme">
            <div class="blog__block">
                <div class="blog__block-top blog__block-top--popular">
                    <div class="icon-title"><?php pll_e("популярное в рубрике");?></div>
                </div>
                <?php $loop = new WP_Query( array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'cat' => get_the_category()[0]->cat_ID
//                        'meta_query' => [
//                            'AND',
//                            [
//                                'key' => 'favorite',
//                                'value'	  	=>  true,
//                                'compare' 	=> '=',
//                            ]
//                        ],
                    )
                ); ?>
                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <a href="<?php the_permalink();?>" class="blog__card blog__card--popular">
                        <div class="blog__card-body">
                            <div class="title text-bold"><?php the_title(); ?></div>
                            <div class="desc desc--xs blog__card-desc"><?php the_modified_time('F jS, Y'); ?></div>
                        </div>
                    </a>
                  <a href="<?php the_permalink();?>" class="blog__card blog__card--popular">
                    <div class="blog__card-body">
                      <div class="title text-bold"><?php the_title(); ?></div>
                      <div class="desc desc--xs blog__card-desc"><?php the_modified_time('F jS, Y'); ?></div>
                    </div>
                  </a>
                <?php endwhile; wp_reset_query(); ?>
            </div>

            <?php dynamic_sidebar( 'category_sidebar' ); ?>

        </div>
    </div>
</div>




<?php get_footer();
?>
