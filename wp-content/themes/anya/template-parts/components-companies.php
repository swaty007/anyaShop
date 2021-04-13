<section class="company-list">
    <div class="container">
        <div class="title text-center"><?php pll_e("Компании, в которых работают наши выпускники");?></div>
        <div class="company-list__wrap">
            <?php $loop = new WP_Query( array(
                    'post_type' => 'partners',
                    'posts_per_page' => -1,
                )
            ); ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post();?>
                <a href="<?= get_post_meta($post->ID, 'href', true);?>" target="_blank" rel="noreferrer noopener nofollow" class="company">
                    <img src="<?php the_post_thumbnail_url(); ?>" />
                </a>
            <?php endwhile; wp_reset_query(); ?>
        </div>
    </div>
</section>
