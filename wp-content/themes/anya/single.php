<?php
 get_header();
the_post(); ?>
<section class="article">
    <div class="container">
        <h1 class="title__xl mb-5">
            <?php the_title() ?>
        </h1>
        <img class="article__photo mb-4" src="<?php the_post_thumbnail_url();?>" />
        <div class="article__html wordpress__content">
            <?php the_content();?>
        </div>
        <div class="article__comments">
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
//                comments_template();
            endif; ?>
        </div>
        <h3 class="title__sm mb-2">
            <?php pll_e("Other articles"); ?>
        </h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
        <?php $count = 0;$loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 4, 'post__not_in' => [$post->ID] ) ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="col blog__item">
                <?php //the_modified_time('F jS, Y'); ?>
                <a class="block__item--link" href="<?php the_permalink(); ?>">
                    <img src="<?php the_post_thumbnail_url(); ?>" class="blog__item--img">
                    <h4 class="title__xm">
                        <?php the_title(); ?>
                    </h4>
                </a>
            </div>
            <?php $count++;endwhile; wp_reset_query(); ?>
        </div>
        <div class="text-right">
            <div class="blog__more title__xm">
<!--                <a href="<?//= get_permalink( get_option( 'page_for_posts' )) ;?>" class="blog__more--btn">-->
                <a href="<?= get_post_type_archive_link( 'post' ) ;?>" class="blog__more--btn">
                    <?php pll_e("All articles"); ?>
                </a>
            </div>
        </div>
    </div>
</section>
  <?php get_footer(); ?>
