<?php
/* Template Name: Все вебинары */
$loop = new WP_Query(array('post_type' => 'webinars', 'posts_per_page' => -1));
if (!$loop->found_posts) {
//    include('404.php');
//    exit();
}

get_header();
the_post();
?>



    <section class="card-list card-list--page card-list--courses">
        <div class="container card-list__container">
            <h1 class="title title-md text-center card-list__title-md">
                <?php the_title();?>
            </h1>
            <?php if (!$loop->found_posts):?>
                <div class="fourth-title text-bold text-center"><?php pll_e("Мы готовим что-то интересное для тебя.");?></div>
                <div class="sixth-title page__subtitle text-center"><?php pll_e("Немного терпения :)");?></div>
                <div class="text-center">
                    <a href="<?= pll_home_url();?>" class="btn"><?php pll_e("Вернуться на главную");?></a>
                </div>
            <?php else:?>
            <?php while ($loop->have_posts()) : $loop->the_post();?>
                <?php set_query_var('webinar_id', $post->ID); ?>
                <?php get_template_part('template-parts/components', 'webinar-card'); ?>
            <?php endwhile;
            wp_reset_query(); ?>
            <?php endif;?>
        </div>
    </section>


<?php
get_footer();
