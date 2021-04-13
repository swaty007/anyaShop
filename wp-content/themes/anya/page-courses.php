<?php
/* Template Name: Все курсы */

get_header();
the_post();
?>

<?php
$courses_terms = get_terms([
    'taxonomy' => 'courses_category',
    'parent' => 0,
]);
?>

    <section class="card-list card-list--courses">
        <div class="container card-list__container">
            <h1 class="title title-md text-center">
                <?php the_title(); ?>
            </h1>
            <button id="filter_open" class="btn btn-nobg card-list--mob card-list__btn" ><?php pll_e("Фильтры");?></button>
            <div class="card-list__wrap card-list__wrap--courses">
                    <div id="card-filter" class="card-filter">
                        <div class="card-filter__container">
                            <div class="title title-md text-center card-list--tab card-filter__container-title"><?php the_title(); ?></div>
                            <div class="card-filter__title text-bold">
                                <?php pll_e("Уровень сложности");?>
                            </div>
                            <label for="courses_newbie" class="default-checkbox card-filter__checkbox">
                                <input id="courses_newbie" type="checkbox" class="default-checkbox__check">
                                <span class="default-checkbox__title"><?php pll_e("Для новичков");?></span>
                            </label>
                            <label for="courses_advanced" class="default-checkbox card-filter__checkbox">
                                <input id="courses_advanced" type="checkbox" class="default-checkbox__check">
                                <span class="default-checkbox__title"><?php pll_e("Для продвинутых");?></span>
                            </label>
                            <div id="courses_filter" class="card-filter__block">
                                <div class="card-filter__item active" data-id="all" data-slug="all"><?php pll_e("Все курсы");?></div>
                                <?php foreach ($courses_terms as $term): ?>
                                    <div class="card-filter__item"
                                         data-id="<?= $term->term_id; ?>"
                                         data-slug="<?= $term->slug; ?>">
                                        <?= $term->name; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button id="filter_close" class="btn card-filter__btn"><?php pll_e("Применить");?></button>
                            <button id="filter_close" class="btn btn-nobg card-filter__btn card-filter__btn--down"><?php pll_e("Закрыть");?></button>

                        </div>
                         </div>

                <div id="courses_wrap" class="card-wrap">
                    <?php
                    $loop = new WP_Query(array('post_type' => 'courses', 'posts_per_page' => -1)); ?>
                    <?php while ($loop->have_posts()) : $loop->the_post();
                        set_query_var('course_id', $post->ID);
                        ?>
                        <?php get_template_part('template-parts/components', 'course-card'); ?>
                    <?php endwhile;
                    wp_reset_query(); ?>

                </div>
            </div>
        </div>
    </section>
                                    
<?php
get_footer();
